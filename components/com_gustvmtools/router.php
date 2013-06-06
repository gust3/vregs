<?php
if(  !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
function check()
{
	$this->alias = "";
    return true;
}
function gustvmtoolsParseRoute($segments)
{
    $vars = array();
    if ((count($segments)) == 2)
    {
            $vars['view'] = 'contact';
			$vars['option'] = 'com_gustvmtools';
			$vars['id'] = $segments[1];
			$vars['layout'] = $segments[0];
    }
    return $vars;
}
function gustvmtoolsBuildRoute(&$query)
{
	$segments = array();
	
	unset($query['view']);
	
	if ($query['layout']) 
	{
		$segments[] = $query['layout'];
		unset($query['layout']);
	}
	if ($query['id']) 
	{
		$segments[] = $query['id'];
		unset($query['id']);
	}
	return $segments;
}
?>