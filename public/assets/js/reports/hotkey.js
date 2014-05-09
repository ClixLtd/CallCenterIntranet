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
        $.get(reportUrl, function(data) {

            var holder = $('<ul>').attr('id', 'main');
            
            //pops titles
            var titles = $('<ul>').addClass('rows titles');
            $(data['title']).each( function(i,v){titles.append($('<li>').html(v))});
            
            var kk = 0, tClass = 'odd';
            holder.append(titles, $('<ul>').addClass('content rows'));
            for(intro in data['list'] )
            {   
                tClass = (tClass == 'even')?'odd':'even';
                var row = $('<ul>').addClass('rows trigger ' + tClass).attr('data-trigger', ++kk);
                row.append($('<li>').html(intro));

                //titles
                var sub = $('<li>').html($('<ul>').addClass('rows titles')).addClass('subDetails').css('display', 'none').attr('data-target', kk);
                sub.find('ul').append(
                    $('<ul>').addClass('rows').append(
                        $('<li>').html('Disposition'),
                        $('<li>').html('Count'),
                        $('<li>').html('DI Total')
                    )
                );
                
                //Disposition
                var dispCls = 'even';
                for(dispo in data['list'][intro])
                {
                    dispCls = (dispCls == 'even')?'odd':'even';
                    var tClsSub = 'even';
                    var refSub = $('<li>').html($('<ul>').addClass('rows titles')).addClass('subDetails ').css('display', 'none').attr('data-target', ++kk);
                    //Client Title Rows
                    $(refSub).find('.titles').append(
                        $('<li>').html('Lead ID'),
                        $('<li>').html('Client ID'),
                        $('<li>').html('Client Name'),
                        $('<li>').html('DI Amount'),
                        $('<li>').html('Company')
                    );
                    //Client rows
                    $(data['list'][intro][dispo]['item']).each( function(a,b) {
                        tClsSub = (tClsSub == 'even')?'odd':'even';
                        $(refSub).append($('<ul>').append(
                            $('<li>').html($('<span>').html(b[0])),
                            $('<li>').html($('<span>').html(b[1])),
                            $('<li>').html(b[2]),
                            $('<li>').html(b[3]),
                            $('<li>').html(b[4])
                        ).addClass('rows ' + tClsSub))
                    });
                    
                    //Disposition Rows
                    sub.append($('<ul>').addClass('rows trigger ' + dispCls).append(
                        $('<li>').html(dispo),
                        $('<li>').html(data['list'][intro][dispo]['item'].length),
                        $('<li>').html('&pound;' + parseFloat(data['list'][intro][dispo]['total']).toFixed(2)),
                        refSub
                        ).attr('data-trigger', kk));
                }
                
                row.append(sub);
                holder.find('ul.content').append(row);
            }
            
            $('#response').css('display','none').html(holder).fadeIn();
            
        }, 'json').fail(function(o,s,m){console.log(s + ': ' + m)})
    }

    $(document).on("click", ".trigger", function(e){$("li[data-target=" + $(this).attr('data-trigger') + "]").slideToggle();e.stopPropagation()})

    $(document).on("click", "li span", function(e){
        e.stopPropagation();
    })


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