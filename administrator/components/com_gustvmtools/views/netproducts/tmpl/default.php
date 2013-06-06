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
<form action="<?php echo JRoute::_('index.php?option=com_gustvmtools&view=netproducts'); ?>" method="post" name="adminForm">
    <fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search">Фильтр по id сети магазинов: </label>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_WEBLINKS_SEARCH_IN_TITLE'); ?>" />
			<button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
		</div>
		<div class="filter-search2 fltlft">
			<label class="filter-search-lbl" for="filter_search2">Фильтр по id: </label>
			<input type="text" name="filter_search2" id="filter_search2" value="<?php echo $this->escape($this->state->get('filter.search2')); ?>" title="<?php echo JText::_('COM_WEBLINKS_SEARCH_IN_TITLE'); ?>" />
			<button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="document.id('filter_search2').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
		</div>
		<div class="filter-search3 fltlft">
			<label class="filter-search-lbl" for="filter_search2">Фильтр по id продукта: </label>
			<input type="text" name="filter_search3" id="filter_search3" value="<?php echo $this->escape($this->state->get('filter.search3')); ?>" title="<?php echo JText::_('COM_WEBLINKS_SEARCH_IN_TITLE'); ?>" />
			<button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="document.id('filter_search3').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
		</div>
	</fieldset>
    <table class="adminlist">
        <thead><?php echo $this->loadTemplate('head');?></thead>
        <tbody><?php echo $this->loadTemplate('body');?></tbody>
        <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
    </table>
<input type="hidden" name="option" value="com_gustvmtools" />
<input type="hidden" name="task" value="netproducts" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="netproducts"/>
<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
<?php echo JHtml::_('form.token'); ?>
</form>