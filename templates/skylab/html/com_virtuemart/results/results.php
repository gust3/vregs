<?php
/**
 * @subpackage        tpl_skylab
 * @copyright        Copyright (C) 2011 Linelab.org. All rights reserved.
 * @license          Commercial
 */

defined('_JEXEC') or die('Restricted access');
$document = JFactory::getDocument();

?>
<div class="browse-view">
	<input type="hidden" name="is_results" id="is_results" value="1" />
	<h1><?php echo JText::_('Результаты поиска'); ?></h1>
		<div class="orderby-displaynumber">
			<div class="orderByList">
				<?php
				echo preg_replace_callback('/(href="([^"]*)")/','replaceOrderBy',$orderByList['orderby']);
			//	echo preg_replace_callback('/(href="([^"]*)")/','replaceManufacturer',$orderByList['manufacturer']);
				?>
			</div>
				<div class="display-number"><div>&nbsp;</div>
				<?php 
					if (count($products)>12) { echo str_replace('name=""','id="limit"',preg_replace('/onchange="([^"]*)"/','onchange="loadContent(this.value,document.getElementById(\'vm2_search\').toQueryString()+\'&mod_search[price][from]=\'+document.getElementById(\'price_from\').options[document.getElementById(\'price_from\').selectedIndex].value+\'&mod_search[price][to]=\'+document.getElementById(\'price_to\').options[document.getElementById(\'price_to\').selectedIndex].value);"',str_replace('&amp;amp;','&',$pagination->getLimitBox())));}
					else
					{
					echo str_replace('start=', 'results=get_results&start=', str_replace("selected=\"selected\"", "", str_replace('name=""','id="limit"',preg_replace('/onchange="([^"]*)"/','onchange="loadContent(this.value,document.getElementById(\'vm2_search\').toQueryString()+\'&mod_search[price][from]=\'+document.getElementById(\'price_from\').options[document.getElementById(\'price_from\').selectedIndex].value+\'&mod_search[price][to]=\'+document.getElementById(\'price_to\').options[document.getElementById(\'price_to\').selectedIndex].value);"',str_replace('&amp;amp;','&',$pagination->getLimitBox())))));
					}

					?> </div>
				<div class="clear"></div>
		</div>
		
		<div id="bottom-pagination"><?php echo str_replace('start', 'limit='.JRequest::getInt('limit',12).'&start',$pagination->getPagesLinks()); ?></div><div style="text-align:center;"><?php echo $pagination->getPagesCounter(); ?></div>
	<?php
	$verticalseparator = " vertical-separator";
	$iBrowseCol=1;
	$iBrowseProduct=1;
	$width=' width'.floor(100/$per_row);
	$BrowseProducts_per_row=$per_row;
	if(JRequest::getInt('per_row')) {
                $BrowseProducts_per_row=JRequest::getInt('per_row');
                $Browsecellwidth = ' width'.floor ( 100 / $BrowseProducts_per_row );
        } else {
                $Browsecellwidth = ' width33';
        }
	?>
	<div id="product-list-container">
	<?php
	foreach ( $products as $product ) {
	    echo '<input type="hidden" name="special_product_id" value="'.$product->virtuemart_product_id.'" disabled="disabled" />';

	// Show the horizontal seperator
	if ($iBrowseCol == 1 && $iBrowseProduct > $BrowseProducts_per_row) { ?>
	<div class="horizontal-separator"></div>
	<?php }

	// this is an indicator wether a row needs to be opened or not
	if ($iBrowseCol == 1) { ?>
	<div class="row">
	<?php }

	// Show the vertical seperator
	if ($iBrowseProduct == $BrowseProducts_per_row or $iBrowseProduct % $BrowseProducts_per_row == 0) {
		$show_vertical_separator = ' ';
	} else {
		$show_vertical_separator = $verticalseparator;
	}

		// Show Products ?>
		
		
				<div class="produkt floatleft<?php echo $cellwidth . $show_vertical_separator ?> width25" action="#">
			<div class="spacer">
				<div class="nadpis" id="nadpis_<?php echo $product->virtuemart_product_id ?>" >
								<h3><?php echo JHTML::link($product->link, $product->product_name); ?></h3>
					<div class="obrazek" id="obrazek_<?php echo $product->virtuemart_product_id ?>" style="position: relative;">
						<?php
							echo JHTML::_('image', $product->images[0]->file_url_thumb, $product->product_name, 'id = "obrazek_'.$product->virtuemart_product_id.'_img"');
						?>
						
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
								<input type="button" class="addtocart-button details" value="<?php echo JText::_('Сравнить'); ?>" onclick="but_cl('nadpis_<?php echo $product->virtuemart_product_id ?>');"/>
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
					<div class="product-price marginbottom12" id="productPrice<?php echo $product->virtuemart_product_id ?>">

					</div>  
						<div class="product-price marginbottom12" id="productPrice<?php echo $product->virtuemart_product_id ?>" style="float:left;">
											<?php
												echo (int) $product->prices['salesPriceTemp']." <span class='rouble'>e</span>" ;
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
								<input type="hidden" name="virtuemart_product_id[]" class="vid" value="<?php echo $product->virtuemart_product_id ?>" />
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
	$iBrowseProduct ++;

	// Do we need to close the current row now?
	if ($iBrowseCol == $BrowseProducts_per_row) { ?>
	<div class="clear"></div>
	</div>
		<?php
		$iBrowseCol = 1;
	} else {
		$iBrowseCol ++;
	}
}
?>
</div>
<?php
// Do we need a final closing row tag?
if ($iBrowseCol != 1) { ?>
	<div class="clear"></div>
	</div>
<?php
}
?>	
<div id="bottom-pagination"><?php echo str_replace('start', 'limit='.JRequest::getInt('limit',12).'&start',$pagination->getPagesLinks()); ?></div><div style="text-align:center;"><?php echo $pagination->getPagesCounter(); ?></div>
</div>

<script type="text/javascript">
	jQuery(function(){
		Cufon.refresh;
	});
</script>