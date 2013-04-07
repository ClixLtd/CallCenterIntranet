$(function () {
  
  // -- Display the PPI Invoice Total
  // --------------------------------
  $("#Invoice_Charge").change(function()
  {
    addInvoiceTotal();
  });
  
  $("#Invoice_Qty").change(function()
  {
    addInvoiceTotal();
  });
  
  function addInvoiceTotal()
  {
    var total = 0;
    var vat = 0;
    
    total = ($("#Invoice_Charge").val() / 100) * $("#Invoice_Fee").val();
    total = total * $("#Invoice_Qty").val();
    vat = total / 100 * $("#VAT_Percentage").val();
    total = total + vat;
    
    $("#Invoice_VAT").val(vat);
    $("#Invoice_Total").val(total.toFixed(2));
  }
  
  // -- Create an Invoice - David
  // ----------------------------
  $('#createInvoice').click(function()
  {
    // -- Validate Form
    // ----------------
    var msg = '';
    
    if($('#Invoice_Description').val() == '')
    {
      msg += "Invoice Description is empty\n";
    }
    
    if($('#Invoice_Charge').val() == '')
    {
      msg += "Invoice Charge is empty\n";
    }
    
    if($('#Refund_Method').val() < 0)
    {
      msg += "Refund Method not selected\n";
    }
    
    if(msg != '')
    {
      alert(msg);
    }
    else
    {
      var clientID = $('#Invoice_ClientID').val();
      
      /*
      $.ajax({
        url: 'http://gabintranet.clix.dev/crm/invoice/create_invoice/' + clientID,
        data:
        {
          claimID: 
          //$('#Create-Invoice').serialize()
        },
        async: false,
        dataType: "json", 
        success: function(data)
        {
          if (data['status'] == 'done')
    			{
    				alert('Invoice #' + data['message'] + ', has been created and sent to the print queue');
            $("#createInvoice").hide();
            location.reload();
    			}
    			else
    			{
    				alert('Error: Unable to create an Invoice. Please contact I.T. Support');
    			}
        }
      });
      */
      
      $.post('/crm/invoice/create_invoice/' + clientID + '.json',
  		$('#Create-Invoice').serialize(),
  		function(data){
  			if (data['status'] == 'done')
  			{
  				alert('Invoice #' + data['message'] + ', has been created and sent to the print queue');
          $("#createInvoice").hide();
          location.reload();
  			}
  			else
  			{
  				alert('Error: Unable to create an Invoice. Please contact I.T. Support');
  			}
  		});
    }
    
    return false;
  });
  
  // -- Pay Invoice
  // --------------
  $("#paidInvoice").click(function()
  {
    var invoiceID = $(this).attr('rel');
    
    if(confirm('Are you sure the client has paid?') == true)
    {
      $.getJSON('/crm/invoice/pay_invoice/' + invoiceID, function(data)
      {
        if(data['status'] == 'done')
        {
          alert('Invoice has been marked paid');
          location.reload();
        }
      });
    }
    else
    {
      return;
    }
  });
  
	// Simon's functions
	$('#dateRangeDisposition').click(
		function() {
			
			var url = '/reports/dispositions';
			
			var centerName = $('input[name=center]').val();
			
			
			if ( centerName && centerName != '-1') {
				url = url + '/center/' + centerName;
			}
			
			if ($('#startdate').val() != '') {
				url = url + '/' + $('#startdate').val();
			}
			
			if ($('#enddate').val() != '') {
				url = url + '/' + $('#enddate').val();
			}
		
			disposition_url = url+".json";
			
			load_dispositions();
			
			//window.location = url;
		}
	);
  
  // -- Enable Editing of the Client's Details
  // -----------------------------------------
  $("#Edit-Client-Details").click(function()
  {
    $(".Client-Edit-Input").removeAttr('readonly');
    $(".Client-Edit-Input").css('box-shadow', '0px 0px 2px #333');
    $("#saveClientDetails").show();
  });
  
  // -- Enable Editing of the Partner Details
  // ----------------------------------------
  $("#Edit-Partner-Details").click(function()
  {
    $(".Partner-Edit-Input").removeAttr('readonly');
    $(".Partner-Edit-Input").css('box-shadow', '0px 0px 2px #333');
    $("#savePartnerDetails").show();
  });
	
	
	$( '.cd-dropdown' ).dropdown({
    	gutter : 5,
    	delay : 20,
	});
	
	
	
	$('#dateRangeCommission').click(
		function() {
			
			var url = '/reports/commission';
			
			if ($('#startdate').val() != '') {
				url = url + '/' + $('#startdate').val();
			}
			
			if ($('#enddate').val() != '') {
				url = url + '/' + $('#enddate').val();
			}
		
			disposition_url = url+".json";
			
			load_dispositions();
			
			//window.location = url;
		}
	);

	// Notification Close Button
	$('.close-notification').click(
		function () {
			$(this).parent().fadeTo(350, 0, function () {$(this).slideUp(600);});
			return false;
		}
	);

	// jQuery Tipsy
	$('[rel=tooltip], #main-nav span, .loader').tipsy({gravity:'s', fade:true}); // Tooltip Gravity Orientation: n | w | e | s

	// jQuery Facebox Modal
	$('.open-modal').nyroModal();

	// jQuery jWYSIWYG Editor
	$('.wysiwyg').wysiwyg({ iFrameClass:'wysiwyg-iframe' });
	
	// jQuery dataTables
	$('.datatable').dataTable();

	// jQuery Custome File Input
	$('.fileupload').customFileInput();

	// jQuery DateInput
	$('.datepicker').datepick({ pickerClass: 'jq-datepicker' });
	
	$('.datetimepicker').datetimepicker();
	
	
	// jQuery Data Visualize
	$('table.data').each(function() {
		var chartWidth = $(this).parent().width()*0.90; // Set chart width to 90% of its parent
		var chartType = ''; // Set chart type
			
		if ($(this).attr('data-chart')) { // If exists chart-chart attribute
			chartType = $(this).attr('data-chart'); // Get chart type from data-chart attribute
		} else {
			chartType = 'area'; // If data-chart attribute is not set, use 'area' type as default. Options: 'bar', 'area', 'pie', 'line'
		}
		
		if(chartType == 'line' || chartType == 'pie') {
			$(this).hide().visualize({
				type: chartType,
				colors: ['#ae432e','#77ab13','#058dc7','#ef561a','#8d10ee','#5a3b16','#26a4ed','#f45a90','#e9e744', '1FC604', '#B6F314', '#2BAC37', '#AA7576', '#955FE8', '#8F8568', '#A2FA50', '#E7B93F', '#0E9831', '#ED64D4', '#D545AA', '#D5DCF2', '#DDA87E', '#87C100', '#2FD93A', '#E0025A', '#D30A0F', '#DDD764', '#5FC20C', '#23BFCF', '#AA0AD6', '#5A955A', '#4382BF', '#60E22F', '#F52B4F', '#AF9AA6', '#0F1A57', '#5AAEC5', '#D26C59', '#C4EE03', '#EA275C', '#E6C012', '#76C259', '#82CFF1', '#8B67A6', '#A81D07', '#AEE7EF', '#96668B', '#F1EB0E', '#D99404', '#BBCC9D', '#44B2BA', '#1508B9', '#4BA26B', '#044A85', '#F31B0B', '#95F47B', '#E90F1B', '#95748E', '#F9244B', '#A3FBF0', '#6856CC', '#1B51B7', '#D4D485', '#27F5C3', '#066025', '#09D5FA', '#116731', '#E05C5D', '#1851E1', '#4E8BFA', '#0F3E43', '#864ED7', '#0C858E', '#2A78B5', '#9041B3', '#CB2FA7', '#33D71B', '#F28871', '#6ABD27', '#2C77E3', '#AAFDA9', '#4DC25E', '#E506D8', '#742314', '#B413BF', '#66A534'],
				width: chartWidth,
				height: '325px',
				lineDots: 'double',
				interaction: true,
				multiHover: 5,
				tooltip: true,
				tooltiphtml: function(data) {
					var html ='';
					for(var i=0; i<data.point.length; i++){
						html += '<p class="chart_tooltip"><strong>'+data.point[i].value+'</strong> '+data.point[i].yLabels[0]+'</p>';
					}	
					return html;
				}
			});
		} else {
			$(this).hide().visualize({
				type: chartType,
				width: chartWidth,
				colors: ['#ae432e','#77ab13','#058dc7','#ef561a','#8d10ee','#5a3b16','#26a4ed','#f45a90','#e9e744', '1FC604', '#B6F314', '#2BAC37', '#AA7576', '#955FE8', '#8F8568', '#A2FA50', '#E7B93F', '#0E9831', '#ED64D4', '#D545AA', '#D5DCF2', '#DDA87E', '#87C100', '#2FD93A', '#E0025A', '#D30A0F', '#DDD764', '#5FC20C', '#23BFCF', '#AA0AD6', '#5A955A', '#4382BF', '#60E22F', '#F52B4F', '#AF9AA6', '#0F1A57', '#5AAEC5', '#D26C59', '#C4EE03', '#EA275C', '#E6C012', '#76C259', '#82CFF1', '#8B67A6', '#A81D07', '#AEE7EF', '#96668B', '#F1EB0E', '#D99404', '#BBCC9D', '#44B2BA', '#1508B9', '#4BA26B', '#044A85', '#F31B0B', '#95F47B', '#E90F1B', '#95748E', '#F9244B', '#A3FBF0', '#6856CC', '#1B51B7', '#D4D485', '#27F5C3', '#066025', '#09D5FA', '#116731', '#E05C5D', '#1851E1', '#4E8BFA', '#0F3E43', '#864ED7', '#0C858E', '#2A78B5', '#9041B3', '#CB2FA7', '#33D71B', '#F28871', '#6ABD27', '#2C77E3', '#AAFDA9', '#4DC25E', '#E506D8', '#742314', '#B413BF', '#66A534'],
				height: '325px',
				interaction: true,
				multiHover: 5,
				tooltip: true,
				tooltiphtml: function(data) {
					var html ='';
					for(var i=0; i<data.point.length; i++){
						html += '<p class="chart_tooltip"><strong>'+data.point[i].value+'</strong> '+data.point[i].yLabels[0]+'</p>';
					}	
					return html;
				}
			});
		}
	});

	// Check all checkboxes
	$('.check-all').click(
		function(){
			$(this).parents('form').find('input:checkbox').attr('checked', $(this).is(':checked'));
		}
	)

	// IE7 doesn't support :disabled
	$('.ie7').find(':disabled').addClass('disabled');

	// Menu Dropdown
	$('#main-nav li ul').hide(); //Hide all sub menus
	$('#main-nav li.current a').parent().find('ul').slideToggle('slow'); // Slide down the current sub menu
	$('#main-nav li a').click(
		function () {
			$(this).parent().siblings().find('ul').slideUp('normal'); // Slide up all menus except the one clicked
			$(this).parent().find('ul').slideToggle('normal'); // Slide down the clicked sub menu
			return false;
		}
	);
	$('#main-nav li a.no-submenu, #main-nav li li a').click(
		function () {
			window.location.href=(this.href); // Open link instead of a sub menu
			return false;
		}
	);

	// Widget Close Button
	$('.close-widget').click(
		function () {
			$(this).parent().fadeTo(350, 0, function () {$(this).slideUp(600);}); // Hide widgets
			return false;
		}
	);

	// Table actions
	$('.table-switch').hide();
	$('.toggle-table-switch').click(
		function () {
			$(this).parent().parent().siblings().find('.toggle-table-switch').removeClass('active').next().slideUp(); // Hide all menus expect the one clicked
			$(this).toggleClass('active').next().slideToggle(); // Toggle clicked menu
			$(document).click(function() { // Hide menu when clicked outside of it
				$('.table-switch').slideUp();
				$('.toggle-table-switch').removeClass('active')
			});
			return false;
		}
	);

	// Image actions
	$('.image-frame').hover(
		function() { $(this).find('.image-actions').css('display', 'none').fadeIn('fast').css('display', 'block'); }, // Show actions menu
		function() { $(this).find('.image-actions').fadeOut(100); } // Hide actions menu
	);

		// Tickets
	$('.tickets .ticket-details').hide(); // Hide all ticket details
	$('.tickets .ticket-open-details').click( // On click hide all ticket details content and open clicked one
		function() {
			//$('.tickets .ticket-details').slideUp()
			$(this).parent().parent().parent().parent().siblings().find('.ticket-details').slideUp(); // Hide all ticket details expect the one clicked
			$(this).parent().parent().parent().parent().find('.ticket-details').slideToggle();
			return false;
		}
	);

	// Wizard
	$('.wizard-content').hide(); // Hide all steps
	$('.wizard-content:first').show(); // Show default step
	$('.wizard-steps li:first-child').find('a').addClass('current');
	$('.wizard-steps a').click(
		function() { 
			var step = $(this).attr('href'); // Set variable 'step' to the value of href of clicked wizard step
			$('.wizard-steps a').removeClass('current');
			$(this).addClass('current');
			$(this).parent().prevAll().find('a').addClass('done'); // Mark all prev steps as done
			$(this).parent().nextAll().find('a').removeClass('done'); // Mark all next steps as undone
			$(step).siblings('.wizard-content').hide(); // Hide all content divs
			$(step).fadeIn(); // Show the content div with the id equal to the id of clicked step
			return false;
		}
	);
	$('.wizard-next').click(
		function() { 
			var step = $(this).attr('href'); // Set variable 'step' to the value of href of clicked wizard step
			$('.wizard-steps a').removeClass('current');
			$('.wizard-steps a[href="'+step+'"]').addClass('current');
			$('.wizard-steps a[href="'+step+'"]').parent().prevAll().find('a').addClass('done'); // Mark all prev steps as done
			$('.wizard-steps a[href="'+step+'"]').parent().nextAll().find('a').removeClass('done'); // Mark all next steps as undone
			$(step).siblings('.wizard-content').hide(); // Hide all content divs
			$(step).fadeIn(); // Show the content div with the id equal to the id of clicked step
			return false;
		}
	);

	// Content box tabs and sidetabs
	$('.tab, .sidetab').hide(); // Hide the content divs
	$('.default-tab, .default-sidetab').show(); // Show the div with class 'default-tab'
	$('.tab-switch a.default-tab, .sidetab-switch a.default-sidetab').addClass('current'); // Set the class of the default tab link to 'current'

	if (window.location.hash && window.location.hash.match(/^#tab\d+$/)) {
		var tabID = window.location.hash;
		
		$('.tab-switch a[href='+tabID+']').addClass('current').parent().siblings().find('a').removeClass('current');
		$('div'+tabID).parent().find('.tab').hide();
		$('div'+tabID).show();
	} else if (window.location.hash && window.location.hash.match(/^#sidetab\d+$/)) {
		var sidetabID = window.location.hash;
		
		$('.sidetab-switch a[href='+sidetabID+']').addClass('current');
		$('div'+sidetabID).parent().find('.sidetab').hide();
		$('div'+sidetabID).show();
	}
	
	$('.tab-switch a').click(
		function() { 
			var tab = $(this).attr('href'); // Set variable 'tab' to the value of href of clicked tab
			$(this).parent().siblings().find('a').removeClass('current'); // Remove 'current' class from all tabs
			$(this).addClass('current'); // Add class 'current' to clicked tab
			$(tab).siblings('.tab').hide(); // Hide all content divs
			$(tab).show(); // Show the content div with the id equal to the id of clicked tab
			$(tab).find('.visualize').trigger('visualizeRefresh'); // Refresh jQuery Visualize
			$('.fullcalendar').fullCalendar('render'); // Refresh jQuery FullCalendar
			return false;
		}
	);

	$('.sidetab-switch a').click(
		function() { 
			var sidetab = $(this).attr('href'); // Set variable 'sidetab' to the value of href of clicked sidetab
			$(this).parent().siblings().find('a').removeClass('current'); // Remove 'current' class from all sidetabs
			$(this).addClass('current'); // Add class 'current' to clicked sidetab
			$(sidetab).siblings('.sidetab').hide(); // Hide all content divs
			$(sidetab).show(); // Show the content div with the id equal to the id of clicked tab
			$(sidetab).find('.visualize').trigger('visualizeRefresh'); // Refresh jQuery Visualize
			$('.fullcalendar').fullCalendar('render'); // Refresh jQuery FullCalendar
			
			return false;
		}
	);
	
	// Content box accordions
	$('.accordion li div').hide();
	$('.accordion li:first-child div').show();
	$('.accordion .accordion-switch').click(
		function() {
			$(this).parent().siblings().find('div').slideUp();
			$(this).next().slideToggle();
			return false;
		}
	);
	
	//Minimize Content Article
	$('article header h2').css({ 'cursor':'s-resize' }); // Minizmie is not available without javascript, so we don't change cursor style with CSS
	$('article header h2').click( // Toggle the Box Content
		function () {
			$(this).parent().find('nav').toggle();
			$(this).parent().parent().find('section, footer').toggle();
		}
	);
	
	// Progress bar animation
	$('.progress-bar').each(function() {
		var progress = $(this).children().width();
		$(this).children().css({ 'width':0 }).animate({width:progress},3000);
	});
	
	//jQuery Full Calendar
	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();
	
	$('.fullcalendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,basicWeek,basicDay'
		},
		editable: true,
		events: [
			{
				title: 'All Day Event',
				start: new Date(y, m, 1)
			},
			{
				title: 'Long Event',
				start: new Date(y, m, d-5),
				end: new Date(y, m, d-2)
			},
			{
				id: 999,
				title: 'Repeating Event',
				start: new Date(y, m, d-3, 16, 0),
				allDay: false
			},
			{
				id: 999,
				title: 'Repeating Event',
				start: new Date(y, m, d+4, 16, 0),
				allDay: false
			},
			{
				title: 'Meeting',
				start: new Date(y, m, d, 10, 30),
				allDay: false
			},
			{
				title: 'Lunch',
				start: new Date(y, m, d, 12, 0),
				end: new Date(y, m, d, 14, 0),
				allDay: false
			},
			{
				title: 'Birthday Party',
				start: new Date(y, m, d+1, 19, 0),
				end: new Date(y, m, d+1, 22, 30),
				allDay: false
			},
			{
				title: 'Click for Walking Pixels',
				start: new Date(y, m, 28),
				end: new Date(y, m, 29),
				url: 'http://www.walkingpixels.com/'
			}
		]
	});
	
});