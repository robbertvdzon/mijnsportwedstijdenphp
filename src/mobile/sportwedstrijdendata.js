var grandSummary = 0; 
var playerSummary = 0; 
var gameSummary = new Array();

function loadProgData(){
    if (getUserData()==null) return;
    var games = getUserData().foundGames;
    var gamesText = "";
    var empty = true;

    gamesText += "<table id=table_prog >";
    
    gamesText += 
            "<tr>"+
            "<td id=spaceleft_prog></td>"+
            "<td align=left colspan=3></td>"+
            "<td id=spaceright_prog></td>"+
            "</tr>";

    for(var index = 0; index < games.length; index++) {
        var game = games[index];
        if (gameDateInPast(game.dateTimeStr)) continue;
        var gameText = "";
        gameText = getGameHtmlProg(game,index);
        gamesText = gamesText+gameText;
        empty = false;
    }
    
    gamesText = gamesText+"<tr id=spacebottom_prog><td colspan=99></td><tr>";
    gamesText = gamesText+"</table>";
    
    if (empty){
        gamesText = "<table id=table_prog >"+
            "<tr><td id=spaceleft_prog></td>"+
            "<td align=left colspan=3><br>Geen programma data beschikbaar</td>"+
            "<td id=spaceright_prog></td><tr>"+
            "<tr id=spacebottom_prog><td colspan=99></td><tr>"+
            "</table>";
    }
    
    document.getElementById('progData').innerHTML = gamesText;
   // also load game data
    loadGameData();
} 


function getGameHtmlProg(game, index){
    var color = "#ffffff";
    if (index %2 ==0){
        color = "#ecf4d9";
    }
    else{
        color = "#ffffff";
    }    
    
    var timeArray = extractTime(game.dateTimeStr);

    var team1 = game.teamname;
    var team2 = game.opponent;
    if (game.homegame==0) {
        team1 = game.opponent;
        team2 = game.teamname;
    }
    team1 = team1.replace(/ /g, "&nbsp;");
    team2 = team2.replace(/ /g, "&nbsp;");

    var aantalAanwezig = game.membersPresentYesNames.split(",").length;
    if (game.membersPresentYesNames=="") aantalAanwezig = 0;
    
    var zelfAanwezigText = "";
    if (game.userPresent==0) {
        zelfAanwezigText = "zelf nog niets opgegeven";
    }
    if (game.userPresent==1) {
        zelfAanwezigText = "zelf aanwezig";
    }
    if (game.userPresent==2) {
        zelfAanwezigText = "zelf niet aanwezig";
    }
            


    var gameText = 
                "<tr bgcolor="+color+" onClick='openGame("+game.id+")' height=5px><td colspan=99 ></td></tr>"+
                "<tr  bgcolor="+color+" onClick='openGame("+game.id+")'>"+
                "<td></td>"+
                "<td align=right>"+
                "<b>"+
                timeArray.dowShort+
                "&nbsp;"+
                timeArray.day+
                "-"+
                timeArray.month+
                "-"+
                timeArray.year+
                "</b>"+
                "<br>"+
                team1+
                "<br>"+
                "<small>"+aantalAanwezig+" spelers aanwezig</small>"+
                "</td>"+
                "<td align=left>"+
                "<br>"+
                "&nbsp;&nbsp;-&nbsp;&nbsp;<br><br>"+
                "</td>"+
                "<td align=left>"+
                "<b>"+
                timeArray.time+"<br>"+
                "</b>"+
                team2+
                "<br>"+
                "<small>"+zelfAanwezigText+"</small>"+
                "</td>"+
                "<td></td>"+
                "</tr>"+
                "<tr bgcolor="+color+" onClick='openGame("+game.id+")' height=5px><td colspan=99 ></td></tr>";
    return gameText;
}

function get3TableRows(data1, data2, data3){
    return "<tr><td width=1px></td><td align=left valign=top width=100px>"+data1+"</td><td align=left valign=top width=10px>"+data2+"</td><td align=left valign=top >"+data3+"</td></tr>";
}


function saveEditGame(){
    
    var currentGameID = getCurrentGameID();
    var games = getUserData().foundGames;
    var game = null;
    for(var index = 0; index < games.length; index++) {
        var testgame = games[index];
        if (games[index].id==currentGameID){
            game = games[index];
        }
    }
    
    if (game==null) return;
    
    game.score = document.getElementById('editGameUitslag').value;
    game.points = document.getElementById('editGamePoints').value;
    game.opponent = document.getElementById('editGameOpponent').value;
    game.meetingpoint = document.getElementById('editGameMeetingPoint').value;
    if (document.getElementById('editGameHomegame').checked){
        game.homegame = 1;
    }
    else{
        game.homegame = 0;
    }
    // parse the date/time
    var gameDate = document.getElementById('editGameDate').value;
    var newGameTime = document.getElementById('editGameTime').value;
    var days = parseInt(gameDate.split("-")[0],10);
    var months = parseInt(gameDate.split("-")[1],10)-1;
    var year = parseInt(gameDate.split("-")[2],10);
    var hours = parseInt(newGameTime.split(":")[0],10);
    var minutes = parseInt(newGameTime.split(":")[1],10);   
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
    game.datetime = dateTimeInt;
    game.gamedate = dateTimeInt;
    
    

//-----------------
    // find the team that belongs to this game
    var selectedTeam = null;
    for(var index2 = 0; index2 < getUserData().teams.length; index2++) {
        var team = getUserData().teams[index2];
        if (team.id == game.teamID) selectedTeam = team;
    }
    if (selectedTeam==null) return;
    var team = selectedTeam;
    
    // load all teammembers in an array
    var teammembersArray = new Array();
    for ( var j=0; j<team.teammembers.length; ++j ){
        var teammember = team.teammembers[j];
        teammembersArray[teammember.id] = teammember;                 
    }
            
    var listFieldArray = new Array();
    var listDescriptionArray = new Array();
    var listFieldTypeArray = new Array();
    
    var fieldIndex = 0;
    listFieldArray[fieldIndex] = "goals";
    listDescriptionArray[fieldIndex] = "Doelpunten";
    listFieldTypeArray[fieldIndex] = 0;
    
    fieldIndex++;
    listFieldArray[fieldIndex] = "membersPresentYes";
    listDescriptionArray[fieldIndex] = "Aanwezig";
    listFieldTypeArray[fieldIndex] = 2;
    
    fieldIndex++;
    listFieldArray[fieldIndex] = "membersPresentNo";
    listDescriptionArray[fieldIndex] = "Afwezig";
    listFieldTypeArray[fieldIndex] = 2;
    
    fieldIndex++;
    listFieldArray[fieldIndex] = "membersPresentUnknown";
    listDescriptionArray[fieldIndex] = "Weet Niet";
    listFieldTypeArray[fieldIndex] = 2;
    
    for (i=1;i<=10;i++){
        var listname = team["listname"+i];
        var listtype = team["listtype"+i];
        //alert(listname);
        if (listname!=null && listname!=""){
            fieldIndex++;
            listFieldArray[fieldIndex] = "list"+i;
            listDescriptionArray[fieldIndex] = listname;
            listFieldTypeArray[fieldIndex] = listtype;
        }
    }
    for(var index3 = 0; index3 < listFieldArray.length; index3++) {
        var fieldName = listFieldArray[index3];
        var listDataOld = game[fieldName];
        var listname = listDescriptionArray[index3];
        var listType = listFieldTypeArray[index3];
        var listData = "";
        if (listname!="" && listname!=null){
            for(var index4 = 0; index4 < team.teammembers.length; index4++) {
                var teammember = team.teammembers[index4];
                var listnr = index3;
                fieldnamePrefix = "list_"+listnr+"_";
                if (listnr==0) fieldnamePrefix = "list_goals_";
                if (listnr==1) fieldnamePrefix = "list_PresentYes_";
                if (listnr==2) fieldnamePrefix = "list_PresentNo_";
                if (listnr==3) fieldnamePrefix = "list_PresentUnknown_";
                fieldID = fieldnamePrefix+teammember.id;
                if (listType==2){
                    if (document.getElementById(fieldID).checked){
                       listData+= teammember.id+" ";
                    }
                }
                else{
                    var value = document.getElementById(fieldID).value;
                    if (value!=null && value!=""){
                       listData+= teammember.id+"*"+value+" ";
                    }
                }
            }
            game[fieldName]=listData;
            //alert(fieldName+" oud:"+listDataOld+"  nieuw:"+listData);
        }
    }    
    
    
    saveGame(game);
    hideEditGame();
}

