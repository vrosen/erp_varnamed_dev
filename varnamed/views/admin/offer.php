<?php include('header.php'); ?>

	<script type="text/javascript">
	function areyousure()
	{
		return confirm('<?php echo 'Are you sure you want to mail this offer?';?>');
	}
	function areyousure_update()
	{
		return confirm('<?php echo 'Are you sure you want to update this offer?';?>');
	}
	</script>
	
	<link href='http://fonts.googleapis.com/css?family=Patua+One' rel='stylesheet' type='text/css'>

	<?php echo form_open($this->config->item('admin_folder').'/offer/update/'.$offer_id); ?>
	<div class="panel panel-default" style="width: 100%; float: left;">
		<div class="panel-heading"><?php echo 'OFR'.$offer_id; ?><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
				<div class="panel-body">
					<table class="table table-striped table-hover" style="border: 1px solid #ddd;">
						<thead>
							<tr>
								<th>Code</th>
								<th>Quantity</th>
								<th>Discount<?php //echo lang('discount'); ?></th>
								<th>New price<?php //echo lang('saleprice'); ?></th>
								<th>Total</th>
								<th>Saleprice</th>
								<?php if($this->bitauth->is_admin()){ ?>
								<th>Warehouse price<?php //echo lang('warehouse_price'); ?></th>
								<?php } ?>
								<th>Description</th>
							</tr>
						</thead>
						<tbody>
							<?php if(!empty($items)): ?>
									<?php foreach ($items as $item):?>
											<tr>	
												<td><input style="width: 100%;" type="text" name="code[]" value="<?php echo str_replace('/','',$item['ARTIKELCOD']); ?>"></td>
												<td><input style="width: 100%;" type="text" name="quantity[]" value="<?php echo $item['REGELNR']; ?>"></td>
												<td><?php echo $this->config->item('currency_symbol'); ?>&nbsp;&nbsp;<input type="text" name="discount[]" value="<?php echo $item['KORTING']; ?>"></td>
												<td><?php echo $this->config->item('currency_symbol'); ?>&nbsp;&nbsp;<input type="text" name="new_price[]" value="<?php echo $item['saleprice']; ?>"></td>
												<td><?php echo format_currency($item['saleprice']*$item['REGELNR']); ?></td>
												<td><?php echo format_currency($item['OSTUKSPRIJ']); ?></td>
												<input type="hidden" value="<?php echo $item['OSTUKSPRIJ']; ?>" name="no_discount_price[]" />
												<?php if($this->bitauth->is_admin()){ ?>
												<td><?php echo format_currency($item['WAREHOUSE']); ?></td>
												<?php } ?>
												<td><input style="width: 100%;" type="text" name="description[]" value="<?php echo $item['description']; ?>"></td>
											</tr>
									<?php endforeach; ?>
							<?php endif; ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan='3'></td><td>
									<?php echo 'Nett'; ?>
								</td>
								<td>
									<?php echo $total_net; ?>
								</td>
							</tr>
							<tr>	
								<td colspan='3'></td><td>
									<?php echo 'VAT'; ?>
								</td>
								<td>
									<?php echo $total_vat; ?>
								</td>
							</tr>	
							<?php if(!empty($special_case)): ?>
									<tr>
										<td colspan='3'></td><td>
											<?php foreach($special_case as $case): ?>
												<?php echo $case; ?>
											<?php endforeach; ?>
										</td>
										<td>
											<?php foreach($special_vat as $svat): ?>
												<?php echo format_currency($svat); ?>
											<?php endforeach; ?>	
										</td>
									</tr>	
							<?php endif; ?>
							<tr>	
								<td colspan='3'></td><td>
									<?php echo 'Gross'; ?>
								</td>
								<td>
									<?php echo $total_gross; ?>
								</td>
							</tr>
						</tfoot>
					</table>
				</div>	
			</div>	
			<button type="submit" style="font-family: 'Patua One', cursive;" onclick="return areyousure_update();" class="btn btn-info" ><?php echo lang('update')?></button>
			<a class="btn btn-info" style="font-family: 'Patua One', cursive;" onclick="return areyousure();" href="<?php echo site_url($this->config->item('admin_folder').'/offer/word/'.$offer_id.'/'.$customer_id);?>">Get in WORD<?php //echo lang('cancel')?></a>
			<a class="btn btn-info" style="font-family: 'Patua One', cursive;" onclick="return areyousure();" href="<?php echo site_url($this->config->item('admin_folder').'/offer/send_mail/'.$offer_id);?>">Send by e-mail<?php //echo lang('cancel')?></a>
	</form>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
<?php include('footer.php'); ?>