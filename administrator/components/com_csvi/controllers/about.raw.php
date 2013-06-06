<?php
/**
 * About controller
 *
 * @package 	CSVI
 * @author 		Roland Dalmulder
 * @link 		http://www.csvimproved.com
 * @copyright 	Copyright (C) 2006 - 2012 RolandD Cyber Produksi
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: about.raw.php 2035 2012-06-16 12:19:33Z RolandD $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport('joomla.application.component.controllerform');

/**
 * About Controller
 *
 * @package    CSVI
 */
class CsviControllerAbout extends JControllerForm {

	/**
	 * Version check
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
	public function createFolder() {
		$model = $this->getModel();
		echo json_encode($model->createFolder());
	}
}
?>
