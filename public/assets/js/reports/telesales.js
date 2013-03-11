$(function () {

    getReport();

    $('#month').change(function() {
        changeSituation();
    });

    $('#callCenter').change(function() {
        changeSituation();
    });

    $('.userClick').live("click", function() {
        var user = $(this).attr('rel');
        $('#subDetails' + user).slideToggle('fast');
    });
    
    
    
    
    function changeSituation()
    {
    
        currentCenter = ($('#callCenter').val() == "ALL") ? "/ALL" : "/" + $('#callCenter').val();
        
        currentDate = ($('#month').val() == "THISMONTH") ? "" : "/" + $('#month').val();
        
        
        reportURL = "/reports/get_telesales_report" + currentCenter + "" + currentDate + ".json";
        
        newUrl = '/reports/telesales_report' + currentCenter + "" + currentDate + '/';
        
        
        window.history.pushState('', document.title, newUrl);
                
        getReport();

    }
    
    
    
    $('#submitNewValues').click(function() {
        
        
        var postUrl = (currentCenter == "ALL") ? "/reports/save_telesales_values.json" : "/reports/save_telesales_values/" + currentCenter + ".json";

        $.post(postUrl,
		$('#centerValues').serialize(), 
		function(data){
			if (data['status'] == 'SUCCESS')
			{
			    getReport();
			}
			else
			{
    			alert('Updating values failed. Please submit a support ticket with a screenshot!');
			}
		});


    });
    
    
    
    
    

    function getReport()
    {
        $('#loading_data').fadeIn();
        
        $.getJSON(reportURL, function(data) {
            var items = [];
            var titleList = [];
            var altChoice = 1;
            
            
            $.each(data['centerVals'], function(key, val) {
                $('input[name=' + key + ']').val(val);
            });
            
            
            $.each(data['titles'], function(key, val) {
            
                titleList.push('<li>' + val + '</li>');
                
            });
            
            items.push( '<ul class="titles">' + titleList.join('') + '</ul>' );
            
            
            $.each(data['report'], function(key, val) {
                
                var fullList = [];
                
                var userID = key;
                
                $.each(val, function(keys,vals) {
                    var allReferrals = [];
                    if (keys == 'allReferrals')
                    {
                        
                        allReferrals.push('<li><ul class="titles"><li>Name</li><li>Leadpool ID</li><li>List Name</li><li>Status</li><li>DI</li><li>Product</li><li>Referred</li><li>Last Contact</li><li>Callback</li></ul></li>');
                        
                        var altSinChoice = 1;
                            
                        $.each(vals, function(refkey, refval) {
                            var singleList = [];
                            
                            $.each(refval, function(sinkey, sinval) {
                                singleList.push('<li>' + sinval + '</li>');
                            });
                            
                            allReferrals.push('<li><ul class="alt' + altSinChoice + '">' + singleList.join('') + '</ul></li>');
                            
                            altSinChoice = (altSinChoice==1) ? 2 : 1;
                        });
                        
                        fullList.push('<li class="subDetails" id="subDetails' + userID + '"><ul>' + allReferrals.join('') + '</ul></li>');
                    }
                    else
                    {
                        fullList.push('<li>' + vals + '</li>');
                    }
                });
                
                items.push( '<ul class="alt' + altChoice + ' userClick" rel="' + userID + '">' + fullList.join('') + '</ul>' );
                
                altChoice = (altChoice==1) ? 2 : 1;
                
            });
            
            
            $('#telesalesList').html('<ul class="allTelesales">' + items.join('') + '</ul>');
            
            $('#loading_data').fadeOut();
                        
        });
    
    }

});