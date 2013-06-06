<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

/**
 * @package		Joomla.Site
 * @subpackage	mod_menulinelab
 * @since		1.5
 */
class modMenuLinelabHelper
{
	/**
	 * Get a list of the menu items.
	 *
	 * @param	JRegistry	$params	The module options.
	 *
	 * @return	array
	 * @since	1.5
	 */
	static function getList(&$params)
	{
		$app = JFactory::getApplication();
		$menu = $app->getMenu();

		// If no active menu, use default
		$active = ($menu->getActive()) ? $menu->getActive() : $menu->getDefault();

		$user = JFactory::getUser();
		$levels = $user->getAuthorisedViewLevels();
		asort($levels);
		$key = 'menu_items'.$params.implode(',', $levels).'.'.$active->id;
		$cache = JFactory::getCache('mod_menulinelab', '');
		if (!($items = $cache->get($key)))
		{
			// Initialise variables.
			$list		= array();
			$db			= JFactory::getDbo();

			$path		= $active->tree;
			$start		= (int) $params->get('startLevel');
			$end		= (int) $params->get('endLevel');
			$showAll	= $params->get('showAllChildren');
			$items 		= $menu->getItems('menutype', $params->get('menutype'));

			$category_list = self::getCategoryTreeArray();

			$lastitem	= 0;

			if ($items) {
				foreach($items as $i => $item)
				{
					if (($start && $start > $item->level)
						|| ($end && $item->level > $end)
						|| (!$showAll && $item->level > 1 && !in_array($item->parent_id, $path))
						|| ($start > 1 && !in_array($item->tree[$start-2], $path))
					) {
						unset($items[$i]);
						continue;
					}

					$item->deeper = false;
					$item->shallower = false;
					$item->level_diff = 0;

					if (isset($items[$lastitem])) {
						$items[$lastitem]->deeper		= ($item->level > $items[$lastitem]->level);
						$items[$lastitem]->shallower	= ($item->level < $items[$lastitem]->level);
						$items[$lastitem]->level_diff	= ($items[$lastitem]->level - $item->level);
					}

					$item->parent = (boolean) $menu->getItems('parent_id', (int) $item->id, true);

					$lastitem			= $i;
					$item->active		= false;
					$item->flink = $item->link;

					switch ($item->type)
					{
						case 'separator':
							// No further action needed.
							continue;

						case 'url':
							if ((strpos($item->link, 'index.php?') === 0) && (strpos($item->link, 'Itemid=') === false)) {
								// If this is an internal Joomla link, ensure the Itemid is set.
								$item->flink = $item->link.'&Itemid='.$item->id;
							}
							break;

						case 'alias':
							// If this is an alias use the item id stored in the parameters to make the link.
							$item->flink = 'index.php?Itemid='.$item->params->get('aliasoptions');
							break;

						default:
							$router = JSite::getRouter();
							if ($router->getMode() == JROUTER_MODE_SEF) {
								$item->flink = 'index.php?Itemid='.$item->id;
							}
							else {
								$item->flink .= '&Itemid='.$item->id;
							}
							break;
					}

					if (strcasecmp(substr($item->flink, 0, 4), 'http') && (strpos($item->flink, 'index.php?') !== false)) {
						$item->flink = JRoute::_($item->flink, true, $item->params->get('secure'));
					}
					else {
						$item->flink = JRoute::_($item->flink);
					}

					$item->title = htmlspecialchars($item->title);
					$item->anchor_css = htmlspecialchars($item->params->get('menu-anchor_css', ''));
					$item->anchor_title = htmlspecialchars($item->params->get('menu-anchor_title', ''));
					$item->menu_image = $item->params->get('menu_image', '') ? htmlspecialchars($item->params->get('menu_image', '')) : '';

					if ($item->component=='com_virtuemart') {
						switch ($item->query['view'])  {
							case 'virtuemart':
							case 'categories':
							case 'category':
								$item->html_categories=self::buildTreeHTML($category_list, (int)$item->query['virtuemart_category_id'], 0, $item, $params);
								break;
						}
					}
				}

				if (isset($items[$lastitem])) {
					$items[$lastitem]->deeper		= (($start?$start:1) > $items[$lastitem]->level);
					$items[$lastitem]->shallower	= (($start?$start:1) < $items[$lastitem]->level);
					$items[$lastitem]->level_diff	= ($items[$lastitem]->level - ($start?$start:1));
				}
			}

			$cache->store($items, $key);
		}
		return $items;
	}

