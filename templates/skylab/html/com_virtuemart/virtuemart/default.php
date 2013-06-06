<?php
/**
*
* Description
*
* @package	VirtueMart
* @subpackage
* @author
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: default.php 6461 2012-09-16 21:49:03Z Milbo $
*/
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
JHTML::_( 'behavior.modal' );
require_once JPATH_SITE.DS.'templates'.DS.'skylab'.DS.'tools2.php';
$js = "
jQuery(document).ready(function () {
	jQuery('.orderlistcontainer').hover(
		function() { jQuery(this).find('.orderlist').stop().show()},
		function() { jQuery(this).find('.orderlist').stop().hide()}
	)
});
document.addEvent('domready',function() {
	var div=new Element('div',{
		'id':'product_details',
		'class':'product_details'
	});
	document.getElementsByTagName('body')[0].appendChild(div);
	div.setStyle('display','none');
});
function show_detail(url) {
	new Request.HTML({
		'url':url,
		'method':'post',
		'data':'type=raw',
		'onSuccess':function(tree,elements,html,js) {
			var close_details=function() {
				document.id('product_details').setStyle('display','none');
				document.id('main').removeEvent('click',close_details);
			}
			document.id('main').addEvent('click',close_details);
			document.id('product_details').set('html',html);
			document.id('product_details').position();
			jQuery('#product_details').css('position', 'fixed');
			var close_btn=new Element('div',{
				'class':'close_detail'
			});
			document.id('product_details').grab(close_btn,'top');
			close_btn.addEvent('click',close_details);			
			document.id('product_details').setStyle('display','');
			ymaps.ready(init);
			var myMap, myPlacemark1, myPlacemark2, myPlacemark3, myPlacemark4, myPlacemark5;
			function init(){     
			}
			SqueezeBox.initialize({});
                        SqueezeBox.assign($$('a.modal'), {
				parse: 'rel'
                        });
			TabbedContent.init();
			Virtuemart.product(jQuery('.product'));
			document.id('addtocart_details').addEvent('click',close_details);
		}
	}).send();
}
";
$document = JFactory::getDocument();
$document->addScriptDeclaration($js);
?>

<?php # Vendor Store Description
if (!empty($this->vendor->vendor_store_desc) and VmConfig::get('show_store_desc', 1)) { ?>
<p class="vendor-store-desc">
	<?php echo $this->vendor->vendor_store_desc; ?>
</p>
<?php } ?>

<?php
# load categories from front_categories if exist
if ($this->categories and VmConfig::get('show_categories', 1)) echo $this->loadTemplate('categories');

# Show template for : topten,Featured, Latest Products if selected in config BE
if (!empty($this->products) ) { ?>
	<?php echo $this->loadTemplate('products');
}

?>