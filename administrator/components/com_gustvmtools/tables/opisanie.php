<?php 
defined('_JEXEC') or die();
 
class TableOpisanie extends JTable
{
        var $id = null;
        var $product_id = null;
		var $text = null;
		var $published = 1;
		var $review = null;
        function __construct(&$db)
        {
                parent::__construct( '#__vmtools_opisanie', 'id', $db );
        }
}
?>