	/**
	* This function is repsonsible for returning an array containing category information
	* @param boolean Show only published products?
	* @param string the keyword to filter categories
	*/
	function getCategoryTreeArray( $only_published=true, $keyword = "" ) {

			$database	=& JFactory::getDBO();
			// Get only published categories
			$query  = "SELECT c.virtuemart_category_id AS cid, cl.category_description, cl.category_name,cx.category_child_id as cid, cx.category_parent_id as parent,c.ordering, c.published
						FROM #__virtuemart_categories AS c, #__virtuemart_category_categories AS cx, #__virtuemart_categories_".str_replace('-','_',strtolower(JFactory::getLanguage()->getTag()))." AS cl WHERE ";
			$query .= "(c.virtuemart_category_id=cx.category_child_id) AND (c.virtuemart_category_id=cl.virtuemart_category_id) ";
			$query .= "ORDER BY c.ordering ASC, cl.category_name ASC";

			// initialise the query in the $database connector
			// this translates the '#__' prefix into the real database prefix
			$database->setQuery( $query );
			$category_list = $database->loadAssocList('cid');

			// Transfer the Result into a searchable Array

			// establish the hierarchy of the menu
			$children = array();
			// first pass - collect children
			foreach ($category_list as $v ) {
				$v['category_name']=htmlspecialchars($v['category_name']);
				$pt = $v['parent'];
				$list = @$children[$pt] ? $children[$pt] : array();
				array_push( $list, $v );
				$children[$pt] = $list;
			}

			return $children;
	}

	function buildTree(&$fields, $index=0) {
		$list=array();
		if ($fields[$index]) {
			if (is_array($fields[$index])) {
				foreach ($fields[$index] as $key => $value) {
					$list[$value['cid']]['cid']=$value['cid'];
					$list[$value['cid']]['name']=$value['category_name'];
					$list[$value['cid']]['desc']=$value['category_description'];
					$list[$value['cid']]['children']=self::buildTree($fields, $value['cid']);
				}
			}
		}
		return $list;
	}

	function buildTreeHTML(&$fields, $index=0, $level=0, &$item, &$params) {
		$html='';
		if ($fields[$index]) {
			if (is_array($fields[$index])) {
				if (count($fields[$index])) {
					$html.="\n<ul class=\"level".$level." chield\">\n";
					foreach ($fields[$index] as $key => $value) {
						$children = self::buildTreeHTML($fields, $value['cid'], $level+1, $item, $params);
						$li_level = $level+1;
						$li_parent = $children!=''?' parent':'';
						$li_active = $value['cid']==JRequest::getVar('virtuemart_category_id')?' active':'';
						$html.="\t<li class=\"level".$li_level.$li_parent.$li_active."\">";
						$link = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$value['cid'].'&Itemid='.$item->id);
						if (substr($link,0,11)=='/component/') {
							$link.='?Itemid='.$item->id;
						}
						$html.="<a href=\"".$link."\">".trim($value['category_name']).'</a>';
						if ($level == 0)  {
							if($params->get('showVirtueMartCategoryDescription')) {
								if (trim($value['category_description'])) {
									$html.='<span class="vmdesc">'.trim($value['category_description']).'</span>';
								}
							}
						}
						$html.=$children;
						$html.="\t</li>\n";
					}
					$html.="</ul>\n";
				}
			}
		}
		return $html;
	}
}
