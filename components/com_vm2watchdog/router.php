<?php
/*
 * Created on Apr 30, 2012
 *
 * Author: Linelab.org
 * Project: wdog
 */

defined('_JEXEC') or die('Restricted access');

function VM2WatchDogBuildRoute(&$query) {
	$segments=array();
	if(isset($query['view'])) {
		switch($query['view']) {
			case 'watchdog':
				$segments[]=$query['view'];
				unset($query['view']);
				break;
			case 'confirm';
				$segments[]=$query['view'];
				unset($query['view']);
				break;
		}
	}
	if(isset($query['task'])) {
		if($query['task']=='watchdog.unsubscribe') {
			$segments[]='unsubscribe';
			unset($query['task']);
		}
	}
	return $segments;
}

function VM2WatchDogParseRoute($segments) {
	$vars=array();
	switch($segments[0]) {
		case 'watchdog':
			$vars['view']='watchdog';
			break;
		case 'confirm':
			$vars['view']='confirm';
			break;
		case 'unsubscribe':
			$vars['task']='watchdog.unsubscribe';
			break;
	}
	return $vars;
}
?>