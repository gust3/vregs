<?php
/*
 * Created on Jan 14, 2012
 *
 * Author: Linelab.org
 * Project: tmpl_skylab_vm2
 */

defined('_JEXEC') or die('Restricted access');

class VM2SearchHelper extends JObject {
	private $_params=null;
	private $_customfields=null;
	private $_db=null;
	private $_fields=null;
	private $_search=null;
	private $_cart_vars=null;
	private $_category_id=null;
	private $_ids=null;
	private $_media_fields=null;
	
	function __construct($params) {
		$this->_params=$params;
		
		$this->_db=JFactory::getDBO();
		$this->_search=JRequest::getVar('mod_search',array(),'post','array');
		$this->_lang=strtolower(str_replace("-","_",JFactory::getLanguage()->getTag()));
		$this->_category_id=JRequest::getInt('virtuemart_category_id',0);
		if($this->_params->get('customfields')) {
			foreach($this->_params->get('customfields') as $custom=>$value) {
				if($value==1) {
					$this->_customfields[]=$custom;
				}
			}
		}
		if($this->_category_id>0) {	
			$this->_ids=$this->_getIds();
			if(empty($this->_ids)) {
				$this->_ids=array("0");
			}
		}
	}
	
	private function _getIds() {
		$query="SELECT DISTINCT virtuemart_product_id \n";
		$query.="FROM #__virtuemart_product_categories \n";
		$query.="WHERE virtuemart_category_id=".$this->_category_id;
		$this->_db->setQuery($query);		
		return $this->_db->loadResultArray();
	}
	
	function getFields() {
		$query="SELECT virtuemart_custom_id AS id, custom_title AS title, field_type AS type, is_list \n";
		$query.="FROM #__virtuemart_customs \n";
		$query.="WHERE published=1 AND field_type IN('S','I','B') \n";
		if(count($this->_customfields)) {
			$query.="AND virtuemart_custom_id IN(".implode(",",$this->_customfields).") \n";
		}
		/*
		if($this->_category_id>0) {
			$query.="AND virtuemart_custom_id IN(SELECT virtuemart_custom_id FROM #__virtuemart_product_customfields WHERE virtuemart_product_id IN(".implode(",",$this->_ids).")) \n";
		}
		*/
		$this->_db->setQUery($query);
		return $this->_fields=$this->_db->loadObjectList('id');
	}
	
	function getValues() {
		
		$data=array();	
		
		foreach(array_keys($this->_fields) as $field) {
			$query="SELECT DISTINCT virtuemart_custom_id AS id, custom_value AS value \n";
			$query.="FROM #__virtuemart_product_customfields \n";
			$query.="WHERE virtuemart_custom_id=".$field." \n";
		/*	
			if($this->_category_id>0) {
				$query.="AND virtuemart_product_id IN(".implode(",",$this->_ids).") \n";
			}
		*/
			$this->_db->setQUery($query);
			$data[$field]=$this->_db->loadObjectList();
		}
		return $data;
	}
	
	function getMediaFields() {
		$query="SELECT virtuemart_custom_id AS id, custom_title AS title, field_type AS type, is_list \n";
		$query.="FROM #__virtuemart_customs \n";
		$query.="WHERE published=1 AND field_type IN('M') AND is_cart_attribute=0 \n";
		if(count($this->_customfields)) {
			$query.="AND virtuemart_custom_id IN(".implode(",",$this->_customfields).") \n";
		}
		if($this->_category_id>0) {
			$query.="AND virtuemart_custom_id IN(SELECT virtuemart_custom_id FROM #__virtuemart_product_customfields WHERE virtuemart_product_id IN(".implode(",",$this->_ids).")) \n";
		}
		$this->_db->setQUery($query);
		return $this->_fields=$this->_db->loadObjectList('id');
	}
	