function getListDataNumber(teammembersArray,listData){
    if (listData==null) return "";
    var text = "";
    var arrayData = listData.split(" ");
    for ( var i=0, len=arrayData.length; i<len; ++i ){
        arrayItem = arrayData[i];
        var valArray = arrayItem.split("*");
        if (valArray.length==2){
            memberID=valArray[0];
            value = valArray[1];
            if (value!=null && value!=""){
                if (teammembersArray[memberID]!=null){
                    if (text!="") text+=", ";
                    text+=teammembersArray[memberID].nickname+":"+value;
                }                    
            }
        }
    }
    return text;
}

function getListDataCheck(teammembersArray,listData){
    if (listData==null) return "";
    var text = "";
    var arrayData = listData.split(" ");
    for ( var i=0, len=arrayData.length; i<len; i++ ){
        memberID = arrayData[i];
        if (memberID!=null && memberID!=""){
            if (teammembersArray[memberID]!=null){
                if (text!="") text+=", ";
                text+=teammembersArray[memberID].nickname;
            }                    
        }
    }
    return text;
}


function loadGameData(){
    var games = "";
    var currentGameID = getCurrentGameID();
    var gameText = "";
    var gameEditText = "";
    games = getUserData().foundGames;
    
    gameText +="<table id=table_game>";
    gameEditText +="<table id=table_gameedit>";
    for(var index = 0; index < games.length; index++) {
        var game = games[index];
        if (game.id==currentGameID){
            // hide or show the edit button            
            if (game.userIsAdmin==true){
                document.getElementById('gameButtonEdit').style.display = "";
            }
            else{
                document.getElementById('gameButtonEdit').style.display = "none";
            }
            
            // find the team that belongs to this game
            var selectedTeam = null;
            for(var index2 = 0; index2 < getUserData().teams.length; index2++) {
                var team = getUserData().teams[index2];
                if (team.id == game.teamID) selectedTeam = team;
            }
            if (selectedTeam==null) break;
            
            // load all teammembers in an array
            var teammembersArray = new Array();
            for ( var j=0; j<selectedTeam.teammembers.length; ++j ){
                var teammember = selectedTeam.teammembers[j];
                teammembersArray[teammember.id] = teammember;                 
            }
            
            
            
            var homegame = "thuis";
            var homegameChecked = "checked";
            if (game.homegame==0) {
                homegame = "uit";
                homegameChecked = "";
            }
    
            var zelfAanwezig = "ja";
            var zelfAanwezigImages = "";
            if (game.userPresent==0) {
                zelfAanwezig = "weet niet";
                zelfAanwezigImages += "<img src='knopaanwezig.png' onclick='gameAanwezig()' >";
                zelfAanwezigImages += "<img src='knopafwezig.png' onclick='gameAfwezig()' >";
                zelfAanwezigImages += "<img src='knopweetniet2.png' onclick='gameWeetNiet()' >";
            }
            if (game.userPresent==1) {
                zelfAanwezig = "ja";
                zelfAanwezigImages += "<img src='knopaanwezig2.png' onclick='gameAanwezig()' >";
                zelfAanwezigImages += "<img src='knopafwezig.png' onclick='gameAfwezig()' >";
                zelfAanwezigImages += "<img src='knopweetniet.png' onclick='gameWeetNiet()' >";
            }
            if (game.userPresent==2) {
                zelfAanwezig = "nee";
                zelfAanwezigImages += "<img src='knopaanwezig.png' onclick='gameAanwezig()' >";
                zelfAanwezigImages += "<img src='knopafwezig2.png' onclick='gameAfwezig()' >";
                zelfAanwezigImages += "<img src='knopweetniet.png' onclick='gameWeetNiet()' >";
            }
            
            //gameText += "<tr><td align=left valign=top colspan=99>"+zelfAanwezigImages+"</td></tr>";



//            gameText += get3TableRows("<b>id</b>","&nbsp;<b>:</b>&nbsp;",game.id);
            var timeArray = extractTime(game.dateTimeStr);
            
            
           
            gameText += get3TableRows("<b>datum</b>","&nbsp;<b>:</b>&nbsp;",timeArray.dowShort+"&nbsp;"+timeArray.day+"-"+timeArray.month+"-"+timeArray.year);
            gameText += get3TableRows("<b>tijd</b>","&nbsp;<b>:</b>&nbsp;",timeArray.time);
            var team1 = game.teamname;
            var team2 = game.opponent;
            if (game.homegame==0) {
                team1 = game.opponent;
                team2 = game.teamname;
            }
            team1 = team1.replace(/ /g, "&nbsp;");
            team2 = team2.replace(/ /g, "&nbsp;");
            gameText += get3TableRows("<b>wedstrijd</b>","&nbsp;<b>:</b>&nbsp;",team1+"&nbsp;-&nbsp;"+team2);
            gameText += get3TableRows("<b>uit/thuis</b>","&nbsp;<b>:</b>&nbsp;",homegame);
            gameText += get3TableRows("<b>verzamelplek</b>","&nbsp;<b>:</b>&nbsp;",game.meetingpoint);            
            gameText += get3TableRows("<b>uitslag</b>","&nbsp;<b>:</b>&nbsp;",game.score);
            gameText += get3TableRows("<b>punten</b>","&nbsp;<b>:</b>&nbsp;",game.points);
            gameText += get3TableRows("<b>Doelpuntenmakers</b>","&nbsp;<b>:</b>&nbsp;",getListDataNumber(teammembersArray,game.goals));
            var aantalAanwezig = game.membersPresentYesNames.split(",").length;
            var aantalAfwezig = game.membersPresentNoNames.split(",").length;
            var aantalWeetniet = game.membersPresentUnknownNames.split(",").length;
            if (game.membersPresentYesNames=="") aantalAanwezig = 0;
            if (game.membersPresentNoNames=="") aantalAfwezig = 0;
            if (game.membersPresentUnknownNames=="") aantalWeetniet = 0;
            
            gameText += get3TableRows("<b>aanwezig</b>","&nbsp;<b>:</b>&nbsp;","("+aantalAanwezig+") "+game.membersPresentYesNames);
            gameText += get3TableRows("<b>afwezig</b>","&nbsp;<b>:</b>&nbsp;","("+aantalAfwezig+") "+game.membersPresentNoNames);
            gameText += get3TableRows("<b>niet&nbsp;opgegeven</b>","&nbsp;<b>:</b>&nbsp;","("+aantalWeetniet+") "+game.membersPresentUnknownNames);           
            
            for (i=1;i<=10;i++){
                var listname = selectedTeam["listname"+i];
                var listtype = selectedTeam["listtype"+i];
                //alert(listname);
                if (listname!=null && listname!=""){
                    if (listtype==2){
                        gameText += get3TableRows("<b>"+listname+"</b>","&nbsp;<b>:</b>&nbsp;",getListDataCheck(teammembersArray,game["list"+i]));
                    }
                    else{
                        gameText += get3TableRows("<b>"+listname+"</b>","&nbsp;<b>:</b>&nbsp;",getListDataNumber(teammembersArray,game["list"+i]));
                    }
                    
                }
            }
            gameText +=  "<tr><td width=10px></td><td align=left valign=center width=100px><b>zelf aanwezig</b>"+
            "</td><td align=left valign=center >&nbsp;<b>:</b>&nbsp;</td><td align=left valign=center width=240' >"+
            zelfAanwezigImages+"</td></tr>";
            
            
            // print messages
            if (game.messages!=null && game.messages!="null"){
                gameText += "<tr><td></td><td align=left valign=top colspan=99><br>"+game.messages+"</td></tr>";
            }
//            gameText += "<tr><td align=left valign=top colspan=99><textarea id=newGameMessageTextArea></textarea></td></tr>";
//            gameText += "<tr><td align=left valign=top colspan=99><img src='nieuwbericht.png' onClick='addGameMessage()'></td></tr>";
            
            gameEditText += get3TableRows("<b>uitslag</b>","&nbsp;<b>:</b>&nbsp;","<input type='text' id='editGameUitslag' value='"+game.score+"'/>");
            gameEditText += get3TableRows("<b>punten</b>","&nbsp;<b>:</b>&nbsp;","<input type='text' id='editGamePoints' value='"+game.points+"'/>");
            gameEditText += get3TableRows("<b>datum</b>","&nbsp;<b>:</b>&nbsp;","<input type='text' id='editGameDate' value='"+timeArray.day+"-"+timeArray.month+"-"+timeArray.year+"'/>");
            gameEditText += get3TableRows("<b>tijd</b>","&nbsp;<b>:</b>&nbsp;","<input type='text' id='editGameTime' value='"+timeArray.time+"'/>");
            gameEditText += get3TableRows("<b>tegenstander</b>","&nbsp;<b>:</b>&nbsp;","<input type='text' id='editGameOpponent' value='"+game.opponent+"'/>");
            gameEditText += get3TableRows("<b>thuiswedstrijd</b>","&nbsp;<b>:</b>&nbsp;","<input type='checkbox' id='editGameHomegame' "+homegameChecked+"/>");
            gameEditText += get3TableRows("<b>verzamelplaats</b>","&nbsp;<b>:</b>&nbsp;","<input type='text' id='editGameMeetingPoint' value='"+game.meetingpoint+"'/>");


            /****
             *  Print lijsten
             */
            var listFieldArray = new Array();
            var listDescriptionArray = new Array();
            var listFieldTypeArray = new Array();
            
            var fieldIndex = 0;
            listFieldArray[fieldIndex] = "goals";
            listDescriptionArray[fieldIndex] = "Doelpunten";
            listFieldTypeArray[fieldIndex] = 0;
            
            fieldIndex++;
            listFieldArray[fieldIndex] = "membersPresentYes";
            listDescriptionArray[fieldIndex] = "Aanwezig";
            listFieldTypeArray[fieldIndex] = 2;
            
            fieldIndex++;
            listFieldArray[fieldIndex] = "membersPresentNo";
            listDescriptionArray[fieldIndex] = "Afwezig";
            listFieldTypeArray[fieldIndex] = 2;
            
            fieldIndex++;
            listFieldArray[fieldIndex] = "membersPresentUnknown";
            listDescriptionArray[fieldIndex] = "Weet&nbsp;niet";
            listFieldTypeArray[fieldIndex] = 2;
            
            game["membersPresentUnknown"] = "";// maak een lege membersPresentUnknown
            
            for (i=1;i<=10;i++){
                var listname = selectedTeam["listname"+i];
                var listtype = selectedTeam["listtype"+i];
                //alert(listname);
                if (listname!=null && listname!=""){
                    fieldIndex++;
                    listFieldArray[fieldIndex] = "list"+i;
                    listDescriptionArray[fieldIndex] = listname;
                    listFieldTypeArray[fieldIndex] = listtype;
                }
            }
            
            gameEditText += "<tr><td align=left valign=top colspan=99><table>";
            // print header row
            gameEditText += "<tr>";
            gameEditText += "<td></td>";
            gameEditText += "<td>&nbsp;&nbsp;&nbsp;</td>";
            for(var index3 = 0; index3 < listFieldArray.length; index3++) {
                gameEditText += "<td align=left>"+listDescriptionArray[index3]+"</td>";
                gameEditText += "<td>&nbsp;&nbsp;&nbsp;</td>";
            }
            gameEditText += "</tr>";
            
            // print list data: all users
            var aanwezigheidArray = new Array(); 
            var afwezigheidArray = new Array();
            for(var index4 = 0; index4 < selectedTeam.teammembers.length; index4++) {
                var color = "#ffffff";
                if (index4 %2 ==0){
                    color = "#ecf4d9";
                }
                
                var teammember = selectedTeam.teammembers[index4];
                gameEditText += "<tr bgcolor="+color+">";
                gameEditText += "<td align=left>"+teammember.nickname+"</td>";
                gameEditText += "<td>&nbsp;&nbsp;&nbsp;</td>";
                for(var index3 = 0; index3 < listFieldArray.length; index3++) {
                    gameEditText += "<td>";
                    var listdata = game[listFieldArray[index3]];
                    var listname = listDescriptionArray[index3];
                    var listType = listFieldTypeArray[index3];
                    if (listname!="" && listname!=null){
                        gameEditText += printListitem(teammember.id,listdata,listType,index3,aanwezigheidArray, afwezigheidArray);        
                    }
                    gameEditText += "<td>&nbsp;&nbsp;&nbsp;</td>";
                }
                gameEditText += "</tr>";
                
            }
            gameEditText += "</table></td></tr>";
            /****
             * Einde print lijsten
             */

            
        }
    }
    gameText +="</table>";
    gameEditText +="</table>";
    
    document.getElementById('gameData').innerHTML = gameText;
    document.getElementById('editgameData').innerHTML = gameEditText;
    
}



