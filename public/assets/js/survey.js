$(function () {
	
	//var portalAddress = "https://intranet.gregsonandbrooke.co.uk/crm/portal/";
  var portalAddress = "http://callcenterintranet.clix.dev/survey/";
	var decisionMade = false;
	var questionArray = [];
	
	
	
	/*
	$(".questionSelect").change(function(){
		
		if ( $(this).val() != "-- Select" )
		{
			questionArray[$(this).attr('name').replace("form-q","")] = true;
			
			$("#"+$(this).attr('name')).fadeTo('fast',0.5);
		}
		else
		{
			questionArray[$(this).attr('name').replace("form-q","")] = false;
			$("#"+$(this).attr('name')).fadeTo('fast',1);
		}
		
		
		if ( countTrue() == $(".questionSelect").length && !decisionMade)
		{
			// Lets show the continue button.
			$("#mailMessage").fadeIn(300);
			$("#errorMessage").hide();
			//$("#ppiChecker").animate({bottom: '0'}, 300);
		}
		else
		{
			// Make sure we haven't shown the continue button.
			//$("#ppiChecker").animate({bottom: '-60'}, 300);
		}
		
		
		
		
		// Count all the forms to make sure they have been filled in
		function countTrue() {
			var runningTotal = 0;
			$.each(questionArray, function(index, value) {
				if (value === true)
				{
					runningTotal++;
				}
			});
			return runningTotal;
		}
		
	});
	*/
  
	$("#saveButton").click(function()
  {    
		$("#mailMessage").hide();
		$("#errorMessage").hide();
		$("#validateSpinner").fadeIn(300);
		
		$.ajax({
		  url: portalAddress + "save/" + apiKey + "/" + surveyID + ".jsonp",
      contentType: 'application/json',
      dataType: "JSONP",
      data: ($("#SurveyForm").serialize() + "&" + $('#vicidial_form', window.parent.document).serialize()),
      cache: false,
      success: function(data)
      {
        var html = '';
        
  			$(".decisionPopup").animate({bottom: '-200'},300);
  		
  			$("#validateSpinner").fadeOut(300);
  			//$("#ppiChecker").animate({bottom: '-60'}, 300);
  			
  			if (data['status'] == "FAIL")
  			{
  				$("#errorMessage").html(data["message"]).fadeIn();
  				$("#ppiChecker").animate({bottom: '0'}, 300);
  				
  			}
        else
        {
          $("#thankYou").animate({bottom: '0'}, 300);
          $('#saveButton').hide();
          
          if(data['results'].length > 0)
          {
            $.each(data['results'], function(index, value)
            {
              html += '<li>' + value['product_name'] + '</b></li>';
            });
            
            $("#drClientID").html(html);
  					$("#drClient").animate({bottom: '0'}, 300);
          }
        }
        /*
  			else
  			{
  				// Display the correct submission and the returned ID
  				
  				if (data['client_type']['type'] == "DR")
  				{
  					$("#drClientID").html(data['client_type']['clientID']);
  					$("#drClient").animate({bottom: '0'}, 300);
  				}
  				else
  				if (data['client_type']['type'] == "PPI")
  				{
  					$("#ppiClientID").html(data['client_type']['clientID']);
  					$("#ppiClient").animate({bottom: '0'}, 300);
  				}
  				else
  				if (data['client_type']['type'] == "DONE")
  				{
  					$("#thankYou").animate({bottom: '0'}, 300);
  				}
  				
  				decisionMade = true;
  				$(".questionSelect").attr('disabled', 'disabled');
  				
  			}
  			*/
  		}
    });
		
		
		return false;
	});
	
	
});