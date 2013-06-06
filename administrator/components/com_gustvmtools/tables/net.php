<?php 
defined('_JEXEC') or die();
 
class TableNet extends JTable
{
        var $id = null;
        var $ymname = null;
        var $label = null;
        var $email = null;
        var $phone = null;
        var $published = 1;
		var $url = null;
		var $dostavka = null;
        function __construct(&$db)
        {
                parent::__construct( '#__vmtools_netshop', 'id', $db );
        }
}
?>