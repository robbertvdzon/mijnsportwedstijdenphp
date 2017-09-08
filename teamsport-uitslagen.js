/*************************************************
 *
 **************************************************/
function loadGames() {
	var competitionID = document.getElementById('selectcompetition2').value;
	loadGames2(competitionID);
}



function loadGames2(competitionID) {
    var JSONObject = new Object;
    JSONObject.request = "loadGames";
    JSONObject.competitionID = competitionID;

    ts_runAjax(JSONObject, function onSuccess(resultJSON) {
        loadGamesData(resultJSON.result, false);
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1763T-->Fout bij ophalen van de wedstrijden<!--T1763T-->", resultJSON.errorMsg);
    }, false);
}


/*************************************************
 *
 **************************************************/
function loadGamesData($games, initialCall) {
	var resultText = "<table id=dualcolortable cellspacing='0'>";
	resultText += "<tr height=25><td><b><!--T1764T-->Wedstrijd<!--T1764T--></b></td><td width=10></td><td><b><!--T1765T-->Datum<!--T1765T--></b></td><td width=10></td><td><b><!--T1766T-->Tijd<!--T1766T--></b></td><td width=10></td><td><b><!--T1767T-->Uit/thuis<!--T1767T--></b></td><td width=10></td><td><b><!--T1768T-->Eindstand<!--T1768T--></b><td width=10></td><td><b><!--T1769T-->Punten<!--T1769T--></b></td><td width=10></td><td></td></tr>";
	var currentDate = new Date();
	for(var index = 0; index < $games.length; index++) {
		var item = $games[index];
		var gameDate = new Date(item.gamedate * 1000);
		if (currentDate<=gameDate) continue;
		var gameteams = item.opponent +" - "+initialSelectedTeamName;
		var homegame = "<!--T1770T-->uit<!--T1770T-->";
		if (item.homegame==1){
			gameteams = initialSelectedTeamName+" - "+item.opponent;
            homegame = "<!--T1771T-->thuis<!--T1771T-->";
		}
	
		resultText += "<tr height=25><td>" + gameteams + "</td><td></td><td>" + ts_getDateDate(gameDate) + "</td><td></td><td>" + ts_getDateTime(gameDate) + "</td><td></td><td>"+homegame+"</td><td></td><td>"+item.score+"</td><td></td><td>"+item.points+"</td>";
        resultText += "<td></td><td><img src='images/edit.png' title='<!--T1772T-->Open wedstrijd<!--T1772T-->' onclick='ts_changeSection(\"wedstrijd\","+item.id+");' height=15px style='cursor: pointer;'>";
        resultText += "&nbsp;&nbsp;";
        resultText += "<img src='images/delete.png' title='<!--T1773T-->Verwijder wedstrijd<!--T1773T-->' onclick='deleteGame("+item.id+");'  height=15px style='cursor: pointer;'>";
        resultText += "&nbsp;&nbsp;";
        resultText += "</td></tr>";
        
	}
	resultText += "</table>";
	document.getElementById('gamelist').innerHTML = resultText;
	
    // Make the rows dual color
    var table = document.getElementById("dualcolortable");
    for (var i = 0, row; row = table.rows[i]; i++) {
        if ((i % 2 == 0)){
            row.className  = "dualcolortableRowNoHighlight";
        }
        else{
            row.className  = "dualcolortableRowHighlight";
        }
    }    
}

function deleteGame(gameID) {
    var JSONObject = new Object;
    JSONObject.request = "deleteGame";
    JSONObject.gameID = gameID;
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        loadGames();
    }, function onError(resultJSON) {
    }, false);    
}


function loadCompetitionsData(competitions, initialCall) {
    var select = document.getElementById('selectcompetition2');
    if(select==null) return;

    if(competitions.length == 0) {
        // no team found
        var theOption = new Option;
        theOption.text = "<!--T1774T-->Geen competities gevonden<!--T1774T-->";
        theOption.value = -1;
        select.options[0] = theOption;
    }

    for(var index = 0; index < competitions.length; index++) {
        var item = competitions[index];
        var theOption = new Option;
        theOption.text = item.season;
        theOption.value = item.id;
        theOption.selected = initialSelectedCompetition == item.id;
        select.options[index] = theOption;
    }
   
    if(!initialCall) {
        loadGames();
    }
}   


function competitionSelect() {
	loadGames();
}

/*************************************************
 *
 **************************************************/
function openNewGame() {

    var competitionID = document.getElementById('selectcompetition2').value;
    if (competitionID==-1){
        ts_showGlobalError("<!--T1775T-->Fout<!--T1775T-->", "<!--T1776T-->Er is nog geen competitie aangemaakt.<br>Maak eerst een competitie en voeg daarna een wedstrijd toe.<!--T1776T-->");
    }
    else{
    	document.getElementById('newGame').style.display = '';
    	document.getElementById('newGameDate').value = "";
        document.getElementById('newGameOpponent').value = "";
        document.getElementById('newHomegame').checked = false;
        document.getElementById('newGameDate').focus();
    }
    
}

