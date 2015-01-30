<?php include('header.php'); ?>

<?php 

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
<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('confirm_delete_product');?>');
}
</script>

			<?php echo form_open($this->config->item('admin_folder').'/invoices/update_credit_note/'.$id ); ?>
				<div class="panel panel-default" style="width: 100%; float: left;">
					<div class="panel-heading">Credit note to...<?php //echo lang('invoice_details'); ?><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
						</div>
							<div class="panel-body">
								<table class="table table-striped" style="border: 1px solid #ddd;">
									<tbody>
										<tr>
											<td><?php echo lang('credit_number'); ?></td>
											<td style="white-space:nowrap"><?php echo $credit_note->credit_note_number; ?></td>
										</tr>
										<tr>
											<td><?php echo lang('invoice_customer'); ?></td>
											<td style="white-space:nowrap"><a href="<?php echo $this->config->item('base_url').$this->config->item('admin_folder').'/customers/form/'.$c_id->id; ?>"><?php echo $credit_note->customer_number.'&nbsp'.$credit_note->company; ?></a></td>
										</tr>
										<tr>
											<td><?php echo lang('order_number'); ?></td>
											<td style="white-space:nowrap"><?php echo $credit_note->order_number; ?></td>
										</tr>
											<tr>
												<td><?php echo lang('delivery_condition'); ?></td>
												<td style="white-space:nowrap"><?php echo form_dropdown('delivery_condition',$condition,$credit_note->delivery_condition); ?></td>
											</tr>
											<tr>
												<td><?php echo lang('payment_condition'); ?></td>
												<td style="white-space:nowrap"><?php echo form_dropdown('payment_condition',$payment_condition_array,$credit_note->payment_condition); ?></td>
											</tr>
											<tr>
												<td><?php echo lang('invoice_per_email'); ?></td>
												<td style="white-space:nowrap">
																	<?php
																		$data = array(
																			'name'        => 'invoice_per_email',
																			'id'          => 'invoice_per_email',
																			'value'       => '1',
																			'checked'     => $credit_note->per_email,
																			'style'       => 'margin:10px',
																			);

																		echo form_checkbox($data);
																	?>
												</td>
											</tr>
											<tr>
												<td><?php echo lang('email_address'); ?></td>
												<td style="white-space:nowrap"><input name="email" type="text" value="<?php echo $credit_note->email; ?>" class="gc_check"/></td>
											</tr>
											<tr>
												<td><?php echo lang('email_address'); ?></td>
												<td style="white-space:nowrap">
													<?php if(!empty($invoices_pdf)) { 

													?>&nbsp;<a class="btn" href="<?php echo site_url('admin/invoices/new_credit_note_pdf/'.$id.'/'.$credit_note->credit_note_number);?>" target="_blank"><?php echo lang('new_pdf');?></a><?php
													} 
													else {
														?>&nbsp;<a class="btn" href="<?php echo site_url('admin/invoices/credit_note_pdf/'.$id.'/'.$credit_note->credit_note_number);?>" target="_blank"><?php echo lang('pdf');?></a> <?php
													}
													?>
													<a class="btn" title="<?php echo lang('send_email_notification');?>" onclick="$('#notification_form').slideToggle();"><i class="icon-envelope"></i> <?php echo lang('send_email_notification');?></a>
												</td>
											</tr>
											<tr>
												<td><?php echo lang('order_date'); ?></td>
												<td style="white-space:nowrap"><?php echo $credit_note->invoice_created_on; ?></td>
											</tr>   
											<tr>
												<td><?php echo lang('artikel_dispatch_date'); ?></td>
												<td style="white-space:nowrap"><?php echo $credit_note->order_dispatch_date; ?></td>
											</tr> 
											<tr>
												<td><?php echo lang('invoice_dispatch_date'); ?></td>
												<td style="white-space:nowrap"><?php echo $credit_note->invoice_created_on; ?></td>
											</tr>
											<tr>
												<td><?php echo lang('invoice'); ?></td>
												 <td style="white-space:nowrap"><?php echo lang('credit_note_belongs'); ?><a href="<?php echo $this->config->item('base_url').$this->config->item('admin_folder').'/invoices/view/'.$credit_note->invoice_id; ?>">
													<?php echo $credit_note->invoice_number; ?></a>
												</td>
											</tr> 	
									</tbody>
								</table>
							</div>
						</div>

						
					<div class="panel panel-default" style="width: 100%; float: left;">
						<div class="panel-heading">PDF Credit notes<?php //echo lang('invoice_details'); ?><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
							</div>
								<div class="panel-body">
									<table class="table table-striped" style="border: 1px solid #ddd;">
										<tr><td>Credit note Number</td><td>Delete</td></tr>	
													<?php 
													if(!empty($invoices_pdf)) { 
														foreach ($invoices_pdf as $pdf){
																if(!is_dir($pdf)){
																	if(!is_numeric(substr($pdf,0,2))){
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
		<div class="panel-heading">Credit note products<?php //echo lang('invoice_details'); ?><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
				<div class="panel-body">
					<table id="myTable" class="table table-bordered" style="border: 1px solid #ddd;">
						
							<thead>
									<tr>
										<th><?php echo lang('product_nr');?></th>
										<th><?php echo lang('quantity');?></th>
										<th>VPA<?php //echo lang('package_details');?></th>
										<th><?php echo lang('price');?></th>
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
												<td><?php echo $this->config->item('currency_symbol'); ?><input style="background: #E8E8E8 ; color: #000000:" type="text" name="unit_price[]" value="<?php echo '- '.$product['unit_price']?>" class="span2" /></td>
												<td><strong><?php echo $this->config->item('currency_symbol'); ?>&nbsp;<?php echo '- '.$product['unit_price']*$product['quantity']; ?></strong></td>
												<td><input style="background: #E8E8E8 ; colour: #000000; width: 100%;" type="text" name="description[]" value="<?php echo $product['description']?>" class="span2" /></td>
												<input type="hidden" name="total[]" value="<?php echo $product['unit_price']*$product['quantity']; ?>" class="span2" />
												<input type="hidden" name="product_id[]" value="<?php echo $product['product_id']?>" class="span2" />
												<td style="text-align: center; width: 50px;">
													<a class="glyphicon glyphicon-trash" style="display: inline-block;" onclick="return areyousure()" href="<?php echo site_url($this->config->item('admin_folder').'/invoices/delete_credit_note_product/'.$id.'/'.$product['code']); ?>"><?php //echo lang('form_view')?></a>
												</td>
									</tr>
									<?php 
									
										$total_net[] =  $product['unit_price']*$product['quantity'];
 									
									?>
								<?php endforeach;?>
							</tbody>

							<tfoot>
							<?php 
							$totalnet = array_sum($total_net);
							
							
							?>
							<tr>
										<td><strong><?php echo lang('total_price_net');?></strong></td>
										<td colspan="2"></td>
										<td>- <?php echo format_currency($totalnet); ?></td>
										<input type="hidden" name="totalnet" value="<?php echo $totalnet; ?>" class="span2" />
							</tr>
							<tr>
										<td><strong><?php echo lang('shipping');?></strong></td>
										<td colspan="2"></td>
										<td>
										<?php 
											if(!empty($credit_note->shipping)){
												?><?php echo $this->config->item('currency_symbol'); ?><input style="background: #E8E8E8 ; colour: 	#000000:" type="text" name="dispatch_costs" value="<?php echo '- '.$credit_note->shipping; ?>" class="span2" /><?php
											}
											 else {
												?><?php echo $this->config->item('currency_symbol'); ?><input style="background: #E8E8E8 ; colour: 	#000000:" type="text" name="dispatch_costs" value="" class="span2" /><?php
											 }
										?>
										</td>
							</tr>
							<tr>
										<td><strong><?php echo lang('vat');?>&nbsp;&nbsp;<?php //echo str_replace('.00', '%', $product->vat); ?></strong></td>
										<td colspan="2"></td>
										<td>
											<?php 
												if(!empty($credit_note->VAT)){
													?><?php echo $this->config->item('currency_symbol'); ?><input style="background: #E8E8E8 ; colour: 	#000000:" type="text" name="VAT" value="<?php echo '- '.$credit_note->VAT; ?>" class="span2" /><?php
												} else {
													?><?php echo $this->config->item('currency_symbol'); ?><input style="background: #E8E8E8 ; colour: 	#000000:" type="text" name="VAT" value="" class="span2" /><?php
												}
											?>
										</td>
							</tr>
							<tr>
										<td><h4><?php echo lang('total_price_gross');?></h4></td>
										<td colspan="2"></td>
										<td><strong><?php echo '- '.format_currency($totalnet+$credit_note->VAT+$credit_note->shipping); ?></strong></td>
										<input type="hidden" name="totalgross" value="<?php echo format_currency($totalnet+$credit_note->VAT+$credit_note->shipping); ?>" class="span2" />
							</tr>
						</tfoot>
					</table>
					
				</div>
				
			</div>
			<th><button class="btn btn-primary" type="submit"><?php echo lang('update'); ?></button></th>
		</div>
		
</form>
<?php include('footer.php');