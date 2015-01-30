<?php include('header.php'); ?>
<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('confirm_delete_address');?>');
}
</script>
<br><a class="btn btn-info" style="float:right;"href="<?php echo site_url($this->config->item('admin_folder').'/customers/address_form/'.$customer->NR);?>"><i class="icon-plus-sign"></i> <?php echo lang('add_new_address');?></a><br><br>
<?php 

//echo $back_location;



?>

	<?php echo form_open($this->config->item('admin_folder').'/customers/set_address/'.$id);?>

	<div class="panel panel-default" style="width: 100%; float: left;">
		<div class="panel-heading">Adresses<span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
			<div class="panel-body">
				<table class="table table-striped">
				<thead>
					<tr>
									<th>Type<?php //echo lang('invoice_address'); ?></th>
									<th><?php echo lang('name');?></th>
									<th><?php echo lang('contact');?></th>
									<th><?php echo lang('address');?></th>
									<th><?php echo lang('locality');?></th>
									<th><?php echo lang('country');?></th>
									<th>Edit</th>
									<th>Delete</th>
					</tr>
				</thead>
			<tbody>
			<?php echo (count($addresses) < 1)?'<tr><td style="text-align:center;" colspan="6">'.lang('no_addresses').'</td></tr>':''?>

		<?php foreach ($addresses as $address): ?>
   
		<tr>
                   
                    <?php
                    
                    if($address['SOORT'] == 1){
                        $invoice_index = true;
                    }
                    else {
                        $invoice_index = false;
                    }

                    if($address['SOORT'] == 2){
                        $delivery_index = true;
                    }
                    else {
                        $delivery_index = false;
                    }              

                    
                    ?>
                    <?php $invoice_address = array(
                            'name'        => 'invoice_address',
                            'id'          => 'invoice_address',
                            'value'       => $address['id'],
                            'checked'     => $invoice_index,
                            'style'       => 'margin:10px',
                            );
                    ?>
                    <?php $delivery_address = array(
                            'name'        => 'delivery_address',
                            'id'          => 'delivery_address',
                            'value'       =>  $address['id'],
                            'checked'     =>  $delivery_index,
                            'style'       => 'margin:10px',
                            );
                    ?>
                        <td>
							<?php   if($address['SOORT'] == 1){ 
										echo 'Invoice address';
									}
							?>
							<?php   if($address['SOORT'] == 2){ 
										echo 'Delivery address';
									}
							?>
						</td>
			<td>
				<?php echo $address['NAAM1']; ?>, <?php echo $address['NAAM2']; ?>, <?php echo $address['NAAM3']; ?>
			</td>


			<td>
				<?php echo (!empty($address['STRAAT']))?'<br/>'.$address['STRAAT']:'';?>
				<?php echo (!empty($address['HUISNR']))?'<br/>'.$address['HUISNR']:'';?>
			</td>
			
			<td>
				<?php echo $address['POSTCODE'];?>,  <?php echo $address['PLAATS'];?> ,  
			</td>
			

			<td><?php echo strtoupper($address['LANDCODE']);?> </td>
			<td><?php echo $address['LAND'];?> </td>
		
							<td style="text-align: center; width: 50px;">
								<a class="glyphicon glyphicon-edit" style="display: inline-block; font-size: 16px;" href="<?php echo site_url($this->config->item('admin_folder').'/customers/address_form/'.$customer->NR.'/'.$address['id']);?>"><?php //echo lang('form_view')?></a>
								</td>
							<td style="text-align: center; width: 50px;">
								<a class="glyphicon glyphicon-trash"  onclick="return areyousure();" style="display: inline-block; font-size: 16px;" href="<?php echo site_url($this->config->item('admin_folder').'/customers/erase_adres/'.$customer->NR.'/'.$address['id']);?>"><?php //echo lang('form_view')?></a>
								</td>
				

		</tr>
<?php endforeach; ?>
	</tbody>
</table>
<br>
</div></div>
</form>
<a class="btn btn-info" href="<?php echo $back_location; ?>">Back</a>

<?php include('footer.php');