/*************************************************
 *
 **************************************************/
function addGame() {

	document.getElementById('newGame').style.display = 'none';

	var competitionID = document.getElementById('selectcompetition2').value;
	var gameDate = document.getElementById('newGameDate').value;
    var javascriptDateStr = gameDate.replace( /(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3") ;
	var newGameTime = document.getElementById('newGameTime').value;

	var dateTime = javascriptDateStr + " " + newGameTime;
    var gameOpponent = document.getElementById('newGameOpponent').value;
    var homegame = document.getElementById('newHomegame').checked;
	var JSONObject = new Object;
	JSONObject.request = "addGame";
	JSONObject.competitionID = competitionID;
	JSONObject.gameDate = dateTime;
    JSONObject.gameOpponent = gameOpponent;
    JSONObject.homegame = homegame;
	JSONObject.teamID = initialSelectedTeamID;
	ts_runAjax(JSONObject, function onSucces(resultJSON) {
		loadGames();
	}, function onError(resultJSON) {
		ts_showGlobalError("<!--T1777T-->Fout<!--T1777T-->", resultJSON.errorMsg);
	}, false);
}


/*************************************************
 *
 **************************************************/
function importFromTeamersOpen() {
    document.getElementById('importFromTeamersPage1').style.display = '';
}


var itemsFromTeamersFound = 0;
/*************************************************
 *
 **************************************************/
function importFromTeamersStep1() {
    document.getElementById('importFromTeamersPage1').style.display = 'none';

    var url = document.getElementById('importTeamersURL').value;
    var JSONObject = new Object;
    JSONObject.request = "importFromTeamers";
    JSONObject.url = url;
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        
        var resultText = "<table cellspacing='0'>";
            resultText += "<tr>";
            resultText += "<td><b>team</b></td>";
            resultText += "<td width=10></td>";
            resultText += "<td><b>uit/thuis</b></td>";
            resultText += "<td width=10></td>";
            resultText += "<td><b>datum</b></td>";
            resultText += "<td width=10></td>";
            resultText += "<td><b>time</b></td>";
            resultText += "<td></td>";
            resultText += "</tr>";

        var competitionFound = false;
        itemsFromTeamersFound = resultJSON.result.length;
        for(var index = 0; index < resultJSON.result.length; index++) {
            competitionFound = true;
            var item = resultJSON.result[index];

            resultText += "<tr height=20>";
            resultText += "<td><input id=opponent_"+index+" value='" + item.opponent + "'></td>";
            resultText += "<td></td>";
            resultText += "<td><input id=uitthuis_"+index+" value='" + item.uitthuis + "'></td>";
            resultText += "<td></td>";
            resultText += "<td><input id=date_"+index+" value='" + item.date + "'></td>";
            resultText += "<td></td>";
            resultText += "<td><input id=time_"+index+" value='" + item.time + "'></td>";
            resultText += "<td></td>";
            resultText += "</tr>";
                        
                        
                        
        }
        
         resultText += "</table>";
         //alert(resultText);
        
        document.getElementById('importFromTeamersGames').innerHTML = resultText;
        
        
        
        document.getElementById('importFromTeamersPage2').style.display = '';
    }, function onError(resultJSON) {
        ts_showGlobalError("Fout", resultJSON.errorMsg);
    }, false);


}

/*************************************************
 *
 **************************************************/
function importFromTeamersStep2() {

   document.getElementById('importFromTeamersPage2').style.display = 'none';
   var competitionID = document.getElementById('selectcompetition2').value;
 
   var JSONObject = new Object;
   JSONObject.games = new Array;
   JSONObject.request = "addGames";
   
   for(var index = 0; index < itemsFromTeamersFound; index++) {
       var opponentField = "opponent_"+index;
       var uitthuisField = "uitthuis_"+index;
       var dateField = "date_"+index;
       var timeField = "time_"+index;
       var opponent = document.getElementById(opponentField).value
       var homegame = document.getElementById(uitthuisField).value=="thuis";
       var gameDate = document.getElementById(dateField).value
       var gameTime = document.getElementById(timeField).value
       var dateDateTime = gameDate + " " + gameTime;      
       JSONObject.games[index] = new Object;
       JSONObject.games[index].gameOpponent = opponent;
       JSONObject.games[index].homegame = homegame;
       JSONObject.games[index].gameDate = dateDateTime;
       JSONObject.games[index].competitionID = competitionID;
       JSONObject.games[index].teamID = initialSelectedTeamID;
    }
    
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        loadGames();
    }, function onError(resultJSON) {
        ts_showGlobalError("Fout", resultJSON.errorMsg);
    }, false);
    
}    
    
    

