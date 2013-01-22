$(function () {
	
	
	
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
    	       location.reload();
	       }
	   });
	});
	
	
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

		creditorCurrent++;
	
	
	}
	
});