function printListitem(memberID, list, proptype, listnr, aanweziglijst, afweziglijst){
    fieldnamePrefix = "list_"+listnr+"_";
    if (listnr==0) fieldnamePrefix = "list_goals_";
    if (listnr==1) fieldnamePrefix = "list_PresentYes_";
    if (listnr==2) fieldnamePrefix = "list_PresentNo_";
    if (listnr==3) fieldnamePrefix = "list_PresentUnknown_";
    
    
    if (listnr==3){
        // check if user is unknown
        var aanwezigheidUnknown = true;
        if (true==aanweziglijst[memberID] || true==afweziglijst[memberID] ){
            // user is in de aanwezig of afwezig lijst
            aanwezigheidUnknown = false;
        }
        
        //
        if (aanwezigheidUnknown){
            //voor de unknown value, deze moet zelf ingevuld worden 
            list = ""+memberID;
        }
    }
    


    if (list==null) list = "";
    var arrayData = list.split(" ");
    if (proptype==2){
        checked = "";
        for ( var i=0, len=arrayData.length; i<len; ++i ){
            idInList = arrayData[i];
            if (memberID==idInList){
                checked = "checked";                
                if (listnr==1) aanweziglijst[memberID] = true;
                if (listnr==2) afweziglijst[memberID] = true;
                
            }
        }
        onclickValue = "";
        fieldID = fieldnamePrefix+memberID;
        if (listnr==1 || listnr==2 || listnr==3 ){
            if (listnr==3){
                // for the 3 present fields
                field1 = "list_PresentYes_"+memberID;
                field2 = "list_PresentNo_"+memberID;
            }
            if (listnr==2){
                // for the 3 present fields
                field1 = "list_PresentUnknown_"+memberID;
                field2 = "list_PresentYes_"+memberID;
            }
            if (listnr==1){
                // for the 3 present fields
                field1 = "list_PresentNo_"+memberID;
                field2 = "list_PresentUnknown_"+memberID;
            }
            onclickValue="onclick='document.getElementById(\""+field1+"\").checked=false;document.getElementById(\""+field2+"\").checked=false;'";
        }
        
        return "<input type='checkbox' class='gameCheckbox' value='true' id='"+fieldID+"' "+checked+" "+onclickValue+"/>";
//        return checked;


    }
    if (proptype==1){
        value = "";
        for ( var i=0, len=arrayData.length; i<len; ++i ){
            arrayItem = arrayData[i];
            var valArray = arrayItem.split("*");
            if (valArray.length==2){
                if (memberID==valArray[0]){
                    value = valArray[1];
                }
            }
        }    
        return "<input type='text' class='listEditFields' id='"+fieldnamePrefix+memberID+"' value='"+value+"'  size=10/>&nbsp;&euro;";
    }
    if (proptype==0){
        value = "";
        for ( var i=0, len=arrayData.length; i<len; ++i ){
            arrayItem = arrayData[i];
            var valArray = arrayItem.split("*");
            if (valArray.length==2){
                if (memberID==valArray[0]){
                    value = valArray[1];
                }
            }
        }    
        return "<input type='text' class='listEditFields' id='"+fieldnamePrefix+memberID+"' value='"+value+"' size=10/>";
    }

    return "";
}


