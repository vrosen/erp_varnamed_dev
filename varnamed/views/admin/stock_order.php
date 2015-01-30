<?php include('header.php'); ?>

<link href='http://fonts.googleapis.com/css?family=Raleway:500' rel='stylesheet' type='text/css'>


		<?php 
		if($order->status == 0 ){
				echo form_open($this->config->item('admin_folder').'/suppliers/update_new_order/'.$order->id, 'class="form-inline"');
		}
		else {
				echo form_open($this->config->item('admin_folder').'/stock/update_delivered_order/'.$order->id, 'class="form-inline"');
		}
		?>

		<div class="panel panel-default" style="float: left; width: 75%;" id="customer_info">
			<div class="panel-heading">Recent orders<span id="stbar" class="closeit glyphicon glyphicon-chevron-down pull-right"></span></div>
				<div class="panel-body">
					<table class="table table-striped" style="border: 1px solid #ddd; ">
						<tbody>
							<tr>
								<th style="font-family: 'Raleway', sans-serif;"><?php echo lang('order_number'); ?></th>
								<td><?php echo $order->order_number;?></td>
							</tr>
							<tr>
								<th style="font-family: 'Raleway', sans-serif;"><?php  echo lang('supplier');?></th>
								<td>
									<a href="<?php echo site_url($this->config->item('admin_folder').'/suppliers/form/'.$order->supplier_id); ?>">
									<?php echo strtoupper($order->supplier_name); ?>
									</a>
								</td>
							</tr>
							<tr>
								<th style="font-family: 'Raleway', sans-serif;"><?php  echo lang('order_date');?></th>
							<?php 
							if(!empty($order->ordered_on)){
								?><td><input id="ordered_on" class="form-control" name="ordered_on" value="<?php echo $order->ordered_on; ?>" type="date" placeholder="ordered date"/></td><?php
							}
							else {
								?><td><input id="ordered_on" name="ordered_on" class="form-control" value="<?php echo date('Y-m-d'); ?>" type="date" placeholder="ordered date"/></td><?php
							}
							?>
							</tr>
							<tr>
							<th style="font-family: 'Raleway', sans-serif;"><?php  echo lang('arrival_date');?></th>
							<?php 
								?><td><input id="arrival_date" name="arrival_date" class="form-control" value="<?php echo $order->arrival_date; ?>" type="date" placeholder="expexted date of arrival"/></td><?php
							?>
							</tr>
						</tbody>
					</table>
				<input type="hidden" name="entered_by" value="<?php echo $order->entered_by; ?>" />
			</div>
		</div>

						<div class="panel panel-default" style="float: left; width: 75%;" id="customer_info">
							<div class="panel-heading">Ordered products<span id="stbar" class="closeit glyphicon glyphicon-chevron-down pull-right"></span></div>
								<div class="panel-body">
									<table class="table table-striped" style="border: 1px solid #ddd; ">
										<thead>
											<tr>
												<th><?php echo lang('product');?></th>
												<th><?php echo lang('number_ordered');?></th>
												<th>VK<?php echo lang('VK');?></th>
												
												<?php if($order->status == 1): ?>
													<th><?php echo lang('number_recieved'); ?></th>
													<th>LotNr.</th>
													<th>Houdbaar</th>
												<?php endif; ?>
												
												<th><?php echo lang('unit_price');?></th>
												<th>Total<?php echo lang('total');?></th>
												<th><?php echo lang('description');?></th>
											</tr>
										</thead>
								<?php if(!empty($order_items)): ?>
								<tbody>
									<?php foreach ($order_items as $item): ?>
										<?php 
										if($order->status == 1){ 
										$k = count($item['code']);
										//print_r($order_items); 
										?>
										<tr>
											<td><input type="text" name="code[]" id="code[]" value="<?php echo form_decode($item['code']); ?>" class="span1" required /></td>
											<td><input type="text" name="ordered_quantity[]" id="ordered_quantity[]" value="<?php echo form_decode($item['ordered_quantity']); ?>" class="span1" required /></td>
											<td><input type="text" name="delivered_quantity[]" id="delivered_quantity[]" value="<?php echo form_decode($item['delivered_quantity']); ?>" class="span1" required /></td>
											<td><?php echo $item['batch_number']; ?></td>
											<td><input type="text" class="start_exp" name="expiration_date[]" value="<?php echo $item['expiration_date']; ?>" class="span2" /></td>
											<td><?php echo form_input(array('name'=>'package_details[]','value'=>form_decode($item['package_details']), 'class'=>'span1'));?></td>
											
											<td><?php echo form_input(array('name'=>'unit_price[]','value'=>$item['price'], 'class'=>'span1'));?></td>
											
											<td><?php echo format_currency($item['price']*$item['delivered_quantity']); ?></td>
											<td><?php echo form_decode($item['description']); ?></td>
											
											<input type="hidden" name="order_number" value="<?php echo $order->order_number; ?>">
											<input type="hidden" name="NR" value="<?php echo $order->NR; ?>">
											<input type="hidden" name="supplier_id" value="<?php echo $order->supplier_id; ?>">
											<input type="hidden" name="supplier_name" value="<?php echo $order->supplier_name; ?>">
											<input type="hidden" name="product_id[]" value="<?php echo $item['id']; ?>">
										</tr>
										<?php 
										if(!empty($item))
										$t_pr[] = form_decode($item['vk'])*form_decode($item['number']); 
										?>
										<?php $net_sum = array_sum($t_pr); ?>
										<?php
										}
										else {
										?>
										<tr>
											<td><input type="text" name="code[]" id="code[]" value="<?php echo form_decode($item['ARTIKELCOD']); ?>" class="span1" required /></td>
											<td><input type="text" name="quantity[]" id="quantity[]" value="<?php echo form_decode($item['AANTALBEST']); ?>" class="span1" required /></td>
											<td><?php echo form_input(array('name'=>'package_details[]','value'=>form_decode($item['CAANTALPER']), 'class'=>'span1'));?></td>
											<td><?php echo form_input(array('name'=>'unit_price[]','value'=>  format_currency($item['warehouse_price']), 'class'=>'span1'));?></td>
											<td><?php echo format_currency($item['total']); ?></td>
											<td><?php echo form_decode($item['FACTUUROMS']); ?></td>
											<input type="hidden" name="description" value="<?php echo $item['FACTUUROMS']; ?>" />
											<input type="hidden" name="order_number" value="<?php echo $order->order_number; ?>">
											<input type="hidden" name="NR" value="<?php echo $order->NR; ?>">
											<input type="hidden" name="supplier_id" value="<?php echo $order->supplier_id; ?>">
											<input type="hidden" name="supplier_name" value="<?php echo $order->supplier_name; ?>">
											<input type="hidden" name="product_id[]" value="<?php echo $item['id']; ?>">
										</tr>
										<?php 
										if(!empty($item))
										$t_pr[] = form_decode($item['vk'])*form_decode($item['number']); 
										$net_sum = array_sum($t_pr);
										}
										?>
										<?php endforeach; ?>
								</tbody>
								
									<tfoot>
										
											<tr>
													<td><strong><?php echo lang('netto');?></strong></td>
													<td colspan='3'></td><td><?php echo format_currency($order->total);   ?></td>	
													<input type="hidden" name="netto" value="<?php echo $order->total;   ?>">
											</tr>
											<tr>
													<td><strong><?php echo lang('vat');?></strong></td>
													<td colspan=""><input type="text" name="vat" value="<?php echo $vat; ?>" class="span1"></td>
													<td colspan='2'></td><td><?php echo format_currency($net_sum); ?></td>
													<input type="hidden" name="vat" value="<?php echo $net_sum; ?>">
											</tr>

											<tr>
													<td><h3><?php echo lang('gross');?></h3></td>
													<td colspan="3"></td>
													<td><?php echo format_currency($order->total); ?></td>
													<input type="hidden" name="gross" value="<?php echo $order->total; ?>">
											</tr>
									</tfoot>
								<?php endif; ?>
						</table>
					</div>
				</div>
				<div class="panel panel-default" style="float: left; width: 75%;" id="customer_info">
					<div class="panel-heading">Details<span id="stbar" class="closeit glyphicon glyphicon-chevron-down pull-right"></span></div>
						<div class="panel-body">
							<div class="table table-striped" style="padding: 5px;  width: 100%;  margin-bottom:15px;">
								<fieldset><legend style="font-family: 'Raleway', sans-serif;">Other remarks<?php echo lang('other_remarks');  ?></legend></fieldset>
									<textarea name="notes" class="form-control" style="width: 50%;"><?php echo $order->notes;?></textarea>
							</div>		
							<div class="table table-striped" style="padding: 5px;  width: 100%;  margin-bottom:15px;">
								<fieldset><legend style="font-family: 'Raleway', sans-serif;"><?php echo lang('status');  ?></legend></fieldset>
								<?php $atr = 'class=form-control style="width: 20%;"'; echo form_dropdown('status', $this->config->item('stock_order_statuses'), $order->status,$atr); ?>
							</div>		
					</div>
					<div style="padding: 0px 0px 10px 10px">
						<button class="btn btn-info btn-sm" type="submit" name="submit" value="update"><?php echo lang('update'); ?></button>
					</div>
				</div>
				
					<div style="padding: 0px 0px 10px 10px">
						test
					</div>


</form>

<script>$('.start_exp').datepicker({dateFormat:'yy-mm-dd', altField: '#start_top_alt', altFormat: 'yy-mm-dd'});</script>
<script>$('#ordered_on').datepicker({dateFormat:'yy-mm-dd', altField: '#start_top_alt', altFormat: 'yy-mm-dd'});</script>
<script>$('#arrival_date').datepicker({dateFormat:'yy-mm-dd', altField: '#start_top_1_alt', altFormat: 'yy-mm-dd'});</script>


<?php include('footer.php');