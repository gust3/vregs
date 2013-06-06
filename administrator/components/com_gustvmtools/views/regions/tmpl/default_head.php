<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;
?>
<tr>
    <th width="5">
        <?php echo "id"; ?>
    </th>
    <th width="20">
        <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
    </th>
    <th>
         <?php echo JHtml::_('grid.sort',  'id_region', 'id_region', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
		
    </th>
	<th>
          <?php 
		/*  $title, $order, $direction = 'asc', $selected = 0, $task = null, $new_direction = 'asc'*/
		  
		  echo JHtml::_('grid.sort',  'label', 'label', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?>
    </th>
	<th>sctx</th>
	<th>x</th>
	<th>y</th>
</tr>