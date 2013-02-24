$(function () {

    getReport();

    $('#callCenter').change(function() {
        reportURL = ($(this).val() == "ALL") ? "/reports/get_telesales_report.json" : "/reports/get_telesales_report/" + $(this).val() + ".json";
        
                
        getReport();
    });

    function getReport()
    {
        $('#loading_data').fadeIn();
        
        $.getJSON(reportURL, function(data) {
            var items = [];
            var titleList = [];
            var altChoice = 1;
            
            $.each(data['titles'], function(key, val) {
            
                
                titleList.push('<li>' + val + '</li>');
                
            });
            
            items.push( '<ul class="titles">' + titleList.join('') + '</ul>' );
            
            
            $.each(data['report'], function(key, val) {
                
                var fullList = [];
                
                $.each(val, function(keys,vals) {
                    if (keys == 'allReferrals')
                    {
                        
                    }
                    else
                    {
                        fullList.push('<li>' + vals + '</li>');
                    }
                });
                
                items.push( '<ul class="alt' + altChoice + '">' + fullList.join('') + '</ul>' );
                
                altChoice = (altChoice==1) ? 2 : 1;
                
            });
            
            
            $('#telesalesList').html('<ul class="allTelesales">' + items.join('') + '</ul>');
            
            $('#loading_data').fadeOut();
                        
        });
    
    }

});