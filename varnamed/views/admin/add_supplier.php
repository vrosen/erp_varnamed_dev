<?php include('header.php'); ?>

<?php echo form_open($this->config->item('admin_folder').'/suppliers/add_supplier'); ?>
	<div class="panel panel-default" style="width: 52%; float: left;">
		<div class="panel-heading">Latest Orders<span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
				<div class="panel-body">
					<table class="table table-striped" style="border: 1px solid #ddd;">
						<tr>
							<td style="width: 20%;"><?php echo lang('number');?></td>
							<td>
								<?php
									$data	= array('name'=>'number','id'=>'number','style'=>'width: 98%; background: whitesmoke;');
									echo form_input($data); 
								?>
							</td>
						</tr>
						<tr>
							<td><?php echo lang('company');?></td>
							<td>
								<?php
									$data	= array('name'=>'company','name'=>'company','style'=>'width: 98%; background: whitesmoke;');
									echo form_input($data);
								?>
							</td>
						</tr>
						<tr>
							<td><?php echo lang('contact_person');?></td>
							<td>
								<?php
									$data	= array('name'=>'contact_person','id'=>'contact_person','style'=>'width: 98%; background: whitesmoke;');
									echo form_input($data); 
								?>
							</td>
						</tr>
						<tr>
							<td><?php echo lang('phone');?></td>
							<td>
								<?php
									$data	= array('name'=>'phone','id'=>'phone','style'=>'width: 98%; background: whitesmoke;');
									echo form_input($data);
								?>
							</td>
						</tr>
						<tr>
							<td><?php echo lang('fax');?></td>
							<td>
								<?php
									$data	= array('name'=>'fax','id'=>'fax','style'=>'width: 98%; background: whitesmoke;');
									echo form_input($data); 
								?>
							</td>
						</tr>
						<tr>
							<td><?php echo lang('email');?></td>
							<td>
								<?php
									$data	= array('name'=>'email','id'=>'email','style'=>'width: 98%; background: whitesmoke;');
									echo form_input($data); 
								?>
							</td>
						</tr>						
						<tr>
							<td><?php echo lang('web');?></td>
							<td>
								<?php
									$data	= array('name'=>'web','id'=>'web','style'=>'width: 98%; background: whitesmoke;');
									echo form_input($data); 
								?>
							</td>
						</tr>						
						<tr>
							<td><?php echo lang('cust_tariff');?></td>
							<td>
								<?php
									$data	= array('name'=>'cust_tariff','id'=>'cust_tariff','style'=>'width: 98%; background: whitesmoke;');
									echo form_input($data); 
								?>
							</td>
						</tr>						
						<tr>
							<td><?php echo lang('account_number');?></td>
							<td>
								<?php
									$data	= array('name'=>'account_number','id'=>'account_number','style'=>'width: 98%; background: whitesmoke;');
									echo form_input($data);
								?>
							</td>
						</tr>						
						<tr>
							<td><?php echo lang('account_owner');?></td>
							<td>
								<?php
									$data	= array('name'=>'account_owner','id'=>'account_owner','style'=>'width: 98%; background: whitesmoke;');
									echo form_input($data); 
								?>
							</td>
						</tr>						
						<tr>
							<td><?php echo lang('bank_number');?></td>
							<td>
								<?php
									$data	= array('name'=>'bank_number','id'=>'bank_number','style'=>'width: 98%; background: whitesmoke;');
									echo form_input($data); 
								?>
							</td>
						</tr>						
						<tr>
							<td><?php echo lang('bank_name');?></td>
							<td>
								<?php
									$data	= array('name'=>'bank_name','id'=>'bank_name','style'=>'width: 98%; background: whitesmoke;');
									echo form_input($data);
								?>
							</td>
						</tr>						
						<tr>
							<td><?php echo lang('supplier_info');?></td>
							<td>
								<?php
									$data	= array('name'=>'supplier_info','id'=>'supplier_info','style'=>'width: 98%; background: whitesmoke;');
									echo form_textarea($data);
								?>
							</td>
						</tr>
					</table>
<br>					
						<input class="btn btn-info" type="submit" value="<?php echo lang('save');?>"/>

</form>
</div>
</div>
<?php include('footer.php');