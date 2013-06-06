<?php
/*
 * Created on Dec 14, 2011
 *
 * Author: Linelab.org
 * Project: tmpl_skylab
 */

defined('_JEXEC') or die('Restricted access');

if(JRequest::getVar('results')=='get_results') {
	if(JRequest::getVar('type')=='breadcrumbs') {
		echo json_encode(getSearchBreadCrumbs());
	} else {
		showProducts();
		if(JRequest::getInt('virtuemart_manufacturer_id')>0) {
		    ?>
		    <input type="hidden" name="order_manufacturer_id" id="order_manufacturer_id" value="<?php echo JRequest::getInt('virtuemart_manufacturer_id'); ?>" />
		    <?php
		}
	}

	JFactory::getApplication()->close();
}

function replaceOrderBy($matches) {
	if(JRequest::getVar('results')=='get_results') {
		return 'href="javascript:void(0);" onclick="loadContent(\''.$matches[2].(strpos($matches[2],'?')?'&':'?').'results=get_results&limistart=0\',document.getElementById(\'vm2_search\').toQueryString()+\'&mod_search[price][from]=\'+document.getElementById(\'price_from\').options[document.getElementById(\'price_from\').selectedIndex].value+\'&mod_search[price][to]=\'+document.getElementById(\'price_to\').options[document.getElementById(\'price_to\').selectedIndex].value);");"';
	} else {
		return 'href="javascript:void(0);" onclick="loadContent(\''.$matches[2].'\',\'type=raw&limitstart=0\');"';
	}
}

function replaceManufacturer($matches) {
    if(JRequest::getVar('results')=='get_results') {
	return 'href="javascript:void(0);" onclick="loadContent(\''.$matches[2].(strpos($matches[2],'?')?'&':'?').'&limistart=0&\',document.getElementById(\'vm2_search\').toQueryString()+\'&mod_search[price][from]=\'+document.getElementById(\'price_from\').options[document.getElementById(\'price_from\').selectedIndex].value+\'&mod_search[price][to]=\'+document.getElementById(\'price_to\').options[document.getElementById(\'price_to\').selectedIndex].value);");"';
    } else {
	return 'href="javascript:void(0);" onclick="loadContent(\''.$matches[2].'\',\'type=raw&limitstart=0\');"';
    }
}

function replacePagination($matches) {
	$limistart=array();
	preg_match('/start=([0-9]+)/',$matches[2],$limistart);
	return 'href="javascript:void(0);" onclick="loadContent(\'index.php?results=get_results&limit'.$limistart[0].'&limit=\'+document.getElementById(\'limit\').options[document.getElementById(\'limit\').selectedIndex].value,document.getElementById(\'vm2_search\').toQueryString()+\'&mod_search[price][from]=\'+document.getElementById(\'price_from\').options[document.getElementById(\'price_from\').selectedIndex].value+\'&mod_search[price][to]=\'+document.getElementById(\'price_to\').options[document.getElementById(\'price_to\').selectedIndex].value);");"';
}

function setShowWhere($cids,$mids,$pids) {
	$where=array();
	//echo "CIDS: ";print_r($cids);echo "<br> PIDS: ";print_r($pids);echo "<br> MIDS: ";print_r($mids);echo "<br><br>";
	if(count($cids)) {
		$where[]="p.virtuemart_product_id IN(".implode(",",$cids).")";
	}
	if(count($pids)) {
		$where[]="p.virtuemart_product_id IN(".implode(",",$pids).")";
	}
	if(count($mids)) {
		$where[]="p.virtuemart_product_id IN(".implode(",",$mids).")";
	}
	if(JRequest::getInt('virtuemart_category_id')) {
                $where[]="pc.virtuemart_category_id=".JRequest::getInt('virtuemart_category_id');
        }

	return count($where)?("WHERE ".implode(" AND ",$where)." \n"):"";
}

/* ***************************************************************************** начало формирования продуктов **************************************** */

