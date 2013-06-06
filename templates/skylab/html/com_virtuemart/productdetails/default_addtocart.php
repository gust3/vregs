<?php
/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers, Valerie Isaksen
 * @todo handle child products
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default_addtocart.php 6260 2012-07-12 07:42:04Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
$sr = explode(',', $_COOKIE['vm_sravnenie_value']);
?>
<div class="addtocart-area">
<?php 
	$z = 0;
	foreach ($sr as $item)
	{
		if ($item == 0) break;
		if ($item == $product->virtuemart_product_id )
		{
				$z = 1;
		}
	}
	if ($z == 0)
	{
	?>
		<span class="add-string" style="color:#356E8E; margin-left:50px; cursor:pointer;" onclick="but_cl();">Добавить в сравнение</span>
	<?php
	}
	?>
    <form method="post" class="product js-recalculate" action="index.php" >
	<?php // Product custom_fields
	if (!empty($this->product->customfieldsCart)) { ?>
    	<div class="product-fields">
		<?php foreach ($this->product->customfieldsCart as $field) { ?>
		    <div class="product-field product-field-type-<?php echo $field->field_type ?>">
			<span class="product-fields-title" ><strong><?php echo JText::_($field->custom_title) ?></strong></span>
			<?php if ($field->custom_tip)
			    echo JHTML::tooltip($field->custom_tip, JText::_($field->custom_title), 'tooltip.png'); ?>
			<span class="product-field-display"><?php echo $field->display ?></span>

			<span class="product-field-desc"><?php echo $field->custom_field_desc ?></span>
		    </div><br />
		    <?php
		}
		?>
    	</div>
	<?php
	}
	/* Product custom Childs
	 * to display a simple link use $field->virtuemart_product_id as link to child product_id
	 * custom_value is relation value to child
	 */

	if (!empty($this->product->customsChilds)) {
	    ?>
    	<div class="product-fields">
    <?php foreach ($this->product->customsChilds as $field) { ?>
		    <div class="product-field product-field-type-<?php echo $field->field->field_type ?>">
			<span class="product-fields-title" ><strong><?php echo JText::_($field->field->custom_title) ?></strong></span>
			<span class="product-field-desc"><?php echo JText::_($field->field->custom_value) ?></span>
			<span class="product-field-display"><?php echo $field->display ?></span>

		    </div><br />
		<?php } ?>
    	</div>
<?php } ?>

	<div class="addtocart-bar">

<?php // Display the quantity box

    $stockhandle = VmConfig::get('stockhandle', 'none');
    if (($stockhandle == 'disableit' or $stockhandle == 'disableadd') and ($this->product->product_in_stock - $this->product->product_ordered) < 1) {
 ?>
		<a href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&layout=notify&virtuemart_product_id='.$this->product->virtuemart_product_id); ?>" class="notify"><?php echo JText::_('COM_VIRTUEMART_CART_NOTIFY') ?></a>

<?php } else { ?>
<?php // Display the quantity box ?> 	<div style="float:left; display:block; border:0 none;">
			<!-- <label for="quantity<?php echo $this->product->virtuemart_product_id;?>" class="quantity_box"><?php echo JText::_('COM_VIRTUEMART_CART_QUANTITY'); ?>: </label> -->
			<div class="quantity-controls-add">
				<input type="button" class="quantity-controls quantity-plus" />
				</div><div class="quantity-box">
				<input type="text" class="quantity-input" name="quantity[]" value="1" />
			</div><div class="quantity-controls-remove">
				<input type="button" class="quantity-controls quantity-minus" />
			</div>  	</div>
			<?php // Display the quantity box END ?>

	    <?php
	    // Display the add to cart button
	    ?>     <div style="float:left;display:block; width:70%;">
		<span class="addtocart-button">
		<?php echo shopFunctionsF::getAddToCartButton($this->product->orderable); ?>
		</span>
<?php } ?>
       	</div>
	    <div class="clear"></div>
	</div>

	<?php // Display the add to cart button END  ?>
	<input type="hidden" class="pname" value="<?php echo $this->product->product_name ?>" />
	<input type="hidden" name="option" value="com_virtuemart" />
	<input type="hidden" name="view" value="cart" />
	<noscript><input type="hidden" name="task" value="add" /></noscript>
	<input type="hidden" name="virtuemart_product_id[]" value="<?php echo $this->product->virtuemart_product_id ?>" />
    </form>

    <div class="clear"></div>
