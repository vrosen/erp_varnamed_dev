
<?php 
if($this->session->userdata('shop') == 1){
?><div><img src="<?php echo $_SERVER['DOCUMENT_ROOT'].'/assets/img/invoice_logos/c_logo.png' ?>" style="width: 200px; margin-left: 33%;" ></div><?php
}
if($this->session->userdata('shop') == 2){
?><div><img src="<?php echo $_SERVER['DOCUMENT_ROOT'].'/assets/img/invoice_logos/d_logo.png' ?>" style="width: 200px; margin-left: 33%;"></div><?php
}
?>

<p style="margin-left: 70%;">
<font face="sans-serif" size="2">
	<?php 
	if($this->session->userdata('shop') == 1){
		if($cur_country == 'NL'){
			?><strong><?php echo $shop_name.'.nl'; ?></strong><br><?php
		}
		if($cur_country == 'BE'){
			?><strong><?php echo $shop_name.'.be'; ?></strong><br><?php
		}
		if($cur_country == 'FR'){
			?><strong><?php echo $shop_name.'.fr'; ?></strong><br><?php
		}
		if($cur_country == 'LX'){
			?><strong><?php echo $shop_name.'.com'; ?></strong><br><?php
		}
		if($cur_country == 'BEL'){
			?><strong><?php echo $shop_name.'.be'; ?></strong><br><?php
		}
		if($cur_country == 'DE'){
			?><strong><?php echo $shop_name.'.de'; ?></strong><br><?php
		}
		if($cur_country == 'AT'){
			?><strong><?php echo $shop_name.'.at'; ?></strong><br><?php
		}
		if($cur_country == 'UK'){
			?><strong><?php echo $shop_name.'.com'; ?></strong><br><?php
		}
	}	
	?>
<?php 
if($this->session->userdata('shop') == 2){
?><strong><?php echo $shop_name.'.com BV'; ?></strong><br><?php
}
?>
<?php 
if($this->session->userdata('shop') == 1){
if($cur_country == 'FR'){
 echo $shop_address['street_number'].' '.$shop_address['street'];
} 
if($cur_country == 'AT'){
 echo $shop_address['street'].'<br>'.$shop_address['street_number'];
} 
if($cur_country == 'UK'){
 echo $shop_address['street'].'<br>'.$shop_address['street_number'];
} 
if($cur_country == 'DE'){
 echo $shop_address['street'].'<br>'.$shop_address['street_number'];
} 
if($cur_country == 'LX'){
 echo $shop_address['street'].'<br>'.$shop_address['street_number'];
} 
if($cur_country == 'NL'){
 echo $shop_address['street'].' '.$shop_address['street_number'];
} 
if($cur_country == 'BE'){
 echo $shop_address['street'].' '.$shop_address['street_number'];
} 
if($cur_country == 'BEL'){
 echo $shop_address['street'].' '.$shop_address['street_number'];
}
}
if($this->session->userdata('shop') == 2){
if($cur_country == 'FR'){
 echo $shop_address['street_number'].' '.$shop_address['street'];
} 
if($cur_country == 'AT'){
 echo $shop_address['street'].'<br>'.$shop_address['street_number'];
} 
if($cur_country == 'UK'){
 echo $shop_address['street'].'<br>'.$shop_address['street_number'];
} 
else {
echo $shop_address['street'].' '.$shop_address['street_number'];
}
}
?><br>

<?php echo $shop_address['zip'].' '.$shop_address['city'];?><br>
<?php echo 'Tel.'.' '.$shop_address['phone'];?><br>
<?php echo 'E-mail'.' : '.$shop_address['email'];?><br>
<?php echo lang('website').$shop_address['website']; ?>
</font>
</p>
	<?php 
	if($this->session->userdata('shop') == 1){
	
		if($cur_country == 'NL'){
			?><address><font size="1"><?php  echo $shop_name.'.nl'.' - '.$shop_address['street'].' '.$shop_address['street_number'].' - '.$shop_address['zip'].' '.$shop_address['city']; ?></font></address><?php
		}
		if($cur_country == 'BE'){
			?><address><font size="1"><?php  echo $shop_name.'.be'.' - '.$shop_address['street'].' '.$shop_address['street_number'].' - '.$shop_address['zip'].' '.$shop_address['city']; ?></font></address><?php
		}
		if($cur_country == 'FR'){
			?><address><font size="1"><?php  echo $shop_name.'.fr'.' - '.$shop_address['street_number'].' '.$shop_address['street'].' - '.$shop_address['zip'].' '.$shop_address['city']; ?></font></address><?php
		}
		if($cur_country == 'LX'){
			?><address><font size="1"><?php  echo $shop_name.'.com'.' - '.$shop_address['street'].' '.$shop_address['street_number'].' - '.$shop_address['zip'].' '.$shop_address['city']; ?></font></address><?php
		}
		if($cur_country == 'BEL'){
			?><address><font size="1"><?php  echo $shop_name.'.be'.' - '.$shop_address['street'].' '.$shop_address['street_number'].' - '.$shop_address['zip'].' '.$shop_address['city']; ?></font></address><?php
		}
		if($cur_country == 'DE'){
			?><address><font size="1"><?php  echo $shop_name.'.de'.' - '.$shop_address['street'].' '.$shop_address['street_number'].' - '.$shop_address['zip'].' '.$shop_address['city']; ?></font></address><?php
		}
		if($cur_country == 'AT'){
			?><address><font size="1"><?php  echo $shop_name.'.at'.' - '.$shop_address['street'].' '.$shop_address['street_number'].' - '.$shop_address['zip'].' '.$shop_address['city']; ?></font></address><?php
		}
		if($cur_country == 'UK'){
			?><address><font size="1"><?php  echo $shop_name.'.com'.' - '.$shop_address['street_number'].' - '.$shop_address['zip'].' '.$shop_address['city']; ?></font></address><?php
		}
	}	
	?>