function showProducts() {
	$db=JFactory::getDBO();
	$search=JRequest::getVar('mod_search',array(),'post','array');
	$lang=strtolower(str_replace("-","_",JFactory::getLanguage()->getTag()));

	JFactory::getLanguage()->load('com_virtuemart');
	$ids=array();
	$cids=array();
	$mids=array();
	$pids=array();

	JFactory::getApplication()->setUserState('mod_vm2_search.customs',isset($search["customs"])?$search["customs"]:array());
	if(isset($search["customs"])) {
		foreach($search["customs"] as $id=>$customs) {
			
			/*for($i=0;$i<count($customs);$i++) {
				$customs[$i]=strtolower($db->quote($customs[$i]));
			}
			$query="SELECT DISTINCT virtuemart_product_id \n";
			$query.="FROM #__virtuemart_product_customfields \n";
			$query.="WHERE LOWER(custom_value) IN(".implode(",",$customs).") AND virtuemart_custom_id=".$id." \n";
			*/
			for($i=0;$i<count($customs);$i++) {
		
				$query="SELECT DISTINCT virtuemart_product_id \n";
				$query.="FROM #__virtuemart_product_customfields \n";
				$query.="WHERE (locate(lower('".$customs[$i]."'), lower(custom_value)) > 0) AND virtuemart_custom_id=".$id." \n";
				$db->setQuery($query);
				
				//var_dump($datas);
				
				$datas=$db->loadResultArray();
				
			//	var_dump($datas);
				if(empty($cids)) {
					$cids=$datas;
				} else {
					//$cids=array_intersect($cids,$datas);
					$cids=array_merge($cids,$datas);
				}
			}
		}
		$cids=array_unique($cids);
	}
	//print_r($cids);

	if(JRequest::getInt('virtuemart_manufacturer_id')>0) {
	    $search["manufacturers"]=array(JRequest::getInt('virtuemart_manufacturer_id'));
	}

	JFactory::getApplication()->setUserState('mod_vm2_search.manufacturers',isset($search["manufacturers"])?$search["manufacturers"]:array());
	if(isset($search["manufacturers"])) {
		$query="SELECT DISTINCT virtuemart_product_id \n";
		$query.="FROM #__virtuemart_product_manufacturers \n";
		$query.="WHERE virtuemart_manufacturer_id IN(".implode(",",$search["manufacturers"]).")";
		$db->setQuery($query);
		$mids=$db->loadResultArray();
	}


	JFactory::getApplication()->setUserState('mod_vm2_search.price',$search["price"]);
	if(strlen($search["price"]["from"]) && strlen($search["price"]["to"])) {
		$query="SELECT DISTINCT virtuemart_product_id \n";
		$query.="FROM #__virtuemart_product_prices \n";
		$query.="WHERE product_price>=".$search["price"]["from"]." AND product_price<=".$search["price"]["to"]." \n";
		$db->setQuery($query);
		//echo str_replace('#__','jos_',$query)."<br />";
		$pids=$db->loadResultArray();
	}
	
	$query="SELECT DISTINCT p.virtuemart_product_id \n";
	$query.="FROM #__virtuemart_products AS p \n";
	$query.="LEFT JOIN #__virtuemart_products_".$lang." AS pl ON p.virtuemart_product_id=pl.virtuemart_product_id \n";
	$query.="LEFT JOIN #__virtuemart_product_manufacturers AS pmx ON p.virtuemart_product_id=pmx.virtuemart_product_id \n";
	$query.="LEFT JOIN #__virtuemart_manufacturers_".$lang." AS mf ON pmx.virtuemart_manufacturer_id=mf.virtuemart_manufacturer_id \n";
	$query.="LEFT JOIN #__virtuemart_product_categories AS pc ON p.virtuemart_product_id=pc.virtuemart_product_id \n";
	$query.="LEFT JOIN #__virtuemart_categories_".$lang." AS c ON pc.virtuemart_category_id=c.virtuemart_category_id \n";
	$query.="LEFT JOIN #__virtuemart_product_prices AS pp ON pp.virtuemart_product_id=p.virtuemart_product_id \n";
	$query.=setShowWhere($cids,$mids,$pids);
	$query.="ORDER BY ".JRequest::getString('orderby','virtuemart_product_id')." ".JRequest::getString('order','ASC');
	//echo str_replace('#__','jos_',$query);exit;
	$db->setQUery($query,JRequest::getInt('limitstart',0),JRequest::getInt('limit',12));
	$ids=$db->loadResultArray();


	$query="SELECT COUNT(p.virtuemart_product_id) \n";
	$query.="FROM #__virtuemart_products AS p \n";
	$query.="LEFT JOIN #__virtuemart_products_".$lang." AS pl ON p.virtuemart_product_id=pl.virtuemart_product_id \n";
	$query.="LEFT JOIN #__virtuemart_product_manufacturers AS pmx ON p.virtuemart_product_id=pmx.virtuemart_product_id \n";
	$query.="LEFT JOIN #__virtuemart_manufacturers_".$lang." AS mf ON pmx.virtuemart_manufacturer_id=mf.virtuemart_manufacturer_id \n";
	$query.="LEFT JOIN #__virtuemart_product_categories AS pc ON p.virtuemart_product_id=pc.virtuemart_product_id \n";
	$query.="LEFT JOIN #__virtuemart_categories_".$lang." AS c ON pc.virtuemart_category_id=c.virtuemart_category_id \n";
	$query.=setShowWhere($cids,$mids,$pids);
	$db->setQUery($query);
	$total=$db->loadResult();

	define('JPATH_VM_ADMINISTRATOR',JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_virtuemart'.DS);

	if(!class_exists('VmConfig')) require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'config.php');
	if (!class_exists('VirtueMartModelProduct')) require(JPATH_VM_ADMINISTRATOR . DS . 'models' . DS . 'product.php');

	$productModel = new VirtueMartModelProduct();
	$products=$productModel->getProducts($ids);
	$productModel->addImages($products,1);
	foreach($products as $product) {
		$product->stock=$productModel->getStockIndicator($product);
	}
	$per_row=VmConfig::get('products_per_row',3);

	$pagination=$productModel->getPagination2($total,JRequest::getInt('limitstart',0));

	$orderByList=$productModel->getOrderByList(false);

	if (!class_exists('CurrencyDisplay'))  require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'currencydisplay.php');

	$currency = CurrencyDisplay::getInstance( );

	if(!class_exists('Permissions')) require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'permissions.php');
	$showBasePrice = Permissions::getInstance()->check('admin'); //todo add config settings

	if (!class_exists( 'shopFunctionsF' )) require(JPATH_SITE.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'shopfunctionsf.php');

	$show_prices  = VmConfig::get('show_prices',1);

	require_once dirname(__FILE__).DS.'html'.DS.'com_virtuemart'.DS.'results'.DS.'results.php';
}



