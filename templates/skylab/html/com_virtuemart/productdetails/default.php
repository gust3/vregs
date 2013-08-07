<?php
/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers, Eugen Stranz
 * @author RolandD,
 * @todo handle child products
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default.php 6414 2012-09-10 08:03:48Z alatak $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
if (JRequest::getVar('action_html') == "saveobzor")
{
    $db = JFactory::getDBO();
    $query ="INSERT #__vmtools_opisanie SET published = 1, text = ".$db->quote(JRequest::getVar('html')).", product_id =".$this->product->virtuemart_product_id;
    $db->setQuery($query);
    $db->query();
    header('Location: ' . "http://video-registratory.com/obzor/".$this->product->slug);
}

// addon for joomla modal Box
JHTML::_('behavior.modal');
// JHTML::_('behavior.tooltip');
$document = JFactory::getDocument();
$document->addScriptDeclaration("
	jQuery(document).ready(function($) {
		$('a.ask-a-question').click( function(){
			$.facebox({
				iframe: '" . $this->askquestion_url . "',
				rev: 'iframe|550|550'
			});
			return false ;
		});
	/*	$('.additional-images a').mouseover(function() {
			var himg = this.href ;
			var extension=himg.substring(himg.lastIndexOf('.')+1);
			if (extension =='png' || extension =='jpg' || extension =='gif') {
				$('.main-image img').attr('src',himg );
			}
			console.log(extension)
		});*/
	});
");

$session =JFactory::getSession();
$session->set( 'somecode', $somecode );
$somecode = $session->get( 'somecode');

/* Let's see if we found the product */
if (empty($this->product)) {
    echo JText::_('COM_VIRTUEMART_PRODUCT_NOT_FOUND');
    echo '<br /><br />  ' . $this->continue_link_html;
    return;
}
?>
  <?php // Product Title   ?>
    <h1>Видеорегистратор <?php echo $this->product->product_name ?></h1>
    <?php // Product Title END   ?>
	
    <?php
    // Product Edit Link
    echo $this->edit_link;
    // Product Edit Link END
    ?>
<div class="gusts_product_details">
	<div class="col1">
		<?php echo $this->loadTemplate('images');?>

	</div>
	<div class="col2">
		<?php
			// Product Short Description
			if (!empty($this->product->product_s_desc)) {
			?>
				<div class="product-short-description">
				<?php
				/** @todo Test if content plugins modify the product description */
				echo nl2br($this->product->product_s_desc);
				?>
				</div>
			<?php
			} // Product Short Description END
		?>
	</div>
	<div class="col3">
	<?php
		echo $this->loadTemplate('showprices');
		echo $this->loadTemplate('addtocart');
	?>
	</div>
</div>
<div style="clear:both;" class="product_details_buttons">
<a class="<?php if (JRequest::getVar('layout', 'default') == 'default') echo "selected"; ?>" href="<?php echo JRoute::_($this->product->link);?>">Характеристики</a>
<a class="<?php if (JRequest::getVar('layout', 'default') == 'otzyvy') echo "selected"; ?>" href="<?php echo JRoute::_('otzyvy/'.$this->product->slug);?>.html">Отзывы</a>
<a class="<?php if (JRequest::getVar('layout', 'default') == 'obzor') echo "selected"; ?>" href="<?php echo JRoute::_('obzor/'.$this->product->slug);?>.html">Обзор</a>
<a class="<?php if (JRequest::getVar('layout', 'default') == 'video') echo "selected"; ?>" href="<?php echo JRoute::_('video/'.$this->product->slug);?>.html">Видео</a>
</div>



<?php
//смотрим как будет слой и выводим нужную информацию
switch (JRequest::getVar('layout', 'default')) {
case 'default':
//нет слоя
?>
	<div class="gust_custom_fields">
	<?php
		if (!empty($this->product->customfieldsSorted['normal'])) {
		$this->position = 'normal';		
		
		echo $this->loadTemplate('customfields');
		} // Product custom_fields END 
	?>
	</div>
<?php
	echo $this->loadTemplate('map');
	break;
case 'otzyvy':
//слой отзывы


	function otvet_print($parent, $step, $otzyvy)
	{
	
		foreach ($otzyvy as $item) {
			if ($item->parent == $parent)
			{
				?>
				<div style="border:1px grey solid; padding:10px; margin-top:10px; margin-left:<?php echo 10*$step;?>px;">
				<div class="nick"><?php if($item->user) echo $item->user."<br>"; else echo "без имени<br>";?></div>
				<div><?php echo $item->comment?></div>
				<div class="answer" item_id="<?php echo $item->id;?>">ответить</div>
				</div>
				<?php
				otvet_print($item->id, $step + 1, $otzyvy);
			}
		}
	}
?>
	<div style="clear:both; margin-bottom:10px;">
		<?php foreach ($this->otzyvy as $item) {
		if ($item->parent > 0) continue;
		?>	
		<div style="border:1px grey solid; padding:10px; margin-top:10px;">
		<div class="nick"><?php 
		
		$item->minusy = str_replace('Недостатки:','Недостатки:<br>',$item->minusy);
		$item->minusy = str_replace('Достоинства:','Достоинства:<br>',$item->minusy);
		$item->minusy = str_replace('Комментарий:','Комментарий:<br>',$item->minusy);
		$item->plusy = str_replace('Недостатки:','Недостатки:<br>',$item->plusy);
		$item->plusy = str_replace('Достоинства:','Достоинства:<br>',$item->plusy);
		$item->plusy = str_replace('Комментарий:','Комментарий:<br>',$item->plusy);
		$item->comment = str_replace('Недостатки:','Недостатки:<br>',$item->comment);
		$item->comment = str_replace('Достоинства:','Достоинства:<br>',$item->comment);
		$item->comment = str_replace('Комментарий:','Комментарий:<br>',$item->comment);
		
		if($item->user) echo $item->user."<br>"; else echo "без имени<br>";
		for ($i=0;$i<$item->reiting;$i++)
		{			
			echo '<img src="'.$this->baseurl.'/templates/skylab/images/star.png" width="14">';
		}		
		?></div>
		<div><?php echo $item->minusy?></div>
		<div><?php echo $item->plusy?></div>
		<div><?php echo $item->comment?></div>
		<div class="otziv_show_form">добавить отзыв</div><div class="answer" item_id="<?php echo $item->id;?>">ответить</div>
		</div>
		<?php
		otvet_print($item->id, 1, $this->otzyvy);
		}
		?>
		<div style="text-align:right;">все отзывы предоставлены <a href="http://market.yandex.ru">http://market.yandex.ru</a></div>
		<form id="sent_otziv_form" style="display:none;">
		<div class="add_comment_otzivi">
		<div class="otzivi_info"></div>
		Имя:<input type="text" name="user" size="20" value=""/>
		<?php
		for ($i=0;$i<5;$i++)
		{			
			echo '<img class="star_edit" src="'.$this->baseurl.'/templates/skylab/images/star_hide.png" width="14" reiting="'.$i.'"/>';
		}
		?>
		<br>
		<input type="hidden" name="reiting" size="20" value=""/>
		Плюсы: <textarea name="plusy"></textarea>
		Минусы: <textarea name="minusy"></textarea>
		Коментарий: <textarea name="comment"></textarea>
		<div style="text-align:center;"><img class="img_captcha" src="<?php echo $this->baseurl?>/components/com_virtuemart/kcaptcha/index.php?<?php echo session_name(); ?>=<?php echo session_id(); ?>" alt="Captcha" /><br>
		<div class="refresh_captcha">обновить</div>
		<input type="text" name="captcha" size="20" style="margin:10px auto;"/><br></div>
		<input type="button" value="отправить" style="margin:0 auto;" id="sent_otziv">
		<input type="hidden" value="<?php echo $this->product->virtuemart_product_id?>" name="product_id">

		<script>
		jQuery(function($){			
			$('.answer').click(function(){
				$("#sent_otziv_form").hide();
				if ($(this).attr('item') == 1)
				{
					$('.otvet_div').remove();
					$(this).removeAttr("item");
				}
				else
				{
					$('.answer').removeAttr("item");
					$('.otvet_div').remove();
					$(this).parent().after('<div id="' + $(this).attr('item') + '" class="otvet_div"><div class="otziv_info_otvet"></div><form id="form_otziv">Имя: <input class="otvet_name" type="text" name="user" value=""/>Ответ:<br><textarea name="comment" class="com_textarea_otvet"></textarea><br><img class="img_captcha_otvet" src="<?php echo $this->baseurl ?>/components/com_virtuemart/kcaptcha/index.php?' + Math.random() + '"><br><br><input type="text" name="captcha" class="captcha_otvet"><input type="hidden" value="' + $(this).attr('item_id') + '" name="parent"><input type="hidden" value="<?php echo $this->product->virtuemart_product_id?>" name="product_id"><input type="button" class="repply_button" value="ответить"></form></div>');
					$(this).attr("item", "1");
					$('.repply_button').click(function(){
						vars = $("#form_otziv").serializeArray();
						$.post('index.php?option=com_gustvmtools&view=ajaxotziv&type=raw&otzivtype=otvet', vars , function(data) {
							if (data == 1)
							{
								$(".otvet_name").val('');
								$(".com_textarea_otvet").val('');
								$(".captcha_otvet").val('');
								data="отзыв отправлен на модерацию"
							}
							$('.otziv_info_otvet').html(data);
							$('.img_captcha_otvet').attr("src", "<?php echo $this->baseurl ?>/components/com_virtuemart/kcaptcha/index.php?" + Math.random());
						});						
					});
				}
			});
			
			$(".refresh_captcha").click(function(){
				$('.img_captcha').attr("src", "<?php echo $this->baseurl ?>/components/com_virtuemart/kcaptcha/index.php?" + Math.random());
			});
			$('#sent_otziv').click(function(){
				
				vars = $("#sent_otziv_form").serializeArray();
				$.post('index.php?option=com_gustvmtools&view=ajaxotziv&type=raw', vars , function(data) {
					if (data == 1)
					{
						$('textarea[name=plusy]').val('');
						$('textarea[name=minusy]').val('');
						$('textarea[name=comment]').val('');
						$('input[name="captcha"]').val('');
						data="отзыв отправлен на модерацию"
					}
					$('.otzivi_info').html(data);
					$('.img_captcha').attr("src", "<?php echo $this->baseurl ?>/components/com_virtuemart/kcaptcha/index.php?" + Math.random());
				});
			});
			$(".star_edit").hover(
				  function () {
					$(this).attr('src', "<?php echo $this->baseurl.'/templates/skylab/images/star.png';?>");
					v = $(this).attr('reiting');
					$(".star_edit").each(function(){
						if ($(this).attr('reiting') < v){
							$(this).attr('src', "<?php echo $this->baseurl.'/templates/skylab/images/star.png';?>");
						}
					});
					
				  },
				  function () {
					$(this).attr('src', "<?php echo $this->baseurl.'/templates/skylab/images/star_hide.png';?>");
					v = $(".star_edit.selected").attr('reiting');
					$(".star_edit").each(function(){						
						if (v)
						{
						if ($(this).attr('reiting') >= v+1)
						{
							$(this).attr('src', "<?php echo $this->baseurl.'/templates/skylab/images/star_hide.png';?>");
						}
						else
						{
							$(this).attr('src', "<?php echo $this->baseurl.'/templates/skylab/images/star.png';?>");
						}
						}
						else
						{
							$(this).attr('src', "<?php echo $this->baseurl.'/templates/skylab/images/star_hide.png';?>");
						}
					});
				  }
				);
			$(".star_edit").click(function(){
				$(".star_edit").each(function(){
					$(this).removeClass('selected');
				});
				$(this).addClass('selected');
				$('input[name="reiting"]').val(parseInt($(this).attr('reiting')) + 1);
			});
			$(".otziv_show_form").click(function(){
				$("#sent_otziv_form").toggle();
				$('.img_captcha').attr("src", "<?php echo $this->baseurl ?>/components/com_virtuemart/kcaptcha/index.php?" + Math.random());
				$('.answer').removeAttr("item");
				$('.otvet_div').remove();
				$("html,body").animate({scrollTop: $('#sent_otziv_form').offset().top}, 1000);
			});
		});		
		</script>
		</div>
		
		</form>
	</div>
<?php
	break;
case 'obzor':
//слой описание
?>
	<div style="clear:both;">
		<?php 
    if (count($this->obzor) == 0)
    {
    ?>
    <h2>Обзор видеорегистратора <?php echo $this->product->product_name ?></h2>
    <p>Это автомобильный видеорегистратор, позволяющий вести наблюдение за дорогой. Это устройство дает возможность чувствовать себя безопаснее на дороге. Прежде всего легче установить  правду и вы защищены от произвола ГАИ.</p>
    <p>Для этого видеорегистратора нет подробного обзора. Вы можете добавить его.</p>
   
    <?php
    $user = & JFactory::getUser();
    ?>
    <form method="post">
    <?php
    if (!$user->guest) {
        
        //Подключение редактора
    $editor =& JFactory::getEditor();
    echo $editor->display('html', "", '550', '400', '60', '20', true );
    ?>
    <input type="submit" class="button" value="добавить" style="margin-left:790px;">
    <input type="hidden" value="saveobzor" name="action_html">
    </form>
    <?php
    }
    else
    {
    ?>
    <p><strong>Зарегестрируйтесь чтобы добавить</strong></p>
    <?php
    }
    }
    else
    {
    foreach ($this->obzor as $item) {?>
				<div style="padding:10px;"><?php echo $item->text?></div>
	<?php 
    }
    }
    ?>
	</div>
<?php
	break;
case 'video':
//слой видео
?>
	<div style="clear:both;">
		<?php foreach ($this->video as $item) {?>
				<div style="width:50%;float:left; margin-top:10px; text-align:center;">
					<iframe width="420" height="315" src="http://www.youtube.com/embed/<?php echo $item->url?>" frameborder="0" allowfullscreen></iframe>
					<p style="text-align:center; width:100%;"><?php echo $item->comment?></p>
				</div>
		<?php } ?>
		<div style="clear:both;"></div>
	</div>
<?php
	break;
}
?>