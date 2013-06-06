<?php
defined('_JEXEC') or die('Restricted access');
$doc =& JFactory::getDocument();
$doc->addScriptDeclaration("
function get_cookie ( cookie_name )
	{
	  var results = document.cookie.match ( '(^|;) ?' + cookie_name + '=([^;]*)(;|$)' );
	 
	  if ( results )
		return ( unescape ( results[2] ) );
	  else
		return null;
	}
jQuery(function($){
$(\"#region_change\").val(get_cookie(\"region\"));

$(\"#region_change\").change(function()
{
document.cookie=\"region=\" + $(this).val() + '; path=/';
window.location.reload();
});
});
");
?>
<select id="region_change">
<option value="2">Санкт-Петербург</option>
<option value="213">Москва</option>
</select>