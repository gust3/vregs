<?php
defined('_JEXEC') or die('Restricted access');

if (!class_exists( 'mod_virtuemart_product' )) require('helper.php');
$productModel = VmModel::getModel('Product');

//читаем материалы

$config = & JFactory::getConfig();
$document =& JFactory::getDocument();
$document->addStyleSheet(JURI::root(true).'/modules/mod_gust_slider/gust_slider.css');
$db=& JFactory::getDBO();


if ($params->get('slidefrom') == 1)
{
//получаем все материалы
$q='SELECT id, introtext, alias, title FROM '.$config->getValue('dbprefix').'content WHERE catid = '.$params->get('id_category');
$db->setQuery($q);
$data_row = $db->loadObjectList();
for ($i=0;$i<count($data_row);$i++)
{
$str = $data_row[$i]->introtext;
preg_match_all('|<product_id.*?>(.*)</product_id>|sei', $str, $matches);
$products[] = $matches[1][0];
preg_match_all('|<new.*?>(.*)</new>|sei', $str, $matches);
$yes[] = $matches[1][0];
};

}
else
{
$q='SELECT virtuemart_product_id, product_new FROM '.$config->getValue('dbprefix').'virtuemart_products WHERE product_slider = 1';
$db->setQuery($q);
$data_row = $db->loadObjectList();
for ($i=0;$i<count($data_row);$i++)
{
$products[] = $data_row[$i]->virtuemart_product_id;
$yes[] = $data_row[$i]->product_new;
};
}
?>
<div class="gust_slider">
	<div class="container_slider">
		<?php
		for ($i=0; $i<count($products); $i++){
			if ($i == 0){ 
				$s = "display:block;"; 
			} 
			else{ 
				$s = "display:none;";         
			} 	
		$got_product = $productModel->getProductSingle($products[$i]);
		$productModel->addImages($got_product);
		
        
        list($width, $height) = @getimagesize($got_product->images[0]->file_url);
        
        if ($height > 150)
        {
            $width_will = (int)($width*150)/$height;
            if ($width_will > 190)
            {
                $height_will = (int)($height*190)/$width;
                $width_will = 190;
                $margin_top = 150 - $height_will;
            }            
        }
        else
        {
            if ($width > 190)
            {
                $width_will = 190;
                $height_will = (int)($height*190)/$width;
                $margin_top = 150 - $height_will;
            }
            else
            {
                $width_will = $will;
                $height_will = $height;
                $margin_top = 150 - $height_will;
            }
        }     
        
        ?>       
		<div num="<?php echo $i;?>" class="slide_gust" style="<?php echo $s ?>">
			<a href="<?php echo $got_product->link?>"><img height="<?php echo $height_will;?>" width="<?php echo $width_will;?>"  src="<?php echo $got_product->images[0]->file_url?>" alt="<?php echo $got_product->product_name?>" style="margin-top:<?php echo $margin_top?>px;" title="<?php echo $got_product->product_name?>"></a>
			<a href="<?php echo $got_product->link?>"><span class="title_product"><?php echo $got_product->product_name?></span></a>
			<div class="product_props">
			<?php $j=0;
			echo $got_product->product_s_desc;
			?>
			</div>
			<?php if (($yes[$i] == "yes") || ($yes[$i] == "1")) {?>
			<div class="new_lenta"></div>
			<?php } ?>
			<span class="price_container_product">всего за <span class="product_price"><?php echo (int) $got_product->product_price?></span> рублей</span>
			<a href="<?php echo $got_product->link?>"><div class="button">подробнее</div></a>
		</div>			
			<?php
			}
			?>
	</div>
<div style="clear: both; height:0px;">&nbsp;</div>
</div>
<script>

jQuery(function(){
posibble_to_rotate = 1;
n_max = <?php echo count($products)?>;
    function slide(){
	  if (posibble_to_rotate == 1){
        n = jQuery(".slide_gust:visible").attr("num");
        n = parseInt(n);
		if (n == (n_max-1)){
          n = 0;
        }
        else{
          n = n + 1;
        }		
        jQuery(".slide_gust:visible").hide(1000);
		jQuery(".slider_contol .active").removeClass('active');
        jQuery("li[num="+n+"]", ".slider_contol").addClass('active');
		jQuery(".slide_gust[num="+n+"]").show(1000);
       }
    };	
	<?php if ($params->get('autoslide') == 0){?>
	setTimeout(rotate, <?php echo $params->get('time')?>);
	<?php	}	?>
    function rotate() { 
	  slide();
      setTimeout(rotate, 4000);
    }

});
</script>