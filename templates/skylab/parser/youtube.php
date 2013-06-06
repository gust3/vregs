<?php
	$start_time = microtime(true);
	
	$db = JFactory::getDBO();
	$query = $db->getQuery(true);
	$query->select('product_name, virtuemart_product_id');
	$query->from('#__virtuemart_products_ru_ru');
	$db->setQuery($query);
	$products = $db->loadObjectList();
	
	foreach ($products as $product)
	{
		$product_name = $product->product_name;
		$phrase = implode("+", explode(" ", $product_name));
		
		$xml =  simplexml_load_file("http://gdata.youtube.com/feeds/api/videos?vq=".$phrase."&orderby=published&start-index=11&max-results=10");
	//	echo $xml->entry[0]->title;
	//	echo str_replace("http://gdata.youtube.com/feeds/api/videos/", "", $xml->entry[0]->id);
		
		foreach($xml->entry as $k => $item)
		{	
		if ($k == 10) break;
		$text =  $item->title;
		
		if (strpos($text, "тест")) continue; 
		if (strpos($text, "обзор")) continue;

		$url = str_replace("http://gdata.youtube.com/feeds/api/videos/", "", $item->id);
		$query = 'INSERT INTO #__vmtools_videos VALUES (0, '.$product->virtuemart_product_id.', "'.$url.'", '.$db->quote($text).', 1)';
		$db->setQuery($query);
		$db->query();
		}
	}
	
	$exec_time = microtime(true) - $start_time;
	echo "<span style='color:green'>задача выполнена</span><br>";
	echo "<span style='color:green'>время выполнения: <span style='color:red'>".(int)$exec_time."</span> секунд</span>";
?>