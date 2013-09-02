<?php
/**
*
* Show the products in a category
*
* @package	VirtueMart
* @subpackage
* @author RolandD
* @author Max Milbers
* @todo add pagination
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: default.php 5120 2011-12-18 18:29:26Z electrocity $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
JHTML::_( 'behavior.modal' );
//JHTML::_('behavior.modal','.details',array('size'=>array('x'=>800,'y'=>800),'handler'=>'iframe'));
require_once JPATH_SITE.DS.'templates'.DS.'skylab'.DS.'tools2.php';
/* javascript for list Slide
  Only here for the order list
  can be changed by the template maker
*/
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
$document->addScript('templates/skylab/js/tabbedContent.js');
?> 
<input type="hidden" name="is_category" id="is_category" value="<?php echo JRequest::getInt('virtuemart_category_id'); ?>" />
<?php
/* Show child categories */

if (( VmConfig::get('showCategory',1) ) &&  (!$this->search)){
	if ($this->category->haschildren) {

		// Category and Columns Counter
		$iCol = 1;
		$iCategory = 1;

		// Calculating Categories Per Row
		$categories_per_row = VmConfig::get ( 'categories_per_row', 3 );
		$category_cellwidth = ' width'.floor ( 100 / $categories_per_row );

		// Separator
		$verticalseparator = " vertical-separator";
		?>

		<div class="category-view">

		<?php // Start the Output
		if(!empty($this->category->children)){
		foreach ( $this->category->children as $category ) {

			// Show the horizontal seperator
			if ($iCol == 1 && $iCategory > $categories_per_row) { ?>
			<div class="horizontal-separator"></div>
			<?php }

			// this is an indicator wether a row needs to be opened or not
			if ($iCol == 1) { ?>
			<div class="row">
			<?php }

			// Show the vertical seperator
			if ($iCategory == $categories_per_row or $iCategory % $categories_per_row == 0) {
				$show_vertical_separator = ' ';
			} else {
				$show_vertical_separator = $verticalseparator;
			}

			// Category Link
			$caturl = JRoute::_ ( 'index.php?option=com_virtuemart&view=category&virtuemart_category_id=' . $category->virtuemart_category_id );

				// Show Category ?>
				<div class="category floatleft<?php echo $category_cellwidth . $show_vertical_separator ?>">
					<div class="spacer">
						<h2>
							<a href="<?php echo $caturl ?>" title="<?php echo $category->category_name ?>">
							<?php echo $category->category_name ?>
							<br />
							<?php // if ($category->ids) {
								echo $category->images[0]->displayMediaThumb("",false);
							//} ?>
							</a>
						</h2>
					</div>
				</div>
			<?php
			$iCategory ++;

		// Do we need to close the current row now?
		if ($iCol == $categories_per_row) { ?>
		<div class="clear"></div>
		</div>
			<?php
			$iCol = 1;
		} else {
			$iCol ++;
		}
	}
	}
	// Do we need a final closing row tag?
	if ($iCol != 1) { ?>
		<div class="clear"></div>
		</div>
	<?php } ?>
</div>
<?php }
}

// Show child categories
if (!empty($this->products)) {
	if (!empty($this->keyword)) {
		?>
		<h3><?php // echo $this->keyword; ?></h3>
		<?php
	}
	?>

<?php // Category and Columns Counter
$iBrowseCol = 1;
$iBrowseProduct = 1;

// Calculating Products Per Row
$BrowseProducts_per_row = $this->perRow;
if(JRequest::getInt('per_row')>0) {
        $BrowseProducts_per_row=JRequest::getInt('per_row');
}
$Browsecellwidth = ' width'.floor ( 100 / $BrowseProducts_per_row );

// Separator
$verticalseparator = " vertical-separator";
?>

<div class="browse-view">
<?php if (!$this->search) { ?>
	<h1>Автомобильные видеорегистраторы <?php echo $this->category->category_name; ?></h1>
<?php
	}
?>
	<div class="category_description">
	<?php echo $this->category->category_description ; ?>
</div>
		<form action="<?php echo JRoute::_('index.php?option=com_virtuemart&view=category&limitstart=0&virtuemart_category_id='.$this->category->virtuemart_category_id ); ?>" method="get">
		<?php if ($this->search) { ?>
		<!--BEGIN Search Box --><div class="virtuemart_search">
		<?php //echo $this->searchcustom ?>
		<?php echo $this->searchcustomvalues ?>
		<input style="height:16px;vertical-align :middle;" name="keyword" class="inputbox" type="text" size="20" value="<?php echo $this->keyword ?>" />
		<input type="submit" value="<?php echo JText::_('COM_VIRTUEMART_SEARCH') ?>" class="button" onclick="this.form.keyword.focus();"/>
		</div>
				<input type="hidden" name="search" value="true" />
				<input type="hidden" name="view" value="category" />


		<!-- End Search Box -->
		<?php } ?>    

<div id="bottom-pagination"><?php //echo $this->vmPagination->getPagesLinks(); ?></div><div style="text-align:center;"><?php// echo $this->vmPagination->getPagesCounter(); ?></div>
		</form>
<div id="product-list-container">
<?php // Start the Output
$db = JFactory::getDBO();
$sr = explode(',', $_COOKIE['vm_sravnenie_value']);
foreach ( $this->products as $product ) {
	
    $query = 'SELECT region FROM #__vmtools_regions_products WHERE product_id = '.$product->virtuemart_product_id." AND region = ".$_COOKIE['region'];
    $db->setQuery($query);
	$rez = $db->loadResult();	
	if (!$rez) continue;
	
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
		<div class="produkt floatleft<?php echo $Browsecellwidth . $show_vertical_separator ?>" action="#">
			<div class="spacer">
				<div class="nadpis" id="nadpis_<?php echo $product->virtuemart_product_id ?>" >
								<h2><?php echo JHTML::link($product->link, $product->product_name); ?></h2>
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
								<input type="button" class="addtocart-button details" value="<?php echo JText::_('перейти в сравнение'); ?>" onclick="goto_sravnenie()"/>
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
					if ($this->show_prices == '1') {

						echo (int) $product->prices['salesPriceTemp']." <span class='rouble' style=\" font-size:16px !important; font-weight:normal;\">e</span>" ;
					
					} 
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
echo "</div>\n";
// Do we need a final closing row tag?
if ($iBrowseCol != 1) { ?>
	<div class="clear"></div>
	</div>
<?php
}
?>
<div id="bottom-pagination"><?php echo $this->vmPagination->getPagesLinks(); ?><div style="text-align:center"><?php echo $this->vmPagination->getPagesCounter(); ?></div></div></div>
<?php } ?>
<!--<div id="product_details" class="product_details" style="display:none"></div>-->
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