<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;
 
// Загружаем тултипы.
JHtml::_('behavior.tooltip');
include '../administrator/components/com_gustvmtools/panel.php';
?>
<form action="index.php" method="post" name="adminForm">
<table>
<tr>
<td>ID магазина:</td><td><?php echo $this->items[0]->id?></td>
</tr>
<tr>
<td>название:</td> <td><input value="<?php echo $this->items[0]->name?>" name="name"></td>
</tr>
<tr>
<td>адрес:</td><td><input value="<?php echo $this->items[0]->adress?>" name="adress"></td>
</tr>
<tr>
<td>телефон:</td><td><input value="<?php echo $this->items[0]->phone?>" name="phone"></td>
</tr>
<tr>
<td>label:</td><td><input value="<?php echo $this->items[0]->label?>" name="label"></td>
</tr>
<tr>
<td>email:</td><td><input value="<?php echo $this->items[0]->email?>" name="email"></td>
</tr>
<tr>
<td>enabled:</td><td><input value="<?php echo $this->items[0]->enabled?>" name="enabled"></td>
</tr>
</table>
<input type="hidden" name="option" value="com_gustvmtools" />
<input type="hidden" name="task" value="apply" />
<input type="hidden" name="boxchecked" value="1" />
<input type="hidden" name="id_shop" value="<?php echo $this->items[0]->id?>" />
<input type="hidden" name="controller" value="shop" />
</form>