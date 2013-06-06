<?php 
defined('_JEXEC') or die();
 
class TableNetadress extends JTable
{
        var $id = null;
        var $id_net = null;
        var $id_region = null;
        var $adress = null;
        var $clocks = null;
        var $published = 1;
		var $x = null;
		var $y = null;
		var $url = null;
		var $vidacha_zakazov = null;
		var $dostavka = null;
		var $oplata = null;
		var $label = null;
		var $email = null;
		var $phones = null;
        function __construct(&$db)
        {
                parent::__construct( '#__vmtools_shops_adresses', 'id', $db );
        }
}
?>