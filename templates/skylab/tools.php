<?php
/**
 * @subpackage        tpl_skylab
 * @copyright        Copyright (C) 2011 Linelab.org. All rights reserved.
 * @license          Commercial
 */
 
defined('_JEXEC') or die;
JFactory::getLanguage()->load('com_virtuemart');
$frontpage = $this->params->get('frontpage', 0);
$menu = JSite::getMenu();
$left_width = ($this->countModules('position-7')>0) ? $left_width : 0;
$right_width = ($this->countModules('position-6')>0) ? $right_width : 0;
$temp_width = ''. $temp_width .'';
$inlinestyle = "
#wrapper { ".$temp_width."padding:0;}
	.s-c-s #colmid { left:".$left_width."px;}
	.s-c-s #colright { margin-left:-".($left_width + $right_width)."px;}
	.s-c-s #col1pad { margin-left:".($left_width + $right_width)."px;}
	.s-c-s #col2 { left:".$right_width."px;width:".$left_width."px;}
	.s-c-s #col3 { width:".$right_width."px;}
	.s-c-x #colright { left:".$left_width."px;}
	.s-c-x #col1wrap { right:".$left_width."px;}
	.s-c-x #col1 { margin-left:".$left_width."px;}
	.s-c-x #col2 { right:".$left_width."px;width:".$left_width."px;}
	.x-c-s #colright { margin-left:-".$right_width."px;}
	.x-c-s #col1 { margin-left:".$right_width."px;}
	.x-c-s #col3 { left:".$right_width."px;width:".$right_width."px;}";
$this->addStyleDeclaration($inlinestyle);
$main3_count = ($this->countModules('position-9')>0) + ($this->countModules('position-10')>0) + ($this->countModules('position-11')>0);
$main3_width = $main3_count > 0 ? ' x' . floor(99 / $main3_count) : '';
$main2_count = ($this->countModules('position-3')>0) + ($this->countModules('position-4')>0) + ($this->countModules('position-5')>0);
$main2_width = $main2_count > 0 ? ' x' . floor(99 / $main2_count) : '';
if(JRequest::getCmd('view')=='productdetails') {
	$js2="function setPagination() {
		if(document.getElementById('product_name')) {
			document.id('last_bread_crumb').set('text',document.id('product_name').get('text'));
		}
	}";
	JFactory::getDocument()->addScriptDeclaration($js2);
}
ob_start();
?>
function loadContent(url,data) {
	var body = document.body;
    var html = document.documentElement;
	var height = Math.max( body.scrollHeight, body.offsetHeight,html.clientHeight, html.scrollHeight, html.offsetHeight );

	document.getElementsByTagName('body')[0].appendChild(new Element('div',{
		'id':'preloader'
	}));
	document.getElementById('preloader').setStyle('height',height);
	var table=new Element('table',{
		'id':'preloader_table'
	});
	var tr=table.insertRow(0);
	var td=tr.insertCell(0);
	td.appendChild(new Element('img',{
		'src':'/templates/skylab/images/ajax-loader.gif'
	}));
	document.getElementById('preloader').appendChild(table);
	
	url = '<?php echo "http://".$_SERVER['SERVER_NAME']."/"?>' + url;
	new Request.HTML({
		'url':url,
		'method':'post',
		'data':data,
		'onSuccess':function(tree,elements,html,js) {
			document.getElementById('preloader').parentNode.removeChild(document.getElementById('preloader'));
			document.getElementById('component').innerHTML=html;
			jQuery.noConflict();
			Virtuemart.product(jQuery(".product"));
			if(document.id('extra_cart')) {
				if(document.id('extra_cart').value==1) {
					$$('.addtocart-button').addEvent('click',function() {
						document.id('product_list').addClass('show_products');
						(function(){document.id('product_list').removeClass('show_products')}).delay(15000);
						window.location.hash='cart';
					});
				}
			}			
			/*
			if($('product-list-container')) {
				$('product-list-container').getElements('input[name=special_product_id]').each(function(el) { 
					$('nadpis_'+el.value).addEvents({
						'mouseenter' : function(){
							$('product_link_2_'+el.value).morph({'opacity': '1','top': '-15px'});
							$('cart_link_2_'+el.value).morph({'opacity': '1','top': '15px'});
							$('obrazek_'+el.value+'_img').morph({'opacity': '0.6'});
						},
						'mouseleave' : function(){ 
							$('product_link_2_'+el.value).morph({'opacity': '0','top': '0px'});
							$('cart_link_2_'+el.value).morph({'opacity': '0','top': '0px'});
							$('obrazek_'+el.value+'_img').morph({'opacity': '1'});
						}
					});	
				});
			}
			*/
			if(jQuery('#product-list-container')) {
				jQuery('#product-list-container input[name=special_product_id]').each(function() {					
					jQuery('#nadpis_'+ jQuery(this).val()).hover(
						function()
						{ 
							s = '#product_link_2_' + jQuery('.vid', this).val();
							jQuery(s).animate({  
							opacity: "1",
							top: "-15px",  
							}, 350);
							s = '#cart_link_2_' + jQuery('.vid', this).val();
							jQuery(s).animate({  
							opacity: "1",
							top: "15px",  
							}, 350); 
						}, 
						function()
						{
							s = '#product_link_2_' + jQuery('.vid', this).val();
							jQuery(s).animate({  
							opacity: "0",
							top: "0px",  
							}, 350);
							s = '#cart_link_2_' + jQuery('.vid', this).val();
							jQuery(s).animate({  
							opacity: "0",
							top: "0px",  
							}, 350);
						}
					);
					
				});
			}			
			<?php
			if(JRequest::getCmd('view')=='productdetails') {
				?>
				if(document.getElementById('product_name')) {
					setPagination();
					//jQuery(".product").product();					
					jQuery("form.js-recalculate").each(function(){
						if (jQuery(this).find(".product-fields").length) {
							var id= jQuery(this).find('input[name="virtuemart_product_id[]"]').val();
							jQuery.setproducttype(jQuery(this),id);
						}
					});
					SqueezeBox.initialize({});
					SqueezeBox.assign($$('a.modal'), {
						parse: 'rel'
					});new 
					TabbedContent.init();
				}
				<?php
			}
			?>
			
			jQuery('.orderlistcontainer').hover(
				function() { jQuery(this).find('.orderlist').stop().show()},
				function() { jQuery(this).find('.orderlist').stop().hide()}
			)
			Cufon.refresh();
			if(document.getElementById('order_manufacturer_id')) {
			    var manufacturers=document.getElementById('mod_search_manufacturers').getElementsByTagName('input');
			    for(var i=0;i<manufacturers.length;i++) {
				manufacturers[i].checked=false;
			    }
			    document.getElementById('mod_search_manufacturers_'+document.getElementById('order_manufacturer_id').value).checked=true;
			}
		}
	}).send();
}

