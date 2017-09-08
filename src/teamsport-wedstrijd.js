var currentGame = -1;
var currentGameData = null;
var currentGames = "";


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

function isSupporter() {
    var teammembers = eval('(' + initialTeammembers + ')');
    for(var index = 0; index < teammembers.length; index++) {
        var item = teammembers[index];
        if (item.userID==currentUserID){
            if(item.supporter == "1") return true;
        }
    }
    return false;
}


function checkPermissions(){
    if (isAdminUser()){
        document.getElementById('modifyButton1b').style.display = ""; 
        document.getElementById('modifyButton2b').style.display = ""; 
        document.getElementById('modifyButton3b').style.display = ""; 
        document.getElementById('modifyButton4b').style.display = ""; 
    }
    else{
        document.getElementById('modifyButton1b').style.display = "none"; 
        document.getElementById('modifyButton2b').style.display = "none"; 
        document.getElementById('modifyButton3b').style.display = "none"; 
        document.getElementById('modifyButton4b').style.display = "none"; 
    }
    if (anonimousLogin){
        document.getElementById('newMessageb').style.display = "none"; 
        document.getElementById('selectedGameData').style.display = "none"; 
        document.getElementById('gameMessages').style.display = "none"; 
        document.getElementById('textForAnonimousTeam').style.display = ""; 
        document.getElementById('textForAnonimousTeamMessages').style.display = ""; 
    }
    else{
        document.getElementById('newMessageb').style.display = ""; 
        document.getElementById('selectedGameData').style.display = ""; 
        document.getElementById('gameMessages').style.display = ""; 
        document.getElementById('textForAnonimousTeam').style.display = "none"; 
        document.getElementById('textForAnonimousTeamMessages').style.display = "none"; 
    }
}

function disableAll(){
    document.getElementById("siteDataEnabled").style.display = 'none';
    document.getElementById("siteDataEmpty").style.display = '';
}

function enableAll(){
    document.getElementById("siteDataEnabled").style.display = '';
    document.getElementById("siteDataEmpty").style.display = 'none';
}

/*************************************************
 *
 **************************************************/
function setPrecenseYes(){
    memberID = findCurrentTeamMemberID();
    document.getElementById("list_PresentNo_"+memberID).checked=false;
    document.getElementById("list_PresentYes_"+memberID).checked=true;
    document.getElementById("list_PresentUnknown_"+memberID).checked=false;
    saveGame();

}
/*************************************************
 *
 **************************************************/
function setPrecenseNo(){
    memberID = findCurrentTeamMemberID();
    document.getElementById("list_PresentNo_"+memberID).checked=true;
    document.getElementById("list_PresentYes_"+memberID).checked=false;
    document.getElementById("list_PresentUnknown_"+memberID).checked=false;
    saveGame();    
}
/*************************************************
 *
 **************************************************/
function setPrecenseUnknown(){
    memberID = findCurrentTeamMemberID();
    document.getElementById("list_PresentNo_"+memberID).checked=false;
    document.getElementById("list_PresentYes_"+memberID).checked=false;
    document.getElementById("list_PresentUnknown_"+memberID).checked=true;
    saveGame();    
}



/*************************************************
 *
 **************************************************/
function getUserName(users,userID) {
    for ( var i=0, len=users.length; i<len; ++i ){
        if (users[i].id==userID) {
            return users[i].nickname;
        }
    }
    return "unknown";
}

/*************************************************
 *
 **************************************************/
function fillPresentUnknown(teammembers, membersPresentYes,membersPresentNo){
    var unknownMembers = "";
    
    for ( var i=0, len=teammembers.length; i<len; ++i ){
        var memberID = teammembers[i].id;
        var found = false;
        
        if (membersPresentYes!=null){
            var values = membersPresentYes.split(" ");
            for ( var j=0, len2=values.length; j<len2; ++j ){
                foundMemberID = values[j];
                if (foundMemberID==memberID){
                    found = true;
                }
            }
        }
        
        if (membersPresentNo!=null){
            var values = membersPresentNo.split(" ");
            for ( var j=0, len3=values.length; j<len3; ++j ){
                foundMemberID = values[j];
                if (foundMemberID==memberID){
                    found = true;
                }
            }
        }
        
        if (!found){
            if (unknownMembers!="") unknownMembers+=" ";
            unknownMembers = unknownMembers+memberID;
        }
    }
    
    return unknownMembers;
} 


/*************************************************
 *
 **************************************************/
function openListValueCheck(list,fieldToLoad) {
    teammembers = eval('(' + initialTeammembers + ')');
    result = "";

	if (list!=null){
		var values = list.split(" ");
		for ( var i=0, len=values.length; i<len; ++i ){
			userID = values[i];
			if (userID!=null && userID!=""){
    			username = getUserName(teammembers,userID);
    			if (result!="") result+=", "
    		    result+=username;
		    }
		}
	}	
    document.getElementById(fieldToLoad).innerHTML = result;
}



/*************************************************
 *
 **************************************************/
function openListValueNumber(list,fieldToLoad) {
    teammembers = eval('(' + initialTeammembers + ')');
    result = "";

    if (list!=null){
        var values = list.split(" ");
        for ( var i=0, len=values.length; i<len; ++i ){
            values2 = values[i].split("*");
            if (values2.length==2){
                if (values2[1]!=""){
                    userID = values2[0];
                    username = getUserName(teammembers,userID);
                    if (result!="") result+=", "
                    result+=username+":"+values2[1];
                }
            }
        }
    }   
    document.getElementById(fieldToLoad).innerHTML = result;
}

/*************************************************
 *
 **************************************************/
