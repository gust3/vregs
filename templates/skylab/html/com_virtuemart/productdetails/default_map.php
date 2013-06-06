<?php
defined('_JEXEC') or die('Restricted access');

//чтение параметров из COOKIE
$p = 'product'.$this->product->virtuemart_product_id;
if ($_COOKIE[$p])
{
	$params = explode(":", $_COOKIE[$p]);
}
else
{
foreach ($this->nets as $item)
{
	if (!$item->adresses) 
	{
		continue;
	}
	else
	{
		$params[] = $item->adresses[0]->id;
		$params[] = $item->id_net;
		break;
	}
}
}
?>
<div style="float:left; width:50%; min-height:410px; clear:both;">
<?php
$i = 0;
?>
<table style="width:100%; padding-top:5px;">
<tr>
<td width="10%"></td><td width="45%">Цена</td><td>Магазин</td>
</tr>
</table>
<?php
foreach ($this->nets as $item)
{

if (($item->adresses == 'same') || (!$item->adresses))continue;
if (!$item->label) 
{
$item->label = $item->ymname;
}

?>
<div style="clear:both;">
<table style="width:100%; padding-top:5px;">
<tr>
<td style="padding-top:5px;"><input arr_id = "<?php echo $i;?>" style="float:left;"  class="net_control" type="radio" name="net[]" value="<?php echo $item->id_net;?>"></td>
<td style="width:45%; font-size:36px; color:#ba210f; padding-top:5px;"><?php echo $item->price;?> <span class="rouble">e</span></td>
<td style="width:45%; padding-top:5px; font-size:26px;color:black;"><?php echo str_replace("'","",$item->label);?></td>
</tr>
</table>
		<?php
			$j =0;
		?>
	<div class="block_adresses" arr_id = "<?php echo $i;?>" net_id = "<?php echo $item->id_net?>" style="clear:both; margin:10px; display:none;">
		<?php
			foreach ($item->adresses as $adress)
			{	
				$adr = str_replace($this->regionname.",", "", $adress->adress);
		?>
			<div style="clear:both; margin-left:20px; <?php if ($j>12) echo " display:none; ";?>" <?php if ($j>12) echo " class='more' ";?>>
				<input phones ="<?php echo $adress->phones;?>" class="netpoints <?php if ($adress->id == $params[0]) echo "selecetednetpoint"?>" arr_id = "<?php echo $j;?>" <?php if ($adress->id == $params[0]) echo 'checked="checked"';?> style="float:left;" type="radio" name="netadress[]" value="<?php echo $adress->id;?>"><span style="width:300px; height:20px; float:left; overflow:hidden; cursor:pointer;" title="<?php echo $adr;?>"><?php echo $adr;?></span>
			</div>
		<?php
				$j++;
			}
			if ($j >= 13) echo "<div style='clear:both; text-align:center;'><span class='more_link_adresses' style='cursor:pointer;' show='1'>показать/скрыть все</span></div>";
		?>
	</div>
</div>
<?php
$i++;
}
?>
<div style="clear:both">
<input type="checkbox" <? if ($params) 
	{
		if ($params[0] == -1) echo "checked='checked'";
	} ?> name="dostavka" class="dostavka" value="1" style="float:left">Доставка
</div>
</div>
<div id="real_map" class="div-maps" style="height: 399px; border: 1px solid #C6C3C3; width:420px;"></div>
<div class="addtocart-area" style="float:left; width:200px; margin-top:20px;">

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

	<div class="addtocart-bar map">

