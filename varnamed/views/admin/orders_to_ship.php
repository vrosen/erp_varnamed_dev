<?php require('header.php'); 

$admin_statuses = array('0'=>'Select status','Processing'=>'Processing','Shipped'=>'Shipped','On_Hold'=>'On Hold','Cancelled'=>'Cancelled','Delivered'=>'Delivered');
$warehouse_statuses = array('0'=>'Select status','Processing'=>'Processing','Shipped'=>'Shipped','On_Hold'=>'On Hold');
$sales_statuses = array('0'=>'Select status','Processing'=>'Processing','On_Hold'=>'On Hold');
$statuses = array('0'=>'Select status');

$warehouse1 = array('2'=>'Transoflex(Frechen)','3'=>'Comforties(Delft)');
$warehouse2 = array('2'=>'Transoflex(Frechen)','3'=>'Dutchblue(Delft)');

$empty_address = $this->session->flashdata('empty_address');
if(!empty($empty_address)){
echo $empty_address;
}

$missing_address = $this->session->flashdata('missing_address');
if(!empty($missing_address)){
echo $missing_address;
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
				$icon	= ' <i class="icon-chevron-up"></i>';
			}
			else
			{
				$sort	= 'asc';
				$icon	= ' <i class="icon-chevron-down"></i>';
			}
		}
		else
		{
			$sort	= 'asc';
			$icon	= '';
		}
			

		$return = site_url($admin_folder.'/orders/processed_orders/'.$by.'/'.$sort.'/'.$code);
		
		echo '<a href="'.$return.'">'.lang($lang).$icon.'</a>';

	}
	
?>


<style type="text/css">
	.pagination {
		margin:0px;
		margin-top:-3px;
	}
</style>

<br>
<?php echo form_open($this->config->item('admin_folder').'/orders/ship_order', array('id'=>'delete_form', 'onsubmit'=>'return submit_form();', 'class="form-inline"')); ?>

	<div class="panel panel-default" style="width: 100%; float: left;">
		<div class="panel-heading"><?php echo lang('orders_fixed_date'); ?><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
				<div class="panel-body">
					<table class="table table-striped" style="border: 1px solid #ddd;">
						<thead>
							<tr>
								<th><button type="submit" class="glyphicon glyphicon-globe" ></button></th>
								<th style="font-size: 11px; white-space:nowrap"><?php echo lang('order_number'); ?></th>
								<th style="font-size: 11px; white-space:nowrap"><?php echo sort_url('company', 'company', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
								<th style="font-size: 11px; white-space:nowrap"><?php echo sort_url('country', 'country_id', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
								<th style="font-size: 11px; white-space:nowrap"><?php echo sort_url('warehouse','warehouse', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
								<th style="font-size: 11px; white-space:nowrap"><?php echo sort_url('forwarder','carrier', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
								<th style="font-size: 11px; white-space:nowrap"><?php echo sort_url('picking_agent','picking_agent', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
								<th style="font-size: 11px; white-space:nowrap"><?php echo sort_url('monitored_by','monitored_by', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
								<th style="font-size: 11px; white-space:nowrap">Label number</th>
								<th style="font-size: 11px; white-space:nowrap"><?php echo sort_url('delivery_date','ordered_on', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
								<th style="font-size: 11px; white-space:nowrap">Backorder</th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						<?php echo (count($orders) < 1)?'<tr><td style="text-align:center;" colspan="8">'.lang('no_orders') .'</td></tr>':''?>
						<?php foreach($orders as $order): ?>
						<?php 
						if($order->printed == 1){
							?><tr style="color: blue;"><?php
						}else {
							?><tr><?php
						}
						?>
						
							<td><input name="orders[]" type="checkbox" value="<?php echo $order->id; ?>" class="gc_check"/></td>
							<td style="font-size: 12px; white-space: nowrap"><?php echo $order->order_number; ?></td>
							<td style="font-size: 11px; white-space: nowrap"><?php echo $order->company; ?></td>
							<td style="font-size: 11px; white-space: nowrap"><?php echo $order->country_id; ?></td>
									<td style="font-size: 11px; white-space: nowrap">
									<?php 
									if($current_shop == '1'){
										
										if($order->warehouse == 1 or $order->warehouse == 3){
											 echo  'Combiwerk(Delft)';
										}
										if($order->warehouse == 0 or $order->warehouse == 2){
											 echo  'Transoflex(Frechen)';
										}
									}
									if($current_shop == '2'){
										
										if($order->warehouse == 1 or $order->warehouse == 3){
											echo  'Dutchblue(Delft)';
										}
										if($order->warehouse == 0 or $order->warehouse == 2){
										   echo  'Transoflex(Delft)';
										} 
									}
									if($this->data_shop == 3){ 
									 echo  'Glovers(Delft)';
									 
									 }
									 
									?>
									</td>
									<td style="font-size:12px;"><?php echo $order->carrier; ?></td>
									<td style="font-size:12px;"><input type="text" name="picking_agent" style="width:24px; height: 13px;"></td>
									<td style="font-size:12px;"><input type="text" name="monitored_by" style="width:24px; height: 13px;"></td>
									<td style="font-size:12px;"><input type="text" name="label_number" style="width:24px; height: 13px;"></td>
							<td style="font-size:12px;"><?php echo $order->ordered_on; ?></td>
									<?php
									if($order->BACKORDER == 1 ){
										if(!empty($verzendung[$order->order_number])){
											
											?><td style="font-size:12px; color: red"><?php echo $verzendung[$order->order_number][0]; ?></td><?php
											
										} 
										else {
											?><td style="font-size:12px; color: red">Backorder</td><?php
										}
										
									}
									else {
										?><td></td><?php
									}
									 
									?>
							<td style="text-align: center; width: 50px;">
										<a class="glyphicon glyphicon-edit" style="display: inline-block; font-size: 16px;" href="<?php echo site_url($this->config->item('admin_folder').'/orders/view/'.$order->id);?>"><?php //echo lang('form_view')?></a>
							</td>	
							<?php if($order->status == '2'): ?>
							<td style="text-align: center; width: 50px;">
							
										<a class="glyphicon glyphicon-list-alt" style="display: inline-block; font-size: 16px;" href="<?php echo site_url('admin/orders/print_label/'.$order->id);?>"><?php //echo lang('print_label');?></a>
							</td>
							
							<td style="text-align: center; width: 50px;">
										<a  class="glyphicon glyphicon-file" style="display: inline-block; font-size: 16px;" href="<?php echo site_url('admin/orders/packing_slip/'.$order->id);?>" target="_blank"><?php //echo lang('packing_slip');?></a>
									 </td>
									 <?php endif; ?>
						</tr>
						<?php endforeach; ?>
						</tbody>
</table>
	</div>
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
		return confirm('<?php echo lang('confirm_ship_order') ?>');
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