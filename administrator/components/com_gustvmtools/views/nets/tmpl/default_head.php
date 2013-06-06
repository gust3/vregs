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
          <?php echo JHtml::_('grid.sort',  'ymname', 'ymname', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
	<th>
         <?php echo JHtml::_('grid.sort',  'label', 'label', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
	<th>
          <?php echo JHtml::_('grid.sort',  'email', 'email', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
	<th>
         <?php echo JHtml::_('grid.sort',  'phone', 'phone', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
	<th>
         <?php echo JHtml::_('grid.sort',  'published', 'published', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
	<th>
         <?php echo JHtml::_('grid.sort',  'url', 'url', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
	<th>
         <?php echo JHtml::_('grid.sort',  'dostavka', 'dostavka', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
</tr>