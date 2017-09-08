/*************************************************
 *
 **************************************************/


function isAdminUser() {
    var teammembers = eval('(' + initialTeammembers + ')');
    for(var index = 0; index < teammembers.length; index++) {
        var item = teammembers[index];
        if (item.userID==currentUserID){
            if(item.admin == "1") return true;
        }
    }
    return false;
}


function checkPermissions(){
    if (isAdminUser()){
        document.getElementById('modifyButton1b').style.display = ""; 
//        document.getElementById('modifyButton2b').style.display = ""; 
        document.getElementById('tip1').style.display = ""; 
        document.getElementById('tip2').style.display = "none"; 
    }
    else{
        document.getElementById('modifyButton1b').style.display = "none"; 
//        document.getElementById('modifyButton2b').style.display = "none"; 
        document.getElementById('tip1').style.display = "none"; 
        document.getElementById('tip2').style.display = ""; 
    }
}


function loadGames() {
	var competitionID = document.getElementById('selectcompetition2').value;
	loadGames2(competitionID);
}

function loadGames2(competitionID) {
    var JSONObject = new Object;
    JSONObject.request = "loadGames";
    JSONObject.competitionID = competitionID;

    ts_runAjax(JSONObject, function onSuccess(resultJSON) {
        loadGamesDataUitslagen(resultJSON.result, false);
        loadGamesDataProgramma(resultJSON.result, false);
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1668T-->Fout bij ophalen van de wedstrijden<!--T1668T-->", resultJSON.errorMsg);
    }, false);
}


function findCurrentTeamMemberID() {
    var teammembers = eval('(' + initialTeammembers + ')');
    for(var index = 0; index < teammembers.length; index++) {
        var item = teammembers[index];
        if (item.userID==currentUserID){
            return item.id;
        }
    }
    return -1;
}


function checkPresentInList(list,memberID) {
    if (list!=null){
        var values = list.split(" ");
        for ( var i=0, len=values.length; i<len; ++i ){
            var userID = values[i];
            if (userID==memberID){
                return true;
            }
        }
    }
    return false;   
}

function setAanwezig(gameID,memberID){
    var JSONObject = new Object;
    JSONObject.request = "setAanwezig";
    JSONObject.gameID = gameID;
    JSONObject.memberID = memberID;
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        loadGames();
    }, function onError(resultJSON) {
    }, false);    
}

function setAfwezig(gameID,memberID){
    var JSONObject = new Object;
    JSONObject.request = "setAfwezig";
    JSONObject.gameID = gameID;
    JSONObject.memberID = memberID;
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        loadGames();
    }, function onError(resultJSON) {
    }, false);    
}

function setOnbekend(gameID,memberID){
    var JSONObject = new Object;
    JSONObject.request = "setOnbekend";
    JSONObject.gameID = gameID;
    JSONObject.memberID = memberID;
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        loadGames();
    }, function onError(resultJSON) {
    }, false);    
}


/*************************************************
 *
 **************************************************/
