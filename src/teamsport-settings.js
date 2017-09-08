var savedTeamMembers = null;



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
    }
    else{
        document.getElementById('modifyButton1b').style.display = "none"; 
    }
    
    if (anonimousLogin){
        document.getElementById('modifyButton2b').style.display = "none"; 
        document.getElementById('modifyButton3b').style.display = "none"; 
        document.getElementById('settingsData').style.display = "none"; 
        document.getElementById('textForAnonimousTeam').style.display = ""; 
    }
    else{
        document.getElementById('modifyButton2b').style.display = ""; 
        document.getElementById('modifyButton3b').style.display = ""; 
        document.getElementById('settingsData').style.display = ""; 
        document.getElementById('textForAnonimousTeam').style.display = "none"; 
    } 
    
}


/*************************************************
 *
 **************************************************/
function getMailto($to) {
    if ($to==0) return "<!--T1725T-->niemand<!--T1725T-->";
    if ($to==1) return "<!--T1726T-->de beheerders<!--T1726T-->";
    if ($to==2) return "<!--T1727T-->iedereen<!--T1727T-->";
}


/*************************************************
 *
 **************************************************/
function loadTeamData($teamdata) {
    var voorkeur = $teamdata.voorkeursNrAanwezig;
    /*T1728T*/
    var reminder = "nee";
    if ($teamdata.reminderDays>0){
        reminder = "ja, "+$teamdata.reminderDays+" dagen van te voren";
    }
    var tekort = "nee";
    if ($teamdata.tekortMailTo>0){
        tekort = "ja, naar "+getMailto($teamdata.tekortMailTo);
    }
    var waarschuwing = "nee";
    if ($teamdata.waarschuwingMailTo>0){
        waarschuwing = "ja, "+$teamdata.waarschuwingMailDagen+" dagen van te voren, naar "+getMailto($teamdata.waarschuwingMailTo);
    }
    /*T1728T*/
    document.getElementById('teamname').innerHTML = $teamdata.teamname;
    document.getElementById('sport').innerHTML = $teamdata.sport;
    document.getElementById('vereniging').innerHTML = $teamdata.vereniging;   
    document.getElementById('voorkeur').innerHTML = voorkeur;   
    document.getElementById('reminder').innerHTML = reminder;
    document.getElementById('tekort').innerHTML = tekort;
    document.getElementById('waarschuwing').innerHTML = waarschuwing;
    
    document.getElementById('teamnameEdit').value = $teamdata.teamname;
    document.getElementById('sportEdit').value = $teamdata.sport;
    document.getElementById('verenigingEdit').value = $teamdata.vereniging;   
    document.getElementById('voorkeurEdit').value = $teamdata.voorkeursNrAanwezig;
    document.getElementById('reminderDaysEdit').value = $teamdata.reminderDays;
    document.getElementById('waarschuwingDaysEdit').value = $teamdata.waarschuwingMailDagen;
    
    document.getElementById('reminderEdit0').checked = $teamdata.reminderDays==0;
    document.getElementById('reminderEdit1').checked = $teamdata.reminderDays>0;
    
    document.getElementById('tekortToEdit0').checked = $teamdata.tekortMailTo==0;
    document.getElementById('tekortToEdit1').checked = $teamdata.tekortMailTo==1;
    document.getElementById('tekortToEdit2').checked = $teamdata.tekortMailTo==2;
    
    document.getElementById('waarschuwingToEdit0').checked = $teamdata.waarschuwingMailTo==0;
    document.getElementById('waarschuwingToEdit1').checked = $teamdata.waarschuwingMailTo==1;
    document.getElementById('waarschuwingToEdit2').checked = $teamdata.waarschuwingMailTo==2;
    
    document.getElementById('waarschuwingToEdit2').checked = $teamdata.waarschuwingMailTo==2;
    
    if ($teamdata.waarschuwingMailTo==0 || $teamdata.waarschuwingMailTo==null){
        document.getElementById('rowWarningEdit').style.display = 'none';
    }
    else{
        document.getElementById('rowWarningEdit').style.display = '';
    }
    
    if ($teamdata.reminderDays==0 || $teamdata.reminderDays==null){
        document.getElementById('rowReminderEdit').style.display = 'none';
    }
    else{
        document.getElementById('rowReminderEdit').style.display = '';
    }
    
	
    document.getElementById('teamheader').innerHTML = "&nbsp;"+$teamdata.teamname+" <!--T1729T-->instellingen<!--T1729T-->";
}

