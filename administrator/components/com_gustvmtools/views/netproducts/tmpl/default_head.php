<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;
?>
<tr>
    <th width="20">
        <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
    </th>
	<th>
          <?php echo JHtml::_('grid.sort',  'id', 'id', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
	<th>
          <?php echo JHtml::_('grid.sort',  'id_net', 'id_net', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
	<th>
         <?php echo JHtml::_('grid.sort',  'price', 'price', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
	<th>
          <?php echo JHtml::_('grid.sort',  'id_product', 'id_product', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
	<th>
         <?php echo JHtml::_('grid.sort',  'published', 'published', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
</tr>