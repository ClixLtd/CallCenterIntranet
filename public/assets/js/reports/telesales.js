$(function () {

    $.getJSON('/reports/get_telesales_report/GAB.json', function(data) {
        var items = [];
        
        $.each(data['titles'], function(key, val) {
        
            var fullList = [];
            
            fullList.push('<li>' + val + '</li>');
            
        });
        
        items.push( '<ul class="titles">' + fullList.join('') + '</ul>' );
        
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