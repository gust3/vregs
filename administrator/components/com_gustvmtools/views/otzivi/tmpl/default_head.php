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
          <?php echo JHtml::_('grid.sort',  'product_id', 'product_id', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
	<th>
         <?php echo JHtml::_('grid.sort',  'reiting', 'reiting', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
	<th>
          <?php echo JHtml::_('grid.sort',  'plusy', 'plusy', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
	<th>
         <?php echo JHtml::_('grid.sort',  'minusy', 'minusy', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
	<th>
         <?php echo JHtml::_('grid.sort',  'published', 'published', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
	<th>
         <?php echo JHtml::_('grid.sort',  'comment', 'comment', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
	<th>
         <?php echo JHtml::_('grid.sort',  'user', 'user', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
</tr>