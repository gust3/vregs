<?php
/*
 * Created on Apr 30, 2012
 *
 * Author: Linelab.org
 * Project: wdog
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controllerform');

class VM2WatchDogControllerWatchDog extends JControllerForm {
	function getModel($name='WatchDog',$prefix='VM2WatchDogModel',$config=array()) {
		return parent::getMOdel($name,$prefix,$config);
	}
	
	function save() {
		$model=$this->getModel();
		if(!$model->save()) {
			$this->setRedirect(JRoute::_('index.php?option=com_vm2watchdog&view=watchdog&virtuemart_product_id='.JRequest::getInt('virtuemart_product_id').'&tmpl=component'),$model->getError(),'error');
		} else {
			$this->setRedirect(JRoute::_('index.php?option=com_vm2watchdog&view=confirm&tmpl=component'));
		}
		
	}
	
	function unsubscribe() {
		$model=$this->getMOdel();
		$err='';
		$msg=JText::_('COM_VM2WATCHDOG_SUCCESSFULLY_UNSUBSCRIBED');
		if(!$model->unsubscribe()) {
			$msg=$model->getError();
			$err='error';
		}
		$this->setRedirect('index.php',$msg,$err);
	}
}
?>