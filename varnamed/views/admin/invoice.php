<?php include('header.php'); ?>
<link href='http://fonts.googleapis.com/css?family=Abel' rel='stylesheet' type='text/css'>
<?php 
$empty_address = $this->session->flashdata('empty_address');
if(!empty($empty_address)){
echo $empty_address;
}
$condition = array(
    NULL                     => lang('select_delivery_condition'),
    '1'         => lang('free_shipment'),
    '2'    => lang('calculate_shipment'),
    );
	
	$payment_condition_array = array(
    
    '0' => lang('select_payment_condition'),
    '1' => lang('30_without_deduction'),
    '3' => lang('8_without_deduction'),
    '4' => lang('immediately_without_deduction'),
    '5' => lang('42_without_deduction'),
    
);
	
	
	
	
	
	
?>
<script>
function areyousure()
{
	return confirm('<?php echo lang('confirm_delete_order');?>');
}
function areyousure_remove()
{
	return confirm('<?php echo 'Remove Product?';?>');
}

</script>
<?php
	if($this->session->flashdata('message')){

	echo $this->session->flashdata('message');


	}
?>

<br>
		<?php 
			if(!empty($message)){
			
			?>
				<div class="alert alert-error">
				<button class="close" data-dismiss="alert">×</button>
				<strong>Error!</strong>
				<?php echo $message; ?>
				</div>
			<?php
			}
		?>
		
        <tr>
			<?php echo form_open($this->config->item('admin_folder').'/invoices/credit_note/'.$id); ?>
								<input type="hidden" name="invoice_number" value="<?php echo $invoice->invoice_number; ?>">
								<input type="hidden" name="order_number" value="<?php echo $invoice->order_number; ?>">
								<input type="hidden" name="customer_number" value="<?php echo $invoice->customer_number; ?>">
						<!--&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&-->
							<?php foreach($ordered_products as $product): ?>
								<input type="hidden" name="code[]" value="<?php echo $product['code']?>" class="span2" /></td>
								<input type="hidden" name="quantity[]" value="<?php echo $product['quantity']?>" class="span1" /></td>
								<input type="hidden" name="vpa[]" value="<?php echo $product['vpa']?>" class="span2" /></td>
								<input type="hidden" name="unit_price[]" value="<?php echo $product['unit_price']?>" class="span2" /></td>
								<input type="hidden" name="product_total[]" value="<?php echo $product['unit_price']*$product['quantity']; ?>"></td>
								<input type="hidden" name="description[]" value="<?php echo $product['description']?>" class="span2" /></td>
								<input type="hidden" name="total[]" value="<?php echo $product['unit_price']*$product['quantity']; ?>" class="span2" />
								<input type="hidden" name="product_id[]" value="<?php echo $product['id']?>" class="span2" />
							<?php endforeach; ?>
								<input type="hidden" name="totalgross" value="<?php echo ($product['unit_price']*$product['quantity'])+$invoice->VAT+$invoice->dispatch_costs; ?>" class="span2" />
								<input type="hidden" name="dispatch_costs" value="<?php echo $invoice->dispatch_costs; ?>" class="span2" />
								<input type="hidden" name="totalnet" value="<?php echo $product['unit_price']*$product['quantity']; ?>" class="span2" />
								<input type="hidden" name="VAT" value="<?php echo $invoice->VAT; ?>" class="span2" />
						<!--&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&-->
                        <td style="white-space:nowrap"><input class="btn btn-primary" type="submit" value="Make credit note" name="create_credit_note"></td>

                </form>
        </tr> 
