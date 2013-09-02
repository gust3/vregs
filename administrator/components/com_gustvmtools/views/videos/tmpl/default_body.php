<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;
$db =& JFactory::getDBO();
foreach ($this->items as $i => $item): 
$query = "SELECT model FROM #__vmtools_products WHERE id=".$item->product_id;
$db->setQuery($query);	
$name = $db->loadresult();
?>
   <tr class="row<?php echo $i % 2; ?>">       
        <td>
            <?php echo JHtml::_('grid.id', $i, $item->id); ?>
        </td>
		<td>
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&task=save&view=video&id='.$item->id); ?>"><?php echo $item->id; ?></a>
        </td>
        <td>
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&task=save&view=video&id='.$item->id); ?>"><?php echo $item->product_id; ?></a> (<?php echo $name;?>)
        </td>
		<td>
			<a href="http://www.youtube.com/embed/<?php echo $item->url;?>" title="<?php echo $item->comment?>"><?php echo "http://www.youtube.com/embed/".$item->url; ?></a>
			
        </td>
		<td align="center">
           <?php echo JHtml::_('jgrid.published', $item->published, $i, '', true, 'cb', null, null); ?>
        </td>
  </tr>
<?php endforeach; ?>