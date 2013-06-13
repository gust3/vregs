<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;
?>
<div style="clear:both;">
		<?php 
        $i = 0;
        foreach ($this->items as $k => $item) {
		if (!$item->label) $item->label = $item->ymname;
		switch ($i)
        {
            case 0:$c = "odd";break;
            case 1:$c = "noodd";break;
            case 2:$c = "noodd";break;
            case 3:$c = "odd";break;
            case 4:$c = "odd";break;
        }
        $i++;
        if ($i == 4) $i = 0;
        ?>
				<div class="border_contacts <? echo $c; ?>" >
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