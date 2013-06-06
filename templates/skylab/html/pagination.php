<?php
/**
 * @version		$Id: pagination.php 9764 2007-12-30 07:48:11Z ircmaxell $
 * @package		Joomla
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
/**
 * This is a file to add template specific chrome to pagination rendering.
 *
 * pagination_list_footer
 * 	Input variable $list is an array with offsets:
 * 		$list[limit]		: int
 * 		$list[limitstart]	: int
 * 		$list[total]		: int
 * 		$list[limitfield]	: string
 * 		$list[pagescounter]	: string
 * 		$list[pageslinks]	: string
 *
 * pagination_list_render
 * 	Input variable $list is an array with offsets:
 * 		$list[all]
 * 			[data]		: string
 * 			[active]	: boolean
 * 		$list[start]
 * 			[data]		: string
 * 			[active]	: boolean
 * 		$list[previous]
 * 			[data]		: string
 * 			[active]	: boolean
 * 		$list[next]
 * 			[data]		: string
 * 			[active]	: boolean
 * 		$list[end]
 * 			[data]		: string
 * 			[active]	: boolean
 * 		$list[pages]
 * 			[{PAGE}][data]		: string
 * 			[{PAGE}][active]	: boolean
 *
 * pagination_item_active
 * 	Input variable $item is an object with fields:
 * 		$item->base	: integer
 * 		$item->link	: string
 * 		$item->text	: string
 *
 * pagination_item_inactive
 * 	Input variable $item is an object with fields:
 * 		$item->base	: integer
 * 		$item->link	: string
 * 		$item->text	: string
 *
 * This gives template designers ultimate control over how pagination is rendered.
 *
 * NOTE: If you override pagination_item_active OR pagination_item_inactive you MUST override them both
 */
 
function pagination_list_footer($list)
{
	if(JRequest::getCmd('option')=='com_virtuemart') {
		$uri=JFactory::getURI();
		$uri->delVar('type');
		$uri->delVar('limitstart');
		$uri->delVar('limit');
		
		$list['limitfield']=str_replace('onchange="this.form.submit()"','onchange="loadContent(\''.JFactory::getURI()->toString().'&type=raw&limitstart=0&limit=\'+this.value);"',$list['limitfield']);
	}
	// Initialize variables
	$lang =& JFactory::getLanguage();
	$html = "<div class=\"list-footer\">\n";
	if ($lang->isRTL())
	{
		$html .= "\n<div class=\"counter\">".$list['pagescounter']."</div>";
		$html .= $list['pageslinks'];
		$html .= "\n<div class=\"limit\">".JText::_('кол-во:').$list['limitfield']."</div>";
	}
	else
	{
		$html .= "\n<div class=\"limit\">".JText::_('кол-во:').$list['limitfield']."</div>";
		$html .= $list['pageslinks'];
		$html .= "\n<div class=\"counter\">".$list['pagescounter']."</div>";
	}
	$html .= "\n<input type=\"hidden\" name=\"limitstart\" value=\"".$list['limitstart']."\" />";
	$html .= "\n</div>";
	return $html;
}
function pagination_list_render($list)
{
	// Initialize variables
	$lang =& JFactory::getLanguage();
	$html = "<div class=\"pagination\">";
	// Reverse output rendering for right-to-left display
	if($lang->isRTL())
	{
		$html .= '&laquo; '.$list['start']['data'];
		$html .= '&nbsp;'.$list['previous']['data'];
		$list['pages'] = array_reverse( $list['pages'] );
		foreach( $list['pages'] as $page ) {
			if($page['data']['active']) {
				$html .= '<strong>';
			}
			$html .= '&nbsp;'.$page['data'];
			if($page['data']['active']) {
				$html .= '</strong>';
			}
		}
		$html .= '&nbsp;'.$list['next']['data'];
		$html .= '&nbsp;'.$list['end']['data'];
		$html .= ' &raquo;';
	}
	else
	{
		$html .= '&laquo; '.$list['start']['data'];
		$html .= $list['previous']['data'];
		foreach( $list['pages'] as $page )
		{
			if($page['data']['active']) {
				$html .= '<strong>';
			}
			$html .= $page['data'];
			if($page['data']['active']) {
				$html .= '</strong>';
			}
		}
		$html .= $list['next']['data'];
		$html .= $list['end']['data'];
		$html .= ' &raquo;';
	}
	$html .= "</div>";
	return $html;
}

function pagination_item_active(&$item) {
    if(JRequest::getVar('results')=='get_results') {
	return '<a href="javascript:void(0);" onclick=loadContent("'.$item->link.'",\'results=get_results&\'+document.getElementById(\'vm2_search\').toQueryString()+\'&mod_search[price][from]=\'+document.getElementById(\'price_from\').options[document.getElementById(\'price_from\').selectedIndex].value+\'&mod_search[price][to]=\'+document.getElementById(\'price_to\').options[document.getElementById(\'price_to\').selectedIndex].value); title="'.$item->text.'">'.$item->text.'</a>';
    } else if(JRequest::getVar('option')=='com_virtuemart') {
	return '<a href="javascript:void(0);" onclick=loadContent("'.$item->link.'","type=raw"); title="'.$item->text.'">'.$item->text.'</a>';
    } else {
	return "<a href=\"".$item->link."\" title=\"".$item->text."\">".$item->text."</a>";
    }
}

function pagination_item_inactive(&$item) {
	return "<span>".$item->text."</span>";
}
?>
