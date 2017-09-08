/*************************************************
 *
 **************************************************/
var currentCompetitionID = 0;
var currentCompetitions = null;


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
    
    // place edit button2
    var x = GetTopLeft(document.getElementById('modifyButton1a')).Left;// use the left of the first edit button!
    var y = GetTopLeft(document.getElementById('modifyButton2a')).Top;
    document.getElementById('modifyButton2b').style.position="absolute";
    document.getElementById('modifyButton2b').style.display = ""; 
    document.getElementById('modifyButton2b').style.left = 0; 
    document.getElementById('modifyButton2b').style.top = 0; 
    var xRef = GetTopLeft(document.getElementById('modifyButton2b')).Left;
    var yRef = GetTopLeft(document.getElementById('modifyButton2b')).Top;
    document.getElementById('modifyButton2b').style.left = x-25-xRef; 
    document.getElementById('modifyButton2b').style.top = y-10-yRef; 
    

    if (isAdminUser()){
        document.getElementById('modifyButton1b').style.display = ""; 
        document.getElementById('modifyButton2b').style.display = ""; 
    }
    else{
        document.getElementById('modifyButton1b').style.display = "none"; 
        document.getElementById('modifyButton2b').style.display = "none"; 
    }
    
    competitionSelectionChanged();
    
}

    

function showOwnProgramma(){
    try{
   document.getElementById('ownprogramma').style.display = ""; 
   document.getElementById('ownuitslagen').style.display = "none"; 
   document.getElementById('programma').style.display = "none"; 
   document.getElementById('uitslagen').style.display = "none"; 
   document.getElementById('stand').style.display = "none";
   document.getElementById('details').style.display = "none"; 
   document.getElementById('ownprogImageA').src="images/tab-programma2.png"; 
   document.getElementById('ownuitslagenImageA').src="images/tab-uitslagen.png"; 
   document.getElementById('ownprogImageB').src="images/tab-teamprogramma2.png"; 
   document.getElementById('ownuitslagenImageB').src="images/tab-teamuitslagen.png"; 
   document.getElementById('progImage').src="images/tab-compprogramma.png"; 
   document.getElementById('progUitslagen').src="images/tab-compuitslagen.png"; 
   document.getElementById('progStand').src="images/tab-stand.png";
   }
   catch(Exception){
       
       } 
//   document["progDetails"].src="images/tab-details.png"; 
}

function showOwnUitslagen(){
   document.getElementById('ownprogramma').style.display = "none"; 
   document.getElementById('ownuitslagen').style.display = ""; 
   document.getElementById('programma').style.display = "none"; 
   document.getElementById('uitslagen').style.display = "none"; 
   document.getElementById('stand').style.display = "none"; 
   document.getElementById('details').style.display = "none"; 
   document.getElementById('ownprogImageA').src="images/tab-programma.png"; 
   document.getElementById('ownuitslagenImageA').src="images/tab-uitslagen2.png"; 
   document.getElementById('ownprogImageB').src="images/tab-teamprogramma.png"; 
   document.getElementById('ownuitslagenImageB').src="images/tab-teamuitslagen2.png"; 
   document.getElementById('progImage').src="images/tab-compprogramma.png"; 
   document.getElementById('progUitslagen').src="images/tab-compuitslagen.png"; 
   document.getElementById('progStand').src="images/tab-stand.png"; 
//   document["progDetails"].src="images/tab-details.png"; 
}


function showProgramma(){
   document.getElementById('ownprogramma').style.display = "none"; 
   document.getElementById('ownuitslagen').style.display = "none"; 
   document.getElementById('programma').style.display = ""; 
   document.getElementById('uitslagen').style.display = "none"; 
   document.getElementById('stand').style.display = "none";
   document.getElementById('details').style.display = "none"; 
   document.getElementById('ownprogImageA').src="images/tab-programma.png"; 
   document.getElementById('ownuitslagenImageA').src="images/tab-uitslagen.png"; 
   document.getElementById('ownprogImageB').src="images/tab-teamprogramma.png"; 
   document.getElementById('ownuitslagenImageB').src="images/tab-teamuitslagen.png"; 
   document.getElementById('progImage').src="images/tab-compprogramma2.png"; 
   document.getElementById('progUitslagen').src="images/tab-compuitslagen.png"; 
   document.getElementById('progStand').src="images/tab-stand.png"; 
 //  document["progDetails"].src="images/tab-details.png"; 
}