function openListValueMoney(list,fieldToLoad) {
    teammembers = eval('(' + initialTeammembers + ')');
    result = "";

    if (list!=null){
        var values = list.split(" ");
        for ( var i=0, len=values.length; i<len; ++i ){
            values2 = values[i].split("*");
            if (values2.length==2){
                if (values2[1]!=""){
                    userID = values2[0];
                    username = getUserName(teammembers,userID);
                    if (result!="") result+="&nbsp;<!--T1778T-->&euro;<!--T1778T--> , "
                    result+=username+":"+values2[1];
                }
            }
        }
    }   
    document.getElementById(fieldToLoad).innerHTML = result;
}


function findCurrentTeamMemberID() {
    teammembers = eval('(' + initialTeammembers + ')');
    for(var index = 0; index < teammembers.length; index++) {
        var item = teammembers[index];
        if (item.userID==currentUserID){
	    if (!item.deleted){
            	return item.id;
            }
        }
    }
    return -1;
}

function saveListdata2(teammembers, fieldnamePrefix,listType,savefieldname){
                value = "";
                for(var index = 0; index < teammembers.length; index++) {
                    var item = teammembers[index];
                    editfieldname=fieldnamePrefix+item.id;
                    if (listType==0){
                        if(document.getElementById(editfieldname) != null) {
                            fieldvalue = document.getElementById(editfieldname).value;
                            fieldvalue2 = fieldvalue.replace(/[^0-9.,]/g,"");
                            value += " "+item.id+"*"+fieldvalue2; 
                        }
                    }        
                    if (listType==1){
                        if(document.getElementById(editfieldname) != null) {
                            fieldvalue = document.getElementById(editfieldname).value;                            
                            fieldvalue2 = fieldvalue.replace(/[^0-9.,]/g,"");
                            value += " "+item.id+"*"+fieldvalue2; 
                        }
                    }        
                    if (listType==2){
                        if(document.getElementById(editfieldname) != null) {
                            fieldvalue = document.getElementById(editfieldname).checked;
                            if (fieldvalue){
                                value += " "+item.id;
                            } 
                        }
                    }        
                }
                // place value in field
                if(document.getElementById(savefieldname) != null) {
                    document.getElementById(savefieldname).value = value;
                }
    
}


function saveListdata(){
    game = currentGameData;

    teammembers = eval('(' + initialTeammembers + ')');

    for (i=0; i<10; i++){
        propname = "listname"+i;
        propname2 = "listtype"+i;
        listType = 0;
        listname = "";
        listType = game[propname2];
        listname = game[propname]
        if (listname!="" && listname!=null){                
            // load this field
            savefieldname="list"+i;
            fieldnamePrefix = "list_"+i+"_";
            saveListdata2(teammembers, fieldnamePrefix,listType,savefieldname);
        }        
    }
    saveListdata2(teammembers, "list_PresentYes_",2,"gamePresentYesField");
    saveListdata2(teammembers, "list_PresentNo_",2,"gamePresentNoField");
    saveListdata2(teammembers, "list_PresentUnknown_",2,"gamePresentUnknownField");
    saveListdata2(teammembers, "list_goals_",0,"goals");
    
    javascript:document.getElementById('selectedGameDataEdit1').style.display = 'none';
    javascript:document.getElementById('selectedGameDataEdit2').style.display = 'none';
    javascript:document.getElementById('selectedGameDataEdit3').style.display = 'none';
    javascript:document.getElementById('selectedGameDataEdit4').style.display = 'none';
}


function printListitem(memberID, list, proptype, listnr){
    fieldnamePrefix = "list_"+listnr+"_";
    if (listnr==-3) fieldnamePrefix = "list_PresentYes_";
    if (listnr==-2) fieldnamePrefix = "list_PresentNo_";
    if (listnr==-1) fieldnamePrefix = "list_PresentUnknown_";
    if (listnr==0) fieldnamePrefix = "list_goals_";


    if (list==null) list = "";
    var arrayData = list.split(" ");
    if (proptype==2){
        checked = "";
        for ( var i=0, len=arrayData.length; i<len; ++i ){
            idInList = arrayData[i];
            if (memberID==idInList){
                checked = "checked";                
            }
        }
        onclickValue = "";
        fieldID = fieldnamePrefix+memberID;
        if (listnr==-3 || listnr==-2 || listnr==-1){
            if (listnr==-1){
                // for the 3 present fields
                field1 = "list_PresentYes_"+memberID;
                field2 = "list_PresentNo_"+memberID;
            }
            if (listnr==-2){
                // for the 3 present fields
                field1 = "list_PresentUnknown_"+memberID;
                field2 = "list_PresentYes_"+memberID;
            }
            if (listnr==-3){
                // for the 3 present fields
                field1 = "list_PresentNo_"+memberID;
                field2 = "list_PresentUnknown_"+memberID;
            }
            onclickValue="onclick='document.getElementById(\""+field1+"\").checked=false;document.getElementById(\""+field2+"\").checked=false;'";
        }
        
        return "<input type='checkbox' class='gameCheckbox' value='true' id='"+fieldID+"' "+checked+" "+onclickValue+"/>";
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
        return "<input type='text' class='listEditFields' id='"+fieldnamePrefix+memberID+"' value='"+value+"'/>&nbsp;&euro;";
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
        return "<input type='text' class='listEditFields' id='"+fieldnamePrefix+memberID+"' value='"+value+"'/>";
    }

    return "";
}

function addNewPlayersToList(testArray, resultArray, allMembers, list){
    if (list!=null){
        var values = list.split(" ");
        for ( var i=0, len=values.length; i<len; ++i ){
            value2=values[i]+"*";
            values2 = value2.split("*");
            if (values2.length>0){
                userID = values2[0];
                if (userID!="null" &&userID!=null && userID.trim()!=""){
                    if (!(userID in testArray)){
                        testArray[userID] = "1";
                        index = resultArray.length;
                        var item = allMembers[userID];
                        if (item !== undefined) {
                            resultArray[index] = item;
                        }
                    }
                }
            }
        }
    }   
}

