<?php
/**
 *
 * Controller for the templatetype editing
 *
 * @package 	Csvi
 * @author 		RolandD
 * @link 		http://www.csvimproved.com
 * @copyright 	Copyright (C) 2006 - 2012 RolandD Cyber Produksi
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: templatetype.php 1891 2012-02-11 10:43:52Z RolandD $
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the controller framework
jimport('joomla.application.component.controllerform');

/**
 * Controller for the template type editing
 *
 * @package Csvi
 * @author 	RolandD
 * @since 	4.0
 */
class CsviControllerTemplatetype extends JControllerForm {

	/**
	 * Proxy for getModel
	 *
	 * @copyright
	 * @author 		RolandD
	 * @todo
	 * @see
	 * @access 		public
	 * @param
	 * @return 		object of a database model
	 * @since 		4.0
	 */
	public function getModel($name = 'Templatetype', $prefix = 'CsviModel') {
		$model = parent::getModel($name, $prefix, array('ignore_request' => false));
		return $model;
	}


}
?>