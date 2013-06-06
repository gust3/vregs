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
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&task=save&view=product&id='.$item->id); ?>"><?php echo $item->id; ?></a>
        </td>
        <td>
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&task=save&view=product&id='.$item->id); ?>"><?php echo $item->model; ?></a>
        </td>
		<td>
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&task=save&view=product&id='.$item->id); ?>"><?php echo $item->proiz; ?></a>
        </td>
		<td>
            <a href="<?php echo $item->img; ?>" target="_blank"><?php echo $item->img; ?></a>
        </td>
		<td>
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&task=save&view=product&id='.$item->id); ?>"><?php echo $item->price; ?></a>
        </td>
		<td>
            <a target="_blank" href="<?php echo $item->link_to_product;; ?>"><?php echo $item->link_to_product; ?></a>
        </td>
		<td>
            <a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&view=product&task=save&id='.$item->id); ?>"><?php echo $item->desc; ?></a>
        </td>
    </tr>
<?php endforeach; ?>