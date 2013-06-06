<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;
JHtml::_('behavior.formvalidation');
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');


if (!$this->info[0]->label) $this->info[0]->label = $this->info[0]->ymname;
?>
<h3><?php echo str_replace("'", "", $this->info[0]->label);?></h3>
<ul>
<li><?php echo $this->info[0]->email?></li>
<li><?php echo $this->info[0]->phone?></li>
<li><?php echo $this->info[0]->url?></li>
</ul>
<br>
<div style="clear:both;" class="product_details_buttons">
<a class="<?php if (JRequest::getVar('layout', 'default') == 'adresses') echo "selected"; ?>" href="<?php echo JRoute::_("index.php?option=com_gustvmtools&view=contact&id=".JRequest::getVar('id')."&layout=adresses");?>">Адреса сети</a>
<a class="<?php if (JRequest::getVar('layout', 'default') != 'adresses') echo "selected"; ?>" href="<?php echo JRoute::_("index.php?option=com_gustvmtools&view=contact&id=".JRequest::getVar('id')."&layout=products");?>">Продукты</a>



</div>
<br><br>
<div style="clear:both;">
<?php
if (JRequest::getVar('layout', 'default') == 'adresses')
{
foreach ($this->items as $k => $adress) {?>
	<div>
<?php
	echo $adress->adress."; ".$adress->clocks;
?>
	</div>
<?php }
}
?>
<?php
$db=& JFactory::getDBO();
if (JRequest::getVar('layout', 'default') == 'products')
{
if (!class_exists ('VmConfig')) {
		require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'helpers' . DS . 'config.php');
	}
	VmConfig::loadConfig ();
$productModel = VmModel::getModel('Product');
?>
<!--
<?php


foreach ($this->items as $k => $product) {
	
	$query = "SELECT product_name FROM #__virtuemart_products_ru_ru WHERE virtuemart_product_id = ".$product->id;
	$db->setQuery($query);
	$name = $db->loadResult();
	
	$query = "SELECT price FROM #__vmtools_nets_products WHERE id_product = ".$product->id." AND id_net = ".JRequest::getVar('id');
	$db->setQuery($query);
	$price = $db->loadResult();
	

	$p = $productModel->getProductSingle($product->id);
	$productModel->addImages($p);	
?>
<form method="post" class="product js-recalculate" action="index.php">
  <input type="text" class="quantity-input" name="quantity[]" value="1" style="display:none;">
   <input type="hidden" name="option" value="com_virtuemart">
  <input type="hidden" name="view" value="cart">
  <input type="hidden" name="task" value="add">
  <input type="hidden" name="virtuemart_product_id[]" value="<?php echo $p->virtuemart_product_id?>">
  <input type="hidden" class="pname" value="<?php echo $name;?>"/>
	<div style="float:left; width:25%; margin-bottom:10px; height:80px;" title="<?php echo $p->model;?>">
<?php 	
	echo "<div class='item_sravnenie pr-".$p->virtuemart_product_id."'><img onload='info(this)' src='http://".$_SERVER['SERVER_NAME'].'/'.$p->images[0]->file_url_thumb."' alt='".$name."'></div><p><a href='".JRoute::_($p->canonical)."' style='height:20px; display:block; overflow:hidden;'><b>".$name."</b></a>".$price." <span class='rouble'>e</span><br></p><div style='clear:both'><input type='button' class='span-".$p->virtuemart_product_id."' style='font-size:11px; cursor:pointer; float:left; margin-right:2px; margin-top:2px; margin-bottom:2px; margin-left:30px;' onclick='add_to(".$p->virtuemart_product_id.")' value='сравнить'/><input  style='float:left;font-size:11px;margin-top:2px; cursor:pointer;' type=\"submit\" name=\"addtocart\" class=\"addtocart-button\" value=\"заказать\" title=\"заказать\"></div>";
?>

</div>
</form>
<?php }
?>
-->
<?php
$document = JFactory::getDocument();
$virtuemart_product_id=$product->virtuemart_product_id;
$jscript="
	$('nadpis_$virtuemart_product_id').addEvents({
		'mouseenter' : function(){
			$('product_link_2_$virtuemart_product_id').morph({'opacity': '1','top': '-15px'});
			$('cart_link_2_$virtuemart_product_id').morph({'opacity': '1','top': '15px'});
			$('obrazek_${virtuemart_product_id}_img').morph({'opacity': '0.3'});
		},
		'mouseleave' : function(){ 
			$('product_link_2_$virtuemart_product_id').morph({'opacity': '0','top': '0px'});
			$('cart_link_2_$virtuemart_product_id').morph({'opacity': '0','top': '0px'});
			$('obrazek_${virtuemart_product_id}_img').morph({'opacity': '1'});
		}
	});	