<?php 
if($this->session->userdata('shop') == 2){

if($cur_country == 'FR'){
?><address><font size="1"><?php  echo $shop_name.'.com BV'.' - '.$shop_address['street_number'].' '.$shop_address['street'].' - '.$shop_address['zip'].' '.$shop_address['city']; ?></font></address><?php
} 
if($cur_country == 'UK'){
?><address><font size="1"><?php  echo $shop_name.'.com BV'.' - '.$shop_address['street_number'].' - '.$shop_address['zip'].' '.$shop_address['city']; ?></font></address><?php
} 
else {
?><address><font size="1"><?php  echo $shop_name.'.com BV'.' - '.$shop_address['street'].' '.$shop_address['street_number'].' - '.$shop_address['zip'].' '.$shop_address['city']; ?></font></address><?php
}
}
?>


<p><font face="sans-serif" size="2">
    <?php echo $customer_address['NAAM1']; ?><br>
    <?php echo $customer_address['STRAAT'].' '.$customer_address['HUISNR']; ?><br>
	<?php echo $customer_address['POSTCODE']; ?>&nbsp;<?php echo $customer_address['PLAATS']; ?><br>
    <?php echo $customer_address['LAND']; ?>
</font></p>

<h2><?php echo $invoice; ?></h2>



<p><font face="sans-serif" size="2">
    <b><?php echo $invoice_nr; ?></b>&nbsp;<?php echo $invoice_number; ?>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <b><?php echo $client_nr ?></b>&nbsp;<?php echo $customer_number; ?><br>

    <b><?php echo $order_nr ?></b>&nbsp;<?php echo $order_number; ?>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <b><?php if(!empty($created_by)) echo $agent ?></b>&nbsp;<?php if(!empty($created_by)) echo $created_by; ?><br>

    <b><?php echo $date ?></b>&nbsp;<?php echo $invoice_date; ?>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   &nbsp;&nbsp;&nbsp;&nbsp; <b><?php echo $cfactuur ?></b>&nbsp;<?php if(!empty($cfactuurnr)) echo $cfactuurnr; ?><br>



    </font></p>


<table>
    <thead>
        <tr>
            <th style="margin-left: 10%;"><font face="sans-serif" size="2"><?php echo $product_nr; ?></font></th>
            <th align="left"><font face="sans-serif" size="2"><?php echo $description; ?></font></th>
            <th><font face="sans-serif" size="2"><?php echo $delivery_quantity; ?></font></th>
            <th><font face="sans-serif" size="2"><?php echo $number_per_packing; ?></font></th>
            <th><font face="sans-serif" size="2"><?php echo $unit_price_netto; ?></font></th>
            <td colspan="4"></td><th><font face="sans-serif"  size="2"><?php echo $total_price_netto; ?></font></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($ordered_products as $product): ?>
		<?php if($cur_country == 'UK'){ ?>
        <tr>
            <td><font face="sans-serif"  size="2"><?php echo $product['code'] ?></font></td>
            <td align="left"><font face="sans-serif"  size="2"><?php echo $product['description'] ?></font></td>
            <td  align="center"><font face="sans-serif"  size="2"><?php echo $product['quantity'] ?></font></td>
            <td align="center"><font face="sans-serif"  size="2"><?php echo $product['vpa'] ?></font></td>
            <td><font face="sans-serif"  size="2"><?php echo $this->config->item('currency_symbol_uk').' '.str_replace('.',',',$product['unit_price']); ?></font></td>
            <td colspan="4"></td><td align="left"><font face="sans-serif"  size="2"><?php echo $this->config->item('currency_symbol_uk').' '.str_replace('.',',',$product['total']); ?></font></td>
        </tr>
		<?php }else { ?>
        <tr>
            <td><font face="sans-serif"  size="2"><?php echo $product['code'] ?></font></td>
            <td align="left"><font face="sans-serif"  size="2"><?php echo $product['description'] ?></font></td>
            <td  align="center"><font face="sans-serif"  size="2"><?php echo $product['quantity'] ?></font></td>
            <td align="center"><font face="sans-serif"  size="2"><?php echo $product['vpa'] ?></font></td>
            <td><font face="sans-serif"  size="2"><?php echo $this->config->item('currency_symbol').' '.str_replace('.',',',$product['unit_price']); ?></font></td>
            <td colspan="4"></td><td align="left"><font face="sans-serif"  size="2"><?php echo $this->config->item('currency_symbol').' '.str_replace('.',',',$product['total']); ?></font></td>
        </tr>
		<?php } ?>
        <?php endforeach; ?>
    </tbody>
