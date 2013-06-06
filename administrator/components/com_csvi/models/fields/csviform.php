<?php
/**
 * Form override class
 *
 * @package 	CSVI
 * @author 		Roland Dalmulder
 * @link 		http://www.csvimproved.com
 * @copyright 	Copyright (C) 2006 - 2012 RolandD Cyber Produksi
 * @license 	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @version 	$Id: csviform.php 1891 2012-02-11 10:43:52Z RolandD $
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

JFormHelper::loadFieldClass('list');

/**
 * Form override class
 *
 * @package CSVI
 */
abstract class JFormFieldCsviForm extends JFormFieldList {

	protected $type = 'CsviForm';

}
?>
