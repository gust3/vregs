<?php 
defined('_JEXEC') or die();
 
class TableVideo extends JTable
{
        var $id = null;
        var $product_id = null;
        var $url = null;
		var $comment = null;
        var $published = 1;
		function __construct(&$db)
        {
                parent::__construct( '#__vmtools_videos', 'id', $db );
        }
}
?>