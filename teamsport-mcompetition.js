var savedCompetitionsData = null;
var savedCompetition = null;
var competitionIDs = new Array();
var competitionValues = new Array();

var seasonIDs = new Array();
var seasonValues = new Array();

var organisationIDs = new Array();
var organisationValues = new Array();

var savedOrganisationID = -1;
var savedSeasonID = -1;
var savedCompetitionID = -1;


/*************************************************
 *
 **************************************************/

function editCompetition(){
    if (document.getElementById("teams").style.display == ""){
        document.getElementById("editTeams").style.display = "";
    }
    else{
        document.getElementById("editGames").style.display = "";
    }
}


function checkPermissions(){
    document.getElementById('modifyButton1b').style.display = ""; 
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

function setCompetitions(competitionData) {
    savedCompetitionsData = competitionData;
}

function setCompetition(competition) {
    savedCompetition = competition;
}
        

function loadOrganisationData() {
    var select = document.getElementById('selectorganisations2');
    if(select==null) return;


    
    select.options.length = 0;
    count = 0;
    for(var index = 0; index < savedCompetitionsData.organisations.length; index++) {
        var item = savedCompetitionsData.organisations[index];
        var theOption = new Option;
        if (savedOrganisationID==item.id){
            theOption.selected = true;
        }
        theOption.text = item.organisation;
        theOption.value = item.id;        
        select.options[count] = theOption;
        count++;
    }
    organisationSelect();    
    
  // Now load the seasons in the edit layer
  var resultText = "";
    resultText += "<table cellspacing='0'>";
    resultText += "<tr>"+
    "<td><b>Organisatie</b></td><td></td>"+
    "</tr>";

    for(var index = 0; index < savedCompetitionsData.organisations.length; index++) {
        var item = savedCompetitionsData.organisations[index];
        var organisation = item;
        var fieldname1 = 'organisation_' + index;
        resultText += "<tr>"+
        "<td><input id='" + fieldname1 + "' type='text' value='" + ts_escapeQuotes(organisation.organisation) + "'/></td><td width=20></td>"+
        "</td><td width=20></td>"+
        "<td><a href='#' onclick='javascript:removeOrganisation(" + organisation.id + ");'>Verwijder</a></td></tr>";
        organisationValues[index] = organisation.organisation;
        organisationIDs[index] = organisation.id;
    }
    resultText += "</table>";
    document.getElementById('organisationList').innerHTML = resultText;         
}   



function loadSeasonsData(organisationID) {
    var select = document.getElementById('selectseason2');
    if(select==null) return;
    select.options.length = 0;
    count = 0;
    for(var index = 0; index < savedCompetitionsData.seasons.length; index++) {
        var item = savedCompetitionsData.seasons[index];
        if (item.organisationID ==organisationID){
            last = item.id;
            var theOption = new Option;
            if (savedSeasonID==item.id){
                theOption.selected = true;
            }
            
            theOption.text = item.season;
            theOption.value = item.id;
            select.options[count] = theOption;
            count++;
        }
    }
    seasonSelect();    
    

    
  // Now load the seasons in the edit layer
  var resultText = "";
    resultText += "<table cellspacing='0'>";
    resultText += "<tr>"+
    "<td><b><!--T1610T-->Seizoen<!--T1610T--></b></td><td></td>"+
    "</tr>";

    for(var index = 0; index < savedCompetitionsData.seasons.length; index++) {
        var item = savedCompetitionsData.seasons[index];
        if (item.organisationID ==organisationID){
            var season = item;
            var fieldname1 = 'season_' + index;
            resultText += "<tr>"+
            "<td><input id='" + fieldname1 + "' type='text' value='" + ts_escapeQuotes(season.season) + "'/></td><td width=20></td>"+
            "</td><td width=20></td>"+
            "<td><a href='#' onclick='javascript:removeSeason(" + season.id + ");'>Verwijder</a></td></tr>";
            seasonValues[index] = season.season;
            seasonIDs[index] = season.id;
        }
    }
    resultText += "</table>";
    document.getElementById('seasonList').innerHTML = resultText;     
}   

function loadCompetitionsData(seasonID) {
    var select = document.getElementById('selectcompetition2');
    if(select==null) return;
    select.options.length = 0;
    count = 0;
    last = -1;
    for(var index = 0; index < savedCompetitionsData.competitions.length; index++) {
        var item = savedCompetitionsData.competitions[index];
        if (item.seasonID ==seasonID){
            if (last!=item.id){
                last = item.id;
                var theOption = new Option;
                if (savedCompetitionID==item.id){
                    theOption.selected = true;
                }
                theOption.text = item.competition;
                theOption.value = item.id;
                select.options[count] = theOption;
                count++;
            }
        }
    }
    competitionSelect();    
    
    
    // Now load the competition in the edit layer
  var resultText = "";
    resultText += "<table cellspacing='0'>";
    resultText += "<tr>"+
    "<td><b><!--T1611T-->Competitie<!--T1611T--></b></td><td></td>"+
    "</tr>";

    for(var index = 0; index < savedCompetitionsData.competitions.length; index++) {
        var competition = savedCompetitionsData.competitions[index];
        if (competition.seasonID ==seasonID){
            var fieldname1 = 'competition_' + index;
            resultText += "<tr>"+
            "<td><input id='" + fieldname1 + "' type='text' value='" + ts_escapeQuotes(competition.competition) + "'/></td><td width=20></td>"+
            "</td><td width=20></td>"+
            "<td><a href='#' onclick='javascript:removeCompetition(" + competition.id + ");'><!--T1612T-->Verwijder<!--T1612T--></a></td></tr>";
            competitionIDs[index] = competition.id;
            competitionValues[index] = competition.description;
        }
    }
    resultText += "</table>";
    document.getElementById('competitionList').innerHTML = resultText;    
}   



function reloadCompetitions() {
    savedOrganisationID = getSelectedOrganisationID();
    savedSeasonID = getSelectedSeasonID();
    savedCompetitionID = getSelectedCompetitionID();

    var JSONObject = new Object;
    JSONObject.request = "loadMAllCompetitionData";
    JSONObject.userID = currentUserID;

    ts_runAjax(JSONObject, function onSuccess(resultJSON) {
        setCompetitions(resultJSON.result);
        loadOrganisationData();
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1613T-->Fout bij ophalen van de competities<!--T1613T-->", resultJSON.errorMsg);
    }, false);
}



/*################################################################################################
  ################################################################################################
  ################################################################################################*/

/*************************************************
 *
 **************************************************/
function openNewCompetition() {
    document.getElementById('newCompetition').style.display = '';
    document.getElementById('newCompetitionText').value = "";
}

/*************************************************
 *
 **************************************************/
function removeCompetition(competitionID) {
    /*
     * Create JSON object with all modified fields
     */
    var JSONObject = new Object;
    JSONObject.competitionID = competitionID;
    JSONObject.request = "removeMCompetition";
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        reloadCompetitions();
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1614T-->Fout bij verwijderen van competitie<!--T1614T-->", resultJSON.errorMsg);
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
    JSONObject.request = "updateMCompetition";
    var index = 0;
    for( i = 0; i < competitionIDs.length; i++) {
        var competitionid = competitionIDs[i];
        var competitionString = competitionValues[i];
        
        var fieldname1 = 'competition_' + i;
        if (undefined===document.getElementById(fieldname1)) continue;
        if (null===document.getElementById(fieldname1)) continue;
        var newValue= document.getElementById(fieldname1).value;
        
        var changed = false;
        if(competitionString != newValue) {
            changed = true;
        }
        if(changed) {
            JSONObject.competitions[i] = new Object;
            JSONObject.competitions[i].id = competitionid
            JSONObject.competitions[i].competition = newValue;
            index++;
        }
    }
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        reloadCompetitions();
        javascript:document.getElementById('editCompetitions').style.display = 'none';
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1615T-->Fout bij opslaan veranderingen<!--T1615T-->", resultJSON.errorMsg);
    }, false);
}

