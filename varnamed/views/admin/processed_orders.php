<?php require('header.php'); 

$admin_statuses = array('0'=>'Select status','Processing'=>'Processing','Shipped'=>'Shipped','On_Hold'=>'On Hold','Cancelled'=>'Cancelled','Delivered'=>'Delivered');
$warehouse_statuses = array('0'=>'Select status','Processing'=>'Processing','Shipped'=>'Shipped','On_Hold'=>'On Hold');
$sales_statuses = array('0'=>'Select status','Processing'=>'Processing','On_Hold'=>'On Hold');
$statuses = array('0'=>'Select status');


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
	input { margin: 0px; padding: 1px 5px; }
</style>

			<div class="pull-right">
				<?php echo form_open($this->config->item('admin_folder').'/orders/index', 'class="form-inline" style="float:right"');?>
					<fieldset>
						<input id="start_top"  value="" class="span2" type="text" placeholder="Start Date"/>
						<input id="start_top_alt" type="hidden" name="start_date" />
						<input id="end_top" value="" class="span2" type="text"  placeholder="End Date"/>
						<input id="end_top_alt" type="hidden" name="end_date" />

						<button class="btn btn-xs btn-info" name="submit" value="search"><span class="glyphicon glyphicon-search"></span> <?php echo lang('search')?></button>
						<!--<button class="btn" name="submit" value="export"><?php //echo lang('xml_export')?></button>-->
					</fieldset>
				</form>
			</div>
			
			<br/><br/>

<?php echo form_open($this->config->item('admin_folder').'/orders/bulk_delete', array('id'=>'delete_form', 'onsubmit'=>'return submit_form();', 'class="form-inline"')); ?>

	<div class="panel panel-default" style="width: 100%; float: left;">
		<div class="panel-heading"><?php echo lang('processed_orders'); ?><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
				<div class="panel-body">
					<table class="table table-hover" style="border: 1px solid #ddd;">
					<thead>
						<tr>
							<?php if($this->bitauth->is_admin()): ?>
							<th><button type="submit" class="glyphicon glyphicon-trash" ></button></th>
							<?php endif; ?>
							<th><?php echo sort_url('order', 'order_number', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
							<th><?php echo sort_url('company', 'company', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
							<th><?php echo sort_url('ordered_on','ordered_on', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
										<th><?php echo sort_url('entered_by','entered_by', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
										<th><?php echo sort_url('processed_on','processed_on', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
										<th><?php echo lang('backorder'); ?></th>

										<?php 
											if($this->data_shop == 3){
												?><th>Drop Shipment</th><?php
											}
							?>
						</tr>
					</thead>
					<tbody>
				<?php echo (count($orders) < 1)?'<tr><td style="text-align:center;" colspan="8">'.lang('no_orders') .'</td></tr>':''?>
					<?php if(!empty($orders)):?>
					<?php foreach($orders as $order): ?>
					<?php if($order->order_type !='Fixtermin'): ?>
				<tr>
					<td><input name="order[]" type="checkbox" value="<?php echo $order->id; ?>" class="gc_check"/></td>
					<td><?php echo $order->order_number; ?></td>
					<td><?php echo $order->company; ?></td>
					<td><?php echo date('m/d/y h:i a', strtotime($order->ordered_on)); ?></td>
							<td><?php echo strtoupper(substr($order->entered_by, 0,1)).substr($order->entered_by, 1); ?></td>
							<td><?php echo $order->processed_on; ?></td>
					<?php $backorder_array = array(1=>'BACKORDER',0 => ''); ?>
					<td style="font-size: 11px; color: red; "><?php echo '<strong>'.$backorder_array[$order->BACKORDER].'</strong>'; ?></td>
							<!--
					<td style="span2">
						<?php //echo form_dropdown('status', $this->config->item('order_statuses'), $order->status, 'id="status_form_'.$order->id.'" class="span2" style="float:left;"'); ?>
						<button type="button" class="btn" onClick="save_status(<?php //echo $order->id; ?>)" style="float:left;margin-left:4px;"><?php// echo lang('save');?></button>
					</td>
							-->

							<?php if($this->data_shop == 3){
					?><td>
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
				<?php endif; ?>
				<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>
			</div>
		</div>


	<div class="panel panel-default" style="width: 100%; float: left;">
		<div class="panel-heading"><?php echo lang('orders_fixed_date'); ?><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
				<div class="panel-body">
					<table class="table table-hover" style="border: 1px solid #ddd;">
						
						<thead>
							<tr>
							<?php if($this->bitauth->is_admin()): ?>
								<th><button type="submit" class="glyphicon glyphicon-trash" ></button></th>
								<?php endif; ?>
								<th><?php echo sort_url('order', 'order_number', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
								<th><?php echo sort_url('company', 'company', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
								<th><?php echo sort_url('ordered_on','ordered_on', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
											<th><?php echo sort_url('entered_by','entered_by', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
											<th><?php echo sort_url('processed_on','processed_on', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
							<!--	<th><?php //echo sort_url('status','status', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th> -->
								<th><?php echo sort_url('total','total', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
														<?php 
											if($this->data_shop == 3){
											?><th>Drop Shipment</th><?php
											}
											?>
								<th></th>
							</tr>
						</thead>
						<tbody>

							<?php if(!empty($orders)):?>
						<?php foreach($orders as $order): ?>
							<?php if($order->order_type_date != '0000-00-00' and $order->order_type_date != NULL or $order->order_type =='Fixtermin' ): ?>
						<tr>
							<td><input name="order[]" type="checkbox" value="<?php echo $order->id; ?>" class="gc_check"/></td>
							<td><?php echo $order->order_number; ?></td>
							<td><?php echo $order->company; ?></td>
							<td><?php echo date('m/d/y h:i a', strtotime($order->ordered_on)); ?></td>
									<td><?php echo $order->entered_by; ?></td>
									<td><?php echo $order->processed_on; ?></td>
									<!--
							<td style="span2">
								<?php //echo form_dropdown('status', $this->config->item('order_statuses'), $order->status, 'id="status_form_'.$order->id.'" class="span2" style="float:left;"'); ?>
								<button type="button" class="btn" onClick="save_status(<?php //echo $order->id; ?>)" style="float:left;margin-left:4px;"><?php// echo lang('save');?></button>
							</td>
									-->
							<td><div class="MainTableNotes"><?php echo format_currency($order->total); ?></div></td>
									<?php if($this->data_shop == 3){
							?><td>
							<?php
							if($order->dropshipment == 1){
							echo 'Heeft drop shipment';
							}
							?>
							</td><?php
							}
							?>	
							<td>
								<a class="btn btn-default btn-xs" style="float:right;"href="<?php echo site_url($this->config->item('admin_folder').'/orders/view/'.$order->id);?>"><span class="glyphicon glyphicon-search"></span>  <?php echo lang('form_view')?></a>
							</td>

						</tr>
							<?php endif; ?>
						<?php endforeach; ?>
							<?php endif; ?>
							
						</tbody>
					</div></div>

</table>
</form>
</div>
	
							
								
				

</div>
							
							
					
<button type="submit" class="btn btn-info" onclick="history.go(-1); return false;" >Back<?php //echo lang('form_save');?></button>

<?php include('footer.php'); ?>
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