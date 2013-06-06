<?php
/*
 * Created on Apr 30, 2012
 *
 * Author: Linelab.org
 * Project: wdog
 */

defined('_JEXEC') or die('Restricted access');

class VM2WatchDogTableWatches extends JTable {
	function __construct($db) {
		parent::__construct('#__vm2wd_watches','id',$db);
	}
}
?>