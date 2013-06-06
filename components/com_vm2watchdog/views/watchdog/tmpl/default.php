<?php
/*
 * Created on Apr 30, 2012
 *
 * Author: Linelab.org
 * Project: wdog
 */

defined('_JEXEC') or die('Restricted access');


?>
<div class="componentheading"><?php echo JText::_('COM_WM2WATCHDOG_WATCHDOG'); ?></div>
<form action="<?php echo JRoute::_('index.php?option=com_vm2watchdog&view=confirm'); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
	<div class="title"><?php echo $this->item; ?></div>
	<span class="label"><?php echo $this->form->getLabel('email'); ?></span>:&nbsp;<?php echo $this->form->getInput('email'); ?><br />
	<span class="label"><?php echo JText::_('COM_VM2WATCHDOG_WATCH'); ?></span>
	<ul>
		<li><?php echo $this->form->getLabel('price'); ?>:&nbsp;<?php echo $this->form->getInput('price'); ?></li>
	</ul>
	<?php
	if(JFactory::getUser()->get('id')==0) {
		echo $this->form->getLabel('captcha').": ".$this->form->getInput('captcha');
	}
	?>
	<input type="hidden" name="option" value="com_vm2watchdog" />
	<input type="hidden" name="task" value="watchdog.save" />
	<?php echo $this->form->getInput('virtuemart_product_id'); ?>
	<div class="footer">
		<input class="button validate" type="submit" value="<?php echo JText::_('COM_VM2WATCHDOG_SEND'); ?>" />
		<input class="button" type="button" onclick="window.parent.SqueezeBox.close();" value="<?php echo Jtext::_('COM_VM2WATCHDOG_CLOSE'); ?>" />
	</div>
</form>