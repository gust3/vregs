<?php
/*
 * Created on Jan 14, 2012
 *
 * Author: Linelab.org
 * Project: tmpl_skylab_vm2
 */

defined('_JEXEC') or die('Restricted access');

require_once dirname(__FILE__).DS.'helper.php';

$helper=new VM2SearchHelper($params);

$fields=$helper->getFields();
$values=$helper->getValues();
if($params->get('show_manufacturers',1)) {
	$manufacturers=$helper->getManufacturers();
}
if($params->get('show_cart_fields',1)) {
	$catr_vars=$helper->getCartVariants();	
}
if($params->get('show_custom_fields',1)) {
	$cart_vars_values=$helper->getCartVartiantsValues();
}
$media_fields=$helper->getMediaFields();
$media_values=$helper->getMediaFieldsValues();
$prices=$helper->getPrices();

JFactory::getDocument()->addScript('//ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js');
JFactory::getDocument()->addScript('modules/mod_vm2_search/assets/selectToUISlider.jQuery.js');
JFactory::getDocument()->addStyleSheet('modules/mod_vm2_search/assets/ui.slider.extras.css');
JFactory::getDocument()->addStyleSheet('modules/mod_vm2_search/assets/redmond/jquery-ui-1.7.1.custom.css');
JFactory::getDocument()->addScriptDeclaration("jQuery(document).ready(function() {
		document.getElementById('priceslider').slide=null;
		jQuery('#price_from, #price_to').selectToUISlider().hide();
	});
");


require_once JModuleHelper::getLayoutPath('mod_vm2_search');

?>