/*************************************************
 *
 **************************************************/
function addCompetition() {
    document.getElementById('newMCompetition').style.display = 'none';
    var seasonID = getSelectedSeasonID();
    var competition = document.getElementById('newCompetitionText').value;
    var JSONObject = new Object;
    JSONObject.request = "addMCompetition";
    JSONObject.seasonID = seasonID;
    JSONObject.competition = competition;
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        reloadCompetitions();
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1616T-->Fout bij opslaan veranderingen<!--T1616T-->", resultJSON.errorMsg);
    }, false);
}

/*################################################################################################
  ################################################################################################
  ################################################################################################*/



/*################################################################################################
  ################################################################################################
  ################################################################################################*/

/*************************************************
 *
 **************************************************/
function openNewSeason() {
    document.getElementById('newSeason').style.display = '';
    document.getElementById('newSeasonText').value = "";
}

/*************************************************
 *
 **************************************************/
function removeSeason(seasonID) {
    /*
     * Create JSON object with all modified fields
     */
    var JSONObject = new Object;
    JSONObject.seasonID = seasonID;
    JSONObject.request = "removeMSeason";
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        reloadCompetitions();
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1617T-->Fout bij verwijderen van seizoen<!--T1617T-->", resultJSON.errorMsg);
    }, false);
}

/*************************************************
 *
 **************************************************/
function saveSeasons() {
    /*
     * Create JSON object with all modified fields
     */
    var JSONObject = new Object;
    JSONObject.seasons = new Array;
    JSONObject.request = "updateMSeason";
    var index = 0;
    for( i = 0; i < seasonIDs.length; i++) {
        var seasonid = seasonIDs[i];
        var seasonString = seasonValues[i];
        
        var fieldname1 = 'season_' + i;
        var newValue= document.getElementById(fieldname1).value;
        
        var changed = false;
        if(seasonString != newValue) {
            changed = true;
        }
        if(changed) {
            JSONObject.seasons[i] = new Object;
            JSONObject.seasons[i].id = seasonid;
            JSONObject.seasons[i].season = newValue;
            index++;
        }
    }
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        reloadCompetitions();
        javascript:document.getElementById('editSeasons').style.display = 'none';
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1618T-->Fout bij opslaan veranderingen<!--T1618T-->", resultJSON.errorMsg);
    }, false);
}

/*************************************************
 *
 **************************************************/
function addSeason() {
    document.getElementById('newSeason').style.display = 'none';
    var organisationID = getSelectedOrganisationID();
    var season = document.getElementById('newSeasonText').value;
    var JSONObject = new Object;
    JSONObject.request = "addMSeason";
    JSONObject.organisationID = organisationID;
    JSONObject.season = season;
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        reloadCompetitions();
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1619T-->Fout bij opslaan veranderingen<!--T1619T-->", resultJSON.errorMsg);
    }, false);
}

/*################################################################################################
  ################################################################################################
  ################################################################################################*/



/*################################################################################################
  ################################################################################################
  ################################################################################################*/

/*************************************************
 *
 **************************************************/
function openNewOrganisation() {
    document.getElementById('newOrganisation').style.display = '';
    document.getElementById('newOrganisationText').value = "";
}

/*************************************************
 *
 **************************************************/
function removeOrganisation(organisationID) {
    /*
     * Create JSON object with all modified fields
     */
    var JSONObject = new Object;
    JSONObject.organisationID = organisationID;
    JSONObject.request = "removeMOrganisation";
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        reloadCompetitions();
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1620T-->Fout bij verwijderen van organisatie<!--T1620T-->", resultJSON.errorMsg);
    }, false);
}

/*************************************************
 *
 **************************************************/
function saveOrganisations() {
    /*
     * Create JSON object with all modified fields
     */
    var JSONObject = new Object;
    JSONObject.organisations = new Array;
    JSONObject.request = "updateMOrganisation";
    var index = 0;
    for( i = 0; i < organisationIDs.length; i++) {
        var organisationid = organisationIDs[i];
        var organisationString = organisationValues[i];
        
        var fieldname1 = 'organisation_' + i;
        var newValue= document.getElementById(fieldname1).value;
        
        var changed = false;
        if(organisationString != newValue) {
            changed = true;
        }
        if(changed) {
            JSONObject.organisations[i] = new Object;
            JSONObject.organisations[i].id = organisationid;
            JSONObject.organisations[i].organisation = newValue;
            index++;
        }
    }
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        reloadCompetitions();
        javascript:document.getElementById('editOrganisation').style.display = 'none';
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1621T-->Fout bij opslaan veranderingen<!--T1621T-->", resultJSON.errorMsg);
    }, false);
}