function loadBreadcrumbs(url,data) {
	new Request.HTML({
		'url':url,
		'method':'post',
		'data':data,
		'onSuccess':function(tree,elements,html,js) {
			document.id('breadcrumbs').set('html',html);
		}
	}).send();
}

function loadSearchBreadcrumbs(url,data) {
	new Request.JSON({
		'url':url,
		'method':'post',
		'data':data,
		'onSuccess':function(json,text) {
			var manufacturers=json.manufacturers;
			var customs=json.customs;
			
			if(document.id('search_breadcrumbs')) {
				var search=document.id('search_breadcrumbs');
				search.empty();
			} else {
				var breadcrumbs=document.id('breadcrumbs').getElements('div');
				var search=new Element('span',{
					'id':'search_breadcrumbs'
				});
				breadcrumbs.grab(search);
			}
			
			if(customs.length>0) {
				for(var i=0;i<customs.length;i++) {
					var rem=new Element('a',{
						'class':'search_rem'
					});
					rem.appendText(' x ');
					rem.set('id',customs[i].id);
					rem.addEvent('click',function() {
						document.id('mod_search_values_'+this.get('id')).getElements('input').each(function(elm) {
							elm.checked=false;
						});
						submitsearch();
					});
					search.grab(rem);
					search.grab(new Element('img',{
						'src':'/media/system/images/arrow.png'
					}));
					search.appendText(customs[i].title+' :');
					for(var j=0;j<customs[i].values.length;j++) {
						var rem=new Element('a',{
							'class':'search_rem'
						});
						rem.appendText(' x ');
						rem.set('id',customs[i].id);
						rem.set('val',customs[i].values[j]);
						rem.addEvent('click',function() {
							document.id('mod_search_values_'+this.get('id')).getElementById('mod_search_customs_'+this.get('val')).checked=false;
							submitsearch();
						}); 
						search.grab(rem);
						if(customs[i].type=='O') {
							search.appendText(customs[i].values[j]+' ');
						} else if(customs[i].type=='M') {
							search.appendText(customs[i].images[customs[i].values[j]]+' ');
						}
					}	
				}
				
			}
			if(manufacturers.length>0) {
				search.grab(new Element('img',{
					'src':'/media/system/images/arrow.png'
				}));
				/*var rem=new Element('a',{
					'class':'search_rem'
				});
				rem.appendText(' x ');
				rem.addEvent('click',function() {
					document.id('mod_search_manufacturers').getElements('input').each(function(elm) {
						elm.checked=false;
					});
					submitsearch();
				});
				search.grab(rem);
				search.appendText('<?php echo JText::_('COM_VIRTUEMART_PRODUCT_DETAILS_MANUFACTURER_LBL'); ?>');*/
				for(var i=0;i<manufacturers.length;i++) {
					var rem=new Element('a',{
						'class':'search_rem'
					});
					rem.appendText(' x ');
					rem.set('id',manufacturers[i].id);
					rem.addEvent('click',function() {
						document.id('mod_search_manufacturers_'+this.get('id')).checked=false;
						submitsearch();
					});
					search.grab(rem);	
					search.appendText(manufacturers[i].title);
				}
			}
		}
	}).send();
}

