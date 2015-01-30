<?php require('header.php'); 

    $month_array = array(
							'-1'	=> 'Select month',
							date('m')   => date('M'),
                            '1' => 'January',
                            '2' => 'February',
                            '3' => 'March',
                            '4' => 'April',
                            '5' => 'May',
                            '6' => 'June',
                            '7' => 'July',
                            '8' => 'August',
                            '9' => 'September',
                            '10' => 'Oktober',
                            '11' => 'November',
                            '12' => 'December',
                );
                
                $year_array = array(

                    date('Y') => date('Y'),
                    '2006' => '2006',
                    '2007' => '2007',
                    '2008' => '2008',
                    '2009' => '2009',
                    '2010' => '2010',
                    '2011' => '2011',
                    '2012' => '2012',
                    '2013' => '2013',
                    
                );
				$status_array = array(
					
					3=> 'Select status',
					1=>'Open',
					2=>'Closed',
				);

				$sent_array = array(
					
					'-1'=> 'Select status',
					1=>'Not sent',
					2=>'Sent',
				);
				
				
				
            if($current_shop == 1){
               $payment_method_array = array(

                '-1'    => lang('select_payment_method'),
				'0'  	=> 'N/A',
                '1'     => 'Invoice upon delivery',
                '2'		=> 'Direct debit',
                '3'     => 'Paid in advance',
                '4'     => 'iDEAL',
                '6'     => 'American Express',
                '7'     => 'MasterCard',
                '8'     => 'VISA',
                '9'     => 'Instant wire transfer',
                '10'    => 'Giropay',
                '11'    => 'EPS',
                '12'    => 'PAYPAL',
                '5'     => 'Free sample delivery',
                '13'  	=> 'Comforties.com BV Account',//set the shop variable
                '14'    => 'By cheque',
            ); 
            }
            if($current_shop == 2){
                $payment_method_array = array(

                '-1'                         => lang('select_payment_method'),
                '0'                         => 'N/A',
                '1'     => 'Invoice upon delivery',
                '2'              => 'Direct debit',
                '3'           => 'Paid in advance',
                '4'                     => 'iDEAL',
                '6'          => 'American Express',
                '7'                => 'MasterCard',
                '8'                      => 'VISA',
                '9'     => 'Instant wire transfer',
                '10'                   => 'Giropay',
                '11'                       => 'EPS',
                '12'                    => 'PAYPAL',
                '5'      => 'Free sample delivery',
                '13'  => 'Dutchblue.com BV Account',//set the shop variable
                '14'                 =>  'By cheque',
            );
            }
            if($current_shop == 3){
                $payment_method_array = array(

                '-1'                         => lang('select_payment_method'),
                '0'                         => 'N/A',
                '1'     => 'Invoice upon delivery',
                '2'              => 'Direct debit',
                '3'           => 'Paid in advance',
                '4'                     => 'iDEAL',
                '6'          => 'American Express',
                '7'                => 'MasterCard',
                '8'                      => 'VISA',
                '9'     => 'Instant wire transfer',
                '10'                   => 'Giropay',
                '11'                       => 'EPS',
                '12'                    => 'PAYPAL',
                '5'      => 'Free sample delivery',
                '13'  => 'Dutchblue.com BV Account',//set the shop variable
                '14'                 =>  'By cheque',
            );
            }
			$country_array = array(
				
					'-1'	=> 'Select country',
					'NL'	=> 'Netherlands',
					'DE'	=> 'Germany',
					'AT'	=> 'Austria',
					'FR'	=> 'France',
					'LX'	=> 'Luxembourg',
					'BE'	=> 'Belgium',
					'UK'	=> 'UK',
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
			
		$return = site_url($admin_folder.'/invoices/invoice_list/'.$by.'/'.$sort.'/'.$code);
		echo '<a href="'.$return.'">'.lang($lang).$icon.'</a>';
	}
	?>

<style type="text/css">
	.pagination {
		margin:0px;
		margin-top:-3px;
	}
</style>
 <script>
