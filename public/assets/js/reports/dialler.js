var reportUrl = '/reports/get_dialler_report';
$(document).ready(function(){

    $(document).ajaxStart(function(e) {
        $('#loading_data').fadeIn();
    }).ajaxComplete(function(e) {
        $('#loading_data').fadeOut();
    });
    
    getReport();

    function getReport() 
    {
        $.get(reportUrl, function(data){
            
            var holder = $('<ul>').attr('id', 'main').css('display', 'none');

            var titles = $('<ul>').addClass('rows titles');
            titles.append($('<li>').html('Data List'));

            var content = $('<ul>').addClass('rows content');

            var kk =0;
            var tClass = 'even';
            for(src in data)
            {
                tClass = (tClass == 'even')?'odd':'even';

                var row = $('<ul>').addClass('rows trigger ' + tClass );
                row.attr('data-trigger', ++kk);
                row.append($('<li>').text(src));


                //campaign titles
                var camp = $('<li>').css('display', 'none').addClass('subDetails').attr('data-target', kk);
                var campt = $('<ul>').addClass('rows titles');
                campt.append($('<li>').text('Campaign'));
                camp.append(campt);

                //campaign items 
                for(campaign in data[src])
                {
                    camp.append(
                        $('<ul>').addClass('rows trigger').html(
                            $('<li>').text(campaign)
                        ).attr('data-trigger', ++kk)
                    );

                    var lead = $('<li>').addClass('rows subDetails').css('display','none').attr('data-target', kk);
                    lead.append($('<ul>').addClass('rows titles').append(
                        $('<li>').html('Lead ID'),
                        $('<li>').html('Call Date'),
                        $('<li>').html('Result'),
                        $('<li>').html('Agent')
                    ));

                    $(data[src][campaign]).each(function(a,b){
                        lead.append($('<ul>').addClass('rows').append(
                            $('<li>').html($('<span>').text(b.lead_id)),
                            $('<li>').text(b.call_date),
                            $('<li>').text(b.result),
                            $('<li>').text(b.agent)
                        ))
                    });
                    row.append(camp.append(lead));
                }
                content.append(row);
            }
            holder.append(titles, content);
            $('#response').html(holder.fadeIn());
        }, 'json').fail(function(o,s,m){
            alert('Error: '+m);
        })
    }

    $('#grepDialer').submit(function(e){
        e.preventDefault();
        $('#main').fadeOut();
        var start = ($('#startdate').val() != '')?'/'+$('#startdate').val():'';
        var end = ($('#startdate').val() != '')?'/'+$('#startdate').val():'';
        if(start != '')
            reportUrl = '/reports/get_dialler_report' + start + end; 
        else 
            reportUrl = '/reports/get_dialler_report'; 
        getReport();
    })

    $(document).on('click','li span', function(e){e.stopPropagation()});
    $(document).on('click', '.trigger', function(e){$('li[data-target='+$(this).attr('data-trigger')+']').slideToggle();e.stopPropagation()})

});