window.addEvent('domready',function() {
	if(Cookie.read('col_hide')==1) {
		document.id('col2_tog').setStyle('display','none');
		document.id('col1pad').setStyle('margin-left','0px');
		if(document.id('is_category') && document.id('is_category').value==1) {
			var url='<?php echo JFactory::getUri()->base(true); ?>/index.php?option=com_virtuemart&view=category&virtuemart_category_id='+document.id('is_category').value;
			loadContent(url,'type=raw&per_row=4');
		}
	}
});

function toggle_col() {
	if(document.id('col2_tog').getStyle('display')=='none') {
		document.id('col2_tog').setStyle('display','');
		document.id('col1pad').setStyle('margin-left','240px');
		if(document.id('is_category')) {
			var url='<?php echo JFactory::getUri()->base(true); ?>/index.php?option=com_virtuemart&view=category&virtuemart_category_id='+document.id('is_category').value;
			loadContent(url,'type=raw&per_row=3');
		} else if(document.id('is_results')) {
			var url='<?php echo JFactory::getURI()->base(true); ?>/index.php?results=get_results&type=raw&per_row=3';
			var params=document.id('vm2_search').toQueryString()+'&mod_search[price][from]='+document.getElementById('price_from').options[document.getElementById('price_from').selectedIndex].value+'&mod_search[price][to]='+document.getElementById('price_to').options[document.getElementById('price_to').selectedIndex].value;
			loadContent(url,params);
		}
		Cookie.write('col_hide',0,{
			'duration':24*60*60
		});
	} else {
		document.id('col2_tog').setStyle('display','none');
		document.id('col1pad').setStyle('margin-left','0px');
		if(document.id('is_category') && document.id('is_category').value==1) {
			var url='<?php echo JFactory::getUri()->base(true); ?>/index.php?option=com_virtuemart&view=category&virtuemart_category_id='+document.id('is_category').value;
			loadContent(url,'type=raw&per_row=4');
		} else if(document.id('is_results')) {
			var url='<?php echo JFactory::getURI()->base(true); ?>/index.php?results=get_results&type=raw&per_row=4';	
			var params=document.id('vm2_search').toQueryString()+'&mod_search[price][from]='+document.getElementById('price_from').options[document.getElementById('price_from').selectedIndex].value+'&mod_search[price][to]='+document.getElementById('price_to').options[document.getElementById('price_to').selectedIndex].value;
			loadContent(url,params);
		}
		Cookie.write('col_hide',1,{
			'duration':24*60*60
		});
	}
}
<?php
$js=ob_get_contents();
ob_end_clean();
JFactory::getDocument()->addScriptDeclaration($js);
?>