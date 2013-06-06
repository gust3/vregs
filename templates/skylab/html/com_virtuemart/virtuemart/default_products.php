<?php defined('_JEXEC') or die('Restricted access');

$document = JFactory::getDocument();
// Separator
$verticalseparator = " vertical-separator";
$i = 0;
foreach ($this->products as $type => $productList ) {
// Calculating Products Per Row
$products_per_row = VmConfig::get ( 'homepage_products_per_row', 3 ) ;
$cellwidth = ' width'.floor ( 100 / $products_per_row );

// Category and Columns Counter
$col = 1;
$nb = 1;

$productTitle = JText::_('COM_VIRTUEMART_'.$type.'_PRODUCT');
 if ($i > 0){
?>
<div class="horizontal-separator"></div>
<?php
}
?>
<div class="<?php echo $type ?>-view">

	<h4><?php echo $productTitle ?></h4>
<?php // Start the Output
$db = JFactory::getDBO();
$sr = explode(',', $_COOKIE['vm_sravnenie_value']);
foreach ( $productList as $product ) {
	
	$query = 'SELECT sa.adress FROM #__vmtools_nets_products AS np, #__vmtools_shops_adresses AS sa WHERE sa.id_net = np.id_net AND sa.id_region = '.$_COOKIE['region'].' AND np.id_product ='.$product->virtuemart_product_id;
	$db->setQuery($query);
	$adresses = $db->loadObjectList();	
	if (count($adresses) == 0) continue;
	
	// Show the horizontal seperator
	if ($col == 1 && $nb > $products_per_row) { ?>
	<div class="horizontal-separator"></div>
	<?php }

	// this is an indicator wether a row needs to be opened or not
	if ($col == 1) { ?>
	<div class="row">
	<?php }

	// Show the vertical seperator
	if ($nb == $products_per_row or $nb % $products_per_row == 0) {
		$show_vertical_separator = ' ';
	} else {
		$show_vertical_separator = $verticalseparator;
	}

		// Show Products ?>
<div class="produkt floatleft<?php echo $cellwidth . $show_vertical_separator ?>" action="#">
			<div class="spacer">
				<div class="nadpis" id="nadpis_<?php echo $product->virtuemart_product_id ?>" >
								<h3><?php echo JHTML::link($product->link, $product->product_name); ?></h3>
					<div class="obrazek" id="obrazek_<?php echo $product->virtuemart_product_id ?>" style="position: relative;">
						<a href="<?php echo $product->link;?>" title="<?php echo $product->product_name; ?>"><img id="obrazek_<?php echo $product->virtuemart_product_id ?>_img" src="<?php echo $product->images[0]->file_url_thumb;?>" alt="<?php echo $product->product_name;?>"></a>
						<div id="product_link_1_<?php echo $product->virtuemart_product_id ?>" style="position: absolute; top: 50px; left: 0; width: 100%;">
							<div id="product_link_2_<?php echo $product->virtuemart_product_id ?>" style="position: absolute; top: 0; opacity:0;filter:alpha(opacity=0);">
							<?php // Product Details Button
								echo JHTML::link($product->link, JText::_('COM_VIRTUEMART_PRODUCT_DETAILS'), array('title' => $product->product_name,'class' => 'product-details'));
							?>
							</div>
						</div>
						<div id="cart_link_1_<?php echo $product->virtuemart_product_id ?>" style="position: absolute; top: 40px; left: 0;">
							<div id="cart_link_2_<?php echo $product->virtuemart_product_id ?>" style="position: absolute; top: 0px; left: 0;opacity:0; filter:alpha(opacity=0);display: block;">
								<div class="addtocart-bar" style="width:200px;">
								
								<?php 
									$y = 0;
									foreach ($sr as $item)
									{
										if ($item == $product->virtuemart_product_id )
										{
											$y = 1;
										}
									}
								if ($y == 0)
								{
								?>								
								<input type="button" class="addtocart-button details" value="<?php echo JText::_('Сравнить'); ?>" onclick="but_cl('nadpis_<?php echo $product->virtuemart_product_id ?>');"/>
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
						<?php if (VmConfig::get('pshop_allow_reviews') == 1) { ?>
						<span class="contentpagetitle"><?php echo JText::_('COM_VIRTUEMART_CUSTOMER_RATING') ?>:</span>
						<br />
						<?php
						// $img_url = JURI::root().VmConfig::get('assets_general_path').'/reviews/'.$product->votes->rating.'.gif';
						// echo JHTML::image($img_url, $product->votes->rating.' '.JText::_('COM_VIRTUEMART_REVIEW_STARS'));
						// echo JText::_('COM_VIRTUEMART_TOTAL_VOTES').": ". $product->votes->allvotes; ?>
						<?php } ?>
										<div class="product-price marginbottom12" id="productPrice<?php echo $product->virtuemart_product_id ?>" style="float:left;">
					<?php
						echo (int) $product->prices['salesPriceTemp']." <span class='rouble' style=\"font-size:16px !important; font-weight:normal;\">e</span>" ;
					?>					
					</div>  
			<form method="post" class="product" action="index.php" id="addtocartproduct<?php echo $product->virtuemart_product_id ?>">
			<div class="addtocart-bar" style="float:right;">

            <?php // Display the quantity box ?>
            <!-- <label for="quantity<?php echo $product->virtuemart_product_id;?>" class="quantity_box"><?php echo JText::_('COM_VIRTUEMART_CART_QUANTITY'); ?>: </label> -->
            <span class="quantity-box" style="display:none;">
                <input  type="text" class="quantity-input" name="quantity[]" value="1" />
            </span>
            <span class="quantity-controls" style="display:none;"> 
                <input type="button" class="quantity-controls quantity-plus" />
                <input type="button" class="quantity-controls quantity-minus" />
            </span>
            <?php // Display the quantity box END ?>

            <?php // Add the button
            $button_lbl = JText::_('COM_VIRTUEMART_CART_ADD_TO');
            $button_cls = ''; //$button_cls = 'addtocart_button';
            if (VmConfig::get('check_stock') == '1' && !$product->product_in_stock) {
                $button_lbl = JText::_('COM_VIRTUEMART_CART_NOTIFY');
                $button_cls = 'notify-button';
            } ?>

            <?php // Display the add to cart button ?>
            <span class="addtocart-button">
                <input type="submit" name="addtocart"  class="addtocart-button style2" value="<?php echo $button_lbl ?>" title="<?php echo $button_lbl ?>" />
            </span>

        <div class="clear"></div>
        </div>

        <?php // Display the add to cart button END ?>
        <input type="hidden" class="pname" value="<?php echo $product->product_name ?>">
        <input type="hidden" name="option" value="com_virtuemart" />
        <input type="hidden" name="view" value="cart" />
        <noscript><input type="hidden" name="task" value="add" /></noscript>
        <input type="hidden" class="vid" name="virtuemart_product_id[]" value="<?php echo $product->virtuemart_product_id ?>" />
        <?php /** @todo Handle the manufacturer view */ ?>
        <input type="hidden" name="virtuemart_manufacturer_id" value="<?php echo $product->virtuemart_manufacturer_id ?>" />
        <input type="hidden" name="virtuemart_category_id[]" value="<?php echo $product->virtuemart_category_id ?>" />
		</form>
		<div style="clear:both;"></div>
				</div>

<div class="popis">
						<?php // Product Short Description
						if(!empty($product->product_s_desc)) { ?>
						<?php } ?>
 
<?php
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
?>
 
				</div>
			<div class="clear"></div>
			</div>	
		</div>		
	<?php
	$nb ++;

	// Do we need to close the current row now?
	if ($col == $products_per_row) { ?>
	<div class="clear"></div>
	</div>
		<?php
		$col = 1;
	} else {
		$col ++;
	}
	
}
// Do we need a final closing row tag?
if ($col != 1) { ?>
	<div class="clear"></div>
	</div>
<?php
}
?>
</div>

<script>
function get_cookie ( cookie_name )
	{
	  var results = document.cookie.match ( '(^|;) ?' + cookie_name + '=([^;]*)(;|$)' );
	 
	  if ( results )
		return ( unescape ( results[2] ) );
	  else
		return null;
	}
</script>
<?php 
$i++;
}