
<link rel="stylesheet" type="text/css" media="print" href="<?php echo base_url('assets/css/print.css'); ?>">
<?php  
	if($current_shop == 1){
	?>
		<div><img src="<?php echo base_url('assets/img/comforties.jpg'); ?>"></div>
	<?php
	}
	if($current_shop == 2){
	?>
		<div><img src="<?php echo base_url('assets/img/dutch.png'); ?>"></div>
	<?php
	}
  ?>
<p style="margin-left: 40%;">
<font face="sans-serif" size="2">
<?php echo $shop_name.'.com'.' '.$shop_index; ?><br>
<?php echo $shop_address['street'].' '.$shop_address['street_number'];?><br>
<?php echo $shop_address['zip'].' '.$shop_address['city'];?><br>
<?php echo lang('phone').' '.$shop_address['phone'];?><br>
<?php echo lang('email').' : '.$shop_address['email'];?><br>
<?php echo lang('website').' : '.$shop_address['website']; ?>

</font>
</p>


<address><font size="1"><?php  echo $shop_name.'.com'.' '.$shop_index.' '.$shop_address['street'].' '.$shop_address['street_number'].' '.$shop_address['zip'].' '.$shop_address['city']; ?></font></address>

<p><font face="sans-serif" size="2">
    <?php echo $customer_address['NAAM1']; ?><br>
    <?php if(!empty($customer_address['NAAM2'])) echo $customer_address['NAAM2']; ?><br> 
    <?php echo $customer_address['STRAAT'].' '.$customer_address['HUISNR']; ?><br>
    <?php echo $customer_address['POSTCODE'].' '.$customer_address['PLAATS']; ?><br>
    <?php echo $customer_address['LAND']; ?>
</font></p>

<h2><?php echo lang('pdf_invoice'); ?></h2>



<p><font face="sans-serif" size="2">
    <b><?php echo lang('pdf_invoice_nr'); ?></b>&nbsp;<?php echo $invoice_number; ?>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <b><?php echo lang('pdf_client_nr'); ?></b>&nbsp;<?php echo $customer_number; ?><br>

    <b><?php echo lang('pdf_order_nr'); ?></b>&nbsp;<?php echo $order_number; ?>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

    <b>Ust-IdNr.</b><br>

    <b><?php echo lang('agent'); ?></b>&nbsp;<?php echo $agent; ?>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <b>Bestell-Nr.</b><br>
    <b><?php echo lang('date'); ?></b>&nbsp;<?php echo $invoice_date; ?>
    </font></p>

   <hr />

<table>
    <thead>
        <tr>
            <th><font size="2"><?php echo lang('product_nr'); ?></font></th>
            <th><font size="2"><?php echo lang('description'); ?></font></th>
            <th><font size="2"><?php echo lang('delivery_quantity'); ?></font></th>
            <th><font size="2"><?php echo lang('number_per_packing'); ?></font></th>
            <th><font size="2"><?php echo lang('unit_price_netto'); ?></font></th>
            <th><font size="2"><?php echo lang('total_price_netto'); ?></font></th>
        </tr>
    </thead>
    <hr />
    <tbody>
        <?php foreach ($ordered_products as $product): ?>
        <tr>
            <td><font size="1"><?php echo $product['code'] ?></font></td>
            <td><font size="1"><?php echo $product['description'] ?></font></td>
            <td align="center"><font size="1"><?php echo $product['quantity'] ?></font></td>
            <td align="center"><font size="1"><?php echo $product['vpa'] ?></font></td>
            <td align="center"><font size="1"><?php echo $product['unit_price'] ?></font></td>
            <td align="center"><font size="1"><?php echo $product['total'] ?></font></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <hr />
    <tfoot>
        <tr>
            <td colspan="4"></td>
            <td><font size="2"><?php echo lang('shipping_costs'); ?>:</font></td>
            <td colspan="4"></td>
            <td align="left"><font size="2"><?php echo $shipping_costs; ?></font></td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td><font size="2"><?php echo lang('total_price_net'); ?>:</font></td>
            <td colspan="4"></td>
            <td align="left"><font size="2"><?php echo $totalnet; ?></font></td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td><font size="2"><?php echo str_replace('.00', '%', $vat_index).' '.lang('vat'); ?>:</font></td>
            <td colspan="4"></td>
            <td align="left"><font size="2"><?php echo $vat; ?></font></td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td><font size="2"><b><?php echo lang('total_price'); ?>:</b></font></td>
            <td colspan="4"></td>
            <td align="left"><font size="2"><b><?php echo format_currency($totalgross); ?></b></font></td>
        </tr>
        </tfoot>
</table>
<br>
<p>
    <font face="sans-serif" size="2">
    <b><?php echo lang('sent_date'); ?></b>&nbsp;<?php echo $send_date; ?><br>
    <b><?php echo lang('terms_of_payment'); ?></b>&nbsp;<?php echo $terms_of_payment; ?>
    </font>
</p>
<hr />
<p>
    <font face="sans-serif" size="2">
    <b><?php echo lang('explain'); ?></b>&nbsp;<?php echo lang('re').$invoice_number.'/'.$customer_number; ?>
    </font>
</p>

<br>
<b><?php echo $shop_name.'.com'.' '.$shop_index; ?></b>
<p>
    <font face="sans-serif" size="2">
	<?php  foreach($bank_account as $k=>$v):   ?>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <b><?php echo $k.' '.$v  ?></b><br>
    <?php endforeach;  ?>
    </font>
</p>


















