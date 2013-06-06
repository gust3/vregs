<?php
/**
 * Install view
 *
 * @package 	CSVI
 * @author 		Roland Dalmulder
 * @link 		http://www.csvimproved.com
 * @copyright 	Copyright (C) 2006 - 2012 RolandD Cyber Produksi
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: view.json.php 1891 2012-02-11 10:43:52Z RolandD $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport( 'joomla.application.component.view' );

/**
 * Install View
 *
* @package CSVI
 */
class CsviViewInstall extends JView {
	
	/**
	 * Handle the JSON requests 
	 * 
	 * @copyright 
	 * @author 		RolandD
	 * @todo 
	 * @see 
	 * @access 		public
	 * @param 
	 * @return 		string JSON encoded text
	 * @since 		3.0
	 */
	public function display($tpl = null) {
		// Get the task to perform
		$tasks = explode('.', JRequest::getVar('tasks'));
		$task = $tasks[0];
		unset($tasks[0]);
		
		// Perform the task
		$result = array();
		$result['results'] = $this->get($task);
		if (JRequest::getBool('cancelinstall')) {
			$result['tasks'] = '';
		}
		else {
			$result['results']['messages'][] = JText::_('COM_CSVI_COMPLETED_'.strtoupper($task));
			
			// Add remaining tasks to the result for further processing
			$result['tasks'] = implode('.', $tasks);
		}
		
		// Send back the result
		echo json_encode($result);
	}
}
?>