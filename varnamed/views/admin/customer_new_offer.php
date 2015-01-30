<?php include('header.php'); ?>


<?php echo form_open($this->config->item('admin_folder').'/customers/preview_offer/'.$id); ?>

<table id="myTable" class="table-condensed">
    <thead>
        <tr>
            <td><?php echo lang('product'); ?></td>
            <td><?php echo lang('quantity'); ?></td>
            <td><?php echo lang('price'); ?></td>

            
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo form_input(array('name'=>'product_number[]','class'=>'span2', 'id'=>'product_search'));?></td>
            <td><?php echo form_input(array('name'=>'number[]','class'=>'span2'));?></td>
            <td><?php echo form_input(array('name' => 'unit_price[]', 'class'=>'span2'));?></td>

            <td><a class="deleteRow"></a></td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" style="text-align: left;">
                <input type="button" class="btn btn-small" id="addrow" value="<?php echo lang('add_product'); ?>" />
            </td>
           
        </tr>

    </tfoot>
</table>

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

        cols += '<td><input type="text" class="span2" id="product_search" name="product_number[]' + counter + '"/></td>';
        cols += '<td><input type="text" class="span2" name="number[]' + counter + '"/></td>';
        cols += '<td><input type="text" class="span2"  name="unit_price[]' + counter + '"/></td>';

        


        cols += '<td><button id="ibtnDel" class="btn btn-small btn-danger" ><i class="icon-trash icon-white"></i></button></td>';
        newRow.append(cols);
        if (counter == 20) $('#addrow').attr('disabled', true).prop('value', "You've reached the limit");
        $("table.table-condensed").append(newRow);
        counter++;
    });

    $("table.table-condensed").on("change", 'input[name^="unit_price"]', function (event) {
        calculateRow($(this).closest("tr"));
        calculateGrandTotal();
    });


    $("table.table-condensed").on("click", "#ibtnDel", function (event) {
        $(this).closest("tr").remove();
        calculateGrandTotal();
    });


});



function calculateRow(row) {
    var number = +row.find('input[name^="unit_price"]').val();

}

function calculateGrandTotal() {
    var grandTotal = 0;
    $("table.table-condensed").find('input[name^="unit_price"]').each(function () {
        grandTotal += +$(this).val();
    });
    $("#grandtotal").text(grandTotal.toFixed(2));
}
</script>
<!-- TABLE START -->
<br>
		<input class="btn btn-success" type="submit" value="<?php echo lang('preview_offer');?>"/>
</form>

				
						<div class="row">
							<div class="span2">
								
								<script type="text/javascript">
								$('#product_search').keyup(function(){
									$('#product_list').html('');
									run_product_query();
                                                                        
								});
						
								function run_product_query()
								{
									$.post("<?php echo site_url($this->config->item('admin_folder').'/products/product_autocomplete/');?>", { name: $('#product_search').val(), limit:10},
										function(data) {
									
											$('#product_list').html('');
									
											$.each(data, function(index, value){
									
												if($('#related_product_'+index).length == 0)
												{
													$('#product_list').append('<option id="product_item_'+index+'" value="'+index+'">'+value+'</option>');
                                                                                                      
												}
											});
									
									}, 'json');
								}
								</script>
							</div>
						</div>
						<div class="row">
							<div class="span2">
								<select class="span7" id="product_list" size="5" style="margin:0px;"></select>
							</div>
						</div>
                                               <input type="button" value="fast remove"
   onclick="ClearOptionsFast('product_list');">
<script>
function ClearOptionsFast(id)
{
	var selectObj = document.getElementById(id);
	var selectParentNode = selectObj.parentNode;
	var newSelectObj = selectObj.cloneNode(false); // Make a shallow copy
	selectParentNode.replaceChild(newSelectObj, selectObj);
	return newSelectObj;
}
</script>
<?php include('footer.php');