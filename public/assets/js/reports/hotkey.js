$(function() {

    $(document).ajaxStart(function(){
        $('#loading_data').fadeIn();
    }).ajaxComplete(function() {
        $('#loading_data').fadeOut();
    });

    var reportUrl = '/reports/get_hotkey_report.json';

    getReport();

    //displays drill down 
    $('.userClick').live('click', function(e){
        $(this).find('.subDetails').slideToggle();
    });


    function getReport()
    {

        $.ajax({
            'url'       : reportUrl,
            'type'      : 'GET',
            'dataType'  : 'json',
            'success'   : function(data)
            {
                var holder = $('<ul>').addClass('allTelesales').css('display','none');

                //titles
                var titles = $('<ul>').addClass('titles');
                $(data.title).each(function(key, val){
                        titles.append($('<li>').text(val));
                });
                holder.append(titles);

                //list content
                var i = 0;
                var tClass = 'alt1';
                for( key in data.list )
                {
                    var h = $('<ul>').addClass(tClass + ' userClick');
                    tClass = (tClass == 'alt2')?'alt1':'alt2';
                    h.append($('<li>').addClass(tClass).html(key));

                    //sub menu
                    var sub = $('<ul>');

                    sub.append($('<li>').append(
                        $('<ul>').addClass('titles').append(
                            $('<li>').html('Status'),
                            $('<li>').html('Total')
                        )
                    ));

                    var tClass1 = (tClass == 'alt2')?'alt1':'alt2';
                    $(data.list[key]).each(function(k, v){
                        var tmp = $('<li>').html($('<ul>'));
                        $(v).each( function( k1, v1){
                            $(tmp).find('ul').addClass(tClass1).append($('<li>').html(v1));
                        });
                        sub.append(tmp);
                    });

                    h.append($('<li>').addClass('subDetails').html(sub));
                    holder.append(h);
                }

                $('#telesalesList').html(holder.fadeIn());
            }
        }).fail(function(o, s, m){
            alert('Error: An error occurred please try again later.')
        });
    }

    $('#grepHotkey').submit(function(e){
        e.preventDefault();

        var start = ($('#startdate').val() != '')? '/'+ $('#startdate').val():'';
        var end   = ($('#enddate').val() != '')?   '/' + $('#enddate').val():'';
        var agent = ($('#agent').val() != -1)? '/' + $('#agent').val():'';

        if(agent)
            reportUrl = '/reports/get_hotkey_report/agent' + agent + start + end + '.json';
        else
            reportUrl = '/reports/get_hotkey_report' + start + end + '.json';

        getReport();
    });
})