";
$jscriptdomready="window.addEvent('domready', function(){
	$jscript
});	
";

$document->addScriptDeclaration($jscriptdomready);

$z = 0;
$sr = explode(',', $_COOKIE['vm_sravnenie_value']);
foreach($this->man as $k => $man) 
{
?>
<a class="manufacturer-link <?php if ($man->virtuemart_manufacturer_id == JRequest::getVar('man')) echo 'selected';?>" href="<?php echo JRoute::_("index.php?option=com_gustvmtools&view=contact&id=".JRequest::getVar('id')."&layout=products");?>?man=<?php echo $man->virtuemart_manufacturer_id?>"><?php echo $man->mf_name;?></a>
<?php
}

foreach ($this->items as $k => $product) {

$query = "SELECT product_name FROM #__virtuemart_products_ru_ru WHERE virtuemart_product_id = ".$product->id;
	$db->setQuery($query);
	$name = $db->loadResult();
	
	$query = "SELECT price FROM #__vmtools_nets_products WHERE id_product = ".$product->id." AND id_net = ".JRequest::getVar('id');
	$db->setQuery($query);
	$price = $db->loadResult();
	

	$p = $productModel->getProductSingle($product->id);
	$productModel->addImages($p);
	
	
	if ($z == 0)
	{
?>
	<div class="row" style="clear:both;">
<?php
	}	
?>

<div class="produkt floatleft width25 vertical-separator" action="#">
  <div class="spacer" style="margin-right:10px">
    <div class="nadpis" id="nadpis_<?php echo $p->virtuemart_product_id?>">
      <h3>
        <a href="<?php echo JRoute::_($p->canonical) ?>"><?php echo $name?></a>
      </h3>
      <div class="obrazek" id="obrazek_<?php echo $p->virtuemart_product_id?>" style="position: relative;">
        <a href="<?php echo JRoute::_($p->canonical) ?>" title="<?php echo $name?>">
          <img id="obrazek_<?php echo $p->virtuemart_product_id?>_img" src="<?php echo $p->images[0]->file_url_thumb?>" alt="<?php echo $name?>" style="opacity: 1;">
        </a>
        <div id="product_link_1_<?php echo $p->virtuemart_product_id?>" style="position: absolute; top: 50px; left: 0; width: 100%;">
          <div id="product_link_2_<?php echo $p->virtuemart_product_id?>" style="position: absolute; top: 0px; opacity: 0;">
            <a href="<?php echo JRoute::_($p->canonical) ?>" title="GlobusGPS GL-AV7" class="product-details">Описание товара</a>
          </div>
        </div>
        <div id="cart_link_1_<?php echo $p->virtuemart_product_id?>" style="position: absolute; top: 40px; left: 0;">
          <div id="cart_link_2_<?php echo $p->virtuemart_product_id?>" style="position: absolute; left: 0px; display: block; top: 0px; opacity: 0;">
            <div class="addtocart-bar" style="width:200px;">
              
			  <?php 
									$y = 0;
									foreach ($sr as $item)
									{
										if ($item == $p->virtuemart_product_id )
										{
											$y = 1;
										}
									}
								if ($y == 0)
								{
								?>								
								<input type="button" class="addtocart-button details" value="<?php echo JText::_('Сравнить'); ?>" onclick="but_cl('nadpis_<?php echo $p->virtuemart_product_id ?>');"/>
								<?php
								}
								else
								{
								?>
								<input type="button" class="addtocart-button details" value="<?php echo JText::_('перейти к сравнению'); ?>" onclick="goto_sravnenie()"/>
								<?php
								}
			?>
            </div>
          </div>
        </div>
      </div>
      <!-- The "Average Customer Rating" Part -->
      <div class="product-price marginbottom12" id="productPrice251" style="float:left;">
        
					<?php echo $price?>
        <span class="rouble" style="font-size:16px !important; font-weight:normal;">e</span>
      </div>
      <form method="post" class="product" action="index.php" id="addtocartproduct251">
        <div class="addtocart-bar" style="float:right;">
          <!-- <label for="quantity251" class="quantity_box">Кол-во: </label> -->
          <span class="quantity-box" style="display:none;">
            <input type="text" class="quantity-input" name="quantity[]" value="1">
          </span>
          <span class="quantity-controls" style="display:none;">
            <input type="button" class="quantity-controls quantity-plus">
            <input type="button" class="quantity-controls quantity-minus">
          </span>
          <span class="addtocart-button">
            <input type="submit" name="addtocart" class="addtocart-button style2" value="Заказать" title="Заказать">
          </span>
          <div class="clear"></div>
        </div>
        <input type="hidden" class="pname" value="<?php echo $name?>">
        <input type="hidden" name="option" value="com_virtuemart">
        <input type="hidden" name="view" value="contact">
        <noscript>&lt;input type="hidden" name="task" value="add" /></noscript>
        <input type="hidden" class="vid" name="virtuemart_product_id[]" value="<?php echo $p->virtuemart_product_id?>">
      </form>
      <div style="clear:both;"></div>
    </div>
				<div class="popis"></div>
    <div class="clear"></div>
  </div>
</div>


<?php

if ($z == 3)
{
?>
</div>
<?php
}
$z++;
if ($z == 4) $z =0;

}
}