function showUitslagen(){
   document.getElementById('ownprogramma').style.display = "none"; 
   document.getElementById('ownuitslagen').style.display = "none"; 
   document.getElementById('programma').style.display = "none"; 
   document.getElementById('uitslagen').style.display = ""; 
   document.getElementById('stand').style.display = "none"; 
   document.getElementById('details').style.display = "none"; 
   document.getElementById('ownprogImageA').src="images/tab-programma.png"; 
   document.getElementById('ownuitslagenImageA').src="images/tab-uitslagen.png"; 
   document.getElementById('ownprogImageB').src="images/tab-teamprogramma.png"; 
   document.getElementById('ownuitslagenImageB').src="images/tab-teamuitslagen.png"; 
   document.getElementById('progImage').src="images/tab-compprogramma.png"; 
   document.getElementById('progUitslagen').src="images/tab-compuitslagen2.png"; 
   document.getElementById('progStand').src="images/tab-stand.png"; 
 //  document["progDetails"].src="images/tab-details.png"; 
}

function showStand(){
   document.getElementById('ownprogramma').style.display = "none"; 
   document.getElementById('ownuitslagen').style.display = "none"; 
   document.getElementById('programma').style.display = "none"; 
   document.getElementById('uitslagen').style.display = "none"; 
   document.getElementById('stand').style.display = ""; 
   document.getElementById('details').style.display = "none"; 
   document.getElementById('ownprogImageA').src="images/tab-programma.png"; 
   document.getElementById('ownuitslagenImageA').src="images/tab-uitslagen.png"; 
   document.getElementById('ownprogImageB').src="images/tab-teamprogramma.png"; 
   document.getElementById('ownuitslagenImageB').src="images/tab-teamuitslagen.png"; 
   document.getElementById('progImage').src="images/tab-compprogramma.png"; 
   document.getElementById('progUitslagen').src="images/tab-compuitslagen.png"; 
   document.getElementById('progStand').src="images/tab-stand2.png"; 
//   document["progDetails"].src="images/tab-details.png"; 
}

function showDetails(){
   document.getElementById('ownprogramma').style.display = "none"; 
   document.getElementById('ownuitslagen').style.display = "none"; 
   document.getElementById('programma').style.display = "none"; 
   document.getElementById('uitslagen').style.display = "none"; 
   document.getElementById('stand').style.display = "none"; 
   document.getElementById('details').style.display = ""; 
   document.getElementById('ownprogImageA').src="images/tab-programma.png"; 
   document.getElementById('ownuitslagenImageA').src="images/tab-uitslagen.png"; 
   document.getElementById('ownprogImageB').src="images/tab-teamprogramma.png"; 
   document.getElementById('ownuitslagenImageB').src="images/tab-teamuitslagen.png"; 
   document.getElementById('progImage').src="images/tab-compprogramma.png"; 
   document.getElementById('progUitslagen').src="images/tab-compuitslagen.png"; 
   document.getElementById('progStand').src="images/tab-stand.png"; 
//   document["progDetails"].src="images/tab-details2.png"; 
}


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