function reminderChangeClick(){
    if (document.getElementById('reminderEdit1').checked){
        document.getElementById('rowReminderEdit').style.display = '';
        if (document.getElementById('reminderDaysEdit').value==0){
            document.getElementById('reminderDaysEdit').value=4;
        }
        
    }
    else{
        document.getElementById('rowReminderEdit').style.display = 'none';
    }
}

/*************************************************
 *
 **************************************************/
function saveTeam() {
    
    /*
     * Create JSON object with all modified fields
     */
    var JSONObject = new Object;
    JSONObject.request = "saveTeam";

    JSONObject.teamID = initialSelectedTeamID;
    JSONObject.teamname = document.getElementById('teamnameEdit').value.trim(); 
    JSONObject.vereniging = document.getElementById('verenigingEdit').value.trim(); 
    JSONObject.sport = document.getElementById('sportEdit').value.trim(); 
    JSONObject.voorkeursNrAanwezig = document.getElementById('voorkeurEdit').value.trim(); 

    JSONObject.waarschuwingMailDagen = document.getElementById('waarschuwingDaysEdit').value.trim();

    JSONObject.tekortMailTo = 0; 
    JSONObject.waarschuwingMailTo = 0; 

    if (document.getElementById('reminderEdit0').checked) JSONObject.reminderDays = 0;
    if (document.getElementById('reminderEdit1').checked) JSONObject.reminderDays = document.getElementById('reminderDaysEdit').value.trim();


    if (document.getElementById('tekortToEdit0').checked) JSONObject.tekortMailTo = 0;
    if (document.getElementById('tekortToEdit1').checked) JSONObject.tekortMailTo = 1;
    if (document.getElementById('tekortToEdit2').checked) JSONObject.tekortMailTo = 2;
    
    if (document.getElementById('waarschuwingToEdit0').checked) JSONObject.waarschuwingMailTo = 0;
    if (document.getElementById('waarschuwingToEdit1').checked) JSONObject.waarschuwingMailTo = 1;
    if (document.getElementById('waarschuwingToEdit2').checked) JSONObject.waarschuwingMailTo = 2;
    
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        reloadTeam();      
        document.getElementById('editTeam').style.display = 'none';
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1730T-->Fout bij opslaan veranderingen<!--T1730T-->", resultJSON.errorMsg);
    }, false);
}


/*************************************************
 *
 **************************************************/
function changePW() {
    
    /*
     * Create JSON object with all modified fields
     */
    var JSONObject = new Object;
    JSONObject.request = "changePW";

    JSONObject.userID = currentUserID;
    JSONObject.oldPW = document.getElementById('oldPW').value.trim(); 
    JSONObject.newPW1 = document.getElementById('newPW1').value.trim(); 
    JSONObject.newPW2 = document.getElementById('newPW2').value.trim(); 
    
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        window.location = 'logout.php';
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1731T-->Foutmelding<!--T1731T-->", resultJSON.errorMsg);
    }, false);
}




function loadUserData($userdata) {
    document.getElementById('username').innerHTML = $userdata.username;
    document.getElementById('name').innerHTML = $userdata.name;
    document.getElementById('email').innerHTML = $userdata.email;
    document.getElementById('phonenr').innerHTML = $userdata.phonenumber;

    document.getElementById('usernameEdit').innerHTML = $userdata.username;
    document.getElementById('nameEdit').value = $userdata.name;
    document.getElementById('emailEdit').value = $userdata.email;
    document.getElementById('phonenrEdit').value = $userdata.phonenumber;
}