</div>
<script>
function array_unique(arr) {
		var tmp_arr = new Array();
			for (i = 0; i < arr.length; i++) {
				if (tmp_arr.indexOf(arr[i]) == "-1") {
					tmp_arr.push(arr[i]);
				}
			}
		return tmp_arr;
	}
function but_cl()
{
	
	myVar = get_cookie("vm_sravnenie_value");
	if (myVar)
	{
		var sa = myVar.split(",");
	}
	else
	{
		sa='';
	}
	if (sa.length < 3)
	{
		if (myVar)
			{
				value = myVar + ',' + jQuery('input[name="virtuemart_product_id[]"]').val();
			}
			else
			{
				value = jQuery('input[name="virtuemart_product_id[]"]').val();
			}
			
			var simpleArray = value.split(",");
			simpleArray2 = array_unique(simpleArray);
			value = simpleArray2.join(',');
			document.cookie="vm_sravnenie_value=" + value + "; path=/";
			
			if (simpleArray.length == simpleArray2.length)
			{
				t = jQuery('#component h1').html();
				t2 = jQuery('.main-image img').attr('src');
				s = '<div class="item_sravnenie"><img src="' + t2 + '" title="' + t + '" onload="info(this)"><span class="delete_item_sravnenie" item="' + jQuery('input[name="virtuemart_product_id[]"]').val() + '" style="cursor:pointer; color:#356E8E;"></span></div>';
				if (jQuery('.item_containr_mod_sravnenie').attr('is_an') == 'no')
				{
					jQuery('.item_containr_mod_sravnenie').html('');
					jQuery('.item_containr_mod_sravnenie').removeAttr('is_an')
				}
				jQuery('.item_containr_mod_sravnenie').append(s);	
				jQuery('.delete_item_sravnenie').click(function(){
					jQuery(this).parent().remove();
					text = new Array();
					jQuery('.delete_item_sravnenie').each(function(){						
						text.push(jQuery(this).attr('item'));						
					});
					document.cookie='vm_sravnenie_value=' + text + '; path=/';
					if (jQuery(".item_sravnenie").length > 1) {
						jQuery('.sravnenie-folder-link').show();
					}
					else
					{
						jQuery('.sravnenie-folder-link').hide();
					}
					if (jQuery(".item_sravnenie").length == 0) {
						jQuery('.item_containr_mod_sravnenie').html('нет товаров в папке сравнения');
					}
				});
			}
			
	}
	else
	{
		jQuery.facebox.settings.closeImage = closeImage;
		jQuery.facebox.settings.loadingImage = loadingImage;
		place_text = "Ваша папка сравнения переполнена выберите товар который следует удалить или закройте это окно<br><br><div class='popup_sravnenie' item='" + jQuery('.vid', s).val() + "'>" + jQuery('.item_containr_mod_sravnenie').html() + '</div>';
		jQuery.facebox({ text: place_text }, 'my-groovy-style');
		jQuery('.popup_sravnenie .delete_item_sravnenie').click(function(){
		
			s = jQuery(this).attr('item');
			text2 = new Array();
			jQuery('.popup_sravnenie .delete_item_sravnenie').each(function(){						
						if (s != jQuery(this).attr('item'))
						{
							text2.push(jQuery(this).attr('item'));						
						}
					});
			text2.push(jQuery('.popup_sravnenie').attr('item'));
			document.cookie='vm_sravnenie_value=' + text2 + '; path=/';
		});	
	}
	if (jQuery(".item_sravnenie").length > 1) {
		jQuery('.sravnenie-folder-link').show();
	}
	else
	{
		jQuery('.sravnenie-folder-link').hide();
	}
	
}
</script>