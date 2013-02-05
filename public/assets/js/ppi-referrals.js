$(function () {
  
	$('#PPI-Stage-Search').change(function()
  {
    $.getJSON('/crm/ppi/stage_statues_list/' + $(this).val(), function(data)
    {
      var options = '';
      var selected = '';
      
      options += '<option value="-1">-- Select Stage Status --</option>';
      
      for(i = 0; i < data.length; i++)
      {
        if($("#PPI-Stage-Status-Selected").val() == data[i].id)
        {
          selected = ' SELECTED';
        }
        
        options += '<option value="' + data[i].id + '" ' + selected + '>' + data[i].description + '</option>';
      }
      
      $('select#PPI-Stage-Status-Search').html(options);
    });
  });
  
  $("#PPI-Stage-Status-Search").change(function()
  {
    $("#PPI-Stage-Status-Selected").val($("#PPI-Stage-Status-Search").val());
  })
	
	$('#addNote').click(function() {
	   
	   var clientID = $(this).attr('rel');
	   
	   var $newDialog = $('<div><p>Please add your note in the box below.</p><form id="addNoteForm" method="post" action="/crm/add_note/" style="margin: 0px; padding: 0px;"><input type="hidden" name="clientID" value="' + clientID + '"><p><textarea name="note" style="margin-top: 5px;width: 460px; height: 140px;"></textarea></p></form></div>');
	
	   $newDialog.dialog( { 
	       autoOpen: false, 
	       modal: true, 
	       resizable: false,
	       width: 500,
	       height: 300,
	       title: "Add a Note!",
	       buttons: 
	           [ 
	               { 
	                   text: "Save", 
	                   click: function() { 
	                       $( '#addNoteForm' ).submit(); 
	                   } 
	               },
	               { 
	                   text: "Cancel", 
	                   click: function() { 
	                       $( this ).dialog( "close" ); 
	                   } 
	               }
	           ] 
	       });
	
	   $newDialog.dialog( "open" );
	   
	});
  
  // -- Add a new Correspondance
  // ---------------------------
  
  $('#addPPICorrespondence').click(function()
  {
    var clientID = $(this).attr('rel');
    //var $newDialog = $('<div><form id="addPPICorrespondenceFrom" method="post" action="/crm/ppi/add_claim/" style="margin: 0px; padding: 0px;"><input type="hidden" name="clientID" value="' + clientID + '"><p>Disposision</p><select name="PPI_Disposition" style="width:460px;"><option value="-1">-- Select --</option>' + dispositionList() + '</select></form></div>');
    
    $('#Correspondence-Dialog').dialog( { 
     autoOpen: false, 
     modal: true, 
     resizable: false,
     width: 510,
     height: 330,
     title: "Add a Correspondance!",
     buttons: 
       [ 
           { 
               text: "Save", 
               click: function() {
                   $( '#addPPICorrespondenceForm' ).submit(); 
               } 
           },
           { 
               text: "Cancel", 
               click: function() { 
                   $( this ).dialog( "close" ); 
               } 
           }
       ] 
     });
	
	   $('#Correspondence-Dialog').dialog( "open" );
  });
  
  // -- PPI Pack In Check List
  // -------------------------
  
  
	
	$('.reprintPack').click(function() {
	
	   var clientID = $(this).attr('rel');
	
	   var url = '/crm/ppi/reprint_pack/' + clientID + '/';
	   $("#print_pack_image_"+clientID).attr('src', "/assets/img/lightspinner.gif");
	   $.getJSON(url, function(data) {
	       if (data['status'] == "done")
	       {
    	       alert("Pack has been sent to the printer, scheduled on " + data['schedule'] + '.');
    	       $("#print_pack_image_"+clientID).attr('src', "/assets/img/icons/print.gif");
	       }
	   });
	});
	
	
	$('.packReturned').click(function() {
	
	   var clientID = $(this).attr('rel');
	
	   var url = '/crm/ppi/pack_received/' + clientID + '/';
	   $("#pack_returned_image_"+clientID).attr('src', "/assets/img/lightspinner.gif");
	   
     $.getJSON(url, function(data) {
	       if (data['status'] == "done")
	       {
	         
	         $("#PPI-Packin-Check-Dialog").dialog(
           {
             autoOpen: false, 
    	       modal: true, 
    	       resizable: false,
    	       width: 500,
    	       height: 400,
    	       title: "Pack Document Checklist!",
             /*
             open: function()
             {
               $('#PPI-Packin-Check-Dialog').load('/crm/reports/ppi/chase');
             },
             */
    	       buttons: 
    	           [ 
    	               { 
    	                   text: "Save", 
    	                   click: function() { 
    	                       $( '#ppiPackInCheckListForm' ).submit();
    	                   } 
    	               },
    	               { 
    	                   text: "Cancel", 
    	                   click: function() { 
    	                       $( this ).dialog( "close" );
                             location.reload(); 
    	                   } 
    	               }
    	           ] 
    	       });
             
             $("#PPI-Packin-Check-Dialog").dialog('open');
             
	       }
	   });
	});
  
  function packDocumentCheckList()
  {
    
  }
	
	
	$('#clientIDButton').click(function() {
    	var url = '/crm/view_client/' + $("#clientID").val() + '/';
    	$(location).attr('href', url);
    	
    	return false;
	});
	
	
	
	
	
	$('#findReferralForm').submit(function() {
		if ($('#referralID').val().length > 0)
		{
			$("#referralFalse").hide();
			$(location).attr('href','/crm/ppi/referral/'+$('#referralID').val());
		}
		else
		{
			$("#referralFalse").show();
		}
		
		return false;
	});
	
	
	
	
	
	$('#deadClientButton').click(function() {
		
		$.post('/crm/ppi/dead_client/'+referralID+'.json',
		$('#referralDetails').serialize()+'&'+$('#creditorList').serialize()+'&'+$('#deadClientForm').serialize(), 
		function(data){
			if (data['status'] == 'SUCCESS')
			{
			    if (data['disposition'] == 3 || data['disposition'] == 4)
			    {
    			    $(location).attr('href','/crm/ppi/referrals/');
			    }
			    else
			    {
    			    $(location).attr('href','/crm/ppi/referral/'+data['referralID']);
			    }
			}
		});
		
	});
	
	$('#sendPackButton').click(function() {
		
		$('#hideButtonLoading').show();
		
		$.post('/crm/ppi/create_client/'+referralID+'.json',
		$('#referralDetails').serialize()+'&'+$('#creditorList').serialize(), 
		function(data){
			if (data['status'] == 'SUCCESS')
			{
				$(location).attr('href','/crm/ppi/referral/'+data['referralID']);
			}
			else
			{
				alert('Packing out Client has failed - Please contact the IT department.');
				$('#hideButtonLoading').hide();
			}
		});
		
	});
	
	$('#callBackButton').click(function() {
		
		$.post('/crm/ppi/create_callback/'+referralID+'.json',
		$('#referralDetails').serialize()+'&'+$('#creditorList').serialize()+'&datetime='+$('#callBackInfo').val(), 
		function(data){
			if (data['status'] == 'SUCCESS')
			{
				alert('Call Back for this referral has been set! Referral ID is: '+data['referralID'] );
				$(location).attr('href','/crm/ppi/referrals/');
			}
		});
		
	});
	
	$('#drReferralButton').click(function() {
		
		$.post("/crm/ppi/create_debtsolv_referral/"+referralID+".json",
		$('#referralDetails').serialize()+'&'+$('#creditorList').serialize()+'&'+$('#deadClientForm').serialize(), 
		function(data){
			alert("Client has been transferred to Debtsolv, ClientID is : " + data['clientID']);
			$(location).attr('href','/crm/ppi/referral/'+data['referralID']);
		});
		
		
	});
	
	
	$('#addCreditorButton').click(function() {
		add_creditor();
	});  
	
	
	function add_creditor()
	{
		$newCreditor = $("<div style='margin-bottom: 20px;' class='clearfix'></div>").html('<div class="row-fluid"><div class="span12"><select class="large" name="creditor_'+creditorCurrent+'_choice" id="creditor_'+creditorCurrent+'_choice"><option id="0">-- Unknown Creditor</option>'+creditorSelectBox+'</select></div></div><div class="clearfix"></div><div class="row-fluid" style="margin-top: 10px;"><div class="half-block"><input type="text" class="large" name="creditor_'+creditorCurrent+'_account_number" placeholder="Account Number"></div><div class="half-block clearrm"><input type="text" class="large" name="creditor_'+creditorCurrent+'_sort_code" placeholder="Sort Code"></div></div><div class="clearfix"></div><div class="row-fluid" style="margin-top: 10px;"><div class="half-block"></div><div class="half-block clearrm"><input type="text" class="large" placeholder="Value of Debt" name="creditor_'+creditorCurrent+'_value"></div></div><div class="clearfix"></div>');
		
		$('#creditorList').append($newCreditor);
    $('#saveNewCreditor').show();

		creditorCurrent++;
	
	
	}
  
  function dispositionList()
  {
    // -- Return a list of Dispositions
    // --------------------------------
    var output = [];
    
    $.ajax({
      url: '/crm/referrals/listdispositions/',
      dataType: 'json',
      success: function(data)
      {
        if(data)
        {
          output.push('hello');
          // -- loop through and make options
          // --------------------------------
          //$.each(data, function(key, val)
         // {
            //output.push('<option value="' + val['id'] + '">' + val['description'] + '</option>');
          //  output.push('Hello');
          //});
        }
      }
    });
    
    return output;
  }
  
  
  function returnCreditorListSelect()
  {
    // -- Return a list of creditors in a select option
    // ------------------------------------------------
    //$.ajax(
    //  url: '/crm/creditor/creditorlist/',
    //  );
  }
	
});