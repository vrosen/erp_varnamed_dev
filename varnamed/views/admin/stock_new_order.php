<?php include('header.php'); ?>
<?php

$date = array(
   'id' => 'date',
    'name' => 'date',
    'type' => 'text',
    'placeholder' => 'Date',
    
);

$warehouse_array = array(
    '0'             => 'Select warehouse',
    'dutchblue'     => 'Dutchblue(Delft)',
    'transoflex'    => 'Transoflex(Frechen)',
);



$vat_arr = array('0' => '0',$vat => $vat);


?>

<link href='http://fonts.googleapis.com/css?family=Raleway:500' rel='stylesheet' type='text/css'>
<?php echo form_open($this->config->item('admin_folder').'/suppliers/preview_order/'.$id); ?>

		<div class="panel panel-default" style="float: left; width: 100%;" id="customer_info">
			<div class="panel-heading">General Info<span id="stbar" class="closeit glyphicon glyphicon-chevron-down pull-right"></span></div>
				<div class="panel-body" id="customer_table" style="float: left;">
						<table class="table table-striped" style="border: 1px solid #ddd;">
                            <tr>
								<td style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 30%;">
									<?php echo lang('supplier');?>
								</td>
								<td><input type="text" value="<?php echo $supplier; ?>" class="form-control" name="supplier_name" style="width: 50%;" ></td>
                            </tr>
                            <tr>
								<td style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 30%;">
									Agent<?php //echo lang('order_entry');?>
								</td>
								<td><input type="text" value="<?php echo $current_user; ?>" class="form-control" name="supplier_name" style="width: 50%;" ></td>
                            </tr>
                            <tr>
								<td style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 30%;">
									<?php echo lang('order_date');?>
								</td>
								<?php $date = array(  'name' => 'order_date','type'=> 'date','value' => set_value('order_date',$order_date),'class'=>'form-control','style'=>'width: 20%;','id'=>'datepicker_0'); ?>
								<td><?php echo form_input($date); ?></td>
                            </tr>
                            <tr>
								<td style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 30%;">
									Expected arrival date<?php //echo lang('arrival_date');?>
								</td>
								<td><input id="datepicker_1" name="arrival_date" class="form-control" style="width: 20%;" value="" type="text" placeholder="expexted date of arrival"/></td>
                            </tr>
							<tr>
								<td style="font-family: 'Raleway', sans-serif; padding-left: 10px; width: 30%;">Select currency</td>
								<td>
									<?php 
										$atr = 'class=form-control style="width: 30%;"'; 
										echo form_dropdown('currency',$currency_array,$c_currency,$atr);
									?>
								</td>
							</tr>
							
							
						</table>
				</div>	
		</div>
