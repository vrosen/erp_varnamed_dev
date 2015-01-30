$(document).ready(function() { //////////////////////////////////////////////

    var autocomplete_opt = {
        source: function(request, response) {
            // admin/products
            $.ajax({
                url: qqurl + "admin/products/product_autocomplete",
                dataType: "json",
                type: "POST",
                data: {
                    name: request.term,
                    limit: 10
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.value + ' - ' + item.label,
                            value: item.value,
                            saleprice: item.saleprice,
                            package_details: item.package_details
                        }
                    }));
                }
            });

            // response(availableTags);
        },
        minLength: 1,
        select: function(event, ui) {
            $(this).attr("qq12", ui.item.value);
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
                    .text(ui.item.saleprice);
            return false;
        }

    }
    // Use the .autocomplete() method to compile the list based on input from user
    $('input.span2').autocomplete(autocomplete_opt);
    //
    var counter = 0;
    $("#addrow1").on("click", function() {

        var counter = $('#myTable tr').length - 2;



        var newRow = $("<tr class='qqrow'>");
        var cols = "";

        cols += '<td><input type="text" class="span2" name="product_number[]" required/></td>';
        cols += '<td><input type="text" class="span1" name="number[]" required/></td><td class="span3qq"></td><td class="span1qq"></td>';
        cols += '<td><input type="text" class="span1" name="discount[]"/></td>';
        cols += '<td><input type="text" class="span1" name="unit_price[]"/></td><td class="span2qq"></td>';
        cols += '<td><button class="glyphicon glyphicon-trash fakecl1"  ></button></td>';
        newRow.append(cols);
        if (counter == 20)
            $('#addrow1').attr('disabled', true).prop('value', "You've reached the limit");
        $("table.table-condensed").append(newRow);
        $('input.span2', newRow).autocomplete(autocomplete_opt);
        counter++;
        $(".fakecl1").on("click", function() {
            $(this).parents('.qqrow').remove();
        });
    });
    /////////////
});


