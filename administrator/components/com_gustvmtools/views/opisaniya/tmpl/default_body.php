<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;
foreach ($this->items as $i => $item): 
?>
   <tr class="row<?php echo $i % 2; ?>">       
        <td>
            <?php echo JHtml::_('grid.id', $i, $item->id); ?>
        </td>
		<td>
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&task=save&view=opisanie&id='.$item->id); ?>"><?php echo $item->id; ?></a>
        </td>
        <td>
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&task=save&view=opisanie&id='.$item->id); ?>"><?php echo $item->product_id; ?></a>
        </td>
		<td>
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&task=save&view=opisanie&id='.$item->id); ?>"><?php echo $item->review; ?></a>
        </td>
		<td align="center">
           <?php echo JHtml::_('jgrid.published', $item->published, $i, '', true, 'cb', null, null); ?>
        </td>
    </tr>
<?php endforeach; ?>