function saveAddMessage(){
    var games = "";
    var currentGameID = getCurrentGameID();
    var gameText = "";
    
    games = getUserData().foundGames;

    gameText +="<table>";
    for(var index = 0; index < games.length; index++) {
        var game = games[index];
        if (game.id==currentGameID){
            //alert("oud:"+game.messages);
            //var messages = game.messages;
            var userData = getUserData();
            var d = new Date();
            var extraZero = "";
            if (d.getMinutes()<10){
                extraZero = "0";
            }
            var time = d.getHours()+":"+extraZero+d.getMinutes();
            var months = d.getMonth()+1; 
            var date = d.getDate()+"-"+months; 
            var newMessage="<b>op "+date+" om "+time+" schreef "+game.mynickname+":</b><br>"+document.getElementById('newGameMessageTextArea').value+"<br><br>";
            addMessageCall(currentGameID, newMessage);
        }
    }
    
}

function addMessageCall(gameID, message){
    var JSONObject = new Object;
    JSONObject.request = "addMessage";
    JSONObject.gameID = gameID;
    JSONObject.newMessage = message;
    
    runAjax(JSONObject, function onSuccess(resultJSON) {
        hideAddMessage();
        refresh();
        emailMessage();
    }, function onError(resultJSON) {
        showGlobalError("Fout bij saveGame:"+resultJSON.errorMsg);
    }, false);    
}

function emailMessage(){
    var JSONObject = new Object;
    JSONObject.request = "emailMessages";
    JSONObject.gameID = getCurrentGameID();
    runAjax(JSONObject, function onSuccess(resultJSON) {
    }, function onError(resultJSON) {
        showGlobalError("Fout bij emailMessages:"+resultJSON.errorMsg);
    }, false);    
}

function gameAfwezig(){
    changeGameAanwezigheid("setAfwezig");
}

function gameWeetNiet(){
    changeGameAanwezigheid("setOnbekend");
}

function gameAanwezig(){
    changeGameAanwezigheid("setAanwezig");
}


function changeGameAanwezigheid(aanwezigFunction){
    var currentGameID = getCurrentGameID();
    var memberID = "";

    // find memberID    
    var games = "";
    games = getUserData().foundGames;
    for(var index = 0; index < games.length; index++) {
        var game = games[index];
        if (game.id==currentGameID){
            memberID = game.teammemberID;
        }
    }
    
    var JSONObject = new Object;
    JSONObject.request = aanwezigFunction;
    JSONObject.gameID = currentGameID;
    JSONObject.memberID = memberID;

    runAjax(JSONObject, function onSuccess(resultJSON) {
        refresh();
    }, function onError(resultJSON) {
        showGlobalError("Fout bij saveGame:"+resultJSON.errorMsg);
    }, false);
}



function saveGame(game){
    var JSONObject = new Object;
    JSONObject.request = "saveGame";
    JSONObject.gameID = game.id;
    JSONObject.score = game.score;
    JSONObject.points = game.points;
    JSONObject.meetingpoint = game.meetingpoint;
    JSONObject.homegame = game.homegame;
    JSONObject.datetime = game.gamedate;
    JSONObject.gameType = game.gameType;
    JSONObject.gameStatus = game.gameStatus;
    JSONObject.opponent = game.opponent;
    
    JSONObject.membersPresentYes = game.membersPresentYes;
    JSONObject.membersPresentNo = game.membersPresentNo;
    JSONObject.goals = game.goals;

    JSONObject.list1 = game.list1;
    JSONObject.list2 = game.list2;
    JSONObject.list3 = game.list3;
    JSONObject.list4 = game.list4;
    JSONObject.list5 = game.list5;
    JSONObject.list6 = game.list6;
    JSONObject.list7 = game.list7;
    JSONObject.list8 = game.list8;
    JSONObject.list9 = game.list9;
    JSONObject.list10 = game.list10;
    
    
    if (JSONObject.gameType==null) JSONObject.gameType = "";
    if (JSONObject.gameStatus==null) JSONObject.gameStatus = "";
    if (JSONObject.goals==null) JSONObject.goals = "";
    if (JSONObject.list1==null) JSONObject.list1 = "";
    if (JSONObject.list2==null) JSONObject.list2 = "";
    if (JSONObject.list3==null) JSONObject.list3 = "";
    if (JSONObject.list4==null) JSONObject.list4 = "";
    if (JSONObject.list5==null) JSONObject.list5 = "";
    if (JSONObject.list6==null) JSONObject.list6 = "";
    if (JSONObject.list7==null) JSONObject.list7 = "";
    if (JSONObject.list8==null) JSONObject.list8 = "";
    if (JSONObject.list9==null) JSONObject.list9 = "";
    if (JSONObject.list10==null) JSONObject.list10 = "";
    
    runAjax(JSONObject, function onSuccess(resultJSON) {
        //alert(resultJSON.result.userID);
        refresh();
    }, function onError(resultJSON) {
        showGlobalError("Fout bij saveGame:"+resultJSON.errorMsg);
    }, false);    
}


