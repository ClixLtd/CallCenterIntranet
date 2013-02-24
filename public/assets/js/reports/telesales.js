$(function () {

    $.getJSON('/reports/get_telesales_report/GAB.json', function(data) {
        var items = [];
        
        $.each(data['report'], function(key, val) {
            
            var fullList = [];
            
            $.each(val, function(keys,vals) {
                fullList.push('<li>' + vals + '</li>');
            });
            
            
            items.push( '<ul class="alt1">' + fullList.join('') + '</ul>' );
            
            
            
        });
        
        $('<ul/>', {
            'class': 'allTelesales',
            html: items.join('')
        }).appendTo('#telesalesList');
        
        
    });

});