function saveUser() {
    /*
     * Create JSON object with all modified fields
     */
    var JSONObject = new Object;
    JSONObject.request = "saveUser";
    JSONObject.userID= currentUserID;
    JSONObject.name= document.getElementById('nameEdit').value.trim();
    JSONObject.email= document.getElementById('emailEdit').value.trim();
    JSONObject.phonenumber= document.getElementById('phonenrEdit').value.trim();
    
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        reloadUser();      
        document.getElementById('editUser').style.display = 'none';
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1732T-->Fout bij opslaan veranderingen<!--T1732T-->", resultJSON.errorMsg);
    }, false);
}


function reloadUser() {
    /*
     * Create JSON object with all modified fields
     */
    var JSONObject = new Object;
    JSONObject.request = "loadUser";
    JSONObject.userID = currentUserID;
    ts_runAjax(JSONObject, function onSuccess(resultJSON) {
        loadUserData(resultJSON.result);        
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1733T-->Fout bij het verversen van de gebruikers data<!--T1733T-->", resultJSON.errorMsg);
    }, false);
}


function reloadTeam() {
    /*
     * Create JSON object with all modified fields
     */
    var JSONObject = new Object;
    JSONObject.request = "loadTeam";
    JSONObject.teamID = initialSelectedTeamID;
    ts_runAjax(JSONObject, function onSuccess(resultJSON) {
        loadTeamData(resultJSON.result);        
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1734T-->Fout bij het verversen van de gebruikers data<!--T1734T-->", resultJSON.errorMsg);
    }, false);
}

function reloadTeamUsersData() {
    /*
     * Create JSON object with all modified fields
     */
    var JSONObject = new Object;
    JSONObject.request = "loadTeammembersOfUser";
    JSONObject.userID = currentUserID;
    ts_runAjax(JSONObject, function onSuccess(resultJSON) {
        loadTeamUsersData(resultJSON.result);        
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1735T-->Fout bij het verversen van de gebruikers data<!--T1735T-->", resultJSON.errorMsg);
    }, false);
}