function loadUitslData(){
    if (getUserData()==null) return;
    var games = getUserData().foundGames;

    var gamesText = "";
    var empty = false;
    gamesText += "<table id=table_uitsl >";
    gamesText += 
            "<tr>"+
            "<td id=spaceleft_uitsl></td>"+
            "<td align=left colspan=3></td>"+
            "<td id=spaceright_uitsl></td>"+
            "</tr>";


    for(var index = 0; index < games.length; index++) {
        var game = games[games.length-index-1];
        if (!gameDateInPast(game.dateTimeStr)) continue;
        var gameText = "";
        gameText = getGameHtmlUitsl(game,index);
        gamesText = gamesText+gameText;
        empty = false;
    }
    
    gamesText += "<tr id=spacebottom_prog><td colspan=99></td><tr>";
   
    gamesText += "</table>";
    
    if (empty){
        gamesText = "<table id=table_uitsl >"+
            "<tr><td id=spaceleft_uitsl></td>"+
            "<td align=left colspan=3><br>Geen uitslagen data beschikbaar</td>"+
            "<td id=spaceright_uitsl></td><tr>"+
            "<tr id=spacebottom_prog><td colspan=99></td><tr>"+
            "</table>";
    }

    
    document.getElementById('uitslData').innerHTML = gamesText;
    // also load game data
    loadGameData();
}


function getGameHtmlUitsl(game, index){
    
    var color = "#ffffff";
    if (index %2 ==0){
        color = "#ecf4d9";
    }
    else{
        color = "#ffffff";
    }    
    
    var scoreArray=game.score.split("-");
    var score1 = "?";
    var score2 = "?";
    if (scoreArray.length>0) score1 = scoreArray[0];
    if (scoreArray.length>1) score2 = scoreArray[1];
    if (score1=="") score1 = "?";
    if (score2=="") score2 = "?";
    
    
    var timeArray = extractTime(game.dateTimeStr);
    var team1 = game.teamname;
    var team2 = game.opponent;
    if (game.homegame==0) {
        team1 = game.opponent;
        team2 = game.teamname;
    }
    team1 = team1.replace(/ /g, "&nbsp;");
    team2 = team2.replace(/ /g, "&nbsp;");
    var gameText = 
                "<tr bgcolor="+color+" onClick='openGame("+game.id+")' height=5px><td colspan=99 ></td></tr>"+


                "<tr bgcolor="+color+" onClick='openGame("+game.id+")'>"+
                "<td></td>"+
                "<td align=right>"+
                "<b>"+
                timeArray.dowShort+
                "&nbsp;"+
                timeArray.day+
                "-"+
                timeArray.month+
                "-"+
                timeArray.year+
                "</b>"+
                "</td>"+
                "<td align=left>&nbsp;"+
                ""+
                "</td>"+
                "<td align=left>&nbsp;"+
                "<b>"+
                timeArray.time+
                "</b>"+
                "</td>"+
                "<td></td>"+
                "</tr>"+

                "<tr bgcolor="+color+" onClick='openGame("+game.id+")'>"+
                "<td></td>"+
                "<td align=right>&nbsp;"+
                team1+
                "</td>"+
                "<td align=left>&nbsp;"+
                "-"+
                "</td>"+
                "<td align=left>&nbsp;"+
                team2+
                "</td>"+
                "<td></td>"+
                "</tr>"+
                
                "<tr bgcolor="+color+" onClick='openGame("+game.id+")'>"+
                "<td></td>"+
                "<td align=right>&nbsp;"+
                score1+
                "</td>"+
                "<td align=left>&nbsp;"+
                "-"+
                "</td>"+
                "<td align=left>&nbsp;"+
                score2+
                "&nbsp;&nbsp;&nbsp;("+game.points+" punten)"+
                "</td>"+
                "<td></td>"+
                "</tr>"+

                "<tr bgcolor="+color+" onClick='openGame("+game.id+")' height=5px><td colspan=99 ></td></tr>";

                
    return gameText;
}



function loadStandData(){
    if (getUserData()==null) return;
    //var compData = getUserData().teams[0].competitions[0].mcompetitions;
    var element = document.getElementById('standData');
    if(element==null) return;
    
    var resultText = "";
    var standFound = false;
    
    for (var index1=0; index1<getUserData().foundManagedCompetitions.length; index1++){
        var competitionID = getUserData().foundManagedCompetitions[index1].competitionID;
        var compData = getUserData().foundManagedCompetitions[index1].mcompetitionData;
        if (compData==null){
            continue;
        }
        
        // zoek team en competitie omschrijving
        var teamname = "";
        var competitionDescription = "";
        for(var index2 = 0; index2 < getUserData().teams.length; index2++) {
            var team = getUserData().teams[index2];
            for(var index3 = 0; index3 < team.competitions.length; index3++) {
                var comp = team.competitions[index3];
                if (comp.id == competitionID){
                    competitionDescription = comp.description;
                    teamname = team.teamname;
                }
            }
        }
        
        
        standFound = true;
        resultText += "<b>"+teamname+"-"+competitionDescription+":</b><br>";
        
        resultText += "<table width=750 border=0 id=dualcolortablestand cellspacing='0'>"+
                        "<tr>"+ 
                        "<td align=left>"+
                        "    <b>Plaats</b>"+
                        "</td>"+    
                        "<td>&nbsp;&nbsp;&nbsp;</td>"+    
                        "<td align=left>"+
                        "    <b>Team</b>"+
                        "</td>"+    
                        "<td>&nbsp;&nbsp;&nbsp;</td>"+    
                        "<td align=left>"+
                        "    <b>Punten</b>"+
                        "</td>"+    
                        "<td>&nbsp;&nbsp;&nbsp;</td>"+    
                        "<td align=left>"+
                        "    <b>Gespeeld</b>"+
                        "</td>"+    
                        "<td>&nbsp;&nbsp;&nbsp;</td>"+    
                        "<td align=left>"+
                        "    <b>Gewonnen</b>"+
                        "</td>"+    
                        "<td>&nbsp;&nbsp;&nbsp;</td>"+    
                        "<td align=left>"+
                        "    <b>Verloren</b>"+
                        "</td>"+    
                        "<td>&nbsp;&nbsp;&nbsp;</td>"+
                        "<td align=left>"+
                        "    <b>Gelijk</b>"+
                        "</td>"+    
                        "<td>&nbsp;&nbsp;&nbsp;</td>"+    
                        "<td align=left>"+
                        "    <b>Strafpunten</b>"+
                        "</td>"+    
                        "<td>&nbsp;&nbsp;&nbsp;</td>"+    
                        "<td align=left>"+
                        "    <b>Saldo</b>"+
                        "</td>"+    
                        ""+
                        "</tr>";
    
        for(var index = 0; index < compData.teams.length; index++) {
            var color = "#ffffff";
            if (index %2 ==0){
                color = "#ecf4d9";
            }
            
            var plaats = index+1;
            
            var item = compData.teams[index];
            var teamname = item.teamname;
            teamname = teamname.replace(/ /g, "&nbsp;");
            resultText += "<tr height=30px bgcolor="+color+" onClick='selectMTeam("+item.id+",\""+teamname+"\")'>"+
            "<td align=left>" +plaats +"</td><td></td>"+
            "<td align=left>" +teamname +"</td><td></td>"+
            "<td align=left>" +item.punten +"</td><td></td>"+
            "<td align=left>" +item.numGespeeld +"</td><td></td>"+
            "<td align=left>" +item.numGewonnen +"</td><td></td>"+
            "<td align=left>" +item.numVerloren +"</td><td></td>"+
            "<td align=left>" +item.numGelijk +"</td><td></td>"+
            "<td align=left>" +item.strafpunten +"</td><td></td>"+
            "<td align=left>" +item.saldoVoor +"-"+item.saldoTegen +"</td><td></td>"+
            "</tr>";
        }
        resultText += "</table><br>";
        
    }

    if (!standFound){
        resultText += "Geen beheerde competities gevonden. Standen zijn niet beschikbaar";
    }
    element.innerHTML = resultText;
    
}



