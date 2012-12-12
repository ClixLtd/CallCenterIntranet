$(function () {
	
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
		{ reasonID: $('#deadClientReason').val() }, 
		function(data){
			if (data['status'] == 'SUCCESS')
			{
				location.reload();
			}
		});
		
	});
	
	$('#sendPackButton').click(function() {
		
		$.post('/crm/ppi/create_client/'+referralID+'.json',
		$('#referralDetails').serialize()+'&'+$('#creditorList').serialize(), 
		function(data){
			if (data['status'] == 'SUCCESS')
			{
				location.reload();
			}
			else
			{
				alert('Packing out Client has failed - Please contact the IT department.');
			}
		});
		
	});
	
	$('#callBackButton').click(function() {
		
		$.post('/crm/ppi/create_callback/'+referralID+'.json',
		$('#referralDetails').serialize()+'&'+$('#creditorList').serialize()+'&datetime='+$('#callBackInfo').val(), 
		function(data){
			if (data['status'] == 'SUCCESS')
			{
				alert('Call Back for this client has been set!');
				$(location).attr('href','/crm/ppi/referrals/');
			}
		});
		
	});
	
	$('#drReferralButton').click(function() {
		
		$.getJSON("/crm/ppi/create_debtsolv_referral/"+referralID+".json", function(json) {
			alert("Client has been transferred to Debtsolv, ClientID is : " + json['clientID']);
			location.reload();
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