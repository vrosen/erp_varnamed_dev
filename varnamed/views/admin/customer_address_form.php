		<?php include('header.php');

		if(empty($country_name)){

		  $country_name	= array('name'=>'country_name','style'=>'width: 70%','type'=> 'text');
		}
		else {
		  $country_name	= array('name'=>'country_name','style'=>'width: 70%','value'=> set_value('country_name',$address->LAND));
		}

		$country_array = array(
			
			""		=>	'Select country', 
			'BEL'	=> 'Belgique / français',
			'BE'	=> 'België / nederlands',
			'DE'	=> 'Deutschland / deutsch',
			'FR'	=> 'France / français',
			'LX'	=> 'Luxembourg / français',
			'NL'	=> 'Nederland / nederlands',
			'UK'	=> 'United Kingdom / english',
			'AT'	=> 'Österreich / deutsch',
		);


	
?>



<script type="text/javascript">	
	<?php
	$add_list = array();
	foreach($customer_addresses as $row) {
		// build a new array
		$add_list[$row['id']] = $row;
	}
	$add_list = json_encode($add_list);
	echo "eval(addresses=$add_list);";
	?>
		
	function populate_address(address_id)
	{
		if(address_id == '')
		{
			return;
		}
		// - populate the fields
		$.each(addresses[address_id], function(key, value){
		//alert(key);
			$('.address[name='+key+']').val(value);
		});
	}
	
</script>

<?php echo form_open($this->config->item('admin_folder').'/customers/address_form/'.$customer_nr.'/'.$id);?>

	<div class="panel panel-default" style="width: 100%; float: left;">
		<div class="panel-heading">Adresses<span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
			<div class="panel-body">
				<table class="table table-striped">
				<tr>
				<th>Choose address<?php //echo lang('company'); ?></th>
					<td><a data-toggle="modal" href="#myModal" class="btn btn-primary btn-sm"><?php echo lang('choose_address');?></a></td>
				</tr>
				<tr>
					<th><?php echo lang('company'); ?></th>
					<td><input type="text" name="NAAM1" class="address" value="<?php echo $NAAM1; ?>" style="width:70%;" required/></td>
				</tr>
				<tr>		
					<th><?php echo lang('firstname'); ?></th>
					<td><input type="text" name="NAAM2" class="address" value="<?php echo $NAAM2; ?>" style="width:70%;" /></td>
				</tr>	
				<tr>	
					<th><?php echo lang('lastname');?></th>
					<td><input type="text" name="NAAM3" class="address" value="<?php echo $NAAM3; ?>" style="width:70%;" /></td>
				</tr>		
				<tr>		
					<th><?php echo lang('email');?></th>
					<td><input type="text" name="email" class="address" value="<?php echo $email; ?>" style="width:70%;" /></td>
				</tr>	
				<tr>	
					<th><?php echo lang('phone');?></th>
					<td><input type="text" name="phone" class="address" value="<?php echo $phone; ?>" style="width:70%;" /></td>
				</tr>	
				<tr>	
					<th><?php echo lang('country');?></th>
						<td>
									<select name="LANDCODE" class="address" required>
										<option value="<?php echo $LANDCODE; ?>"><?php echo $country_array[$LANDCODE]; ?></option>
										<option value="">Select country</option>
										<option value="BEL">Belgique / français</option>
										<option value="BE">België / nederlands</option>
										<option value="DE">Deutschland / deutsch</option>
										<option value="FR">France / français</option>
										<option value="LX">Luxembourg / français</option>
										<option value="NL">Nederland / nederlands</option>
										<option value="UK">United Kingdom / english</option>
										<option value="AT">Österreich / deutsch</option>
									</select>
						</td>
				</tr>	
				<tr>	
					<th>Street<?php //echo lang|('company');?></th>
					<td><input type="text" name="STRAAT" class="address" value="<?php echo $STRAAT; ?>" style="width:70%;" required/><input type="text" name="HUISNR" class="address" value="<?php echo $HUISNR; ?>" style="width:10%;" required/></td>
				</tr>
				<tr>	
					<th><?php echo lang('city');?></th>
					<td><input type="text" name="PLAATS" class="address" value="<?php echo $PLAATS; ?>" style="width:70%;" required/></td>
				</tr>		
				<tr>		
					<th>Postcode<?php //echo lang|('company');?></th>
					<td><input type="text" name="POSTCODE" class="address" value="<?php echo $POSTCODE; ?>" style="width:70%;" required/></td>
				</tr>
				<tr>		
					<th>Type<?php //echo lang|('company');?></th>
					<td>
						<?php	
							$type_array = array(
								''	=> 'Select type',
								1	=> 'Invoice address',
								2	=> 'Delivery address',
								3	=> 'Drop shipment address',
								);
					if($this->session->userdata('shop') == 3){
							?>
								<select name="SOORT"  required>
									<option value="<?php echo $type; ?>"><?php echo $type_array[$type]; ?></option>
									<option value="1">Invoice address</option>
									<option value="2">Delivery address</option>
									<option value="3">Drop shipment address</option>
								</select>
							<?php	
						}else {
							?>
								<select name="SOORT"  required>
									<option value="<?php echo $type; ?>"><?php echo $type_array[$type]; ?></option>
									<option value="1">Invoice address</option>
									<option value="2">Delivery address</option>
								</select>
							<?php	
						}
						?>
					</td>
				</tr>
				</table>
				<br>
				<input class="btn btn-primary" type="submit" value="<?php echo lang('save');?>"/>
				</div>
			</div>
</form>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Modal title</h4>
        </div>
        <div class="modal-body">
		<p>
			<table class="table table-striped">
			<?php
			$c = 1;
			foreach($customer_addresses as $a):?>
				<tr>
					<td>
						<?php
							echo nl2br(format_address_NL($a));
						?>
					</td>
					<td style="width:100px;"><input type="button" class="btn btn-primary choose_address pull-right" onclick="populate_address(<?php echo $a['id'];?>);" data-dismiss="modal" value="<?php echo lang('form_choose');?>" /></td>
				</tr>
			<?php endforeach;?>
			</table>
		</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

<?php include('footer.php');