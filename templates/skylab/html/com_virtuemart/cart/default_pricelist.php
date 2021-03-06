	<?php defined('_JEXEC') or die('Restricted access');
/**
 *
 * Layout for the shopping cart
 *
 * @package	VirtueMart
 * @subpackage Cart
 * @author Max Milbers
 * @author Patrick Kohl
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 *
 */
JHTML::stylesheet ( 'plugins/system/onepage/onepage.css');
// Check to ensure this file is included in Joomla!
$plugin=JPluginHelper::getPlugin('system','onepage');
$params=new JRegistry($plugin->params);
$db = JFactory::getDBO();
?>
<div class="billto-shipto">
	<div class="width50 floatleft">

		<span><span class="vmicon vm2-billto-icon"></span>
		<?php echo JText::_('COM_VIRTUEMART_USER_FORM_BILLTO_LBL'); ?></span>
		<div class="output-billto">
		<div class="clear"></div>
		</div>
		
		<?php echo JText::_('COM_VIRTUEMART_USER_FORM_EDIT_BILLTO_LBL'); ?>
		<?php
		if(JFactory::getUser()->get('id')==0 && VmConfig::get('oncheckout_show_register')) {
			?>
			<input class="inputbox" type="checkbox" name="register" id="register" value="1" onclick="toggle_register(this.checked);" <?php echo $params->get('check_register')?'checked="checked"':''; ?>/>
			<?php echo JText::_('COM_VIRTUEMART_REGISTER'); ?>
		<?php
		}
		$userFields=array('agreed','name','username','password','password2');
		echo '<div id="div_billto">';
		echo '	<table class="adminform user-details" id="table_user" '.($params->get('check_register')?'':'style="display:none"').'>' . "\n";
		foreach($this->helper->BTaddress["fields"] as $_field) {
			if(!in_array($_field['name'],$userFields)) {
				continue;
			}
			if($_field['name']=='agreed') {
				continue;
			}
			echo '		<tr>' . "\n";
		    echo '			<td class="key">' . "\n";
		    echo '				<label class="' . $_field['name'] . '" for="' . $_field['name'] . '_field">' . "\n";
		    echo '					' . $_field['title'] . ($_field['required'] ? ' *' : '') . "\n";
		    echo '				</label>' . "\n";
		    echo '			</td>' . "\n";
		    echo '			<td>' . "\n";
		    echo '				' . $_field['formcode'] . "\n";
		    echo '			</td>' . "\n";
		    echo '		</tr>' . "\n";
		}
		echo '	</table>' . "\n";
		echo '	<table class="adminform user-details" id="table_billto">' . "\n";
		foreach($this->helper->BTaddress["fields"] as $_field) {
			if(in_array($_field['name'],$userFields)) {
				continue;
			}
			echo '		<tr>' . "\n";
		    echo '			<td class="key">' . "\n";
		    echo '				<label class="' . $_field['name'] . '" for="' . $_field['name'] . '_field">' . "\n";
		    echo '					' . $_field['title'] . ($_field['required'] ? ' *' : '') . "\n";
		    echo '				</label>' . "\n";
		    echo '			</td>' . "\n";
		    echo '			<td>' . "\n";
		    if($_field['name']=='zip') {
		    	$_field['formcode']=str_replace('input','input onchange="update_form();"',$_field['formcode']);
		    } else if($_field['name']=='virtuemart_country_id') {
		    	$_field['formcode']=str_replace('<select','<select onchange="update_form();"',$_field['formcode']);
		    } else if($_field['name']=='virtuemart_state_id') {
		    	$_field['formcode']=str_replace('<select','<select onchange="update_form();"',$_field['formcode']);
		    }
		    echo '				' . $_field['formcode'] . "\n";
		    echo '			</td>' . "\n";
		    echo '		</tr>' . "\n";
		}
	    echo '	</table>' . "\n";
	    echo '</div>';
		?>
	</div>
    <div class="width50 floatleft" id="div_shipto">
    
    		<?php // Leave A Comment Field ?>
		<div class="customer-comment marginbottom15" style="margin-right:20px;">
			<span class="comment"><?php echo JText::_('COM_VIRTUEMART_COMMENT'); ?></span><br />
			<textarea style="margin-top:15px;" class="customer-comment" name="customer_comment" cols="50" rows="6"><?php echo $this->cart->customer_comment; ?></textarea>
		</div>
		<?php // Leave A Comment Field END ?>   
    
    </div>
    
    
    
    
    
    
    
    
    
    
	
    <div class="width50 floatleft" id="div_shipto" style="display:none;">
		<span class="vmicon vm2-shipto-icon"></span>
		<div class="output-shipto">
		<?php
		if(!empty($this->cart->STaddress['fields'])){
			if(!class_exists('VmHtml'))require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'html.php');
				echo JText::_('COM_VIRTUEMART_USER_FORM_ST_SAME_AS_BT');
				?>
				<input class="inputbox" type="checkbox" name="STsameAsBT" id="STsameAsBT" checked="checked" value="1" onclick="set_st(this);"/><br />
				<?php
		}
 		?>
		<div class="clear"></div>
		</div>
		<?php if(!isset($this->cart->lists['current_id'])) $this->cart->lists['current_id'] = 0; ?>
		<?php
		echo '	<table class="adminform user-details" id="table_shipto" '.($params->get('check_shipto_address')==1?'style="display:none"':'').'>' . "\n";
		foreach($this->helper->STaddress["fields"] as $_field) {
			echo '		<tr>' . "\n";
		    echo '			<td class="key">' . "\n";
		    echo '				<label class="' . $_field['name'] . '" for="' . $_field['name'] . '_field">' . "\n";
		    echo '					' . $_field['title'] . ($_field['required'] ? ' *' : '') . "\n";
		    echo '				</label>' . "\n";
		    echo '			</td>' . "\n";
		    echo '			<td>' . "\n";
		    if($_field['name']=='shipto_zip') {
		    	$_field['formcode']=str_replace('input','input onchange="update_form();"',$_field['formcode']);
		    } else if($_field['name']=='shipto_virtuemart_country_id') {
		    	$_field['formcode']=str_replace('<select','<select onchange="update_form();add_countries();"',$_field['formcode']);
		    	$_field['formcode']=str_replace('class="virtuemart_country_id','class="shipto_virtuemart_country_id',$_field['formcode']);
		    } else if($_field['name']=='shipto_virtuemart_state_id') {
		    	$_field['formcode']=str_replace('id="virtuemart_state_id"','id="shipto_virtuemart_state_id"',$_field['formcode']);
		    	$_field['formcode']=str_replace('<select','<select onchange="update_form();"',$_field['formcode']);
		    }
		    echo '				' . $_field['formcode'] . "\n";
		    echo '			</td>' . "\n";
		    echo '		</tr>' . "\n";
		}
	    echo '	</table>' . "\n";
		?>

	</div>

	<div class="clear"></div>
