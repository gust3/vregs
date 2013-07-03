<?php
defined('_JEXEC') or die('Restricted access');

//чтение параметров из COOKIE
$p = 'product'.$this->product->virtuemart_product_id;
if ($_COOKIE[$p])
{
	$params = explode(":", $_COOKIE[$p]);
    
    if (!in_array($params[0], $this->nets)) 
    {        
    foreach ($this->nets as $item)
        {
            if (!$item->adresses[0]->id) 
            {
                continue;
            }
            else
            {
                $params[0] = $item->adresses[0]->id;
                $params[1] = $item->id_net;
                break;
            }
        }
    }
}
else
{
foreach ($this->nets as $item)
{
	if (!$item->adresses[0]->id) 
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
<?php
$js = 'jQuery(function($){ ';
//скрипты для карты
$js .= 'arr = new Array(); ';
$i=0;
foreach ($this->nets as $item){
    $js .= 'arr.push(new Array()); 
    ';
    $i++;
}
$js .= 'ymaps.ready(init); 
    function init(){
    realMap = new ymaps.Map ("real_map", { 
    center: ['.$this->startpos->x.', '.$this->startpos->y.'], 
    zoom: 9
    }); 
    realMap.controls.add( 
    new ymaps.control.ZoomControl());';
$j = 0;
$i = 0;

foreach ($this->nets as $item){
if (($item->adresses == 'same') || (!$item->adresses)) continue;
    foreach ($item->adresses as $adress) {	
    $js .=  'var myGeocoder = ymaps.geocode("'.$adress->adress.'"); 
        myGeocoder.then( 
        function (res) { 
            placemark = new ymaps.Placemark(res.geoObjects.get(0).geometry.getCoordinates(), { ';
    $js .= "content: '".$adress->adress."', ";
    $js .= "balloonContent: '".$adress->adress."<br>".$adress->clocks."' ";
    $js .= "}); ";		
    $js .= "arr[".$i."].push(placemark);";
	if ($params[1] == $item->id_net){
        $js .= "realMap.geoObjects.add(placemark);";
			if ($j == 0){
				if ($params[0] <> -1) {
					$js .= 'placemark.balloon.open();';
					}						
					$j=1;
			}
	}
    $js .= '}, 
    function (err) { 
    } 
    ); ';
	}
		$i++;
}
	$js .= "} ";
	
    $js .= "$('.net_control').change(function(){ ";
	$js .= 'if ($(".dostavka").attr("checked") == "checked") ';
    $js .= '{ ';
	$js .= 'document.cookie="product'.$this->product->virtuemart_product_id.'=-1:" + $(this).val() + "; path=/"; ';
	$js .= '} ';
   
	$js .= "$('.block_adresses').hide(); ";
	$js .= "$('.block_adresses[net_id=\"' + $(this).val() + '\"]').show(); ";

    $js .= "num = $('.block_adresses.active_tab').attr('arr_id'); ";
	$js .= "for (i=0; i<arr[num].length; i++) ";
	$js .= "{ ";
    
	$js .= "realMap.geoObjects.remove(arr[num][i]); ";
	$js .= '} ';
	
    $js .= "$('.block_adresses.active_tab').removeClass('active_tab'); ";
	$js .= "num = $(this).attr('arr_id'); ";
	$js .= "for (i=0; i<arr[num].length; i++) ";
	$js .= "{ ";
	$js .= "realMap.geoObjects.add(arr[num][i]); ";
	$js .= "} ";
	
    $js .= "$('.block_adresses[arr_id=' + num + ']').addClass('active_tab'); ";
	$js .= "realMap.setZoom(9); ";
    
    $js .= "realMap.setCenter([".$this->startpos->x.", ".$this->startpos->y."]); ";
	
    $js .= "}); ";
	
    $js .= '$(".netpoints").click(function(){ ';
	$js .= 'num = $(this).attr("arr_id"); ';
	$js .= "num2 = $(this).parent().parent().attr('arr_id'); ";
	$js .= "arr[num2][num].balloon.open(); ";
	$js .= "realMap.setZoom(16); ";
	$js .= "realMap.setCenter(arr[num2][num].geometry.getCoordinates()); ";
	$js .= "});	";
	$js .= "$('.more_link_adresses').click(function(){ ";
	$js .=	"p = $(this).parent().parent(); ";
	$js .= "$('.more', p).toggle(); ";
	$js .= "}); ";
	$js .= "$('.netpoints').change(function() ";
	$js .= "{ ";
	$js .= "phones = $(this).attr('phones'); ";
	$js .= 'if (phones) { phones = phones.split(";"); }';
	$js .= '{ if (!phones[0]) ';
    $js .= '{ ';
	$js .= "phones[0] = ''; ";
	$js .= "} ";
	$js .= "if (!phones[1]) ";
	$js .= "{ ";
	$js .= "phones[1] = ''; ";
	$js .= "} ";
	$js .= "phones = '<div>' + phones[0] + '</div>' + '<div>' + phones[1] + '</div>'; ";
	$js .= "$('div.phones').html(phones); }";
	  
    $js .= "document.cookie='product".$this->product->virtuemart_product_id."=' + $(this).val() + ':' + $(this).parent().parent().attr('net_id') + '; path=/'; ";
	
    $js .= "$('.dostavka').removeAttr('checked'); ";

    $js .= "}); ";
	 
    $js .= "$('.dostavka').change(function(){ ";

	$js .= "$('.netpoints').removeAttr('checked'); ";
	$js .= '$("#adress_container").toggle(); ';

	$js .= "if ($(this).attr('checked')){ ";
 
	$js .= 'document.cookie="product'.$this->product->virtuemart_product_id.'=-1:" + $(".net_control:checked").val() + "; path=/"; ';
	$js .= '} ';
	$js .= 'else ';
	$js .= '{';
	$js .= 'if ($(".netpoints:checked").val())';
	$js .= '{';
	$js .= "document.cookie='product".$this->product->virtuemart_product_id."=' + $('.netpoints:checked').val() + ':' + $('.net_control:checked').val() + '; path=/'; ";
	$js .= "} ";
	$js .= "else ";
	$js .= "{ ";
	$js .= "document.cookie='product".$this->product->virtuemart_product_id."=' + $('.netpoints:first').val() + ':' + $('.net_control:checked').val() + '; path=/'; ";
	$js .= "$('.netpoints:first').attr('checked', 'checked'); ";
	$js .= "} ";
	$js .= "$(\".block_adresses[net_id='".$params[1]."']\").addClass('active_tab').css('display', 'block'); ";
	$js .= "} ";
	$js .= "}); ";

    if ($params[0] == -1) {	
	$js .= "$('#adress_container').hide(); ";
	$js .= "$('.net_control[value=".$params[1]."]').attr('checked', 'checked'); ";
	$js .= "$(\".block_adresses[net_id='".$params[1]."']\").addClass('active_tab').css('display', 'block'); ";
	$js .= "document.cookie='product".$this->product->virtuemart_product_id."=' + ".$params[0]." + ':' + ".$params[1]." + '; path=/'; ";
	}	
	else
	{
	$js .= 	"$(\".net_control[value='".$params[1]."']\").attr('checked', 'checked'); ";
	$js .= "$(\".netpoints[value='".$params[0]."']\").attr('checked', 'checked'); ";
	$js .= "$(\".block_adresses[net_id='".$params[1]."']\").addClass('active_tab').css('display', 'block');	";
	$js .= "document.cookie='product".$this->product->virtuemart_product_id."=' + ".$params[0]." + ':' + ".$params[1]." + '; path=/';";
	}
       
	$js .= "phones = $('.selecetednetpoint').attr('phones'); ";
	$js .= 'if (phones) { phones = phones.split(";");	';
	$js .= "if (!phones[0]) ";
	$js .= "{ ";
	$js .= "phones[0] = ''; ";
	$js .= "}";
	$js .= "if (!phones[1]) ";
	$js .= "{ ";
	$js .= "phones[1] = ''; ";
	$js .= "}";
	$js .= "phones = '<div>' + phones[0] + '</div>' + '<div>' + phones[1] + '</div>';";
	$js .= "$('div.phones').html(phones); }";
    $js .= "});";
    $document = JFactory::getDocument();
    $document->addScriptDeclaration($js);
?>
<div style="clear:both;"></div>