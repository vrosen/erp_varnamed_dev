<?php include('header.php'); ?>
<link href='http://fonts.googleapis.com/css?family=Raleway:500' rel='stylesheet' type='text/css'>

	<script type="text/javascript">
		function areyousure()
		{
			return confirm('<?php echo 'Confirm delete contact?'; ?>');
		}
	</script>	
		<div id="sidebar" style="float: right; width: 23%;" >
			<div class="panel panel-default" style="width: 97%; float: right;">
				<div class="panel-heading">Contact persons<span class="closeit glyphicon glyphicon-chevron-down pull-right"></span></div>
					<div class="panel-body">	
								<tr>
									<td><a  class="btn btn-info btn-xs" style="display: inline-block; font-size: 11px;"  data-toggle="modal" href="#myModal_N" href="<?php echo site_url($this->config->item('admin_folder').'/suppliers/contact_form/');?>">New Contact<?php //echo lang('form_view')?></a>
									</td>
								</tr>	
						<?php $i = 0; ?>
							<?php foreach($supplier_contacts as $supplier_contact): ?>
							
							<table class="leftblock_content" style="font-size: 12px; color: black; width: 100%; ">
							<div class="panel-body">
								<tr>
								
								
									<td>Contact person : </td>
									<td><input type="text" name="" style="width: 100%;" value="<?php echo $supplier_contact->contact_person; ?>" /></td>
								</tr>							
								<tr>
									<td>Phone : </td>
									<td><input type="text" name="" style="width: 100%;" value="<?php echo $supplier_contact->phone; ?>" /></td>
								</tr>							
								<tr>
									<td>Fax : </td>
									<td><input type="text" name="" style="width: 100%;" value="<?php echo $supplier_contact->fax; ?>" /></td>
								</tr>							
								<tr>
									<td>Email : </td>
									<td><input type="text" name="" style="width: 100%;" value="<?php echo $supplier_contact->email; ?>" /></td>
								</tr>
								<tr>
									<td>
										<a  class="glyphicon glyphicon-edit" data-placement="bottom" title='Edit' style="display: inline-block; font-size: 12px;" data-toggle="modal" href="<?php echo '#myModal'.$i; ?>" ></a>

											<a class="glyphicon glyphicon-trash" data-placement="bottom" title='Delete' onclick="return areyousure();" style="display: inline-block; font-size: 12px;" href="<?php echo site_url($this->config->item('admin_folder').'/suppliers/delete/'.$supplier_contact->id);?>"><?php //echo lang('form_view')?></a>
									</td>								
								</tr>
								</div>
								</table>
												<div class="modal fade" id="myModal<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
												<div class="modal-dialog">
												  <div class="modal-content" id="form-content" >
													<div class="modal-header">
													  <h4 class="modal-title" style="color: #2E0F2E;">Edit Contact</h4>
													</div>
														<form action="<?php echo site_url($this->config->item('admin_folder').'/suppliers/contact_form/');?>" id="edit-form" method="post">
														<div class="modal-body">
															<p>
																<table class="table table-striped" style="color: #2E0F2E;">
																						<input type="hidden" name="contact_id" id="contact_id" value="<?php echo $supplier_contact->id; ?>"/>
																						<input type="hidden" name="supplier_id" id="supplier_id" value="<?php echo $id; ?>" />
																						
																						<tr>
																							<td>Contact person : </td>
																							<td><input type="text" name="contact_person" id="contact_person" style="width: 100%;" value="<?php echo $supplier_contact->contact_person; ?>" /></td>
																						</tr>							
																						<tr>
																							<td>Phone : </td>
																							<td><input type="text" name="phone" id="phone" style="width: 100%;" value="<?php echo $supplier_contact->phone; ?>" /></td>
																						</tr>							
																						<tr>
																							<td>Fax : </td>
																							<td><input type="text" name="fax" id="fax" style="width: 100%;" value="<?php echo $supplier_contact->fax; ?>" /></td>
																						</tr>							
																						<tr>
																							<td>Email : </td>
																							<td><input type="text" name="email" id="email" style="width: 100%;" value="<?php echo $supplier_contact->email; ?>" /></td>
																						</tr>
																</table>
															</p>
														</div>
														<div class="modal-footer">
														  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														  <button type="submit" class="btn btn-info" id="myFormSubmit" >Save changes</button>
														</div>
													</form>
												  </div><!-- /.modal-content -->
												</div><!-- /.modal-dialog -->
											  </div><!-- /.modal -->
											  <?php $i++; ?>
							<?php endforeach; ?>
						
					</div>
			</div>
		</div>

								<script>
								$(document).ready(function () {
									$('#myFormSubmit').on('click', function(e) {
										e.preventDefault();
										$.ajax({
											url: $('form#edit-form').attr('action'),
											method: $('form#edit-form').attr('method'),
											data: $('form#edit-form').serialize(),
											success: function(e) {
												//window.location = $('form#edit-form').attr('action');
												$('#myModal').hide(), 
											},
											error: function(e) {
												alert('error');
											}
										});
									});
								});
								</script>
	
