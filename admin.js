/*************************************************
 *
 **************************************************/

function syncMCompetition() {
    var JSONObject = new Object;
    JSONObject.request = "syncMCompetition";

    ts_runAjax(JSONObject, function onSuccess(resultJSON) {
        ts_showGlobalSuccess("Gelukt", "gelukt",null);
    }, function onError(resultJSON) {
        ts_showGlobalError("Fout bij ophalen van de wedstrijden", resultJSON.errorMsg);
    }, false);
}


function dbSummary() {
    var JSONObject = new Object;
    JSONObject.request = "dbSummary";

    ts_runAjax(JSONObject, function onSuccess(resultJSON) {
        loadDBSummary(resultJSON.result);
    }, function onError(resultJSON) {
        ts_showGlobalError("Fout bij ophalen van de wedstrijden", resultJSON.errorMsg);
    }, false);
}


/*************************************************
 *
 **************************************************/
function loadDBSummary($dbResult) {
    var resultText = "<table id=dualcolortable1 cellspacing='0'>";
    resultText += "<tr>";
    resultText += "<td ><b>#teams</b></td>";
    resultText += "<td >&nbsp;&nbsp;:&nbsp;&nbsp;</td>";
    resultText += "<td >"+$dbResult.teamcount+"</td>";
    resultText += "</tr>";

    resultText += "<tr>";
    resultText += "<td ><b>#games</b></td>";
    resultText += "<td >&nbsp;&nbsp;:&nbsp;&nbsp;</td>";
    resultText += "<td >"+$dbResult.gamecount+"</td>";
    resultText += "</tr>";

    resultText += "<tr>";
    resultText += "<td ><b>#members</b></td>";
    resultText += "<td >&nbsp;&nbsp;:&nbsp;&nbsp;</td>";
    resultText += "<td >"+$dbResult.teammembercount+"</td>";
    resultText += "</tr>";

    resultText += "<tr>";
    resultText += "<td ><b>#competitions</b></td>";
    resultText += "<td >&nbsp;&nbsp;:&nbsp;&nbsp;</td>";
    resultText += "<td >"+$dbResult.competitioncount+"</td>";
    resultText += "</tr>";

    resultText += "<tr>";
    resultText += "<td ><b>#users</b></td>";
    resultText += "<td >&nbsp;&nbsp;:&nbsp;&nbsp;</td>";
    resultText += "<td >"+$dbResult.userscount+"</td>";
    resultText += "</tr>";
    resultText += "</table>";
    resultText += "<br>";

    document.getElementById('dbSummary').innerHTML = resultText;
}

function listChanges() {
    var JSONObject = new Object;
    JSONObject.request = "adminListAllChanges";
    JSONObject.filterLogGameID = document.getElementById('filterLogGameID').value;
    JSONObject.filterLogTeamID = document.getElementById('filterLogTeamID').value;
    JSONObject.filterLogUserID =document.getElementById('filterLogUserID').value;
    JSONObject.filterLogMemberID = document.getElementById('filterLogMemberID').value;

    ts_runAjax(JSONObject, function onSuccess(resultJSON) {
        loadChanges(resultJSON.result);
    }, function onError(resultJSON) {
        ts_showGlobalError("Fout bij ophalen van de wedstrijden", resultJSON.errorMsg);
    }, false);
}

function listTeams() {
    var JSONObject = new Object;
    JSONObject.request = "adminListAllTeams";

    ts_runAjax(JSONObject, function onSuccess(resultJSON) {
        loadTeams(resultJSON.result);
    }, function onError(resultJSON) {
        ts_showGlobalError("Fout bij ophalen van de wedstrijden", resultJSON.errorMsg);
    }, false);
}

function listUsers() {
    var JSONObject = new Object;
    JSONObject.request = "adminListAllUsers";

    ts_runAjax(JSONObject, function onSuccess(resultJSON) {
        loadUsers(resultJSON.result);
    }, function onError(resultJSON) {
        ts_showGlobalError("Fout bij ophalen van de wedstrijden", resultJSON.errorMsg);
    }, false);
}

function listTeammembers() {
    var JSONObject = new Object;
    JSONObject.request = "adminListAllTeammembers";
    JSONObject.filterTeamID = document.getElementById('filterTeamID').value;

    ts_runAjax(JSONObject, function onSuccess(resultJSON) {
        loadTeammembers(resultJSON.result);
    }, function onError(resultJSON) {
        ts_showGlobalError("Fout bij ophalen van de wedstrijden", resultJSON.errorMsg);
    }, false);
}

