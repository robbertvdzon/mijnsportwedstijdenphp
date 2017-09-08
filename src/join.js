function verder() {
    var invitationID = document.getElementById('uitnodigingscode').value;
    window.location="join.php?id="+invitationID;
}


function acceptExisting(invitationID) {
	var username = document.getElementById('existingUsername').value;
	var password = document.getElementById('existingPassword').value;
	var nickname = document.getElementById('existingNickname').value;

	var JSONObject = new Object;
	JSONObject.request = "joinExisting";
	JSONObject.username = username;
	JSONObject.password = password;
	JSONObject.nickname = nickname;
	JSONObject.invitationID = invitationID;
	ts_runAjax(JSONObject, function onSucces(resultJSON) {
		ts_showGlobalSuccess(/*T1368T*/"Uitnodiging"/*T1368T*/, /*T1369T*/"Uitnodiging is geaccepteerd"/*T1369T*/, function() {
            window.location=/*T1370T*/"http://www.mijnsportwedstrijden.nl/"/*T1370T*/;
        });
	}, function onError(resultJSON) {
		ts_showGlobalError(/*T1371T*/"Error bij uitnodiging"/*T1371T*/, resultJSON.errorMsg, function() {
            window.location=/*T1372T*/"http://www.mijnsportwedstrijden.nl/"/*T1372T*/;
        });
	}, false);
}

function acceptNew(invitationID) {
	var username = document.getElementById('newUsername').value;
	var password = document.getElementById('newPassword').value;
	var name = document.getElementById('newName').value;
	var email = document.getElementById('newEmail').value;
	var nickname = document.getElementById('newNickname').value;

	var JSONObject = new Object;
	JSONObject.request = "joinNew";
	JSONObject.username = username;
	JSONObject.password = password;
	JSONObject.nickname = nickname;
	JSONObject.name = name;
	JSONObject.email = email;
	JSONObject.invitationID = invitationID;
	ts_runAjax(JSONObject, function onSucces(resultJSON) {
		ts_showGlobalSuccess(/*T1373T*/"Uitnodiging"/*T1373T*/, /*T1374T*/"Uitnodiging is geaccepteerd"/*T1374T*/, function() {
            window.location=/*T1375T*/"http://www.mijnsportwedstrijden.nl/"/*T1375T*/;
        });
	}, function onError(resultJSON) {
		ts_showGlobalError(/*T1376T*/"Error bij uitnodiging"/*T1376T*/, resultJSON.errorMsg, function() {
            window.location=/*T1377T*/"http://www.mijnsportwedstrijden.nl/"/*T1377T*/;
        });
	}, false);
}

function rejectInvitation(invitationID) {

	var JSONObject = new Object;
	JSONObject.request = "joinReject";
	JSONObject.invitationID = invitationID;
	ts_runAjax(JSONObject, function onSucces(resultJSON) {
		ts_showGlobalSuccess(/*T1378T*/"Uitnodiging"/*T1378T*/, /*T1379T*/"Uitnodiging is verwijderd"/*T1379T*/, function() {
            window.location=/*T1380T*/"http://www.mijnsportwedstrijden.nl/"/*T1380T*/;
        });
	}, function onError(resultJSON) {
		ts_showGlobalError(/*T1381T*/"Error bij uitnodiging"/*T1381T*/, resultJSON.errorMsg, function() {
            window.location=/*T1382T*/"http://www.mijnsportwedstrijden.nl/"/*T1382T*/;
        });
	}, false);
}