<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));
JHtml::_('behavior.formvalidation');
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
include '../administrator/components/com_gustvmtools/panel.php'; 
// Загружаем тултипы.
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_gustvmtools&view=otzivi'); ?>" method="post" name="adminForm">
        <fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search">модерация</label>
			<select id="filter_search" name="filter_search">
				<option value="1">премодерация</option>
				<option value="2" <?php if ($this->escape($this->state->get('filter.search')) == 2) echo "selected='selected'";?>>все</option>
			</select>
			<button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
		</div>
		</fieldset>
	<table class="adminlist">
        <thead><?php echo $this->loadTemplate('head');?></thead>
        <tbody><?php echo $this->loadTemplate('body');?></tbody>
        <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
    </table>
<input type="hidden" name="option" value="com_gustvmtools" />
<input type="hidden" name="task" value="otzivi" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="otzivi"/>
<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
<?php echo JHtml::_('form.token'); ?>
</form>