function loadTeamUsersData(teammembers){
    savedTeamMembers = teammembers;
    var resultText = "";
    var resultTextEdit = "";
    resultText += "<table>"
    resultTextEdit += "<table>"
    for(var index = 0; index < teammembers.length; index++) {
        var item = teammembers[index];
        resultText += "<tr>"
        resultText += "<td>"
        resultText += "<b><!--T1736T-->Bijnaam voor team<!--T1736T--> '"+item.teamname+"'</b>";
        resultText += "</td>"
        resultText += "<td width=10></td>"
        resultText += "<td>:</td>"
        resultText += "<td width=10></td>"
        resultText += "<td>"
        resultText += item.nickname;
        resultText += "</td>"
        resultText += "</tr>"
        
        resultText += "<tr>"
        resultText += "<td>"
        resultText += "<b><!--T1737T-->Ontvang alle teamberichten per email<!--T1737T--></b>";
        resultText += "</td>"
        resultText += "<td width=10></td>"
        resultText += "<td>:</td>"
        resultText += "<td width=10></td>"
        resultText += "<td>"
        if (item.acceptEmail==1){
            resultText += "ja";
        }
        else{
            resultText += "nee";
        }
        resultText += "</td>"
        resultText += "</tr>"

        resultText += "<tr height=10>"
        resultText += "<td>&nbsp;</td>"
        resultText += "</tr>"
        // same for edit fields
        resultTextEdit += "<tr>"
        resultTextEdit += "<td>"
        resultTextEdit += "<b><!--T1738T-->Bijnaam voor team<!--T1738T--> '"+item.teamname+"'</b>";
        resultTextEdit += "</td>"
        resultTextEdit += "<td width=10></td>"
        resultTextEdit += "<td>:</td>"
        resultTextEdit += "<td width=10></td>"
        resultTextEdit += "<td>"
        resultTextEdit += "<input id = 'teammember_nickname_"+item.id+"' type='text' class='gameEditFields50' value='"+item.nickname+"'/>"
        resultTextEdit += "</td>"
        resultTextEdit += "</tr>"
        
        resultTextEdit += "<tr>"
        resultTextEdit += "<td>"
        resultTextEdit += "<b><!--T1739T-->Ontvang alle teamberichten per email<!--T1739T--></b>";
        resultTextEdit += "</td>"
        resultTextEdit += "<td width=10></td>"
        resultTextEdit += "<td>:</td>"
        resultTextEdit += "<td width=10></td>"
        resultTextEdit += "<td>"
        if (item.acceptEmail==1){
            resultTextEdit += "<input id = 'teammember_acceptmail_"+item.id+"' type='checkbox' checked />"
        }
        else{
            resultTextEdit += "<input id = 'teammember_acceptmail_"+item.id+"' type='checkbox' />"
        }
        resultTextEdit += "</td>"
        resultTextEdit += "</tr>"

        resultTextEdit += "<tr height=10>"
        resultTextEdit += "<td>&nbsp;</td>"
        resultTextEdit += "</tr>"
        
        
    }
    resultText += "</table>"
    resultTextEdit += "</table>"
    document.getElementById('myTeamsData').innerHTML = resultText;
    document.getElementById('myTeamsDataEdit').innerHTML = resultTextEdit;
}



function saveTeamUsersData(){
    var JSONObject = new Object;
    JSONObject.request = "saveTeammembers2";
    JSONObject.changedLists = new Array;
    var changedIndex = 0;


    for(var index = 0; index < savedTeamMembers.length; index++) {
        var item = savedTeamMembers[index];
        if (item.deleted) continue;
        var oldNicknameValue = item.nickname;
        var oldAcceptEmailValue = false;
        if (item.acceptEmail==1){
            oldAcceptEmailValue = true;
        }
        var newNicknameValue = document.getElementById("teammember_nickname_" + item.id).value;
        var newAcceptEmailValue = document.getElementById("teammember_acceptmail_" + item.id).checked;
        var changed = false;
        if (oldNicknameValue!=newNicknameValue){
            changed = true;
        }
        if (oldAcceptEmailValue!=newAcceptEmailValue){
            changed = true;
        }
        
        if (changed){
            var listObject = new Object;
            listObject.id = item.id;
            listObject.nickname = newNicknameValue;
            listObject.acceptEmail = newAcceptEmailValue;
            JSONObject.changedLists[changedIndex] = listObject; 
            changedIndex++;
        }
    }
    

    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        reloadTeamUsersData();
        document.getElementById("editTeammembers").style.display = "none";
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1740T-->Fout<!--T1740T-->", resultJSON.errorMsg);
        loadTeammembers();
    }, false);        
}


function loadEditButtons(){
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
    // place edit button
    var x = GetTopLeft(document.getElementById('modifyButton3a')).Left;
    var y = GetTopLeft(document.getElementById('modifyButton3a')).Top;
    document.getElementById('modifyButton3b').style.position="absolute";
    document.getElementById('modifyButton3b').style.display = ""; 
    document.getElementById('modifyButton3b').style.left = 0; 
    document.getElementById('modifyButton3b').style.top = 0; 
    var xRef = GetTopLeft(document.getElementById('modifyButton3b')).Left;
    var yRef = GetTopLeft(document.getElementById('modifyButton3b')).Top;
    document.getElementById('modifyButton3b').style.left = x-25-xRef; 
    document.getElementById('modifyButton3b').style.top = y-10-yRef;    
    
}


    

