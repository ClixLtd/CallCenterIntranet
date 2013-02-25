function getReport()
{
    $('#loading_data').fadeIn();
    
    var leagueNames = ["Premier League","Championship","League 1","League 2","Conference League"];
    
    var playersPerLeague = 5;
    var leagueZeroName = "Premier League";
    var currentLeague = 0;
    var fullCode = [];
    var currentPlayer = 1;
    var leagueDetails = [];

    $.getJSON(reportURL, function(data) {
        
        $.each(data['report'], function(key, val) {
            
            if (currentPlayer == 1)
            {
                var leagueName = leagueNames[currentLeague];
                leagueDetails.push('<li class="league" id="' + leagueName.toLowerCase().split(' ').join('_') + '"><ul>');
                leagueDetails.push("<li class='title'>" + leagueName + "</li>");
            }
            
            leagueDetails.push("<li><ul><li>" + val['name'] + "</li><li>" + val['referrals'] + "</li><li>" + val['packouts'] + "</li><li>" + val['points'] + "</li></ul></li>");
            
            
            if (currentPlayer == playersPerLeague && currentLeague < leagueNames.length-1)
            {
                leagueDetails.push('</ul></li>');
                fullCode.push(leagueDetails.join(""));
                leagueDetails = [];
                currentLeague++;
                currentPlayer = 1;
            }
            else
            {
                currentPlayer++;
            }

        });
        
        if (currentPlayer < playersPerLeague)
        {
            leagueDetails.push('</ul></li>');
            fullCode.push(leagueDetails.join(""));
        }
        
        $("#telesalesList").html('<ul>' + fullCode.join("") + '</ul>');
        $('#loading_data').fadeOut();
        
    });
    
}
    
$(function () {
    
    getReport();
    setInterval(function() {
        getReport();
    }, 30000);
    
    $('#callCenter').change(function() {
        reportURL = ($(this).val() == "ALL") ? "/reports/get_telesales_report.json" : "/reports/get_telesales_report/" + $(this).val() + ".json";
        
                
        getReport();
    });
    
});