<div class="modal fade" id="myModal_N" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" id="form-content" >
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">New Contact</h4>
        </div>
			<form action="<?php echo site_url($this->config->item('admin_folder').'/suppliers/contact_form/');?>" id="edit-form" method="post">
			<div class="modal-body">
				<p>
					<table class="table table-striped">
						<tr>
							<input type="hidden" name="supplier_id" id="supplier_id" value="<?php echo $id; ?>" />
							<input type="hidden" name="shop_id" id="shop_id" value="<?php echo $shop_id; ?>" />
							<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
								Contact person : 
							</td>
							<td><input type="text" name="contact_person" id="contact_person" class="form-control" style="width: 100%;" /></td>
						</tr>							
						<tr>
							<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
								Phone : 
							</td>
							<td><input type="text" name="phone" id="phone" class="form-control" style="width: 100%;"  /></td>
						</tr>							
						<tr>
							<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
								Fax : 
							</td>
							<td><input type="text" name="fax" id="fax" class="form-control" style="width: 100%;" /></td>
						</tr>							
						<tr>
							<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
								Email : 
							</td>
							<td><input type="text" name="email" id="email" class="form-control" style="width: 100%;"  /></td>
						</tr>
					</table>
				</p>
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  <button type="submit" class="btn btn-info" id="myFormSubmit" >Save changes</button>
			</div>
		</form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
	
		<div class="panel panel-default" style="float: left; width: 75%;" id="customer_info">
			<div class="panel-heading">Recent orders<span id="stbar" class="closeit glyphicon glyphicon-chevron-down pull-right"></span></div>
				<div class="panel-body">
					<table class="table table-striped table-hover" style="border: 1px solid #ddd; ">
						<thead>
								<tr>
									<th><?php echo lang('date');?></th>
									<th><?php echo lang('order_num');?></th>
									<th><?php echo lang('status');?></th>
									<th><?php echo lang('entered_by');?></th>
								</tr>
						</thead>
						<tbody>
							<?php if (!empty($orders)):?>
								<?php foreach ($orders as $order): ?>   
									<tr>
										<td><?php echo $order['entered_on']; ?></td>
										<td><a href="<?php echo site_url($this->config->item('admin_folder')).'/suppliers/order/'.$order['id']; ?>" style="cursor: pointer; cursor: hand;"><?php echo $order['order_number']; ?></a></td>
										<td>
											<?php
												if($order['status'] == 0){
													echo 'New';
												}
												if($order['status'] == 1){
													echo 'Delivered';
												}
												if($order['status'] == 2){
													echo 'Cancelled';
												}
												if($order['status'] == 3){
													echo ')n Hold';
												}
											?>
										</td>
										<td><?php echo $order['entered_by']; ?></td>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
						</tbody>
					</table>
				</div>	
		</div>	