function findTeamMembersForLists(game){
    var resultArray = new Array();
    var testArray = new Array();
    var allMembers = new Array();
    var teammembers = eval('(' + initialTeammembers + ')');
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
    
    // test all lists to see if any of the supporter or old player are in that list
    addNewPlayersToList(testArray, resultArray, allMembers, game.membersPresentYes);
    addNewPlayersToList(testArray, resultArray, allMembers, game.membersPresentNo);
    addNewPlayersToList(testArray, resultArray, allMembers, game.membersPresentUnknown);
    addNewPlayersToList(testArray, resultArray, allMembers, game.goals);
    addNewPlayersToList(testArray, resultArray, allMembers, game.list1);
    addNewPlayersToList(testArray, resultArray, allMembers, game.list2);
    addNewPlayersToList(testArray, resultArray, allMembers, game.list3);
    addNewPlayersToList(testArray, resultArray, allMembers, game.list4);
    addNewPlayersToList(testArray, resultArray, allMembers, game.list5);
    addNewPlayersToList(testArray, resultArray, allMembers, game.list6);
    addNewPlayersToList(testArray, resultArray, allMembers, game.list7);
    addNewPlayersToList(testArray, resultArray, allMembers, game.list8);
    addNewPlayersToList(testArray, resultArray, allMembers, game.list9);
    addNewPlayersToList(testArray, resultArray, allMembers, game.list10);
    
    
    return resultArray;
}


function getListdata(game){
    var result = "<table id=dualcolortable cellspacing='0'>";
    
    result += "<tr>";
    result += "<td></td>";// for the user        
    result += "<td width=10></td>";// extra space        
    hasLists = false;
    for (i=1; i<10; i++){
        var propname = "listname"+i;
        
        var listname = game[propname]
        
        if (listname!="" && listname!=null){
            hasLists = true;
            result += "<td><b>&nbsp;&nbsp;";        
            result += listname;
            result += "&nbsp;&nbsp;</b></td>";
            result += "<td width=10></td>";// extra space        
        }
    }
    result += "</tr>";
    if (hasLists){
        var teammembers = findTeamMembersForLists(game);
        for(var index = 0; index < teammembers.length; index++) {
            var item = teammembers[index];
            result += "<tr>";
            result += "<td>"+item.nickname+"</td>";// for the user        
            result += "<td width=10></td>";// extra space        
            for (i=1; i<10; i++){
                propname = "listname"+i;
                propname2 = "listtype"+i;
                listType = game[propname2];
                listname = game[propname]
                propname = "list"+i;
    
                listdata = game[propname];
                
                
                
                if (listname!="" && listname!=null){
                    result += "<td align=center>";
                    result += printListitem(item.id,listdata,listType,i);        
                    result += "</td>";
                    result += "<td width=20></td>";// extra space        
                }
            }
            result += "</tr>";
        }
    }

    result += "</table>";
    if (!hasLists){
        result += "<!--T1779T-->Er zijn geen eigen lijsten aangemaakt voor dit team.<br>Ga naar 'lijstjes' om een eigen lijst aan te maken.<!--T1779T-->";        
    }
    
    
    return result;
}

function getListdataGoals(game){
    var result = "<table id=dualcolortable cellspacing='0'>";
    
    result += "<tr>";
    result += "<td></td>";// for the user        
    result += "<td width=10></td>";// extra space        
    result += "<td><b>&nbsp;&nbsp;";        
    result += "<!--T1780T-->Doelpunten makers<!--T1780T-->";
    result += "&nbsp;&nbsp;</b></td>";
    result += "<td width=10></td>";// extra space        
    result += "</tr>";
    
    var teammembers = findTeamMembersForLists(game);
    for(var index = 0; index < teammembers.length; index++) {
        var item = teammembers[index];
        result += "<tr>";
        result += "<td>"+item.nickname+"</td>";// for the user        
        result += "<td width=10></td>";// extra space        
        propname = "listname0";
        propname2 = "listtype0";
        listname = "<!--T1781T-->Goals<!--T1781T-->";
        propname = "goals";
        listdata = game[propname];
        
        if (listname!="" && listname!=null){
            result += "<td align=center>";
            result += printListitem(item.id,listdata,0,0);        
            result += "</td>";
            result += "<td width=20></td>";// extra space        
        }
        result += "</tr>";
    }
    
    result += "</table>";
    return result;
}

function getListdataPresent(game){
    var result = "<table id=dualcolortable cellspacing='0'>";
    
    result += "<tr>";
    result += "<td></td>";// for the user        
    result += "<td width=10></td>";// extra space        
    for (i=-3; i<0; i++){
        var propname = "listname"+i;
        
        var listname = "";
        if (i==-3){
            listname = "<!--T1782T-->Aanwezig<!--T1782T-->";
        }
        else if (i==-2){
            listname = "<!--T1783T-->Afwezig<!--T1783T-->";
        }
        else if (i==-1){
            listname = "<!--T1784T-->Weet-niet<!--T1784T-->";
        }        
        
        if (listname!="" && listname!=null){
            result += "<td><b>&nbsp;&nbsp;";        
            result += listname;
            result += "&nbsp;&nbsp;</b></td>";
            result += "<td width=10></td>";// extra space        
        }
    }
    result += "</tr>";
    var teammembers = findTeamMembersForLists(game);
//    teammembers = eval('(' + initialTeammembers + ')');
    for(var index = 0; index < teammembers.length; index++) {
        var item = teammembers[index];
        result += "<tr>";
        result += "<td>"+item.nickname+"</td>";// for the user        
        result += "<td width=10></td>";// extra space        
        for (i=-3; i<0; i++){
            propname = "listname"+i;

            propname2 = "listtype"+i;
            listType = 0;
            listname = "";
            if (i==-3){
                listType = 2;
                listname = "<!--T1785T-->Aanwezig<!--T1785T-->";
                propname = "membersPresentYes";
            }
            else if (i==-2){
                listType = 2;
                listname = "<!--T1786T-->Afwezig<!--T1786T-->";
                propname = "membersPresentNo";
            }
            else if (i==-1){
                listType = 2;
                listname = "<!--T1787T-->Weet-niet<!--T1787T-->";
                propname = "membersPresentUnknown";
            }
            else {
                listType = game[propname2];
                listname = game[propname]
                propname = "list"+i;
            }

            listdata = game[propname];
            
            
            
            if (listname!="" && listname!=null){
                result += "<td align=center>";
                result += printListitem(item.id,listdata,listType,i);        
                result += "</td>";
                result += "<td width=20></td>";// extra space        
            }
        }
        result += "</tr>";
        
        
    }


    
    result += "</table>";
    return result;
}


