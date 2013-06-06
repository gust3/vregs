<?php
defined('_JEXEC') or die;
JHtml::_('behavior.tooltip');
include '../administrator/components/com_gustvmtools/panel.php';
?>
<form action="index.php" method="post" name="adminForm">

нажмите сохранить чтобы получить все адреса магазинов для указанных, сетей. Осторожно, начнется парсинг товаров из яндекс маркета. <b class="red">Не нажимать сохранить если вы не уверены.</b>

<input type="hidden" name="option" value="com_gustvmtools" />
<input type="hidden" name="task" value="gotadresses" />
<input type="hidden" name="controller" value="gotadresses" />
</form>