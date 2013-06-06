<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;
?>
<div style="clear:both;">
		<?php foreach ($this->items as $k => $item) {
		if (!$item->label) $item->label = $item->ymname;
		?>
				<div class="border_contacts <? echo $k & 1 ? 'odd' : 'noodd'?>" >
					<a href="<?php echo JRoute::_("index.php?view=contact&id=".$item->id."&layout=adresses");?>" title="<?php echo str_replace("'", "", $item->label)?>"><b><?php echo str_replace("'", "", $item->label)?></b></a><br>
					<?php
						$s='';
						$array_info = null;
						if ($item->email) $array_info[] = $item->email;
						if ($item->phone) $array_info[] = $item->phone;
						if ($item->url) $array_info[] = $item->url;
						if ($array_info) $s=implode(" : ", $array_info);
					?>
				<?php echo $s ?>
				</div>
		<?php } ?>
		<div style="clear:both;"></div>
</div>