	function getMediaFieldsValues() {
		$data=array();
		foreach(array_keys($this->_fields) as $field) {
			$query="SELECT DISTINCT cf.virtuemart_custom_id AS id, cf.custom_value AS value, m.file_url AS image, m.file_title AS alt \n";
			$query.="FROM #__virtuemart_product_customfields AS cf \n";
			$query.="LEFT JOIN #__virtuemart_medias AS m ON cf.custom_value=m.virtuemart_media_id \n";
			$query.="WHERE virtuemart_custom_id=".$field." \n";
			if($this->_category_id>0) {
				$query.="AND cf.virtuemart_product_id IN(".implode(",",$this->_ids).") \n";
			}
			//echo str_replace('#__','jos_',$query)."<br />";
			$this->_db->setQUery($query);
			$data[$field]=$this->_db->loadObjectList();
		}
		return $data;
	}
	
	function getCartVariants() {
		$query="SELECT virtuemart_custom_id AS id, custom_title AS title, field_type AS type, is_list \n";
		$query.="FROM #__virtuemart_customs \n";
		$query.="WHERE published=1 AND field_type IN('V') \n";
		if(count($this->_customfields)) {
			$query.="AND virtuemart_custom_id IN(".implode(",",$this->_customfields).") \n";
		}
		if($this->_category_id>0) {
			$query.="AND virtuemart_custom_id IN(SELECT virtuemart_custom_id FROM #__virtuemart_product_customfields WHERE virtuemart_product_id IN(".implode(",",$this->_ids).")) \n";
		}
		$this->_db->setQUery($query);
		return $this->_cart_vars=$this->_db->loadObjectList('id');
	}
	
	function getCartVartiantsValues() {
		$data=array();
		foreach(array_keys($this->_cart_vars) as $field) {
			$query="SELECT DISTINCT virtuemart_custom_id AS id, custom_value AS value \n";
			$query.="FROM #__virtuemart_product_customfields \n";
			$query.="WHERE virtuemart_custom_id=".$field." \n";
			$this->_db->setQUery($query);
			$data[$field]=$this->_db->loadObjectList();
		}
		return $data;
	}
	
	function getManufacturers() {
		$query="SELECT virtuemart_manufacturer_id AS id, mf_name AS title \n";
		$query.="FROM #__virtuemart_manufacturers_".$this->_lang." \n";
		/*
		if($this->_category_id>0) {
			$query.="WHERE virtuemart_manufacturer_id IN(SELECT virtuemart_manufacturer_id FROM #__virtuemart_product_manufacturers WHERE virtuemart_product_id IN(".implode(",",$this->_ids).")) \n";
		}*/
		$query.="ORDER BY mf_name ASC \n";
		$query="SELECT #__virtuemart_manufacturers.main, #__virtuemart_manufacturers_".$this->_lang.".mf_name AS title, #__virtuemart_manufacturers.virtuemart_manufacturer_id AS id FROM #__virtuemart_manufacturers, #__virtuemart_manufacturers_".$this->_lang." WHERE #__virtuemart_manufacturers.virtuemart_manufacturer_id = #__virtuemart_manufacturers_".$this->_lang.".virtuemart_manufacturer_id AND #__virtuemart_manufacturers.published = 1";
		$this->_db->setQuery($query);
		return $this->_db->loadObjectList();
	}
	
	function getPrices() {
		$price_sel=JFactory::getApplication()->getUserState('mod_vm2_search.price');
		$price_ol=array();
		

		for($i=$this->_params->get('price_from',100);$i<=$this->_params->get('price_to',1000);$i+=$this->_params->get('price_step',100)) {
			$price_ol[]=JHTML::_('select.option',$i,$i,'id','title');
		}	

		
		$lists["price_from"]=JHTML::_('select.genericlist',$price_ol,"price[from]",'class="inputbox" onchange="submitsearch();"','id','title',isset($min_price)?$min_price:$this->_params->get('price_from'),'price_from');
		$lists["price_to"]=JHTML::_('select.genericlist',$price_ol,"price[to]",'class="inputbox" onchange="submitsearch();"','id','title',isset($max_price)?$max_price:$this->_params->get('price_to'),'price_to');
		
		return $lists;
	}
}
?>
