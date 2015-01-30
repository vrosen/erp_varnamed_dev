<?php require('header.php'); ?>

<?php
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
    '1vast'      => lang('vast'),
    '1buiten'    => lang('buiten'),
);


	//set "code" for searches

	
	if($current_shop == 1){
	
		$warehouse_array = array(
		
			1	=>	'Combiwerk (Delft)',
			2	=>	'Transoflex (Frechen)',
			3	=>	'Combiwerk (Delft)',
			
		);
	
	}
	if($current_shop == 2){
	
		$warehouse_array = array(
		
			1	=>	'Combiwerk (Delft)',
			2	=>	'Transoflex (Frechen)',
			3	=>	'Combiwerk (Delft)',
			
		);
	
	}
	if($current_shop == 3){
	
		$warehouse_array = array(
		
			1	=>	'Combiwerk (Delft)',
			2	=>	'Transoflex (Frechen)',
			
		);
	
	}
	$shop_array = array(
	
	0	=> 'Select shop',
	1	=> 'Dutchblue',
	2	=> 'Comforties',
	3	=> 'Glovers',
		
	);
	
	
?>



<script type="text/javascript">
function areyousure()
{
	return confirm('<?php echo lang('areyousure');?>');
}
</script>

<?php 
$error = $this->session->flashdata('error');
if(!empty($error)){
echo $error;
}


?>


				<?php echo form_open($this->config->item('admin_folder').'/stock/warehouse_stock', 'style="float:left"');?>
					<fieldset>
						Export in excell<input type="checkbox" value="1" name="export">
						<input type="text" class="form-control" style="width: 228px; float: left; margin-right: 4px; " name="term" /> 
						<button class="btn btn-default" style="width: 144px; margin-top: 2px;"  name="submit" value="search"><span class="glyphicon glyphicon-search"></span></button>
						<a class="btn btn-info" style="width: 80px; margin-top: 2px;" href="<?php echo site_url($this->config->item('admin_folder').'/stock/warehouse_stock');?>"><span class="glyphicon glyphicon-refresh"></span></a>
						 
					</fieldset>
				</form>        
<p>&nbsp;</p>

	<div class="panel panel-default" style="width: 100%; float: left;">
		<div class="panel-heading">Selected Products<span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
			</div>
				<div class="panel-body">
					<table class="table table-striped table-hover" id="myTable" style="border: 1px solid #ddd;">
						<button id="addrow" class="glyphicon glyphicon-plus" ></button>
						<thead>
									<tr>
											<th style="font-size: 11px;"><?php echo lang('product'); ?></th>
											<th style="font-size: 11px;"><?php echo lang('current_quantity'); ?></th>
											<th style="font-size: 11px;"><?php echo lang('reserved_quantity'); ?></th>
											<th style="font-size: 11px;"><?php echo lang('warehouse'); ?></th>
											<th style="font-size: 11px;"><?php echo lang('order'); ?></th>
					
											<th style="font-size: 11px;"><?php echo lang('package_details'); ?></th>
											<th style="font-size: 11px;">Price<?php //echo lang('Replacement_value_per_package'); ?></th>
											<th style="font-size: 11px;"><?php echo lang('value'); ?></th>
											<th style="font-size: 11px;"><?php echo lang('arrival_date'); ?></th>
											<th style="font-size: 11px;"><?php echo lang('expiration_date'); ?></th>
											<th style="font-size: 11px;"><?php echo lang('batch_number'); ?></th>
											<th style="font-size: 11px;"><?php echo lang('warehouse_place'); ?></th>
											<th style="font-size: 11px;"><?php echo lang('reason'); ?></th>
											<th style="font-size: 11px;"><?php echo lang('description'); ?></th>

									</tr>
						</thead>
						<tbody>
							<?php if(!empty($orders)): ?>
								<?php foreach($orders as $order): ?>
											<tr>	
													<td style="font-size: 11px;"><a href="<?php echo site_url($this->config->item('admin_folder').'/stock/open_product/'.$order->code);?>" ><?php echo $order->code; ?></a></td>
													<td style="font-size: 11px;"><?php echo $order->current_quantity; ?></td>
													<td style="font-size: 11px;"><?php echo $order->ordered_quantity; ?></td>
													<td style="font-size: 11px;"><?php if(!empty($order->warehouse)) echo $warehouse_array[$order->warehouse]; ?></td>
													<td style="font-size: 11px;"><a href="<?php echo site_url($this->config->item('admin_folder').'/stock/view/'.$order->stock_order_id);?>" ><?php echo $order->stock_order_number; ?></a></td>
													<td style="font-size: 11px;"><?php echo $order->AANTALPERV.'('.$order->package_details.')'; ?></td>
													<td style="font-size: 11px;"><?php echo $order->price; ?></td>
													<td style="font-size: 11px;"><?php echo $order->price*$order->current_quantity; ?></td>
													<td style="font-size: 11px;"><input type="text" class="start_reception" name="reception_date[]" value="<?php echo $order->reception_date; ?>"  style="width: 80px; "/></td>
													<td style="font-size: 11px;"><input type="text" class="start_expiry" name="expiration_date[]" value="<?php echo $order->expiration_date; ?>"   style="width: 80px; "/></td>
													<td style="font-size: 11px;"><input type="text" value="<?php echo $order->batch_number; ?>" style="width: 90%;" name="batch_number[]"></td>
													<td style="font-size: 11px;"><input type="text" value="<?php echo $order->warehouse_place; ?>" style="width: 90%;" name="warehouse_place[]"></td>
													<td></td>
													<td style="font-size: 11px;"><?php echo $order->description; ?></td>

											</tr>
								<?php endforeach; ?>
						<?php endif; ?>
						  <?php echo form_open($this->config->item('admin_folder').'/stock/operation'); ?>
											<td style="font-size: 11px;"><input type="text" style="width: 90%;" name="new_code[]"></td>
											<td style="font-size: 11px;"><input type="text" style="width: 90%;" name="new_quantity[]"></td>
											<td style="font-size: 11px;"></td>
											<td style="font-size: 11px;">
												<select name="magazijnnr[]">
													<option selected="selected" value="1">Combiwerk (Delft)</option>
													<option value="2">Transoflex (Frechen)</option>
												</select>
											</td>
											<td style="font-size: 11px;"><input type="text" style="width: 90%;" name="new_order_number[]"></td>
											<td style="font-size: 11px;"></td>
											<td style="font-size: 11px;"></td>
											<td style="font-size: 11px;"></td>
											<td style="font-size: 11px;"><input type="text" class="start_reception" style="width: 80px;" name="new_arrival_date[]"></td>
											<td style="font-size: 11px;"><input type="text" class="start_expiry" style="width: 80px;" name="new_expiry_date[]"></td>
											<td style="font-size: 11px;"><input type="text" style="width: 90%;" name="new_batch_number[]"></td>
											<td style="font-size: 11px;"><input type="text" style="width: 90%;" name="new_warehouse_place[]"></td>
											<td style="font-size: 11px;">
												<select name="reason[]">
													<option value="0">Reason</option>
													<option value="8">Order</option>
													<option value="9">Korrektur</option>
													<option value="10">Versendung gelöscht</option>
													<option value="11">Retour</option>
												</select>
											</td>
											<td style="font-size: 11px;"></td>
											 <td><button id="ibtnDel" class="glyphicon glyphicon-trash"  ></button></td>
							
						</tbody>
