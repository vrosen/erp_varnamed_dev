<?php require('header.php'); 

            if($current_shop == 1){
               $payment_method_array = array(

                '0'    	=> lang('select_payment_method'),
                '1'     => lang('invoice_upon_delivery'),
                '2'		=> lang('direct_debit'),
                '3'     => lang('paid_in_advance'),
                '4'     => lang('iDEAL'),
                '6'     => lang('American_Express'),
                '7'     => lang('MasterCard'),
                '8'     => lang('VISA'),
                '9'     => lang('instant_wire_transfer'),
                '10'    => lang('Giropay'),
                '11'    => lang('EPS'),
                '12'    => lang('PAYPAL'),
                '5'     => lang('free_sample_delivery'),
                '13'  	=> lang('comforties_com_BV_account'),//set the shop variable
                '14'    => lang('by_cheque'), 
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




	//set "code" for searches
	if(!$code)
	{
		$code = '';
	}
	else
	{
		$code = '/'.$code;
	}
	function sort_url($lang, $by, $sort, $sinvoice, $code, $admin_folder) {

		if ($sort == $by){
			if ($sinvoice == 'asc') {
				$sort	= 'desc';
				$icon	= ' <i class="icon-chevron-up"></i>';
			}
			else {
				$sort	= 'asc';
				$icon	= ' <i class="icon-chevron-down"></i>';
			}
		}
		else {
			$sort	= 'asc';
			$icon	= '';
		}
			
		$return = site_url($admin_folder.'/invoices/index/'.$by.'/'.$sort.'/'.$code);
		echo '<a href="'.$return.'">'.lang($lang).$icon.'</a>';
	}
	
	?>
	
	
	
	




			<div class="span8">
				<?php echo form_open($this->config->item('admin_folder').'/invoices/index', 'class="form-inline" style="float:right"');?>
					<fieldset>
						<input type="text" class="span2" name="term" placeholder="<?php echo lang('search_customers');?>" /> 
						<button class="btn" name="submit" value="search"><?php echo lang('search')?></button>
						<a class="btn" href="<?php echo site_url($this->config->item('admin_folder').'/customers/index');?>">Reset</a>
					</fieldset>
				</form>
                                
			</div>





<?php echo form_open($this->config->item('admin_folder').'/invoices/bulk_delete', array('id'=>'delete_form', 'onsubmit'=>'return submit_form();', 'class="form-inline"')); ?>

	<div class="panel panel-default" style="width: 100%; float: left;">
		<div class="panel-heading"><?php echo lang('customers'); ?><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
				<div class="panel-body">
					<table id="myTable" class="table table-bordered table-hover" style="border: 1px solid #ddd;">
						<thead>
								<tr>
							<?php  if($this->bitauth->is_admin()):  ?>
								<th><button type="submit" class="glyphicon glyphicon-trash" ></button></th>
							<?php endif; ?>
											<th><?php echo sort_url('invoice_number', 'invoice_number', $sort_by, $sort_invoice, $code, $this->config->item('admin_folder')); ?></th>
											<th><?php echo lang('payment_method'); ?></th>
											<th><?php echo lang('invoice_customer'); ?></th>
											<th><?php echo sort_url('creation_date', 'created_on', $sort_by, $sort_invoice, $code, $this->config->item('admin_folder')); ?></th>
											<th><?php echo sort_url('total_price_gross', 'totalgross', $sort_by, $sort_invoice, $code, $this->config->item('admin_folder')); ?></th>
											<th><?php echo lang('payment_date'); ?></th>
											<th><?php echo lang('part_payment'); ?></th>
							</tr>
						</thead>

						<tbody>
							<?php echo (count($invoices) < 1)?'<div class="alert" style="text-align:center;"><button class="close" data-dismiss="alert">×</button><strong>'.lang('no_invoices') .'</strong></div>':''?>
							<?php if(!empty($invoices)): ?>
					 <?php foreach($invoices as $invoiced): ?>
					 
					 	<?php  if($this->bitauth->is_admin()){  ?>
								
										<tr>
										<td><input name="invoice[]" type="checkbox" value="<?php echo $invoiced->id; ?>" class="gc_check"/></td>
										<td><?php echo $invoiced->invoice_number; ?></td>
										<?php if($this->data_shop == 3){ ?>
										<td>Per factuur</td>
										<?php }
										else {
										?>	
										<td><?php echo $payment_method_array[$invoiced->payment_method]; ?></td>
										<?php
										}
										?>
										<td><?php echo $invoiced->company.', '.$invoiced->firstname.'&nbsp;'.$invoiced->lastname; ?></td>
										
										<td><input name="reception_date" type="text" value="<?php echo $invoiced->created_on; ?>" class="span2" /></td>
										<td><?php echo $invoiced->totalgross; ?></td>
										<?php
										if($invoiced->part_payments_made == '0'){
										?><td><?php echo lang('no_payments'); ?></td><?php
										?><td><?php echo lang('made_untill_now'); ?></td><?php
										}
										else {
										?><td><?php echo $invoiced->paid_on; ?></td><?php
										?><td><?php echo $invoiced->part_payment; ?></td><?php
										}
										?>
																			<td style="text-align: center; width: 50px;">
											<a class="glyphicon glyphicon-edit" style="display: inline-block; font-size: 16px;" href="<?php echo site_url($this->config->item('admin_folder').'/invoices/view/'.$invoiced->id ,array( 'class="form-inline"'));?>"><?php //echo lang('form_view')?></a>

								</td>
							</tr>
						<?php }else {

						foreach($invoiced as $invoice): 
							?><tr>
										<td><?php echo $invoice->invoice_number; ?></td>
										<?php if($this->data_shop == 3){ ?>
										<td>Per factuur</td>
										<?php }
										else {
										?>	
										<td><?php echo $payment_method_array[$invoice->payment_method]; ?></td>
										<?php
										}
										?>
										<td><?php echo $invoice->company.', '.$invoice->firstname.'&nbsp;'.$invoice->lastname; ?></td>
										
										<td><input name="reception_date" type="text" value="<?php echo $invoice->created_on; ?>" class="span2" /></td>
										<td><?php echo $invoice->totalgross; ?></td>
										<?php
										if($invoice->part_payments_made == '0'){
										?><td><?php echo lang('no_payments'); ?></td><?php
										?><td><?php echo lang('made_untill_now'); ?></td><?php
										}
										else {
										?><td><?php echo $invoice->paid_on; ?></td><?php
										?><td><?php echo $invoice->part_payment; ?></td><?php
										}
										?>
																			<td style="text-align: center; width: 50px;">
											<a class="glyphicon glyphicon-edit" style="display: inline-block; font-size: 16px;" href="<?php echo site_url($this->config->item('admin_folder').'/invoices/view/'.$invoice->id ,array( 'class="form-inline"'));?>"><?php //echo lang('form_view')?></a>

								</td>
							</tr><?php
								
					endforeach; 




						}
						?>  
					 
					 
					 
					 
					 
					 

						<?php endforeach; ?>
							<?php endif; ?>
						</tbody>
</table>
</div></div>
<?php echo form_close(); ?>




<div class="row">
	<div class="span12" style="border-bottom:1px solid #f5f5f5;">
		<div class="row">
			<div class="span4">
				<?php echo $this->pagination->create_links();?>	&nbsp;
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#gc_check_all').click(function(){
		if(this.checked){
			$('.gc_check').attr('checked', 'checked');
		}
		else{
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
		return confirm('<?php echo lang('confirm_delete_invoice') ?>');
	}
	else
	{
		alert('<?php echo lang('error_no_invoices_selected') ?>');
		return false;
	}
}

function save_status(id)
{
	show_animation();
	$.post("<?php echo site_url($this->config->item('admin_folder').'/invoices/edit_status'); ?>", { id: id, status: $('#status_form_'+id).val()}, function(data){
		setTimeout('hide_animation()', 500);
	});
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