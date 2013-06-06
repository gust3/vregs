<?php 
defined('_JEXEC') or die();
 
class TableNetproducts extends JTable
{
        var $id = null;
        var $id_net = null;
        var $id_product = null;
		var $price = null;
        var $published = 1;
		
        function __construct(&$db)
        {
                parent::__construct( '#__vmtools_nets_products', 'id', $db );
        }
}
?>