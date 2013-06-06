<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;
 
// Загружаем тултипы.
JHtml::_('behavior.tooltip');
include '../administrator/components/com_gustvmtools/panel.php';
?>
<form action="<?php echo JRoute::_('index.php?option=com_gustvmtools&view=shopsinfo'); ?>" method="post" name="adminForm">

<table id="gustVMtools_mag">
	<tr>
		<th></th>
		<th>#</th>
		<th>название</th>
		<th>адрес</th>
		<th>телефон</th>
		<th>label</th>
		<th>email</th>
		<th>enabled</th>
	</tr>
<?php
	foreach ($this->items as $item)
	{
	?>
	<tr>
		<td><input type="checkbox" value="<?php echo $item->id;?>"></td>
		<td><?php echo $item->id;?></td>
		<td><a href="<?php echo JRoute::_('index.php?option=com_gustvmtools&view=shop&id='.$item->id); ?>"><?php echo $item->name;?></a></td>
		<td><?php echo $item->adress?></td>
		<td><?php echo $item->phone?></td>
		<td><?php echo $item->label?></td>
		<td><?php echo $item->email?></td>
		<td><?php echo $item->enabled?></td>
	</tr>
	<?php
	}
	?>
</table>
<?php
echo $this->pagination->getListFooter();
?>
</form>