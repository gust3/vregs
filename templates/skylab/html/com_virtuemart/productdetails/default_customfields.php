<?php
/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers, Valerie Isaksen

 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default_customfields.php 5699 2012-03-22 08:26:48Z ondrejspilka $
 */

// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );
?>
<div class="product-fields">
		<ul>
		<?php
	    $custom_title = null;
	    foreach ($this->product->customfieldsSorted[$this->position] as $field) {
		
		if ($field->display <> "ZAG")
		{
	    	?>
			<li class="points">
					<span class="point_title">
					<?php
						echo JText::_($field->custom_title);
					?>
					</span>
					<span class="point_desc"><?php echo $field->display ?></span>
					<div style="clear:both"></div>
			</li>
			<?php
			
	    }
		else
		{
		?>

		<li><h3><?php echo JText::_($field->custom_title); ?></h3></li>
		<?php
		}
		}
	    ?>
		</ul>		
</div>