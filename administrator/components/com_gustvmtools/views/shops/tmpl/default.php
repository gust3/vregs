<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;
 
// Загружаем тултипы.
JHtml::_('behavior.tooltip');
include '../administrator/components/com_gustvmtools/panel.php';
?>
<form action="index.php" method="post" name="adminForm">
Осторожно, все данные по магазинам будут потеряны

Данный скрипт считывает спарсенные данные и заносит их в таблицы создавая таблицу магазинов и таблицу товаров в которой перечисленны все магазины. <b style="color:red">Не нажимайте сохранить если не уверены к чему это приведет!</b>
<input type="hidden" name="option" value="com_gustvmtools" />
<input type="hidden" name="task" value="apply" />
<input type="hidden" name="boxchecked" value="1" />
<input type="hidden" name="controller" value="shops" />
</form>
<?php
/*
$url = "http://maps.yandex.ru/?text=белый ветер цифровой";
		$ch = curl_init (); // инициализация
		curl_setopt ($ch , CURLOPT_URL , $url);
		curl_setopt ($ch , CURLOPT_USERAGENT , "Mozilla/5.0"); // каким браузером будем прикидываться
		curl_setopt ($ch , CURLOPT_RETURNTRANSFER , 1 ); // вывод страницы в переменную
		$content_main = curl_exec($ch); // скачиваем страницу
		curl_close($ch); // закрываем соединение 
		$cart = json_decode( $content_main, true );
		
		
		
		var_dump($cart[points][0][addr]);*/
/*		
		include_once('simple_html_dom.php');
		$url = "http://maps.yandex.ru/?text=белый ветер цифровой";
		$ch = curl_init (); // инициализация
		curl_setopt ($ch , CURLOPT_URL , $url);
		curl_setopt ($ch , CURLOPT_USERAGENT , "Mozilla/5.0"); // каким браузером будем прикидываться
		curl_setopt ($ch , CURLOPT_RETURNTRANSFER , 1 ); // вывод страницы в переменную
		curl_setopt ($ch, CURLOPT_COOKIE, "yandex_gid=213");
		$content_main = curl_exec($ch); // скачиваем страницу
		curl_close($ch); // закрываем соединение 
		$html = str_get_html($content_main);		
*/
?>

<a href="http://maps.yandex.ru/?text=белый ветер цифровой&z=10&results=60">ddd</a>






http://maps.yandex.ru/?text=%D0%B1%D0%B5%D0%BB%D1%8B%D0%B9%20%D0%B2%D0%B5%D1%82%D0%B5%D1%80%20%D1%86%D0%B8%D1%84%D1%80%D0%BE%D0%B2%D0%BE%D0%B9&z=10&results=60






