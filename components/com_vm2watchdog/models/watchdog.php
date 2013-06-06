<?php
/*
 * Created on Apr 30, 2012
 *
 * Author: Linelab.org
 * Project: wdog
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modelform');

class VM2WatchDogModelWatchDog extends JModelForm {
	function getForm($data=array(),$load=true) {
		$form=$this->loadForm('com_vm2watchdog.watchdog','watchdog',array('control'=>'jform','load_data'=>true));
		//echo "<pre>";print_r($form);exit;
		if(empty($form)) {
			return false;
		}
		return $form;
	}
	
	function loadFormData() {
		$data=JFactory::getApplication()->getUserState('com_watchdog.watchdog.data',array());
		if(!isset($data["email"])) {
			$data["email"]=JFactory::getUser()->get('email');
		}
		if(!isset($data["virtuemart_product_id"])) {
			$data["virtuemart_product_id"]=JRequest::getint('virtuemart_product_id');
		}
		return $data;
	}
	
	function getItem($key=null) {
		$query=$this->_db->getQuery(true);
		$query->select('product_name');
		$query->from('#__virtuemart_products_'.strtolower(str_replace('-','_',JFactory::getLanguage()->getTag())));
		$query->where('virtuemart_product_id='.JRequest::getInt('virtuemart_product_id'));
		$this->_db->setQuery($query);
		return $this->_db->loadResult();
	}
	
	function save() {
		$jform=JRequest::getVar('jform',array(),'post','array');
		$form=$this->getForm();
		if(JFactory::getUser()->get('id')) {
			$form->removeField('captcha');
		}
		if($this->validate($form,$jform)===false) {
			JFactory::getApplication()->setUserState('com_watchdog.watchdog.data',$jform);
			return false;
		}
		
		$table=JTable::getInstance('Watches','VM2WatchDogTable',array());
		$table->bind($jform);
		if(!$table->store()) {
			$this->setError($this->_db->stderr(true));
			return false;
		}
		$this->_sendMail($table);
		return true;
	}
	
	function unsubscribe() {
		$query=$this->_db->getQuery(true);
		$query->delete('#__vm2wd_watches');
		$query->where('id='.JRequest::getInt('id'));
		$this->_db->setQUery($query);
		if(!$this->_db->query()) {
			$this->setError($this->_db->stderr(true));
			return false;
		}
		return true;
	}
	
	private function _sendMail($table) {
		$product_name=$this->getItem();
		$mail=JFactory::getMailer();
		$mail->setSender(array(JFactory::getApplication()->getCfg('mailfrom'),JFactory::getApplication()->getCfg('fromname')));
		$mail->addRecipient($table->email);
		$mail->setSubject(JText::sprintf('COM_VM2WATCHDOG_ACTIVATION'));
		$mail->setBody(JText::sprintf('COM_VM2WATCHDOG_ACTICATION_MSG',$product_name,$table->price,substr(JFactory::getUri()->base(),0,-1).JRoute::_('index.php?option=com_vm2watchdog&task=watchdog.unsubscribe&id='.$table->id)));
		$mail->send();
	}
}
?>