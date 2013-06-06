<?php
defined('_JEXEC') or die;
JHtml::_('behavior.tooltip');
include '../administrator/components/com_gustvmtools/panel.php';
?>
<form action="index.php" method="post" name="adminForm">
    <fieldset class="adminform">

		
 <?php foreach($this->form->getFieldset() as $field): ?>
 <li><?php echo $field->label; echo $field->input;?></li>
 <?php endforeach; ?>
 
 
    </fieldset>
<input type="hidden" name="option" value="com_gustvmtools" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="1" />
<input type="hidden" name="controller" value="region" />
</form>