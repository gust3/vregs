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
          <?php echo JHtml::_('grid.sort',  'model', 'model', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
	<th>
         <?php echo JHtml::_('grid.sort',  'proiz', 'proiz', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
	<th>
          <?php echo JHtml::_('grid.sort',  'img', 'img', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
	<th>
         <?php echo JHtml::_('grid.sort',  'price', 'price', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
	<th>
         <?php echo JHtml::_('grid.sort',  'link_to_product', 'link_to_product', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
	<th>
         <?php echo JHtml::_('grid.sort',  'desc', 'desc', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
</tr>