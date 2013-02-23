$(function () {

    $.getJSON('/reports/get_telesales_report/GAB.json', function(data) {
        var items = [];
        
        $.each(data['report'], function(key, val) {
            items.push('<li id="' + key + '">' + val + '</li>');
        });
        
        $('<ul/>', {
            'class': 'my-new-list',
            html: items.join('')
        }).appendTo('telesalesList');
    });

});