function loadGamesDataUitslagen($games, initialCall) {
    var resultText = "<table width=750 id=dualcolortable1 cellspacing='0'>";
    resultText += "<tr height=25>";
    resultText += "<td width=250><b><!--T1669T-->Wedstrijd<!--T1669T--></b></td>";
    resultText += "<td width=10><td width=70><b><!--T1670T-->Datum<!--T1670T--></b></td>";
    resultText += "<td width=10><td width=50><b><!--T1671T-->Tijd<!--T1671T--></b></td>";
    resultText += "<td width=10><td widtht=50><b><!--T1672T-->Uit/thuis<!--T1672T--></b></td>";
    resultText += "<td width=10><td><b><!--T1673T-->Eindstand<!--T1673T--></b></td>";
    resultText += "<td width=10><td><b><!--T1674T-->Punten<!--T1674T--></b></td>";
    resultText += "<td width=10></td>";
    resultText += "<td></td></tr>";

    var resultEditText = "<table width=790 id=dualcolortable1Edit cellspacing='0'>";
    resultEditText += "<tr height=25>";
    resultEditText += "<td width=10><td width=250><b><!--T1675T-->Wedstrijd<!--T1675T--></b></td>";
    resultEditText += "<td width=10><td width=70><b><!--T1676T-->Datum<!--T1676T--></b></td>";
    resultEditText += "<td width=10><td width=50><b><!--T1677T-->Tijd<!--T1677T--></b></td>";
    resultEditText += "<td width=10><td widtht=50><b><!--T1678T-->Uit/thuis<!--T1678T--></b></td>";
    resultEditText += "<td width=10><td><b><!--T1679T-->Eindstand<!--T1679T--></b></td>";
    resultEditText += "<td width=10><td><b><!--T1680T-->Punten<!--T1680T--></b></td>";
    if (isAdminUser()){
        resultEditText += "<td><b><!--T1681T-->Verwijder<!--T1681T--></b></td><td></td></tr>";
    }
    else{
        resultEditText += "<td></td><td></td></tr>";
    }
    resultEditText += "<td width=10></td>";
    resultEditText += "<td></td></tr>";

    var currentDate = new Date();
    for(var index = 0; index < $games.length; index++) {
        var item = $games[index];
        var gameDate = new Date(item.gamedate * 1000);
        if (currentDate<=gameDate) continue;
        var gameteams = item.opponent +" - "+initialSelectedTeamName;
        var homegame = "uit";
        if (item.homegame==1){
            gameteams = initialSelectedTeamName+" - "+item.opponent;
            homegame = "thuis";
        }
    
        resultText += "<tr height=25><td>" + gameteams + "</td><td></td><td>" + ts_getDateDate(gameDate) + "</td><td></td><td>" + ts_getDateTime(gameDate) + "</td><td></td><td>"+homegame+"</td><td></td><td>"+item.score+"</td><td></td><td>"+item.points+"</td>";
        resultText += "<td></td><td  align=right><img src='images/edit.png' title='Open wedstrijd' onclick='ts_changeSection(\"wedstrijd\","+item.id+");' height=15px style='cursor: pointer;'>";
        resultText += "&nbsp;&nbsp;";
        resultText += "</td></tr>";
        
        resultEditText += "<tr height=25><td></td><td>" + gameteams + "</td><td></td><td>" + ts_getDateDate(gameDate) + "</td><td></td><td>" + ts_getDateTime(gameDate) + "</td><td></td><td>"+homegame+"</td><td></td><td>"+item.score+"</td><td></td><td>"+item.points+"</td>";
        if (isAdminUser()){
            resultEditText += "<td></td><td><img src='images/delete.png' title='<!--T1682T-->Verwijder wedstrijd<!--T1682T-->' onclick='deleteGame("+item.id+");'  height=15px style='cursor: pointer;'>";
        }
        else{
            resultEditText += "<td></td><td>";
        }
        resultEditText += "&nbsp;&nbsp;";
        resultEditText += "</td></tr>";
        
    }
    resultText += "</table>";
    resultEditText += "</table>";
    document.getElementById('uitslagenList').innerHTML = resultText;
    document.getElementById('uitslagenEditList').innerHTML = resultEditText;
    
    // Make the rows dual color
    var table = document.getElementById("dualcolortable1");
    for (var i = 0, row; row = table.rows[i]; i++) {
        if ((i % 2 == 0)){
            row.className  = "dualcolortableRowNoHighlight";
        }
        else{
            row.className  = "dualcolortableRowHighlight";
        }
    }    
    
    // Make the rows dual color
    var table = document.getElementById("dualcolortable1Edit");
    for (var i = 0, row; row = table.rows[i]; i++) {
        if ((i % 2 == 0)){
            row.className  = "dualcolortableRowNoHighlight";
        }
        else{
            row.className  = "dualcolortableRowHighlight";
        }
    }    
    
    // place edit button
    var x = GetTopLeft(document.getElementById('modifyButton1a')).Left;
    var y = GetTopLeft(document.getElementById('modifyButton1a')).Top;
    document.getElementById('modifyButton1b').style.position="absolute";
    document.getElementById('modifyButton1b').style.display = ""; 
    document.getElementById('modifyButton1b').style.left = 0; 
    document.getElementById('modifyButton1b').style.top = 0; 
    var xRef = GetTopLeft(document.getElementById('modifyButton1b')).Left;
    var yRef = GetTopLeft(document.getElementById('modifyButton1b')).Top;
    document.getElementById('modifyButton1b').style.left = x-25-xRef; 
    document.getElementById('modifyButton1b').style.top = y-10-yRef; 
    
}

