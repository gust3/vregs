<?php
/**
* Created on Jun 12, 2012
* @package   mod_vm2_search_j25
* @author    Filip Bartmann
* @copyright Copyright (C) WebSite21 | www.website21.cz
* @license   http://www.website21.cz/licence Proprietary Use License
*/

defined('_JEXEC') or die('Restricted access');

class JFormFieldCustomFields extends JFormField {
	protected $type='CustomFields';
	
	protected function getInput() {
		$db=JFactory::getDBO();
		$query=$db->getQuery(true);
		$query->select('virtuemart_custom_id AS id, custom_title AS title');
		$query->from('#__virtuemart_customs');
		$query->where('published=1');
		$query->where('field_type IN("S","I","B","M","V")');
		$db->setQuery($query);
		$customs=$db->loadObjectList();
		
		$html=array();
		$html[]='<fieldset class="radio" style="border: 1px solid #CCCCCC;float:none;clear:left;">';
		$html[]='<table>';
		foreach($customs as $custom) {
			$html[]='<tr>';
			$html[]='<td>';
			$html[]=$custom->title;
			$html[]='</td>';
			$html[]='<td>';
			$html[]='<input class="inputbox" type="radio" name="jform[params][customfields]['.$custom->id.']" id="'.$custom->id.'" value="1" '.($this->value[$custom->id]==1?'checked="checked"':'').'/>'.JText::_('JYES');
			$html[]='</td>';
			$html[]='<td>';
			$html[]='<input class="inputbox" type="radio" name="jform[params][customfields]['.$custom->id.']" id="'.$custom->id.'" value="0" '.($this->value[$custom->id]==0?'checked="checked"':'').'/>'.JText::_('JNO');
			$html[]='</td>';
			$html[]='</tr>';
		}
		$html[]='</table>';
		$html[]='</fieldset>';
		return implode($html);
	}
}
?>