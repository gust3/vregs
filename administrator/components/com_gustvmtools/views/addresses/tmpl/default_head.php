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
          <?php echo JHtml::_('grid.sort',  'id_region', 'id_region', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
	<th>
          <?php echo JHtml::_('grid.sort',  'adress', 'adress', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
		<th>
          <?php echo JHtml::_('grid.sort',  'clocks', 'clocks', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
	<th>
          <?php echo JHtml::_('grid.sort',  'published', 'published', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
	<th>
          <?php echo JHtml::_('grid.sort',  'x', 'x', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
	<th>
          <?php echo JHtml::_('grid.sort',  'y', 'y', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
	<th>
          <?php echo JHtml::_('grid.sort',  'url', 'url', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
	<th>
          <?php echo JHtml::_('grid.sort',  'vidacha_zakazov', 'vidacha_zakazov', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
	<th>
          <?php echo JHtml::_('grid.sort',  'dostavka', 'dostavka', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
	<th>
          <?php echo JHtml::_('grid.sort',  'oplata', 'oplata', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
	<th>
          <?php echo JHtml::_('grid.sort',  'label', 'label', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
	<th>
          <?php echo JHtml::_('grid.sort',  'email', 'email', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
	<th>
          <?php echo JHtml::_('grid.sort',  'phones', 'phones', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
</tr>