/*
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
*/
var oldSelectedRow = 0;
function competitionSelectionChanged() {
    // clear old row
    var fieldname = "seasonrow_"+oldSelectedRow;
    var el = document.getElementById(fieldname);
    if (el!=null){
        el.style.fontWeight = '';
    }

    // set new row bold
    var fieldname = "seasonrow_"+currentCompetitionID;
    var el = document.getElementById(fieldname);
    if (el!=null){
        el.style.fontWeight = 'bold';
    }
    oldSelectedRow = currentCompetitionID;
    
    // test if this is a managed competition
    var managed = true;
    if (currentCompetitions!=null){
        for(var index = 0; index < currentCompetitions.length; index++) {
            var item = currentCompetitions[index];
            if (currentCompetitionID == item.id){
                managed = item.mCompetition>0;
            }
        }
    }
    
    // hide or show the 'add games' button
    if (managed || anonimousLogin){
        document.getElementById('modifyButton2b').style.display = "none"; 
    }
    else{
        document.getElementById('modifyButton2b').style.display = ""; 
    }
    
    // hide or show the managed games tabs
     if (managed ){
        document.getElementById('ownprogImageA').style.display = "none"; 
        document.getElementById('ownuitslagenImageA').style.display = "none"; 
        document.getElementById('ownprogImageB').style.display = ""; 
        document.getElementById('ownuitslagenImageB').style.display = ""; 
        document.getElementById('progImage').style.display = ""; 
        document.getElementById('progUitslagen').style.display = ""; 
        document.getElementById('progStand').style.display = ""; 
    }
    else{
        document.getElementById('ownprogImageA').style.display = ""; 
        document.getElementById('ownuitslagenImageA').style.display = ""; 
        document.getElementById('ownprogImageB').style.display = "none"; 
        document.getElementById('ownuitslagenImageB').style.display = "none"; 
        document.getElementById('progImage').style.display = "none"; 
        document.getElementById('progUitslagen').style.display = "none"; 
        document.getElementById('progStand').style.display = "none"; 
    }



    
}


function selectCompetition(competitionID) {
    currentCompetitionID = competitionID;
    competitionSelectionChanged();
}


function loadGames() {
	loadGames2(currentCompetitionID);
}