function loadGameData(game) {
    currentGameData = game;
    currentGame = game.id;
    //var teammembers = eval('(' + initialTeammembers + ')');
    var teammembers = findTeamMembersForLists(game);
    game.membersPresentUnknown = fillPresentUnknown(teammembers, game.membersPresentYes,game.membersPresentNo);

    var memberID = findCurrentTeamMemberID();
    var currentUserPresentYes = false;
    var currentUserPresentNo = false;
    var currentUserPresentUnknown = false;

    document.getElementById('newMessageData').value = "";
    document.getElementById('selectwedstrijd').value = currentGame;

    var datetimeint = game.gamedate * 1000;
    var gameDate2 = new Date(datetimeint);
    //alert("get "+datetimeint+":"+gameDate2); 

    var gameteams = game.opponent +" - "+initialSelectedTeamName;
    if (game.homegame==1){
        gameteams = initialSelectedTeamName+" - "+game.opponent;
    }
    var currentGameText = ts_getDateDate(gameDate2) + " : " + gameteams;
    
    if (game.id == undefined){
        var seizoen = "??";
        try{
            var list = document.getElementById('selectcompetition2');
            seizoen = list.options[list.selectedIndex].text;
        }
        catch(Exception){
        }
        disableAll();
        return;
    }

    var opponentLink = game.opponent;
    if (game.mGameID>0){
        if (game.homegame==1){
            if (game.teamID2>0){
                opponentLink = '<a target=_blank href="index.php?team='+game.teamID2+'&section=competitie" class=none3>'+game.opponent+'</a>';
            }
        }
        else{
            if (game.teamID1>0){
                opponentLink = '<a target=_blank href="index.php?team='+game.teamID1+'&section=competitie" class=none3>'+game.opponent+'</a>';
            }
        }
    }


    
    document.getElementById('selectwedstrijd2').innerHTML = "<big>"+currentGameText+"</big>";


    document.getElementById('opponentTextbox').value = game.opponent;
    document.getElementById('gameDate').value = ts_getDateDate(gameDate2);
    document.getElementById('gameDate2').innerHTML = ts_getDateDate(gameDate2);
    document.getElementById('gameDate2Anoniem').innerHTML = ts_getDateDate(gameDate2);
    document.getElementById('gameTime').value = ts_getDateTime(gameDate2);
    document.getElementById('gameTime2').innerHTML = ts_getDateTime(gameDate2);
    document.getElementById('gameTime2Anoniem').innerHTML = ts_getDateTime(gameDate2);

    document.getElementById('opponentTextbox').value = game.opponent;
    document.getElementById('opponent2').innerHTML = opponentLink;
    document.getElementById('opponent2Anoniem').innerHTML = opponentLink;
    document.getElementById('homegame').checked = game.homegame==1;
    if (game.homegame==1){
        document.getElementById('homegame2').innerHTML = "thuis";
        document.getElementById('homegame2Anoniem').innerHTML = "thuis";
    }
    else{
        document.getElementById('homegame2').innerHTML = "uit";
        document.getElementById('homegame2Anoniem').innerHTML = "uit";
    }
    document.getElementById('meetingpoint').value = game.meetingpoint;
    document.getElementById('meetingpoint2').innerHTML = game.meetingpoint;
    if (game.messages=="" || game.messages==null){
        document.getElementById('gameMessages').innerHTML = /*T1799T*/"Er zijn nog geen berichten geplaatst"/*T1799T*/;
    }
    else{
        document.getElementById('gameMessages').innerHTML = game.messages;
    }
    
    var scoreSplit = game.score.split("-");
    var score1 = "";
    var score2 = "";
    if (scoreSplit.length>0){
        score1 = scoreSplit[0]; 
    }
    if (scoreSplit.length>1){
        score2 = scoreSplit[1]; 
    }

    if (game.homegame==1){
        document.getElementById('scoreWij').value = score1;
        document.getElementById('scoreZij').value = score2;
    }
    else{
        document.getElementById('scoreWij').value = score2;
        document.getElementById('scoreZij').value = score1;
    }
    document.getElementById('score2Anoniem').innerHTML = game.score;
    document.getElementById('score2').innerHTML = game.score;
    document.getElementById('points').value = game.points;
    document.getElementById('points2').innerHTML = game.points;
    document.getElementById('points2Anoniem').innerHTML = game.points;

    document.getElementById('gamePresentYesField').value = game.membersPresentYes;
    document.getElementById('gamePresentNoField').value = game.membersPresentNo;
    document.getElementById('gamePresentUnknownField').value = game.membersPresentUnknown;

    document.getElementById('list1').value = game.list1;
    document.getElementById('list2').value = game.list2;
    document.getElementById('list3').value = game.list3;
    document.getElementById('list4').value = game.list4;
    document.getElementById('list5').value = game.list5;
    document.getElementById('list6').value = game.list6;
    document.getElementById('list7').value = game.list7;
    document.getElementById('list8').value = game.list8;
    document.getElementById('list9').value = game.list9;
    document.getElementById('list10').value = game.list10;

    document.getElementById('goals').value = game.goals;
    
    var countYes = 0;
    var countNo = 0;
    var countUnknown = 0;
    try{
        if (game.membersPresentYes!=""){
            countYes = cleanArray(game.membersPresentYes.split(" ")).length;
        }
    }   catch(Exception){  }
    try{
        if (game.membersPresentNo!=""){
            countNo = cleanArray(game.membersPresentNo.split(" ")).length;
        }
    }   catch(Exception){  }
    try{
        if (game.membersPresentUnknown!=""){
            countUnknown = cleanArray(game.membersPresentUnknown.split(" ")).length;
        }
    }   catch(Exception){  }
    


    document.getElementById('goalsName').innerHTML = "<!--T1788T-->Goals<!--T1788T-->";
    document.getElementById('aanwezigName').innerHTML = "<!--T1789T-->Aanwezig<!--T1789T--> ("+countYes+")";
    document.getElementById('afwezigName').innerHTML = "<!--T1790T-->Afwezig<!--T1790T--> ("+countNo+")";
    document.getElementById('onbekendName').innerHTML = "<!--T1791T-->Niet opgegeven<!--T1791T--> ("+countUnknown+")";

    openListValueNumber(game.goals,"goalsValue");
    openListValueCheck(game.membersPresentYes,"aanwezigValue");
    openListValueCheck(game.membersPresentNo,"afwezigValue");
    openListValueCheck(game.membersPresentUnknown,"onbekendValue");
    
    for (i=1;i<=10;i++){
        var listname = game["listname"+i];
        var listtype = game["listtype"+i];
        if (listname!="" && listname!=null){
            document.getElementById("list"+i+"Name").innerHTML = listname;
            if (listtype==0){
                var propname = "list"+i;
                var fieldname = "list"+i+"Value";
                openListValueNumber(game[propname],fieldname);
            }
            if (listtype==1){
                var propname = "list"+i;
                var fieldname = "list"+i+"Value";
                openListValueMoney(game[propname],fieldname);
            }
            if (listtype==2){
                var propname = "list"+i;
                var fieldname = "list"+i+"Value";
                openListValueCheck(game[propname],fieldname);
            }
        }
        else{
            document.getElementById("list"+i+"Row").style.display = 'none';
        }
    }
    
    var aanwezigText = "";
    if (game.membersPresentYes!=null){
        var membersPresentYesArray = cleanArray(game.membersPresentYes.split(" "));
        for ( var i=0, len=membersPresentYesArray.length; i<len; ++i ){
            aanwezigText+=findTeamname(membersPresentYesArray[i]);
            if (i<membersPresentYesArray.length-1){
                aanwezigText+=", ";
            }
            if (membersPresentYesArray[i]==memberID){
                currentUserPresentYes = true;
            }
        }
    }
// document.getElementById('gamePresentYes').innerHTML = aanwezigText;
    
    
    aanwezigText = "";
    if (game.membersPresentNo!=null){
        var membersPresentNoArray = cleanArray(game.membersPresentNo.split(" "));
        for ( var i=0, len=membersPresentNoArray.length; i<len; ++i ){
            aanwezigText+=findTeamname(membersPresentNoArray[i]);
            if (i<membersPresentNoArray.length-1){
                aanwezigText+=",";
            }
            if (membersPresentNoArray[i]==memberID){
                currentUserPresentNo = true;
            }
        }
    }
//    document.getElementById('gamePresentNo').innerHTML = aanwezigText;
    
    aanwezigText = "";
    if (game.membersPresentUnknown!=null){
        var membersPresentUnknownArray = cleanArray(game.membersPresentUnknown.split(" "));
        for ( var i=0, len=membersPresentUnknownArray.length; i<len; ++i ){
            aanwezigText+=findTeamname(membersPresentUnknownArray[i]);
            if (i<membersPresentUnknownArray.length-1){
                aanwezigText+=",";
            }
            if (membersPresentUnknownArray[i]==memberID){
                currentUserPresentUnknown = true;
            }
        }
    }
//    document.getElementById('gamePresentUnknown').innerHTML = aanwezigText;

    document.getElementById('listData').innerHTML = getListdata(game);
    document.getElementById('listDataPresent').innerHTML = getListdataPresent(game);
    document.getElementById('listDataGoals').innerHTML = getListdataGoals(game);
    
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
    
    // hide or show the presence buttons
    // is score is filled in, then you cannot change it anymore
    var hidePresenceButtons = game.score!="" || isSupporter() || anonimousLogin; 
    if (!hidePresenceButtons){
        // hier al laten zien, anders is de plaats van het vinkje niet goed
        document.getElementById('presenceJa').style.display = ""; 
        document.getElementById('presenceNee').style.display = ""; 
        document.getElementById('presenceWeetNiet').style.display = ""; 
        document.getElementById('presenceVink').style.display = "";
    } 
    
    // place the vink image on the correct button
    var x = GetTopLeft(document.getElementById('presenceJa')).Left;
    var y = GetTopLeft(document.getElementById('presenceJa')).Top;
    
    if (currentUserPresentNo){
        x = GetTopLeft(document.getElementById('presenceNee')).Left;
        y = GetTopLeft(document.getElementById('presenceNee')).Top;
    }

    if (currentUserPresentUnknown){
        x = GetTopLeft(document.getElementById('presenceWeetNiet')).Left;
        y = GetTopLeft(document.getElementById('presenceWeetNiet')).Top;
    }
    // place vink on pos 0,0 and use that as the reference 
    document.getElementById('presenceVink').style.position="absolute";
    document.getElementById('presenceVink').style.display = ""; 
    document.getElementById('presenceVink').style.left = 0; 
    document.getElementById('presenceVink').style.top = 0; 
    var xRef = GetTopLeft(document.getElementById('presenceVink')).Left;
    var yRef = GetTopLeft(document.getElementById('presenceVink')).Top;


    document.getElementById('presenceVink').style.left = x+30-xRef; 
    document.getElementById('presenceVink').style.top = y+0-yRef;
    
    
    // hide or show the presence buttons
    // is score is filled in, then you cannot change it anymore
    if (hidePresenceButtons){
        // hier pas verbergen, in de code hierboven wordt het vinkje namelijk ook gehide/geshowed
        document.getElementById('presenceJa').style.display = "none"; 
        document.getElementById('presenceNee').style.display = "none"; 
        document.getElementById('presenceWeetNiet').style.display = "none"; 
        document.getElementById('presenceVink').style.display = "none";
    }
    
    
    // place edit buttons
    var x = GetTopLeft(document.getElementById('modifyButton1a')).Left;
    var y = GetTopLeft(document.getElementById('modifyButton1a')).Top;
    document.getElementById('modifyButton1b').style.position="absolute";
//    document.getElementById('modifyButton1b').style.display = ""; 
    document.getElementById('modifyButton1b').style.left = 0; 
    document.getElementById('modifyButton1b').style.top = 0; 
    var xRef = GetTopLeft(document.getElementById('modifyButton1b')).Left;
    var yRef = GetTopLeft(document.getElementById('modifyButton1b')).Top;
    document.getElementById('modifyButton1b').style.left = x-25-xRef; 
    document.getElementById('modifyButton1b').style.top = y-10-yRef; 
    
    var x = GetTopLeft(document.getElementById('modifyButton2a')).Left;
    var y = GetTopLeft(document.getElementById('modifyButton2a')).Top;
    document.getElementById('modifyButton2b').style.position="absolute";
//    document.getElementById('modifyButton2b').style.display = ""; 
    document.getElementById('modifyButton2b').style.left = 0; 
    document.getElementById('modifyButton2b').style.top = 0; 
    var xRef = GetTopLeft(document.getElementById('modifyButton2b')).Left;
    var yRef = GetTopLeft(document.getElementById('modifyButton2b')).Top;
    document.getElementById('modifyButton2b').style.left = x-25-xRef; 
    document.getElementById('modifyButton2b').style.top = y-10-yRef; 
    
    var x = GetTopLeft(document.getElementById('modifyButton3a')).Left;
    var y = GetTopLeft(document.getElementById('modifyButton3a')).Top;
    document.getElementById('modifyButton3b').style.position="absolute";
//    document.getElementById('modifyButton3b').style.display = ""; 
    document.getElementById('modifyButton3b').style.left = 0; 
    document.getElementById('modifyButton3b').style.top = 0; 
    var xRef = GetTopLeft(document.getElementById('modifyButton3b')).Left;
    var yRef = GetTopLeft(document.getElementById('modifyButton3b')).Top;
    document.getElementById('modifyButton3b').style.left = x-25-xRef; 
    document.getElementById('modifyButton3b').style.top = y-10-yRef; 
    
    var x = GetTopLeft(document.getElementById('modifyButton4a')).Left;
    var y = GetTopLeft(document.getElementById('modifyButton4a')).Top;
    document.getElementById('modifyButton4b').style.position="absolute";
//    document.getElementById('modifyButton4b').style.display = ""; 
    document.getElementById('modifyButton4b').style.left = 0; 
    document.getElementById('modifyButton4b').style.top = 0; 
    var xRef = GetTopLeft(document.getElementById('modifyButton4b')).Left;
    var yRef = GetTopLeft(document.getElementById('modifyButton4b')).Top;
    document.getElementById('modifyButton4b').style.left = x-25-xRef; 
    document.getElementById('modifyButton4b').style.top = y-10-yRef; 
        
    var x = GetTopLeft(document.getElementById('newMessagea')).Left;
    var y = GetTopLeft(document.getElementById('newMessagea')).Top;
    document.getElementById('newMessageb').style.position="absolute";
//    document.getElementById('newMessageb').style.display = ""; 
    document.getElementById('newMessageb').style.left = 0; 
    document.getElementById('newMessageb').style.top = 0; 
    var xRef = GetTopLeft(document.getElementById('newMessageb')).Left;
    var yRef = GetTopLeft(document.getElementById('newMessageb')).Top;
    document.getElementById('newMessageb').style.left = x-25-xRef; 
    document.getElementById('newMessageb').style.top = y-10-yRef; 
    
 
    
     
 
     
}