<!------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------>

	<?php echo form_open($this->config->item('admin_folder').'/suppliers/form/'.$id); ?>
		
		<div class="panel panel-default" style="float: left; width: 75%;" id="customer_info">
			<div class="panel-heading">Supplier's details<span id="stbar" class="closeit glyphicon glyphicon-chevron-down pull-right"></span></div>
				<div class="panel-body">
							<a class="btn btn-default btn-xs" style="margin-right: 3px;" href="<?php echo site_url($this->config->item('admin_folder').'/suppliers/start_order/'.$id);?>"><?php echo lang('new_order'); ?></a>
							<a class="btn btn-default btn-xs" style="margin-right: 3px;" href="<?php echo site_url($this->config->item('admin_folder').'/suppliers/addresses/'.$id); ?>">Supplier`s addresses<?php //echo lang('new_order'); ?></a>
							<br/><br/>
								<table class="table table-striped" style="border: 1px solid #ddd;">
									<thead>
										<td style="text-align: center; width: 30%;"></td>
									</thead>
									<tbody>
										<tr>
											 <td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
												<?php echo lang('number');?>
											</td>								
											<td>
												<input type="text" value="<?php echo $number; ?>" name="number" class="form-control" style="width: 99.5%; background: ;" />
											</td>
										</tr>
										<tr>
											<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
												<?php echo lang('company');?>
											</td>								
											<td>
												<input type="text" value="<?php echo $company; ?>" name="company" class="form-control" style="width: 99.5%; background: ;" />
											</td>
										</tr>

										<tr>
											<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
												<?php echo lang('street');?>
											</td>								
											<td>
												<input type="text" value="<?php echo $street; ?>" name="street" class="form-control" style="width: 99.5%; background: ;" />
											</td>
										</tr>							
										<tr>
											<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
												<?php echo lang('street_num');?>
											</td>								
											<td>
												<input type="text" value="<?php echo $street_num; ?>" name="street_num" class="form-control" style="width: 99.5%; background: ;" />
											</td>
										</tr>							
										<tr>
											<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
												<?php echo lang('post_code');?>
											</td>								
											<td>
												<input type="text" value="<?php echo $post_code; ?>" name="post_code" class="form-control" style="width: 99.5%; background: ;" />
											</td>
										</tr>							
										<tr>
											<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
												<?php echo lang('city');?>
											</td>								
											<td>
											<input type="text" value="<?php echo $plaats; ?>" name="city" class="form-control" style="width: 99.5%; background: ;" />
											</td>
										</tr>							
										<tr>
											<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
												<?php echo lang('country');?>
											</td>								
											<td>
												<input type="text" value="<?php echo $country; ?>" name="country" class="form-control" style="width: 99.5%; background: ;" />
											</td>
										</tr>							
										<tr>
											<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
												<?php echo lang('web');?>
											</td>								
											<td>
												<input type="text" value="<?php echo $web; ?>" name="web" class="form-control" style="width: 99.5%; background: ;" />
											</td>
										</tr>							
										<tr>
											<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
												<?php echo lang('cust_tariff');?>
											</td>								
											<td>
												<input type="text" value="<?php echo $cust_tariff; ?>" name="cust_tariff" class="form-control" style="width: 99.5%; background: ;" />
											</td>
										</tr>							
										<tr>
											<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
												<?php echo lang('account_number');?>
											</td>								
											<td>
												<input type="text" value="<?php echo $account_number; ?>" name="account_number" class="form-control" style="width: 99.5%; background: ;" />
											</td>
										</tr>							
										<tr>
											<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
												<?php echo lang('account_owner');?>
											</td>								
											<td>
												<input type="text" value="<?php echo $account_owner; ?>" name="account_owner" class="form-control" style="width: 99.5%; background: ;" />
											</td>
										</tr>							
										<tr>
											<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
												<?php echo lang('bank_number');?>
											</td>								
											<td>
												<input type="text" value="<?php echo $bank_number; ?>" name="bank_number" class="form-control" style="width: 99.5%; background: ;" />
											</td>
										</tr>							
										<tr>
											<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
												<?php echo lang('bank_name');?>
											</td>								
											<td>
												<input type="text" value="<?php echo $bank_name; ?>" name="bank_name" class="form-control" style="width: 99.5%; background: ;" />
											</td>
										</tr>							
										<tr>
											<td style="font-family: 'Raleway', sans-serif; padding-left: 10px;">
												<?php echo lang('supplier_info');?>
											</td>								
											<td>
												<textarea  class="form-control" style="width: 99.5%; background: ;" ><?php echo $supplier_info; ?></textarea>
											</td>
										</tr>
									<tbody>
								</table>
					<input class="btn btn-info" type="submit" value="<?php echo lang('save');?>"/>
					</form>
			</div>
		</div>

					
		<div class="panel panel-default" style="float: left; width: 75%;" id="customer_info">
			<div class="panel-heading">Supplier's products<span id="stbar" class="closeit glyphicon glyphicon-chevron-down pull-right"></span></div>
				<div class="panel-body">
					<table class="table table-striped" style="border: 1px solid #ddd;">
						<thead>
								<tr>
									<th><?php echo lang('number');?></th>
									<th>Price NL<?php //echo lang('price_NL');?></th>
									<th>Price DE<?php //echo lang('price');?></th>
									<th>Price AU<?php //echo lang('price');?></th>
									<th>Price FR<?php //echo lang('price');?></th>
									<th>Price BE<?php //echo lang('price');?></th>
									<th>Price UK<?php //echo lang('price');?></th>
									<th>Price LX<?php //echo lang('price');?></th>
									<th>for...<?php //echo lang('price');?></th>
									<th>Size <?php //echo lang('size');?></th>
									<th>Delivery time<?php //echo lang('delivery_time');?></th>
									<th><?php echo lang('name');?></th>
								</tr>
						</thead>
						<tbody>
							<?php if (!empty($supplier_products)):?>
								<?php foreach ($supplier_products as $supplier_product): ?>   
									<tr>
										<td><a href="<?php echo site_url($this->config->item('admin_folder').'/products/form/'.$supplier_product->id); ?>" style="cursor: pointer; cursor: hand; color: red;" ><?php echo str_replace('/','',$supplier_product->code); ?></a></td>
										<td><?php echo format_currency($supplier_product->saleprice_NL); ?></td>
										<td><?php echo format_currency($supplier_product->saleprice_DE); ?></td>
										<td><?php echo format_currency($supplier_product->saleprice_AU); ?></td>
										<td><?php echo format_currency($supplier_product->saleprice_FR); ?></td>
										<td><?php echo format_currency($supplier_product->saleprice_BE); ?></td>
										<td><?php echo format_currency($supplier_product->saleprice_UK); ?></td>
										<td><?php echo format_currency($supplier_product->saleprice_LX); ?></td>
										<td><?php echo '1 x '.$supplier_product->package_details; ?></td>
										<td><?php echo $supplier_product->size; ?></td>
										<td><?php echo $supplier_product->delivery_time; ?></td>
										<td><?php echo $supplier_product->$name; ?></td>
									</tr>
								<?php endforeach; ?>
							<?php endif; ?>
						</tbody>
					</table>
				</div>	
		</div>			

<?php include('footer.php'); ?>

<script>
var $tip1 = $('.glyphicon');
$tip1.tooltip({trigger: 'hover'});
</script>



