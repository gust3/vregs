<?php
/*
 * Created on Apr 30, 2012
 *
 * Author: Linelab.org
 * Project: wdog
 */

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

$controller=JController::getInstance('VM2Watchdog');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();
?>