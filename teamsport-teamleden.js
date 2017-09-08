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
        document.getElementById('tip').style.display = ""; 
    }
    else{
        document.getElementById('modifyButton1b').style.display = "none"; 
        document.getElementById('tip').style.display = "none"; 
    }
    
    if (anonimousLogin){
        document.getElementById('teammembers').style.display = "none"; 
        document.getElementById('textForAnonimousTeam').style.display = ""; 
    }
    else{
        document.getElementById('teammembers').style.display = ""; 
        document.getElementById('textForAnonimousTeam').style.display = "none"; 
    }    
    
    
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

function loadTeammembersData(teammembers, initialCall) {
    savedTeamMembers = teammembers;
    var ownTeammemberID = findCurrentTeamMemberID();
    var resultText = "<table id=dualcolortable cellspacing='0'>";
	resultText += "<tr>";
	resultText += "<td><b><!--T1741T-->Bijnaam<!--T1741T-->:</b></td>";
	resultText += "<td width=20></td>";
    resultText += "<td><b><!--T1742T-->Type<!--T1742T-->:</b></td>";
    resultText += "<td width=20></td>";
    resultText += "<td><b><!--T1743T-->Status<!--T1743T-->:</b></td>";
    resultText += "<td width=20></td>";
    resultText += "<td><b><!--T1744T-->Email<!--T1744T-->:</b></td>";
    resultText += "<td width=20></td>";
    resultText += "<td><b><!--T1745T-->Telefoonnr<!--T1745T-->:</b></td>";
    resultText += "<td width=30></td>";
	resultText += "<td></td>";
	resultText += "</tr>";

    var resultEditText = "<table id=dualcolortable2 cellspacing='0'>";
    resultEditText += "<tr>";
    resultEditText += "<td width=10></td><td><b>Bijnaam:</b></td>";
    resultEditText += "<td width=20></td>";
    resultEditText += "<td><b><!--T1746T-->Beheerder<!--T1746T-->:</b></td>";
    resultEditText += "<td width=20></td>";
    resultEditText += "<td><b><!--T1747T-->Supporter<!--T1747T-->:</b></td>";
    resultEditText += "<td width=20></td>";
    resultEditText += "<td><b><!--T1748T-->Invaller<!--T1748T-->:</b></td>";
    resultEditText += "<td width=20></td>";
    resultEditText += "<td><b><!--T1749T-->Status<!--T1749T-->:</b></td>";
    resultEditText += "<td width=20></td>";
    resultEditText += "<td><b><!--T1750T-->Email<!--T1750T-->:</b></td>";
    resultEditText += "<td width=20></td>";
    resultEditText += "<td><b><!--T1751T-->Telefoonnr<!--T1751T-->:</b></td>";
    resultEditText += "<td width=30></td>";
    resultEditText += "<td></td>";
    resultEditText += "</tr>";

	for(var index = 0; index < teammembers.length; index++) {
		var item = teammembers[index];
        if (item.deleted) continue;
        var admincode = "";
        var soort = "";
		if(item.admin == "1") {
			admincode = "<input type='checkbox' id='admin_" + item.id + "' checked>";
			soort+="admin ";
		} else {
			admincode = "<input type='checkbox' id='admin_" + item.id + "' >";
		}

        var supportercode = "";
        if(item.supporter == "1") {
            supportercode = "<input type='checkbox' id='supporter_" + item.id + "' checked>";
            soort+="supporter ";
        } else {
            supportercode = "<input type='checkbox' id='supporter_" + item.id + "' >";
        }
        
        var invallercode = "";
        if(item.invaller == "1") {
            invallercode = "<input type='checkbox' id='invaller_" + item.id + "' checked>";
            soort+="invaller ";
        } else {
            invallercode = "<input type='checkbox' id='invaller_" + item.id + "' >";
        }
        
        var status = "ok";
        var reInviteUserText = "";
        if(item.userID == null || item.userID == "0") {
            //reInviteUserText = "<a href='#' onclick=\"openReInvitation('"+item.id+"','"+item.nickname+"','')\">Uitnodiging versturen</a>("+item.invitationID+")";
            reInviteUserText = "<img src='images/invite.gif' title='Uitnodiging opnieuw versturen'  onclick=\"openReInvitation('"+item.id+"','"+item.nickname+"','')\";' height=15px style='cursor: pointer;'>&nbsp;&nbsp;";

            
            if(item.invitationID != null && item.invitationID!=0) {
                if(item.invitationID == -1) {
                    status = "<!--T1752T-->Niet uitgenodigd<!--T1752T-->";
                }
                else{
                    status = "<!--T1753T-->Uitgenodigd<!--T1753T-->";
                }
            }
            else{
                status = "<!--T1754T-->Geweigerd<!--T1754T-->";
            }
        }
        

		resultText += "<tr height=25>";
		resultText += "<td>" + item.nickname + "</td>";
		resultText += "<td></td>";
		resultText += "<td align=left> " + soort + "</td>";
        resultText += "<td></td>";
        resultText += "<td align=left> " + status + "</td>";
        resultText += "<td></td>";        
        resultText += "<td align=left> " + item.email + "</td>";
        resultText += "<td></td>";
        resultText += "<td align=left> " + item.phonenumber + "</td>";
        resultText += "<td></td>";
        resultText += "<td>";
        resultText += "</td>";
        resultText += "</tr>";
        
        resultEditText += "<tr height=25>";
        resultEditText += "<td width=10></td><td>" + item.nickname + "</td>";
        resultEditText += "<td></td>";
        resultEditText += "<td align=center> " + admincode + "</td>";
        resultEditText += "<td></td>";
        resultEditText += "<td align=center> " + supportercode + "</td>";
        resultEditText += "<td></td>";
        resultEditText += "<td align=center> " + invallercode + "</td>";
        resultEditText += "<td></td>";
        resultEditText += "<td align=left> " + status + "</td>";
        resultEditText += "<td></td>";
        resultEditText += "<td align=left> " + item.email + "</td>";
        resultEditText += "<td></td>";
        resultEditText += "<td align=left> " + item.phonenumber + "</td>";
        resultEditText += "<td></td>";        
        resultEditText += "<td><img src='images/delete.png' title='<!--T1755T-->Verwijder teamlid<!--T1755T-->' onclick='removeTeammember("+item.id+");' height=15px style='cursor: pointer;'>&nbsp;&nbsp;";
        resultEditText += reInviteUserText;
        resultEditText += "&nbsp;&nbsp;";
        resultEditText += "</td>";
		resultEditText += "</tr>";
	}
	resultText += "</table>";
    resultEditText += "</table>";

    document.getElementById('teammembers').innerHTML = resultText;
    document.getElementById('teammembersEditList').innerHTML = resultEditText;

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
    var table = document.getElementById("dualcolortable2");
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

function openChangeNickname(){
    var teammembers = eval('(' + initialTeammembers + ')');
    var ownTeammemberID = findCurrentTeamMemberID();
    for(var index = 0; index < teammembers.length; index++) {
        var item = teammembers[index];
        if (ownTeammemberID==item.id){
            document.getElementById("newNickname").value = item.nickname;            
        }
    }
    document.getElementById("changeNickname").style.display = "";    
}

function changeNickname(){
    var JSONObject = new Object;
    JSONObject.request = "changeNickname";
    JSONObject.nickName = document.getElementById("newNickname").value;
    JSONObject.memberID = findCurrentTeamMemberID();

    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        loadTeammembers();
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1756T-->Fout<!--T1756T-->", resultJSON.errorMsg);
        loadTeammembers();
    }, false);        
    document.getElementById("changeNickname").style.display = "none";    
}


