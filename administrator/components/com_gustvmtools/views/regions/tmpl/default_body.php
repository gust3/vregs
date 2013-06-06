<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;
foreach ($this->items as $i => $item): ?>
    <tr class="row<?php echo $i % 2; ?>">
        <td>
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&view=region&task=save&id='.$item->id); ?>"><?php echo $item->id; ?></a>
        </td>
        <td>
            <?php echo JHtml::_('grid.id', $i, $item->id); ?>
        </td>
        <td>
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&view=region&task=save&id='.$item->id); ?>"><?php echo $item->id_region; ?></a>
        </td>
		<td>
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&view=region&task=save&id='.$item->id); ?>"><?php echo $item->label; ?></a>
        </td>
		<td>
            <?php echo $item->sctx; ?>
        </td>
		<td>
            <?php echo $item->x; ?>
        </td>
		<td>
            <?php echo $item->y; ?>
        </td>
    </tr>
<?php endforeach; ?>