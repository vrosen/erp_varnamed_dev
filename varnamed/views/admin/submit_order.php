<?php include('header.php'); ?>
<?php
$order_type = array(
    'instant_delivery'  => 'Instant delivery',
    'fixdate'           => 'Fixdate',
    'direct_delivery'  => 'Direct delivery',
    'complete_delivery'  => 'Complete delivery',
    'rent'  => 'Rent',
    'recipe'  => 'Recipe',
    'sample_delivery'  => 'Sample delivery',
    'rent_to_own'  => 'Rent to own',
);
$date = array(
    
   'id' => 'date',
    'name' => 'date',
    'type' => 'text',
    'placeholder' => 'Date',
    
);
$delivery_condition = array(
    'no_shipping_costs'  => 'No shipping costs',
    'calculate_shipping_costs'  => 'Calculate shipping costs',
);
$dispatch_method = array(
    'self_delivery'  => 'Self delivery',
    'parcel_sevice'  => 'Parcel sevice',
    'miscellaneous'  => 'miscellaneous',
);
$warehouse = array(
    'dutchblue'  => 'Dutchblue(Delft)',
    'transoflex'  => 'Transoflex(Frechen)',
);
$payment_method = array(
    'invoice_upon_delivery'  => 'Invoice upon delivery',
    'direct_debit'  => 'direct_debit',
    'paid_in_advance'  => 'paid_in_advance',
    'ideal'  => 'ideal',
    'american_express'  => 'american_express',
    'mastercard'  => 'mastercard',
    'visa'  => 'visa',
    'instant_wire_transfer'  => 'instant_wire_transfer',
    'giropay'  => 'giropay',
    'paypal'  => 'paypal',
    'free_sample_delivery'  => 'free_sample_delivery',
    'dutchbluecom_bv_account'  => 'dutchbluecom_bv_account',
    'by_cheque'  => 'by_cheque',
);
$payment_condition = array(
    'immediately_without_departing'  => 'Immediately without departing',
    '8_days_without_departing'  => '8_days_without_departing',
        '30_days_without_departing'  => '30_days_without_departing',
    '42_days_without_departing'  => '42_days_without_departing',
);
?>

<?php echo form_open($this->config->item('admin_folder').'/orders/check_product/'.$id); ?>

    <div class="alert alert-success alert-block">
            <div class="row">
                    <div class="span4">
                       <table class="table">
                            <tr>
                            <td><?php echo lang('customer');?></td>
                            <td><a href="<?php echo site_url($this->config->item('admin_folder').'/customers/form/'.$id); ?>"><?php echo $firstname;?></a></td>
                            </tr>
                            <tr>
                            <td><?php echo lang('order_type');?></td>
                            <td><?php echo form_dropdown('order_type',$order_type,''); ?></td>
                            <td><?php echo form_input($date); ?></td>
                            </tr>
                            <tr>
                            <td><?php echo lang('delivery_condition');?></td>
                            <td><?php echo form_dropdown('delivery_condition',$delivery_condition,'no_shipping_costs'); ?></td>
                            </tr>
                            <tr>
                            <td><?php echo lang('dispatch_method');?></td>
                            <td><?php echo form_dropdown('dispatch_method',$dispatch_method,'parcel_sevice'); ?></td>
                            </tr>
                            <tr>
                            <td><?php echo lang('warehouse');?></td>
                            <td><?php echo form_dropdown('warehouse',$warehouse,'parcel_sevice'); ?></td>
                            </tr>
                            <tr>
                            <td><?php echo lang('weight');?></td>
                            <td><?php ?></td>
                            </tr>
                            <tr>
                            <td><?php echo lang('payment_method');?></td>
                            <td><?php echo form_dropdown('payment_method',$payment_method,'invoice_upon_delivery'); ?></td>
                            </tr>
                            <tr>
                            <td><?php echo lang('payment_condition');?></td>
                            <td><?php echo form_dropdown('payment_condition',$payment_condition,'invoice_upon_delivery'); ?></td>
                            </tr>
                            <tr>
                            <td><?php echo lang('none_VAT');?></td>
                            <?php $none_VAT = array(  'name' => 'none_vat','id' => 'none_vat','value' => 'accept','checked' => TRUE,'style'=> 'margin:10px',); ?>
                            <td><?php echo form_checkbox($none_VAT); ?></td>
                            </tr>
                            <tr>
                            <td><?php echo lang('nicht_mahnen');?></td>
                            <?php $not_warn = array(  'name' => 'not_warn','id' => 'not_warn','value' => 'accept','checked' => TRUE,'style'=> 'margin:10px',); ?>
                            <td><?php echo form_checkbox($not_warn); ?></td>
                            </tr>
                            <tr>
                            <td><?php echo lang('invoice_per_email');?></td>
                            <?php $invoice_per_email = array(  'name' => 'invoice_per_email','id' => 'invoice_per_email','value' => 'accept','checked' => TRUE,'style'=> 'margin:10px',); ?>
                            <td><?php echo form_checkbox($invoice_per_email); ?></td>
                            </tr>
                            <tr>
                            <td><?php echo lang('email_adresse');?></td>
                              <?php $email_address = array(  'name' => 'email_address','id' => 'email_address','type'=> 'text',); ?>
                            <td><?php echo form_input($email_address); ?></td>
                            </tr>
                            <tr>
                            <td><?php echo lang('currency');?></td>
                            <td><?php echo 'EUR'; ?></td>
                            </tr>
                            <tr>
                            <td><?php echo lang('order_entry');?></td>
                            <td><?php echo $current_admin; ?></td>
                            </tr>
                            <tr>
                            <td><?php echo lang('order_date');?></td>
                            <td><?php echo date('m/d/Y'); ?></td>
                            </tr>
                            <tr>
                            <td><?php echo lang('status');?></td>
                            <td><?php echo 'order in process';?></td>
                            </tr>
                    </table>
                    </div>
            </div>
    </div>