function loadGames2(competitionID) {
    var JSONObject = new Object;
    JSONObject.request = "loadCompetitionData";
    JSONObject.competitionID = competitionID;

    ts_runAjax(JSONObject, function onSuccess(resultJSON) {
        loadGamesDataUitslagen(resultJSON.result.games, false);
        loadGamesDataProgramma(resultJSON.result.games, false);
        loadCompetitieProgrammaData(resultJSON.result.mCompetition, false);
        loadCompetitieUitslagenData(resultJSON.result.mCompetition, false);
        loadCompetitieStand(resultJSON.result.mCompetition, false);
    }, function onError(resultJSON) {
        ts_showGlobalError("Fout bij ophalen van de wedstrijden", resultJSON.errorMsg);
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


function loadCompetitieProgrammaData(competitionData){
    var resultText = "";
    resultText += "<table>";
    
    var currentDate = new Date();
    var lastPlayroundDate = "";
    for(var index = 0; index < competitionData.games.length; index++) {
        var item = competitionData.games[index];
        var gameDate = new Date(item.datetime * 1000);
        if (currentDate>gameDate) continue;
        var team1 = '<a target=_blank href="index.php?team='+item.teamID1+'&section=competitie" class=none3>'+item.teamName1+'</a>';
        var team2 = '<a target=_blank href="index.php?team='+item.teamID2+'&section=competitie" class=none3>'+item.teamName2+'</a>';
        var location = item.location;
        var speelronde = item.playround;
        var dateStr = ts_getDateDate(gameDate);
        playroundDate = speelronde+dateStr;
        if (playroundDate!=lastPlayroundDate){
            lastPlayroundDate = playroundDate;
            resultText += "<tr><td colspan=99><br><b>Speelronde " + speelronde+" , "+dateStr+"</td></tr>";
        }
    
        resultText += "<tr><td>" + location + "</td><td width=10px>&nbsp;</td><td>" + ts_getDateTime(gameDate) + "</td><td width=10px>&nbsp;</td><td>" + team1 + "</td><td width=10px>&nbsp;</td><td>-</td><td width=10px>&nbsp;</td><td>" + team2 + "</td>";
        resultText += "</tr>";
        
        
    }    
    
    resultText += "</table>";
    document.getElementById('programma').innerHTML = resultText;

    
}

function loadCompetitieUitslagenData(competitionData){
    var resultText = "";
    resultText += "<table>";
    
    var currentDate = new Date();
    var lastPlayroundDate = "";
    for(var index = 0; index < competitionData.games.length; index++) {
        var item = competitionData.games[index];
        var gameDate = new Date(item.datetime * 1000);
        if (currentDate<=gameDate) continue;
        var team1 = '<a target=_blank href="index.php?team='+item.teamID1+'&section=competitie" class=none3>'+item.teamName1+'</a>';
        var team2 = '<a target=_blank href="index.php?team='+item.teamID2+'&section=competitie" class=none3>'+item.teamName2+'</a>';
        var location = item.location;
        var speelronde = item.playround;
        var score = item.score;
        var dateStr = ts_getDateDate(gameDate);
        playroundDate = speelronde+dateStr;
        if (playroundDate!=lastPlayroundDate){
            lastPlayroundDate = playroundDate;
            resultText += "<tr><td colspan=99><br><b><!--T1438T-->Speelronde<!--T1438T--> " + speelronde+" , "+dateStr+"</td></tr>";
        }
    
        resultText += "<tr><td>" + location + "</td><td width=10px>&nbsp;</td><td>" + ts_getDateTime(gameDate) + "</td><td width=10px>&nbsp;</td><td>" + team1 + "</td><td width=10px>&nbsp;</td><td>-</td><td width=10px>&nbsp;</td><td>" + team2 + "</td><td width=10px>&nbsp;</td><td>" + score + "</td>";
        resultText += "</tr>";
        
        
    }    
    
    resultText += "</table>";
    document.getElementById('uitslagen').innerHTML = resultText;

    
}

function loadCompetitieStand(competitionData){
    var resultText = "<table id=dualcolortableStand cellspacing='0'>";
    /*T1439T*/
        resultText += "<tr>"+
        "<td><b>Plaats</b></td>"+
        "<td width=10px>&nbsp;</td>"+
        "<td><b>Team</b></td>"+
        "<td width=10px>&nbsp;</td>"+
        "<td><b>Punten</b></td>"+
        "<td width=10px>&nbsp;</td>"+
        "<td><b>Gespeeld</b></td>"+
        "<td width=10px>&nbsp;</td>"+
        "<td><b>Gewonnen</b></td>"+
        "<td width=10px>&nbsp;</td>"+
        "<td><b>Verloren</b></td>"+
        "<td width=10px>&nbsp;</td>"+
        "<td><b>Gelijk</b></td>"+
        "<td width=10px>&nbsp;</td>"+
        "<td><b>Saldo</b></td>"+
        "</tr>";
    /*T1439T*/
    
    
    var currentDate = new Date();
    var lastPlayroundDate = "";
    for(var index = 0; index < competitionData.teams.length; index++) {
        var item = competitionData.teams[index];
        var gameDate = new Date(item.datetime * 1000);
        if (currentDate<=gameDate) continue;
        var team = '<a target=_blank href="index.php?team='+item.id+'&section=competitie" class=none3>'+item.teamname+'</a>';
        var numGespeeld = item.numGespeeld;
        var numGewonnen = item.numGewonnen;
        var numVerloren = item.numVerloren;
        var numGelijk = item.numGelijk;
        var punten = item.punten;
        var saldoVoor = item.saldoVoor;
        var saldoTegen = item.saldoTegen;
        var saldo = saldoVoor+"-"+saldoTegen;
        var nr = index+1;

        resultText += "<tr>"+
        "<td>" + nr + "</td>"+
        "<td width=10px>&nbsp;</td>"+
        "<td>" + team + "</td>"+
        "<td width=10px>&nbsp;</td>"+
        "<td>" + punten + "</td>"+
        "<td width=10px>&nbsp;</td>"+
        "<td>" + numGespeeld + "</td>"+
        "<td width=10px>&nbsp;</td>"+
        "<td>" + numGewonnen + "</td>"+
        "<td width=10px>&nbsp;</td>"+
        "<td>" + numVerloren + "</td>"+
        "<td width=10px>&nbsp;</td>"+
        "<td>" + numGelijk + "</td>"+
        "<td width=10px>&nbsp;</td>"+
        "<td>" + saldo + "</td>"+
        "</tr>";
        
        
    }    
    
    resultText += "</table>";
    document.getElementById('stand').innerHTML = resultText;

    // Make the rows dual color
    var table = document.getElementById("dualcolortableStand");
    for (var i = 0, row; row = table.rows[i]; i++) {
        if ((i % 2 == 0)){
            row.className  = "dualcolortableRowNoHighlight";
        }
        else{
            row.className  = "dualcolortableRowHighlight";
        }
    }    
    
    
}


/*************************************************
 *
 **************************************************/
function loadGamesDataUitslagen($games, initialCall) {
    var resultText = "<table width=750 id=dualcolortable1 cellspacing='0'>";
    resultText += "<tr height=25>";
    /*T1440T*/
    resultText += "<td width=250><b>Wedstrijd</b></td>";
    resultText += "<td width=10><td width=70><b>Datum</b></td>";
    resultText += "<td width=10><td width=50><b>Tijd</b></td>";
    resultText += "<td width=10><td widtht=50><b>Uit/thuis</b></td>";
    resultText += "<td width=10><td><b>Eindstand</b></td>";
    resultText += "<td width=10><td><b>Punten</b></td>";
    /*T1440T*/
    resultText += "<td></td><td></td></tr>";
    resultText += "<td width=10></td>";
    resultText += "<td></td></tr>";


    var currentDate = new Date();
    for(var index = 0; index < $games.length; index++) {
        var item = $games[index];
        var gameDate = new Date(item.gamedate * 1000);
        if (currentDate<=gameDate) continue;
        
        var opponentLink = item.opponent;
        if (item.mGameID>0){
            if (item.homegame==1){
                if (item.teamID2>0){
                    opponentLink = '<a target=_blank href="index.php?team='+item.teamID2+'&section=competitie" class=none3>'+item.opponent+'</a>';
                }
            }
            else{
                if (item.teamID1>0){
                    opponentLink = '<a target=_blank href="index.php?team='+item.teamID1+'&section=competitie" class=none3>'+item.opponent+'</a>';
                }
            }
        }
        
        var gameteams = opponentLink +" - "+initialSelectedTeamName;
        var homegame = "uit";
        if (item.homegame==1){
            gameteams = initialSelectedTeamName+" - "+opponentLink;
            homegame = "thuis";
        }
    
        resultText += "<tr height=25><td>" + gameteams + "</td><td></td><td>" + ts_getDateDate(gameDate) + "</td><td></td><td>" + ts_getDateTime(gameDate) + "</td><td></td><td>"+homegame+"</td><td></td><td>"+item.score+"</td><td></td><td>"+item.points+"</td>";
        resultText += "<td></td><td  align=right><img src='images/edit.png' title='Open wedstrijd' onclick='ts_changeSection(\"wedstrijd\","+item.id+");' height=15px style='cursor: pointer;'>";
        resultText += "&nbsp;&nbsp;";
        resultText += "</td>";
        if (isAdminUser()){
            resultText += "<td></td><td><img src='images/delete.png' title='Verwijder wedstrijd' onclick='deleteGame("+item.id+");'  height=15px style='cursor: pointer;'>";
        }
        else{
            resultText += "<td></td>";
        }
        resultText += "</tr>";
        
        
    }
    resultText += "</table>";
    document.getElementById('ownuitslagen').innerHTML = resultText;
    
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
    
}

/*************************************************
 *
 **************************************************/
function loadGamesDataProgramma($games, initialCall) {
    var memberID = findCurrentTeamMemberID();
    var resultText = "<table width=750 border=0 id=dualcolortable cellspacing='0'>";
	resultText += "<tr height=25>";
    /*T1441T*/
    resultText += "<td width=250><b>Wedstrijd</b></td>";
    resultText += "<td width=10></td><td width=70><b>Datum</b></td>";
    resultText += "<td width=10></td><td width=50><b>Tijd</b></td>";
    resultText += "<td width=10></td><td width=50><b>Uit/thuis</b></td>";
	resultText += "<td width=10></td><td width=250><b>Aanwezigheid</b>";
	/*T1441T*/
	resultText += "<td width=10></td>";
    resultText += "<td></td><td></td></tr>";
	resultText += "<td></td></tr>";
	
    
	var currentDate = new Date();
	for(var index = 0; index < $games.length; index++) {
		var item = $games[index];
		var gameDate = new Date(item.gamedate * 1000);
        if (currentDate>=gameDate) continue;

        var opponentLink = item.opponent;
        if (item.mGameID>0){
            if (item.homegame==1){
                if (item.teamID2>0){
                    opponentLink = '<a target=_blank href="index.php?team='+item.teamID2+'&section=competitie" class=none3>'+item.opponent+'</a>';
                }
            }
            else{
                if (item.teamID1>0){
                    opponentLink = '<a target=_blank href="index.php?team='+item.teamID1+'&section=competitie" class=none3>'+item.opponent+'</a>';
                }
            }
        }

		var gameteams = opponentLink +" - "+initialSelectedTeamName;
		var homegame = "uit";
		if (item.homegame==1){
			gameteams = initialSelectedTeamName+" - "+opponentLink;
            homegame = "thuis";
		}
		
		resultText += "<tr height=25><td>" +gameteams +"</td><td></td><td>" +ts_getDateDate(gameDate) +"</td><td></td><td>" +ts_getDateTime(gameDate) +"</td><td></td><td>"+homegame+"</td>";
        resultText += "<td></td><td>";

        var currentUserPresentYes=true;
        var currentUserPresentNo=false;
        var currentUserPresentUnknown=true;
        
        var fieldname = "aanwezig_"+item.id;
        var checkedYes = "";
        var checkedNo = "";
        var checkedUnknown = "";
        
        if (checkPresentInList(item.membersPresentYes,memberID)) {
            checkedYes = "checked";
        }
        else if (checkPresentInList(item.membersPresentNo,memberID)) {
            checkedNo = "checked";
        }
        else{
            checkedUnknown = "checked";
        }


        resultText += "<input type='radio' name="+fieldname+" id="+fieldname+" "+checkedYes+" onClick=\"setAanwezig("+item.id+","+memberID+")\" >&nbsp;ja";
        resultText += "&nbsp;&nbsp;&nbsp;&nbsp;";
        resultText += "<input type='radio' name="+fieldname+" id="+fieldname+" "+checkedNo+" onClick=\"setAfwezig("+item.id+","+memberID+")\" >&nbsp;nee";
        resultText += "&nbsp;&nbsp;&nbsp;&nbsp;";
        resultText += "<input type='radio' name="+fieldname+" id="+fieldname+" "+checkedUnknown+" onClick=\"setOnbekend("+item.id+","+memberID+")\" >&nbsp;weet niet";

        resultText += "";
        resultText += "</td><td></td><td>";
        resultText += "<td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td align=right><img src='images/edit.png' title='Open wedstrijd' onclick='ts_changeSection(\"wedstrijd\","+item.id+");' height=15px style='cursor: pointer;'>";
        resultText += "&nbsp;&nbsp;";
        resultText += "</td>";
        
        if (isAdminUser()){
            resultText += "<td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td><img src='images/delete.png' title='Verwijder wedstrijd' onclick='deleteGame("+item.id+");'  height=15px style='cursor: pointer;'>";
        }
        else{
            resultText += "<td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td>";
        }
        resultText += "&nbsp;&nbsp;";
        resultText += "</td></tr>";
        
	}
    resultText += "</table>";
    document.getElementById('ownprogramma').innerHTML = resultText;
	
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


function loadCompetitionHandlerTeamSeizoenenForEditCompetitions(competitions, initialLoad) {
    var resultText = "";
    resultText += "<table cellspacing='0'>";
    resultText += "<tr>"+
    /*T1442T*/
    "<td><b>Seizoen</b></td><td></td>"+
    "<td><b>Competitie</b></td><td></td>"+
    "<td><b>Type</b></td><td></td>"+
    "<td><b>Status</b></td><td></td>"+
    /*T1442T*/
    "</tr>";

    for(var index = 0; index < competitions.length; index++) {
        var competition = competitions[index];
        var fieldname1 = 'competition_season_' + index;
        var fieldname2 = 'competition_desciption_' + index;
        var fieldname3 = 'competition_status_' + index;
        var selected1 = "";
        var selected2 = "";
        var selected3 = "";
        if (competition.status==null){
            selected1 = "selected";
        }
        else if (competition.status==0){
            selected1 = "selected";
        }
        else if (competition.status==1){
            selected2 = "selected";
        }
        else if (competition.status==2){
            selected3 = "selected";
        }
        
        var type = "Eigen competitie";
        if (competition.mCompetition>0){
            type = "Beheerde competitie";
        }
        
        resultText += "<tr>"+
        "<td><input id='" + fieldname1 + "' type='text' value='" + ts_escapeQuotes(competition.season) + "'/></td><td width=20></td>"+
        "<td><input id='" + fieldname2 + "' type='text' value='" + ts_escapeQuotes(competition.description) + "'/></td><td width=20></td>"+
        "<td>"+type + "</td><td width=20></td>"+
        "<td>"+
        "<select id='"+fieldname3+"'>"+
        /*T1443T*/
        "<option "+selected1+" value=0>Actief</option>"+
        "<option "+selected2+" value=1>Afgelopen</option>"+
        "<option "+selected3+" value=2>Volgend jaar</option>"+
        /*T1443T*/
        "</select>"+
        "</td><td width=20></td>"+
        
        "<td><a href='#' onclick='javascript:removeCompetition(" + competition.id + ");'><!--T1444T-->Verwijder<!--T1444T--></a></td></tr>";

        competitionIDs[index] = competition.id;
        competitionValuesSeason[index] = competition.season;
        competitionValuesDescription[index] = competition.description;
        competitionValuesStatus[index] = competition.status;
    }
    resultText += "</table>";
    document.getElementById('competitionList').innerHTML = resultText;
}

function loadCompetitionsData(competitions, initialCall) {
    currentCompetitions = competitions;
    loadCompetitionHandlerTeamSeizoenenForEditCompetitions(competitions, initialCall);

    var resultText = "<table width=750 id=dualcolortable3 cellspacing='0'>";
    resultText += "<tr height=25>";
    /*T1445T*/
    resultText += "<td ><b>Seizoen</b></td>";
    resultText += "<td width=10><td><b>Competitie</b></td>";
    resultText += "<td width=10><td><b>Type</b></td>";
    resultText += "<td width=10><td><b>Status</b></td>";
    /*T1445T*/
    resultText += "<td width=10></td>";
    resultText += "<td></td></tr>";


    for(var index = 0; index < competitions.length; index++) {
        var item = competitions[index];
        currentCompetitionID = initialSelectedCompetition;
        if (initialSelectedCompetition == item.id){
        }
        
        var type = /*T1446T*/"Eigen competitie"/*T1446T*/;
        if (item.mCompetition>0){
            type = /*T1447T*/"Beheerde competitie"/*T1447T*/;
        }

        var status = /*T1448T*/"Actief"/*T1448T*/;
        if (item.status==1){
            status = /*T1449T*/"Afgelopen"/*T1449T*/;
        }
        if (item.status==2){
            status = /*T1450T*/"Volgend jaar"/*T1450T*/;
        }

        resultText += "<tr height=25 id='seasonrow_"+item.id+"' onclick='javascript:selectCompetition(\""+item.id+"\");loadGames();'>  "+
        "<td>" + item.season + "</td><td></td>"+
        "<td>" + item.description + "</td><td></td>"+
        "<td>" + type + "</td><td></td>"+
        "<td>" + status + "</td>";
        resultText += "</tr>";
        
        
    }
    resultText += "</table>";

    document.getElementById('competitiesList').innerHTML = resultText;
    
    // Make the rows dual color
    var table = document.getElementById("dualcolortable3");
    for (var i = 0, row; row = table.rows[i]; i++) {
        if ((i % 2 == 0)){
            row.className  = "dualcolortableRowNoHighlight";
        }
        else{
            row.className  = "dualcolortableRowHighlight";
        }
    }    
    
    
}



function competitionSelect() {
	loadGames();
}

/*************************************************
 *
 **************************************************/
function openNewGame() {

    var competitionID = currentCompetitionID;
    if (competitionID==-1){
        ts_showGlobalError("Fout", /*T1451T*/"Er is nog geen competitie aangemaakt.<br>Maak eerst een competitie en voeg daarna een wedstrijd toe."/*T1451T*/);
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
    document.getElementById("addGamesScreen").style.display = "none";
    
}

/*************************************************
 *
 **************************************************/
function addGame() {

    document.getElementById('newGame').style.display = 'none';

    var competitionID = currentCompetitionID;
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
            alert(/*T1452T*/"Ongeldige datum opgegeven"/*T1452T*/);
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
		ts_showGlobalError("Fout", resultJSON.errorMsg);
	}, false);
}


/*************************************************
 *
 **************************************************/
function importFromTeamersOpen() {
    document.getElementById('importFromTeamersPage1').style.display = '';
    document.getElementById("addGamesScreen").style.display = "none";    
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
            /*T1453T*/
            resultText += "<td><b>team</b></td>";
            resultText += "<td width=10></td>";
            resultText += "<td><b>uit/thuis</b></td>";
            resultText += "<td width=10></td>";
            resultText += "<td><b>datum</b></td>";
            resultText += "<td width=10></td>";
            resultText += "<td><b>time</b></td>";
            /*T1453T*/
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
   var competitionID = currentCompetitionID;
 
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
var competitionValuesSeason = new Array();
var competitionValuesDescription = new Array();
var competitionValuesStatus = new Array();



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
        showGlobalError(/*T1454T*/"Fout bij verwijderen van competitie"/*T1454T*/, resultJSON.errorMsg);
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
        var competitionSeasonString = competitionValuesSeason[i];
        var competitionDescriptionString = competitionValuesDescription[i];
        var competitionStatusString = competitionValuesStatus[i];
        
        var fieldname1 = 'competition_season_' + i;
        var fieldname2 = 'competition_desciption_' + i;
        var fieldname3 = 'competition_status_' + i;
        
        var newValueSeason = document.getElementById(fieldname1).value;
        var newValueDescription = document.getElementById(fieldname2).value;
        var newValueStatus = document.getElementById(fieldname3).value;
        
        var changed = false;
        if(competitionSeasonString != newValueSeason) {
            changed = true;
        }
        if(competitionStatusString != newValueDescription) {
            changed = true;
        }
        if(competitionDescriptionString != newValueStatus) {
            changed = true;
        }

        if(changed) {
            JSONObject.competitions[i] = new Object;
            JSONObject.competitions[i].id = competitionid
            JSONObject.competitions[i].season = newValueSeason;
            JSONObject.competitions[i].description = newValueDescription;
            JSONObject.competitions[i].status = newValueStatus;
            index++;
        }
    }
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        loadCompetitions();
        javascript:document.getElementById('editCompetitions').style.display = 'none';
    }, function onError(resultJSON) {
        ts_showGlobalError("Fout bij opslaan veranderingen", resultJSON.errorMsg);
    }, false);
}

/*************************************************
 *
 **************************************************/
function addCompetition() {
    document.getElementById('newCompetition').style.display = 'none';
    var selectedTeamID = initialSelectedTeamID;
    var season = document.getElementById('newSeasonText').value;
    var competition = document.getElementById('newCompetitionText').value;
    var status = document.getElementById('newStatusText').value;
    var JSONObject = new Object;
    JSONObject.request = "addCompetition";
    JSONObject.teamID = selectedTeamID;
    JSONObject.season = season;
    JSONObject.competition = competition;
    JSONObject.status = status;
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        loadCompetitions();
    }, function onError(resultJSON) {
        ts_showGlobalError(/*T1455T*/"Fout bij opslaan veranderingen"/*T1455T*/, resultJSON.errorMsg);
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
        ts_showGlobalError(/*T1456T*/"Fout bij ophalen van de competities"/*T1456T*/, resultJSON.errorMsg);
    }, false);
}


/*************************************************
 *
 **************************************************/
function openNewCompetition() {
    document.getElementById('newCompetition').style.display = '';
    document.getElementById('newSeasonText').value = "";
}

