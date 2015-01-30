<?php include('header.php'); ?>
<?php
$order_type_array = array(
    '0'                 => 'Select order type',
    'instant_delivery'  => 'Instant delivery',
    'fixdate'           => 'Fixdate',
    'direct_delivery'   => 'Direct delivery',
    'complete_delivery' => 'Complete delivery',
    'rent'              => 'Rent',
    'recipe'            => 'Recipe',
    'sample_delivery'   => 'Sample delivery',
    'rent_to_own'       => 'Rent to own',
);
$date = array(
   'id' => 'date',
    'name' => 'date',
    'type' => 'text',
    'placeholder' => 'Date',
    
);
$delivery_condition_array = array(
    '0'                         => 'Select delivery condition',
    'no_shipping_costs'         => 'No shipping costs',
    'calculate_shipping_costs'  => 'Calculate shipping costs',
);
$dispatch_method_array = array(
    '0'              => 'Select dispatch method',
    'self_delivery'  => 'Self delivery',
    'parcel_sevice'  => 'Parcel sevice',
    'miscellaneous'  => 'miscellaneous',
);
$warehouse_array = array(
    '0'             => 'Select warehouse',
    'dutchblue'     => 'Dutchblue(Delft)',
    'transoflex'    => 'Transoflex(Frechen)',
);
$payment_method_array = array(
                
    '0'                         => lang('select_payment_method'),
    'invoice_upon_delivery'     => lang('invoice_upon_delivery'),
    'direct_debit'              => lang('direct_debit'),
    'paid_in_advance'           => lang('paid_in_advance'),
    'iDEAL'                     => lang('iDEAL'),
    'American_Express'          => lang('American_Express'),
    'MasterCard'                => lang('MasterCard'),
    'VISA'                      => lang('VISA'),
    'instant_wire_transfer'     => lang('instant_wire_transfer'),
    'Giropay'                   => lang('Giropay'),
    'EPS'                       => lang('EPS'),
    'PAYPAL'                    => lang('PAYPAL'),
    'free_sample_delivery'      => lang('free_sample_delivery'),
    'dutchblue_com_BV_account'  => lang('dutchblue_com_BV_account'),//set the shop variable
    'by_cheque'                 => lang('by_cheque'), 
);
$payment_condition_array = array(
                    
    '0'                                         => lang('set_condition'),
    'immediately_without_deduction'             => lang('immediately_without_deduction'),
    '8_days_without_deduction'                  => lang('8_days_without_deduction'),
    '30_days_without_deduction'                 => lang('30_days_without_deduction'),
    '42_days_without_deduction'                 => lang('42_days_without_deduction'),
);

$currency_array = array(
    
    'EUR'   => 'EUR',
    'USD'   => 'USD'
    
);

$vat_array = array(

    '0'     => 0,
    $vat_index   => $vat_index,
);



