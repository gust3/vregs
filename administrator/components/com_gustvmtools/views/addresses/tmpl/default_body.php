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
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&task=save&view=address&id='.$item->id); ?>"><?php echo $item->id; ?></a>
        </td>
        <td>
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&task=save&view=address&id='.$item->id); ?>"><?php echo $item->id_net; ?></a>
			<a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&task=save&view=net&id='.$item->id_net); ?>">[сеть]</a>
        </td>
		<td>
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&task=save&view=address&id='.$item->id); ?>"><?php echo $item->id_region; ?></a>
        </td>
		<td>
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&task=save&view=address&id='.$item->id); ?>"><?php echo $item->adress; ?></a>
        </td>
		<td>
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&task=save&view=address&id='.$item->id); ?>"><?php echo $item->clocks; ?></a>
        </td>
		<td align="center">
           <?php echo JHtml::_('jgrid.published', $item->published, $i, '', true, 'cb', null, null); ?>
        </td>
		<td>
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&view=address&task=save&id='.$item->id); ?>"><?php echo $item->x; ?></a>
        </td>
		<td>
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&view=address&task=save&id='.$item->id); ?>"><?php echo $item->y; ?></a>
        </td>
		<td>
            <a href="<?php echo $item->url; ?>" target="_blanc"><?php echo $item->url; ?></a>
        </td>
		<td>
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&view=address&task=save&id='.$item->id); ?>"><?php echo $item->vidacha_zakazov; ?></a>
        </td>
		<td>
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&view=address&task=save&id='.$item->id); ?>"><?php echo $item->dostavka; ?></a>
        </td>
		<td>
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&view=address&task=save&id='.$item->id); ?>"><?php echo $item->oplata; ?></a>
        </td>
		<td>
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&view=address&task=save&id='.$item->id); ?>"><?php echo $item->label; ?></a>
        </td>
		<td>
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&view=address&task=save&id='.$item->id); ?>"><?php echo $item->email; ?></a>
        </td>
		<td>
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&view=address&task=save&id='.$item->id); ?>"><?php echo $item->phones; ?></a>
        </td>
    </tr>
<?php endforeach; ?>