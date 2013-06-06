<?php
/**
 * Template types controller
 *
 * @package 	CSVI
 * @author 		Roland Dalmulder
 * @link 		http://www.csvimproved.com
 * @copyright 	Copyright (C) 2006 - 2012 RolandD Cyber Produksi
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: templatetypes.json.php 1891 2012-02-11 10:43:52Z RolandD $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport('joomla.application.component.controller');

/**
 * About Controller
 *
 * @package    CSVIVirtueMart
 */
class CsviControllerTemplatetypes extends JController {

	public function loadTemplateTypes() {
		$jinput = JFactory::getApplication()->input;
		$model = $this->getModel('templatetypes');
		$action = $jinput->get('action');
		$component = $jinput->get('component');
		echo json_encode($model->loadTemplateTypes($action, $component));
	}

	public function loadSettings() {
		$jinput = JFactory::getApplication()->input;
		$model = $this->getModel('templatetypes');
		$action = $jinput->get('action');
		$component = $jinput->get('component');
		$operation = $jinput->get('operation');
		echo $model->loadSettings($action, $component, $operation);
	}
}
?>
