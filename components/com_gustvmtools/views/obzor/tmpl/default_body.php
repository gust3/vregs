<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;
if (!class_exists ('VmConfig')) {
		require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'helpers' . DS . 'config.php');
	}
	VmConfig::loadConfig ();
$productModel = VmModel::getModel('Product');
?>
<div style="clear:both;">
		<?php foreach ($this->items as $k=>$item) {
		$p = $productModel->getProductSingle($item->product_id);
		$p_a = explode('/', $p->link);
		?>
				<div class="border_contacts <? echo $k & 1 ? 'odd' : 'noodd'?>" style="text-align:left;">
					<a href="<?php echo $p->link?>" title="<?php echo $item->product_name?>"><b><?php echo $item->product_name?></b></a><br>
					<p style="width:100%;"><?php echo $item->text?></p>
					<a href="/obzor/<?php echo $p_a[count($p_a) - 1];?>" style="float:right">обзор полностью</a>
					<p style="clear:both"></p>
				</div>
		<?php } ?>
		<div style="clear:both;"></div>
</div>