/*************************************************
 *
 **************************************************/
function addOrganisation() {
    document.getElementById('newOrganisation').style.display = 'none';
    var userID = currentUserID;
    var organisation = document.getElementById('newOrganisationText').value;
    var JSONObject = new Object;
    JSONObject.request = "addMOrganisation";
    JSONObject.userID = userID;
    JSONObject.organisation = organisation;
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        reloadCompetitions();
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1622T-->Fout bij opslaan organisaties<!--T1622T-->", resultJSON.errorMsg);
    }, false);
}

/*################################################################################################
  ################################################################################################
  ################################################################################################*/


function getSelectedOrganisationID(){
    var select = document.getElementById('selectorganisations2');
    if(select==null) return;
    return select.value;
}    

function getSelectedSeasonID(){
    var select = document.getElementById('selectseason2');
    if(select==null) return;
    return select.value;
}    

function getSelectedCompetitionID(){
    var select = document.getElementById('selectcompetition2');
    if(select==null) return;
    return select.value;
}    


function organisationSelect(){
    var select = document.getElementById('selectorganisations2');
    if(select==null) return;
    loadSeasonsData(select.value);
}    


function seasonSelect(){
    var select = document.getElementById('selectseason2');
    if(select==null) return;
    loadCompetitionsData(select.value);
}    

function competitionSelect(){
    var select = document.getElementById('selectcompetition2');
    if(select==null) return;
    loadCompetition(select.value);
}    


function loadCompetition(compID) {
    var element = document.getElementById('programma');
    if(element==null) return;
    element.innerHTML = "ID="+compID;

    var JSONObject = new Object;
    JSONObject.request = "loadMCompetition";
    JSONObject.compID = compID;
    ts_runAjax(JSONObject, function onSuccess(resultJSON) {
        setCompetition(resultJSON.result);
        loadGamesDataUitslagen();
        loadGamesDataProgramma();
        loadGamesDataStand();
        loadTeams();
        loadEditGames();
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1623T-->Fout bij ophalen van de wedstrijden<!--T1623T-->", resultJSON.errorMsg);
    }, false);
}

function getTeamsDropdown(compData,fieldid, teamid){
    var selectCode = "";
    selectCode += "<select id="+fieldid+">";
    selectCode += "<option value=-1";
    if (-1==teamid){
        selectCode += " selected ";
    }
    selectCode += ">";
    selectCode += "</option>";
    
    for(var index = 0; index < compData.teams.length; index++) {
        var team = compData.teams[index];
        selectCode += "<option value="+team.id;
        if (team.id==teamid){
            selectCode += " selected ";
        }
        selectCode += ">";
        selectCode += team.teamname;
        selectCode += "</option>";
    }
    selectCode += "</select>";
    return selectCode;

}


function saveGames(){
    compData = savedCompetition;
    
    /*
     * Create JSON object with all modified fields
     */
    var JSONObject = new Object;
    JSONObject.games = new Array;
    JSONObject.request = "updateMGames";
    JSONObject.competitionID = getSelectedCompetitionID();
    var changedIndex = 0;
    for(var index = 0; index < compData.games.length; index++) {
        var item = compData.games[index];
        var gameDate = new Date(item.datetime * 1000);
        var gameDateStr = ts_getDateDate(gameDate);
        var gameTimeStr = ts_getDateTime(gameDate)
        
        var fieldnamePlayround = 'game_playround_' + item.id;
        var fieldnameDate = 'game_date_' + item.id;
        var fieldnameTime = 'game_time_' + item.id;
        var fieldnameLocation = 'game_location_' + item.id;
        var fieldnameStand = 'game_stand_' + item.id;
        var fieldnameTeam1 = 'game_team1_' + item.id;
        var fieldnameTeam2 = 'game_team2_' + item.id;

        var valuePlayround = item.playround;
        var valueDate = gameDateStr;
        var valueTime = gameTimeStr;
        var valueLocation = item.location;
        var valueStand = item.score;
        var valueTeam1 = item.teamID1;
        var valueTeam2 = item.teamID2;
        
        var newPlayround= document.getElementById(fieldnamePlayround).value;
        var newDate = document.getElementById(fieldnameDate).value;
        var newTime = document.getElementById(fieldnameTime).value;
        var newLocation = document.getElementById(fieldnameLocation).value;
        var newStand = document.getElementById(fieldnameStand).value;
        var newTeam1 = document.getElementById(fieldnameTeam1).value;
        var newTeam2 = document.getElementById(fieldnameTeam2).value;
        
        var changed = false;
        
        if (valuePlayround!=newPlayround) changed = true;
        if (valueDate!=newDate) changed = true;
        if (valueTime!=newTime) changed = true;
        if (valueLocation!=newLocation) changed = true;
        if (valueStand!=newStand) changed = true;
        if (valueTeam1!=newTeam1) changed = true;
        if (valueTeam2!=newTeam2) changed = true;
        
        if (changed){
            var days = parseInt(newDate.split("-")[0],10);
            var months = parseInt(newDate.split("-")[1],10)-1;
            var year = parseInt(newDate.split("-")[2],10);
            var hours = parseInt(newTime.split(":")[0],10);
            var minutes = parseInt(newTime.split(":")[1],10);   
            if (isNaN(year)){
                alert("<!--T1624T-->Ongeldige datum opgegeven<!--T1624T-->");
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
            
            
            JSONObject.games[changedIndex] = new Object;
            JSONObject.games[changedIndex].id = item.id;
            JSONObject.games[changedIndex].playround = newPlayround;
            JSONObject.games[changedIndex].datetime = dateTimeInt;
            JSONObject.games[changedIndex].location = newLocation;
            JSONObject.games[changedIndex].stand = newStand;
            JSONObject.games[changedIndex].teamID1 = newTeam1;
            JSONObject.games[changedIndex].teamID2 = newTeam2;
            changedIndex++;            
        }
    }
    
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        reloadCompetitions();
        javascript:document.getElementById('editGames').style.display = 'none';
    }, function onError(resultJSON) {
        javascript:document.getElementById('editGames').style.display = 'none';
        ts_showGlobalError("<!--T1625T-->Fout bij opslaan veranderingen<!--T1625T-->", resultJSON.errorMsg);
    }, false);
    
}

