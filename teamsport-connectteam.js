
function openConnectTeam() {
    
    var body = ''; 
    if (userLoggedIn){
        
        
        body = 
        ''+
        /*T1580T*/  
        'Wilt u dit koppelen aan een welke bestaand team?<br><br>';
        /*T1580T*/
        var $teams = eval('(' + initalTeams + ')');
        
        // find the name of the anonymous team
        var anonymousTeamName = "";
        for(var index = 0; index < $teams.length; index++) {
            var item = $teams[index];
            if (item.id == initialSelectedTeamID){
                anonymousTeamName = item.teamname;
            }
        }
        
        
        var teamWithSameNameFound = false;
        for(var index = 0; index < $teams.length; index++) {
            var item = $teams[index];
            if (item.id != initialSelectedTeamID){
                teamname = item.teamname;
                var selected = "";
                if (anonymousTeamName==teamname){
                    selected = " checked ";
                    teamWithSameNameFound = true;
                }
                body +=  '<input type="radio" id="selectTeam_'+item.id+'" name="connectTeamRadio" '+selected+'><!--T1581T-->Ja, aan mijn bestaande team "'+teamname+'"<!--T1581T--><br><br>';  
            }
        }

        for(var index = 0; index < $teams.length; index++) {
            var item = $teams[index];
            if (item.id == initialSelectedTeamID){
                teamname = item.teamname;
                var selected = "";
                if (!teamWithSameNameFound){
                    selected = " checked ";
                }
                body +=  '<input type="radio" id="selectTeam_'+item.id+'" name="connectTeamRadio" '+selected+'><!--T1582T-->Nee, ik heb nog geen team en wil team "'+teamname+'" gebruiken<!--T1582T--><br><br>';  
            }
        }

        body += '<br><a href="#" onclick="javascript:connectTeamStep2();"><!--T1583T-->Doorgaan<!--T1583T--></a>';
        
            
        
        
    }
    else{
        body = 
        '<input type="radio" id="notLoggedInHaveAccount" name="connectTeamRadio" ><!--T1584T-->Ik ben al gebruiker van mijnsportwedstrijden.nl maar ben nu niet ingelogd<!--T1584T--><br>'+  
        '<input type="radio" id="notLoggedInNewAccount" name="connectTeamRadio" checked><!--T1585T-->Ik ben nog geen gebruiker van mijnsportwedstrijden.nl<!--T1585T--><br>'+  
        '<br>'+  
        '<a href="#" onclick="javascript:connectTeamStep2();"><!--T1586T-->Doorgaan<!--T1586T--></a>';
    }
    
    document.getElementById('connectTeamBody').innerHTML = body;
    document.getElementById('connectTeam').style.display = '';
}

function connectTeamStep2() {
    try{
        var el = document.getElementById('notLoggedInHaveAccount');
        if (el!=null){
            if (el.checked) connectTeamStep3("notLoggedInHaveAccount",0);
        }
    }
    catch(Exception){
    }
    
    try{
        var el = document.getElementById('notLoggedInNewAccount');
        if (el!=null){
            if (el.checked) connectTeamStep3("notLoggedInNewAccount",0);
        }
    }
    catch(Exception){
    }
    

    var $teams = eval('(' + initalTeams + ')');
    for(var index = 0; index < $teams.length; index++) {
        var item = $teams[index];
        var idStr = "selectTeam_"+item.id;
        el = document.getElementById(idStr);
        if (el!=null){
            if (el.checked){
                if (item.id != initialSelectedTeamID){
                    connectTeamStep3("connectTo",item.id );
                }
                else{
                    connectTeamStep3("createAndConnectTo",item.id );
                }
            }
        }
    }

}


function connectTeamStep3(action,arg2) {
    var body = ''; 

    if (action=="notLoggedInHaveAccount"){
        body = 
        ''+  
        '<!--T1587T-->Log eerst in en kom dan terug op deze pagina<br>'+  
        'Daarna kunt u dit team koppelen<!--T1587T--><br><br>'+  
        '<a href="#" onclick="javascript:connectTeamClose();"><!--T1588T-->Doorgaan<!--T1588T--></a>';
    }

    if (action=="connectTo"){
        body = 
        ''+  
        '<!--T1589T-->Druk op doorgaan om de actie door te voeren<!--T1589T--><br><br>'+  
        '<a href="#" onclick="javascript:connectTeam('+arg2+');"><!--T1590T-->Doorgaan<!--T1590T--></a>';
    }

    if (action=="createAndConnectTo"){
        body = 
        ''+  
        '<!--T1591T-->Druk op doorgaan om de actie door te voeren<!--T1591T--><br><br>'+  
        '<a href="#" onclick="javascript:createTeamAndConnect();"><!--T1592T-->Doorgaan<!--T1592T--></a>';
    }

    if (action=="notLoggedInNewAccount"){
        body = 
        ''+
        '<b><!--T1593T-->Maak hier een account aan..<!--T1593T--></b><br><br>'+
        '<table align="left" border="0" cellspacing="0" cellpadding="3">'+
        '<tr height=30><td><!--T1594T-->Gebruikersnaam<!--T1594T--></td><td width=20 align=center>:</td><td><input type="text" name="user" id="connectTeamNewUsername" maxlength="100" autocomplete="off"></td></tr>'+
        '<tr height=30><td><!--T1595T-->Wachtwoord<!--T1595T--></td><td width=20 align=center>:</td><td><input type="password" name="pass" id="connectTeamNewPassword" maxlength="100" autocomplete="off"></td></tr>'+
        '<tr height=30><td><!--T1596T-->Email<!--T1596T--></td><td width=20 align=center>:</td><td><input type="text" name="email" maxlength="100" id="connectTeamNewEmail" autocomplete="off"></td></tr>'+
        '<tr height=30><td><!--T1597T-->Naam<!--T1597T--></td><td width=20 align=center>:</td><td><input type="text" name="name" maxlength="100" id="connectTeamNewName" autocomplete="off"></td></tr>'+
        '<tr height=30>'+
        '    <td colspan=99>'+
        '        <br>'+            
        '        <img border="0" id="captcha" src="captcha/image.php" alt="" >'+
        '        <br>'+
        '        <!--T1598T-->Ter preventie van spam, noteer bovenstaande code in het onderstaand veld<!--T1598T-->'+
        '    </td>'+
        '</tr>'+
        '<tr height=30><td><!--T1599T-->Beveiligingscode<!--T1599T--></td>'+
        '    <td align=center>&nbsp;&nbsp;:&nbsp;&nbsp;</td>'+
        '    <td align=top> <input type="text" id="testveld" value="">'+
        '    </td></tr>'+
        '<tr ><td colspan=99><br><a href="#" onclick="javascript:connectTeamCreateAccount();"><!--T1600T-->Doorgaan<!--T1600T--></a><br><br></td></tr>'+
        '</table>';
    }

    document.getElementById('connectTeamBody').innerHTML = body;
}