/* ***************************************************************************** конец формирования продуктов **************************************** */


function getSearchBreadCrumbs() {
	$db=JFactory::getDBO();
	$lang=strtolower(str_replace("-","_",JFactory::getLanguage()->getTag()));
	$search=JRequest::getVar('mod_search');

	$manufacturers=@$search["manufacturers"];
	$customs=@$search["customs"];

	$manufacturers_ol=array();
	if(count($manufacturers)) {
		$query="SELECT virtuemart_manufacturer_id AS id, mf_name AS title \n";
		$query.="FROM #__virtuemart_manufacturers_".$lang." \n";
		$query.="WHERE virtuemart_manufacturer_id IN(".implode(",",$manufacturers).")";
		$db->setQuery($query);
		$manufacturers_ol=$db->loadObjectList();
	}

	$custom_arr=array();
	if(isset($search["customs"])) {
		foreach($customs as $id=>$values) {
			$query="SELECT custom_title, field_type \n";
			$query.="FROM #__virtuemart_customs \n";
			$query.="WHERE virtuemart_custom_id=".$id." \n";
			$db->setQuery($query);
			$custom_o=$db->loadObject();

			$custom=new stdClass();
			$custom->id=$id;
			$custom->title=$custom_o->custom_title;
			$custom->values=$values;
			$custom->type='O';
			if($custom_o->field_type=='M') {
				$custom->type='M';
				$custom->images=array();
				$images=array();
				foreach($values as $value) {
					$query="SELECT file_title \n";
					$query.="FROM #__virtuemart_medias \n";
					$query.="WHERE virtuemart_media_id=".$value;
					$db->setQuery($query);
					$file_title=$db->loadResult();
					$custom->images[$value]=$file_title;
				}
			}

			$custom_arr[]=$custom;
		}
	}

	return array('manufacturers'=>$manufacturers_ol,'customs'=>$custom_arr);
}
?>