<?php require('header.php'); 

$admin_statuses = array('0'=>'Select status','Pending'=>'Pending','Processing'=>'Processing','Shipped'=>'Shipped','On_Hold'=>'On Hold','Cancelled'=>'Cancelled','Delivered'=>'Delivered');
$warehouse_statuses = array('0'=>'Select status','Pending'=>'Pending','Processing'=>'Processing','Shipped'=>'Shipped','On_Hold'=>'On Hold');
$sales_statuses = array('0'=>'Select status','Pending'=>'Pending','Processing'=>'Processing','On_Hold'=>'On Hold');
$statuses = array('0'=>'Select status','Pending'=>'Pending');


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
			

		$return = site_url($admin_folder.'/stock/index/'.$by.'/'.$sort.'/'.$code);
		
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
</style>

<?php echo form_open($this->config->item('admin_folder').'/stock/bulk_delete', array('id'=>'delete_form', 'onsubmit'=>'return submit_form();', 'class="form-inline"')); ?>
<br>
	<div class="panel panel-default" style="width: 100%; float: left;">
		<div class="panel-heading">Latest Orders<span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
				<div class="panel-body">
					<table class="table table-striped table-hover" style="border: 1px solid #ddd;">
						<thead>
							<tr>
							<?php if($this->bitauth->is_admin()): ?>
										<th><button type="submit" class="glyphicon glyphicon-trash" ></button></th>
										<?php endif; ?>
								<th><?php echo sort_url('order', 'order_number', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
											<th><?php echo sort_url('ordered_on','ordered_on', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
								<th><?php echo sort_url('supplier_name', 'supplier_id', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
											<th><?php echo sort_url('arrival_date','arrival_date', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>

								<th>View</th>
								<th>Check</th>
							</tr>
						</thead>

						<tbody>
						<?php echo (count($orders) < 1)?'<tr><td style="text-align:center;" colspan="8">'.lang('no_orders') .'</td></tr>':''?>
						<?php foreach($orders as $order): ?>
						<tr>
						<?php if($this->bitauth->is_admin()): ?>
							<td><input name="order[]" type="checkbox" value="<?php echo $order->id; ?>" class="gc_check"/></td>
							<?php endif;  ?>
							<td><?php echo $order->order_number; ?></td>
									<td style="white-space:nowrap"><?php echo $order->ordered_on; ?></td>
							<td style="white-space:nowrap"><?php echo $suppliers[$order->supplier_id]['company']; ?></td>
									<td style="white-space:nowrap"><?php echo $order->expected_delivery_date_; ?></td>  
								<td style="text-align: center; width: 50px;">
									<a class="glyphicon glyphicon-edit" style="display: inline-block; font-size: 16px;" href="<?php echo site_url($this->config->item('admin_folder').'/stock/view/'.$order->id);?>"><?php //echo lang('form_view')?></a>
								</td>	
								<td style="text-align: center; width: 50px;">
									<a class="glyphicon glyphicon-ok-sign" style="display: inline-block; font-size: 16px;" href="<?php echo site_url($this->config->item('admin_folder').'/stock/checkout/'.$order->id);?>"><?php //echo lang('form_view')?></a>
								</td>									
		
						</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
					</div></div>

</form>
<div class="row">
	<div class="span12" style="border-bottom:1px solid #f5f5f5;">
		<div class="row">
			<div class="span4">
				<?php echo $this->pagination->create_links();?>	
			</div>
            </div>
	</div>
</div>

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
	$('#start_top').datepicker({dateFormat:'mm-dd-yy', altField: '#start_top_alt', altFormat: 'yy-mm-dd'});
	$('#start_bottom').datepicker({dateFormat:'mm-dd-yy', altField: '#start_bottom_alt', altFormat: 'yy-mm-dd'});
	$('#end_top').datepicker({dateFormat:'mm-dd-yy', altField: '#end_top_alt', altFormat: 'yy-mm-dd'});
	$('#end_bottom').datepicker({dateFormat:'mm-dd-yy', altField: '#end_bottom_alt', altFormat: 'yy-mm-dd'});
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