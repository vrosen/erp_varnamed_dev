$(document).ready(function(){
	//$('.datepicker').datepicker({dateFormat: 'yy-mm-dd'});
	
	// Main Packery block
    //var container = document.querySelector('.container');
    //var stampElem = document.querySelector('#notmoving');
    // initializing Packery
   /* var pckry = new Packery(container, {
        itemSelector: '.panel-default',
        gutter: 2
    });

    //pckry.stamp( stampElem );

    var itemElems = pckry.getItemElements();

    // for each item...
    for ( var i=0, len = itemElems.length; i < len; i++ ) {
      var elem = itemElems[i];
      // make element draggable with Draggabilly
      var draggie = new Draggabilly( elem , {
        containment: '.container',
        handle: '.panel-heading'
      });
      // bind Draggabilly events to Packery
      pckry.bindDraggabillyEvents( draggie );
    } */
	


    // Remove widget from DOM
    $('body').on('click', '.panel-heading', function() {
        //$(this).parent().parent().remove();
        $(this).parent().children('div.panel-body').toggle();
		$('#view').css('height', ($('#view').css('width') - 96));

      //  pckry.layout();

     }); 
	 
	     $('body').on('click', '#stbar', function() {
        //$(this).parent().parent().remove();
        $(this).parent().children('div.panel-body').toggle();
		$('#view').css('height', ($('#view').css('width') - 96));

      //  pckry.layout();

     }); 
 
	      // Opens iframe popup
    $('body').on('click', '.gobaby', function() {
    
        
	  			$(".gobaby").colorbox({iframe:true, width:"95%", height:"90%"});
			    
				}); 
  

	  
	  $('body').on('click', '#sidebarhide', function() {
        //$(this).parent().parent().remove();

        $(this).parent().css({width:'75px', opacity:'0.4'});
		$(this).hide();
		$('#sidebarhide1').hide();
		$('#view').css('padding-left', '80px');
		$('#sidebarshow').show();
		$('#sidebarshow1').show();
		
      });
	 
	  
	  $('body').on('click', '#sidebarshow', function() {
        //$(this).parent().parent().remove();

        $(this).parent().css({width:'265px', opacity:'1'});
		$(this).hide();
		$('#sidebarshow1').hide();
		$('#view').css('padding-left', '270px');
		$('#sidebarhide').show();	
		$('#sidebarhide1').show();
		
      }); 
	  
	  
	  $('body').on('click', '#sidebarhide1', function() {
        //$(this).parent().parent().remove();

        $(this).parent().css({width:'75px', opacity:'0.4'});
		$(this).hide();
		$('#sidebarhide').hide();
		$('#view').css('padding-left', '80px');
		$('#sidebarshow').show();
		$('#sidebarshow1').show();
		
      });
	 
	  
	  $('body').on('click', '#sidebarshow1', function() {
        //$(this).parent().parent().remove();

        $(this).parent().css({width:'265px', opacity:'1'});
		$(this).hide();
		$('#sidebarshow').hide();
		$('#view').css('padding-left', '270px');
		$('#sidebarhide').show();	
		$('#sidebarhide1').show();
		
      }); 
	  
	  	/*  $('body').on('click', '#rightsidebarhide', function() {
        //$(this).parent().parent().remove();
        $(this).parent().css({width:'5%', opacity:'0.8', 'white-space':'nowrap'});
		$(this).hide();
		$('#rightsidebarhide').hide();
		$('#rightsidebarshow1').hide();
		$('#rightsidebarhide1').hide();		
		$('#heyti').hide();
		$('#heyti1').css('width', 'auto');
		$('#customer_info').css('width', '93%');
		$('#rightsidebarshow').show();
		
      });
	 
	  
	  $('body').on('click', '#rightsidebarshow', function() {
        //$(this).parent().parent().remove();
        $(this).parent().css({width:'15.5%', opacity:'1', 'white-space':'normal'});
		$(this).hide();
		$('#rightsidebarshow').hide();
		$('#rightsidebarshow1').hide();
		$('#rightsidebarhide1').hide();		
		$('#heyti').show();
		$('#heyti1').css('width', '100%');
		$('#customer_info').css('width', '80%');
		$('#rightsidebarhide').show();	
		
      }); */
	  
	/*  	  $('body').on('click', '#rightsidebarhide', function() {
        //$(this).parent().parent().remove();

        $(this).parent().css({'background-color':'#6F5499', opacity:'0.8', top:'auto', bottom:'0px', right:'10px'});
		$(this).hide();	
		$('#heyti1').css('display', 'none');
		$('#customer_info').css('width', '100%');		
		//$('#sidebarshow').show();
		$('#rightsidebarshow').show();
		
      });
	 
	  
	  $('body').on('click', '#rightsidebarshow', function() {
        //$(this).parent().parent().remove();

        $(this).parent().css({'background-color':'#fff', opacity:'1', width:'15.5%', top:'60px', bottom:'auto', right:'0px'});
		$(this).hide();
		$('#rightsidebarshow').hide();		
		$('#heyti1').css('display', 'block');
		$('#customer_info').css('width', '80%');
		//$('#sidebarhide').show();	
		$('#rightsidebarhide').show();
		
      }); */
	
	$('.redactor').redactor({
		focus: true,
		plugins: ['fileBrowser']
	});
	
	 $(".imgcontainer > img").each(function(){
	   var thisimg = "url("+$(this).attr('src')+")";
	   $(this).css({'background-image': thisimg });
	   $(this).attr('src', '');
	 });	
	 
 
      /*  $('#dashboardtable').jtable({
            paging: true, //Enable paging
            pageSize: 16, //Set page size (default: 10)
            sorting: true, //Enable sorting
            defaultSorting: 'ordered_on DESC', //Set default sorting
            actions: {
                listAction: '/varnamed/admin/dashboard_lastorders?action=list',
               // deleteAction: '/Demo/DeleteStudent',
                //updateAction: '/Demo/UpdateStudent',
               // createAction: '/Demo/CreateStudent'
            },
            fields: {
                order_number: {
					title: 'Order #',
                    key: true,
					width: '8%',
                    //create: false,
                    //edit: false,
                    //list: false
                },
                company: {
                    title: 'Company Name',
                    width: '19%'
                },
                country_id: {
                    title: 'Country',
					width: '8%',
                },
                entered_by: {
                    title: 'Order Placed by',
					width: '18%',
                },
				payment_method: {
                    title: 'Payment',
					width: '10%',
                },
                ordered_on: {
                    title: 'Order Date',
                    width: '10%',
                },
                dropshipment: {
                    title: 'Dropspmt',
                    width: '9%'
                },
				BACKORDER: {
                    title: 'Backorder',
                    width: '9%',
                },
                remarks: {
					title: 'Actions',
					width: '8%'                   
                }
            }
        });
 
        //Load student list from server
        $('#dashboardtable').jtable('load');

*/
});

	//$(".gobaby").click( function () { $(this).colorbox({iframe:true, width:"80%", height:"80%"}); });