<?php if($cur_country == 'UK'){ ?>
    <tfoot>
        <tr>
            <td colspan="4"></td>
            <td><font face="sans-serif"  size="2"><?php echo $shipping_costs; ?>:</font></td>
            <td colspan="4"></td>
            <td align="left"><font face="sans-serif"  size="2"><?php echo $this->config->item('currency_symbol_uk').' '.str_replace('.',',',round($shipping_costs_value,2)); ?></font></td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td><font face="sans-serif"  size="2"><?php echo $total_price_net; ?>:</font></td>
            <td colspan="4"></td>
            <td align="left"><font face="sans-serif"  size="2"><?php echo $this->config->item('currency_symbol_uk').' '.str_replace('.',',',round($totalnet,2)); ?></font></td>
        </tr>
		<!--  -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------  -->
		
	<?php	
		if(!empty($d_vats) and !empty($n_vats)){
		
			?>
					<tr>
						<td colspan="4"></td>
						<td><font face="sans-serif"  size="2"><?php echo str_replace('.00', '%', $vat_index).' '.$vat; ?>:</font></td>
						<td colspan="4"></td>
						<td align="left"><font face="sans-serif"  size="2"><?php echo $this->config->item('currency_symbol_uk').' '.str_replace('.',',',round($n_vats,2)); ?></font></td>
					</tr>
			<?php	
			?>
					<tr>
						<td colspan="4"></td>
						<td><font face="sans-serif"  size="2"><?php echo str_replace('.00', '%', $vat_index).' '.$vat.$shipping_costs; ?>:</font></td>
						<td colspan="4"></td>
						<td align="left"><font face="sans-serif"  size="2"><?php echo $this->config->item('currency_symbol_uk').' '.str_replace('.',',',round($ship_vat_rate,2)); ?></font></td>
					</tr>
			<?php	
			
			 foreach ($ordered_products as $product){
				 if($product['special_vat'] == 1){ ?>
					<tr>
						<td colspan="4"></td>
						<td><font face="sans-serif"  size="2"><?php echo $product['VAT'].'%'.' '.$vat.'-'.$product['code']; ?>:</font></td>
						<td colspan="4"></td>
						<td align="left"><font face="sans-serif"  size="2"><?php echo $this->config->item('currency_symbol_uk').' '.round($product['vat_ammount'],2); ?></font></td>
					</tr>
				<?php } 
			} 
		}
		if(empty($d_vats) and !empty($n_vats)){
		
		
			?>
					<tr>
						<td colspan="4"></td>
						<td><font face="sans-serif"  size="2"><?php echo str_replace('.00', '%', $vat_index).' '.$vat; ?>:</font></td>
						<td colspan="4"></td>
						<td align="left"><font face="sans-serif"  size="2"><?php echo $this->config->item('currency_symbol_uk').' '.str_replace('.',',',round($vat_value,2)); ?></font></td>
					</tr>
			<?php	
		
		
		}
	?>
		<!--  -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------  -->
        <tr>
            <td colspan="4"></td>
            <td><font face="sans-serif"  size="2"><b><?php echo $total_price; ?>:</b></font></td>
            <td colspan="4"></td>
            <td align="left"><font face="sans-serif"  size="2"><b><?php echo $this->config->item('currency_symbol_uk').' '.str_replace('.',',',round($totalgross,2)); ?></b></font></td>
        </tr>
        </tfoot>


<?php }else { ?>
    <tfoot>
        <tr>
            <td colspan="4"></td>
            <td><font face="sans-serif"  size="2"><?php echo $shipping_costs; ?>:</font></td>
            <td colspan="4"></td>
            <td align="left"><font face="sans-serif"  size="2"><?php echo $this->config->item('currency_symbol').' '.str_replace('.',',',round($shipping_costs_value,2)); ?></font></td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td><font face="sans-serif"  size="2"><?php echo $total_price_net; ?>:</font></td>
            <td colspan="4"></td>
            <td align="left"><font face="sans-serif"  size="2"><?php echo $this->config->item('currency_symbol').' '.str_replace('.',',',round($totalnet,2)); ?></font></td>
        </tr>
		<!--  -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------  -->
		
	<?php	
		if(!empty($d_vats) and !empty($n_vats)){
		
			?>
					<tr>
						<td colspan="4"></td>
						<td><font face="sans-serif"  size="2"><?php echo str_replace('.00', '%', $vat_index).' '.$vat; ?>:</font></td>
						<td colspan="4"></td>
						<td align="left"><font face="sans-serif"  size="2"><?php echo $this->config->item('currency_symbol').' '.str_replace('.',',',round($n_vats,2)); ?></font></td>
					</tr>
			<?php	
			?>
					<tr>
						<td colspan="4"></td>
						<td><font face="sans-serif"  size="2"><?php echo str_replace('.00', '%', $vat_index).' '.$vat.$shipping_costs; ?>:</font></td>
						<td colspan="4"></td>
						<td align="left"><font face="sans-serif"  size="2"><?php echo $this->config->item('currency_symbol').' '.str_replace('.',',',round($ship_vat_rate,2)); ?></font></td>
					</tr>
			<?php	
			
			 foreach ($ordered_products as $product){
				 if($product['special_vat'] == 1){ ?>
					<tr>
						<td colspan="4"></td>
						<td><font face="sans-serif"  size="2"><?php echo $product['VAT'].'%'.' '.$vat.'-'.$product['code']; ?>:</font></td>
						<td colspan="4"></td>
						<td align="left"><font face="sans-serif"  size="2"><?php echo $this->config->item('currency_symbol').' '.round($product['vat_ammount'],2); ?></font></td>
					</tr>
				<?php } 
			} 
		}
		if(empty($d_vats) and !empty($n_vats)){
		
		
			?>
					<tr>
						<td colspan="4"></td>
						<td><font face="sans-serif"  size="2"><?php echo str_replace('.00', '%', $vat_index).' '.$vat; ?>:</font></td>
						<td colspan="4"></td>
						<td align="left"><font face="sans-serif"  size="2"><?php echo $this->config->item('currency_symbol').' '.str_replace('.',',',round($vat_value,2)); ?></font></td>
					</tr>
			<?php	
		
		
		}
	?>
		<!--  -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------  -->

        <tr>
            <td colspan="4"></td>
            <td><font face="sans-serif"  size="2"><b><?php echo $total_price; ?>:</b></font></td>
            <td colspan="4"></td>
            <td align="left"><font face="sans-serif"  size="2"><b><?php echo $this->config->item('currency_symbol').' '.str_replace('.',',',$totalgross); ?></b></font></td>
        </tr>
        </tfoot>
		<?php } ?>
