<?php
/*
 * Created on Jan 14, 2012
 *
  * Author: Linelab.org
 * Project: vm2_search
 */

defined('_JEXEC') or die('Restricted access');

$used_manufacturers=JFactory::getApplication()->getUserState('mod_vm2_search.manufacturers');
$price=JFactory::getApplication()->getUserState('mod_vm2_search.price');
$customs=JFactory::getApplication()->getUserState('mod_vm2_search.customs');

JHTML::script('vmprices.js', 'components/com_virtuemart/assets/js/', false);
JFactory::getDocument()->addScriptDeclaration("
function submitsearch() {
	loadContent('index.php?results=get_results',document.id('vm2_search').toQueryString()+'&mod_search[price][from]='+document.getElementById('price_from').options[document.getElementById('price_from').selectedIndex].value+'&mod_search[price][to]='+document.getElementById('price_to').options[document.getElementById('price_to').selectedIndex].value);
	loadSearchBreadcrumbs('index.php?results=get_results&type=breadcrumbs',document.id('vm2_search').toQueryString()+'&mod_search[price][from]='+document.getElementById('price_from').options[document.getElementById('price_from').selectedIndex].value+'&mod_search[price][to]='+document.getElementById('price_to').options[document.getElementById('price_to').selectedIndex].value);
}");
?>
<script type="text/javascript">
function reset_form() {
	var form=document.id('vm2_search');
	var inputs=form.getElements('input');
	inputs.each(function(el) {
		el.checked=false;
	});
	document.id('price_from').selectedIndex=0;
	jQuery('#price_from').trigger('click');
	document.id('price_to').selectedIndex=document.id('price_to').length-1;
	jQuery('#price_to').trigger('click');
	submitsearch();
}
</script>
<style type="text/css">
.field .title {
	font-weight:bold;
}
.value .inputbox {
	display:inline !important;
}
</style>
<div id="vm2_search">
	<div class="field">
		<div class="title">
			<?php echo JText::_('MOD_VM2_SEARCH_PRICE'); ?>
		</div>
		<div id="fields_prices">
		<span style="margin-left:10px; float:left; margin-right:15px;">от</span><input disabled value="100" id="ot" style="float:left; width:40px; margin-right:10px;"><span style="float:left; margin-right:10px;">до</span><input disabled style="float:left; width:40px; margin-right:10px;" value="20000" id="do">
		</div>
		
		<script>
			jQuery(function($){
				$("#apply_button").click(function(){					
					
					$("#fields_prices input").each(function()
					{
						$(this).val(parseInt($(this).val()));
						if ($(this).val() == "NaN") {					
							if ($(this).attr("id") == "ot")
							{						
								$(this).val("100");						
							}	
							else
							{						
								$(this).val("20000");						
							}
						}
						s = Math.floor(parseInt($(this).val())/100)*100;
						$(this).val(s);
						if (parseInt($(this).val()) > 20000) { $(this).val("20000") }
						if (parseInt($(this).val()) < 100) { $(this).val("100") }
						if (parseInt($("#do").val()) < parseInt($("#ot").val()))
						{
							$("#do").val($("#ot").val());
						}
					});
					
					
					/*	
					l = Math.floor((parseInt($("#ot").val())/19900)*100) + "%";
					l2 = Math.floor((parseInt($("#do").val())/19900)*100) + "%";
					$("#handle_price_from").css("left", l);
					$("#handle_price_to").css("left", l2);*/
					$("#handle_price_from .ttContent").html($("#ot").val());
					$("#handle_price_to .ttContent").html($("#do").val());
					$("#price_from option").removeAttr("selected");
					$("#price_to option").removeAttr("selected");
					$("#price_from option").each(function(){
						if (parseInt($(this).attr("value")) == parseInt($("#ot").val()))
						{
							$(this).attr("selected", "selected");
						}
					
					});
					$("#price_to option").each(function(){
						if (parseInt($(this).attr("value")) == parseInt($("#do").val()))
						{
							$(this).attr("selected", "selected");
						}
					
					});
					submitsearch();
				});
				/*
				$("#ot").click(function(){
					jQuery.facebox.settings.closeImage = closeImage;
					jQuery.facebox.settings.loadingImage = loadingImage;
					//формируем хтмл-код окна 
					place_text = "<span style='float:left;margin-top:2px;'>Введите число:</span> <input type='text' style='float:left; margin-left:5px; width:40px; height:10px; font-size:10px;' value='" + $(this).val() +"'><span class='apply' title='применить'></span>";
					//вызываем окно
					jQuery.facebox({ text: place_text }, 'facebox-input');
					
					jQuery(".apply").click(function(){
						
					
					});
				});
				*/
			});		
		</script>
		<div id="priceslider" class="values" style="width:200px;height:50px; display:inline-block;">
		<?php echo $prices["price_from"]; ?>
		<?php echo $prices["price_to"]; ?>
		</div>
	</div>
	<?php
	if($params->get('show_manufacturers',1)) {
		?>
		<div class="field">
			<div class="man_title">
				<?php echo JText::_('MOD_VM2_SEARCH_MANUFACTURER'); ?><br>
			</div>	
			<div class="values" id="mod_search_manufacturers">
				<a id="popular" href="" class="bold">популярные</a> | <a id="all" href="">все</a>
				<br><br>
				<?php
				foreach($manufacturers as $manufacturer) {
					?>
					<div class="value <? if ($manufacturer->main == 0) echo 'manufacturer-all'?>" style="float:left; width:95px; <? if ($manufacturer->main == 0) echo 'display:none;'?>">
						<input class="inputbox" type="checkbox"  name="mod_search[manufacturers][]" id="mod_search_manufacturers_<?php echo $manufacturer->id; ?>" value="<?php echo $manufacturer->id; ?>" <?php echo (isset($used_manufacturers) && in_array($manufacturer->id,$used_manufacturers))?'checked="checked"':''; ?> />
						<label title="<?php echo $manufacturer->title; ?>" for="mod_search_manufacturers_<?php echo $manufacturer->id; ?>" style="width:60px; overflow:hidden;"><?php if (strlen($manufacturer->title) > 8)  { echo mb_substr($manufacturer->title, 0, 7)."..";} else  {echo $manufacturer->title;}?></label>
					</div>
					<?php
				}
				?>
				<div style="clear:both"></div>
			</div>
		</div>
	<?php
	}
	?>
	
<div class="field">
  <span class="doted" id="construction">    
		Конструкция    
  </span>
  <div class="values" id="mod_search_values_4" style="display:none;">
    <div class="value">
      <input class="inputbox" type="checkbox"  name="mod_search[customs][2][]" id="mod_search_customs_без камеры, с экраном" value="без камеры">
      <label for="mod_search_customs_без камеры, с экраном">без камеры</label>
    </div>
	<div class="value">
      <input class="inputbox" type="checkbox"  name="mod_search[customs][2][]" id="mod_search_customs_две камеры, с экраном" value="две камеры">
      <label for="mod_search_customs_две камеры">две камеры</label>
    </div>
    <div class="value">
      <input class="inputbox" type="checkbox"  name="mod_search[customs][2][]" id="mod_search_customs_с камерой, с экраном" value="с камерой">
      <label for="mod_search_customs_с камерой, с экраном">с камерой</label>
    </div>
	<div class="value">
      <input class="inputbox" type="checkbox"  name="mod_search[customs][2][]" id="mod_search_customs_зеркало заднего вида, с экраном" value="с экраном">
      <label for="mod_search_customs_зеркало заднего вида, с экраном">с экраном</label>
    </div>
</div>
</div>

<div class="field">
  <div class="doted" id="razreshenie">
		Макс. разрешение видеозаписи
    <br>
  </div>
	<div class="values" id="mod_search_values_7" style="display:none;">
    <div class="value">
      <input class="inputbox" type="checkbox"  name="mod_search[customs][5][]" id="mod_search_customs_704x576 при 50 к/с " value="1920x1080">
      <label for="mod_search_customs_704x576 при 50 к/с ">1920x1080</label>
    </div>
	<div class="value">
      <input class="inputbox" type="checkbox"  name="mod_search[customs][5][]" id="mod_search_customs_704x576 при 50 к/с " value="1920x1080">
      <label for="mod_search_customs_704x576 при 50 к/с ">1440x1080</label>
    </div>
	<div class="value">
      <input class="inputbox" type="checkbox"  name="mod_search[customs][5][]" id="mod_search_customs_1280x1024 " value="1280x1024">
      <label for="mod_search_customs_1280x1024 ">1280x1024</label>
    </div>
	<div class="value">
      <input class="inputbox" type="checkbox"  name="mod_search[customs][5][]" id="mod_search_customs_704x576 при 50 к/с " value="1280x960">
      <label for="mod_search_customs_704x576 при 50 к/с ">1280x960</label>
    </div>
    <div class="value">
      <input class="inputbox" type="checkbox"  name="mod_search[customs][5][]" id="mod_search_customs_704x576 при 50 к/с " value="1280x720">
      <label for="mod_search_customs_704x576 при 50 к/с ">1280x720</label>
    </div>
	<div class="value">
      <input class="inputbox" type="checkbox"  name="mod_search[customs][5][]" id="mod_search_customs_1280x480 при 30 к/с " value="1280x480">
      <label for="mod_search_customs_1280x480 при 30 к/с ">1280x480</label>
    </div>
	<div class="value">
      <input class="inputbox" type="checkbox"  name="mod_search[customs][5][]" id="mod_search_customs_640x480 " value="640x480">
      <label for="mod_search_customs_640x480 ">640x480</label>
    </div>
	<div class="value">
      <input class="inputbox" type="checkbox"  name="mod_search[customs][5][]" id="mod_search_customs_840x480 " value="840x480">
      <label for="mod_search_customs_840x480 ">840x480</label>
    </div>
    <div class="value">
      <input class="inputbox" type="checkbox"  name="mod_search[customs][5][]" id="mod_search_customs_720x480 при 15 к/с, 320x240 при 30 к/с " value="720x480">
      <label for="mod_search_customs_720x480 при 15 к/с, 320x240 при 30 к/с ">720x480</label>
    </div>
	<div class="value">
      <input class="inputbox" type="checkbox"  name="mod_search[customs][5][]" id="mod_search_customs_704x576" value="704x576">
      <label for="mod_search_customs_704x576 ">704x576</label>
    </div>
	<div class="value">
      <input class="inputbox" type="checkbox"  name="mod_search[customs][5][]" id="mod_search_customs_656x488 при 30 к/с " value="656x488">
      <label for="mod_search_customs_656x488 при 30 к/с ">656x488</label>
    </div>
	<div class="value">
      <input class="inputbox" type="checkbox"  name="mod_search[customs][5][]" id="mod_search_customs_720x480 при 15 к/с, 320x240 при 30 к/с " value="320x240">
      <label for="mod_search_customs_720x480 при 15 к/с, 320x240 при 30 к/с ">320x240</label>
    </div>
	<div class="value">
      <input class="inputbox" type="checkbox"  name="mod_search[customs][5][]" id="mod_search_customs_704x576 " value="352x288">
      <label for="mod_search_customs_704x576 ">352x288</label>
    </div>
	</div>
</div>

<div class="field">
  <div class="values" id="mod_search_values_37">
    <div class="value">
      <input class="inputbox" type="checkbox"  name="mod_search[customs][35][]" id="mod_search_customs_датчик движения (G-сенсор), GPS" value="Датчик движения">
      <label for="mod_search_customs_датчик движения (G-сенсор), GPS">Датчик движения</label>
    </div>
    <div class="value">
      <input class="inputbox" type="checkbox"  name="mod_search[customs][35][]" id="mod_search_customs_детектор движения в кадре" value="GPS">
      <label for="mod_search_customs_детектор движения в кадре">GPS</label>
    </div>
    <div class="value">
      <input class="inputbox" type="checkbox"  name="mod_search[customs][35][]" id="mod_search_customs_датчик движения (G-сенсор), GPS, детектор движения в кадре" value="ГЛОНАСС">
      <label for="mod_search_customs_датчик движения (G-сенсор), GPS, детектор движения в кадре">ГЛОНАСС</label>
    </div>
	<div class="value">
      <input class="inputbox" type="checkbox"  name="mod_search[customs][8][]" id="mod_search_customs_встроенный микрофон" value="встроенный микрофон">
      <label for="mod_search_customs_встроенный микрофон">встроенный микрофон</label>
    </div>
  </div>
</div>

	<?php
	if($params->get('show_cart_fields',1)) {
		foreach($catr_vars as $field) {
			?>
			<div class="field">
				<div class="title">
					<?php echo $field->title; ?>
				</div>
				<div class="values" id="mod_search_values_<?php echo $field->id; ?>">
					<?php
					foreach($cart_vars_values[$field->id] as $value) {
						?>
						<div class="value">
							<input class="inputbox" type="checkbox"  name="mod_search[customs][<?php echo $value->id; ?>][]" id="mod_search_customs_<?php echo $value->value; ?>" value="<?php echo $value->value; ?>" <?php echo (isset($customs[$value->id]) && in_array($value->value,$customs[$value->id]))?'checked="checked"':''; ?> />
							<label for="mod_search_customs_<?php echo $value->value; ?>"><?php echo $value->value; ?></label>
						</div>
						<?php
					}
					?>
				</div>
			</div>
			<?php
		}
	}
	?>
	<?php
	if($params->get('show_custom_fields',1)) {
		foreach($fields as $field) {
			?>
			<div class="field">
				<div class="title">
					<?php echo $field->title; ?><br>			
				</div>
				<div class="values" id="mod_search_values_<?php echo $field->id; ?>">
						<?php
						foreach($values[$field->id] as $value) {
							?>
							<div class="value">
								<input class="inputbox" type="checkbox"  name="mod_search[customs][<?php echo $value->id; ?>][]" id="mod_search_customs_<?php echo $value->value; ?>" value="<?php echo $value->value; ?>" <?php echo (isset($customs[$value->id]) && in_array($value->value,$customs[$value->id]))?'checked="checked"':''; ?> />
								<label for="mod_search_customs_<?php echo $value->value; ?>"><?php echo $value->value; ?></label>
							</div>
							<?php
						}
						?>
				</div>
			</div>
			<?php
		}
	}
	foreach($media_fields as $field) {
		?>
		<div class="field">
			<div class="title">
				<?php echo $field->title; ?>
			</div>
			<div class="values" id="mod_search_values_<?php echo $field->id; ?>" style="display:none;">
				<?php
				foreach($media_values[$field->id] as $value) {
					?>
					<div class="value search_images">
						<input class="inputbox nodisplay" type="checkbox"  name="mod_search[customs][<?php echo $value->id; ?>][]" id="mod_search_customs_<?php echo $value->value; ?>" value="<?php echo $value->value; ?>" <?php echo (isset($customs[$value->id]) && in_array($value->value,$customs[$value->id]))?'checked="checked"':''; ?> />
						<label for="mod_search_customs_<?php echo $value->value; ?>"><?php echo JHTML::_('image',$value->image,$value->alt); ?></label>
						<!--<label for="mod_search_customs_<?php echo $value->value; ?>"><?php echo $value->alt; ?></label>-->
					</div>
					<?php
				}
				?>
			</div>
		</div>
		<?php
	}
	?> <div class="clr"></div>
	<div class="reset">
		<input class="button" id="apply_button" type="button" onclick="" value="<?php echo JText::_('применить'); ?>" style="float:left;"/>
        <input class="button" type="button" onclick="reset_form();" value="<?php echo JText::_('MOD_VM2_RESET_FORM'); ?>" style="float:left;"/>
	</div>
	<div style="clear:both;"></div>
	<input type="hidden" name="virtuemart_category_id" id="virtuemart_category_id" value="<?php //echo JRequest::getInt('virtuemart_category_id'); ?>0" />
</div>
<script>
	jQuery(function($){
		$("#popular").click(function(event){
			event.preventDefault();
			$('.manufacturer-all').hide();
			$("#all").removeClass('bold');
			$("#popular").addClass('bold');
		});
		$("#all").click(function(event){
		event.preventDefault(); 
		$('.manufacturer-all').show();
		$("#popular").removeClass('bold');
		$("#all").addClass('bold');
		});
		$("#construction").click(function(){$("#mod_search_values_4").toggle();});
		$("#razreshenie").click(function(){$("#mod_search_values_7").toggle();});		
	})
</script>