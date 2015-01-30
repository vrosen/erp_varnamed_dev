<?php require('header.php'); 

$admin_statuses = array('0'=>'Select status','Pending'=>'Pending','Processing'=>'Processing','Shipped'=>'Shipped','On_Hold'=>'On Hold','Cancelled'=>'Cancelled','Delivered'=>'Delivered');
$warehouse_statuses = array('0'=>'Select status','Pending'=>'Pending','Processing'=>'Processing','Shipped'=>'Shipped','On_Hold'=>'On Hold');
$sales_statuses = array('0'=>'Select status','Pending'=>'Pending','Processing'=>'Processing','On_Hold'=>'On Hold');
$statuses = array('0'=>'Select status','Pending'=>'Pending');

if($current_shop == 1){
   $payment_method_array = array(

    '0'                         => lang('select_payment_method'),
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
}
if($current_shop == 2){
    $payment_method_array = array(

    '0'                         => lang('select_payment_method'),
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
    '13'  => lang('dutchblue_com_BV_account'),//set the shop variable
    '14'                 => lang('by_cheque'), 
);
}
if($current_shop == 3){
    $payment_method_array = array(

    '0'                         => lang('select_payment_method'),
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
    '13'  => lang('dutchblue_com_BV_account'),//set the shop variable
    '14'                 => lang('by_cheque'), 
);
}
	//set "code" for searches
	if(!$code)
	{
		$code = '';
	}
	else
	{
		$code = '/'.$code;
	}
	function sort_url($lang, $by, $sort, $sorder, $code, $admin_folder)
	{
		if ($sort == $by)
		{
			if ($sorder == 'asc')
			{
				$sort	= 'desc';
				$icon	= ' <span class="glyphicon glyphicon-chevron-down"></span>';
			}
			else
			{
				$sort	= 'asc';
				$icon	= ' <span class="glyphicon glyphicon-chevron-up"></span>';
			}
		}
		else
		{
			$sort	= 'asc';
			$icon	= '';
		}
			

		$return = site_url($admin_folder.'/orders/index/'.$by.'/'.$sort.'/'.$code);
		
		echo '<a href="'.$return.'">'.$icon.' '.lang($lang).'</a>';

	}
	
if ($term):?>

<div class="alert alert-info">
	<?php echo sprintf(lang('search_returned'), intval($total));?>
</div>
<?php endif;?>

<style type="text/css">
	.pagination {
		margin:0px;
		margin-top:-3px;
	}
</style>

<script type="text/javascript">
 
 /*   $(document).ready(function () {
	 
	 var checked = $("input[type=checkbox]:checked").length;
	 
	if (checked == 0) {
	
	$("input[type=checkbox]").parents('tr').children('td').css("background-color", "#fff");
	
	}
	
	if (checked == 1) { 
	
	$("input[type=checkbox]").parents('tr').children('td').css("background-color", "blue"); 
	
	}
	
	});*/
	
</script>

	<div class="span12" style="border-bottom:1px solid #f5f5f5; float: left;">
		<div class="row">
                    <?php if(count($orders) < 1): ?>
			<div class="span4">
				<?php echo $this->pagination->create_links();?>	
			</div>
                    <?php  endif; ?>
		</div>
	</div>


<?php echo form_open($this->config->item('admin_folder').'/orders/bulk_delete', array('id'=>'delete_form', 'onsubmit'=>'return submit_form();', 'class="form-inline"')); ?>

	<div class="panel panel-default" style="width: 100%; float: left;">
		<div class="panel-heading">Latest Orders<span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
				<div class="panel-body">
					<table class="table table-striped table-hover" style="border: 1px solid #ddd;">
						<thead>
							<tr>
								<th><button type="submit" class="glyphicon glyphicon-trash" ></button></th>

								<th><?php echo sort_url('order', 'order_number', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
								<th><?php echo sort_url('company', 'company', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
								<th><?php echo sort_url('country', 'country_id', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
								<th><?php echo sort_url('entered_by','entered_by', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
								<th><?php echo lang('payment_method'); ?></th>
								<th>Backorder<?php //echo lang('payment_method'); ?></th>
								<th><?php echo sort_url('ordered_on','ordered_on', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
								<?php 
												if($this->data_shop == 3){
													?><th>Drop Shipment</th><?php
												}
								?>
							</tr>
						</thead>
						<tbody>
						<?php echo (count($orders) < 1)?'<tr><td style="text-align:center;" colspan="8">'.lang('no_orders') .'</td></tr>':''?>
						<?php foreach($orders as $order): ?>
						<tr>
							<td><input name="order[]" type="checkbox" value="<?php echo $order->id; ?>" class="gc_check"/></td>
							<td style="font-size: 11px;"><?php echo $order->order_number; ?></td>
							<td style="font-size: 11px;"><?php echo $order->company; ?></td>
									<td style="font-size: 11px;"><?php echo strtoupper($order->country_id); ?></td>
									<td style="font-size: 11px;">
										<?php 
										if($order->WEBSHOP == 1){
											echo 'WEB';
										}
										else {
											echo '<strong>'.$order->entered_by.'</strong>'; 
										}
										?>
									</td>
									<td style="font-size: 11px;">
										<?php 
										if(!empty($order->payment_method)){
											echo $payment_method_array[$order->payment_method];
										}
										if($this->data_shop == 3){
											echo 'Met factuur ';
										}
										?>
									</td>
							<?php $backorder_array = array(1=>'BACKORDER',0 => ''); ?>
							<td style="font-size: 11px; color: red; ">
									<?php 
									if(empty($order->BACKORDER)){
										$order->BACKORDER = 0;
									}
									echo '<strong>'.$backorder_array[$order->BACKORDER].'</strong>'; ?>
									<?php
									if($order->BACKORDER == 1 ){
										if(!empty($verzendung[$order->order_number])){
											echo $verzendung[$order->order_number][0];
										} 
									}
									?>
									</td>
									
							<td style="font-size: 11px;"><?php echo $order->ordered_on; ?></td>
							<?php if($this->data_shop == 3){
							?>
							<td>
							<?php
							if($order->dropshipment == 1){
							echo 'Heeft drop shipment';
							}
							?>
							</td><?php
							}
							?>			
							<td style="text-align: center; width: 50px;">
								<a class="glyphicon glyphicon-edit" style="display: inline-block; font-size: 16px;" href="<?php echo site_url($this->config->item('admin_folder').'/orders/view/'.$order->id);?>"><?php //echo lang('form_view')?></a>
								</td>
						</tr>
						<?php endforeach; ?>
						</tbody>
			</table>
			</div>
		</div>


	</form>

	
	<script type="text/javascript">
	$(document).ready(function(){
		$('#gc_check_all').click(function(){
			if(this.checked)
			{
				$('.gc_check').attr('checked', 'checked');
			}
			else
			{
				 $(".gc_check").removeAttr("checked"); 
			}
		});
		
		// set the datepickers individually to specify the alt fields
		$('#start_top').datepicker({dateFormat:'yy-mm-dd', altField: '#start_top_alt', altFormat: 'yy-mm-dd'});
		$('#start_bottom').datepicker({dateFormat:'yy-mm-dd', altField: '#start_bottom_alt', altFormat: 'yy-mm-dd'});
		$('#end_top').datepicker({dateFormat:'yy-mm-dd', altField: '#end_top_alt', altFormat: 'yy-mm-dd'});
		$('#end_bottom').datepicker({dateFormat:'yy-mm-dd', altField: '#end_bottom_alt', altFormat: 'yy-mm-dd'});
	});

	function do_search(val)
	{
		$('#search_term').val($('#'+val).val());
		$('#start_date').val($('#start_'+val+'_alt').val());
		$('#end_date').val($('#end_'+val+'_alt').val());
		$('#search_form').submit();
	}

	function do_export(val)
	{
		$('#export_search_term').val($('#'+val).val());
		$('#export_start_date').val($('#start_'+val+'_alt').val());
		$('#export_end_date').val($('#end_'+val+'_alt').val());
		$('#export_form').submit();
	}

	function submit_form()
	{
		if($(".gc_check:checked").length > 0)
		{
			return confirm('<?php echo lang('confirm_delete_order') ?>');
		}
		else
		{
			alert('<?php echo lang('error_no_orders_selected') ?>');
			return false;
		}
	}

	function save_status(id)
	{
		show_animation();
		$.post("<?php echo site_url($this->config->item('admin_folder').'/orders/edit_status'); ?>", { id: id, status: $('#status_form_'+id).val() }, 
			function(data){
			setTimeout('hide_animation()', 500);
		}
		);
	}

	function show_animation()
	{
		$('#saving_container').css('display', 'block');
		$('#saving').css('opacity', '.8');
	}

	function hide_animation()
	{
		$('#saving_container').fadeOut();
	}

	</script>

<div id="saving_container" style="display:none;">
	<div id="saving" style="background-color:#000; position:fixed; width:100%; height:100%; top:0px; left:0px;z-index:100000"></div>
	<img id="saving_animation" src="<?php echo base_url('assets/img/storing_animation.gif');?>" alt="saving" style="z-index:100001; margin-left:-32px; margin-top:-32px; position:fixed; left:50%; top:50%"/>
	<div id="saving_text" style="text-align:center; width:100%; position:fixed; left:0px; top:50%; margin-top:40px; color:#fff; z-index:100001"><?php echo lang('saving');?></div>
</div>
<?php include('footer.php'); ?>