/*************************************************
 *
 **************************************************/
function reloadGames() {
	var competitionID = document.getElementById('selectcompetition2').value;
	loadGames(competitionID);
}


function loadGames(competitionID) {
    var JSONObject = new Object;
    JSONObject.request = "loadGames";
    JSONObject.competitionID = competitionID;

    ts_runAjax(JSONObject, function onSuccess(resultJSON) {
        if (resultJSON.result==""){
          disableAll();
        }
        else{
          enableAll();
        }
        loadGamesData(resultJSON.result, false);
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1792T-->Fout bij ophalen van de wedstrijden<!--T1792T-->", resultJSON.errorMsg);
    }, false);
}


/*************************************************
 *
 **************************************************/
function nextGame() {
    if (currentGameData.id==undefined) return;    
    var newGame = currentGameData;
    for(var index = 0; index < currentGames.length; index++) {
        var item = currentGames[index];
        if(currentGame == item.id){
            var selectedIndex = index+1;
            if (selectedIndex < currentGames.length){
                newGame = currentGames[selectedIndex];
            }
        }
    }
    loadGame(newGame.id);
    loadGamesInTable();
}


/*************************************************
 *
 **************************************************/
function prevGame() {
    if (currentGameData.id==undefined) return;    
    var newGame = currentGameData;
    for(var index = 0; index < currentGames.length; index++) {
        var item = currentGames[index];
        if(currentGame == item.id){
            var selectedIndex = index-1;
            if (selectedIndex >=0){
                newGame = currentGames[selectedIndex];
            }
        }
    }
    loadGame(newGame.id);
    loadGamesInTable();
}