function loadEditGames(){
    compData = savedCompetition;
    var element = document.getElementById('gamesList');
    if(element==null) return;
    
    var resultText = "<table width=100% border=0 id=dualcolortable cellspacing='0'>";
    resultText += "<tr>";
    resultText += "<td>&nbsp;&nbsp;</td>";
    resultText += "<td><!--T1626T-->Ronde<!--T1626T--></td>";
    resultText += "<td>&nbsp;&nbsp;</td>";
    resultText += "<td><!--T1627T-->Datum<!--T1627T--></td>";
    resultText += "<td>&nbsp;&nbsp;</td>";
    resultText += "<td><!--T1628T-->Tijd<!--T1628T--></td>";
    resultText += "<td>&nbsp;&nbsp;</td>";
    resultText += "<td><!--T1629T-->Locatie<!--T1629T--></td>";
    resultText += "<td>&nbsp;&nbsp;</td>";
    resultText += "<td><!--T1630T-->Team1<!--T1630T--></td>";
    resultText += "<td>&nbsp;&nbsp;</td>";
    resultText += "<td><!--T1631T-->Team2<!--T1631T--></td>";
    resultText += "<td>&nbsp;&nbsp;</td>";
    resultText += "<td><!--T1632T-->Stand<!--T1632T--></td>";
    resultText += "<td>&nbsp;&nbsp;</td>";
    resultText += "<td>&nbsp;&nbsp;</td>";
    resultText += "</tr>";

        
    

 
    for(var index = 0; index < compData.games.length; index++) {
        var item = compData.games[index];
        var gameDate = new Date(item.datetime * 1000);
        var gameDateStr = ts_getDateDate(gameDate);
        var gameTimeStr = ts_getDateTime(gameDate);
        
        var fieldnamePlayround = 'game_playround_' + item.id;
        var fieldnameDate = 'game_date_' + item.id;
        var fieldnameTime = 'game_time_' + item.id;
        var fieldnameLocation = 'game_location_' + item.id;
        var fieldnameStand = 'game_stand_' + item.id;
        var fieldnameTeam1 = 'game_team1_' + item.id;
        var fieldnameTeam2 = 'game_team2_' + item.id;

        var fieldPlayround = "<input id='" + fieldnamePlayround + "' type='text' value='" + ts_escapeQuotes(item.playround) + "' size=6  onkeydown='if (event.keyCode == 13) saveGames()'/>";
        var fieldDate = "<input id='" + fieldnameDate + "' type='text' value='" + gameDateStr + "' size=10 onkeydown='if (event.keyCode == 13) saveGames()'/>";
        var fieldTime = "<input id='" + fieldnameTime + "' type='text' value='" + gameTimeStr + "' size=6 onkeydown='if (event.keyCode == 13) saveGames()'/>";
        var fieldLocation = "<input id='" + fieldnameLocation + "' type='text' value='" + item.location + "' size=8 onkeydown='if (event.keyCode == 13) saveGames()' />";
        var fieldStand = "<input id='" + fieldnameStand + "' type='text' value='" + item.score + "' size=6 onkeydown='if (event.keyCode == 13) saveGames()'/>";
        var fieldTeam1 = getTeamsDropdown(compData,fieldnameTeam1, item.teamID1);
        var fieldTeam2 = getTeamsDropdown(compData,fieldnameTeam2, item.teamID2);
        
        
        resultText += "<tr>";
        resultText += "<td>&nbsp;&nbsp;</td>";
        resultText += "<td>"+fieldPlayround+"</td>";
        resultText += "<td>&nbsp;&nbsp;</td>";
        resultText += "<td>"+fieldDate+"</td>";
        resultText += "<td>&nbsp;&nbsp;</td>";
        resultText += "<td>"+fieldTime+"</td>";
        resultText += "<td>&nbsp;&nbsp;</td>";
        resultText += "<td>" +fieldLocation +"</td>";
        resultText += "<td>&nbsp;&nbsp;</td>";
        resultText += "<td>"+fieldTeam1+"</td>";
        resultText += "<td>&nbsp;&nbsp;</td>";
        resultText += "<td>"+fieldTeam2+"</td>";
        resultText += "<td>&nbsp;&nbsp;</td>";
        resultText += "<td>"+fieldStand+"</td>";
        resultText += "<td>&nbsp;&nbsp;</td>";
        resultText += "<td><img src='images/delete.png' title='<!--T1633T-->Verwijder wedstrijd<!--T1633T-->' onclick='removeMGame("+item.id+");'  height=15px style='cursor: pointer;'></td>";
        
        resultText += "</tr>";
        
        
    }
    resultText += "</table>";
    element.innerHTML = resultText;
    
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
function addGames(){
    
    /*
     * Create JSON object with all modified fields
     */
    var JSONObject = new Object;
    JSONObject.games = new Array;
    JSONObject.request = "newMGames";
    JSONObject.competitionID = getSelectedCompetitionID();
    var changedIndex = 0;
    for(var index = 0; index < 20; index++) {
        var fieldnamePlayround = 'newgame_playround_' + index;
        var fieldnameDate = 'newgame_date_' + index;
        var fieldnameTime = 'newgame_time_' + index;
        var fieldnameLocation = 'newgame_location_' + index;
        var fieldnameStand = 'newgame_stand_' + index;
        var fieldnameTeam1 = 'newgame_team1_' + index;
        var fieldnameTeam2 = 'newgame_team2_' + index;

        
        var newPlayround= document.getElementById(fieldnamePlayround).value;
        var newDate = document.getElementById(fieldnameDate).value;
        var newTime = document.getElementById(fieldnameTime).value;
        var newLocation = document.getElementById(fieldnameLocation).value;
        var newStand = document.getElementById(fieldnameStand).value;
        var newTeam1 = document.getElementById(fieldnameTeam1).value;
        var newTeam2 = document.getElementById(fieldnameTeam2).value;
        
        // check minimal fields
        var newGame = true;
        if (newDate=="") newGame = false;
        if (newTime=="") newGame = false;
        if (newTeam1=="") newGame = false;
        if (newTeam2=="") newGame = false;
        
        
        if (newGame){
            var days = parseInt(newDate.split("-")[0],10);
            var months = parseInt(newDate.split("-")[1],10)-1;
            var year = parseInt(newDate.split("-")[2],10);
            var hours = parseInt(newTime.split(":")[0],10);
            var minutes = parseInt(newTime.split(":")[1],10);   
            if (isNaN(year)){
                alert("<!--T1634T-->Ongeldige datum opgegeven<!--T1634T-->");
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
            
            
            JSONObject.games[changedIndex] = new Object;
            JSONObject.games[changedIndex].playround = newPlayround;
            JSONObject.games[changedIndex].datetime = dateTimeInt;
            JSONObject.games[changedIndex].location = newLocation;
            JSONObject.games[changedIndex].stand = newStand;
            JSONObject.games[changedIndex].teamID1 = newTeam1;
            JSONObject.games[changedIndex].teamID2 = newTeam2;
            changedIndex++;            
        }
    }
    
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        reloadCompetitions();
        javascript:document.getElementById('newGames').style.display = 'none';
    }, function onError(resultJSON) {
        javascript:document.getElementById('newGames').style.display = 'none';
        ts_showGlobalError("<!--T1635T-->Fout bij opslaan veranderingen<!--T1635T-->", resultJSON.errorMsg);
    }, false);
    
}

