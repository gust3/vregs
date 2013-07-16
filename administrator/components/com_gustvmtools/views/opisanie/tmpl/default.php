<?php
defined('_JEXEC') or die;
JHtml::_('behavior.tooltip');
include '../administrator/components/com_gustvmtools/panel.php';
?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col100">
    <fieldset class="adminform">

		
 <?php foreach($this->form->getFieldset() as $field): ?>
 <div style="margin-bottom:10px; clear:both;"><?php echo $field->name; echo '<br><div>'.$field->input."</div>";?></div></br>
 <?php endforeach; ?>
 
 
    </fieldset>
</div>
<input type="hidden" name="option" value="com_gustvmtools" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="opisanie" />
</form>