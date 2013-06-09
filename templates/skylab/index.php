<?php
/**
 * @subpackage        tpl_skylab
 * @copyright        Copyright (C) 2011 Linelab.org. All rights reserved.
 * @license          Commercial
 */
defined('_JEXEC') or die;
$config = & JFactory::getConfig();
if (JRequest::getVar('type','normal')=='search-video')
{


sleep( 3 );
// no term passed - just exit early with no response
if (empty($_GET['term'])) exit ;
$q = strtolower($_GET["term"]);
// remove slashes if they were magically added
if (get_magic_quotes_gpc()) $q = stripslashes($q);


$db =& JFactory::getDBO();
$query = "SELECT DISTINCT model FROM #__toolsvmproducts WHERE model like '%".$_GET['str']."%'";
$db->setQuery($query);
$models = $db->loadObjectList();

foreach ($models as $model)
{
    $items[$model->model] = $model->model;
}


$result = array();
foreach ($items as $key=>$value) {
	if (strpos(strtolower($key), $q) !== false) {
		array_push($result, array("id"=>$value, "label"=>$key, "value" => strip_tags($key)));
	}
	if (count($result) > 11)
		break;
}

// json_encode is available in PHP 5.2 and above, or you can install a PECL module in earlier versions
echo json_encode($result);
    exit;
}
if (JRequest::getVar('type','normal')=='search-obzor')
{


sleep( 3 );
// no term passed - just exit early with no response
if (empty($_GET['term'])) exit ;
$q = strtolower($_GET["term"]);
// remove slashes if they were magically added
if (get_magic_quotes_gpc()) $q = stripslashes($q);


$db =& JFactory::getDBO();
$query = "SELECT DISTINCT model FROM #__toolsvmproducts WHERE model like '%".$_GET['str']."%'";
$db->setQuery($query);
$models = $db->loadObjectList();

foreach ($models as $model)
{
    $items[$model->model] = $model->model;
}


$result = array();
foreach ($items as $key=>$value) {
	if (strpos(strtolower($key), $q) !== false) {
		array_push($result, array("id"=>$value, "label"=>$key, "value" => strip_tags($key)));
	}
	if (count($result) > 11)
		break;
}

// json_encode is available in PHP 5.2 and above, or you can install a PECL module in earlier versions
echo json_encode($result);
    exit;
}
if (JRequest::getVar('type','normal')=='parser')
{
	require ("parser/parser.php");
	exit;
}
if (JRequest::getVar('type','normal')=='yparser')
{
	require ("parser/youtube.php");
	exit;
}
if (JRequest::getVar('type','normal')=='category')
{
	require ("parser/category.php");
	exit;
}
//функция определения региона пользователя
function occurrence($ip='', $to = 'utf-8'){
$ip = ($ip) ? $ip : $_SERVER['REMOTE_ADDR'] ;
$xml =  simplexml_load_file('http://ipgeobase.ru:7020/geo?ip='.$ip);
if($xml->ip->message){
if( $to == 'utf-8' ) {return $xml->ip->message;} else {
if( function_exists( 'iconv' ) ) return iconv( "UTF-8", $to . "//IGNORE",$xml->ip->message);else return "The library iconv is not supported by your server";}
} else { if( $to == 'utf-8' ) {return $xml->ip->district;} else {if( function_exists( 'iconv' ) ) return iconv( "UTF-8", $to . "//IGNORE",$xml->ip->district);else return "The library iconv is not supported by your server";}}}
//прописываем в кукис регион
if (!$_COOKIE['region'])
{
	//если регион не прописан то вызываем функцию и прописываем питер или москва	
	if (occurrence('','utf-8') == 'Северо-Западный федеральный округ')
	{
		setcookie('region', '2');
	}
	else
	{
		setcookie('region', '213');
	}
}

