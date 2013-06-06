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
<form action="<?php echo JRoute::_('index.php?option=com_gustvmtools&view=videos'); ?>" method="post" name="adminForm">
    <table class="adminlist">
        <thead><?php echo $this->loadTemplate('head');?></thead>
        <tbody><?php echo $this->loadTemplate('body');?></tbody>
        <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
    </table>
<input type="hidden" name="option" value="com_gustvmtools" />
<input type="hidden" name="task" value="videos" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="videos"/>
<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
<?php echo JHtml::_('form.token'); ?>
</form>