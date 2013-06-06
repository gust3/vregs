<?php 
defined('_JEXEC') or die();
 
class TableOtziv extends JTable
{
        var $id = null;
        var $product_id = null;
        var $reiting = null;
        var $plusy = null;
        var $minusy = null;
        var $comment = null;
		var $user = null;
		var $published = 1;
		var $date = null;
		var $parent = 0;
		var $premoderation = 0;
        function __construct(&$db)
        {
                parent::__construct( '#__vmtools_products_otzivi', 'id', $db );
        }
}
?>