<?php require('header.php'); 

$admin_statuses = array('0'=>'Select status','Pending'=>'Pending','Processing'=>'Processing','Shipped'=>'Shipped','On_Hold'=>'On Hold','Cancelled'=>'Cancelled','Delivered'=>'Delivered');
$warehouse_statuses = array('0'=>'Select status','Pending'=>'Pending','Processing'=>'Processing','Shipped'=>'Shipped','On_Hold'=>'On Hold');
$sales_statuses = array('0'=>'Select status','Pending'=>'Pending','Processing'=>'Processing','On_Hold'=>'On Hold');
$statuses = array('0'=>'Select status','Pending'=>'Pending');

$reason = array(
    
    '0'                     => lang('select_reason'),
    'stocktaking'           => lang('stocktaking'),
    'defective'             => lang('defective'),
    'expired'               => lang('expired'),
    'passedexam'            => lang('passedexam'),
    'correction'            => lang('correction'),
    'transfer'              => lang('transfer'),
    'sending'               => lang('sending'),
    'sample_consumption'    => lang('sample_consumption'),
    
    
);

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
	<div class="pull-right">
		
			<div class="span4">
				<?php echo $this->pagination->create_links();?>	
			</div>
	</div>
</div>
<div class="row">
	<div class="pull-right">
		
				<?php echo form_open($this->config->item('admin_folder').'/stock/backorder', 'class="form-inline" style="float:right"');?>
					<fieldset>
						<input id="top" type="text" class="span2" name="term" placeholder="<?php echo lang('term')?>" /> 
						<button class="btn" name="submit" value="search"><?php echo lang('search')?></button>
						<button class="btn" name="submit" value="export"><?php echo lang('excel_export')?></button>
					</fieldset>
				</form>
	</div>
</div>

<?php echo form_open($this->config->item('admin_folder').'/stock/send_backorder', 'class="form-inline" style="float:right"');?>
<table class="table table-striped">
    <thead>
		<tr>
			<th><?php echo lang('product'); ?></th>
                        <th><?php echo lang('order'); ?></th>
                        <th><?php echo lang('ek'); ?></th>
                        <th><?php echo sort_url('current_quantity','current_quantity', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
                        <td><?php echo lang('write_off'); ?></td>
                        <th><?php echo lang('arrival_date'); ?></th>
                        <th><?php echo lang('expiration_date'); ?></th>
                        <th><?php echo lang('batch_number'); ?></th>
                        <th><?php echo sort_url('warehouse','warehouse', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
                        <th><?php echo lang('customer_order'); ?></th>
                        <th><?php echo lang('reason'); ?></th>
                        <th><?php echo lang('remarks'); ?></th>
                </tr>
	</thead>

    <tbody>
    <?php if(!empty($orders)): ?>
    <?php foreach($orders as $order): ?>
	<tr>
            <td><?php echo $order->product_code; ?><input type="hidden" name="product_code[]" value="<?php echo $order->product_code; ?>"></td>
                <td><?php echo $order->stock_order_number; ?><input type="hidden" name="stock_order_number[]" value="<?php echo $order->stock_order_number; ?>"></td>
                <td><?php echo $order->ek; ?><input type="hidden" name="ek[]" value="<?php echo $order->ek; ?>"></td>
                <td><?php echo $order->current_quantity; ?></td>
                <td><input type="text" name="backorder_quantity[]" class="span1"></td>
                <td><?php echo $order->reception_date; ?><input type="hidden" value="<?php echo $order->reception_date; ?>" name="reception_date[]"></td>
                <td><?php echo $order->expiration_date; ?><input type="hidden" value="<?php echo $order->expiration_date; ?>"  name="expiration_date[]"></td>
                <td><?php echo $order->batch_number; ?><input type="hidden" value="<?php echo $order->batch_number; ?>"  name="batch_number[]"></td>
                <td><?php echo $order->warehouse_place; ?><inpyt type="hidden" name="warehouse_place" value="<?php echo $order->warehouse_place ?>"></td>
                <td><input type="text" name="customer_order[]" class="span2"></td>
                <td><?php echo form_dropdown('reason[]',$reason,'0'); ?></td>
                <td><?php echo form_textarea(array('rows' => 1,'name' => 'remarks[]')); ?></td>
	</tr>
    <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
<button class="btn" name="submit" value="export"><?php echo lang('save')?></button>
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