/*************************************************
 *
 **************************************************/
function openNewGames() {
    document.getElementById('newGames').style.display = '';
    document.getElementById('editGames').style.display = 'none';
    var element = document.getElementById('newGamesList');
    if(element==null) return;
    
    var resultText = "<table width=100% border=0 id=dualcolortable cellspacing='0'>";
    resultText += "<tr>";
    resultText += "<td>&nbsp;&nbsp;</td>";
    resultText += "<td><!--T1636T-->Ronde<!--T1636T--></td>";
    resultText += "<td>&nbsp;&nbsp;</td>";
    resultText += "<td><!--T1637T-->Datum<!--T1637T--></td>";
    resultText += "<td>&nbsp;&nbsp;</td>";
    resultText += "<td><!--T1638T-->Tijd<!--T1638T--></td>";
    resultText += "<td>&nbsp;&nbsp;</td>";
    resultText += "<td><!--T1639T-->Locatie<!--T1639T--></td>";
    resultText += "<td>&nbsp;&nbsp;</td>";
    resultText += "<td><!--T1640T-->Team1<!--T1640T--></td>";
    resultText += "<td>&nbsp;&nbsp;</td>";
    resultText += "<td><!--T1641T-->Team2<!--T1641T--></td>";
    resultText += "<td>&nbsp;&nbsp;</td>";
    resultText += "<td><!--T1642T-->Stand<!--T1642T--></td>";
    resultText += "</tr>";

    for(var index = 0; index < 20; index++) {
        var gameDateStr = "";
        var gameTimeStr = "";

        var gameDate = new Date();
        if (index==0){
            gameDateStr = ts_getDateDate(gameDate);
            gameTimeStr = "21:00";
        }
        
        var fieldnamePlayround = 'newgame_playround_' + index;
        var fieldnameDate = 'newgame_date_' + index;
        var fieldnameTime = 'newgame_time_' + index;
        var fieldnameLocation = 'newgame_location_' + index;
        var fieldnameStand = 'newgame_stand_' + index;
        var fieldnameTeam1 = 'newgame_team1_' + index;
        var fieldnameTeam2 = 'newgame_team2_' + index;

        var fieldPlayround = "<input id='" + fieldnamePlayround + "' type='text' value='' size=6  onkeydown='if (event.keyCode == 13) saveNewGames()'/>";
        var fieldDate = "<input id='" + fieldnameDate + "' type='text' value='" + gameDateStr + "' size=10 onkeydown='if (event.keyCode == 13) saveNewGames()'/>";
        var fieldTime = "<input id='" + fieldnameTime + "' type='text' value='" + gameTimeStr + "' size=6 onkeydown='if (event.keyCode == 13) saveNewGames()'/>";
        var fieldLocation = "<input id='" + fieldnameLocation + "' type='text' value='' size=8 onkeydown='if (event.keyCode == 13) saveNewGames()' />";
        var fieldStand = "<input id='" + fieldnameStand + "' type='text' value='' size=6 onkeydown='if (event.keyCode == 13) saveNewGames()'/>";
        var fieldTeam1 = getTeamsDropdown(compData,fieldnameTeam1, -1);
        var fieldTeam2 = getTeamsDropdown(compData,fieldnameTeam2, -1);
        
        
        resultText += "<tr>";
        resultText += "<td>&nbsp;&nbsp;</td>";
        resultText += "<td>"+fieldPlayround+"</td>";
        resultText += "<td>&nbsp;&nbsp;</td>";
        resultText += "<td>"+fieldDate+"</td>";
        resultText += "<td>&nbsp;&nbsp;</td>";
        resultText += "<td>"+fieldTime+"</td>";
        resultText += "<td>&nbsp;&nbsp;</td>";
        resultText += "<td>" +fieldLocation +"</td>";
        resultText += "<td>&nbsp;&nbsp;</td>";
        resultText += "<td>"+fieldTeam1+"</td>";
        resultText += "<td>&nbsp;&nbsp;</td>";
        resultText += "<td>"+fieldTeam2+"</td>";
        resultText += "<td>&nbsp;&nbsp;</td>";
        resultText += "<td>"+fieldStand+"</td>";
        
        resultText += "</tr>";
        
        
    }
    resultText += "</table>";

    element.innerHTML = resultText;
    
}


