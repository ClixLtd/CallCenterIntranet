$(function () {

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
        
        $('<ul/>', {
            'class': 'allTelesales',
            html: items.join('')
        }).appendTo('#telesalesList');
        
        
    });

});