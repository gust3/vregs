<?php 
defined('_JEXEC') or die();
 
class TableRegion extends JTable
{
        var $id = null;
        var $id_region = null;
        var $label = null;
        var $sctx = null;
		var $x = null;
        var $y = null;
        function __construct(&$db)
        {
            parent::__construct( '#__vmtools_regions', 'id', $db );
        }
}
?>