<div class="block">
    <div class="navbar navbar-inner block-header">
        
<table class="table table-striped">
	<thead>
		<tr>
                        <th><input type="checkbox" id="gc_check_all" /> <button type="submit" class="btn btn-small btn-danger"><i class="icon-trash icon-white"></i></button></th>
                        <th><?php echo lang('product_nr');?></th>
                        <th><?php echo lang('quantity');?></th>
                        <th><?php echo lang('num_vpe');?></th>
                        <th><?php echo lang('VK');?></th>
                        <th><strong><?php echo lang('coupon_discount');?></strong></th>
                        <th><?php echo lang('unit_price');?></th>
                        <th><?php echo lang('total');?></th>
                        <th><?php echo lang('buying_price');?></th>
                        <th><?php echo lang('margin'); ?></th>
                        <th><?php echo lang('available_stock'); ?></th>
			<th><?php echo lang('description');?></th>
		</tr>
	</thead>
        <tbody>
                    <tr>
                        <td></td>
                        <td><?php echo form_input(array('id'=>'product_number','name'=>'product_number','class'=>'span1'));?></td>
                        <td><?php echo form_input(array('id'=>'number','name'=>'number','class'=>'span1'));?></td>
                        <td><?php ?></td>
                        <td><?php ?></td>
                        <td><?php echo form_input(array('id'=>'discount','name'=>'discount','class'=>'span1'));?></td>
                        <td><?php echo form_input(array('id'=>'unit_price','name'=>'unit_price','class'=>'span1'));?></td>
                        <td><?php ?></td>
                        <td><?php echo form_input(array('id'=>'ek','name'=>'ek','class'=>'span1'));?></td>
                        <td><?php echo form_input(array('id'=>'margin','name'=>'margin','class'=>'span1'));?></td>
                        <td><?php ?></td>
                        <td><?php ?></td>
                    </tr>
                <div id="display"></div>
            </tbody>

        
    <script>
        function update(){
                  $('#display')
                        .text(
                                ($('#number').val() * $('#unit_price').val() - $('#discount').val() * $('#number').val() * $('#unit_price').val() / 100)
                    );  
                }
                $('#number').keyup(update);
                $('#unit_price').change(update);
                $('#discount').change(update);
    </script>
        
		<tfoot>
		<tr>
			<td><strong><?php echo lang('subtotal');?></strong></td>
			<td colspan="5"></td>
			
		</tr>
		<tr>
			<td><strong><?php echo lang('shipping');?></strong></td>
                        <td colspan="10"><?php //echo form_input(); ?></td>
			<td><?php //echo format_currency($order->shipping); ?></td>
		</tr>
		<tr>
			<td><strong><?php echo lang('tax');?></strong></td>
			<td colspan="5"></td>
			<td><?php // echo format_currency($order->tax); ?></td>
		</tr>
		<tr>
			<td><h3><?php echo lang('total');?></h3></td>
			<td colspan="5"></td>
			<td><strong><?php //echo format_currency($order->total); ?></strong></td>
		</tr>
	</tfoot>
</table>



	<div class="row">
		<div class="span3">
			<label><?php echo lang('group');?></label>
		
		</div>
	</div>

	<div class="row">
		<div class="span3">
			<label><?php echo lang('important_info');?></label>
			<?php
			$data	= array('name'=>'important_info', 'value'=>set_value('important_info', $phone), 'class' => 'span11', 'rows' => '2');
			echo form_textarea($data); ?>
		</div>
	</div>
       
		<input class="btn btn-danger" type="submit" value="<?php echo lang('check');?>"/>
                

</form>






<?php include('footer.php'); ?>