</table>

<p>
    <font face="sans-serif" size="2">
    <b><?php echo $sent_date; ?></b>&nbsp;<?php echo $send_date; ?><br>
    <b><?php echo $terms_of_payment; ?></b>&nbsp;<?php echo $payment_condition; ?>
    </font>
</p>
<hr />
<p>
    <font face="sans-serif" size="2">
    <b>
	<?php echo $explain; ?></b>&nbsp;<?php echo $re.$invoice_number.'/'.$customer_number; ?><br>
	&nbsp;
	<?php 
	if($this->session->userdata('shop') == 2){
		if(!empty($important_sentence)){
		echo $important_sentence;
		}
	}	
	?>
	<?php 
	if($this->session->userdata('shop') == 1){
		if($cur_country == 'NL'){
			echo $comforties_explain_nl;
		}
		if($cur_country == 'BE'){
			echo $comforties_explain_be;
		}
		if($cur_country == 'FR'){
			echo $comforties_explain_fr;
		}
		if($cur_country == 'LX'){
			echo $comforties_explain_lx;
		}
		if($cur_country == 'BEL'){
			echo $comforties_explain_bel;
		}
		if($cur_country == 'DE'){
			echo $comforties_explain_de;
		}
		if($cur_country == 'AT'){
			echo $comforties_explain_at;
		}
		if($cur_country == 'UK'){
			echo $comforties_explain_uk;
		}
	}	
	?>
    </font>
</p>


<p>
    <font face="sans-serif" style="margin-left: 10%;" size="2">
	<?php  foreach($bank_account as $k=>$v):   ?>
    <b><?php echo $k.' '.$v  ?></b><br>
    <?php endforeach;  ?>
    </font>
</p>