function createTeamAndConnect() {
    /*
     * Create JSON object with all modified fields
     */
    var JSONObject = new Object;
    JSONObject.requestConnectTeam = initialSelectedTeamID;
    JSONObject.request = "createTeamAndConnect";
    ts_runAjax(JSONObject, function(resultJSON) {
        // gelukt        
        globalSucceeded();
    }, function(resultJSON) {
        // niet gelukt
        globalFailed(resultJSON.errorMsg);
    }, false);
}

function connectTeam(teamID) {
    /*
     * Create JSON object with all modified fields
     */
    var JSONObject = new Object;
    JSONObject.requestConnectTeam = initialSelectedTeamID;
    JSONObject.teamID = teamID;
    JSONObject.request = "connectTeam";
    ts_runAjax(JSONObject, function(resultJSON) {
        // gelukt        
        globalSucceeded();
    }, function(resultJSON) {
        // niet gelukt
        globalFailed(resultJSON.errorMsg);
    }, false);
}


function connectTeamCreateAccount() {
    var username = document.getElementById('connectTeamNewUsername').value;
    var password = document.getElementById('connectTeamNewPassword').value;
    var email = document.getElementById('connectTeamNewEmail').value;
    var name = document.getElementById('connectTeamNewName').value;
    var testveld = document.getElementById('testveld').value;
    /*
     * Create JSON object with all modified fields
     */
    var JSONObject = new Object;
    JSONObject.username = username;
    JSONObject.password = password;
    JSONObject.email = email;
    JSONObject.name = name;
    JSONObject.testveld = testveld;
    JSONObject.requestConnectTeam = initialSelectedTeamID;
    JSONObject.request = "createUser";
    ts_runAjax(JSONObject, function(resultJSON) {
        // gelukt        
        connectTeamCreateAccountSucceeded();
    }, function(resultJSON) {
        // niet gelukt
        connectTeamCreateAccountFailed(resultJSON.errorMsg);
    }, false);
}

function connectTeamCreateAccountSucceeded() {
    body = 
    ''+  
    '<!--T1601T-->Een account is aangemaakt, <!--T1601T--><br>'+  
    '<!--T1602T-->Het is nu mogelijk om met de opgegevens gebruikersnaam en wachtwoord in te loggen<!--T1602T--><br><br>'+  
    '<a href="#" onclick="javascript:ts_changeSection(\'login\');">Inloggen</a>';
    
    
    document.getElementById('connectTeamBody').innerHTML = body;
}

function connectTeamCreateAccountFailed(errorMsg) {
    body = 
    ''+  
    '<b><!--T1603T-->Foutmelding!<!--T1603T--></b><br><br>'+  
    errorMsg+
    '<br><br>'+  
    '<a href="#" onclick="javascript:connectTeamStep3(\'notLoggedInNewAccount\',0);"><!--T1604T-->Probeer nog een keer<!--T1604T--></a><br><br>';
    document.getElementById('connectTeamBody').innerHTML = body;
}

function globalSucceeded() {
    body = 
    ''+  
    '<!--T1605T-->De actie is voltooid<!--T1605T--><br><br>'+  
    '<a href="#" onclick="javascript:connectTeamClose();">Sluiten</a>';
    document.getElementById('connectTeamBody').innerHTML = body;
}

function globalFailed(errorMsg) {
    body = 
    ''+  
    '<b><!--T1606T-->Foutmelding!<!--T1606T--></b><br><br>'+  
    errorMsg+
    '<br><br>'+  
    '<a href="#" onclick="javascript:connectTeamClose();"><!--T1607T-->Sluiten<!--T1607T--></a>';
    document.getElementById('connectTeamBody').innerHTML = body;
}


function connectTeamClose() {
    document.getElementById('connectTeam').style.display = 'none';
}