function removeTeam(teamID) {
    var JSONObject = new Object;
    JSONObject.request = "adminRemoveTeam";
    JSONObject.teamID = teamID;

    ts_runAjax(JSONObject, function onSuccess(resultJSON) {
        listTeams();
    }, function onError(resultJSON) {
        ts_showGlobalError("Fout bij ophalen van de wedstrijden", resultJSON.errorMsg);
    }, false);
}

function removeUser(userID) {
    var JSONObject = new Object;
    JSONObject.request = "adminRemoveUser";
    JSONObject.userID = userID;

    ts_runAjax(JSONObject, function onSuccess(resultJSON) {
        listUsers();
    }, function onError(resultJSON) {
        ts_showGlobalError("Fout bij ophalen van de wedstrijden", resultJSON.errorMsg);
    }, false);
}

function enableProUser(userID) {
    var JSONObject = new Object;
    JSONObject.request = "adminEnableProUser";
    JSONObject.userID = userID;

    ts_runAjax(JSONObject, function onSuccess(resultJSON) {
        listUsers();
    }, function onError(resultJSON) {
        ts_showGlobalError("Fout bij ophalen van de enable Pro", resultJSON.errorMsg);
    }, false);
}

function disableProUser(userID) {
    var JSONObject = new Object;
    JSONObject.request = "adminDisableProUser";
    JSONObject.userID = userID;

    ts_runAjax(JSONObject, function onSuccess(resultJSON) {
        listUsers();
    }, function onError(resultJSON) {
        ts_showGlobalError("Fout bij ophalen van de disable Pro", resultJSON.errorMsg);
    }, false);
}


/*************************************************
 *
 **************************************************/
function loadTeams($teams) {
    var resultText = "<table width=750 id=dualcolortable1 cellspacing='0'>";
    resultText += "<tr height=25>";
    resultText += "<td ><b>ID</b></td>";
    resultText += "<td width=10></td>";
    resultText += "<td ><b>Team</b></td>";
    resultText += "<td width=10></td>";
    resultText += "<td ><b>#games</b></td>";
    resultText += "<td width=10></td>";
    resultText += "<td ><b>#teamleden</b></td>";
    resultText += "<td width=10></td>";
    resultText += "<td ><b>#competitions</b></td>";
    resultText += "<td width=10></td>";
    resultText += "<td ><b>remove</b></td>";
    resultText += "<td></td></tr>";

    for(var index = 0; index < $teams.length; index++) {
        var item = $teams[index];
        
        resultText += "<tr height=25>";
        resultText += "<td >"+item.teamid+"</td>";
        resultText += "<td width=10></td>";
        resultText += "<td >"+item.teamname+"</td>";
        resultText += "<td width=10></td>";
        resultText += "<td >"+item.gamecount+"</td>";
        resultText += "<td width=10></td>";
        resultText += "<td >"+item.teammembercount+"</td>";
        resultText += "<td width=10></td>";
        resultText += "<td >"+item.competitioncount+"</td>";
        resultText += "<td width=10></td>";
        resultText += "<td ><a href=# onclick='javascript:removeTeam("+item.teamid+");'>[remove team]</a></td>";
        resultText += "<td></td></tr>";
    }
    resultText += "</table>";

    document.getElementById('teamlist').innerHTML = resultText;
}


/*************************************************
 *
 **************************************************/
function loadChanges($changes) {
    var resultText = "<table width=100% id=dualcolortable1 cellspacing='0'>";
    resultText += "<tr height=25>";
    resultText += "<td ><b>User</b></td>";
    resultText += "<td width=10></td>";
    resultText += "<td ><b>Date</b></td>";
    resultText += "<td width=10></td>";
    resultText += "<td ><b>Time</b></td>";
    resultText += "<td width=10></td>";
    resultText += "<td ><b>GameID</b></td>";
    resultText += "<td width=10></td>";
    resultText += "<td ><b>TeamID</b></td>";
    resultText += "<td width=10></td>";
    resultText += "<td ><b>UserID</b></td>";
    resultText += "<td width=10></td>";
    resultText += "<td ><b>MemberID</b></td>";
    resultText += "<td width=10></td>";
    resultText += "<td ><b>Action</b></td>";
    resultText += "<td width=10></td>";
    resultText += "<td ><b>Statement</b></td>";
    resultText += "<td></td></tr>";

    for(var index = 0; index < $changes.length; index++) {
        var item = $changes[index];
        
        resultText += "<tr height=25>";
        resultText += "<td >"+item.user+"</td>";
        resultText += "<td width=10></td>";
        resultText += "<td >"+item.date+"</td>";
        resultText += "<td width=10></td>";
        resultText += "<td >"+item.time+"</td>";
        resultText += "<td width=10></td>";
        resultText += "<td >"+item.gameID+"</td>";
        resultText += "<td width=10></td>";
        resultText += "<td >"+item.teamID+"</td>";
        resultText += "<td width=10></td>";
        resultText += "<td >"+item.userID+"</td>";
        resultText += "<td width=10></td>";
        resultText += "<td >"+item.memberID+"</td>";
        resultText += "<td width=10></td>";
        resultText += "<td >"+item.action+"</td>";
        resultText += "<td width=10></td>";
        resultText += "<td >"+item.statement+"</td>";
        resultText += "<td></td></tr>";
    }
    resultText += "</table>";

    document.getElementById('changesist').innerHTML = resultText;
}


