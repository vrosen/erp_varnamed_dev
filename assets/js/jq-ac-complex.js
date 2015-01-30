$(document).ready(function(){
    $("#addPartButton").click( function(){
        $c = $.trim($("#addPart").val());
        if(!$c) alert("Input Part Code");
        else
        {
            $.ajax({
                    url: qqurl+"admin/part/add",
                    dataType: "html",
                    type: "POST",
                    data: {
                        part: $c,
                        complex: $("#addPart").attr('baseId')
                    }, 
                    success: function (data) {
                        if(data = 'OK') location.reload(); 
                        else alert(data);
                        }
                    });
        }
    });
    //
    $(".fakecl3").on("click", function () {
            $.ajax({
                    url: qqurl+"admin/part/delete",
                    dataType: "html",
                    type: "POST",
                    data: {
                        part: $(this).attr('delid'),
                        complex: $("#addPart").attr('baseId')
                    }, 
                    success: function (data) {
                        if(data = 'OK') location.reload(); 
                        else alert(data);
                        }
            });
    });
    //
    var autocomplete_opt = {
        source: function(request, response){
            $.ajax({
                    url: qqurl+"admin/products/product_autocomplete",
                    dataType: "json",
                    type: "POST",
                    data: {
                        name: request.term,
                        limit: 10
                    }, 
                    success: function (data) {
                        response($.map(data, function(item) {
                            //
                            return {
                                label: item.value+' - '+item.label,
                                value: item.value,
                            }
                        }));
                        }
                    });
                    
            // response(availableTags);
        },
        minLength: 1,
        select: function(event, ui) {
                
                $(this).val(ui.item.value);
                
                return false;
	}
        
    }
    // Use the .autocomplete() method to compile the list based on input from user
    $('#addPart').autocomplete(autocomplete_opt);
 });

    
