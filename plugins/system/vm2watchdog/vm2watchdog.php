<?php
/*
 * Created on Apr 30, 2012
 *
 * Author: Linelab.org
 * Project: wdog
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

class plgSystemVM2WatchDog extends JPlugin {
	private $_db=null;
	function __construct($config,$params) {
		parent::__construct($config,$params);
		$this->_db=JFactory::getDBO();
		JFactory::getLanguage()->load('com_vm2watchdog',JPATH_SITE);
	}
	
	function onAfterRoute() {
		if(JFactory::getApplication()->isSite()) {
			return;
		} 
		$data=JRequest::get('post');
		if(@$data['option']=='com_virtuemart' && @$data['controller']=='product' && @$data['task']=='apply') {
			$query=$this->_db->getQuery(true);
			$query->select('product_price');
			$query->from('#__virtuemart_product_prices');
			$query->where('virtuemart_product_id='.$data["virtuemart_product_id"]);
			$this->_db->setQuery($query);
			$price=$this->_db->loadResult();
			if($price==$data["product_price"]) {
				return true;
			}
			
			$query=$this->_db->getQuery(true);
			$query->select('email');
			$query->from('#__vm2wd_watches');
			$query->where('virtuemart_product_id='.$data["virtuemart_product_id"]);
			$query->where('price<'.$price);
			$query->where('price>'.$data['product_price']);
			$this->_db->setQuery($query);
			foreach($this->_db->loadResultArray() as $email) {
				$mail=JFactory::getMailer();
				$mail->setSender(array(JFactory::getApplication()->getCfg('mailfrom'),JFactory::getApplication()->getCfg('fromname')));
				$mail->addRecipient($email);
				$mail->setSubject(JText::sprintf('COM_VM2WATCHDOG_ALERT',JFactory::getApplication()->getCfg('sitename')));
				$mail->setBody(JText::sprintf('COM_VM2WATCHDOG_DISCOUNT',$data["product_name"],$data["product_price"]));
				$mail->Send();	
			}
		}		
	}
}
?>