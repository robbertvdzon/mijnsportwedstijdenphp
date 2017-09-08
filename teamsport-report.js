var selectedField = "";
var currentData = null;
var listFields = new Array();
var listtypes = new Array();
var listDescriptions = new Array();
var grandSummary = 0; 
var playerSummary = 0; 
var gameSummary = new Array();
var origData = new Array();


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
        document.getElementById('modifyButton2b').style.display = ""; 
        document.getElementById('tip').style.display = ""; 
    }
    else{
        document.getElementById('modifyButton1b').style.display = "none"; 
        document.getElementById('modifyButton2b').style.display = "none"; 
        document.getElementById('tip').style.display = "none"; 
    }
    if (anonimousLogin){
        document.getElementById('reportData').style.display = "none"; 
        document.getElementById('textForAnonimousTeam').style.display = ""; 
    }
    else{
        document.getElementById('reportData').style.display = ""; 
        document.getElementById('textForAnonimousTeam').style.display = "none"; 
    } 
}


function getListButton(description,fieldname){
    var selected = false;
    listDescriptions[fieldname] = description;
    if (fieldname==selectedField){
        selected = true;
    }
    if (selected){
        resultvalue = "<td class='listButtonSeperator' width=2></td><td class='listButtonSelected' id='listbutton"+fieldname+"' onClick='selectReport(\""+fieldname+"\")'>&nbsp;&nbsp;"+description+"&nbsp;&nbsp;</td>";
    }
    else{
        resultvalue = "<td class='listButtonSeperator' width=2><td class='listButtonNotSelected' id='listbutton"+fieldname+"' onClick='selectReport(\""+fieldname+"\")'>&nbsp;&nbsp;"+description+"&nbsp;&nbsp;</td>";
    }
    return resultvalue;
    
}

function selectReport(fieldname) {
    document.getElementById('listbutton'+selectedField).setAttribute("class", "listButtonNotSelected");
    document.getElementById('listbutton'+selectedField).setAttribute("className", "listButtonNotSelected");
    selectedField = fieldname;
    document.getElementById('listbutton'+selectedField).setAttribute("class", "listButtonSelected");
    document.getElementById('listbutton'+selectedField).setAttribute("className", "listButtonSelected");
    printListData(true);
    printListData(false);
}



function extractMemberListDataNumber(memberID, list,gameID, readonly) {
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
    var editboxFieldname = "listdata_"+gameID+"_"+memberID;
    origData[editboxFieldname] = listValue;
    if (readonly){
        return listValue;
    }
    else{
        return "<input type='text' class='listEditFields' id='"+editboxFieldname+"' value='"+listValue+"'/>";
    }   
}


function extractMemberListDataMoney(memberID, list,gameID, readonly) {
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
    var editboxFieldname = "listdata_"+gameID+"_"+memberID;
    origData[editboxFieldname] = listValue;
    if (readonly){
        return listValue;
    }
    else{
        return "<input type='text' class='listEditFields' id='"+editboxFieldname+"' value='"+listValue+"'/>";   
    }   
}