/*************************************************
 *
 **************************************************/
function loadGamesDataProgramma($games, initialCall) {
    var memberID = findCurrentTeamMemberID();
    var resultText = "<table width=750 border=0 id=dualcolortable cellspacing='0'>";
	resultText += "<tr height=25>";
    resultText += "<td width=250><b><!--T1683T-->Wedstrijd<!--T1683T--></b></td>";
    resultText += "<td width=10></td><td width=70><b><!--T1684T-->Datum<!--T1684T--></b></td>";
    resultText += "<td width=10></td><td width=50><b><!--T1685T-->Tijd<!--T1685T--></b></td>";
    resultText += "<td width=10></td><td widtht=50><b><!--T1686T-->Uit/thuis<!--T1686T--></b></td>";
	resultText += "<td width=10></td><td ><b><!--T1687T-->Aanwezigheid<!--T1687T--></b>";
	resultText += "<td width=10></td>";
	resultText += "<td></td></tr>";
	
    var resultEditText = "<table width=790 border=0 id=dualcolortableEdit cellspacing='0'>";
    resultEditText += "<tr height=25>";
    resultEditText += "<td width=10></td><td width=250><b><!--T1688T-->Wedstrijd<!--T1688T--></b></td>";
    resultEditText += "<td width=10></td><td width=70><b><!--T1689T-->Datum<!--T1689T--></b></td>";
    resultEditText += "<td width=10></td><td width=50><b><!--T1690T-->Tijd<!--T1690T--></b></td>";
    resultEditText += "<td width=10></td><td widtht=50><b><!--T1691T-->Uit/thuis<!--T1691T--></b></td>";
    resultEditText += "<td width=10></td><td ><b><!--T1692T-->Aanwezigheid<!--T1692T--></b>";
    resultEditText += "<td width=10></td>";
    if (isAdminUser()){
        resultEditText += "<td><b><!--T1693T-->Verwijder<!--T1693T--></b></td><td></td></tr>";
    }
    else{
        resultEditText += "<td></td><td></td></tr>";
    }
    
    
	
	
	var currentDate = new Date();
	for(var index = 0; index < $games.length; index++) {
		var item = $games[index];
		var gameDate = new Date(item.gamedate * 1000);
        if (currentDate>=gameDate) continue;
		var gameteams = item.opponent +" - "+initialSelectedTeamName;
		var homegame = "uit";
		if (item.homegame==1){
			gameteams = initialSelectedTeamName+" - "+item.opponent;
            homegame = "thuis";
		}
		
		resultText += "<tr height=25><td>" +gameteams +"</td><td></td><td>" +ts_getDateDate(gameDate) +"</td><td></td><td>" +ts_getDateTime(gameDate) +"</td><td></td><td>"+homegame+"</td>";
        resultText += "<td></td><td>";

        resultEditText += "<tr height=25><td></td><td>" +gameteams +"</td><td></td><td>" +ts_getDateDate(gameDate) +"</td><td></td><td>" +ts_getDateTime(gameDate) +"</td><td></td><td>"+homegame+"</td>";
        resultEditText += "<td></td><td>";
        
        var currentUserPresentYes=true;
        var currentUserPresentNo=false;
        var currentUserPresentUnknown=true;
        
        var fieldname = "aanwezig_"+item.id;
        var checkedYes = "";
        var checkedNo = "";
        var checkedUnknown = "";
        
        var aanwezig = "niet ingevuld";
        
        if (checkPresentInList(item.membersPresentYes,memberID)) {
            checkedYes = "checked";
            aanwezig = "ja";
        }
        else if (checkPresentInList(item.membersPresentNo,memberID)) {
            checkedNo = "checked";
            aanwezig = "nee";
        }
        else{
            checkedUnknown = "checked";
            aanwezig = "niet ingevuld";
        }

        resultText += aanwezig;

        resultEditText += "<input type='radio' name="+fieldname+" id="+fieldname+" "+checkedYes+" onClick=\"setAanwezig("+item.id+","+memberID+")\" >&nbsp;<!--T1694T-->ja<!--T1694T-->";
        resultEditText += "&nbsp;&nbsp;&nbsp;&nbsp;";
        resultEditText += "<input type='radio' name="+fieldname+" id="+fieldname+" "+checkedNo+" onClick=\"setAfwezig("+item.id+","+memberID+")\" >&nbsp;<!--T1695T-->nee<!--T1695T-->";
        resultEditText += "&nbsp;&nbsp;&nbsp;&nbsp;";
        resultEditText += "<input type='radio' name="+fieldname+" id="+fieldname+" "+checkedUnknown+" onClick=\"setOnbekend("+item.id+","+memberID+")\" >&nbsp;<!--T1696T-->weet niet<!--T1696T-->";

        resultText += "";
        resultText += "</td><td></td><td>";
        resultText += "<td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td align=right><img src='images/edit.png' title='Open wedstrijd' onclick='ts_changeSection(\"wedstrijd\","+item.id+");' height=15px style='cursor: pointer;'>";
        resultText += "&nbsp;&nbsp;";
        resultText += "</td></tr>";
        
        resultEditText += "";
        if (isAdminUser()){
            resultEditText += "<td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td><img src='images/delete.png' title='Verwijder wedstrijd' onclick='deleteGame("+item.id+");'  height=15px style='cursor: pointer;'>";
        }
        else{
            resultEditText += "<td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>";
        }
        resultEditText += "&nbsp;&nbsp;";
        resultEditText += "</td></tr>";
        
	}
    resultText += "</table>";
    resultEditText += "</table>";
    document.getElementById('programmaList').innerHTML = resultText;
    document.getElementById('programmaEditList').innerHTML = resultEditText;
	
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
	
    // Make the rows dual color
    var table = document.getElementById("dualcolortableEdit");
    for (var i = 0, row; row = table.rows[i]; i++) {
        if ((i % 2 == 0)){
            row.className  = "dualcolortableRowNoHighlight";
        }
        else{
            row.className  = "dualcolortableRowHighlight";
        }
    }    
    // place edit button
    var x = GetTopLeft(document.getElementById('modifyButton2a')).Left;
    var y = GetTopLeft(document.getElementById('modifyButton2a')).Top;
    document.getElementById('modifyButton2b').style.position="absolute";
    document.getElementById('modifyButton2b').style.display = ""; 
    document.getElementById('modifyButton2b').style.left = 0; 
    document.getElementById('modifyButton2b').style.top = 0; 
    var xRef = GetTopLeft(document.getElementById('modifyButton2b')).Left;
    var yRef = GetTopLeft(document.getElementById('modifyButton2b')).Top;
    document.getElementById('modifyButton2b').style.left = x-25-xRef; 
    document.getElementById('modifyButton2b').style.top = y-10-yRef; 	
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


function loadCompetitionHandlerTeamSeizoenenForEditCompetitions(competitions, initialLoad) {
    var resultText = "";
    resultText += "<table cellspacing='0'>";
//  resultText += "<tr><td><b>Omschrijving</b></td><td></td></tr>";

    for(var index = 0; index < competitions.length; index++) {
        var competition = competitions[index];
        fieldname = 'competition_' + index;
        resultText += "<tr><td><input id='" + fieldname + "' type='text' value='" + ts_escapeQuotes(competition.season) + "'/></td>" + "<td width=20></td><td><a href='#' onclick='javascript:removeCompetition(" + competition.id + ");'>Verwijder</a></td></tr>";

        competitionIDs[index] = competition.id;
        competitionValues[index] = competition.season;
    }
    resultText += "</table>";
    document.getElementById('competitionList').innerHTML = resultText;
}



function loadCompetitionsData(competitions, initialCall) {
    var select = document.getElementById('selectcompetition2');
    if(select==null) return;
    loadCompetitionHandlerTeamSeizoenenForEditCompetitions(competitions, initialCall);

    if(competitions.length == 0) {
        // no team found
        var theOption = new Option;
        theOption.text = "<!--T1697T-->Geen competities gevonden<!--T1697T-->";
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

    document.getElementById('editProgramma').style.display = 'none';
    document.getElementById('editUitslagen').style.display = 'none';
    var competitionID = document.getElementById('selectcompetition2').value;
    if (competitionID==-1){
        ts_showGlobalError("<!--T1698T-->Fout<!--T1698T-->", "<!--T1699T-->Er is nog geen competitie aangemaakt.<br>Maak eerst een competitie en voeg daarna een wedstrijd toe.<!--T1699T-->");
    }
    else{
        for (i=1;i<10;i++){
            document.getElementById('newGameDate'+i).value = "";
            document.getElementById('newGameTime'+i).value = "";
            document.getElementById('newGameOpponent'+i).value = "";
            document.getElementById('newHomegame'+i).checked = false;
        }
    }
    document.getElementById('newGame').style.display = '';
    document.getElementById('newGameDate1').focus();
    
}

/*************************************************
 *
 **************************************************/
function addGame() {

    document.getElementById('newGame').style.display = 'none';
    document.getElementById('editProgramma').style.display = 'none';
    document.getElementById('editUitslagen').style.display = 'none';

    var competitionID = document.getElementById('selectcompetition2').value;
    var JSONObject = new Object;
    JSONObject.request = "addGames";
    JSONObject.games = new Array;
    var index = 0;
    for (i=1; i<10; i++){
        var gameDate = document.getElementById('newGameDate'+i).value;
        var newGameTime = document.getElementById('newGameTime'+i).value;
        var gameOpponent = document.getElementById('newGameOpponent'+i).value;
        var homegame = document.getElementById('newHomegame'+i).checked;
        if (gameDate=="") continue
        if (newGameTime=="") continue
        if (gameOpponent=="") continue
        var days = parseInt(gameDate.split("-")[0],10);
        var months = parseInt(gameDate.split("-")[1],10)-1;
        var year = parseInt(gameDate.split("-")[2],10);
        var hours = parseInt(newGameTime.split(":")[0],10);
        var minutes = parseInt(newGameTime.split(":")[1],10);   
        if (isNaN(year)){
            alert("<!--T1700T-->Ongeldige datum opgegeven<!--T1700T-->");
            return
        }
        var dateMSec = new Date(0);
        dateMSec.setUTCDate(days);
        dateMSec.setUTCMonth(months);
        dateMSec.setUTCFullYear(year);
        dateMSec.setUTCHours(hours);
        dateMSec.setUTCMinutes(minutes);
        dateMSec.setUTCSeconds(0);
        var dateTimeInt = (dateMSec.getTime())/1000;
    	
        var gameOpponent = document.getElementById('newGameOpponent'+i).value;
        var homegame = document.getElementById('newHomegame'+i).checked;
       
        JSONObject.games[index] = new Object;
        JSONObject.games[index].gameOpponent = gameOpponent;
        JSONObject.games[index].homegame = homegame;
        JSONObject.games[index].gameDate = dateTimeInt;
        JSONObject.games[index].competitionID = competitionID;
        JSONObject.games[index].teamID = initialSelectedTeamID;        
        index++;
    }
	ts_runAjax(JSONObject, function onSucces(resultJSON) {
		loadGames();
	}, function onError(resultJSON) {
		ts_showGlobalError("<!--T1701T-->Fout<!--T1701T-->", resultJSON.errorMsg);
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
   document.getElementById('editProgramma').style.display = 'none';
   document.getElementById('editUitslagen').style.display = 'none';
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
       

        var days = parseInt(gameDate.split("-")[0],10);
        var months = parseInt(gameDate.split("-")[1],10)-1;
        var year = parseInt(gameDate.split("-")[2],10);
        var hours = parseInt(gameTime.split(":")[0],10);
        var minutes = parseInt(gameTime.split(":")[1],10);   
        if (isNaN(year)){
            alert("Ongeldige datum opgegeven");
            return
        }
        var dateMSec = new Date(0);
        dateMSec.setUTCDate(days);
        dateMSec.setUTCMonth(months);
        dateMSec.setUTCFullYear(year);
        dateMSec.setUTCHours(hours);
        dateMSec.setUTCMinutes(minutes);
        dateMSec.setUTCSeconds(0);
        var dateTimeInt = (dateMSec.getTime())/1000;       
       
       
       
       
       JSONObject.games[index] = new Object;
       JSONObject.games[index].gameOpponent = opponent;
       JSONObject.games[index].homegame = homegame;
       JSONObject.games[index].gameDate = dateTimeInt;
       JSONObject.games[index].competitionID = competitionID;
       JSONObject.games[index].teamID = initialSelectedTeamID;
    }
    
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        loadGames();
    }, function onError(resultJSON) {
        ts_showGlobalError("Fout", resultJSON.errorMsg);
    }, false);
    
}    
    
//----------------------------
var competitionIDs = new Array();
var competitionValues = new Array();



/*************************************************
 *
 **************************************************/
function removeCompetition(competitionID) {
    /*
     * Create JSON object with all modified fields
     */
    var JSONObject = new Object;
    JSONObject.competitionID = competitionID;
    JSONObject.request = "removeCompetition";
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        loadCompetitions();
    }, function onError(resultJSON) {
        showGlobalError("<!--T1702T-->Fout bij verwijderen van competitie<!--T1702T-->", resultJSON.errorMsg);
    }, false);
}

