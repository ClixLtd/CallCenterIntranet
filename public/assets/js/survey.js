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
  
  //$("#drClient").animate({bottom: '0'}, 300);
  //$("#thankYou").animate({bottom: '0'}, 300);  
	$("#saveButton").click(function()
  {    
    if(validate())
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
          else if(data['status'] == 'SUCCESS')
          {
            $("#thankYou").animate({bottom: '0'}, 300);
            $('#saveButton').hide();
            
            $("#Success-Message").html(data['message']);
            $("#LeadpoolID").html('Leadpool ID:<br />' + data['leadpoolID']);
            
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
		
    }
    else
    {
      $("#errorMessage").html('Please answer all the questions in the survey and submit again').fadeIn();
		  $("#ppiChecker").animate({bottom: '0'}, 300);
    }
		
		return false;
	});
	
  /*
  var rebuttalWindow = $("#Rebuttal").dialog({
    width: 550,
    height: 650
  });
  */
  
  $("#RebuttalButton").click(function(e)
  {
    //rebuttalWindow.dialog('open');
    
    if(rebuttalURL != '')
    {
      myWindow=window.open('','MyNewWindow','width=550,height=650,left=200,top=100');
      myWindow.document.write('<html><head><title>Rebuttal Script</title></head><body><iframe width="100%" height="100%" src="' + rebuttalURL + '" seamless></iframe></body></html>');
      myWindow.document.close();
  
      $(".demo").append('<div><input type="button" id="affect_new_window" value="Now click me"/></div>');
      $('#affect_new_window').click(function(e)
      {
        $('p', myWindow.document).text('See the text changed, that is neat and easy.');
          myWindow.focus();
      });
    }
    
  });
});

function validate()
{
  var valid = true;
  
  $(".required").each(function()
  {    
    if($(this).val() == '' || $(this).val() == '-1')
    {
      $(this).addClass('highlight');
      
      valid = false;
    }
    else
    {
      $(this).removeClass('highlight');
    }
  });
  
  return valid;
}