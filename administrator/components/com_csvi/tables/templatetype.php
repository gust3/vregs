<?php
/**
 * Template types table
 *
 * @package 	CSVI
 * @author 		Roland Dalmulder
 * @link 		http://www.csvimproved.com
 * @copyright 	Copyright (C) 2006 - 2012 RolandD Cyber Produksi
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: templatetype.php 1891 2012-02-11 10:43:52Z RolandD $
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

/**
* @package CSVI
 */
class TableTemplatetype extends JTable {

	/**
	* @param database A database connector object
	*/
	public function __construct($db) {
		parent::__construct('#__csvi_template_types', 'id', $db );
	}
}
?>