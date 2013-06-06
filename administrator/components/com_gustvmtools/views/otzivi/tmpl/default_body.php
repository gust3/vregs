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
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&task=save&view=otziv&id='.$item->id); ?>"><?php echo $item->id; ?></a>
        </td>
        <td>
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&task=save&view=otziv&id='.$item->id); ?>"><?php echo $item->product_id; ?></a>
        </td>
		<td>
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&task=save&view=otziv&id='.$item->id); ?>"><?php echo $item->reiting; ?></a>
        </td>
		<td>
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&task=save&view=otziv&id='.$item->id); ?>"><?php echo $item->plusy; ?></a>
        </td>
		<td>
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&task=save&view=otziv&id='.$item->id); ?>"><?php echo $item->minusy; ?></a>
        </td>
		<td align="center">
           <?php echo JHtml::_('jgrid.published', $item->published, $i, '', true, 'cb', null, null); ?>
        </td>
		<td>
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&view=otziv&task=save&id='.$item->id); ?>"><?php echo $item->comment; ?></a>
        </td>
		<td>
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&view=otziv&task=save&id='.$item->id); ?>"><?php echo $item->user; ?></a>
        </td>
    </tr>
<?php endforeach; ?>