/*************************************************
 *
 **************************************************/
function loadUsers($users) {
    var resultText = "<table width=750 id=dualcolortable1 cellspacing='0'>";
    resultText += "<tr height=25>";
    resultText += "<td ><b>ID</b></td>";
    resultText += "<td width=10></td>";
    resultText += "<td ><b>User</b></td>";
    resultText += "<td width=10></td>";
    resultText += "<td ><b>email</b></td>";
    resultText += "<td width=10></td>";
    resultText += "<td ><b>proUser</b></td>";
    resultText += "<td width=10></td>";
    resultText += "<td ><b>premiumDate</b></td>";
    resultText += "<td width=10></td>";
    resultText += "<td ><b>#teams</b></td>";
    resultText += "<td width=10></td>";
    resultText += "<td ><b>remove</b></td>";
    resultText += "<td></td></tr>";

    for(var index = 0; index < $users.length; index++) {
        var item = $users[index];
        
        resultText += "<tr height=25>";
        resultText += "<td >"+item.id+"</td>";
        resultText += "<td width=10></td>";
        resultText += "<td >"+item.username+"</td>";
        resultText += "<td width=10></td>";
        resultText += "<td >"+item.email+"</td>";
        resultText += "<td width=10></td>";
        resultText += "<td >"+item.proUser+"</td>";
        resultText += "<td width=10></td>";
        resultText += "<td >"+item.endProDate+"</td>";
        resultText += "<td width=10></td>";
        resultText += "<td >"+item.teammembercount+"</td>";
        resultText += "<td width=10></td>";
        resultText += "<td ><a href=# onclick='javascript:removeUser("+item.id+");'>[remove]</a>&nbsp;&nbsp;";
        resultText += "<a href=# onclick='javascript:enableProUser("+item.id+");'>[pro+]</a>&nbsp;&nbsp;";
        resultText += "<a href=# onclick='javascript:disableProUser("+item.id+");'>[pro-]</a></td>";
        resultText += "<td></td></tr>";
    }
    resultText += "</table>";

    document.getElementById('userlist').innerHTML = resultText;
}

/*************************************************
 *
 **************************************************/
function loadTeammembers($users) {
    var resultText = "<table width=750 id=dualcolortable1 cellspacing='0'>";
    resultText += "<tr height=25>";
    resultText += "<td ><b>memberID</b></td>";
    resultText += "<td width=10></td>";
    resultText += "<td ><b>userID</b></td>";
    resultText += "<td width=10></td>";
    resultText += "<td ><b>Username</b></td>";
    resultText += "<td width=10></td>";
    resultText += "<td ><b>Nickname</b></td>";
    resultText += "<td width=10></td>";
    resultText += "<td ><b>email</b></td>";
    resultText += "<td width=10></td>";
    resultText += "<td></td></tr>";

    for(var index = 0; index < $users.length; index++) {
        var item = $users[index];
        
        resultText += "<tr height=25>";
        resultText += "<td >"+item.memberID+"</td>";
        resultText += "<td width=10></td>";
        resultText += "<td >"+item.userID+"</td>";
        resultText += "<td width=10></td>";
        resultText += "<td >"+item.nickname+"</td>";
        resultText += "<td width=10></td>";
        resultText += "<td >"+item.username+"</td>";
        resultText += "<td width=10></td>";
        resultText += "<td >"+item.email+"</td>";
        resultText += "<td></td></tr>";
    }
    resultText += "</table>";

    document.getElementById('userlist').innerHTML = resultText;
}