function saveChanges(){
    var JSONObject = new Object;
    JSONObject.request = "saveTeammembers";
    JSONObject.changedLists = new Array;
    var changedIndex = 0;


    for(var index = 0; index < savedTeamMembers.length; index++) {
        var item = savedTeamMembers[index];
        if (item.deleted) continue;
        var oldAdminValue = false;
        var oldSupporterValue = false;
        var oldInvallerValue = false;
        if(item.admin == "1") {
            oldAdminValue = true;
        }
        if(item.supporter == "1") {
            oldSupporterValue = true;
        }
        if(item.invaller == "1") {
            oldInvallerValue = true;
        }
        var newAdminValue = document.getElementById("admin_" + item.id).checked;
        var newSupporterValue = document.getElementById("supporter_" + item.id).checked;
        var newInvallerValue = document.getElementById("invaller_" + item.id).checked;
        var changed = false;
        if (oldAdminValue!=newAdminValue){
            changed = true;
        }
        if (oldSupporterValue!=newSupporterValue){
            changed = true;
        }
        if (oldInvallerValue!=newInvallerValue){
            changed = true;
        }
        
        if (changed){
            var listObject = new Object;
            listObject.id = item.id;
            listObject.admin = newAdminValue;
            listObject.supporter = newSupporterValue;
            listObject.invaller = newInvallerValue;
            JSONObject.changedLists[changedIndex] = listObject; 
            changedIndex++;
        }
    }
    

    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        document.getElementById("editTeammembers").style.display = "none";
        loadTeammembers();
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1757T-->Fout<!--T1757T-->", resultJSON.errorMsg);
        loadTeammembers();
    }, false);        
}

