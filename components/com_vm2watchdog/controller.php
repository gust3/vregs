<?php
/*
 * Created on Apr 30, 2012
 *
 * Author: Linelab.org
 * Project: wdog
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class VM2WatchDogController extends JController {
	function display($cachable=false,$urlparams=false) {
		JRequest::setVar('view',JRequest::getCmd('view','watchdog'));
		
		parent::display($cachable,$urlparams);
		return $this;
	}
}
?>