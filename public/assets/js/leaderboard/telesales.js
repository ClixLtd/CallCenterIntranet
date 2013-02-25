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
                leagueDetails.push("<li class='title'>" + leagueName + "</li>");
            }
            
            leagueDetails.push("<li><ul></ul></li>");
            
            
            if (currentPlayer == playersPerLeague)
            {
                fullCode.push(leagueDetails.join(""));
            }
            
            currentPlayer++;
            
        });
        
    });
    
    console.log(fullCode.join(""));

}
    
$(function () {
    
    getReport();
    setInterval(function() {
        getReport();
    }, 30000);
    

    
});