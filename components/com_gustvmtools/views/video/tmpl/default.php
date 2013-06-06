<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));
JHtml::_('behavior.formvalidation');
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
// Загружаем тултипы.
?>
<form action="<?php echo JRoute::_('index.php?option=com_gustvmtools&view=video'); ?>" method="post" name="adminForm">
    <?php echo $this->loadTemplate('head');?>
    <?php echo $this->loadTemplate('body');?>
    <?php echo $this->loadTemplate('foot');?>
<input type="hidden" name="option" value="com_gustvmtools" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="video"/>
<?php echo JHtml::_('form.token'); ?>
</form>
