<?php
defined('_JEXEC') or die;
JHtml::_('behavior.tooltip');
include '../administrator/components/com_gustvmtools/panel.php';
?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col100">
<fieldset class="adminform">
 <?php foreach($this->form->getFieldset() as $field): ?>
 <li><?php echo $field->label; echo $field->input;?></li>
 <?php endforeach; ?>  
</fieldset>
</div>
<input type="hidden" name="option" value="com_gustvmtools" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="address"/>
</form>