</table>

<br>



      
						<button class="btn btn-primary" type="submit" name="add"  onclick="return areyousure();" value="addt"><?php echo lang('add')?></button>
						<button class="btn btn-primary" type="submit" name="remove"  onclick="return areyousure();" value="remove"><?php echo lang('remove')?></button>
				</form>
			</div>
		</div>






<?php include('footer.php'); ?>

<script>$('.start_reception').datepicker({dateFormat:'yy-mm-dd', altField: '#start_top_alt', altFormat: 'yy-mm-dd'});</script>
<script>$('.start_expected').datepicker({dateFormat:'yy-mm-dd', altField: '#start_top_alt', altFormat: 'yy-mm-dd'});</script>
<script>$('.start_expiry').datepicker({dateFormat:'yy-mm-dd', altField: '#start_top_alt', altFormat: 'yy-mm-dd'});</script>
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
        <script>
        $(document).ready(function () {
            var counter = 0;

            $("#addrow").on("click", function () {


                var counter = $('#myTable tr').length - 2;

                $("#ibtnDel").on("click", function () {
                    counter = -1
                });


                var newRow = $("<tr>");
                var cols = "";

                cols += '<td style="font-size: 11px;"><input type="text" style="width: 90%;" name="new_code[]' + counter + '" required/></td>';
                cols += '<td style="font-size: 11px;"><input type="text" style="width: 90%;" name="new_quantity[]' + counter + '" required/></td><td></td>';
                cols += '<td style="font-size: 11px;"><select name="magazijnnr[]"><option selected="selected" value="1">Combiwerk (Delft)</option><option value="2">Transoflex (Frechen)</option></select></td>';
                cols += '<td style="font-size: 11px;"><input type="text" style="width: 90%;" name="new_order_number[]' + counter + '"/></td><td></td><td></td><td></td>';
                cols += '<td style="font-size: 11px;"><input type="text" class="start_reception" style="width: 80px;" name="new_arrival_date[]' + counter + '"/></td>';
                cols += '<td style="font-size: 11px;"><input type="text" class="start_expiry" style="width: 80px;" name="new_expiry_date[]' + counter + '"/></td>';
                cols += '<td style="font-size: 11px;"><input type="text" style="width: 90%;" name="new_batch_number[]' + counter + '"/></td>';
                cols += '<td style="font-size: 11px;"><input type="text" style="width: 90%;" name="new_warehouse_place[]' + counter + '"/></td>';
                cols += '<td style="font-size: 11px;"><select name="reason[]"><option value="0">Reason</option><option value="8">Order</option><option value="9">Korrektur</option><option value="10">Versendung gelöscht</option><option value="11">Retour</option></select></td>';
                cols += '<td></td>';




                cols += '<td><button id="ibtnDel" class="glyphicon glyphicon-trash" style="display: inline-block; " ></button></td>';
                newRow.append(cols);
                if (counter == 20) $('#addrow').attr('disabled', true).prop('value', "You've reached the limit");
                $("table.table-hover").append(newRow);
                counter++;
            });

            $("table.table-hover").on("change", 'input[name^="unit_price"]', function (event) {
                calculateRow($(this).closest("tr"));
                calculateGrandTotal();
            });


            $("table.table-hover").on("click", "#ibtnDel", function (event) {
                $(this).closest("tr").remove();
                calculateGrandTotal();
            });


        });



        function calculateRow(row) {
            var number = +row.find('input[name^="unit_price"]').val();

        }

        function calculateGrandTotal() {
            var grandTotal = 0;
            $("table.order-list").find('input[name^="unit_price"]').each(function () {
                grandTotal += +$(this).val();
            });
            $("#grandtotal").text(grandTotal.toFixed(2));
        }
        </script>