<br>		
<?php echo form_open($this->config->item('admin_folder').'/invoices/update/'.$id ); ?>

	<div class="panel panel-default" style="width: 100%; float: left;">
		<div class="panel-heading"><?php echo lang('invoice_details'); ?><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
				<div class="panel-body">
					<table class="table table-striped" style="border: 1px solid #ddd;">
						<tbody>
							<tr>
								<td style="font-family: 'Abel', sans-serif; font-size: 16px;"><?php echo lang('invoice_number'); ?></td>
								<td style="font-family: 'Abel', sans-serif; font-size: 16px;" style="white-space:nowrap "><?php echo $invoice->invoice_number; ?></td>
								<input type="hidden" name="invoice_number" value="<?php echo $invoice->invoice_number; ?>">
								<input type="hidden" name="order_id" value="<?php echo $invoice->order_id_number; ?>" />
							</tr>
							<tr>
								<td style="font-family: 'Abel', sans-serif; font-size: 16px;"><?php echo lang('invoice_customer'); ?></td>
								<?php if(!empty($c_id->id)){ ?>
								<td style="font-family: 'Abel', sans-serif; font-size: 16px;" style="white-space:nowrap">
									<a href="<?php echo $this->config->item('base_url').$this->config->item('admin_folder').'/customers/form/'.$c_id->id; ?>"><?php echo $invoice->customer_number.' - '.$invoice->company; ?></a>
								</td>
								<?php }	else {
								?>
								 <td style="font-family: 'Abel', sans-serif; font-size: 16px;" style="white-space:nowrap"><a href="<?php echo $this->config->item('base_url').$this->config->item('admin_folder').'/customers/form/'.$invoice->customer_id; ?>"><?php echo $invoice->company.$invoice->customer_number; ?></a></td>
								<?php
								}
								?>
							</tr>
							<tr>
								<td style="font-family: 'Abel', sans-serif; font-size: 16px;"><?php echo lang('company'); ?></td>
								<td style="font-family: 'Abel', sans-serif; font-size: 16px;"><input style="background: #E8E8E8 ; colour:#000000:" type="text" name="company" value="<?php echo $invoice->company; ?>"></td>
							</tr>
							<tr>
								<td style="font-size: 12px;"><?php echo lang('firstname'); ?></td>
								<td><input style="background: #E8E8E8 ; color: 	#000000:" type="text" name="firstname" value="<?php echo $invoice->firstname; ?>"></td>
							</tr>
							<tr>
								<td style="font-size: 12px;"><?php echo lang('lastname'); ?></td>
								<td><input style="background: #E8E8E8 ; color: 	#000000:" type="text" name="lastname" value="<?php echo $invoice->lastname; ?>"></td>
							</tr>
							<tr>
									<td><?php echo lang('order_number'); ?></td>
									<td style="white-space:nowrap"><?php echo $invoice->order_number; ?></td>
									<input type="hidden" name="order_number" value="<?php echo $invoice->order_number; ?>" />
							</tr>
							<tr>
								<td><?php echo lang('delivery_condition'); ?></td>
								<td style="white-space:nowrap"><?php echo form_dropdown('delivery_condition',$condition,$invoice->delivery_condition); ?></td>
							</tr>
							<tr>
								<td><?php echo lang('payment_condition'); ?></td>
								<td style="white-space:nowrap"><?php echo form_dropdown('payment_condition',$payment_condition_array,$invoice->payment_condition); ?></td>
							</tr>
							<tr>
								<td><?php echo lang('invoice_per_email'); ?></td>
								<td style="white-space:nowrap">
								<?php
									$data = array(
										'name'        => 'invoice_per_email',
										'id'          => 'invoice_per_email',
										'value'       => '1',
										'checked'     => $invoice->per_email,
										'style'       => 'margin:10px',
										);

									echo form_checkbox($data);
								?>
							</td>
							</tr>
							<tr>
								<td><?php echo lang('email'); ?></td>
								<td><input style="background: #E8E8E8 ; color: 	#000000:" name="email" type="email" value="<?php echo $email; ?>" /></td>
							</tr>
							<tr>
								<td>Download<?php //echo lang('pdf'); ?></td>

								<td>
									<?php
										if($this->data_shop == 3){
									?>
										<a href="http://glovers.com/Glovers/client_files/<?php echo $invoice->customer_id; ?>/docs/<?php echo $invoice->invoice_number.'.pdf'; ?>" target="_blank" ><?php echo $invoice->invoice_number.'.pdf'; ?></a>
									<?php
										}
									?>
									<?php if(!empty($invoices_pdf)) { 

									?>&nbsp;<a class="btn" href="<?php echo site_url('admin/invoices/new_pdf/'.$invoice->invoice_number);?>" target="_blank"><?php echo lang('new_pdf');?></a><?php
									} 
									else {
										?>&nbsp;<a class="btn" href="<?php echo site_url('admin/invoices/pdf/'.$invoice->invoice_number);?>" target="_blank"><?php echo lang('pdf');?></a> <?php
									}
									?>
								

							   <!-- <a class="btn" href="<?php //echo site_url('admin/invoices/packing_slip/'.$invoice->id);?>" target="_blank"><?php //echo lang('send_email');?></a> -->
							   
									<a class="btn" href="<?php echo site_url('admin/invoices/download_word/'.$invoice->invoice_number);?>"><?php echo lang('word');?></a></td>
							</tr>
							<tr>
								<td><?php echo lang('invoice_paid'); ?></td>
								<td>&nbsp;
								<?php
									$data = array(
										'name'        => 'invoice_paid',
										'id'          => 'invoice_paid',
										'value'       => '1',
										'checked'     => $invoice->fully_paid,
										'style'       => 'margin:10px',
										);

									echo form_checkbox($data);
								?>
								<span><?php echo lang('invoice_date'); ?><input style="background: #E8E8E8 ; color: 	#000000:" name="invoice_date" id="invoice_date" type="text" value="<?php echo $invoice->paid_on; ?>" class="span2"/></span></td>
								<script>$('#invoice_date').datepicker({dateFormat:'yy-mm-dd', altField: '#start_top_alt', altFormat: 'yy-mm-dd'});</script>
							</tr>    
							<tr>
								<td><?php echo lang('order_date'); ?></td>
								<td style="white-space:nowrap"><?php echo $order_date; ?></td>
							</tr>   
							<tr>
								<td><?php echo lang('artikel_dispatch_date'); ?></td>
								<td style="white-space:nowrap"><?php echo $invoice->order_dispatch_date; ?></td>
							</tr> 
							<tr>
								<td><?php echo lang('invoice_dispatch_date'); ?></td>
								<td style="white-space:nowrap">
									<?php
										if(!empty($invoice->created_on)){
											echo $invoice->created_on;
										} else {
											
										}
									?>
								</td>
							</tr>
							<tr>
								<td><?php echo lang('credit_note'); ?></td>
								<td style="white-space:nowrap">
									<?php
										if(!empty($credit_notes)){
											foreach($credit_notes as $credit_note){
												?><span><a href="<?php echo site_url($this->config->item('admin_folder').'/invoices/view_credit_note/'.$credit_note['id'].'/'.$credit_note['credit_note_number']); ?>"><?php echo $credit_note['credit_note_number']; ?></a> ; </span><?php
											}
										}
									?>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
	
	<div class="panel panel-default" style="width: 100%; float: left;">
		<div class="panel-heading">PDF Invoices<?php //echo lang('invoice_details'); ?><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
				<div class="panel-body">
					<table class="table table-striped" style="border: 1px solid #ddd;">
						<tr><td>Invoice Number</td><td>Delete</td></tr>	
									<?php 
									if(!empty($invoices_pdf)) { 
										foreach ($invoices_pdf as $pdf){
												if(!is_dir($pdf)){
													if(is_numeric(substr($pdf,0,2))){
														?>
															<tr>
																<td><?php echo '<a href="'.site_url("/client_files/$customer_id/docs/$pdf").'" target="_blank">'.$pdf.'</a>'; ?></td>
																<td></td>
															</tr>
														<?php
													}
												}
											}
										}
									?>
					</table>				
				</div>					
			</div>					
									
	<div class="panel panel-default" style="width: 100%; float: left;">
		<div class="panel-heading"><?php echo lang('invoice_details'); ?><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
				<div class="panel-body">
					<table id="myTable" class="table table-bordered" style="border: 1px solid #ddd;">
						<button id="addrow" class="glyphicon glyphicon-plus" ></button>
							<thead>
									<tr>
										<th><?php echo lang('product_nr');?></th>
										<th>Quantity<?php //echo lang('quantity');?></th>
										<th>VPA<?php //echo lang('package_details');?></th>
										<th><?php echo lang('price');?></th>
										<th>Article VAT<?php //echo lang('price');?></th>
										<th><?php echo lang('total');?></th>
										<th><?php echo lang('description');?></th>
									</tr>
							</thead>
							<tbody>
							<?php 
							$total_net = array();
							
							?>
								<?php foreach($ordered_products as $product):?>
									<tr>
												<td><input style="background: #E8E8E8 ; colour: #000000:" type="text" name="code[]" value="<?php echo $product['code']?>" class="span2" /></td>
												<td><input style="background: #E8E8E8 ; colour: #000000:" type="text" name="quantity[]" value="<?php echo $product['quantity']?>" class="span1" /></td>
												<td><input style="background: #E8E8E8 ; colour: #000000:" type="text" name="vpa[]" value="<?php echo $product['vpa']?>" class="span2" /></td>
												<td><?php echo $this->config->item('currency_symbol'); ?><input style="background: #E8E8E8 ; color: 	#000000:" type="text" name="unit_price[]" value="<?php echo $product['unit_price']?>" class="span2" /></td>
												<td>
													<?php echo format_currency($product['unit_price']*$product['VAT']/100,2); ?>
												</td>
												<td><strong><?php echo $this->config->item('currency_symbol'); ?>&nbsp;<?php echo $product['unit_price']*$product['quantity']; ?></strong><input type="hidden" name="product_total[]" value="<?php echo $product['unit_price']*$product['quantity']; ?>"></td>
												<td><input style="background: #E8E8E8 ; colour: #000000; width: 100%;" type="text" name="description[]" value="<?php echo $product['description']?>"  /></td>
												<td><a class="glyphicon glyphicon-trash" href="<?php echo site_url($this->config->item('admin_folder').'/invoices/remove/'.$product['id'].'/'.$id); ?>" onclick="return areyousure_remove();"></a></td>
												<input type="hidden" name="total[]" value="<?php echo $product['unit_price']*$product['quantity']; ?>" class="span2" />
												<input type="hidden" name="vat_ammount[]" value="<?php echo $product['unit_price']*$product['VAT']/100; ?>" class="span2" />
												<input type="hidden" name="product_id[]" value="<?php echo $product['id']?>" class="span2" />
									</tr>
									<?php 
											$st = $product['unit_price']*$product['quantity'];

											if(!empty($invoice->vat_index)){

												if($product['VAT'] == $invoice->vat_index){
										
													$VAT_N 		= $invoice->vat_index;
													$n_vat[] 	= round($st*$product['VAT']/100,2);
												}
												if($product['VAT'] != $invoice->vat_index){
													
													$VAT_D 		= $product['VAT'];
													$d_vat[] 	= round($st*$product['VAT']/100,2);
												}
											} elseif(empty($invoice->vat_index) and !empty($customer_vat_index)){

												if($product['VAT'] == $customer_vat_index){
										
													$VAT_N 		= $customer_vat_index;
													$n_vat[] 	= round($st*$product['VAT']/100,2);
												}
												if($product['VAT'] != $customer_vat_index){
													
													$VAT_D 		= $product['VAT'];
													$d_vat[] 	= round($st*$product['VAT']/100,2);
												}
											}else {
												if($product['VAT'] == $order_vat_index){

													$VAT_N 		= $order_vat_index;
													$n_vat[] 	= round($st*$product['VAT']/100,2);
												}
												if($product['VAT'] != $order_vat_index){

													$VAT_D 		= $product['VAT'];
													$d_vat[] 	= round($st*$product['VAT']/100,2);
												}
											}
											
											$total_net[] =  $product['unit_price']*$product['quantity'];
 									
									?>
									
								<?php endforeach;?>
							</tbody>
							<tfoot>
							<?php 
							$totalnet = array_sum($total_net)+$invoice->dispatch_costs;
							
							
							?>

								<tr>
									<td><strong><?php echo lang('shipping');?></strong></td>
									<td colspan="4"></td>
									<td>
										<?php 
											if(!empty($order_details['shipping'])){
												?><?php echo $this->config->item('currency_symbol'); ?><input style="background: #E8E8E8 ; colour: 	#000000:" type="text" name="dispatch_costs" value="<?php echo $invoice->dispatch_costs; ?>" class="span2" /><?php
											}
											else {
												?><?php echo $this->config->item('currency_symbol'); ?><input style="background: #E8E8E8 ; colour: 	#000000:" type="text" name="dispatch_costs" value="" class="span2" /><?php
											}
										?>
									</td>
								</tr>
								<tr>
									<td><strong><?php echo lang('total_price_net');?></strong></td>
									<td colspan="4"></td>
									<td><?php echo format_currency($totalnet+$invoice->dispatch_costs); ?></td>
									<input type="hidden" name="totalnet" value="<?php echo $totalnet+$invoice->dispatch_costs; ?>" class="span2" />
								</tr>
