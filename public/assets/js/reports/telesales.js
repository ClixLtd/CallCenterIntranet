$(function () {

    getReport();

    $('#callCenter').change(function() {
        reportURL = ($(this).val() == "ALL") ? "/reports/get_telesales_report.json" : "/reports/get_telesales_report/" + $(this).val() + ".json";
        
                
        getReport();
    });

    function getReport()
    {
        
        $.getJSON(reportURL, function(data) {
            var items = [];
            var titleList = [];
            
            $.each(data['titles'], function(key, val) {
            
                
                titleList.push('<li>' + val + '</li>');
                
            });
            
            items.push( '<ul class="titles">' + titleList.join('') + '</ul>' );
            
            
            $.each(data['report'], function(key, val) {
                
                var fullList = [];
                
                $.each(val, function(keys,vals) {
                    fullList.push('<li>' + vals + '</li>');
                });
                
                items.push( '<ul class="alt1">' + fullList.join('') + '</ul>' );
                
            });
            
            
            $('#telesalesList').html('<ul class="allTelesales">' + items.join('') + '</ul>');
                        
        });
    
    }

});