?>
<link href='http://fonts.googleapis.com/css?family=Raleway:500' rel='stylesheet' type='text/css'>
	<div class="panel panel-default" style="width: 100%; float: left;">
	<!-- Default panel contents -->
		<div class="panel-heading">Stock: New Order<span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
		</div>
		<div class="panel-body">

    <?php echo form_open($this->config->item('admin_folder').'/suppliers/submit_order/'.$id); ?>


                       <table class="table">
                            <tr>
								<td style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 30%;"><?php echo lang('supplier');?></td>
								<td>
								<input type="text" name="supplier_name" class="form-control" style="width: 20%;" value="<?php echo $supplier; ?>" disabled/>
								</td>
                            </tr>
                            <tr>
								<td style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 30%;"><?php echo lang('agent');?></td>
								<td>
								<input type="text" name="agent_name" class="form-control" style="width: 20%;" value="<?php echo $current_user; ?>" disabled/>
								</td>
                            </tr>
                            <tr>
								<td style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 30%;"><?php echo lang('order_date');?></td>
								<td><input id="order_date" name="order_date" type="text" class="form-control" value="<?php echo  $order_date; ?>" style="width: 20%;" placeholder="Order date" required/></td>
                            </tr>
                            <tr>
								<td style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 30%;"><?php echo lang('arrival_date');?></td>
								<td><input id="arrival_date" name="arrival_date" type="text" class="form-control" style="width: 20%;" placeholder="<?php echo lang('expected_date_arrival'); ?>" required/></td>
                            </tr>
                    </table>
					</div>
					</div>
					
					
					
				<div class="panel panel-default" style="width: 100%; float: left;">
					<!-- Default panel contents -->
						<div class="panel-heading">Stock: New Order<span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
						</div>
						<div class="panel-body">
							<table class="table">
									<thead>
											<tr>
												<th style="font-family: 'Raleway', sans-serif;"><?php echo lang('product'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>&nbsp;
												<th style="font-family: 'Raleway', sans-serif;"><?php echo lang('product_quantity'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
												<th style="font-family: 'Raleway', sans-serif;"><?php echo lang('min_order'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
												<th style="font-family: 'Raleway', sans-serif;"><?php echo lang('num_vpe'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
												<th style="font-family: 'Raleway', sans-serif;"><?php echo lang('unit_price'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
												<th style="font-family: 'Raleway', sans-serif;"><?php echo lang('total_price'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
												<th style="font-family: 'Raleway', sans-serif;"><?php echo lang('description'); ?></td>
											</tr>
									</thead>
									<tbody>
											<?php
											//echo '<pre>'; 
											//print_r($product_array);
											//echo '</pre>'; 
											?>
											<?php foreach ($product_array as $product): ?>
												<tr>
													<!--<td><input name="product[]" type="checkbox" value="<?php //echo $product['id']; ?>" class="gc_check"/></td>-->
													<input name="product[]" type="hidden" value="<?php echo $product['id']; ?>" />
													<td><input name="product_number[]" type="hidden" value="<?php echo $product['code']; ?>" /><?php echo $product['code']; ?></td>
													<td><input name="number[]" type="text" value="<?php echo $product['ordered_quantity']; ?>" class="span1"/></td>
													<td><?php echo $product['min_stock']; ?></td><input name="min_stock[]" type="hidden" value="<?php echo $product['min_stock']; ?>" />
													<td><input name="vpa[]" type="hidden" value="<?php echo $product['package_details']; ?>" /><?php echo $product['package_details']; ?></td>
													
													
													<?php echo (empty($product['unit_price']))?   '<td>'.form_input(array('name' => 'vk[]','value'=> $product['warehouse_price'],'class'=> 'span1')).'</td>': '<td>'.form_input(array('name' => 'vk[]','value'=> $product['warehouse_price'],'class'=> 'span1')).'</td>'; ?>

													<?php echo (empty($product['unit_price']))?   '<td>'.$product['warehouse_price']*$product['ordered_quantity'].'</td>': '<td>'.$product['unit_price']*$product['ordered_quantity'].'</td>'; ?>

													<td><input name="description[]" type="hidden" value="<?php echo $product['name']; ?>" /><?php echo $product['name_UK']; ?></td>
													<?php 
													
													if (!empty($product['unit_price'])){
														$total_price[]  =   $product['unit_price']*$product['ordered_quantity'];
														?><input name="total[]" type="hidden" value="<?php echo $product['unit_price']*$product['ordered_quantity']; ?>" class="span1"/><?php
													}
													if (empty($product['unit_price'])){
														$total_price[] = $product['warehouse_price']*$product['ordered_quantity'];
														?><input name="total[]" type="hidden" value="<?php echo $product['warehouse_price']*$product['ordered_quantity']; ?>" class="span1"/><?php
													}

													?>   
												</tr>
											<?php endforeach; ?>
											
											<?php $net_price = array_sum($total_price);  ?>

											<div id="display"></div>
									</tbody>

									<tfoot>
												<tr>
													<td><strong><?php echo lang('netto');?></strong></td>
													<td colspan='4'></td><td><strong><?php echo format_currency($net_price);   ?></strong></td>
													<input type="hidden" name="netto" value="<?php echo $net_price;   ?>">
												</tr>
												<tr>
														<td><strong><?php echo lang('vat');?></strong></td>


														<td colspan=""></td><td><?php echo form_dropdown('vindex',$vat_array); ?></td>
														
																<td colspan='2'></td><td><?php //echo format_currency($net_price); ?></td>
																<input type="hidden" name="vat" value="<?php //echo $net_price; ?>">
												</tr>
												<tr>
													<td><strong><?php echo lang('gross');?></strong></td>
													<td colspan="4"></td>
													<td><?php echo format_currency($net_price); ?></td>
													<input type="hidden" name="gross" value="<?php echo $net_price; ?>">
												</tr>
									</tfoot>
											
							</table>

					<input type="hidden" name="saleprice_index" value="<?php // echo $saleprice_index; ?>">
					<input type="hidden" name="vat_index" value="<?php //echo $vat_index; ?>">


						<div class="table table-striped" style="padding: 5px;  width: 50%;  margin-bottom:15px;">
							<fieldset><legend style="font-family: 'Raleway', sans-serif;"><?php echo lang('shipping_notes');  ?></legend></fieldset>
							<?php
								$data	= array('name'=>'shipping_notes','id'=>'shipping_notes','class' => 'form-control', 'rows' => '2');
								echo form_textarea($data); 
							?>
						</div>
						<div class="table table-striped" style="padding: 5px;  width: 50%;  margin-bottom:15px;">
							<fieldset><legend style="font-family: 'Raleway', sans-serif;"><?php echo lang('important_info');  ?></legend></fieldset>
							<?php
								$data	= array('name'=>'important_info','id'=>'important_info','class' => 'form-control', 'rows' => '2');
								echo form_textarea($data); 
							?>
						</div>

			

<div style="padding: 0px 0px 10px 10px">

				<input class="btn btn-info btn-sm" type="submit" value="<?php echo lang('create_order');?>"/>
				<input class="btn btn-info btn-sm" type="submit" value="<?php echo lang('update');?>"/>
                <a class="btn btn-danger btn-sm" href="<?php echo site_url($this->config->item('admin_folder').'/suppliers/form/'.$id); ?>"><?php echo lang('cancel');?></a>
				</div>
		</form>

		</div>
	</div>

    <script>
		$('#order_date').datepicker({dateFormat:'yy-mm-dd', altField: '#start_top_alt', altFormat: 'yy-mm-dd'});
		$('#arrival_date').datepicker({dateFormat:'yy-mm-dd', altField: '#start_top_alt', altFormat: 'yy-mm-dd'});
	
        function update(){
                  $('#display')
                        .text(
                                ($('#number[]').val() * $('#unit_price[]').val() - $('#discount[]').val() * $('#number[]').val() * $('#unit_price[]').val() / 100)
                    );  
                }
                $('#number').keyup(update);
                $('#unit_price').change(update);
                $('#discount').change(update);
    </script>
	
<style>
#some-element {
  border: 1px solid #ccc;
  display: none;
  font-size: 10px;
  margin-top: 10px;
  padding: 5px;
  text-transform: uppercase;
}

#some-div:hover #some-element {
  display: block;
}
</style>


<?php include('footer.php'); ?>