function loadGamesDataUitslagen(){
    compData = savedCompetition;
    var element = document.getElementById('uitslagen');
    if(element==null) return;
    
    var resultText = "<table width=750 border=0 id=dualcolortable cellspacing='0'>";
    var playroundAndDate = "";
 
    var currentDate = new Date();
    for(var index = 0; index < compData.games.length; index++) {
        var item = compData.games[index];
        var gameDate = new Date(item.datetime * 1000);
        if (currentDate<gameDate) continue;
        var gameDateStr = ts_getDateDate(gameDate);
        var newPlayroundAndDate=item.playround+gameDateStr;
        if (newPlayroundAndDate!=playroundAndDate){
            playroundAndDate = newPlayroundAndDate;
            resultText += "<tr height=30px><td></td><td colspan=99><b><!--T1643T-->Speelronde<!--T1643T--> " +item.playround +" , "+gameDateStr;
            resultText += "</b><td>";
            resultText += "</tr>";
            
        }
        resultText += "<tr><td></td><td>" +item.location +"</td><td></td><td>" +ts_getDateTime(gameDate) +"</td><td></td><td>"+item.teamName1+"</td><td></td><td>"+item.teamName2+"</td><td></td><td>"+item.score+"</td>";
        resultText += "<td></td><td>";
        resultText += "</tr>";
    }
    resultText += "</table>";
    element.innerHTML = resultText;
    
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

function loadGamesDataProgramma(){
    compData = savedCompetition;
    var element = document.getElementById('programma');
    if(element==null) return;
    
    var resultText = "<table width=750 border=0 id=dualcolortable cellspacing='0'>";
    var playroundAndDate = "";
 
    var currentDate = new Date();
    for(var index = 0; index < compData.games.length; index++) {
        var item = compData.games[index];
        var gameDate = new Date(item.datetime * 1000);
        if (currentDate>=gameDate) continue;
        var gameDateStr = ts_getDateDate(gameDate);
        var newPlayroundAndDate=item.playround+gameDateStr;
        if (newPlayroundAndDate!=playroundAndDate){
            playroundAndDate = newPlayroundAndDate;
            resultText += "<tr height=30px><td></td><td colspan=99><b><!--T1644T-->Speelronde<!--T1644T--> " +item.playround +" , "+gameDateStr;
            resultText += "</b><td>";
            resultText += "</tr>";
            
        }
        resultText += "<tr><td></td><td>" +item.location +"</td><td></td><td>" +ts_getDateTime(gameDate) +"</td><td></td><td>"+item.teamName1+"</td><td></td><td>"+item.teamName2+"</td>";
        resultText += "<td></td><td>";
        resultText += "</tr>";
    }
    resultText += "</table>";
    element.innerHTML = resultText;
    
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

function loadGamesDataStand(){
    compData = savedCompetition;
    var element = document.getElementById('stand');
    if(element==null) return;
    
    
    var resultText = "<table width=750 border=0 id=dualcolortablestand cellspacing='0'>"+
                    "<tr>"+ 
                    "<td>"+
                    "    <b><!--T1645T-->Plaats<!--T1645T--></b>"+
                    "</td>"+    
                    "<td>&nbsp;&nbsp;&nbsp;</td>"+    
                    "<td>"+
                    "    <b><!--T1646T-->Team<!--T1646T--></b>"+
                    "</td>"+    
                    "<td>&nbsp;&nbsp;&nbsp;</td>"+    
                    "<td>"+
                    "    <b><!--T1647T-->Punten<!--T1647T--></b>"+
                    "</td>"+    
                    "<td>&nbsp;&nbsp;&nbsp;</td>"+    
                    "<td>"+
                    "    <b><!--T1648T-->Gespeeld<!--T1648T--></b>"+
                    "</td>"+    
                    "<td>&nbsp;&nbsp;&nbsp;</td>"+    
                    "<td>"+
                    "    <b><!--T1649T-->Gewonnen<!--T1649T--></b>"+
                    "</td>"+    
                    "<td>&nbsp;&nbsp;&nbsp;</td>"+    
                    "<td>"+
                    "    <b><!--T1650T-->Verloren<!--T1650T--></b>"+
                    "</td>"+    
                    "<td>&nbsp;&nbsp;&nbsp;</td>"+
                    "<td>"+
                    "    <b><!--T1651T-->Gelijk<!--T1651T--></b>"+
                    "</td>"+    
                    "<td>&nbsp;&nbsp;&nbsp;</td>"+    
                    "<td>"+
                    "    <b><!--T1652T-->Strafpunten<!--T1652T--></b>"+
                    "</td>"+    
                    "<td>&nbsp;&nbsp;&nbsp;</td>"+    
                    "<td>"+
                    "    <b><!--T1653T-->Saldo<!--T1653T--></b>"+
                    "</td>"+    
                    ""+
                    "</tr>";

    for(var index = 0; index < compData.teams.length; index++) {
        var item = compData.teams[index];
        resultText += "<tr>"+
        "<td>" +index +"</td><td></td>"+
        "<td>" +item.teamname +"</td><td></td>"+
        "<td>" +item.punten +"</td><td></td>"+
        "<td>" +item.numGespeeld +"</td><td></td>"+
        "<td>" +item.numGewonnen +"</td><td></td>"+
        "<td>" +item.numVerloren +"</td><td></td>"+
        "<td>" +item.numGelijk +"</td><td></td>"+
        "<td>" +item.strafpunten +"</td><td></td>"+
        "<td>" +item.saldoVoor +"-"+item.saldoTegen +"</td><td></td>"+
        "</tr>";
    }
    resultText += "</table>";
    element.innerHTML = resultText;
    
    // Make the rows dual color
    var table = document.getElementById("dualcolortablestand");
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
function addTeams(){
    
    /*
     * Create JSON object with all modified fields
     */
    var JSONObject = new Object;
    JSONObject.teams = new Array;
    JSONObject.request = "newMTeams";
    JSONObject.competitionID = getSelectedCompetitionID();
    var changedIndex = 0;
    for(var index = 0; index < 20; index++) {
        var fieldnameTeamname = 'newteam_teamname_' + index;
        var fieldnameAanvoerder = 'newteam_aanvoerder_' + index;
        var fieldnameEmail = 'newteam_email_' + index;
        
        var newTeamname= document.getElementById(fieldnameTeamname).value;
        var newAanvoerder = document.getElementById(fieldnameAanvoerder).value;
        var newEmail = document.getElementById(fieldnameEmail).value;
        
        // check minimal fields
        var newTeam = true;
        if (newTeamname=="") newTeam = false;
        
        
        if (newTeam){
            JSONObject.teams[changedIndex] = new Object;
            JSONObject.teams[changedIndex].teamname = newTeamname;
            JSONObject.teams[changedIndex].aanvoerder = newAanvoerder;
            JSONObject.teams[changedIndex].email = newEmail;
            changedIndex++;            
        }
    }
    
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        reloadCompetitions();
        javascript:document.getElementById('newTeams').style.display = 'none';
    }, function onError(resultJSON) {
        javascript:document.getElementById('newTeams').style.display = 'none';
        ts_showGlobalError("<!--T1654T-->Fout bij opslaan veranderingen<!--T1654T-->", resultJSON.errorMsg);
    }, false);
    
}

/*************************************************
 *
 **************************************************/
function openNewTeams() {
    document.getElementById('newTeams').style.display = '';
    document.getElementById('editTeams').style.display = 'none';
    var element = document.getElementById('newTeamsList');
    if(element==null) return;
    
    var resultText = "<table  border=0 id=dualcolortable cellspacing='0'>";
    resultText += "<tr>";
    resultText += "<td>&nbsp;&nbsp;</td>";
    resultText += "<td><!--T1655T-->Teamnaam<!--T1655T--></td>";
    resultText += "<td>&nbsp;&nbsp;</td>";
    resultText += "<td><!--T1656T-->Aanvoerder<!--T1656T--></td>";
    resultText += "<td>&nbsp;&nbsp;</td>";
    resultText += "<td><!--T1657T-->Email<!--T1657T--></td>";
    resultText += "</tr>";

    for(var index = 0; index < 20; index++) {
        var fieldnameTeamname = 'newteam_teamname_' + index;
        var fieldnameAanvoerder = 'newteam_aanvoerder_' + index;
        var fieldnameEmail = 'newteam_email_' + index;

        var fieldTeamname = "<input id='" + fieldnameTeamname + "' type='text' value='' size=40  onkeydown='if (event.keyCode == 13) saveNewTeams()'/>";
        var fieldAanvoerder = "<input id='" + fieldnameAanvoerder + "' type='text' value='' size=20 onkeydown='if (event.keyCode == 13) saveNewTeams()'/>";
        var fieldEmail = "<input id='" + fieldnameEmail + "' type='text' value='' size=20 onkeydown='if (event.keyCode == 13) saveNewTeams()'/>";
        
        
        resultText += "<tr>";
        resultText += "<td>&nbsp;&nbsp;</td>";
        resultText += "<td>"+fieldTeamname+"</td>";
        resultText += "<td>&nbsp;&nbsp;</td>";
        resultText += "<td>"+fieldAanvoerder+"</td>";
        resultText += "<td>&nbsp;&nbsp;</td>";
        resultText += "<td>"+fieldEmail+"</td>";
        
        resultText += "</tr>";
        
        
    }
    resultText += "</table>";

    element.innerHTML = resultText;
    
}



function saveTeams(){
    compData = savedCompetition;
    javascript:document.getElementById('editTeams').style.display = 'none';
    
    /*
     * Create JSON object with all modified fields
     */
    var JSONObject = new Object;
    JSONObject.teams = new Array;
    JSONObject.request = "updateMTeams";
    var changedIndex = 0;

    for(var index = 0; index < compData.teams.length; index++) {
        var item = compData.teams[index];
        var season = item;
        var fieldname1 = 'team_teamname_' + index;
        var fieldname2 = 'team_aanvoerder_' + index;
        var fieldname3 = 'team_email_' + index;
        var fieldname4 = 'team_strafpunten_' + index;

        var valueTeamname = item.teamname;
        var valueAanvoerder = item.aanvoerder;
        var valueEmail = item.email;
        var valueStrafpunten = item.strafpunten;
        
        var newTeamname= document.getElementById(fieldname1).value;
        var newAanvoerder = document.getElementById(fieldname2).value;
        var newEmail = document.getElementById(fieldname3).value;
        var newStrafpunten = document.getElementById(fieldname4).value;
        
        var changed = false;
        
        if (valueTeamname!=newTeamname) changed = true;
        if (valueAanvoerder!=newAanvoerder) changed = true;
        if (valueEmail!=newEmail) changed = true;
        if (valueStrafpunten!=newStrafpunten) changed = true;
        
        if (changed){
            JSONObject.teams[changedIndex] = new Object;
            JSONObject.teams[changedIndex].id = item.id;
            JSONObject.teams[changedIndex].teamname = newTeamname;
            JSONObject.teams[changedIndex].aanvoerder = newAanvoerder;
            JSONObject.teams[changedIndex].email = newEmail;
            JSONObject.teams[changedIndex].strafpunten = newStrafpunten;
            changedIndex++;            
        }
    }
    
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        reloadCompetitions();
        javascript:document.getElementById('editTeams').style.display = 'none';
    }, function onError(resultJSON) {
        javascript:document.getElementById('editTeams').style.display = 'none';
        ts_showGlobalError("<!--T1658T-->Fout bij opslaan veranderingen<!--T1658T-->", resultJSON.errorMsg);
    }, false);
    
}