<!-- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->								

									<?php

										$n_vats 				=	array_sum($n_vat);
										$d_vats 				=	array_sum($d_vat);
										
										$vat_shipping_costs 	= 	$shipping_costs*$VAT_N/100;
										$vat_shipping_costs_d 	= 	$shipping_costs*$VAT_N/100;
										
										if(!empty($VAT_N) and !empty($VAT_D)){
											?>
												<tr>
													<td style="font-size: 11px;"><strong><?php echo lang('vat');?></strong></td>
													<td colspan="" style="font-size: 11px;"><?php echo $VAT_N.'%'; ?></td>
													<td colspan='3' style="font-size: 12px;">
													<span style="color: blue;"><?php echo 'VAT for the ordered products, different from nutrition'; ?></span>
													</td>
													<td><?php echo format_currency($n_vats,2); ?></td>
												</tr>
												<tr>
													<td style="font-size: 11px;"><strong><?php echo lang('vat');?></strong></td>
													<td colspan="" style="font-size: 11px;"><?php echo $VAT_N.'%'; ?></td>
													<td colspan='3' style="font-size: 12px;">
													<span style="color: blue;"><?php echo 'VAT for the shipping costs for the ordered products, different from nutrition'; ?></span>
													</td>
													<td><?php echo format_currency($vat_shipping_costs,2); ?></td>
												</tr>
											<?php

												foreach($ordered_products as $product){
													if($product['special_vat'] == 1){
														$st 		= $product['unit_price']*$product['quantity'];
														$d_vat 		= round($st*$product['VAT']/100,2);
														?>
															<tr>
																<td style="font-size: 11px;"><strong><?php echo lang('vat');?></strong></td>
																<td colspan="" style="font-size: 11px;"><?php echo $VAT_D.'%'; ?></td>
																<td colspan='3' style="font-size: 12px;">
																<span style="color: blue;"><?php echo 'VAT for product'.' '.$product['code']; ?></span>
																</td>
																<td><?php echo format_currency($d_vat,2); ?></td>
															</tr>
														<?php
													}
												}

												?><input type="hidden" name="VAT" value="<?php echo $n_vats+$vat_shipping_costs+$d_vats; ?>" /><?php
												?><input type="hidden" name="ship_vat_rate" value="<?php echo $vat_shipping_costs; ?>" /><?php
										}
										if(!empty($VAT_N) and empty($VAT_D)){
											?>
											
												<tr>
													<td style="font-size: 11px;"><strong><?php echo lang('vat');?></strong></td>
													<td colspan="" style="font-size: 11px;"><?php echo $VAT_N.'%'; ?></td>
													<td colspan='3' style="font-size: 12px;"></td><td><?php echo format_currency($n_vats+$vat_shipping_costs,2); ?></td>
													<input type="hidden" name="VAT" value="<?php echo $n_vats; ?>" />
												</tr>
											<?php
										}
									?>
							
							
							