<script type="text/javascript">
jQuery(function($) {
	$('.span1qq').autoNumeric('init');
});
</script>
		<div class="panel panel-default" style="width: 100%; float: left;">
			<div class="panel-heading">Order Products<?php //echo lang('invoice_details'); ?><span class="closeit glyphicon glyphicon-chevron-down pull-right"></span>
				</div>
					<div class="panel-body">
						<table id="myTable" class="table table-condensed" style="border: 1px solid #ddd;">
							<button id="addrow28" class="glyphicon glyphicon-plus" ></button>
								<thead>
									<tr>
										<td style="font-family: 'Raleway', sans-serif;">CODE<?php //echo lang('product_nr'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
										<td style="font-family: 'Raleway', sans-serif;"><?php echo lang('quantity'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
										<td style="font-family: 'Raleway', sans-serif;">VPE<?php //echo lang('num_vpe'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
										<td style="font-family: 'Raleway', sans-serif;"><?php echo lang('discount'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
										<td style="font-family: 'Raleway', sans-serif;">Unit Price<?php ///echo lang('unit_price'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
										<td style="font-family: 'Raleway', sans-serif;">Description</td>
									</tr>
								</thead>
								<tbody>
									<tr class='qqrow'>
										<td><input type="text" name="product_number[]" class="span222"  qq13="" required /></td>
										<td><input type="text" name="number[]" class="span1" required /></td>
										<td class='span3qq'></td>
										<td><?php echo form_input(array('name'=>'discount[]', 'class'=>'span2'));?></td>
										<td><input type="text" name="unit_price[]" class="span1qq" data-a-sign="<?php echo $c_details->currency_font; ?>" data-a-dec="." data-a-sep="," /></td>
										<td class='span2qq'></td>
										<td><a id="ibtnDel" class="glyphicon glyphicon-trash fakecl2" ></a></td>
									</tr>
								</tbody>
						</table>
					</div>
		</div>
		
		<input type="submit" class="btn btn-info" value="Make order">
		<input type="hidden" id="sup_id" value="<?php echo $id; ?>">
	</form>


	<script>
	$(function() {
	$( "#datepicker_0" ).datepicker({dateFormat:'yy-mm-dd', altField: '#start_top_alt', altFormat: 'yy-mm-dd'});
	$( "#datepicker_1" ).datepicker({dateFormat:'yy-mm-dd', altField: '#start_top_alt', altFormat: 'yy-mm-dd'});
	});
	
	
	$(document).ready(function(){
    
    var autocomplete_opt = {
        source: function(request, response){

            $.ajax({
                    url: qqurl+"admin/products/product_autocomplete_supplier",
                    dataType: "json",
                    type: "POST",
                    data: {
                        name: request.term,
                        limit: 10,
						supplier_id: $("#sup_id").val()
                    }, 
                    success: function (data) {
					
                        response($.map(data, function(item) {
                            return {
                                label: item.label+' - '+item.value,
                                value: item.value,
                                supplier_price: item.supplier_price,
                                package_details: item.package_details
                            }
                        }));
                        }
                    });
                    
        },
        minLength: 1,
        select: function(event, ui) {
                $(this).attr("qq13",ui.item.value);
                $(this).val(ui.item.value);
                //
                $(this).closest("tr.qqrow")   // Finds the closest row <tr> 
                 .find(".span2qq")     // Gets a descendent with class="nr"
                 .text(ui.item.label);  
                // 
                $(this).closest("tr.qqrow")   // Finds the closest row <tr> 
                 .find(".span3qq")     // Gets a descendent with class="nr"
                 .text(ui.item.package_details);  
                //
                $(this).closest("tr.qqrow")   // Finds the closest row <tr> 
                 .find(".span1qq")     // Gets a descendent with class="nr"
                 .val(ui.item.supplier_price);
                return false;
		}
    }
    // Use the .autocomplete() method to compile the list based on input from user
    $('input.span222').autocomplete(autocomplete_opt);
    //
    var counter = 0;
    $("#addrow28").on("click", function () {

                var counter = $('#myTable tr').length - 2;

                var newRow = $("<tr class='qqrow'>");
                var cols = "";
				
                
				cols += '<td><input type="text" class="span2" name="product_number[]" required/></td>';
                cols += '<td><input type="text" class="span1" name="number[]" required/></td><td class="span3qq"></td>';
                cols += '<td><input type="text" class="span1" name="discount[]"/></td>';
                cols += '<td><input type="text" name="unit_price[]" class="span1qq" data-a-sign="<?php echo $c_details->currency_font; ?>" data-a-dec="." data-a-sep="," /></td><td class="span2qq"></td>';
                cols += '<td><button class="glyphicon glyphicon-trash fakecl2"  ></button></td>';
                newRow.append(cols);
				
                if (counter == 100) $('#addrow').attr('disabled', true).prop('value', "You've reached the limit");
                 $("table.table-condensed").append(newRow);
                $('input.span2',newRow).autocomplete(autocomplete_opt);
                counter++;
                $(".fakecl2").on("click", function () {
                    $(this).parents('.qqrow').remove();
                });
				$('.span1qq',newRow).autoNumeric('init');
            });
    /////////////
 });

	
	
	
	
	</script>


<?php include('footer.php'); ?>