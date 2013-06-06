<?php

/**
 * @version		$Id: default.php 15 2009-11-02 18:37:15Z chdemko $
 * @package		Joomla16.Tutorials
 * @subpackage	Components
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @author		Christophe Demko
 * @link		http://joomlacode.org/gf/project/helloworld_1_6/
 * @license		License GNU General Public License version 2 or later
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
if ($this->arr)
{
if (count($this->arr) > 3){
	$this->arr = array_slice($this->arr, count($this->arr) - 3, count($this->arr));
}
unset($arr_customs);

for ($i=0;$i<count($this->arr);$i++)
{
	foreach ($this->arr[$i]->customfields as $item)
	{
		if (($item->display <> "ZAG"))
		{
			$arr_customs[] = $item->custom_title;
		}
	}
}
$arr_customs = array_unique($arr_customs);                                          
?>
<table id="sravnenie">
<tr>
	<td style="width:25%"></td>	
	<?php
	$i = 0;
	foreach ($this->arr as $value)
	{
	$i++;
	?>
		<th style="width:25%" class="<?php echo "col-sr".$i?>">
		<div style="height:150px;">
			<a href="<?php echo JURI::root(true).$value->link;?>"><img src="<?php echo JURI::root(true).$value->images[0]->file_url_thumb?>" alt="<?php echo $value->product_name?>" ></a>
		</div>
			<br>
			<a href="<?php echo JURI::root(true).$value->link;?>" style="display:block; height:40px; padding:10px;"><b><?php echo $value->product_name?></b></a>
			<div class="delete-sr" p_id="<?php echo $value->virtuemart_product_id?>">удалить</div>
		</th>
	<?php
	}	
	?>	
</tr>
<?php 
foreach ($arr_customs as $item)
{
?>
<tr>
	<td style="width:25%"><b><?php echo $item;?></b></td>	
	<?php
	$i = 0;
	foreach ($this->arr as $value)
	{
	$i++;
	?>
		<td class="<?php echo "col-sr".$i?>" style="width:25%">
		<?php
			foreach ($value->customfields as $cf)
			{
				if (($cf->custom_title ==  $item) && ($cf->display != "ZAG"))
				{
					echo $cf->custom_value;
					break;
				}
			}
		?>
		</td>
	<?php
	}	
	?>	
</tr>
<?php
}
?>
</table>
<script>
function get_cookie ( cookie_name )
	{
	  var results = document.cookie.match ( '(^|;) ?' + cookie_name + '=([^;]*)(;|$)' );
	 
	  if ( results )
		return ( unescape ( results[2] ) );
	  else
		return null;
	}
function array_unique(arr) {
		var tmp_arr = new Array();
			for (i = 0; i < arr.length; i++) {
				if (tmp_arr.indexOf(arr[i]) == "-1") {
					tmp_arr.push(arr[i]);
				}
			}
		return tmp_arr;
	}
	
jQuery(function($){
$('.delete-sr').click(function(){
	s = $(this).parent().attr('class');
	$("." + s).hide();
	myVar = get_cookie("vm_sravnenie_value");
	var simpleArray = myVar.split(",");
	simpleArray2 = array_unique(simpleArray);	
	p_id = $(this).attr('p_id');
	simpleArray3 = [];	
	for (i=0; i< simpleArray2.length; i++) 
	{	
		if (simpleArray2[i] != p_id) 
		{
			simpleArray3.push(simpleArray2[i]);
		}
	}
	value = simpleArray3.join(',');
	document.cookie="vm_sravnenie_value=" + value;

});
});
</script>
<?php
}
else
{
?>
нет товаров для сравнения
<?php
}
?>