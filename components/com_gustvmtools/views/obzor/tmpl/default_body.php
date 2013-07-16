<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;
if (!class_exists ('VmConfig')) {
		require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'helpers' . DS . 'config.php');
	}
	VmConfig::loadConfig ();
?>
<div style="clear:both;">
		<?php foreach ($this->items as $k=>$item) {
            $db = JFactory::getDBO();
            $query = "SELECT virtuemart_category_id FROM #__virtuemart_product_categories WHERE virtuemart_product_id=".$item->product_id;
            $db->setQuery( $query ); 
            $cat = $db->loadResult();
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
				<div class="border_contacts <? echo $c; ?>" style="text-align:left;">
					<a href="<?php echo JRoute::_('obzor/'.$item->slug.".html");?>" title="<?php echo $item->product_name?>"><b><?php echo $item->product_name?></b></a><br>
					<p style="width:100%;" class="mini-obzor-text">
                    
                    <?php 
                     if (mb_strlen($item->text) > 220)
                        {                    
                            echo mb_substr($item->text, 0, 220)."..";
                        }
                    else
                        {
                            echo $item->text;
                        }
                    ?>                    
                    </p>
					<b>[<a href="<?php echo JRoute::_('obzor/'.$item->slug.".html");?>" >обзор полностью</a>]</b>
					<b title="<?php echo $item->product_name;?>">[<a href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$item->product_id.'&virtuemart_category_id='.$cat);?>" ><?php 
                      if (strlen($item->product_name) > 20)
                        {
                            echo substr($item->product_name, 0, 20)."..";
                        }
                        else
                        {
                            echo $item->product_name;
                        }                     
                    ?>
                    
                    
                    </a>]</b>
                    <b>[<a href="<?php echo JRoute::_('otzyvy/'.$item->slug.".html");?>" >Отзывы</a>]</b>
                    <b>[<a href="<?php echo JRoute::_('video/'.$item->slug.".html");?>" >Видео</a>]</b>
                    <p style="clear:both"></p>
				</div>
		<?php } ?>
		<div style="clear:both;"></div>
</div>