/*************************************************
 *
 **************************************************/
function reloadGame() {
    var newGame = currentGameData;
    for(var index = 0; index < currentGames.length; index++) {
        var item = currentGames[index];
        if(currentGame == item.id){
            newGame = currentGames[index];
        }
    }
    loadGame(newGame.id);
    loadGamesInTable();
}



/*************************************************
 *
 **************************************************/
function loadGamesInTable() {
    var resultText2 = "";
    var currentGameText = "";
    var gamesFound = false;
    var resultText2 = "<table id='dualcolortable' cellspacing='0'>";
    for(var index = 0; index < currentGames.length; index++) {
        var item = currentGames[index];
        var datetimeint2 = item.gamedate * 1000;
        var gameDate2 = new Date(datetimeint2);
        var selected = false;
        var gamesFound = true;
        var gameteams = item.opponent +" - "+initialSelectedTeamName;
        if (item.homegame==1){
            gameteams = initialSelectedTeamName+" - "+item.opponent;
        }
        if(currentGame == item.id){
            currentGameText = ts_getDateDate(gameDate2) + " : " + gameteams;
            selected = true;
        }
        if (selected){
            resultText2 += "<tr height=25>";
            resultText2 += "<td></td>";
            resultText2 += "<td onClick='javascript:loadGame("+item.id+");' width=90px><b><big>";
            resultText2 += ts_getDateDate(gameDate2);
            resultText2 += "</big></b></td>";
            resultText2 += "<td onClick='javascript:loadGame("+item.id+");'><b><big>";
            resultText2 += "&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;";
            resultText2 += "</big></b></td>";
            resultText2 += "<td onClick='javascript:loadGame("+item.id+");'><b><big>";
            resultText2 += gameteams; 
            resultText2 += "</big></b><td></td>";
            resultText2 += "</tr>";
        }
        else{
            resultText2 += "<tr height=25>";
            resultText2 += "<td></td>";
            resultText2 += "<td onClick='javascript:loadGame("+item.id+");'><big>";
            resultText2 += ts_getDateDate(gameDate2);
            resultText2 += "</big></td>";
            resultText2 += "<td onClick='javascript:loadGame("+item.id+");'><big>";
            resultText2 += "&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;";
            resultText2 += "</big></td>";
            resultText2 += "<td onClick='javascript:loadGame("+item.id+");'><big>";
            resultText2 += gameteams; 
            resultText2 += "</big><td></td>";
            resultText2 += "</tr>";
        }
    }
    document.getElementById('selectGameData').innerHTML = resultText2;
    
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


/*************************************************
 *
 **************************************************/
function loadGamesData($games, initialCall) {
	if(initialCall) {
		currentGame = initialSelectedGame ;
	}
	currentGames = $games;
	loadGamesInTable();
}

/*************************************************
 *
 **************************************************/


function loadCompetitionsData(competitions, initialCall) {
    var select = document.getElementById('selectcompetition2');
    if(select==null) return;

    if(competitions.length == 0) {
        // no team found
        var theOption = new Option;
        theOption.text = "<!--T1793T-->Geen seizoenen gevonden<!--T1793T-->";
        theOption.value = -1;
        select.options[0] = theOption;
    }

    for(var index = 0; index < competitions.length; index++) {
        var item = competitions[index];
        var theOption = new Option;
        theOption.text = item.season+" : "+item.description;
        theOption.value = item.id;
        theOption.selected = initialSelectedCompetition == item.id;
        select.options[index] = theOption;
    }

}   


function competitionSelect() {
	reloadGames();
}

function loadGame(gameID) {//-----------

    /*
     * Create JSON object with all modified fields
     */
    var JSONObject = new Object;
    JSONObject.request = "loadGame";
    JSONObject.gameID = gameID;
    ts_runAjax(JSONObject, function onSuccess(resultJSON) {
        loadGameData(resultJSON.result);
        document.getElementById('selectGameList').style.display = 'none';
        loadGamesInTable();
        
    }, function onError(resultJSON) {
        document.getElementById('selectGameList').style.display = 'none';
        ts_showGlobalError("<!--T1794T-->Fout bij ophalen van de wedstrijd data<!--T1794T-->", resultJSON.errorMsg);
    }, false);
}


function findTeamname(teamMemberID){
	if (teamMemberID==null) return "";
	if (teamMemberID=="") return "";
	var teammembers = eval('(' + initialTeammembers + ')');
	for(var index = 0; index < teammembers.length; index++) {		
		var item = teammembers[index];
		if (item.id==teamMemberID){
			return (item.nickname);
		}
	}
	return "naam"+teamMemberID;
}


/*************************************************
 *
 **************************************************/
function saveGame() {
	var gameID = document.getElementById('selectwedstrijd').value

	var gameDate = document.getElementById('gameDate').value;
    var newGameTime = document.getElementById('gameTime').value;
    var days = parseInt(gameDate.split("-")[0],10);
    var months = parseInt(gameDate.split("-")[1],10)-1;
    var year = parseInt(gameDate.split("-")[2],10);
    var hours = parseInt(newGameTime.split(":")[0],10);
    var minutes = parseInt(newGameTime.split(":")[1],10);   
    if (isNaN(year)){
        alert("<!--T1795T-->Ongeldige datum opgegeven<!--T1795T-->");
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
	// load list info
	saveListdata();
	
	/*
	 * Create JSON object with all modified fields
	 */
	var JSONObject = new Object;
	JSONObject.request = "saveGame";
	JSONObject.membersPresentYes = document.getElementById('gamePresentYesField').value.trim();
	JSONObject.membersPresentNo = document.getElementById('gamePresentNoField').value.trim();
    //JSONObject.membersPresentUnknown = document.getElementById('gamePresentUnknownField').value.trim();
    JSONObject.goals= document.getElementById('goals').value.trim();
    JSONObject.list1= document.getElementById('list1').value.trim();
    JSONObject.list2= document.getElementById('list2').value.trim();
    JSONObject.list3= document.getElementById('list3').value.trim();
    JSONObject.list4= document.getElementById('list4').value.trim();
    JSONObject.list5= document.getElementById('list5').value.trim();
    JSONObject.list6= document.getElementById('list6').value.trim();
    JSONObject.list7= document.getElementById('list7').value.trim();
    JSONObject.list8= document.getElementById('list8').value.trim();
    JSONObject.list9= document.getElementById('list9').value.trim();
    JSONObject.list10= document.getElementById('list10').value.trim();

	JSONObject.gameID = gameID;
    
    
    if (document.getElementById("homegame").checked){
        JSONObject.score = document.getElementById("scoreWij").value+"-"+document.getElementById('scoreZij').value;
    }
    else{
        JSONObject.score = document.getElementById("scoreZij").value+"-"+document.getElementById('scoreWij').value;        
    }
    if (JSONObject.score=="-"){
        JSONObject.score = "";
    }
    
    
    JSONObject.points = document.getElementById("points").value;
    JSONObject.gameType = 0;
    JSONObject.gameStatus = 0;
	JSONObject.meetingpoint = document.getElementById("meetingpoint").value;
    JSONObject.homegame = document.getElementById("homegame").checked;
    
    
    JSONObject.opponent = document.getElementById("opponentTextbox").value;
    

	JSONObject.datetime = dateTimeInt;
	
	ts_runAjax(JSONObject, function onSucces(resultJSON) {
		reloadGames();		
        reloadGame();
		//ts_showGlobalSuccess("Wedstrijd", "Veranderingen zijn doorgevoerd", function() {
		//}
		//);
	}, function onError(resultJSON) {
		ts_showGlobalError("<!--T1796T-->Fout bij opslaan veranderingen<!--T1796T-->", resultJSON.errorMsg);
	}, false);
}

/*************************************************
 *
 **************************************************/
function addMessage() {
    var currentDate = new Date();
    var day = currentDate.getDate();
    var month = currentDate.getMonth()+1;
    var hour = currentDate.getHours();
    var minutes = currentDate.getMinutes();
    var timeHour = ts_addLeadingZero("" + hour);
    var timeMinutes = ts_addLeadingZero("" + minutes);

    var memberID = findCurrentTeamMemberID();
    var teammembers = eval('(' + initialTeammembers + ')');
    var username = getUserName(teammembers,memberID);
    var newMessage = "<b>";
    newMessage += "op "+day+"-"+month+" om "+timeHour+":"+timeMinutes+" schreef ";
    newMessage += username;
    newMessage += ":</b><br>";
    
    
    newMessage = newMessage+document.getElementById('newMessageData').value.trim()+"<br><br>";
    newMessage = newMessage.replace(/\n/g,'<br>');
 
 
 
    var gameID = document.getElementById('selectwedstrijd').value
    var JSONObject = new Object;
    JSONObject.request = "addMessage";
    JSONObject.gameID = gameID;
    JSONObject.newMessage= newMessage;
    
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        reloadGames();        
        reloadGame();
        emailTheMessages();
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1797T-->Fout bij opslaan veranderingen<!--T1797T-->", resultJSON.errorMsg);
    }, false);
    
    
    document.getElementById('newMessage').style.display = 'none';
}