function reInviteTeammember() {
    /*
     * Create JSON object with all modified fields
     */
    document.getElementById("reInviteUsers").style.display = "none";
    var JSONObject = new Object;
    JSONObject.teammemberID = document.getElementById("reInviteMemberID").value;
    JSONObject.nickname = document.getElementById("reInviteNickname").value;
    JSONObject.email = document.getElementById("reInviteEmail").value;
    JSONObject.request = "reInviteTeammember";
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        loadTeammembers();
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1758T-->Fout bij opnieuw uitnodigen van teammember<!--T1758T-->", resultJSON.errorMsg);
    }, false);
}


function openReInvitation(memberID,nickname,email) {
    document.getElementById("reInviteNickname").value = nickname;
    document.getElementById("reInviteMemberID").value = memberID;
    document.getElementById("reInviteEmail").value = email;
    document.getElementById("reInviteUsers").style.display = "";
}


function openInvitation() {
	document.getElementById('inviteUsers').style.display = '';

    for (var i=1; i<=15; i++){
        var nameStr = "name_"+i;
        var emailStr = "email_"+i;
        document.getElementById(nameStr).value="";
        document.getElementById(emailStr).value="";
    }

}

function sendInvitation() {
	document.getElementById('inviteUsers').style.display = 'none';

	/*
	 * Create JSON object with all modified fields
	 */
	var JSONObject = new Object;
	JSONObject.request = "inviteNewMembers";
    for (var i=1; i<=15; i++){
        var nameStr = "name_"+i;
        var emailStr = "email_"+i;
        
        JSONObject[nameStr] = document.getElementById(nameStr).value;
        JSONObject[emailStr] = document.getElementById(emailStr).value;
    }
	JSONObject.teamID = initialSelectedTeamID;
	JSONObject.inviterUserID = currentUserID;

	ts_runAjax(JSONObject, function onSuccess(resultJSON) {
		var resultValue = "";
		if(resultJSON.result.failed != "") {
			resultValue += "<!--T1759T-->Error bij versturen naar:<!--T1759T-->" + resultJSON.result.failed + "<br>";
            ts_showGlobalSuccess("Uitnodigingen", resultValue, function() {
            });
		}
        loadTeammembers();
	}, function onError(resultJSON) {
		ts_showGlobalError("<!--T1760T-->Fout bij ophalen van de competities<!--T1760T-->", resultJSON.errorMsg);
        loadTeammembers();
	}, false);
}



/*************************************************
 *
 **************************************************/
function removeTeammember(teammemberID) {
    /*
     * Create JSON object with all modified fields
     */
    var JSONObject = new Object;
    JSONObject.teammemberID = teammemberID;
    JSONObject.request = "removeTeammember";
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        loadTeammembers();
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1761T-->Fout bij verwijderen van teammember<!--T1761T-->", resultJSON.errorMsg);
    }, false);
}


/*************************************************
 *
 **************************************************/
function loadTeammembers() {
    var JSONObject = new Object;
    JSONObject.request = "loadTeammembers";
    JSONObject.teamID = initialSelectedTeamID;
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        loadTeammembersData(resultJSON.result, false);
    }, function onError(resultJSON) {
        ts_showGlobalError("<!--T1762T-->Fout bij ophalen van de teammembers<!--T1762T-->", resultJSON.errorMsg);
    }, false);
}