function extractMemberListDataCheck(memberID, list,gameID, readonly) {
    var listValue = "";
    var readOnlyValue = ".";
    if (list!=null){
        var values = list.split(" ");
        for ( var i=0, len=values.length; i<len; ++i ){
            var userID = values[i];
            if (userID==memberID){
                grandSummary += 1; 
                playerSummary += 1; 
                gameSummary[gameID]+=1;
                listValue = " checked ";
                readOnlyValue = "X";
            }
        }
    }
    var editboxFieldname = "listdata_"+gameID+"_"+memberID;
    origData[editboxFieldname] = listValue;
    if (readonly){
        return readOnlyValue;
    }
    else{
        return "<input type='checkbox' class='gameCheckbox' id='"+editboxFieldname+"' "+listValue+"/>";   
    }   
    
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

function findTeamMembersForLists(listName){
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
    
    for(var index = 0; index < currentData.length; index++) {
        var game = currentData[index];
        addNewPlayersToList(testArray, resultArray, allMembers, game[listName]);
    }
    
    
    return resultArray;
}


/*************************************************
 *
 **************************************************/
function saveListData() {
    var listType = listtypes[selectedField];     
    var listName = listFields[selectedField];     
    var teammembers = findTeamMembersForLists(listName);

    var JSONObject = new Object;
    JSONObject.request = "saveListData";
    JSONObject.changedLists = new Array;
    var changedIndex = 0;
    
    for(var index = 0; index < currentData.length; index++) {
        var item = currentData[index];
        var gameID = item.id;
        var listModified = false;
        var listData = "";

        for(var index1 = 0; index1 < teammembers.length; index1++) {
            var teammember = teammembers[index1];

            var editboxFieldname = "listdata_"+gameID+"_"+teammember.id;
            var orig = origData[editboxFieldname];
            var newdata = "";
            if (listType==0){
                newdata = document.getElementById(editboxFieldname).value;
                listData+=teammember.id+"*"+newdata+" ";
            }
            if (listType==1){
                newdata = document.getElementById(editboxFieldname).value;
                listData+=teammember.id+"*"+newdata+" ";
            }
            if (listType==2){
                newdata = document.getElementById(editboxFieldname).checked;
                if (newdata) {
                    newdata = "checked";
                }
                else{
                    newdata = "";
                }
                if (newdata=="checked"){
                    listData+=teammember.id+" ";
                }
            }
            if (newdata.trim()!=orig.trim()) {
                listModified = true;
            }
        }
        if (listModified){
            var listObject = new Object;
            listObject.listName = listName;
            listObject.listType = listType;
            listObject.gameID = gameID;
            listObject.listData = listData;
            JSONObject.changedLists[changedIndex] = listObject; 
            changedIndex++;
//            alert("update "+listName+"("+listType+") for game "+gameID+" :"+listData);
        }
    }
    
    
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        reloadListData();
        document.getElementById('editReport').style.display = 'none';
    }, function onError(resultJSON) {
        ts_showGlobalError("Fout", resultJSON.errorMsg);
    }, false);    
    
}

        
/*************************************************
 *
 **************************************************/
