<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_gustvmtools/assets/css/stylesheet.css');
// Подключаем библиотеку контроллера Joomla.
require_once( JPATH_COMPONENT.DS.'controller.php' );
 
if($controller = JRequest::getWord('controller')) {
	$path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
	if (file_exists($path)) {
		require_once $path;
	} else {
		$controller = '';
	}
}
// Create the controller
$classname	= 'gustVMtoolsController'.$controller;
$controller	= new $classname( );

// Perform the Request task
$controller->execute( JRequest::getVar( 'task' ) );

// Redirect if set by the controller
$controller->redirect();