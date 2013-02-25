function getReport()
{
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
                var leagueName = (currentLeague == 0) ? leagueZeroName : "Division " + currentLeague;
                leagueDetails.push('<li class="league" id="' + leagueName.toLowerCase().split(' ').join('_') + '"><ul>');
                leagueDetails.push("<li class='title'>" + leagueName + "</li>");
            }
            
            leagueDetails.push("<li><ul><li>" + val['name'] + "</li><li>" + val['referrals'] + "</li><li>" + val['packouts'] + "</li><li>" + val['points'] + "</li></ul></li>");
            
            
            if (currentPlayer == playersPerLeague)
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
        
    });
    
}
    
$(function () {
    
    getReport();
    setInterval(function() {
        getReport();
    }, 30000);
    

    
});