/*************************************************
 *
 **************************************************/
function saveCompetitions() {
    /*
     * Create JSON object with all modified fields
     */
    var JSONObject = new Object;
    JSONObject.competitions = new Array;
    JSONObject.request = "updateCompetition";
    var index = 0;
    for( i = 0; i < competitionIDs.length; i++) {
        var competitionid = competitionIDs[i];
        var competitionString = competitionValues[i];
        var fieldname = 'competition_' + i;
        var newValue = document.getElementById(fieldname).value;
        if(competitionString != newValue) {
            JSONObject.competitions[i] = new Object;
            JSONObject.competitions[i].id = competitionid
            JSONObject.competitions[i].season = newValue;
            index++;
        }
    }
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        loadCompetitions();
        javascript:document.getElementById('editCompetitions').style.display = 'none';
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1703T-->Fout bij opslaan veranderingen<!--T1703T-->", resultJSON.errorMsg);
    }, false);
}

/*************************************************
 *
 **************************************************/
function addCompetition() {
    document.getElementById('newCompetition').style.display = 'none';
    var selectedTeamID = initialSelectedTeamID;
    var season = document.getElementById('newSeasonText').value;
    var JSONObject = new Object;
    JSONObject.competitions = new Array;
    JSONObject.request = "addCompetition";
    JSONObject.teamID = selectedTeamID;
    JSONObject.season = season;
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        loadCompetitions();
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1704T-->Fout bij opslaan veranderingen<!--T1704T-->", resultJSON.errorMsg);
    }, false);
}



/*************************************************
 *
 **************************************************/
function loadCompetitions() {
    var JSONObject = new Object;
    JSONObject.competitions = new Array;
    JSONObject.request = "loadCompetitions";
    JSONObject.teamID = initialSelectedTeamID;
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        loadCompetitionsData(resultJSON.result, false);
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1705T-->Fout bij ophalen van de competities<!--T1705T-->", resultJSON.errorMsg);
    }, false);
}


/*************************************************
 *
 **************************************************/
function openNewCompetition() {
    document.getElementById('newCompetition').style.display = '';
    document.getElementById('newSeasonText').value = "";
}