</div>

<fieldset id="cart-contents">
	<table
		class="cart-summary"
		cellspacing="0"
		cellpadding="0"
		border="0"
		width="100%">
		<tr>
			<th align="left"><?php echo JText::_('COM_VIRTUEMART_CART_NAME') ?></th>
			<th
				align="right"
				width="110px"><?php echo JText::_('COM_VIRTUEMART_CART_QUANTITY') ?>
				/ <?php echo JText::_('COM_VIRTUEMART_CART_ACTION') ?></th>
			</tr>



		<?php
		$i=1;
		
		foreach( $this->cart->products as $pkey =>$prow ) {
			$query = 'SELECT np.id_net, np.price, ns.ymname, ns.label FROM #__vmtools_nets_products AS np, #__vmtools_netshop AS ns WHERE ns.id = np.id_net AND ns.published = 1 AND np.published = 1 AND np.id_product='.$prow->virtuemart_product_id;
			$db->setQuery($query);
			$nets = $db->loadObjectList();

			foreach ($nets as $net)
			{
			$query = 'SELECT adress, id FROM #__vmtools_shops_adresses WHERE id_region='.$_COOKIE['region'].' AND id_net='.$net->id_net;
			$db->setQuery($query);
			$net->adresses = $db->loadObjectList();
            $query = 'SELECT text FROM #__vmtools_dostavka WHERE region='.$_COOKIE['region'].' AND product_id = '.$prow->virtuemart_product_id.' AND net_id = '.$net->id_net." LIMIT 1";
			$db->setQuery($query);
            $net->dostavka = $db->loadResult();
            }
			?>
			<tr valign="top" class="sectiontableentry<?php echo $i ?>" id="product_row_<?php echo $pkey; ?>">
				<td align="left" >
					<?php if ( $prow->virtuemart_media_id) {  ?>
						<span class="cart-images">
						 <?php
						 if(!empty($prow->image)) echo $prow->image->displayMediaThumb('',false);
						 ?>
						</span>
					<?php } ?>
					<?php echo JHTML::link($prow->url, $prow->product_name).$prow->customfields; ?>
					
					<?php
					
					
					$p = "product".$prow->virtuemart_product_id;
					if ($_COOKIE[$p])
					{
						$mass = explode(':', $_COOKIE[$p]);
						$adress_cookie_id = $mass[0];
						$net_cookie_id = $mass[1];
					}
					else
					{
						$adress_cookie_id = 'choose';
						$net_cookie_id = $nets[0]->id;
					}
					
					?>
					<select name="product<?php echo $i;?>" class="net" style="display:auto;">					
						<?php					
							foreach ($nets as $net)
							{
							if (!$net->adresses) continue; 	
							if (!($net->label))
							{
								$net->label = $net->ymname;
							}
							$text = '';
							if ($net_cookie_id == $net->id_net) $text = "selected='selected'";
							?>
							<option <?php echo $text;?> price="<?php echo $net->price?>" value="<?php echo $net->id_net?>"><b><?php echo $net->price?> руб.</b> <?php echo $net->label?></option>	
							<?php
							}
						?>				
					</select>
					<input p_id="<?php echo $prow->virtuemart_product_id;?>" <?php if ($adress_cookie_id == -1) echo " checked='checked' "?> type="checkbox" style="float:left;"> <span style="float:left; margin-top:-7px">доставка</span>
					<div class="all-dostavka" <?php if ($adress_cookie_id != -1) echo "style='display:none;'"?>>
                    <?php
                    foreach ($nets as $net)
							{
								$text='';
								if (!$net->adresses) continue;
								if (($net->id_net == $net_cookie_id) && ($adress_cookie_id == 'choose'))
								{
									$adress_cookie_id = $adresses->id;
								}
								if ($net_cookie_id == $net->id_net)
								{
									$text = 'display:block;';
                                    $text2 = 'display:none;';
								}
								else
								{
									$text = 'display:none;';
                                    $text2 = 'display:block;';
								}
								if (!$net_cookie_id)
								{
									$text = 'display:block;'; $net_cookie_id = "none";
								}
								?>
                                <div class="dostavka" id_net="<?php echo $net->id_net;?>" style="<?php echo $text;?> clear:both;">
                                    <?php echo $net->dostavka;?>
                                </div>
                    <?php } ?>
                    </div>
                    <div class="adresses" style="both:clear; width:500px; <?php if ($adress_cookie_id == -1) echo "display:none;"?>" >					
						<?php
							foreach ($nets as $net)
							{
								$text='';
								if (!$net->adresses) continue;
								if (($net->id_net == $net_cookie_id) && ($adress_cookie_id == 'choose'))
								{
									$adress_cookie_id = $adresses->id;
								}
								if ($net_cookie_id == $net->id_net)
								{
									$text = 'display:block;';
								}
								else
								{
									$text = 'display:none;';
								}
								if (!$net_cookie_id)
								{
									$text = 'display:block;'; $net_cookie_id = "none";
								}
								?>
								<select class="adress" id_net="<?php echo $net->id_net;?>" name="product<?php echo $i;?>" style="<?php echo $text;?> clear:both; ">
								<?php
								foreach ($net->adresses as $adress)
								{
								$text='';							
									if ($net->id == $adress_cookie_id)
									{
										$text .= " selected='selected'";
									}
								?>
									<option  value="<?php echo $adress->id?>" net="<?php echo $net->id_net;?>"><?php echo $adress->adress?></option>	
								<?php
								}
								?>
								</select>
								<?php
							}
						?>				
					</div>
				</td>
				
				<td align="right" >
				<input type="text" title="<?php echo  JText::_('COM_VIRTUEMART_CART_UPDATE') ?>" class="inputbox" size="3" maxlength="4" value="<?php echo $prow->quantity ?>" id='quantity_<?php echo $pkey; ?>'/>
				<input type="button" class="vmicon vm2-add_quantity_cart" name="update" title="<?php echo  JText::_('COM_VIRTUEMART_CART_UPDATE') ?>" align="middle" onclick="update_form('update_product','<?php echo $pkey; ?>');"/>
				<a class="vmicon vm2-remove_from_cart" title="<?php echo JText::_('COM_VIRTUEMART_CART_DELETE') ?>" align="middle" href="javascript:void(0)" onclick="update_form('remove_product','<?php echo $pkey; ?>')"> </a>
				</td>
			</tr>
		<?php
		//echo "<pre>";print_r($this->cart->pricesUnformatted['salesPrice']);echo "</pre>";
			$i = 1 ? 2 : 1;
		} 

		?>
		<!--Begin of SubTotal, Tax, Shipment, Coupon Discount and Total listing -->
                  <?php if ( VmConfig::get('show_tax')) { $colspan=3; } else { $colspan=2; } ?>

		  <tr class="sectiontableentry1">
			<td  align="right"><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_PRODUCT_PRICES_TOTAL'); ?></td>
			<td align="right" id="sales_price"><?php echo $this->currencyDisplay->createPriceDiv('salesPrice', '0', $this->cart->pricesUnformatted,false) ?></td>
		  </tr>

			<?php
		if (VmConfig::get('coupons_enable')) {
		?>
			<tr class="sectiontableentry2">
				<td align="left">
				    <?php if(!empty($this->layoutName) && $this->layoutName=='default') {
					    echo $this->loadTemplate('coupon');
				    }
				?>

					 <?php
						echo "<span id='coupon_code_txt'>".@$this->cart->cartData['couponCode']."</span>";
						echo @$this->cart->cartData['couponDescr'] ? (' (' . $this->cart->cartData['couponDescr'] . ')' ): '';
						?>

				</td>
					 <?php if ( VmConfig::get('show_tax')) { ?>
					<td align="right" id="coupon_tax"><?php echo $this->currencyDisplay->createPriceDiv('couponTax','', @$this->cart->pricesUnformatted['couponTax'],false); ?> </td>
					 <?php } ?>
					<td align="right">&nbsp;</td>
					<td align="right" id="coupon_price"><?php echo $this->currencyDisplay->createPriceDiv('salesPriceCoupon','', @$this->cart->pricesUnformatted['salesPriceCoupon'],false); ?> </td>
			</tr>
		<?php } ?>


		<?php
		foreach($this->cart->cartData['DBTaxRulesBill'] as $rule){ ?>
			<tr class="sectiontableentry<?php $i ?>">
				<td align="right"><?php echo $rule['calc_name'] ?> </td>

                                   <?php if ( VmConfig::get('show_tax')) { ?>
				<td align="right"> </td>
                                <?php } ?>
				<td align="right"> <?php echo $this->currencyDisplay->createPriceDiv($rule['virtuemart_calc_id'].'Diff','', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'].'Diff'],false);  ?></td>
				<td align="right"><?php echo $this->currencyDisplay->createPriceDiv($rule['virtuemart_calc_id'].'Diff','', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'].'Diff'],false);   ?> </td>
			</tr>
			<?php
			if($i) $i=1; else $i=0;
		} ?>

		<?php

		foreach($this->cart->cartData['taxRulesBill'] as $rule){ ?>
			<tr class="sectiontableentry<?php $i ?>">
				<td align="right"><?php echo $rule['calc_name'] ?> </td>
				<?php if ( VmConfig::get('show_tax')) { ?>
				<td align="right"><?php echo $this->currencyDisplay->createPriceDiv($rule['virtuemart_calc_id'].'Diff','', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'].'Diff'],false); ?> </td>
				 <?php } ?>
				<td align="right"><?php    ?> </td>
				<td align="right"><?php echo $this->currencyDisplay->createPriceDiv($rule['virtuemart_calc_id'].'Diff','', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'].'Diff'],false);   ?> </td>
			</tr>
			<?php
			if($i) $i=1; else $i=0;
		}

		foreach($this->cart->cartData['DATaxRulesBill'] as $rule){ ?>
			<tr class="sectiontableentry<?php $i ?>">
				<td align="right"><?php echo   $rule['calc_name'] ?> </td>

                                     <?php if ( VmConfig::get('show_tax')) { ?>
				<td align="right"> </td>

                                <?php } ?>
				<td align="right"><?php  echo $this->currencyDisplay->createPriceDiv($rule['virtuemart_calc_id'].'Diff','', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'].'Diff'],false);   ?>  </td>
				<td align="right"><?php echo $this->currencyDisplay->createPriceDiv($rule['virtuemart_calc_id'].'Diff','', $this->cart->pricesUnformatted[$rule['virtuemart_calc_id'].'Diff'],false);   ?> </td>
			</tr>
			<?php
			if($i) $i=1; else $i=0;
		} ?>


	<tr class="sectiontableentry1" style="display:none;">
				<td align="left">
				<?php // echo $this->cart->cartData['shipmentName']; ?>
				    <br />
				<?php
				echo JText::_('COM_VIRTUEMART_CART_SELECTSHIPMENT');
				if(!empty($this->layoutName) && $this->layoutName=='default') {
					echo "<fieldset id='shipments'>";					
						foreach($this->helper->shipments_shipment_rates as $rates) {
								echo str_replace("input",'input onclick="update_form();"',$rates)."<br />";
						}
					echo "</fieldset>";
				} else {
				    JText::_('COM_VIRTUEMART_CART_SHIPPING');
				}
?>
				<td align="right" id="shipment"><?php echo $this->currencyDisplay->createPriceDiv('salesPriceShipment','', $this->cart->pricesUnformatted['salesPriceShipment'],false); ?> </td>
		</tr>

		<tr class="sectiontableentry1" style="display:none;">
				<td align="left">
				<?php 
				echo JText::_('COM_VIRTUEMART_CART_SELECTPAYMENT');
				if(!empty($this->layoutName) && $this->layoutName=='default') { 
					echo "<fieldset id='payments'>";
						foreach($this->helper->paymentplugins_payments as $payments) {
							echo str_replace('type="radio"','type="radio" onclick="update_form();"',$payments)."<br />";
						}
					echo "</fieldset>";
				} else {
					JText::_('COM_VIRTUEMART_CART_PAYMENT'); 
				}
				?> </td>
				<td align="right" id="payment"><?php  echo $this->currencyDisplay->createPriceDiv('salesPricePayment',0, $this->cart->pricesUnformatted['salesPricePayment'],false); ?> </td>
			</tr>
		  <tr class="sectiontableentry2" style="display:none;">
				<td align="right"><?php echo JText::_('COM_VIRTUEMART_CART_TOTAL') ?>: </td>
       			<td align="right"><strong id="bill_total"><?php echo $this->currencyDisplay->createPriceDiv('billTotal',0, $this->cart->pricesUnformatted['billTotal'],false) ?></strong></td>
		  </tr>
		    <?php
		    if ( $this->totalInPaymentCurrency) {
			?>

		       <tr class="sectiontableentry2">
					    <td align="right"><?php echo JText::_('COM_VIRTUEMART_CART_TOTAL_PAYMENT') ?>: </td>
					    <td align="right"><strong><?php echo $this->currencyDisplay->createPriceDiv('totalInPaymentCurrency', 0 , $this->totalInPaymentCurrency,false); ?></strong></td>
				      </tr>
				      <?php
		    }
		    ?>


	</table>
</fieldset>
<script>
jQuery(function($){

$('.net').change(function(){
p = $(this).parent();
$('.adress', p).hide();
id_net = $(this).val();
chk = $('input', p);
$('.adress[id_net=' + id_net +']', p).show();
$('.dostavka', p).hide();
$('.dostavka[id_net=' + id_net +']', p).show();
if ($(chk).attr('checked') == 'checked'){
	id_adress = -1;
}
else{
	id_adress = $('.adress[id_net=' + id_net + ']', p).val();
}
needed_cookie = id_adress + ':' + id_net;
document.cookie='product' + $(chk).attr('p_id') + '=' + needed_cookie + '; path=/';

totallprice = 0;
$('.net').each(function(){
	$s = $(this).parent().parent();
    totallprice = totallprice + (parseInt($('option:selected', this).attr('price'))*$(".inputbox", $s).val());
});
totallprice = totallprice + ' руб';
$('#sales_price').html(totallprice);

});

$('input[p_id]').each(function(){

if ($(this).attr('checked') == 'checked'){
	p = $(this).parent();
	id_adress = -1;
	id_net = $('.net', p).val();
}
else
{
	p = $(this).parent();
	id_adress = $('.adress', p).val();
	id_net = $('.net', p).val();
}
needed_cookie = id_adress + ':' + id_net;
document.cookie='product' + $(this).attr('p_id') + "=" + needed_cookie + '; path=/';
});

//флажок доставка
$('input[p_id]').change(function(){
p = $(this).parent();
id_net = $('.net', p).val();
$('div.adresses', p).toggle();
$('.all-dostavka').toggle();
if ($(this).attr('checked') == 'checked'){
	id_adress = -1;
}
else{
	id_adress = $('.adress[id_net=' + id_net + ']', p).val();
}
needed_cookie = id_adress + ':' + id_net;
document.cookie='product' + $(this).attr('p_id') + '=' + needed_cookie + '; path=/';
});
//подсчитываем сумму

totallprice = 0;
$('.net').each(function(){
	$s = $(this).parent().parent();
    totallprice = totallprice + (parseInt($('option:selected', this).attr('price'))*$(".inputbox", $s).val());
    
});
totallprice = totallprice + ' руб';
$('#sales_price').html(totallprice);

//выбираем адресс
$('.adress').change(function(){
chk = $(this).parent().parent();
chk = $('input', chk);
p = $(chk).parent();
id_net = $('.net', p).val();
if ($(chk).attr('checked') == 'checked'){
	id_adress = -1;	
}
else{
	id_adress = $('.adress[id_net=' + id_net + ']', p).val();	
}
needed_cookie = id_adress + ':' + id_net;
document.cookie = 'product' + $(chk).attr('p_id') + '=' + needed_cookie + '; path=/';
});

});

</script>