if ($z > 0) 
{
?>
</div>
<?php
}
?>
<input type="hidden" name="option" value="com_gustvmtools" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="cart"/>
<?php echo JHtml::_('form.token'); ?>
<br>
<form action="<?php echo JRoute::_('index.php?option=com_gustvmtools&view=contact&id='.JRequest::getVar('id').'&layout='.JRequest::getVar('layout', 'default')); ?>" method="post" name="adminForm">
<table class="contacts" style="clear:both;">
    <tr>
		<td style="text-align:center;"><?php echo str_replace('value="0"', 'value="'.$this->total.'"',  $this->pagination->getListFooter()); ?></td>
	</tr>
</table>
</form>
<script>


jQuery('#limit').attr('onchange','');
<?php if (JRequest::getVar('layout', 'default') == 'products')
{
?>
jQuery('#limit').change(function(event)
{
event.preventDefault();
document.location.href = "<?php echo JRoute::_("index.php?option=com_gustvmtools&view=contact&id=".JRequest::getVar('id')."&layout=products");?>?man=<?php echo JRequest::getVar("man", '0')?>&limit=" + jQuery(this).val();
});
<?php
}
else
{
?>
jQuery('#limit').change(function(event)
{
event.preventDefault();
document.location.href = "<?php echo JRoute::_("index.php?option=com_gustvmtools&view=contact&id=".JRequest::getVar('id')."&layout=adresses");?>?limit=" + jQuery(this).val();
});
<?php
}
?>
jQuery('.nadpis').hover(
	function()
	{ 
		s = '#product_link_2_' + jQuery('.vid', this).val();
		jQuery(s).animate({  
		opacity: "1",
		top: "-15px",  
		}, 350);
		s = '#cart_link_2_' + jQuery('.vid', this).val();
		jQuery(s).animate({  
		opacity: "1",
		top: "15px",  
		}, 350); 
	}, 
	function()
	{
		s = '#product_link_2_' + jQuery('.vid', this).val();
		jQuery(s).animate({  
		opacity: "0",
		top: "0px",  
		}, 350);
		s = '#cart_link_2_' + jQuery('.vid', this).val();
		jQuery(s).animate({  
		opacity: "0",
		top: "0px",  
		}, 350);
	}
);
					
var info = function(img) {
    if (img.width < img.height)
	{
		jQuery(img).css('height', '40px');
		jQuery(img).css('width', 'auto');
	}
}
</script>
</div>