<!-- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->	

									<tr>
										<td style="font-size: 11px;"><strong><?php echo lang('gross');?></strong></td>
										<td colspan="4"></td>
										<?php 
										if(!empty($VAT_N) and !empty($VAT_D)){
										echo 'test';
											?>
												<td><strong><?php echo format_currency($totalnet+$n_vats+$vat_shipping_costs+$d_vats); ?></strong></td>
												<input type="hidden" name="totalgross" value="<?php echo $totalnet+$n_vats+$vat_shipping_costs+$d_vats; ?>">
											<?php
											}
										?>
										<?php 
										if(!empty($VAT_N) and empty($VAT_D)){
										echo 'test';
											?>
												<td><strong><?php echo format_currency($totalnet+$n_vats+$vat_shipping_costs); ?></strong></td>
												<input type="hidden" name="totalgross" value="<?php echo $totalnet+$n_vats+$vat_shipping_costs; ?>">
											<?php
											}
										?>
									</tr>
						</tfoot>
					</table>
				</div>
			</div>


				<div class="panel panel-default" style="width: 100%; float: left;">
					<div class="panel-heading">INFO<?php //echo lang('invoice_details'); ?><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
						</div>
						<div class="panel-body">
							<table class="table table-striped">
									<tr>
										<td style="text-align:center; text-transform: uppercase;"><h5>Payment info<?php //echo lang('customer_info');?></h5></td>
										<td style="text-align:center; text-transform: uppercase;"><h5>Remarks<?php //echo lang('invoice_agreements');?></h5></td>
									</tr>
									<tr>
										<td style="padding:5px;">
											<textarea name="payment_info" style="width:400px;"><?php if(!empty($invoice->payment_info)) echo $invoice->payment_info;?></textarea>
										</td>
										<td style="padding:5px;">
												<textarea name="invoice_note" style="width:400px;"><?php if(!empty($invoice->notes)) echo $invoice->notes;?></textarea>
										</td>
								</tr>	
						</table>
					</div>
				</div>
			<button class="btn btn-primary" type="submit"><?php echo lang('update'); ?></button>