function printListData(readonly) {
    origData = new Array();
    var listType = listtypes[selectedField];     
    var listName = listFields[selectedField];     
    var listDescription = listDescriptions[selectedField];     

    var resultText = "";

    var teammembers = findTeamMembersForLists(listName);

    resultText += "<table cellspacing='0'>";
    resultText += "<tr>";
    resultText += "<td valign=top >";


    // print players data
    if (readonly){
        resultText += "<table id='dualcolortableA' cellspacing='0' width=100%>";
    }
    else{
        resultText += "<table id='dualcolortableEditA' cellspacing='0'  width=100%>";
    }
    
    resultText += "<tr>";
    resultText += "<td>";
    resultText += "<b><!--T1706T-->Speler<!--T1706T--></b>";
    resultText += "</td>";
    resultText += "</tr>";
    for(var index1 = 0; index1 < teammembers.length; index1++) {
        var teammember = teammembers[index1];
        nickname = teammember.nickname.replace(/ /g,"&nbsp;");
        resultText += "<tr height=27>";
        resultText += "<td>";
        resultText += "&nbsp;&nbsp;&nbsp;";
        if (teammember.deleted){
            resultText += nickname+"&nbsp;(<!--T1707T-->oud&nbsp;speler<!--T1707T-->)";
        }
        else if (teammember.supporter){
            resultText += nickname+"&nbsp;(<!--T1708T-->supporter<!--T1708T-->)";
        }
        else{
            resultText += nickname;
        }
        //alert(nickname);
        resultText += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        resultText += "</td>";
        resultText += "</tr>";
    }    
    resultText += "<tr height=2>";
    resultText += "<td colspan=999 class='listButtonSeperator' ></td>";
    resultText += "</tr>";
    resultText += "<tr>";
    resultText += "<td>";
    resultText += "&nbsp;&nbsp;&nbsp;";
    resultText += "<b><!--T1709T-->Totaal<!--T1709T-->:</b>";
    resultText += "</td>";
    resultText += "</table>";

    resultText += "</td>";
    resultText += "<td>";
    var scollLayerName = "";
    if (readonly){
        scollLayerName = "scrollLayer";
        resultText += "<div id='"+scollLayerName+"' style='overflow-x: scroll;overflow-y: hidden;width:550px;' align=left>";
    }
    else{
        scollLayerName = "scrollLayerEdit";
        resultText += "<div id='"+scollLayerName+"' style='overflow-x: scroll;overflow-y: hidden;width:750px;' align=left>";
    }

    
    // data
    if (readonly){
        resultText += "<table id='dualcolortableB' cellspacing='0'>";
    }
    else{
        resultText += "<table id='dualcolortableEditB' cellspacing='0'>";
    }
    // print header
    resultText += "<tr>";
    resultText += "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
    resultText += "<td>";
    resultText += "<b><!--T1710T-->Totaal<!--T1710T--></b>";
    resultText += "</td>";
    resultText += "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
    resultText += "<td class='listButtonSeperator' width=1>&nbsp;</td>";
    resultText += "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
    
    var lastGameRowName = "";
    
    for(var index = 0; index < currentData.length; index++) {
        var item = currentData[index];
        var gameDate = new Date(item.gamedate * 1000);
        var gameID = item.id;
        var day = gameDate.getDate();
        var month = gameDate.getMonth();
        var monthNames = [ "jan", "feb", "maa", "apr", "mei", "jun",
            "jul", "aug", "sep", "okt", "nov", "dec" ];
        var listRowName = "";
        if (readonly){
            listRowName = "listRow"+index;
        }   
        else{
            listRowName = "listRowEdit"+index;
        }
             
        var currentDate = new Date();
        if (gameDate<currentDate){
            lastGameRowName = listRowName;
        }
        resultText += "<td class='listDate' id='"+listRowName+"' onClick=\"ts_changeSection('wedstrijd',"+item.id+");\">"+day+"&nbsp;"+monthNames[month];
        resultText += "</td>";
        resultText += "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";

        gameSummary[gameID]=0;
        
    }
    
    resultText += "</tr>";
    
    // print fields
    grandSummary = 0; 
    for(var index1 = 0; index1 < teammembers.length; index1++) {
        var teammember = teammembers[index1];

        // first build the player data rows (and calculate the players and grand summary)
        playerSummary = 0; 
        playerDataText = "";
        for(var index = 0; index < currentData.length; index++) {
            var item = currentData[index];
            var gameID = item.id;
            var listvalue = item[listName];
            playerDataText += "<td>";
            if (listType==0){
                playerDataText += extractMemberListDataNumber(teammember.id, listvalue,gameID,readonly);
            }
            if (listType==1){
                playerDataText += extractMemberListDataMoney(teammember.id, listvalue,gameID,readonly);
            }
            if (listType==2){
                playerDataText += extractMemberListDataCheck(teammember.id, listvalue,gameID,readonly);
            }
            playerDataText += "</td>";
            playerDataText += "<td></td>";
        }

        resultText += "<tr  height=27>";
        resultText += "<td>";
        resultText += "</td>";
        resultText += "<td>";
        if (listType==1){
            resultText += "<b>"+playerSummary+" &euro;</b>";
        }
        else{
            resultText += "<b>"+playerSummary+"</b>";
        }
        
        resultText += "</td>";
        resultText += "<td></td>";
        resultText += "<td class='listButtonSeperator' width=1></td>";
        resultText += "<td></td>";
        
        resultText += playerDataText;
        
            
            
            
    }
    
    // totals per date
    resultText += "<tr height=2>";
    resultText += "<td colspan=999 class='listButtonSeperator' ></td>";
    resultText += "</tr>";

    resultText += "<tr>";
    resultText += "<td>";
    resultText += "</td>";
    
    resultText += "<td>";
    resultText += "<b>"+grandSummary+"</b>";
    resultText += "</td>";
    resultText += "<td>";
    resultText += "</td>";
    resultText += "<td class='listButtonSeperator' width=1></td>";
    resultText += "<td></td>";
    
    
    
    for(var index = 0; index < currentData.length; index++) {
        var item = currentData[index];
        var listvalue = item[listName];
        resultText += "<td>";
        gameID = item.id;
        if (listType==0){
            
            resultText += "<b>"+Math.round(gameSummary[gameID]*100)/100+"</b>";
        }
        if (listType==1){
            resultText += "<b>"+Math.round(gameSummary[gameID]*100)/100+"&nbsp;&euro;"+"</b>";
        }
        if (listType==2){
            resultText += "<b>"+Math.round(gameSummary[gameID]*100)/100
        }
        resultText += "</td>";
        resultText += "<td>";
        }
    resultText += "</tr>";    

    resultText += "</table>";
    resultText += "";
    resultText += "</div>";
    resultText += "</td>";
    resultText += "</tr>";
    resultText += "</table>";
    
    resultText += "<br>";
    
    if (readonly){
        document.getElementById('listData').innerHTML = resultText;
    }
    else{
        document.getElementById('listEditData').innerHTML = resultText;
    }
    
    
    var col = document.getElementById(lastGameRowName);
    var div = document.getElementById(scollLayerName);
    if (col != null && div != null) {
        div.scrollLeft = col.offsetLeft-450;
    }
//    document.getElementById(lastGameRowName).scrollIntoView();
    
    
    
    // Make the rows dual color
    var table = document.getElementById("dualcolortableEditA");
    if (readonly){
        table = document.getElementById("dualcolortableA");
    }    
    for (var i = 0, row; row = table.rows[i]; i++) {
        if ((i % 2 == 0)){
            row.className  = "dualcolortableRowNoHighlight";
        }
        else{
            row.className  = "dualcolortableRowHighlight";
        }
    }

    var table = document.getElementById("dualcolortableEditB");
    if (readonly){
        table = document.getElementById("dualcolortableB");
    }    
    for (var i = 0, row; row = table.rows[i]; i++) {
        if ((i % 2 == 0)){
            row.className  = "dualcolortableRowNoHighlight";
        }
        else{
            row.className  = "dualcolortableRowHighlight";
        }
    }
    
    

    if (readonly){
        
        document.getElementById('listTitle').innerHTML = "&nbsp;&nbsp;"+listDescription;
        
        
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
}

/*************************************************
 *
 **************************************************/
function loadListDataHandler(listData) {
    currentData = listData;
    printListData(true);
    printListData(false);
}

function loadReportButtons(team) {
    var reportButtons = "";
    reportButtons = "<table cellspacing='0'><tr>";
    selectedField = "goals";
    reportButtons += getListButton("<!--T1711T-->Goals<!--T1711T-->","goals");
    reportButtons += getListButton("<!--T1712T-->Aanwezig<!--T1712T-->","membersPresentYes",false);

    listFields["goals"] = "goals";
    listFields["membersPresentYes"] = "membersPresentYes";
    listtypes["goals"] = 0;
    listtypes["membersPresentYes"] = 2;
    
    
    for (i=1;i<=10;i++){
        var listProp = "list"+i;
        var listnameProp = "listname"+i;
        var listtypeProp = "listtype"+i;
        var listname = team[listnameProp];
        var listtype = team[listtypeProp];
        if (listname!="" && listname!=null){
            reportButtons += getListButton(listname,listname);
            listFields[listname] = listProp;
            listtypes[listname] = listtype;
        }
        
    }
    reportButtons += "<td class='listButtonSeperator' width=1></td>";    
    reportButtons += "</tr></table>";
    
    document.getElementById('listButtons').innerHTML = reportButtons;
}

/*************************************************
 *
 **************************************************/
function reloadListData() {
    var competitionID = document.getElementById('selectcompetition2').value;
    loadListData(competitionID);
}


function loadListData(competitionID, callback) {
    var JSONObject = new Object;
    JSONObject.request = "loadListData";
    JSONObject.competitionID = competitionID;

    ts_runAjax(JSONObject, function onSuccess(resultJSON) {
        loadListDataHandler(resultJSON.result);
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1713T-->Fout bij ophalen van de listdata<!--T1713T-->", resultJSON.errorMsg);
    }, false);
}



function competitionSelect() {
    reloadListData();
}


function loadCompetitionsData(competitions, initialCall) {
    var select = document.getElementById('selectcompetition2');
    if(select==null) return;

    if(competitions.length == 0) {
        // no team found
        var theOption = new Option;
        theOption.text = "<!--T1714T-->Geen competities gevonden<!--T1714T-->";
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
   
    if(!initialCall) {
        loadGames();
    }
}   


//----------------------------
/*************************************************
 *
 **************************************************/
function loadListsOverview(team) {
    var resultText = "";
    resultText += "<table cellspacing='0'>";

    resultText += "<tr>";
    resultText += "<td>";
    resultText += "<b><!--T1715T-->Lijstnaam:<!--T1715T--></b>";
    resultText += "</td>";
    resultText += "<td width=20></td>";
    resultText += "<td>";
    resultText += "<b><!--T1716T-->Soort lijst:<!--T1716T--></b>";
    resultText += "</td>";
    resultText += "<td width=20></td>";
    resultText += "<td></td>";
    resultText += "</tr>";

    for (i=1;i<=10;i++){
        var listnameProp = "listname"+i;
        var listtypeProp = "listtype"+i;
        var listname = team[listnameProp];
        var listtype = team[listtypeProp];
        var listtypeName = "Unknown";
        if (listtype==0){
            listtypeName = "<!--T1717T-->Getallenlijst<!--T1717T-->";
        }
        if (listtype==1){
            listtypeName = "<!--T1718T-->Geldlijst<!--T1718T-->";
        }
        if (listtype==2){
            listtypeName = "<!--T1719T-->Aanvinklijst<!--T1719T-->";
        }
        if (listname!="" && listname!=null){
            resultText += "<tr height=30px>";
            resultText += "<td>";
            resultText += "<input id='list_" + i + "' class='gameEditFields' type='text' value='" + listname + "'/>";
            resultText += "</td>";
            resultText += "<td width=20></td>";
            resultText += "<td>";
            resultText += listtypeName;
            resultText += "</td>";
            resultText += "<td width=20></td>";
            resultText += "<td><a href='#' onclick='javascript:removeList(" + i + ");'><!--T1720T-->Verwijder<!--T1720T--></a></td>";
            resultText += "</tr>";
        }
    }
    resultText += "</table>";
    document.getElementById('lists').innerHTML = resultText;
}

/*************************************************
 *
 **************************************************/
function removeList(listID) {
    /*
     * Create JSON object with all modified fields
     */
    var JSONObject = new Object;
    JSONObject.listID = listID;
    JSONObject.request = "removeList";
    JSONObject.teamID = initialSelectedTeamID;
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        reloadTeam();
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1721T-->Fout bij verwijderen van lijst<!--T1721T-->", resultJSON.errorMsg);
    }, false);
}

