<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;
if (!class_exists ('VmConfig')) {
		require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'helpers' . DS . 'config.php');
	}
	VmConfig::loadConfig ();
//http://video-registratory.com/index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=249&virtuemart_category_id=43
?>
<div style="clear:both;">
		<?php foreach ($this->items as $item) {

        $db = JFactory::getDBO();
        $query = "SELECT virtuemart_category_id FROM #__virtuemart_product_categories WHERE virtuemart_product_id=".$item->id;
        $db->setQuery( $query ); 
        $cat = $db->loadResult();
        ?>
				<div style="width:50%;float:left; margin-top:10px; text-align:center;">
					<iframe width="420" height="315" src="http://www.youtube.com/embed/<?php echo $item->url?>" frameborder="0" allowfullscreen></iframe>
					<p style="text-align:center; width:100%;"><?php echo $item->comment?></p>
                    <b>[<a href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$item->id.'&virtuemart_category_id='.$cat);?>" ><?php echo $item->name;?></a>]</b>
                    <b>[<a href="<?php echo JRoute::_('otzyvy/'.$item->slug.".html");?>" >Отзывы</a>]</b>
                    <b>[<a href="<?php echo JRoute::_('obzor/'.$item->slug.".html");?>" >Обзоры</a>]</b>
                    <b>[<a href="<?php echo JRoute::_('video/'.$item->slug.".html");?>" >Видео</a>]</b>
				</div>
		<?php } ?>
		<div style="clear:both;"></div>
</div>