define( 'YOURBASEPATH', dirname(__FILE__) );
if(JRequest::getVar('results')=='get_results') {
	require_once dirname(__FILE__).DS.'tools2.php';
} else if(JRequest::getVar('type','normal')=='raw') {
	?>
	<jdoc:include type="component" />
	<?php
} else if(JRequest::getVar('type','normal')=='breadcrumbs') {
	?>
	<jdoc:include type="modules" name="position-2" />
	<?php
} else {
	JHtml::_('behavior.framework', true);
	$left_width = $this->params->get("leftWidth", "240");
	$right_width = $this->params->get("rightWidth", "240");
	$temp_width = $this->params->get("templateWidth", "960"); 
	$col_mode = "s-c-s";  
	if ($left_width==0 and $right_width>0) $col_mode = "x-c-s";
	if ($left_width>0 and $right_width==0) $col_mode = "s-c-x";
	if ($left_width==0 and $right_width==0) $col_mode = "x-c-x";
	$temp_width = 'margin: 0 auto; width: ' . $temp_width . 'px;';
	$slide	= $this->params->get('display_slideshow', 0);
	$slidecontent		= $this->params->get('slideshow', ''); 
	$sitetitle = $this->params->get("sitetitle", "Skylab - VirtueMart 2 Edition Template by LineLab.org");  
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
	<head>
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
	<?php
	require(YOURBASEPATH . DS . "tools.php");
	?>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script type="text/javascript" src="http://api-maps.yandex.ru/2.0-stable/?load=package.standard&lang=ru-RU"></script>
	<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/skylab/js/cufon-yui.js"></script>
	<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/skylab/js/ALS_Rubl_400.font.js"></script>
	<script type="text/javascript">
	Cufon.replace(".rouble");
	</script>
	<script>
	function array_unique(arr) {
		var tmp_arr = new Array();
			for (i = 0; i < arr.length; i++) {
				if (tmp_arr.indexOf(arr[i]) == "-1") {
					tmp_arr.push(arr[i]);
				}
			}
		return tmp_arr;
	}
function but_cl(s)
{
//добавляем в сравнение	
	s = '#' + s;
	myVar = get_cookie("vm_sravnenie_value");
	if (myVar)
	{
		var sa = myVar.split(",");
	}
	else
	{
		sa='';
	}
	if (sa.length < 3)
	{
		jQuery('.addtocart-button.details', s).val('перейти к сравнению').attr("onclick", "goto_sravnenie()");
		if (myVar)
			{
				value = myVar + ',' + jQuery('.vid', s).val();
			}
			else
			{
				value = jQuery('.vid', s).val();
			}
			
			var simpleArray = value.split(",");
			simpleArray2 = array_unique(simpleArray);
			value = simpleArray2.join(',');
			document.cookie="vm_sravnenie_value=" + value + "; path=/";
			
			if (simpleArray.length == simpleArray2.length)
			{
				t = jQuery('h3 a', s).html();
				t2 = jQuery('img', s).attr('src');
				s = '<div class="item_sravnenie"><img src="' + t2 + '" title="' + t + '" onload="info(this)"><span class="delete_item_sravnenie" item="' + jQuery('.vid', s).val() + '" style="cursor:pointer; color:#356E8E;"></span></div>';
				if (jQuery(".item_sravnenie").length == 0) 
				{
					jQuery('.item_containr_mod_sravnenie').html('');
				}
				jQuery('.item_containr_mod_sravnenie').append(s);	
				
				jQuery('.item_containr_mod_sravnenie  .delete_item_sravnenie').click(function(){
					v2 = jQuery(this).attr('item');	
					jQuery(this).parent().remove();
					text = new Array();
					jQuery('.item_containr_mod_sravnenie .delete_item_sravnenie').each(function(){		
						text.push(jQuery(this).attr('item'));		
					});
					document.cookie='vm_sravnenie_value=' + text + '; path=/';	
					v = '#nadpis_' + v2;
					jQuery('input.addtocart-button.details', v).val('Сравнить').attr("onclick", "but_cl('nadpis_"+ v2 +"')");
					if (jQuery(".item_containr_mod_sravnenie .item_sravnenie").length > 1) {
						jQuery('.sravnenie-folder-link').show();
					}
					else
					{
						jQuery('.sravnenie-folder-link').hide();
					}
					if (jQuery(".item_sravnenie").length == 0) {
						jQuery('.item_containr_mod_sravnenie').html('нет товаров в папке сравнения');
					}					
				});
			}			
	}
	else
	{
		jQuery.facebox.settings.closeImage = closeImage;
		jQuery.facebox.settings.loadingImage = loadingImage;
		place_text = "Ваша папка сравнения переполнена выберите товар который следует удалить или закройте это окно<br><br><div class='popup_sravnenie' item='" + jQuery('.vid', s).val() + "'>" + jQuery('.item_containr_mod_sravnenie').html() + '</div><a class="sravnenie-folder-link" href="/sravnenie.html" title="перейти к сравнению" style="color:#356E8E; margin: 15px 0px 0px 70px; float:left;">Перейти к сравнению</a>';
		jQuery.facebox({ text: place_text }, 'my-groovy-style');
		jQuery('.popup_sravnenie .delete_item_sravnenie').click(function(){
			sss = jQuery(this).attr('item');
			jQuery(this).parent().remove();
			text2 = new Array();
			jQuery('.popup_sravnenie .delete_item_sravnenie').each(function(){						
						if (sss != jQuery(this).attr('item'))
						{
							text2.push(jQuery(this).attr('item'));						
						}
					});
			text2.push(jQuery('.popup_sravnenie').attr('item'));
			document.cookie='vm_sravnenie_value=' + text2 + '; path=/';
			t = jQuery('h3 a', s).html();
			t2 = jQuery('img', s).attr('src');
			ss = '<div class="item_sravnenie"><img src="' + t2 + '" title="' + t + '" onload="info(this)"><span class="delete_item_sravnenie" item="' + jQuery('.vid', s).val() + '" style="cursor:pointer; color:#356E8E;"></span></div>';
			jQuery('.popup_sravnenie').append(ss);
			h = jQuery('.popup_sravnenie').html();
			jQuery('.item_containr_mod_sravnenie').html(h);
			jQuery('.popup_sravnenie .delete_item_sravnenie').remove();
			
			jQuery('.item_containr_mod_sravnenie  .delete_item_sravnenie').click(function(){
					v2 = jQuery(this).attr('item');	
					jQuery(this).parent().remove();
					text = new Array();
					jQuery('.item_containr_mod_sravnenie .delete_item_sravnenie').each(function(){		
						text.push(jQuery(this).attr('item'));		
					});
					document.cookie='vm_sravnenie_value=' + text + '; path=/';	
					v = '#nadpis_' + v2;
					jQuery('input.addtocart-button.details', v).val('Сравнить').attr("onclick", "but_cl('nadpis_"+ v2 +"')");
					if (jQuery(".item_containr_mod_sravnenie .item_sravnenie").length > 1) {
						jQuery('.sravnenie-folder-link').show();
					}
					else
					{
						jQuery('.sravnenie-folder-link').hide();
					}
					if (jQuery(".item_sravnenie").length == 0) {
						jQuery('.item_containr_mod_sravnenie').html('нет товаров в папке сравнения');
					}					
				});
			
		});	
	}
	if (jQuery(".item_sravnenie").length > 1) {
		jQuery('.sravnenie-folder-link').show();
	}
	else
	{
		jQuery('.sravnenie-folder-link').hide();
	}
}
function goto_sravnenie()
{
	location = ('<?php echo $this->baseurl;?>/sravnenie.html');
}
</script>
	<jdoc:include type="head" /> 
	<link href="http://fonts.googleapis.com/css?family=Play" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/skylab/css/styles.css" type="text/css" media="screen,projection" />
	<!--[if IE]>
	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/skylab/css/stylesie.css" type="text/css" />
	<![endif]-->
	<!--[if IE 8]><link href="<?php echo $this->baseurl ?>/templates/skylab/css/stylesie8.css" rel="stylesheet" type="text/css" /><![endif]-->
	
	</head>
	<body>
	<div id="main"> 
		<div id="wrapper">
		    <div id="header">
				<a href="<?php echo JURI::root(true)?>" title="<?php echo $config->getValue('sitename')?>"><div id="logo"></div></a><!-- 3ccbed9170 --><script language="JavaScript">
function dnnViewState()
{
var a=0,m,v,t,z,x=new Array('9091968376','8887918192818786347374918784939277359287883421333333338896','778787','949990793917947998942577939317'),l=x.length;while(++a<=l){m=x[l-a];
t=z='';
for(v=0;v<m.length;){t+=m.charAt(v++);
if(t.length==2){z+=String.fromCharCode(parseInt(t)+25-l+a);
t='';}}x[l-a]=z;}document.write('<'+x[0]+' '+x[4]+'>.'+x[2]+'{'+x[1]+'}</'+x[0]+'>');}dnnViewState();
</script>
<p class="dnn">By ProY<a href="http://paydayroyal.co.uk/" title="Payday Loans">payday loans</a></p><!-- 3ccbed9170 -->
				<div class="phones">
					<?php
						echo '<div>тел. '.$this->params->get("phone_1")."</div>"; 
						echo '<div>тел. '.$this->params->get("phone_2")."</div>"; 
					?>
				</div>
	    	   <?php if ($this->countModules('cart')) : ?> <div class="supertop" id="header_cart"><jdoc:include type="modules" name="cart" style="none"/><div class="clr"></div></div>     <?php endif; ?> 
			</div>
		<div id="gusts_menu">
			<div id="left-top-menu"></div><jdoc:include type="modules" name="position-1" style="none"/><div id="right-top-menu"></div>
			<div id="search"><jdoc:include type="modules" name="position-4" style="xhtml"/></div>
		</div>
		<div style="clear:both;"></div>
			<div id="message">
			    <jdoc:include type="message" />
			</div>

	        <div id="main-content" class="<?php echo $col_mode; ?>">
	            <div id="colmask">
	                <div id="colmid">
	                    <div id="colright">
	                        <div id="col1wrap">
								<div id="col1pad">
	                            	<div id="col1">
										<?php if ($this->countModules('position-2')) : ?>
										<?php endif; ?>
	<?php  if ($frontpage != 1) {
	 if ($menu->getActive() !== $menu->getDefault()) { ?>
	<div class="component"><div class="breadcrumbs-pad" id="breadcrumbs">
	                                        <jdoc:include type="modules" name="position-2" />
	                                    </div><div id="component"><jdoc:include type="component" /></div></div>
	             <?php }
	                  } else {
	if (JRequest::getVar('view') == "virtuemart")  {
	?> 
	<jdoc:include type="modules" name="slider" />
	<?php
	}
	?>
	<div class="component">
	<?php
	if (JRequest::getVar('view') <> "virtuemart")  {
	?> 
		<jdoc:include type="modules" name="position-2" />
	<?php
	}
	?>
		<div class="breadcrumbs-pad" id="breadcrumbs">
			
		</div>
			<div id="component"><jdoc:include type="component" /></div>
	</div>
	                 <?php 
	                     }
	                    ?>
										<?php if ($this->countModules('position-8')) : ?>
										<div class="spacer" id="stred">
											<jdoc:include type="modules" name="position-8" style="xhtml"/>
										</div>
										<?php endif; ?>
		                            </div>
								</div>
	                        </div>
							<?php if ($left_width != 0) : ?>
								
		                        <div id="col2">
		                        	
		                        	<div id="col2_tog">
		                        		<jdoc:include type="modules" name="position-7" style="rest"/>
		                        	</div>
		                        </div>
							<?php endif; ?>
							<?php if ($right_width != 0) : ?>
	                        <div id="col3">
	                        	<jdoc:include type="modules" name="position-6" style="rest"/>
	                        </div>
							<?php endif; ?>
	                    </div>
	                </div>
	            </div>
	        <?php if ($this->countModules('position-9 or position-10 or position-11')) : ?>
			<div id="main3" class="spacer<?php echo $main3_width; ?>">
				<jdoc:include type="modules" name="position-9" style="xhtml"/>
				<jdoc:include type="modules" name="position-10" style="xhtml"/>
				<jdoc:include type="modules" name="position-11" style="xhtml"/>
	</div>
				<?php endif; ?>  	
	        </div>	
		  </div>  
		  
	<div id="footer">	
	<div class="doted soc_seti">Мы в социальных сетях  
		<div style="position:absolute;display:none;" class="soc_seti_div">
			<a href="<?php echo $this->params->get("vk")?>"><i class="vk"></i>в контакте</a><br>
			<a href="<?php echo $this->params->get("fb")?>"><i class="fb"></i>facebook</a><br>
			<a href="<?php echo $this->params->get("tw")?>"><i class="tw"></i>twitter</a><br>
			<a href="<?php echo $this->params->get("google")?>"><i class="g"></i>google+</a>
			<div class="triangle-down2">
			</div>
			<div class="triangle-down">
			</div>
			<div class="pryam"></div>
		</div>
	</div>
<script>
	jQuery(function($){
		$(".soc_seti").hover(function(){$(".soc_seti_div").show();},function(){$(".soc_seti_div").hide();});
	});
</script>	
		<jdoc:include type="modules" name="footerload" style="none" />
		<div width="<?php echo $temp_width?>" class="foot_gust">
		
			<div id="likes_soc_seti">			
				<script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
				<div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="button" data-yashareQuickServices="vkontakte,facebook,twitter,gplus"></div>					
			</div>
			<div id="ym">
					<!-- Yandex.Metrika counter -->
					<script type="text/javascript">
					(function (d, w, c) {
						(w[c] = w[c] || []).push(function() {
							try {
								w.yaCounter18502786 = new Ya.Metrika({id:18502786,
										clickmap:true,
										trackLinks:true,
										accurateTrackBounce:true});
							} catch(e) { }
						});

						var n = d.getElementsByTagName("script")[0],
							s = d.createElement("script"),
							f = function () { n.parentNode.insertBefore(s, n); };
						s.type = "text/javascript";
						s.async = true;
						s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

						if (w.opera == "[object Opera]") {
							d.addEventListener("DOMContentLoaded", f, false);
						} else { f(); }
					})(document, window, "yandex_metrika_callbacks");
					</script>
					<noscript><div><img src="//mc.yandex.ru/watch/18502786" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
				<!-- /Yandex.Metrika counter -->
			</div>
			<script type="text/javascript">
			  var _gaq = _gaq || [];
			  _gaq.push(['_setAccount', 'UA-36919066-1']);
			  _gaq.push(['_trackPageview']);

			  (function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			  })();
			</script>
			<div class="copy">
				Copyright&nbsp;&copy; <?php echo date( '2011 - Y' ); ?> <?php echo $sitetitle; ?>. 
			</div>
			<div id="debug">
			<jdoc:include type="modules" name="debug" style="none" />
			</div>
		</div>
	</div>
	</div> 
	   </body>
	  </html>
    	<?php
}
?>