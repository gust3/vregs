<?php
 defined('_JEXEC') or die('Restricted access');
class TableProducts extends JTable
{
 var $id = 0;
 var $model = '';
 var $proiz = '';
 var $img = '';
 var $properties_value = '';
 var $price = 0;
 var $link_to_product = '';
 var $desc = '';
function __construct(&$db)
	{
		parent::__construct( '#__toolsvmproducts', 'id', $db );
	}
 }
 ?>