$(function() {
$( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
});
$(function() {
$( "#datepicker_1" ).datepicker({ dateFormat: 'yy-mm-dd' });
});
$(function() {
$( ".datepicker_" ).datepicker({ dateFormat: 'yy-mm-dd' });
});
</script>

<br>
			<!--****************************************************************************************************************************************************************************-->
			<div class="form-group">
				<?php echo form_open($this->config->item('admin_folder').'/invoices/invoice_list'); ?>
				

						<?php
							if(!empty($month)) {
								echo form_dropdown('month', $month_array, $month); 
							} else {
								echo form_dropdown('month', $month_array, '-1'); 
							}
						?>
						<?php
							if(!empty($start_date)){
								?><input type="text" name="start_date" class="datepicker_" placeholder="start date" value="<?php echo $start_date; ?>"/><?php
							}else {
								?><input type="text" name="start_date" class="datepicker_" placeholder="start date"/><?php
							}
						?>
						<?php
							if(!empty($end_date)){
								?><input type="text" name="end_date" class="datepicker_" placeholder="end date" value="<?php echo $end_date; ?>"/><?php
							}else {
								?><input type="text" name="end_date" class="datepicker_" placeholder="end date"/><?php
							}
						?>
						 <input type="checkbox" value="1" name="unset_days">
						<?php		
							if(!empty($year)) {
								echo form_dropdown('year', $year_array, $year);
							} else {
								echo form_dropdown('year', $year_array, '-1');
							}			
						?>
						<?php 
							if(!empty($invoice_status)) {
								echo form_dropdown('invoice_status', $status_array, $invoice_status);
							} else {
								echo form_dropdown('invoice_status', $status_array, '-1');
							}
						?>
						<?php
							if(!empty($sent)) {
								echo form_dropdown('sent', $sent_array, $sent);
							} else {
								echo form_dropdown('sent', $sent_array, '-1');
							}						
						?>
						<?php
							if(!empty($country)) {
								echo form_dropdown('country', $country_array, $country);
							} else {
								echo form_dropdown('country', $country_array, '-1');
							}						
						?>
						<?php
							if(!empty($payment_method)) {
								echo form_dropdown('payment_method', $payment_method_array, $payment_method);
							} else {
								echo form_dropdown('payment_method', $payment_method_array, '-1');
							}						
						?>
						Export excel <input type="checkbox" value="1" name="export">
						&nbsp;
						<button class="btn btn-default" style="width: 43px; margin-top: 10px;"  name="submit" value="search"><span class="glyphicon glyphicon-search"></span></button>
						<a class="btn btn-info" style="width: 43px; margin-top: 10px;" href="<?php echo site_url($uri); ?>"><span class="glyphicon glyphicon-refresh"></span></a>
				</form>
			</div>
			<!--****************************************************************************************************************************************************************************-->


<?php echo form_open($this->config->item('admin_folder').'/invoices/bulk_delete', array('id'=>'delete_form', 'onsubmit'=>'return submit_form();', 'class="form-inline"')); ?>

	<div class="panel panel-default" style="width: 100%; float: left;">
		<div class="panel-heading"><?php echo lang('invoices'); ?><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
				<div class="panel-body">
					<table id="myTable" class="table table-bordered table-hover" style="border: 1px solid #ddd;">
						<thead>
							<tr>
								
								<th style="white-space:nowrap"><?php echo sort_url('invoice_number', 'invoice_number', $sort_by, $sort_invoice, $code, $this->config->item('admin_folder')); ?></th>
								<th style="white-space:nowrap"><?php echo sort_url('order_number', 'order_number', $sort_by, $sort_invoice, $code, $this->config->item('admin_folder')); ?></th>
								<th style="white-space:nowrap"><?php echo sort_url('invoice_customer', 'bill_company', $sort_by, $sort_invoice, $code, $this->config->item('admin_folder')); ?></th>
								<th style="white-space:nowrap"><?php echo sort_url('country_code', 'country_id', $sort_by, $sort_invoice, $code, $this->config->item('admin_folder')); ?></th>
								<th style="white-space:nowrap"><?php echo sort_url('payment_method', 'payment_method', $sort_by, $sort_invoice, $code, $this->config->item('admin_folder')); ?></th>
								<th style="white-space:nowrap"><?php echo sort_url('invoice_date', 'created_on', $sort_by, $sort_invoice, $code, $this->config->item('admin_folder')); ?></th>
								<th style="white-space:nowrap"><?php echo sort_url('paid_on', 'paid_on', $sort_by, $sort_invoice, $code, $this->config->item('admin_folder')); ?></th>
								<th style="white-space:nowrap"><?php echo sort_url('total_price_net', 'totalnet', $sort_by, $sort_invoice, $code, $this->config->item('admin_folder')); ?></th>
								<th style="white-space:nowrap"><?php echo sort_url('vat', 'VAT', $sort_by, $sort_invoice, $code, $this->config->item('admin_folder')); ?></th>
								<th style="white-space:nowrap"><?php echo sort_url('total_price_gross', 'totalgross', $sort_by, $sort_invoice, $code, $this->config->item('admin_folder')); ?></th>
							</tr>
						</thead>

						<tbody>

							<?php echo (count($invoices) < 1)?'<div class="alert" style="text-align:center;"><button class="close" data-dismiss="alert">×</button><strong>'.lang('no_invoices') .'</strong></div>':''?>
						<?php if(!empty($invoices)): ?>
								<?php foreach($invoices as $invoice): ?>

						<tr>
							<?php if($current_shop == 2): ?>
									<td style="white-space:nowrap"><?php echo $invoice['invoice_number']; ?></td>
									<td style="white-space:nowrap"><?php echo $invoice['order_number']; ?></td>
									<td style="white-space:nowrap"><?php echo $invoice['customer_id'].', '.$invoice['company']; ?></td>
									<td style="white-space:nowrap"><?php echo $invoice['country_id']; ?></td>
									<td style="white-space:nowrap"><?php echo $payment_method_array[$invoice['payment_method']]; ?></td>
									<td style="white-space:nowrap"><?php echo $invoice['created_on']; ?></td>
									<td style="white-space:nowrap"><?php 
										if($invoice['paid_on'] == null){
											echo 'Not paid';
										}else {
											echo $invoice['paid_on'];
										}
									 ?></td>
									<td style="white-space:nowrap"><?php echo $this->config->item('currency_symbol').' '.money_format('%.2n', $invoice['totalnet']); ?></td>
									<td style="white-space:nowrap">
										 <?php 
											 if($invoice['totalnet'] != '0.00'){
												 echo $this->config->item('currency_symbol').' '.money_format('%.2n', $invoice['VAT']); 
											 }
										 ?>
									</td>

									<td style="white-space:nowrap"><?php echo $this->config->item('currency_symbol').' '.money_format('%.2n', $invoice['totalgross']); ?></td>
									<td style="text-align: center; width: 50px;">
										<a class="glyphicon glyphicon-edit" style="display: inline-block; font-size: 16px;" href="<?php echo site_url($this->config->item('admin_folder').'/invoices/view/'.$invoice['id'] ,array( 'class="form-inline"'));?>"><?php //echo lang('form_view')?></a>
									</td>
									<?php endif; ?>
								<?php if($current_shop == 1): ?>
									<td style="white-space:nowrap"><?php echo $invoice['invoice_number']; ?></td>
									<td style="white-space:nowrap"><?php echo $invoice['order_number']; ?></td>
									<td style="white-space:nowrap"><?php echo $invoice['customer_id'].', '.$invoice['company']; ?></td>
									<td style="white-space:nowrap"><?php echo $invoice['country_id']; ?></td>
									<td style="white-space:nowrap"><?php echo $payment_method_array[$invoice['payment_method']]; ?></td>
									<td style="white-space:nowrap"><?php echo $invoice['created_on']; ?></td>
									<td style="white-space:nowrap"><?php 
										if($invoice['paid_on'] == null){
											echo 'Not paid';
										}else {
											echo $invoice['paid_on'];
										}
									 ?></td>
									<td style="white-space:nowrap"><?php echo $this->config->item('currency_symbol').' '.money_format('%.2n', $invoice['totalnet']); ?></td>
									<td style="white-space:nowrap"><?php echo $this->config->item('currency_symbol').' '.money_format('%.2n', $invoice['VAT']); ?></td>
									<td style="white-space:nowrap"><?php echo $this->config->item('currency_symbol').' '.money_format('%.2n', $invoice['totalgross']); ?></td>
									<td style="text-align: center; width: 50px;">
										<a class="glyphicon glyphicon-edit" style="display: inline-block; font-size: 16px;" href="<?php echo site_url($this->config->item('admin_folder').'/invoices/view/'.$invoice['id'] ,array( 'class="form-inline"'));?>"><?php //echo lang('form_view')?></a>
									</td>

									<?php endif; ?>
						</tr>
						<?php endforeach; ?>
							<?php endif; ?>
						</tbody>
</table>
</div></div>

<?php echo form_close(); ?>
			<div class="span4">
				<?php echo $this->pagination->create_links();?>	
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