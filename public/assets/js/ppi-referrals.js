$(function () {
  
  var textNumber = 0;
  
  $( "#sendTextMessageDialog" ).dialog({
      autoOpen: false,
      height: 270,
      width: 340,
      modal: true,
      buttons: {
        "Send": function() {
            $.post('/sms/send.json', { to: textNumber, from: "Persolvo", body: $('#sendTextMessageBody').val() }).done(function(data) {
                
                
                if (data.status == "FAIL")
                {
                    alert(data.message);
                }
                else
                {
                    alert(data.message);
                    $('#sendTextMessageBody').val("")
                    $( "#sendTextMessageDialog" ).dialog( "close" );
                }
                
            });
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });

  
  
  
  $('.sendText').click(function() {
  
        textNumber = $(this).attr('id');
        
        $( "#sendTextMessageDialog" ).dialog("open");
      	 
  });
  
  
  
  
  // -- Save Refund Method
  // ---------------------
  $('#saveRefundMethod').click(function()
  {
    var claimID = $(this).attr('rel');
    var methodID = $('#Refund_Method').val();
    var errorMsg = '';
    
    if(methodID == -1)
    {
      errorMsg = 'Select a Refund Method';
    }
    
    if(errorMsg != '')
    {
      alert(errorMsg);
    }
    else
    {
      $.post('/crm/ppi/save_refund_method/' + claimID + '.json',
  		{
  		  method_id: methodID
  		},
  		function(data){
  			if (data['status'] == 'done')
  			{
  				alert('Refund Method has been saved');
          location.reload();
  			}
  			else
  			{
  				alert('Error: Refund method has not been saved');
  			}
  		});
    }
  });
  
  // -- Change the Claim Signatory
  // -----------------------------
  $("#changeSignatory").click(function()
  {
    var newDialog = $("#Change-Signatory-Box").dialog();
    
    newDialog.dialog( { 
       autoOpen: false, 
       modal: true, 
       resizable: false,
       title: "Change Claim Signatory",
       buttons: 
           [ 
               { 
                   text: "Save", 
                   click: function()
                   {
                     $.post('/crm/ppi/change_signatory/0.json',
            		     $('#changeSignatoryForm').serialize(),
                 		   function(data)
                        {
                  			  if (data['status'] == 'done')
                  			  {
                  				  alert("Signatory has been changed");
                            location.reload();
                  			  }
                  			  else
                  			  {
                  				  alert("Error: Signatory couldn't be changed.");
                  			  }
                  		  });
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
  	
  	 newDialog.dialog( "open" );
  });
  
  // -- Print Claim Letter
  // ---------------------
  $('.printPPILetter').click(function()
  {	
     var settings = $(this).attr('rel');
     var settingsArray = settings.split(",");
     
     var letterID = settingsArray[0];
     var claimID  = settingsArray[1];
     var clientID = settingsArray[2];
     var freeText = settingsArray[3];
     
     var newDialog = $("#Print-PPI-Letter-Dialog").dialog();
     
     $("#Letter-Free-Text").val("");
    
     if(freeText == 0)
     {
        $("#Letter-Free-Text-Box").hide();
     }
     else
     {
        $("#Letter-Free-Text-Box").show();
     }

    
     newDialog.dialog( { 
       autoOpen: false, 
       modal: true, 
       resizable: false,
       /*height: auto,*/
       width: 500,
       /*height: 400,*/
       open: function()
       {
         $("#Letter-Free-Text").val("");
         
       },
       title: "Print Letters",
       buttons: 
           [ 
               { 
                   text: "Print", 
                   click: function()
                   {
                       printClaimLetter(letterID, claimID, clientID);
                       $( this ).dialog( "close" );
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
  	
  	 newDialog.dialog( "open" );
	});
  
  // -- Enable Editing of the Partner Details
  // ----------------------------------------
  $("#editClaim").click(function()
  {
    $(".Claim-Edit-Input").removeAttr('readonly');
    $(".Claim-Edit-Input").removeAttr('disabled');
    $(".Claim-Edit-Input").css('box-shadow', '0px 0px 2px #333');
    
    $("#Claim-Amount-Input").val($("#Claim-Amount-Raw").val());
    
    $("#saveClaimDetails").show();
  });
  
  // -- Cancel a Client's PPI Account
  // --------------------------------  
  $("#cancelPPIClient").click(function()
  {
    if(confirm('Are you sure you want to cancel this client?') == true)
    {
      $.getJSON('/crm/ppi/cancel_client/' + $(this).attr('rel'), function(data)
      {
        if(data['status'] == 'SUCCESS')
        {
          alert('Client PPI account has been canceled');
          location.reload();
        }
      });
    }
    else
    {
      return;
    }
  });
  
  // -- Cancel a Client's PPI Account
  // --------------------------------  
  $("#reactivatePPIClient").click(function()
  {
    if(confirm('Are you sure you want reactivate this client?') == true)
    {
      $.getJSON('/crm/ppi/reactivate_client/' + $(this).attr('rel'), function(data)
      {
        if(data['status'] == 'SUCCESS')
        {
          alert('Client PPI account has been reactivated');
          location.reload();
        }
      });
    }
    else
    {
      return;
    }
  });
  
  // -- Edit creditors from the client view
  // --------------------------------------
  $('#editCreditorsButton').click(function()
  {    
    var clientID = $(this).attr('rel');
    
    var newDialog1 = $("#Edit-Creditors-Dialog").dialog();
    
    newDialog1.dialog( { 
	       autoOpen: false, 
	       modal: true, 
	       resizable: false,
	       width: 800,
	       height: 500,
	       title: "Edit Creditors",
	       buttons: 
	           [ 
	               { 
	                   text: "Save Creditors", 
	                   click: function() { 
	                       //$( '#addClaimsForm' ).submit();
                         editCreditors();
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
	
	   newDialog1.dialog( "open" );
     
  });
  
  // -- Create Claims
  // ----------------
  $('#createClaimsButton').click(function()
  {
    var clientID = $(this).attr('rel');
    
    var newDialog2 = $("#Create-Claims-Dialog").dialog();
    
    newDialog2.dialog( { 
	       autoOpen: false, 
	       modal: true, 
	       resizable: false,
	       width: 400,
	       height: 250,
	       title: "Create Claims",
	       buttons: 
	           [ 
	               { 
	                   text: "Create Claims", 
	                   click: function() { 
                         createClaims(clientID); 
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
	
	   newDialog2.dialog( "open" );
  });
  
  // -- Create a new Claim
  // ---------------------
  $("#addNewClaimButton").click(function()
  {
    var clientID = $(this).attr('rel');
    var dialogBox = $("#Create-New-Claim").dialog();
    
    dialogBox.dialog({
      autoOpen: false,
      modal: true,
      width: 600,
      height: 500,
      resizable: false,
      title: "Create a New Claim",
      buttons: 
       [ 
           { 
               text: "Create New Claim", 
               click: function()
               { 
                 var errorMsg = '';
                 
                 if($("#newClaimCreditorChoice").val() == -1)
                   errorMsg = "> Select a Creditor\n";
                   
                 if($("#newClaimSignatory").val() == -1)
                   errorMsg += "> Select a Signatory\n";
                   
                 if($("#newClaimAccountNumber").val() == '')
                   errorMsg += "> Enter an Account number\n";
                   
                 if($("#newClaimValue").val() == '')
                   errorMsg += "> Enter a Value";
                 
                 if(errorMsg == '')
                 {
                   createClaims(clientID, true);
                   
                 }
                 else
                 {
                   alert(errorMsg);
                 }
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
  });
  
  // -- Edit Creditors
  // -----------------

  function editCreditors()
  {
    $.post('/crm/save_creditors/0.json',
		$('#creditorEditFrom').serialize(),
		function(data){
			if (data['status'] == 'done')
			{
				alert('Creditors have been saved');
        location.reload();
			}
			else
			{
				alert('Creditors could not be saved');
			}
		});
  }

function createClaims(clientID, form)
{
  var formData = null;
  
  if(form == true)
  {
    formData = $('#creditorFrom').serialize();
  }
    
  $.post('/crm/ppi/create_claims/' + clientID + '.json',
    formData,
    function(data)
    {
      if (data['status'] == 'SUCCESS')
      {
        alert("Claims Created\n\nDon't forget to send the claim letter for each claim made");
        location.reload();
      }
      else
      {
        alert('Claims could not be created');
      }
   });
}

  // -- Edit creditors from the client view
  // --------------------------------------
  $('#editCreditorButton').click(function()
  {
    var clientID = $(this).attr('rel');
    
    var newDialog = $("#Create-Claims-Dialog").dialog();
    
    newDialog.dialog( { 
	       autoOpen: false, 
	       modal: true, 
	       resizable: false,
	       width: 800,
	       height: 500,
	       title: "Create Claims",
	       buttons: 
	           [ 
	               { 
	                   text: "Create", 
	                   click: function() { 
	                       $( '#addClaimsForm' ).submit(); 
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
	
	   newDialog.dialog( "open" );
  });
  
	$('#PPI-Stage-Search').change(function()
  {
    updatePPIStatusCombo();
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
  
  // -- Add Claim Correspondence
  // ---------------------------
  $('#addPPIClaimCorrespondence').click(function()
  {
    $('#Claim-Correspondence-Dialog').dialog( { 
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
                   $( '#addClaimCorrespondenceForm' ).submit(); 
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
	
	   $('#Claim-Correspondence-Dialog').dialog( "open" );
  });
  
  // -- Change the Claim Stage and Status
  // ------------------------------------
  $("#changeClaimStatus").click(function()
  {
    $('#Claim-Change_stage-status-Dialog').dialog( { 
     autoOpen: false, 
     modal: true, 
     resizable: false,
     width: 510,
     height: 330,
     title: "Change Claim Stage and Status",
     open: function()
     {
       updatePPIStatusCombo();
     },
     close: function()
     {
       
     },
     buttons: 
       [ 
           { 
               text: "Save", 
               click: function() {
                   $( '#changeClaimStageStatusForm' ).submit(); 
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
	
	   $('#Claim-Change_stage-status-Dialog').dialog( "open" );
  });
  
  // -- Add a new Correspondence
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
				$(location).attr('href','/crm/ppi/referral/'+data['referralID'] + '/' + data['clientID']);
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
  
  function updatePPIStatusCombo()
  {
    $.getJSON('/crm/ppi/stage_statues_list/' + $('#PPI-Stage-Search').val(), function(data)
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
  }
  
  // -- Print the selected claim letter
  // ----------------------------------
  function printClaimLetter(letterID, claimID, clientID)
  {     
     $.post('/crm/ppi/print_PPI_letter/' + letterID + '/' + claimID + '/' + clientID + '.json',
      $('#PrintPPILetterForm').serialize(),
      function(data)
      {
        if(data['status'] == "done")
        {
          alert("Letter has been sent to the print queue");
	        $("#print_letter_image_" + letterID).attr('src', "/assets/img/icons/print.gif");
          
          location.reload();
        }
      });
  }
	
	
	function add_creditor()
	{
		//$newCreditor = $("<div style='margin-bottom: 20px;' class='clearfix'></div>").html('<div class="row-fluid"><div class="span12"><select class="large" name="creditor_'+creditorCurrent+'_choice" id="creditor_'+creditorCurrent+'_choice"><option id="0">-- Unknown Creditor</option>'+creditorSelectBox+'</select></div></div><div class="clearfix"></div><div class="row-fluid" style="margin-top: 10px;"><div class="half-block"><input type="text" class="large" name="creditor_'+creditorCurrent+'_account_number" placeholder="Account Number"></div><div class="half-block clearrm"><input type="text" class="large" name="creditor_'+creditorCurrent+'_sort_code" placeholder="Sort Code"></div></div><div class="clearfix"></div><div class="row-fluid" style="margin-top: 10px;"><div class="half-block"></div><div class="half-block clearrm"><input type="text" class="large" placeholder="Value of Debt" name="creditor_'+creditorCurrent+'_value"></div></div><div class="clearfix"></div>');
		$newCreditor = $("<div style='margin-bottom: 20px;' class='clearfix'></div>").html('<div class="row-fluid"><div class="span12"><select class="large" name="creditor_'+creditorCurrent+'_choice" id="creditor_'+creditorCurrent+'_choice"><option id="0">-- Unknown Creditor</option>'+creditorSelectBox+'</select></div></div><div class="clearfix"></div><div class="row-fluid" style="margin-top: 10px;"><div class="half-block"><input type="text" class="large" name="creditor_'+creditorCurrent+'_account_number" placeholder="Account Number"></div><div class="half-block clearrm"><input type="text" class="large" name="creditor_'+creditorCurrent+'_sort_code" placeholder="Sort Code"></div></div><div class="clearfix"></div><div class="row-fluid" style="margin-top: 10px;"><div class="half-block"><select name="creditor_'+creditorCurrent+'_signatory" class="large"><option value="1">Signatory</option><option value="1">Client</option><option value="2">Partner</option><option value="3">Joint</option></select></div><div class="half-block clearrm"><input type="text" class="large" placeholder="Value of Debt" name="creditor_'+creditorCurrent+'_value"></div></div><div class="clearfix"></div><div class="row-fluid" style="margin-top: 10px;"><div class="half-block clearrm"><select name="creditor_'+creditorCurrent+'_debttype" class="large"><option value="0">Type of Debt</option>' + debtType + '</select></div></div>');
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