/*************************************************
 *
 **************************************************/
function emailTheMessages() {
    var gameID = document.getElementById('selectwedstrijd').value
    var JSONObject = new Object;
    JSONObject.request = "emailMessages";
    JSONObject.gameID = gameID;
    
    ts_runAjax(JSONObject, 
        function onSucces(resultJSON) {
        }, 
        function onError(resultJSON) {
        }, 
        false);
}


/*************************************************
 *
 **************************************************/
function openNewGame() {
	document.getElementById('newGame').style.display = '';
	document.getElementById('newGameDate').value = "";
	document.getElementById('newGameOpponent').value = "";
}

/*************************************************
 *
 **************************************************/
function addGame() {
	document.getElementById('newGame').style.display = 'none';

	var competitionID = document.getElementById('selectcompetition2').value;
	var gameDate = document.getElementById('newGameDate').value;
	var newGameTime = document.getElementById('newGameTime').value;
	var dateTime = gameDate + " " + newGameTime;
	var gameOpponent = document.getElementById('newGameOpponent').value;

	var JSONObject = new Object;
	JSONObject.request = "addGame";
	JSONObject.competitionID = competitionID;
	JSONObject.gameDate = dateTime;
	JSONObject.gameOpponent = gameOpponent;
	JSONObject.teamID = initialSelectedTeamID;
	ts_runAjax(JSONObject, function onSucces(resultJSON) {
		reloadGames();
	}, function onError(resultJSON) {
		ts_showGlobalError("Fout", resultJSON.errorMsg);
	}, false);
}