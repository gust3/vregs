<?php
/*
 * Created on Apr 30, 2012
 *
 * Author: Linelab.org
 * Project: wdog
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

class VM2WatchDogViewWatchDog extends JView {
	function display($tpl=null) {
		$this->item=$this->get('item');
		$this->form=$this->get('form');
		
		JHTML::_('behavior.framework');
		JHTML::_('behavior.formvalidation');
		
		parent::display($tpl);
	}
}
?>