function findTeamMembersForLists(teammembers,games,listName){
    var resultArray = new Array();
    var testArray = new Array();
    var allMembers = new Array();
    var idx=0;
    // first add all current players (not deleted and not supporter) 
    for(var index = 0; index < teammembers.length; index++) {
        var item = teammembers[index];
        allMembers[item.id] = item;
        if (!item.deleted && !item.supporter){
            resultArray[idx] = item;
            testArray[item.id] = "1";
            idx++;
        }
    }
    
    for(var index = 0; index < games.length; index++) {
        var game = games[index];
        addNewPlayersToList(testArray, resultArray, allMembers, game[listName]);
    }
    
    
    return resultArray;
}


function addNewPlayersToList(testArray, resultArray, allMembers, list){
    if (list==null){
        return
    }
    if (list=="null"){
        return
    }
    var values = list.split(" ");
    for ( var i=0, len=values.length; i<len; ++i ){
        var value2=values[i]+"*";
        var values2 = value2.split("*");
        if (values2.length>0){
            var userID = values2[0];
            if (userID.trim()!=""){
                if (!(userID in testArray)){
                    testArray[userID] = "1";
                    var index = resultArray.length;
                    var item = allMembers[userID];
                    resultArray[index] = item;
                }
            }
        }
    }
}


function extractMemberListDataNumber(memberID, list, gameID) {
    var listValue = "";
    if (list!=null){
        var values = list.split(" ");
        for ( var i=0, len=values.length; i<len; ++i ){
            var value2 = values[i]+"";
            var values2 = value2.split("*");
            if (values2.length==2){
                if (values2[1]!=""){
                    var userID = values2[0];
                    if (userID==memberID){
                        if (values2[1]!='0'){                            
                            var floatValue = parseFloat(values2[1].replace(",","."));
                            grandSummary += floatValue; 
                            playerSummary += floatValue; 
                            gameSummary[gameID]+=floatValue;
                            //alert("set "+gameID);
                            listValue = values2[1];
                        }
                    }
                }
            }
        }
    }
    return listValue;
}


function extractMemberListDataMoney(memberID, list, gameID) {
    var listValue = "";
    if (list!=null){
        var values = list.split(" ");
        for ( var i=0, len=values.length; i<len; ++i ){
            var value2 = values[i]+"";
            var values2 = value2.split("*");
            if (values2.length==2){
                if (values2[1]!=""){
                    var userID = values2[0];
                    if (userID==memberID){
                        if (values2[1]!='0'){
                            var floatValue = parseFloat(values2[1].replace(",","."));
                            grandSummary += floatValue; 
                            playerSummary += floatValue; 
                            gameSummary[gameID]+=floatValue;;
                            listValue = values2[1];
                        }
                    }
                }
            }
        }
    }
    return listValue;
}


function extractMemberListDataCheck(memberID, list, gameID) {
    var listValue = "";
    var readOnlyValue = ".";
    if (list!=null){
        var values = list.split(" ");
        for ( var i=0, len=values.length; i<len; ++i ){
            var userID = values[i];
            if (userID==memberID){
                listValue = " checked ";
                grandSummary += 1; 
                playerSummary += 1; 
                gameSummary[gameID]+=1;
                readOnlyValue = "X";
            }
        }
    }
    return readOnlyValue;
    
}


function loadStatData(){
    loadStatDataPage1();
    loadGameData();
}

function selectLijst(lijstNr, teamID){
    if (getUserData()==null) return;
    var games = getUserData().foundGames;
    var gamesText = "";
    

    var teamData = null;
    
    if (getUserData().usedTeams.length==0){
        document.getElementById('stat2Data').innerHTML = "Geen data beschikbaar";
        return;
    }
    
    for (index = 0; index<getUserData().teams.length; index++){
        var team = getUserData().teams[index];
        if (team.id == teamID){
            teamData = team;
        }
    }

    if (teamData==null){
        document.getElementById('stat2Data').innerHTML = "Geen lijstdata gevonden";
        return;
    }


    var listName = "";
    if (lijstNr==-11){
         listName = "Doelpuntenmakers";
    }
    else if (lijstNr==-12) {
        listName = "Aanwezigheid";
    }
    else{
        var listNameFieldName = "listname"+lijstNr;
        listName = teamData[listNameFieldName];
    }
    
    
    var listType = 0;
    if (lijstNr==-11){
         listType = 0;
    }
    else if (lijstNr==-12) {
        listType = 2;
    }
    else{
        var listTypeFieldName = "listtype"+lijstNr;
        listType = teamData[listTypeFieldName];;
    }
    
    var listDataFieldName = "list"+lijstNr;
    if (lijstNr==-11){
        listDataFieldName = "goals";
    }
    else if (lijstNr==-12) {
        listDataFieldName = "membersPresentYes";
    }
    
   document.getElementById('listNameHeader').innerHTML = listName;
    
//    gamesText += "<img src='return.png' onclick='selectStat()' >";

    //gamesText += "&nbsp;&nbsp;&nbsp;<b>"+listName+":</b><br><br>";
    gamesText += "<table>";
    
    // header
    gamesText += "<tr>";
    gamesText += "<td></td>";// teammember
    gamesText += "<td></td>";// extra spaces
    gamesText += "<td></td>";// user summary
    gamesText += "<td></td>";// extra spaces
    for(var index = 0; index < games.length; index++) {
        var game = games[index];
        var gameID = game.id;
        
        if (game.teamID != teamID) continue;

        var gameText = "";
        var gameDate = new Date(game.gamedate * 1000);
        var day = gameDate.getDate();
        var month = gameDate.getMonth();
        var monthNames = [ "jan", "feb", "maa", "apr", "mei", "jun",
            "jul", "aug", "sep", "okt", "nov", "dec" ];
        gamesText += "<td onClick='openGame("+game.id+")'>"+day+"&nbsp;"+monthNames[month]+"</td>";

        gamesText += "</td>";
        gamesText += "<td>&nbsp;&nbsp;</td>";
        // reset summery
        gameSummary[gameID]=0;
        
    }
    gamesText += "</tr>";
    

    grandSummary = 0; 

    // list all teammembers
    var listTeammembers = findTeamMembersForLists(teamData.teammembers,games,listName);
    for(var index2 = 0; index2 < listTeammembers.length; index2++) {
        var teammember = listTeammembers[index2];
        playerSummary = 0; 
        playerDataText = "";

        var gameIndex = 0;
        for(var index = 0; index < games.length; index++) {
            var game = games[index];
            var gameID = game.id;
            var listvalue = game[listDataFieldName];
            if (game.teamID != teamID) continue;
                gameIndex++;

                var color = "#ffffff";
                if (index2 % 2 ==0){
                    if (gameIndex %2 ==0){
                        color = "#ecf4d9";
                    }
                    else{
                        color = "#dce3cb";
                    }
                }
                else{
                    if (gameIndex %2 ==0){
                        color = "#cbd3b7";
                    }
                    else{
                        color = "#bac3a4";
                    }
                }
                
                playerDataText += "<td bgcolor="+color+">";
                if (listType==0){
                    playerDataText += extractMemberListDataNumber(teammember.id, listvalue, gameID);
                }
                if (listType==1){
                    playerDataText += extractMemberListDataMoney(teammember.id, listvalue, gameID);
                }
                if (listType==2){
                    playerDataText += extractMemberListDataCheck(teammember.id, listvalue, gameID);
                }
                playerDataText += "</td>";
                playerDataText += "<td bgcolor="+color+">&nbsp;&nbsp;</td>";
        }
        gamesText += "<tr>";
        var nickname = teammember.nickname;
        nickname = nickname.replace(/ /g, "&nbsp;");
        gamesText += "<td align=left>"+nickname+"</td>";
        gamesText += "<td>&nbsp;&nbsp;&nbsp;</td>";
        if (listType==1){
            gamesText += "<td><b>"+playerSummary+" &euro;</b></td>";
        }
        else{
            gamesText += "<td><b>"+playerSummary+"</b></td>";
        }
        gamesText += "<td>&nbsp;&nbsp;&nbsp;</td>";
        gamesText += playerDataText;
        gamesText += "</tr>";
    }
    
    // print totals onderaan scherm
    // totals per date
    gamesText += "<tr height=5>";
    gamesText += "<td colspan=999 class='listButtonSeperator' ></td>";
    gamesText += "</tr>";

    gamesText += "<tr>";
    gamesText += "<td align=left>Totaal</td>";// user
    gamesText += "<td></td>";// space
    gamesText += "<td>";
    gamesText += "<b>"+grandSummary+"</b>";
    gamesText += "</td>";
    gamesText += "<td></td>";// space
    for(var index = 0; index < games.length; index++) {
        var game = games[index];
        if (game.teamID != teamID) continue;
        gamesText += "<td>";
        var gameID = game.id;
        if (listType==0){
            gamesText += "<b>"+Math.round(gameSummary[gameID]*100)/100+"</b>";
        }
        if (listType==1){
            gamesText += "<b>"+Math.round(gameSummary[gameID]*100)/100+"&nbsp;&euro;"+"</b>";
        }
        if (listType==2){
            gamesText += "<b>"+Math.round(gameSummary[gameID]*100)/100
        }
        gamesText += "</td>";
        gamesText += "<td>";
        }
    gamesText += "</tr>";    
    gamesText += "</table>";
    
    document.getElementById('stat2Data').innerHTML = gamesText;
    selectStat2();
}


