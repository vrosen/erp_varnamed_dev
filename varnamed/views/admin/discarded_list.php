<?php require('header.php'); 

$admin_statuses = array('0'=>'Select status','Pending'=>'Pending','Processing'=>'Processing','Shipped'=>'Shipped','On_Hold'=>'On Hold','Cancelled'=>'Cancelled','Delivered'=>'Delivered');
$warehouse_statuses = array('0'=>'Select status','Pending'=>'Pending','Processing'=>'Processing','Shipped'=>'Shipped','On_Hold'=>'On Hold');
$sales_statuses = array('0'=>'Select status','Pending'=>'Pending','Processing'=>'Processing','On_Hold'=>'On Hold');
$statuses = array('0'=>'Select status','Pending'=>'Pending');



$warehouse_place = array(
    
    '0'         => lang('select_place'),
    'vast'      => lang('vast'),
    'buiten'    => lang('buiten'),
);


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
			

		$return = site_url($admin_folder.'/orders/index/'.$by.'/'.$sort.'/'.$code);
		
		echo '<a href="'.$return.'">'.lang($lang).$icon.'</a>';

	}
	
if ($term):?>


<?php endif;?>
<style type="text/css">
	.pagination {
		margin:0px;
		margin-top:-3px;
	}
</style>
<div class="row">
	<div class="pull-left">
		
			<div class="span4">
				<?php echo $this->pagination->create_links();?>	
			</div>
	</div>
</div>
<div class="row">
	<div class="pull-left">
		
				<?php echo form_open($this->config->item('admin_folder').'/stock/warehouse_stock', 'class="form-inline" style="float:right"');?>
					<fieldset>

						<button class="btn btn-warning btn-small" name="submit" value="export"><?php echo lang('xml_export')?></button>
					</fieldset>
				</form>
	</div>
</div>


<table class="table table-condensed">
    <thead>
		<tr>
			<th><?php echo sort_url('product', 'product_code', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
                        <th><?php echo lang('order'); ?></th>
                        <th><?php echo lang('ek'); ?></th>
                        <th><?php echo sort_url('current_quantity','current_quantity', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
			<th><?php echo sort_url('reserved_quantity', 'reserved_quantity', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
                        <th><?php echo sort_url('delivered_quantity', 'delivered_quantity', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
                        <th><?php echo sort_url('warehouse','warehouse', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
			<th><?php echo lang('package_details'); ?></th>
                        <th><?php echo lang('Replacement_value_per_package'); ?></th>
                        <th><?php echo lang('value'); ?></th>
                        <th><?php echo lang('arrival_date'); ?></th>
                        <th><?php echo lang('expiration_date'); ?></th>
                        <th><?php echo lang('batch_number'); ?></th>
                        <th><?php echo sort_url('warehouse_place','warehouse_place', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
                        <th><?php echo lang('description'); ?></th>
                </tr>
	</thead>

    <tbody>
	<?php echo (count($backorder_stock) < 1)?'<tr><td style="text-align:center;" colspan="8">'.lang('no_orders') .'</td></tr>':''?>
        <?php if(!empty($backorder_stock)):?>
    <?php foreach($backorder_stock as $stock): ?>
	<tr>
		<td><?php echo $stock->product_code; ?></td>
                <td><?php echo $stock->stock_order_number; ?></td>
                <td><?php echo $stock->ek; ?></td>
                <td><?php echo $stock->current_quantity; ?></td>
                <td><?php echo $stock->reserved_quantity; ?></td>
                <td><?php echo $stock->delivered_quantity; ?></td>
		<td><?php echo $stock->warehouse; ?></td>
                <td><?php echo $stock->package_details; ?></td>
                <td></td>
                <td><?php echo $stock->price; ?></td>
                <td><input type="date" value="<?php echo $stock->reception_date; ?>" class="span2" name="reception_date"></td>
                <td><input type="date" value="<?php echo $stock->expiration_date; ?>" class="span2" name="expiration_date"></td>
                <td><input type="date" value="<?php echo $stock->batch_number; ?>" class="span2" name="batch_number"></td>
                <td><input type="date" value="<?php echo $stock->warehouse_place; ?>" class="span1" name="warehouse_place"></td>
                <td><?php echo $stock->description; ?></td>
	</tr>
    <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>


    
    




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
function save_products(id)
{
	show_animation();
	$.post("<?php echo site_url($this->config->item('admin_folder').'/stock/move'); ?>", { id: id, status: $('#status_form_'+id).val() }, 
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