function loadTeams(){
    compData = savedCompetition;
    var element = document.getElementById('teams');
    if(element==null) return;
    
    
    var resultText = "<table width=750 border=0 id=dualcolortableteams cellspacing='0'>"+
                    "<tr>"+ 
                    "<td>"+
                    "    <b><!--T1659T-->Team<!--T1659T--></b>"+
                    "</td>"+    
                    "<td>&nbsp;&nbsp;&nbsp;</td>"+    
                    "<td>"+
                    "    <b><!--T1660T-->Aanvoerder<!--T1660T--></b>"+
                    "</td>"+    
                    "<td>&nbsp;&nbsp;&nbsp;</td>"+    
                    "<td>"+
                    "    <b><!--T1661T-->Email<!--T1661T--></b>"+
                    "</td>"+    
                    "<td>&nbsp;&nbsp;&nbsp;</td>"+    
                    "<td>"+
                    "    <b><!--T1662T-->Strafpunten<!--T1662T--></b>"+
                    "</td>"+    
                    ""+
                    "</tr>";

    for(var index = 0; index < compData.teams.length; index++) {
        var item = compData.teams[index];
        resultText += "<tr>"+
        "<td>" +item.teamname +"</td><td></td>"+
        "<td>" +item.aanvoerder +"</td><td></td>"+
        "<td>" +item.email +"</td><td></td>"+
        "<td>" +item.strafpunten+"</td><td></td>"+
        "</tr>";
    }
    resultText += "</table>";
    element.innerHTML = resultText;
    
    // Make the rows dual color
    var table = document.getElementById("dualcolortableteams");
    for (var i = 0, row; row = table.rows[i]; i++) {
        if ((i % 2 == 0)){
            row.className  = "dualcolortableRowNoHighlight";
        }
        else{
            row.className  = "dualcolortableRowHighlight";
        }
    }        
 
    
  // Now load the seasons in the edit layer
 
    var resultText = "<table width=750 border=0 id=dualcolortableteams cellspacing='0'>"+
                    "<tr>"+ 
                    "<td>"+
                    "    <b><!--T1663T-->Team<!--T1663T--></b>"+
                    "</td>"+    
                    "<td>&nbsp;&nbsp;&nbsp;</td>"+    
                    "<td>"+
                    "    <b><!--T1664T-->Aanvoerder<!--T1664T--></b>"+
                    "</td>"+    
                    "<td>&nbsp;&nbsp;&nbsp;</td>"+    
                    "<td>"+
                    "    <b><!--T1665T-->Email<!--T1665T--></b>"+
                    "</td>"+    
                    "<td>&nbsp;&nbsp;&nbsp;</td>"+    
                    "<td>"+
                    "    <b><!--T1666T-->Strafpunten<!--T1666T--></b>"+
                    "</td>"+    
                    ""+
                    "</tr>";

    for(var index = 0; index < compData.teams.length; index++) {
        var item = compData.teams[index];
        var season = item;
        var fieldname1 = 'team_teamname_' + index;
        var fieldname2 = 'team_aanvoerder_' + index;
        var fieldname3 = 'team_email_' + index;
        var fieldname4 = 'team_strafpunten_' + index;
        resultText += "<tr>"+
        "<td><input id='" + fieldname1 + "' type='text' value='" + ts_escapeQuotes(item.teamname) + "' onkeydown='if (event.keyCode == 13) saveTeams()'/></td><td width=20></td>"+
        "<td><input id='" + fieldname2 + "' type='text' value='" + ts_escapeQuotes(item.aanvoerder) + "' onkeydown='if (event.keyCode == 13) saveTeams()'/></td><td width=20></td>"+
        "<td><input id='" + fieldname3 + "' type='text' value='" + ts_escapeQuotes(item.email) + "' onkeydown='if (event.keyCode == 13) saveTeams()'/></td><td width=20></td>"+
        "<td><input id='" + fieldname4 + "' type='text' value='" + ts_escapeQuotes(item.strafpunten) + "' onkeydown='if (event.keyCode == 13) saveTeams()'/></td><td width=20></td>"+
        "</td><td width=20></td>"+
        "<td><a href='#' onclick='javascript:removeTeam(" + season.id + ");'>Verwijder</a></td></tr>";
        seasonValues[index] = season.season;
        seasonIDs[index] = season.id;
    }
    resultText += "</table>";
    document.getElementById('teamsList').innerHTML = resultText;     
 
    
}

