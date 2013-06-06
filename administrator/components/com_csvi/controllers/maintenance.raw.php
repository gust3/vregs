<?php
/**
 * Matintenance controller
 *
 * @package 	CSVI
 * @author 		Roland Dalmulder
 * @link 		http://www.csvimproved.com
 * @copyright 	Copyright (C) 2006 - 2012 RolandD Cyber Produksi
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: maintenance.raw.php 1891 2012-02-11 10:43:52Z RolandD $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport('joomla.application.component.controllerform');

/**
 * Maintenance Controller
 *
 * @package    CSVI
 */
class CsviControllerMaintenance extends JControllerForm {
	
	public function __construct() {
		parent::__construct();
		$this->registerTask('sortcategories', 'options');
		$this->registerTask('icecatsettings', 'options');
	}

	/**
	 * Load the ICEcat settings
	 *
	 * @copyright
	 * @author 		RolandD
	 * @todo
	 * @see
	 * @access 		public
	 * @param
	 * @return
	 * @since 		3.0
	 */
	public function options() {
		// Create the view object
		$view = $this->getView('maintenance', 'raw');

		// Load the model
		$view->setModel($this->getModel('maintenance', 'CsviModel'), true);

		// Now display the view
		$view->display();
	}
	
	/**
	 * Load the operations 
	 * 
	 * @copyright 
	 * @author 		RolandD
	 * @todo 
	 * @see 
	 * @access 		public
	 * @param 
	 * @return 
	 * @since 		4.0
	 */
	public function operations() {
		$model = $this->getModel();
		$options = $model->getOperations();
		echo $options;
	}
	
	
}
?>
