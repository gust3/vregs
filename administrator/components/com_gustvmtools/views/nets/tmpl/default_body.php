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
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&task=save&view=net&id='.$item->id); ?>"><?php echo $item->id; ?></a>
			<a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&task=adresses&view=addresses').'&id_net='.$item->id;?>">[адреса сети]</a>
        </td>
        <td>
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&task=save&view=net&id='.$item->id); ?>"><?php echo $item->ymname; ?></a>
        </td>
		<td>
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&task=save&view=net&id='.$item->id); ?>"><?php echo $item->label; ?></a>
        </td>
		<td>
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&task=save&view=net&id='.$item->id); ?>"><?php echo $item->email; ?></a>
        </td>
		<td>
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&task=save&view=net&id='.$item->id); ?>"><?php echo $item->phone; ?></a>
        </td>
		<td align="center">
           <?php echo JHtml::_('jgrid.published', $item->published, $i, '', true, 'cb', null, null); ?>
        </td>
		<td>
            <a href="<?php echo $item->url; ?>"><?php echo $item->url; ?></a>
        </td>
		<td>
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&view=net&task=save&id='.$item->id); ?>"><?php echo $item->dostavka; ?></a>
        </td>
    </tr>
<?php endforeach; ?>