function loadStatDataPage1(){
    if (getUserData()==null) return;
    var games = getUserData().foundGames;
    var gamesText = "";

    var teamData = null;
    var multipleTeams = false;
    
    if (getUserData().usedTeams.length==0){
        gamesText += 
                "<table id=table_stat>"+
                "<tr>"+
                "<td id=spaceleft_stat></td>"+
                "<td align=left ><br>Geen data beschikbaar</td>"+
                "<td id=spaceright_stat></td>"+
                "</tr>"+
                "</table>";
        document.getElementById('statData').innerHTML = gamesText;
        return;
    }
    
    gamesText += 
            "<table id=table_stat>"+
            "<tr>"+
            "<td id=spaceleft_stat></td>"+
            "<td>"+
            "</td>"+
            "<td id=spaceright_stat></td>"+
            "</tr>";
            
    multipleTeams = getUserData().usedTeams.length>1;
    
    for (i = 0; i<getUserData().usedTeams.length; i++){
        var teamID = getUserData().usedTeams[i];
        color0 = "#ecf4d9";
        color1 = "#ffffff";
        color2 = "#ffffff";
        
        
        for (index = 0; index<getUserData().teams.length; index++){
            var team = getUserData().teams[index];
            if (team.id == teamID){
                teamData = team;
            }
        }
    
        if (!multipleTeams){
            gamesText += "<tr bgcolor="+color0+" height=40px><td></td><td><b>Selecteer een lijst:</b></td><td></td></tr>";
        }
        if (teamData!=null){
            
            if (multipleTeams){
                gamesText += "<tr bgcolor="+color0+" height=40px><td></td><td><b>Lijsten voor team "+teamData.teamname+":</b></td><td></td></tr>";
            }
            
            gamesText += "<tr bgcolor="+color2+" height=40px><td></td><td><p onClick=selectLijst(-11,"+teamID+")>Doelpuntenmakers</p></td><td></td></tr>";
            gamesText += "<tr bgcolor="+color1+" height=40px><td></td><td><p onClick=selectLijst(-12,"+teamID+")>Aanwezigheid</p></td><td></td></tr>";
    
            if (teamData.listname1!=null) gamesText += "<tr bgcolor="+color2+" height=40px><td></td><td><p onClick=selectLijst(1,"+teamID+")>"+teamData.listname1+"</p></td><td></td></tr>";
            if (teamData.listname2!=null) gamesText += "<tr bgcolor="+color1+" height=40px><td></td><td><p onClick=selectLijst(2,"+teamID+")>"+teamData.listname2+"</p></td><td></td></tr>";
            if (teamData.listname3!=null) gamesText += "<tr bgcolor="+color2+" height=40px><td></td><td><p onClick=selectLijst(3,"+teamID+")>"+teamData.listname3+"</p></td><td></td></tr>";
            if (teamData.listname4!=null) gamesText += "<tr bgcolor="+color1+" height=40px><td></td><td><p onClick=selectLijst(4,"+teamID+")>"+teamData.listname4+"</p></td><td></td></tr>";
            if (teamData.listname5!=null) gamesText += "<tr bgcolor="+color2+" height=40px><td></td><td><p onClick=selectLijst(5,"+teamID+")>"+teamData.listname5+"</p></td><td></td></tr>";
            if (teamData.listname6!=null) gamesText += "<tr bgcolor="+color1+" height=40px><td></td><td><p onClick=selectLijst(6,"+teamID+")>"+teamData.listname6+"</p></td><td></td></tr>";
            if (teamData.listname7!=null) gamesText += "<tr bgcolor="+color2+" height=40px><td></td><td><p onClick=selectLijst(7,"+teamID+")>"+teamData.listname7+"</p></td><td></td></tr>";
            if (teamData.listname8!=null) gamesText += "<tr bgcolor="+color1+" height=40px><td></td><td><p onClick=selectLijst(8,"+teamID+")>"+teamData.listname8+"</p></td><td></td></tr>";
            if (teamData.listname9!=null) gamesText += "<tr bgcolor="+color2+" height=40px><td></td><td><p onClick=selectLijst(9,"+teamID+")>"+teamData.listname9+"</p></td><td></td></tr>";
            if (teamData.listname10!=null) gamesText += "<tr bgcolor="+color1+" height=40px><td></td><td><p onClick=selectLijst(10,"+teamID+")>"+teamData.listname10+"</p></td><td></td></tr>";
        }
    }
    gamesText += "<tr id=spacebottom_stat><td colspan=99></td><tr>";
    gamesText += 
            "</table>";
    
    document.getElementById('statData').innerHTML = gamesText;
}