<?php // Display the quantity box

    $stockhandle = VmConfig::get('stockhandle', 'none');
    if (($stockhandle == 'disableit' or $stockhandle == 'disableadd') and ($this->product->product_in_stock - $this->product->product_ordered) < 1) {
 ?>
		<a href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&layout=notify&virtuemart_product_id='.$this->product->virtuemart_product_id); ?>" class="notify"><?php echo JText::_('COM_VIRTUEMART_CART_NOTIFY') ?></a>

<?php } else { ?>
<?php // Display the quantity box ?> 	<div style="float:left; display:block; border: 0 none;">
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

<script type="text/javascript">
jQuery(function($){	
//скрипты для карты
arr = new Array();
<?php
$i=0;
foreach ($this->nets as $item) 
{
?>
	arr.push(new Array());
<?php
	$i++;
}
?>
	ymaps.ready(init);
	function init(){     
		realMap = new ymaps.Map ("real_map", {
			center: [<?php echo $this->startpos->x?>, <?php echo $this->startpos->y?>],
			zoom: 9
		});
		realMap.controls.add(
		new ymaps.control.ZoomControl()
		);
		
		<?php
		$j = 0;
		$i = 0;
		foreach ($this->nets as $item) 
		{
		if (($item->adresses == 'same') || (!$item->adresses)) continue;
		?>	
		<?php foreach ($item->adresses as $adress)	
				{?>	
				var myGeocoder = ymaps.geocode("<?php echo $adress->adress;?>");				
				myGeocoder.then(
					function (res) {				
						placemark = new ymaps.Placemark(res.geoObjects.get(0).geometry.getCoordinates(), {
							content: '<?php echo $adress->adress;?>',
							balloonContent: '<?php echo $adress->adress."<br>".$adress->clocks;?>'
						});
						
						arr[<?php echo $i;?>].push(placemark);
						
						<?php
						
						if ($params[1] == $item->id_net){
						?>
						realMap.geoObjects.add(placemark);
						<?php
						if ($j == 0)
						{
							if ($params[0] <> -1) {
						?>						
						placemark.balloon.open();	
						<?
						}						
						$j=1;
						}
						}
						?>
					},
					function (err) {
					}
				);			
		<?php	}
		$i++;
		}		
		?>
	}	
	$('.net_control').change(function(){
	
	if ($(".dostavka").attr('checked') == "checked")
	{
		document.cookie="product<?php echo $this->product->virtuemart_product_id?>=-1:" + $(this).val() + "; path=/";
	}
	
	$('.block_adresses').hide();
	$('.block_adresses[net_id="' + $(this).val() + '"]').show();
		
		num = $('.block_adresses.active_tab').attr('arr_id');
			for (i=0; i<arr[num].length; i++)
			{
				realMap.geoObjects.remove(arr[num][i]);
			}
			$('.block_adresses.active_tab').removeClass('active_tab');
		num = $(this).attr('arr_id');
		for (i=0; i<arr[num].length; i++)
			{
				realMap.geoObjects.add(arr[num][i]);
			}
			$('.block_adresses[arr_id=' + num + ']').addClass('active_tab');
			realMap.setZoom(9);
			realMap.setCenter([<?php echo $this->startpos->x?>, <?php echo $this->startpos->y?>]);
	});
	
	$(".netpoints").click(function(){
		num = $(this).attr('arr_id');
		num2 = $(this).parent().parent().attr('arr_id')		
		arr[num2][num].balloon.open();
		realMap.setZoom(16);
		realMap.setCenter(arr[num2][num].geometry.getCoordinates());
		
	});	
	$('.more_link_adresses').click(function(){
		p = $(this).parent().parent();
		$('.more', p).toggle();
	});
	$(".netpoints").change(function()
	{
		phones = $(this).attr('phones');
		phones = phones.split(";");
		if (!phones[0])
		{
			phones[0] = '';
			
		}
		if (!phones[1]) 
		{
			phones[1] = '';
		}
		phones = '<div>' + phones[0] + '</div>' + '<div>' + phones[1] + '</div>';
		$('div.phones').html(phones);
		
		document.cookie="product<?php echo $this->product->virtuemart_product_id?>=" + $(this).val() + ':' + $(this).parent().parent().attr('net_id') + '; path=/';
		$('.dostavka').removeAttr('checked');
	});
	$(".dostavka").change(function(){
		$('.netpoints').removeAttr('checked');
		$("#adress_container").toggle();
		if ($(this).attr('checked')){
			document.cookie="product<?php echo $this->product->virtuemart_product_id?>=-1:" + $('.net_control:checked').val() + "; path=/";
		}
		else
		{
			if ($('.netpoints:checked').val())
			{
			document.cookie="product<?php echo $this->product->virtuemart_product_id?>=" + $('.netpoints:checked').val() + ':' + $('.net_control:checked').val() + '; path=/';
			}
			else
			{
			document.cookie="product<?php echo $this->product->virtuemart_product_id?>=" + $('.netpoints:first').val() + ':' + $('.net_control:checked').val() + '; path=/';
			$('.netpoints:first').attr('checked', 'checked');
			}			
			$(".block_adresses[net_id='<?php echo $params[1];?>']").addClass('active_tab').css('display', 'block');
		}
	});
	<?php if ($params[0] == -1) {?>	
		$('#adress_container').hide();
		$('.net_control[value=<?php echo $params[1];?>]').attr('checked', 'checked');
		$(".block_adresses[net_id='<?php echo $params[1];?>']").addClass('active_tab').css('display', 'block');
		document.cookie="product<?php echo $this->product->virtuemart_product_id?>=" + <? echo $params[0]?> + ':' + <? echo $params[1]?> + '; path=/';
	<?php }	
		else
		{
	?>
			$(".net_control[value='<?php echo $params[1];?>']").attr('checked', 'checked');			
			$(".netpoints[value='<?php echo $params[0];?>']").attr('checked', 'checked');
			$(".block_adresses[net_id='<?php echo $params[1];?>']").addClass('active_tab').css('display', 'block');			
			document.cookie="product<?php echo $this->product->virtuemart_product_id?>=" + <? echo $params[0]?> + ':' + <? echo $params[1]?> + '; path=/';
	<?php
		}
	?>
	phones = $('.selecetednetpoint').attr('phones');
	phones = phones.split(";");	
	if (!phones[0])
	{
		phones[0] = '';
		
	}
	if (!phones[1]) 
	{
		phones[1] = '';
	}
	phones = '<div>' + phones[0] + '</div>' + '<div>' + phones[1] + '</div>';
	$('div.phones').html(phones);	
});
</script>
<div style="clear:both;"></div>