/*************************************************
 *
 **************************************************/
function saveLists() {
    /*
     * Create JSON object with all modified fields
     */
    var JSONObject = new Object;
    JSONObject.request = "updateLists";
    JSONObject.teamID = initialSelectedTeamID;
    for( i = 1; i <= 10; i++) {
        fieldname = 'list_' + i;
        listname = "";
        if (document.getElementById(fieldname)!=null){
            listname = document.getElementById(fieldname).value;
        }
        //alert(fieldname+":"+listname);
        JSONObject["listname"+i] = listname;
    }
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        document.getElementById('editList').style.display = 'none';
        reloadTeam();
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1722T-->Fout bij opslaan veranderingen<!--T1722T-->", resultJSON.errorMsg);
    }, false);
}



/*************************************************
 *
 **************************************************/
function addLijst() {
    document.getElementById('newListName').value = "";
    document.getElementById('newList').style.display = '';
}

/*************************************************
 *
 **************************************************/
function reloadTeam() {
    loadTeam(initialSelectedTeamID);
}


function loadTeam(teamID) {
    var JSONObject = new Object;
    JSONObject.request = "loadTeam";
    JSONObject.teamID = teamID;

    ts_runAjax(JSONObject, function onSuccess(resultJSON) {
        loadListsOverview(resultJSON.result);
        loadReportButtons(resultJSON.result);
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1723T-->Fout bij ophalen van de team gegevens<!--T1723T-->", resultJSON.errorMsg);
    }, false);
}








/*************************************************
 *
 **************************************************/
function addLijst2() {
    document.getElementById('newList').style.display = 'none';
    var selectedTeamID = initialSelectedTeamID;
    var listName = document.getElementById('newListName').value;
    var listType = 0;
    if (document.getElementById('newListType_0').checked){
        listType  = 0;
    }
    if (document.getElementById('newListType_1').checked){
        listType  = 1;
    }
    if (document.getElementById('newListType_2').checked){
        listType  = 2;
    }
    /*
     * Create JSON object with all modified fields
     */
    var JSONObject = new Object;
    JSONObject.request = "addList";
    JSONObject.listType = listType;
    JSONObject.listName = listName;
    JSONObject.teamID = initialSelectedTeamID;
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        reloadTeam();
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1724T-->Fout bij toevoegen van de lijst<!--T1724T-->", resultJSON.errorMsg);
    }, false);
}