function selectMTeam(mTeamID,teamname){
    var JSONObject = new Object;
    JSONObject.request = "loadMTeamGames";
    JSONObject.mTeamID=mTeamID;
    runAjax(JSONObject, function onSuccess(resultJSON) {
        //alert(resultJSON.result.userID);
        if (resultJSON.result!=null){
            showMTeam(resultJSON.result, teamname);
        }
        else{
            showGlobalError("Geen data");
        }
    }, function onError(resultJSON) {
        showGlobalError("Fout bij get mTeam:"+resultJSON.errorMsg);
    }, false);
}


function showMTeam(games, teamname){
    var gamesText = "";
    var empty = true;

    document.getElementById('mgameName').innerHTML = "Wedstrijden voor "+teamname;
//    gamesText += "<b>Wedstrijden voor "+teamname+"</b><br>";
    gamesText += "<table>";
    
    gamesText += 
            "<tr>"+
            "<td align=left ><b>Datum:</b></td>"+
            "<td align=left >&nbsp;&nbsp;</td>"+
            "<td align=left ><b>Tijd:</b></td>"+
            "<td align=left >&nbsp;&nbsp;</td>"+
            "<td align=left ><b>Wedstrijd:</b></td>"+
            "<td align=left >&nbsp;&nbsp;</td>"+
            "<td align=left ><b>Uitslag:</b></td>"+
            "</tr>"+
            "</tr>";

    for(var index = 0; index < games.length; index++) {
        var color = "#ffffff";
        if (index %2 ==0){
            color = "#ecf4d9";
        }
        var game = games[index];
        var timeArray = extractTime(game.dateTimeStr);
        
        gamesText += 
                "<tr height=30px bgcolor="+color+">"+
                "<td align=left >"+timeArray.dowShort+" "+timeArray.day+"-"+timeArray.month+"-"+timeArray.year+"</td>"+
                "<td align=left >&nbsp;&nbsp;</td>"+
                "<td align=left >"+timeArray.time+"</td>"+
                "<td align=left >&nbsp;&nbsp;</td>"+
                "<td align=left >"+game.teamname1+"&nbsp;&nbsp;-&nbsp;&nbsp;"+game.teamname2+"</td>"+
                "<td align=left >&nbsp;&nbsp;</td>"+
                "<td align=left >"+game.score+"</td>"+
                "</tr>"+
                "</tr>";
    }
    
    gamesText = gamesText+"</table>";
      
    document.getElementById('mgamesData').innerHTML = gamesText;
    openMGames();
}
/*************************************************************************/
/*** MONTH PAYMENT FUNCTIONS                                          ****/
/*************************************************************************/
function startBuyMonth(){
    inappbilling.init(buyMonthStep1, purchaseErrorHandler); 
    //buyMonthStep1("test-ok");
}

function buyMonthStep1(result) {
    /*
     * Init succeeded! Log a message before starting the purchase.
     */
    var appData = getUserData();
    logPayment(
        appData.userID,
        appData.username+":before purchase month",
        result, 
        function onSuccess(resultJSON) {
            buyMonthStep2(resultJSON.result);
        },
        ajaxErrorHandler);
}

function buyMonthStep2(result){
    /*
     * Call billing service
     */
    inappbilling.purchase(buyMonthStep3, purchaseErrorHandler,"com.vdzon.mijnsportwedstrijden.3_maanden");
//    inappbilling.purchase(buyMonthStep3, purchaseErrorHandler,"com.vdzon.mijnsportwedstrijden.app.nl.pro");


//    buyMonthStep3("GELUKT"); 

}

function buyMonthStep3(result) {
    /*
     * Purgache succeeded! update server
     */
    var JSONObject = new Object;
    var appData = getUserData();
    JSONObject.request = "buyedMonth";
    JSONObject.userID = appData.userID;
    JSONObject.actionResult = result;   
    runAjax(JSONObject, function onSuccess(resultJSON) {
        buyMonthStep4(resultJSON.result);
    }, ajaxErrorHandler, false);    
}

function buyMonthStep4($newEndDate){
    /*
     * Update finished, new date found, log success
     */
    refresh();
    document.getElementById('endDatePro').innerHTML = $newEndDate;

    var appData = getUserData();
    logPayment(
        appData.userID,
        appData.username+":after purchase month",
        $newEndDate, 
        function onSuccess(resultJSON) {
            buyMonthStep5(resultJSON.result);
        },
        ajaxErrorHandler);
}

function buyMonthStep5(){
}


/*************************************************************************/
/*** YEAR PAYMENT FUNCTIONS                                           ****/
/*************************************************************************/
function startBuyYear(){
    inappbilling.init(buyYearStep1, purchaseErrorHandler); 
}

function buyYearStep1(result) {
    /*
     * Init succeeded! Log a message before starting the purchase.
     */
    var appData = getUserData();
    logPayment(
        appData.userID,
        appData.username+":before purchase year",
        result, 
        function onSuccess(resultJSON) {
            buyYearStep2(resultJSON.result);
        },
        ajaxErrorHandler);
}

function buyYearStep2(result){
    /*
     * Call billing service
     */
    inappbilling.purchase(buyYearStep3, purchaseErrorHandler,"com.vdzon.mijnsportwedstrijden.1_jaar");
    //buyYearStep3("GELUKT"); 

}

function buyYearStep3(result) {
    /*
     * Purgache succeeded! update server
     */
    var JSONObject = new Object;
    var appData = getUserData();
    JSONObject.request = "buyedYear";
    JSONObject.userID = appData.userID;
    JSONObject.actionResult = result;   
    runAjax(JSONObject, function onSuccess(resultJSON) {
        buyYearStep4(resultJSON.result);
    }, ajaxErrorHandler, false);    
}

function buyYearStep4($newEndDate){
    /*
     * Update finished, new date found, log success
     */
    refresh();

    var appData = getUserData();
    appData.proEndDate = $newEndDate;

    document.getElementById('endDatePro').innerHTML = appData.proEndDate;
    
    logPayment(
        appData.userID,
        appData.username+":after purchase year",
        $newEndDate, 
        function onSuccess(resultJSON) {
            buyYearStep5(resultJSON.result);
        },
        ajaxErrorHandler);
}

function buyYearStep5(){
}


/*************************************************************************/
/*** GLOBAL PAYMENT FUNCTIONS                                         ****/
/*************************************************************************/

function purchaseErrorHandler (error) { 
   alert("ERROR: \r\n"+error ); 
    var JSONObject = new Object;
    var appData = getUserData();
    JSONObject.request = "logPayment";
    JSONObject.userID = appData.userID;
    JSONObject.action = "PaymentError";
    JSONObject.actionResult = error;
    runAjax(JSONObject, function onSuccess(resultJSON) {}, function onError(resultJSON) {} , false);    
} 

function ajaxErrorHandler (error) { 
   alert("AJAX ERROR: \r\n"+error.errorMsg );
    var JSONObject = new Object;
    var appData = getUserData();
    JSONObject.request = "logPayment";
    JSONObject.userID = appData.userID;
    JSONObject.action = "AjaxError";
    JSONObject.actionResult = error.errorMsg;
    runAjax(JSONObject, function onSuccess(resultJSON) {}, function onError(resultJSON) {} , false);    

} 

function logPayment(userID,action, actionResult, succesFunction, errorFunction) {
    var JSONObject = new Object;
    JSONObject.request = "logPayment";
    JSONObject.userID = userID;
    JSONObject.action = action;
    JSONObject.actionResult = actionResult;   
    runAjax(JSONObject, succesFunction , errorFunction , false);    
}

