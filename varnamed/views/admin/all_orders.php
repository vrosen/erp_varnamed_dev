<?php require('header.php'); 

$admin_statuses = array(
    
    '-1'    => 'Select status',
    '0'     => 'Pending',
    '1'     =>'Processing',
    '2'     =>'Ready to ship',
    '3'     =>'Shipped',
    '4'     =>'On Hold',
    '5'     =>'Cancelled',
    '6'     =>'Delivered'
    
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
			

		$return = site_url($admin_folder.'/orders/all_orders/'.$by.'/'.$sort.'/'.$code);
		
		echo '<a href="'.$return.'">'.lang($lang).$icon.'</a>';

	}
	
if ($term):?>


<?php endif;?>

			<div class="span8">
				<?php echo form_open($this->config->item('admin_folder').'/orders/index', 'class="form-inline" style="float:right"');?>
					<fieldset>
						<input id="start_top"  value="" class="span2" type="text" placeholder="Start Date"/>
						<input id="start_top_alt" type="hidden" name="start_date" />
						<input id="end_top" value="" class="span2" type="text"  placeholder="End Date"/>
						<input id="end_top_alt" type="hidden" name="end_date" />



						<button class="btn" name="submit" value="search"><?php echo lang('search')?></button>
						<button class="btn" name="submit" value="export"><?php echo lang('xml_export')?></button>
					</fieldset>
				</form>
			</div>
    <?php echo form_open($this->config->item('admin_folder').'/orders/all_orders', 'class="form-inline" style="float:right"');?>
        <fieldset>
            <?php $js = 'id="status" onChange="this.form.submit();"'; ?>
            <?php echo lang('select_status'); ?>
    <?php
		echo form_dropdown('status',$admin_statuses,$order_status,$js); 
    ?>
        </fieldset>
    </form>



<?php echo form_open($this->config->item('admin_folder').'/orders/bulk_delete', array('id'=>'delete_form', 'onsubmit'=>'return submit_form();', 'class="form-inline"')); ?>

	<div class="panel panel-default" style="width: 100%; float: left;">
		<div class="panel-heading"><?php echo lang('all_orders'); ?><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
				<div class="panel-body">
					<table class="table table-striped table-hover" style="border: 1px solid #ddd;">
						<thead>
									<tr>
											<?php if($this->bitauth->is_admin()): ?>
											<th><button type="submit" class="glyphicon glyphicon-trash" ></button></th>
											<?php endif; ?>
											<th><?php echo sort_url('order', 'order_number', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
											<th><?php echo sort_url('ship_to', 'ship_lastname', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
											<th><?php echo sort_url('ordered_on','ordered_on', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
											<th><?php echo sort_url('entered_by','entered_by', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
											<th><?php echo sort_url('processed_on','processed_on', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
											<th><?php echo sort_url('status','status', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
											<th><?php echo sort_url('total','total', $sort_by, $sort_order, $code, $this->config->item('admin_folder')); ?></th>
											<th></th>
								</tr>
						</thead>
						<tbody>
							<?php echo (count($orders) < 1)?'<tr><td style="text-align:center;" colspan="8">'.lang('select_order_type') .'</td></tr>':''?>
							<?php if(!empty($orders)): ?>
						<?php foreach($orders as $order): ?>
							<tr>
							<?php if($this->bitauth->is_admin()): ?>
									<td><input name="order[]" type="checkbox" value="<?php echo $order->id; ?>" class="gc_check"/></td>
									<?php endif; ?>
									<td><?php echo $order->order_number; ?></td>
									<td><?php echo $order->lastname.''.$order->firstname; ?></td>
									<td><?php echo date('m/d/y h:i a', strtotime($order->ordered_on)); ?></td>
									<td><?php echo $order->entered_by; ?></td>
									<td><?php echo $order->processed_on; ?></td>
									<td>
											<?php echo form_dropdown('status', $this->config->item('all_order_statuses'), $order->status, 'id="status_form_'.$order->id.'"  style="float:left; width: 150px;"'); ?>
											&nbsp;<button  class="glyphicon glyphicon-trash"  onClick="save_status(<?php echo $order->id; ?>)"></button>
											
									</td>

									<td><div class="MainTableNotes"><?php echo format_currency($order->total); ?></div></td>
									<td style="text-align: center; width: 50px;">
									<a class="glyphicon glyphicon-edit" style="display: inline-block; font-size: 16px;" href="<?php echo site_url($this->config->item('admin_folder').'/orders/view/'.$order->id);?>"><?php //echo lang('form_view')?></a>
									</td>
							</tr>
						<?php endforeach; ?>
							<?php endif; ?>
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