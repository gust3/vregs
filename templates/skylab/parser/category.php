<?php
$db = JFactory::getDBO();
$query = $db->getQuery(true);
$query->select('virtuemart_category_id');
$query->from('#__virtuemart_categories');
$db->setQuery($query);
$categories = $db->loadobjectlist();

foreach ($categories as $category)
{
	$query = $db->getQuery(true);
	$query->select('virtuemart_category_id');
	$query->from('#__virtuemart_category_medias');
	$query->where('virtuemart_category_id = '.$category->virtuemart_category_id);
	$db->setQuery($query);
	$have = $db->loadResult();	
	if (!$have){
		$query = $db->getQuery(true);
		$query->select('virtuemart_product_id');
		$query->from('#__virtuemart_product_categories');
		$query->where('virtuemart_category_id = '.$category->virtuemart_category_id);
		$query->count("1");
		$db->setQuery($query);
		$num = $db->loadResult();	
		
		if (!$num) continue;
		
		$query = $db->getQuery(true);
		$query->select('virtuemart_media_id');
		$query->from('#__virtuemart_product_medias');
		$query->where('virtuemart_product_id = '.$num);
		$query->count("1");
		$db->setQuery($query);
		$num = $db->loadResult();
		
		$query = "INSERT INTO #__virtuemart_category_medias VALUES (0, ".$category->virtuemart_category_id.", ".$num.", 0)";
		$db->setQuery($query);
		$db->query();
	}	
}
?>