<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;
if (!class_exists ('VmConfig')) {
		require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'helpers' . DS . 'config.php');
	}
	VmConfig::loadConfig ();
$productModel = VmModel::getModel('Product');
$p = $productModel->getProductSingle($product->id);
?>
<div style="clear:both;">
		<?php foreach ($this->items as $item) {
		$p = $productModel->getProductSingle($item->product_id);
		?>
				<div style="width:50%;float:left; margin-top:10px; text-align:center;">
					<iframe width="420" height="315" src="http://www.youtube.com/embed/<?php echo $item->url?>" frameborder="0" allowfullscreen></iframe>
					<p style="text-align:center; width:100%;"><b><a href="<?php echo JRoute::_($p->canonical);?>" ><?php echo JRoute::_($p->model);?></a><br></b><?php echo $item->comment?></p>
				</div>
		<?php } ?>
		<div style="clear:both;"></div>
</div>