<?php
/*
 * Created on 17.1.2012
 *
  * Author: Linelab.org
 * Project: vm2_search
 */

defined('_JEXEC') or die('Restricted access');

require_once JPATH_SITE.DS.'templates'.DS.'cartlab'.DS.'tools2.php';
?>

<div class="browse-view">
	<h1><?php echo JText::_('Search results'); ?></h1>
		<div class="orderby-displaynumber">
			<div class="orderByList">
				<?php
				echo preg_replace_callback('/(href="([^"]*)")/','replaceOrderBy',$orderByList['orderby']);
				echo preg_replace_callback('/(href="([^"]*)")/','replaceOrderBy',$orderByList['manufacturer']);
				?>
			</div>
				<div class="display-number"><span style="float:left;"><?php echo $pagination->getResultsCounter();?>&nbsp;</span>
				<?php echo preg_replace('/onchange="([^"]*)"/','onchange="loadContent(\''.JFactory::getURI()->toString().(strpos(JFactory::getURI()->toString(),'?')?'&':'?').'limitstart=0&limit=\'+this.value,document.getElementById(\'vm2_search\').toQueryString()+\'&mod_search[price][from]=\'+document.getElementById(\'price_from\').options[document.getElementById(\'price_from\').selectedIndex].value+\'&mod_search[price][to]=\'+document.getElementById(\'price_to\').options[document.getElementById(\'price_to\').selectedIndex].value);"',preg_replace_callback('/value="([^"]*)"/',"replaceLimit",$pagination->getLimitBox())); ?> </div>
				<div class="clear"></div>
			</div>
			<div id="bottom-pagination"><?php echo preg_replace_callback('/(href="([^"]*)")/','replacePagination',$pagination->getPagesLinks()); ?></div><div style="text-align:center;"><?php echo $pagination->getPagesCounter(); ?></div>
	<?php
	$verticalseparator = " vertical-separator";
	$iBrowseCol=1;
	$iBrowseProduct=1;
	$width=' width'.floor(100/$per_row);
	$BrowseProducts_per_row=$per_row;
	
	foreach ( $products as $product ) {

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
		<div class="product floatleft<?php echo $Browsecellwidth . $show_vertical_separator ?>">
			<div class="spacer">
				<div class="nadpis">
								<h2><?php echo JHTML::link($product->link, $product->product_name); ?></h2>
					<div class="obrazek">
					<?php /** @todo make image popup */
							echo $product->images[0]->displayMediaThumb('class="browseProductImage" border="0" title="'.$product->product_name.'" ',true,'class="modal"');
						?>

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

						<?php if (!VmConfig::get('use_as_catalog')){?>
						<div class="paddingtop8">
							<span class="vmicon vm2-<?php echo $product->stock->stock_level ?>" title="<?php echo $product->stock->stock_tip ?>"></span>
							<span class="stock-level"><?php echo JText::_('COM_VIRTUEMART_STOCK_LEVEL_DISPLAY_TITLE_TIP') ?></span>
						</div>
						<?php }?>
				</div>

<div class="popis">
						<?php // Product Short Description
						if(!empty($product->product_s_desc)) { ?>
						<p class="product_s_desc">
						<?php echo shopFunctionsF::limitStringByWord($product->product_s_desc, 40, '...') ?>
						</p>
						<?php } ?>

					<div class="product-price marginbottom12" id="productPrice<?php echo $product->virtuemart_product_id ?>">
					<?php
					if ($show_prices == '1') {
						if( $product->product_unit && VmConfig::get('vm_price_show_packaging_pricelabel')) {
							echo "<strong>". JText::_('COM_VIRTUEMART_CART_PRICE_PER_UNIT').' ('.$product->product_unit."):</strong>";
						}

						//todo add config settings
						if( $showBasePrice){
							echo $currency->createPriceDiv('basePrice','COM_VIRTUEMART_PRODUCT_BASEPRICE',$product->prices);
							echo $currency->createPriceDiv('basePriceVariant','COM_VIRTUEMART_PRODUCT_BASEPRICE_VARIANT',$product->prices);
						}
						echo $currency->createPriceDiv('variantModification','COM_VIRTUEMART_PRODUCT_VARIANT_MOD',$product->prices);
						echo $currency->createPriceDiv('basePriceWithTax','COM_VIRTUEMART_PRODUCT_BASEPRICE_WITHTAX',$product->prices);
						echo $currency->createPriceDiv('discountedPriceWithoutTax','COM_VIRTUEMART_PRODUCT_DISCOUNTED_PRICE',$product->prices);
						echo $currency->createPriceDiv('salesPriceWithDiscount','COM_VIRTUEMART_PRODUCT_SALESPRICE_WITH_DISCOUNT',$product->prices);
						echo $currency->createPriceDiv('salesPrice','COM_VIRTUEMART_PRODUCT_SALESPRICE',$product->prices);
						echo $currency->createPriceDiv('priceWithoutTax','COM_VIRTUEMART_PRODUCT_SALESPRICE_WITHOUT_TAX',$product->prices);
						echo $currency->createPriceDiv('discountAmount','COM_VIRTUEMART_PRODUCT_DISCOUNT_AMOUNT',$product->prices);
						echo $currency->createPriceDiv('taxAmount','COM_VIRTUEMART_PRODUCT_TAX_AMOUNT',$product->prices);
					} ?>
					</div>


					<div class="addtocart-bar">
						<div class="quantity-controls-add">
							<input type="button" class="quantity-controls quantity-plus" />
						</div>
						<div class="quantity-box">
							<input type="text" class="quantity-input" name="quantity[]" id="quantity_<?php echo $product->virtuemart_product_id ?>" value="1" />
						</div>
						<div class="quantity-controls-remove">
							<input type="button" class="quantity-controls quantity-minus" />
						</div>
						<span class="addtocart-button">
							<?php
							$button_lbl = JText::_('COM_VIRTUEMART_CART_ADD_TO');
							$button_cls = ''; //$button_cls = 'addtocart_button';
							if (VmConfig::get('check_stock') == '1' && !$product->product_in_stock) {
								$button_lbl = JText::_('COM_VIRTUEMART_CART_NOTIFY');
								$button_cls = 'notify-button';
							} 
							?>
							<input type="button" value="<?php echo $button_lbl ?>" title="<?php echo $button_lbl ?>" onclick="addToCart(<?php echo $product->virtuemart_product_id ?>);" />
						</span>
					</div>
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
// Do we need a final closing row tag?
if ($iBrowseCol != 1) { ?>
	<div class="clear"></div>
	</div>
<?php
}
?>	
<div id="bottom-pagination"><?php echo $pagination->getPagesLinks(); ?><div style="text-align:center"><?php echo $pagination->getPagesCounter(); ?></div></div></div>
</div>