/*************************************************
 *
 **************************************************/
function removeMGame(gameID) {
    /*
     * Create JSON object with all modified fields
     */
    var JSONObject = new Object;
    JSONObject.gameID = gameID;
    JSONObject.request = "removeMGame";
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        reloadCompetitions();
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1667T-->Fout bij verwijderen van wedstrijd<!--T1667T-->", resultJSON.errorMsg);
    }, false);
}




function showProgramma(){
   document.getElementById('programma').style.display = ""; 
   document.getElementById('uitslagen').style.display = "none"; 
   document.getElementById('stand').style.display = "none";
   document.getElementById('details').style.display = "none"; 
   document.getElementById('teams').style.display = "none"; 
   document.getElementById('progImage').src="images/tab-programma2.png"; 
   document.getElementById('progUitslagen').src="images/tab-uitslagen.png"; 
   document.getElementById('progStand').src="images/tab-stand.png"; 
   document.getElementById('progTeams').src="images/tab-teams.png"; 
}

function showUitslagen(){
   document.getElementById('programma').style.display = "none"; 
   document.getElementById('uitslagen').style.display = ""; 
   document.getElementById('stand').style.display = "none"; 
   document.getElementById('details').style.display = "none"; 
   document.getElementById('teams').style.display = "none"; 
   document.getElementById('progImage').src="images/tab-programma.png"; 
   document.getElementById('progUitslagen').src="images/tab-uitslagen2.png"; 
   document.getElementById('progStand').src="images/tab-stand.png"; 
   document.getElementById('progTeams').src="images/tab-teams.png"; 
}

function showStand(){
   document.getElementById('programma').style.display = "none"; 
   document.getElementById('uitslagen').style.display = "none"; 
   document.getElementById('stand').style.display = ""; 
   document.getElementById('details').style.display = "none"; 
   document.getElementById('teams').style.display = "none"; 
   document.getElementById('progImage').src="images/tab-programma.png"; 
   document.getElementById('progUitslagen').src="images/tab-uitslagen.png"; 
   document.getElementById('progStand').src="images/tab-stand2.png"; 
   document.getElementById('progTeams').src="images/tab-teams.png"; 
}


function showTeams(){
   document.getElementById('programma').style.display = "none"; 
   document.getElementById('uitslagen').style.display = "none"; 
   document.getElementById('stand').style.display = "none"; 
   document.getElementById('details').style.display = "none"; 
   document.getElementById('teams').style.display = ""; 
   document.getElementById('progImage').src="images/tab-programma.png"; 
   document.getElementById('progUitslagen').src="images/tab-uitslagen.png"; 
   document.getElementById('progStand').src="images/tab-stand.png"; 
   document.getElementById('progTeams').src="images/tab-teams2.png"; 
}