<?php
$start_time = microtime(true);
$db = JFactory::getDBO();
/*
	$query = $db->getQuery(true);
    $query->select('link_to_product');
    $query->from('#__toolsvmproducts');
	$db->setQuery($query);
	$links = $db->loadObjectList();

	foreach($links as $link)
	{
		$query = $db->getQuery(true);
		$query->insert('#__vmtools_ymarket_links');
		$query->set('link = "'.$link->link_to_product.'"');
		$query->set("parent_id = 1");
		$db->setQuery($query);
		$db->query();
	}
	
exit;
*/
function show_process($messedge, $color)
{
	echo "<span style='color:".$color."'>".$messedge."</span><br>";
}
require ("simple_html_dom.php");
require ("transliterate.php");

show_process("поиск ссылки", green);

	//ищем ссылку
	
    $query = $db->getQuery(true);
    $query->select('*');
    $query->from('#__vmtools_ymarket_links');
	$query->count(1);
	$query->where("inupdate_order = 0");
	$db->setQuery($query);
	$link = $db->loadObject();

if (!$link)
{
	//если ссылок нет тогда обнуляем все апдейты 
	$query = $db->getQuery(true);
	$query->update('#__vmtools_ymarket_links');
    $query->set('inupdate_order = 0');
	$db->setQuery($query);
	$db->query();
	//ищем снова ссылку
	$query = $db->getQuery(true);
    $query->select('*');
    $query->from('#__vmtools_ymarket_links');
	$query->count(1);
	$query->where("inupdate_order = 0");
	$db->setQuery($query);
	$link = $db->loadObject();
}	
show_process($link->link, green);
$vm_prod = $link->product_id;
if ($link->product_id == 0)
{
	$ch = curl_init (); // инициализация
	curl_setopt ($ch , CURLOPT_URL , $link->link);
	curl_setopt ($ch , CURLOPT_USERAGENT , "Mozilla/5.0"); // каким браузером будем прикидываться
	curl_setopt ($ch , CURLOPT_RETURNTRANSFER , 1 ); // вывод страницы в переменную
	$content_main = curl_exec($ch); // скачиваем страницу
	curl_close($ch); // закрываем соединение 
	$html = str_get_html($content_main);
	$ret_main = $html->find('h1[class="b-page-title"]');
	$model = $ret_main[0]->plaintext;
	echo $model."<br>";
	$ret_main = $html->find('span[class="b-model-pictures__big"]');
	
	//получаем ссылку на картинку
	$img = $ret_main[0]->children(0)->href;		
	if(!$img){
		$img = $ret_main[0]->children(0)->src;
	}
	echo $img."<br><br>";
	
	//получаем параметры сверху главной страницы
	$ret_main = $html->find('ul[class="b-vlist"] li');
	for ($i=0;$i<count($ret_main);$i++){
		$desc_props[$i] = $ret_main[$i]->plaintext;
		echo $desc_props[$i]."<br>";
	}	
	$ret_main = $html->find('div[class="b-breadcrumbs"]');
	$proiz = $ret_main[0]->children(1)->plaintext;
	echo "<br>".$proiz."<br>";
	
	//получаем цену
	$ret_main = $html->find('span[class="b-prices__num"]');
	$price = $ret_main[0]->plaintext;
	if( preg_match_all('/\d+/', $price, $match) ){
	// В массиве $match[0] все числа
	$p='';
	//убираем символ разряда в цифре цены
	foreach ($match[0] as $item){
		$p .=  $item;
	}			
	}
	$price = $p;
	echo "<br>".$price."<br><br>";
	
	/*
	$ret_main = $html->find('.b-top5-geo__offers li');	
		for ($i=0;$i<count($ret_main);$i++)
		{
			$name = $ret_main[$i]->children(1)->plaintext;
			$maps[$i] = array($name, $adress, $price, $url);			
		}
	*/
	//получаем ссылку на страничку детеилз товара
	
	$ret_main = $html->find('ul[class="b-switcher"]');
	$html_on_details = "http://market.yandex.ru".$ret_main[0]->children(1)->children(0)->children(0)->href;
	
	foreach ($ret_main[0]->children as $children)
	{
		if ($children->children(0)->children(0)->plaintext == 'Отзывы')
		{
			$link_otziv = "http://market.yandex.ru".$children->children(0)->children(0)->href."&sort_by=rank";
			break;
		}
	}
	
	$ch = curl_init (); // инициализация
	curl_setopt ($ch , CURLOPT_URL , $html_on_details);
	curl_setopt ($ch , CURLOPT_USERAGENT , "Mozilla/5.0"); // каким браузером будем прикидываться
	curl_setopt ($ch , CURLOPT_RETURNTRANSFER , 1 ); // вывод страницы в переменную
	$content_main = curl_exec($ch); // скачиваем страницу
	curl_close($ch); // закрываем соединение 
	$html = str_get_html($content_main);
	$ret_main = $html->find('table[class="b-properties"] tbody tr');
	for ($i=0;$i<count($ret_main);$i++){
	if ($ret_main[$i]->children(0)->class == "b-properties__title")
		{
			$properties[$i][0] = $ret_main[$i]->children(0)->plaintext;
			$properties[$i][1] = "ZAG";
		}
		else
		{
			$properties[$i][0] = $ret_main[$i]->children(0)->plaintext;
			$properties[$i][1] = $ret_main[$i]->children(1)->plaintext;
		}
		echo $properties[$i][0]." - ".$properties[$i][1]."<br>";
	}
	$html->clear();
	
	//смотрим есть ли такая категория
	
	$query = $db->getQuery(true);
    $query->select('virtuemart_category_id');
    $query->from('#__virtuemart_categories_ru_ru AS ru, #__virtuemart_category_categories AS cc');
	$query->where('ru.category_name = "'.$proiz.'"');
	$query->where('cc.id = ru.virtuemart_category_id');
	$query->where('cc.category_parent_id = '.$link->parent_id);
	$db->setQuery($query);
	$vm_cat = $db->loadResult();

		
	
	if (!$vm_cat)
	{	
		//получаем id категории
		$query = $db->getQuery(true);
		$query->select('virtuemart_category_id');
		$query->from('#__virtuemart_categories_ru_ru');
		$query->order('virtuemart_category_id DESC');
		$query->count('1');
		$db->setQuery($query);
		$vm_cat = $db->loadResult();
		
		if (!$vm_cat)
		{
			$vm_cat = 0;
		}
		//создаем описание и алиас категории
		$db->setquery("INSERT INTO #__virtuemart_categories_ru_ru VALUES (".($vm_cat+1).", '".$proiz."', '', '', '', '', '".str_replace(" ", "-", strtolower(translitIt($proiz)))."')");
		$db->query();
		//создаем порядок для категории
		$db->setquery("INSERT INTO #__virtuemart_category_categories VALUES (".($vm_cat+1).", ".$link->parent_id.", ".($vm_cat+1).", 0)");
		$db->query();
		//создаем запись о самой категории
		$db->setquery("INSERT INTO #__virtuemart_categories (virtuemart_category_id, virtuemart_vendor_id, limit_list_step, limit_list_initial, published, created_by, modified_by, created_on, modified_on, category_template, category_layout, category_product_layout, products_per_row, limit_list_start, limit_list_max) VALUES (".($vm_cat+1).", 1, 10, 10, 1, 319, 319, NOW(), NOW(), 0, 0, 0, 0, 0, 0)");
		$db->query();
	}
	else
	{
		$vm_cat = $vm_cat - 1;
	}
	
	//смотрим есть ли такой производитель
    $query = $db->getQuery(true);
	$query->select('virtuemart_manufacturer_id');
    $query->from('#__virtuemart_manufacturers_ru_ru');
	$query->where('slug = "'.str_replace(" ", "-", strtolower(translitIt($proiz))).'"');
	$db->setQuery($query);
	$vm_man = $db->loadResult();
	
	

	if (!$vm_man)
	{
		//создаем производителя
		$query = $db->getQuery(true);
		$query->select('virtuemart_manufacturer_id');
		$query->from('#__virtuemart_manufacturers');
		$query->order('virtuemart_manufacturer_id DESC');
		$query->count('1');
		$db->setQuery($query);
		$vm_man = $db->loadResult();
		if (!$vm_man)
		{
			$vm_man = 0;
		}			
		$db->setquery("INSERT INTO #__virtuemart_manufacturers VALUES (0, ".($vm_man+1).", 0, 0, 1, NOW(), 319, NOW(), 319, 0, 0)");
		$db->query();
		//создаем описание и алиас для производителя
		$db->setquery("INSERT INTO #__virtuemart_manufacturers_ru_ru VALUES (".($vm_man+1).", '".$proiz."', '', '', '', '".str_replace(" ", "-", strtolower(translitIt($proiz)))."')");
		$db->query();
		$vm_man = $vm_man + 1;
	}
	else
	{
		$vm_man = $vm_man - 1;
	}
	//записываем продукт если его нет
	
	$query = $db->getQuery(true);
	$query->select('virtuemart_product_id');
	$query->from('#__virtuemart_products');
	$query->order('virtuemart_product_id DESC');
	$query->count('1');
	$db->setQuery($query);
	$vm_prod = $db->loadResult();
	
	$db->setquery("INSERT INTO #__virtuemart_products (virtuemart_product_id, published) VALUES (".($vm_prod + 1).", 1)");
	$db->query();
	
	$desc_value = '<ul>';
	foreach ( $desc_props as $item)
	{
		$desc_value .= "<li>".$item."</li>";
	}
	$desc_value .= '</ul>';


	$db->setquery("INSERT INTO #__virtuemart_products_ru_ru VALUES (".($vm_prod + 1).", '".$desc_value."', '','".$model."', '', '', '', '".str_replace(' ', '_', strtolower(translitIt($model)))."')");
	$db->query();
	
	$db->setquery("INSERT INTO #__virtuemart_product_categories VALUES (".($vm_prod + 1).", ".($vm_prod + 1).", ".($vm_cat+1).", 0)");
	$db->query();
	
	$db->setquery("INSERT INTO #__virtuemart_product_manufacturers VALUES (".($vm_prod + 1).", ".($vm_prod + 1).", ".($vm_man +1).")");
	$db->query();
	
	$db->setquery("INSERT INTO #__virtuemart_product_prices VALUES (".($vm_prod + 1).", ".($vm_prod + 1).", '', ".$price.", '', 0, 0, 0, 131, '', '', '', '', '', 0, NOW(), 319, '', 0)");
	$db->query();
	
	//кастомные поля перебираем
	
	foreach($properties as $property)
	{	
		$query = $db->getQuery(true);
		$query->select('virtuemart_custom_id');
		$query->from('#__virtuemart_customs');
		$query->where('custom_title = "'.$property[0].'"');
		$db->setQuery($query);
		$vm_cust = $db->loadResult();
		if (!$vm_cust)
		{
			$query = $db->getQuery(true);
			$query->select('virtuemart_custom_id');
			$query->from('#__virtuemart_customs');
			$query->order('virtuemart_custom_id DESC');
			$query->count("1");
			$db->setQuery($query);
			$vm_cust = $db->loadResult();
			$db->setquery("INSERT INTO #__virtuemart_customs VALUES (".($vm_cust + 1).", 0, 1, 0, '0', 0, '".$property[0]."', '".$property[0]."', '', '', 'S', 0, 0, 0, '', 0, 0, 1, NOW(), 319, 0, NOW(), 319, '', 0)");
			$db->query();
			$vm_cust = ($vm_cust + 1);
		}
			$query = $db->getQuery(true);
			$query->select('virtuemart_customfield_id');
			$query->from('#__virtuemart_product_customfields');
			$query->order('virtuemart_customfield_id DESC');
			$query->count("1");
			$db->setQuery($query);
			$vm_cust_id = $db->loadResult();
		$db->setquery("INSERT INTO #__virtuemart_product_customfields VALUES (".($vm_cust_id + 1).", ".($vm_prod + 1).", ".$vm_cust.", '".$property[1]."', '', '', 1, '', 0, NOW(), 319, '', 0, 0)");
		$db->query();
	}	
	
	unset($html);
	unset($content_main);
	
	copy($img, 'images/stories/virtuemart/product/product-'.($vm_prod + 1).'.jpg');
	
	//добавляем картинку к товару
	
	$query = $db->getQuery(true);
	$query->select('virtuemart_media_id');
	$query->from('#__virtuemart_medias');
	$query->order('virtuemart_media_id DESC');
	$query->count("1");
	$db->setQuery($query);
	$vm_med = $db->loadResult();
	
	$db->setquery("INSERT INTO #__virtuemart_medias VALUES (".($vm_med + 1).", 1, '".$model."', '".$model."', '".$model."', 'image/jpeg', 'product', 'images/stories/virtuemart/product/product-".($vm_prod + 1).".jpg', '', 0, 0, 0, '', 0, 1, NOW(), 631, NOW(), 631, '', 0)");
	$db->query();
	
	$query = $db->getQuery(true);
	$query->select('id');
	$query->from('#__virtuemart_product_medias');
	$query->order('id DESC');
	$query->count("1");
	$db->setQuery($query);
	$vm_med_id = $db->loadResult();
	
	$db->setquery("INSERT INTO #__virtuemart_product_medias VALUES (".($vm_med_id + 1).", ".($vm_prod + 1).", ".($vm_med + 1).", 1)");
	$db->query();				
	
	$query->update('#__vmtools_ymarket_links');
    $query->set('inupdate_order = 1');
	$query->set('update_date = NOW()');
	$query->set('product_id = '.($vm_prod + 1));
	$query->set('category_id = '.($vm_cat + 1));
	$query->where('id ='.$link->id);
	$db->setQuery($query);
	$db->query();
	
		$ch = curl_init (); // инициализация
		curl_setopt ($ch , CURLOPT_URL , $link_otziv );
		curl_setopt ($ch , CURLOPT_USERAGENT , "Mozilla/5.0"); // каким браузером будем прикидываться
		curl_setopt ($ch , CURLOPT_RETURNTRANSFER , 1 ); // вывод страницы в переменную
		$content_main = curl_exec($ch); // скачиваем страницу
		curl_close($ch); // закрываем соединение 
		$html = str_get_html($content_main);
		$ret_main = $html->find('div[class="b-grade"]');
		for ($i=0;$i<count($ret_main);$i++){
			//$otzivy[$i][] = $ret_main[]
			$rating = $ret_main[$i]->children(0)->children(1)->children(0)->children(1)->plaintext;
			switch ($rating) {
					case "ужасная модель":
						$rat = 1;
						break;
					case "плохая модель":
						$rat = 2;
						break;					
					case "обычная модель":
						$rat = 3;
						break;
					case "хорошая модель":
						$rat = 4;
						break;
					case "отличная модель":
						$rat = 5;
						break;
					default:
						$rat="333";
				}
			$otzivy[$i]['rating'] = $rat;
			$otzivy[$i]['plusy'] = $ret_main[$i]->children(0)->children(3)->innertext;
			$otzivy[$i]['minusy'] = $ret_main[$i]->children(0)->children(4)->innertext;
			$otzivy[$i]['comments'] = $ret_main[$i]->children(0)->children(5)->innertext;
			$otzivy[$i]['user'] = $ret_main[$i]->children(0)->children(0)->children(0)->children(0)->children(0)->plaintext;
		}
	foreach ($otzivy as $otziv){

	$query = "INSERT INTO #__vmtools_products_otzivi (product_id, reiting, plusy, minusy, comment, user) VALUES (".($vm_prod + 1).", ".$otziv['rating'].", ".$db->quote($otziv['plusy']).", ".$db->quote($otziv['minusy']).", ".$db->quote($otziv['comment']).", ".$db->quote($otziv['user']).")";
	$db->setQuery($query);
	$db->query();

	}
	
	
	
	$vm_prod = $vm_prod + 1;
	
}
	$query = $db->getQuery(true);
	$query->select('*');
	$query->from('#__vmtools_regions');
	$db->setQuery($query);
	$regions = $db->loadObjectList();
		
	foreach ($regions as $region)	
	{
		$ch = curl_init (); // инициализация
		curl_setopt ($ch , CURLOPT_URL , $link->link);
		curl_setopt ($ch , CURLOPT_USERAGENT , "Mozilla/5.0"); // каким браузером будем прикидываться
		curl_setopt ($ch , CURLOPT_RETURNTRANSFER , 1 ); // вывод страницы в переменную
		curl_setopt ($ch, CURLOPT_COOKIE, "yandex_gid=".$region->id_region);
		$content_main = curl_exec($ch); // скачиваем страницу
		curl_close($ch); // закрываем соединение 
		$html = str_get_html($content_main);
		$ret_main = $html->find('.b-top5-geo__offers li');	
		for ($i=0;$i<count($ret_main);$i++)
		{
			$name = $ret_main[$i]->children(1)->plaintext;
			$url = $ret_main[$i]->children(1)->href;
			$adress = $ret_main[$i]->children(2)->plaintext;
			$price = $ret_main[$i]->children(3)->plaintext;
			$price=preg_replace("/[^x\d|*\.]/","",$price);
			$price = str_replace("руб", "", $price);			
			if ($i < 5)
			{
				$maps[] = array($name, $adress, $price, $url);			
			}
		}
	}
	foreach ($maps as $map)
	{
		$query = $db->getQuery(true);
		$query->select('id, ymname');
		$query->from('#__vmtools_netshop');
		$query->where('ymname="\''.$map[0].'\'"');
		$db->setQuery($query);
		$net = $db->loadObject();
		if (!$net){		
			$query = $db->getQuery(true);
			$query->select('id');
			$query->from('#__vmtools_netshop');
			$query->order('id DESC');
			$query->count("1");
			$db->setQuery($query);
			$net_last_id = $db->loadResult();		
			
			$net_last_id += 1;
			$query = $db->getQuery(true);
			$query->insert('#__vmtools_netshop');
			$query->set('id ='.$net_last_id);
			$query->set('ymname = "\''.$map[0]."'\"");
			$label = explode('.', $map[0]);
			$query->set('label = "'.$db->nameQuote($label[0]).'"');
			$db->setQuery($query);
			$db->query();
		}
		else
		{
			$net_last_id = $net->id;
		}
		$query = $db->getQuery(true);
		$query->select('id');
		$query->from('#__vmtools_nets_products');
		$query->where('id_net = '.$net_last_id);
		$query->where('id_product = '.$vm_prod);
		$db->setQuery($query);
		$net_pr = $db->loadResult();
		if ($net_pr)
		{
			$query = $db->getQuery(true);
			$query->update ('#__vmtools_nets_products');
			$query->set('price = '.($map[2]));
			$query->where('id_net = '.$net_last_id);
			$query->where('id_product = '.$vm_prod);
			$db->setQuery($query);
			$db->query();			
		}
		else
		{
			$query = $db->getQuery(true);
			$query->select('id');
			$query->from('#__vmtools_nets_products');
			$query->order('id DESC');
			$query->count("1");
			$db->setQuery($query);
			$net_pr_last_id = $db->loadResult();
			
			$query = $db->getQuery(true);
			$query->insert ('#__vmtools_nets_products');
			$query->set('price = '.$map[2]);
			$query->set('id_net = '.$net_last_id);
			$query->set('id_product = '.$vm_prod);
			$query->set('id = '.($net_pr_last_id + 1));
			$db->setQuery($query);			
			$db->query();
		}
	}

$exec_time = microtime(true) - $start_time;
echo "<span style='color:green'>задача выполнена</span><br>";
echo "<span style='color:green'>время выполнения: <span style='color:red'>".(int)$exec_time."</span> секунд</span>";
?>