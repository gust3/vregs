<?php
defined('_JEXEC') or die('Restricted access');
$db =& JFactory::getDBO();
$query = "SELECT vo.review, pc.slug, pc.product_name FROM #__vmtools_opisanie AS vo, #__virtuemart_products_ru_ru as pc WHERE pc.virtuemart_product_id = vo.product_id ORDER BY vo.id DESC LIMIT 5";
$db->setQuery($query);
$products = $db->loadObjectList();
foreach ($products as $k => $product)
{
?>
 <a title="<?php echo $product->product_name;?>" href="<?php echo JRoute::_('obzor/'.$product->slug.".html");?>"></p><?php echo mb_substr($product->review, 0, 96);?>...</p></a>
 <?php
 if ($k < 4)
 {
 ?>
 <hr style="border:0px; height:1px; background:grey;">
 <?php
 }
 ?>
<?php
}
?>