</form>

				<div class="panel panel-default" style="width: 100%; float: left;">
					<div class="panel-heading">Addresses<?php //echo lang('invoice_details'); ?><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
						</div>
						<div class="panel-body">
							<table class="table table-striped">
									<tr>
										<td style="text-align:center; text-transform: uppercase;"><h5><?php echo lang('invoice_address');?></h5></td>
										<td style="text-align:center; text-transform: uppercase;"><h5><?php echo lang('delivery_address');?></h5></td>
									</tr>
									<tr>
										<td style="padding:5px;">
											<?php if(!empty($invoice_address)): ?>
												<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('company'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $invoice_address['NAAM1']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('firstname'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $invoice_address['NAAM2']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('lastname'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $invoice_address['NAAM3']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;">Street<?php //echo lang('street'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $invoice_address['STRAAT']; ?>">&nbsp;<input type="text"  style="width: 100px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $invoice_address['HUISNR']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;">Postcode<?php //echo lang('zip'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $invoice_address['POSTCODE']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('city'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $invoice_address['PLAATS']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('country'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $invoice_address['LAND']; ?>"><br><br>
											<?php endif; ?>	
										</td>
										<td style="padding:5px;">
											<?php if(!empty($delivery_address)): ?>
												<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('company'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['NAAM1']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('firstname'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['NAAM2']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('lastname'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['NAAM3']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;">Street<?php //echo lang('street'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['STRAAT']; ?>">&nbsp;<input type="text"  style="width: 100px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['HUISNR']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;">Postcode<?php //echo lang('zip'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['POSTCODE']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('city'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['PLAATS']; ?>"><br>
												<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('country'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['LAND']; ?>"><br><br>
											<?php endif; ?>	
										</td>
										<?php if($this->data_shop == 3): ?>
											<?php if(!empty($drop_shipment_address)): ?>
												<td style="padding:5px;">
														<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('company'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['NAAM1']; ?>"><br>
														<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('firstname'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['NAAM2']; ?>"><br>
														<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('lastname'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['NAAM3']; ?>"><br>
														<label style="font-family: 'Inconsolata'; font-size: 18px;">Street<?php //echo lang('street'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['STRAAT']; ?>">&nbsp;<input type="text"  style="width: 100px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['HUISNR']; ?>"><br>
														<label style="font-family: 'Inconsolata'; font-size: 18px;">Postcode<?php //echo lang('zip'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['POSTCODE']; ?>"><br>
														<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('city'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['PLAATS']; ?>"><br>
														<label style="font-family: 'Inconsolata'; font-size: 18px;"><?php echo lang('country'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label><input type="text"  style="width: 350px; height: 30px; background: #F5F5F5;" name="name" value="<?php echo $delivery_address['LAND']; ?>"><br><br>
												</td>
										<?php endif; ?>
											<?php endif; ?>
									</tr>
									<tr>
										<td style="padding:5px;">
											<a class="btn btn-info btn-sm" href="<?php echo site_url($this->config->item('admin_folder').'/customers/addresses/'.$invoice->customer_id); ?>">Edit addresses<?php //echo lang('change_address');?></a>
										</td>
									</tr>
							</table>
						</div>
				</div>

</div>


<?php include('footer.php'); ?>





<link href='http://fonts.googleapis.com/css?family=Inconsolata' rel='stylesheet' type='text/css'>
        <script>
        $(document).ready(function () {
            var counter = 0;

            $("#addrow").on("click", function () {


                var counter = $('#myTable tr').length - 2;

                $("#ibtnDel").on("click", function () {
                    counter = -1
                });


                var newRow = $("<tr>");
                var cols = "";

                cols += '<td><input type="text" class="span2" name="code[]' + counter + '" required/></td>';
                cols += '<td><input type="text" class="span1" name="quantity[]' + counter + '" required/></td>';
                cols += '<td><input type="text" class="span2" name="vpa[]' + counter + '"/></td>';
                cols += '<td><input type="text" class="span2" name="unit_price[]' + counter + '"/></td><td></td><td></td>';
                cols += '<td><input type="text" class="span3" name="description[]' + counter + '"/></td>';




                cols += '<td><button id="ibtnDel" class="glyphicon glyphicon-trash" style="display: inline-block; " ></button></td>';
                newRow.append(cols);
                if (counter == 20) $('#addrow').attr('disabled', true).prop('value', "You've reached the limit");
                $("table.table-bordered").append(newRow);
                counter++;
            });

            $("table.table-bordered").on("change", 'input[name^="unit_price"]', function (event) {
                calculateRow($(this).closest("tr"));
                calculateGrandTotal();
            });


            $("table.table-bordered").on("click", "#ibtnDel", function (event) {
                $(this).closest("tr").remove();
                calculateGrandTotal();
            });


        });



        function calculateRow(row) {
            var number = +row.find('input[name^="unit_price"]').val();

        }

        function calculateGrandTotal() {
            var grandTotal = 0;
            $("table.table-bordered").find('input[name^="unit_price"]').each(function () {
                grandTotal += +$(this).val();
            });
            $("#grandtotal").text(grandTotal.toFixed(2));
        }
        </script>