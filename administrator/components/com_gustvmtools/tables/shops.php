<?php
 defined('_JEXEC') or die('Restricted access');
 class TableToolsvmproducts extends JTable
 {
 var $id = 0;
 var $name = '';
 var $adress = '';
 var $phone = '';
 function __construct(&$db)
	{
		parent::__construct( '#__vmtools_shops', 'id', $db );
	}
 }
 ?>