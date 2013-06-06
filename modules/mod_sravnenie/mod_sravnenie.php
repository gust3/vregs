<?php
defined('_JEXEC') or die('Restricted access');
?>
<div class="item_containr_mod_sravnenie" <?php if (!$_COOKIE['vm_sravnenie_value']) echo "is_an='no'"?>>
<?php
if (!$_COOKIE['vm_sravnenie_value'])
{
	echo "нет товаров в папке сравнения";
}
else
{
	$mass = explode(',', $_COOKIE['vm_sravnenie_value']);
?>

<?php	
	foreach ($mass as $item)
	{
		$db = JFactory::getDBO();
		$query = 'SELECT product_name FROM #__virtuemart_products_ru_ru WHERE virtuemart_product_id='.$item;
		$db->setQuery($query);
		$result = $db->loadResult();		
		$query = 'SELECT vms.file_url_thumb FROM #__virtuemart_product_medias AS pm, #__virtuemart_medias AS vms WHERE pm.virtuemart_media_id = vms.virtuemart_media_id AND pm.virtuemart_product_id='.$item;
		$db->setQuery($query);
		$result2 = $db->loadResult();		
		$s = '<div class="item_sravnenie"><img src="'.$result2.'" title="'.$result.'" onload="info(this)"><span class="delete_item_sravnenie" item="'.$item.'" style="cursor:pointer; color:#356E8E;"></span></div>';
		echo $s;
	}
}
?>
</div>
<div style="clear:both;"></div>
<a class="sravnenie-folder-link" href="<?php echo JRoute::_('sravnenie.html');?>" title="перейти к сравнению" style="color:#356E8E; <?php if (count($mass) < 2) echo "display:none;"?>">Перейти к сравнению</a>
<script>
var info = function(img) {
    if (img.width < img.height)
	{
		jQuery(img).css('height', '40px');
		jQuery(img).css('width', 'auto');
	}
}

jQuery(function($){
$('.item_containr_mod_sravnenie .delete_item_sravnenie').click(function(){
	v2 = $(this).attr('item');	
	$(this).parent().remove();
	text = new Array();
	$('.item_containr_mod_sravnenie .delete_item_sravnenie').each(function(){		
		text.push($(this).attr('item'));		
	});
	document.cookie='vm_sravnenie_value=' + text + '; path=/';	
	v = '#nadpis_' + v2;
	jQuery('.span-' + v2).show();
	$('input.addtocart-button', v).val('Сравнить').attr("onclick", "but_cl('nadpis_"+ v2 +"')");
	if (jQuery(".res .item_sravnenie").length > 1) {
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
});
</script>