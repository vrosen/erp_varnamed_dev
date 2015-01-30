
<?php include('header.php'); ?>

<?php 

   $payment_method_array = array(

	'0'		=> '',
    '1'     => lang('invoice_upon_delivery'),
    '2'              => lang('direct_debit'),
    '3'           => lang('paid_in_advance'),
    '4'                     => lang('iDEAL'),
    '6'          => lang('American_Express'),
    '7'                => lang('MasterCard'),
    '8'                      => lang('VISA'),
    '9'     => lang('instant_wire_transfer'),
    '10'                   => lang('Giropay'),
    '11'                       => lang('EPS'),
    '12'                    => lang('PAYPAL'),
    '5'      => lang('free_sample_delivery'),
    '13'  => lang('comforties_com_BV_account'),//set the shop variable
    '14'                 => lang('by_cheque'), 
); 


	$priod_array = array(

				"13" => 'Hele jaar',
				"01" => 'Januari',
				"02" => 'Februari',
				"03" => 'Maart',
				"04" => 'April',
				"05" => 'Mai',
				"06" => 'Juni',
				"07" => 'Juli',
				"08" => 'Augustus',
				"09" => 'September',
				"10" => 'Oktober',
				"11" => 'November',
				"12" => 'December',
	);




?>

				<?php echo form_open($this->config->item('admin_folder').'/overview/web_orders');?>

				<?php $js = 'id="agent" onChange="this.form.submit();"'; ?>
	
				<?php echo form_fieldset('Selecteer periode')?>
			
				<?php 
					if(!empty($period)){
						echo form_dropdown('period', $priod_array, $period,$js);
					}
					else {
						echo form_dropdown('period', $priod_array, date('m'),$js);
					}
				 ?>
				
				</form>

<div class="btn-group pull-right">
	<a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/customers/export_xml');?>"><i class="icon-download"></i> <?php echo lang('xml_download');?></a>
	<a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/customers/get_subscriber_list');?>"><i class="icon-download"></i> <?php echo lang('subscriber_download');?></a>
	<a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/customers/form'); ?>"><i class="icon-plus-sign"></i> <?php echo lang('add_new_customer');?></a>
</div>


<table class="table table-striped">
	<thead>
		<tr>
					<th><?php echo lang('order_nr'); ?></th>
					<th>Klant<?php //echo lang('order_nr'); ?></th>
					<th>Datum<?php //echo lang('order_nr'); ?></th>
					<th>Land<?php //echo lang('order_nr'); ?></th>
					<th>Betaalmethode<?php //echo lang('order_nr'); ?></th>
					<th>Totaal<?php //echo lang('order_nr'); ?></th>


		</tr>
	</thead>
	
	<tbody>


		<?php echo (count($web_orders) < 1)?'<tr><td style="text-align:center;" colspan="5">'.lang('no_customers').'</td></tr>':''?>
                <?php foreach ($web_orders as $web_order):?>
		<tr>
                        <td><?php echo $web_order->order_number; ?></td>
                        <td><?php echo str_replace('?','Ö',$web_order->company); ?></td>
                        <td><?php echo $web_order->ordered_on; ?></td>
                        <td><?php echo str_replace('?','Ö',$web_order->country); ?></td>
                        <td><?php echo $payment_method_array[$web_order->payment_method]; ?></td>
                        <td><?php echo $this->config->item('currency_symbol').' '.$web_order->total; ?></td>
		</tr>
<?php endforeach; ?>
	</tbody>
</table>

<?php include('footer.php'); ?>






















