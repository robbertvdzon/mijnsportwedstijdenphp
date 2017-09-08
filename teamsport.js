var currentSection = "home";

function cleanArray(actual){
  var newArray = new Array();
  for(var i = 0; i<actual.length; i++){
      if (actual[i]){
        newArray.push(actual[i]);
    }
  }
  return newArray;
}


function ts_openNewTeam() {
    document.getElementById('newTeam').style.display = '';
    document.getElementById('userMenu').style.display = 'none';
}

function ts_openNewCompetition() {
    document.getElementById('newMCompetition').style.display = '';
    document.getElementById('userMenu').style.display = 'none';
}


function ts_createNewTeam() {
    document.getElementById('newTeam').style.display = 'none';
    var teamname = document.getElementById('newTeamName').value;

    /*
     * Create JSON object with all modified fields
     */
    var JSONObject = new Object;
    JSONObject.teamname = teamname;
    JSONObject.request = "createTeam";
    ts_runAjax(JSONObject, function(resultJSON) {
        
        var newSection = currentSection;
        if (newSection=="home"){
            newSection="competitie";
        }
        
        window.location = 'index.php?team=' + resultJSON.result + '&section='+newSection;
    }, function(resultJSON) {
        ts_showGlobalError("Fout bij ophalen van de teams", resultJSON.errorMsg);
    }, false);
}

function ts_createNewMCompetition() {
    document.getElementById('newMCompetition').style.display = 'none';
    var org = document.getElementById('newMCompOrganisation').value;
    var season = document.getElementById('newMCompSeason').value;
    var competition = document.getElementById('newMCompCompetition').value;

    /*
     * Create JSON object with all modified fields
     */
    var JSONObject = new Object;
    JSONObject.org = org;
    JSONObject.season = season;
    JSONObject.competition = competition;
    JSONObject.request = "createMCompetition";
    ts_runAjax(JSONObject, function(resultJSON) {
        
        var newSection = currentSection;
        if (newSection=="home"){
            newSection="mcompetition";
        }
        
        window.location = 'index.php?team=' + resultJSON.result + '&section='+newSection;
    }, function(resultJSON) {
        ts_showGlobalError("Fout bij maken van competitie", resultJSON.errorMsg);
    }, false);
}

function selectTeam($id){
    if(currentSection == "") {
        window.location.href = "index.php?team=" + $id + "&section=wedstrijd";
    } else {
        window.location.href = "index.php?team=" + $id + "&section=" + currentSection;
    }
}

function ts_teamSelectChange() {
    var team = document.getElementById('selectteam').value;
    if(currentSection == "") {
        window.location.href = "index.php?team=" + team + "&section=wedstrijd";
    } else {
        window.location.href = "index.php?team=" + team + "&section=" + currentSection;
    }

}

function ts_setCurrentSection(section) {
    currentSection = section;
}


function ts_changeSection($section,$gameID) {
	var $postfix = "";
	if ($gameID!=null){
		$postfix="&game="+$gameID;
	}
	if (!ts_isset("initialSelectedTeamID")){
        window.location.href = "index.php?team=0&section=" + $section + $postfix;
	}
	else{
        window.location.href = "index.php?team=" + initialSelectedTeamID + "&section=" + $section + $postfix;
    }
}

function ts_isset(variable_name)
{
    try
    {
    if (typeof(eval(variable_name)) != undefined)
        if (eval(variable_name) != null)
            return true;
    } catch(e) { }
    
    return false;
}


function ts_addLeadingZero(value) {
    if(value.length == 1) {
        return "0" + value;
    }
    return value;
}

function ts_getDateDate(dateTime) {
    var day = dateTime.getUTCDate();
    var month = dateTime.getUTCMonth() + 1;
    var year = dateTime.getUTCFullYear();
    var dateDay = ts_addLeadingZero("" + day);
    var dateMonth = ts_addLeadingZero("" + month);
    var dateYear = "" + dateTime.getFullYear();
    return (dateDay + "-" + dateMonth + "-" + dateYear);
}

function ts_getDateTime(dateTime) {
    var hour = dateTime.getUTCHours();
    var minutes = dateTime.getUTCMinutes();
    var timeHour = ts_addLeadingZero("" + hour);
    var timeMinutes = ts_addLeadingZero("" + minutes);
    return (timeHour + ":" + timeMinutes);
}

function ts_getHTTPRequest() {
    var request = false;
    try {
        request = new XMLHttpRequest();
    } catch (trymicrosoft) {
        try {
            request = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (othermicrosoft) {
            try {
                request = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (failed) {
                request = false;
            }
        }
    }

    if(!request) {
        alert("Error initializing XMLHttpRequest!");
    }
    return request;
}


/*************************************************
 *
 **************************************************/
function encodeUTF(string) {
        if (typeof(string)!='string') return string;

        string = string.replace(/\r\n/g,"\n");
        var utftext = "";
 
        for (var n = 0; n < string.length; n++) {
 
            var c = string.charCodeAt(n);
 
            if (c < 128) {
                utftext += String.fromCharCode(c);
            }
            else if((c > 127) && (c < 2048)) {
                utftext += String.fromCharCode((c >> 6) | 192);
                utftext += String.fromCharCode((c & 63) | 128);
            }
            else {
                utftext += String.fromCharCode((c >> 12) | 224);
                utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                utftext += String.fromCharCode((c & 63) | 128);
            }
 
        }
 
        return utftext;
};



/*************************************************
 *
 **************************************************/
function ts_runAjax(JSONObject, functionSuccess, functionError, showURLAsDebug) {
    
    for(var propertyName in JSONObject) {
       JSONObject[propertyName] = encodeUTF(JSONObject[propertyName]); 
    }
    
    var JSONstring = encodeURIComponent(escape(JSON.stringify(JSONObject)));
//    var JSONstring = escape(JSON.stringify(JSONObject));
    var url = "/requests.php";
    var httpRequest = ts_getHTTPRequest();
    httpRequest.open("POST", url, true);
    
    var params = "json=" + JSONstring;
    httpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    httpRequest.setRequestHeader("Content-length", params.length);
    httpRequest.setRequestHeader("Connection", "close");    
    
    if(showURLAsDebug) {
        alert("http://localhost/"+url+"?" + params);
    }

    /*
     * Result callback
     */
    httpRequest.onreadystatechange = function saveSeasonResult() {
        var request = httpRequest;
        if(request.readyState == 4) {
            if(request.status == 200) {
                // parser.php response
                try {
                    var JSONtext = request.responseText;
                    //alert(JSONtext);
                    var resultJSON = eval('(' + JSONtext + ')');
                    if(resultJSON.hasError) {
                        if(functionError != null)
                            functionError(resultJSON);
                    } else {
                        if(functionSuccess != null)
                            functionSuccess(resultJSON);
                    }
                } catch(err) {
                    ts_showGlobalError("Interne fout(1)", err + "<br><br>Requested call:<br><a target=_blank class=noneBlack href=" + url + "?json=" + JSONstring+ ">" + url + "?json="+JSONstring+"</a>");
                    throw err;
                }
            }
        }
    }
    httpRequest.send(params);
    /*
     * Call the backend
     */
//    httpRequest.send(null);
}

function ts_showGlobalError($title, $errorMsg) {
    document.getElementById('globalError').style.display = '';
    document.getElementById('globalErrorTitle').innerHTML = $title;
    document.getElementById('globalErrorMessage').innerHTML = $errorMsg;
}

var ts_successCallbackFunction;

function ts_showGlobalSuccess($title, $message, callback) {
    ts_successCallbackFunction = callback;
    document.getElementById('globalSuccess').style.display = '';
    document.getElementById('globalSuccessTitle').innerHTML = $title;
    document.getElementById('globalSuccessMessage').innerHTML = $message;
}



function ts_generateDemoData() {
    var JSONObject = new Object;
    JSONObject.request = "generateDemodata";

    ts_runAjax(JSONObject, function(resultJSON) {
        ts_showGlobalSuccess("Demodata", "Nieuwe data is gegenereerd", function() {
        });
    }, function(resultJSON) {
        ts_showGlobalError("Fout bij maken van demodata", resultJSON.errorMsg);
    }, false);
}


function ts_removeDemoData() {
    var JSONObject = new Object;
    JSONObject.request = "removeDemodata";

    ts_runAjax(JSONObject, function(resultJSON) {
        ts_showGlobalSuccess("Demodata", "Demo data is verwijderd", function() {
        });
    }, function(resultJSON) {
        ts_showGlobalError("Fout bij verwijderen van demodata", resultJSON.errorMsg);
    }, false);
}


function ts_clearOrphanData() {
    var JSONObject = new Object;
    JSONObject.request = "clearOrphanData";

    ts_runAjax(JSONObject, function(resultJSON) {
        ts_showGlobalSuccess("Demodata", "Orphan data is verwijderd", function() {
        });
    }, function(resultJSON) {
        ts_showGlobalError("Fout bij verwijderen orphan data", resultJSON.errorMsg);
    }, false);
}


function ts_callCron() {
    var JSONObject = new Object;
    JSONObject.request = "callCron";

    ts_runAjax(JSONObject, function(resultJSON) {
        ts_showGlobalSuccess("Demodata", "Cron is aangeroepen", function() {
        });
    }, function(resultJSON) {
        ts_showGlobalError("Fout bij aanroepen van cron job", resultJSON.errorMsg);
    }, false);
}


function ts_getAllSchemaChanges() {
    var JSONObject = new Object;
    JSONObject.request = "getSQLSchemaChanges";
    ts_runAjax(JSONObject, function(resultJSON) {
        var changes = resultJSON.result.changes;
        var allChanges = "";
        for(var index = 0; index < changes.length; index++) {
            var change = changes[index];
            allChanges+=change+"<br><br>";
        }
        if (allChanges=="") allChanges = "Database structure needs no change";
        document.getElementById('sqlschemaChanges').innerHTML = allChanges;
    }, function(resultJSON) {
        ts_showGlobalError("Fout bij aanroepen van cron job", resultJSON.errorMsg);
    }, false);
}

function ts_performAllSchemaChanges() {
    var JSONObject = new Object;
    JSONObject.request = "performSQLSchemaChanges";
    document.getElementById('sqlschemaChangesFinished').innerHTML = "busy";
    ts_runAjax(JSONObject, function(resultJSON) {
        document.getElementById('sqlschemaChangesFinished').innerHTML = "finished";
    }, function(resultJSON) {
        ts_showGlobalError("Fout bij aanroepen van cron job", resultJSON.errorMsg);
    }, false);
}




function ts_setCookie(c_name, value, expiredays) {
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + expiredays);
    document.cookie = c_name + "=" + escape(value) + ((expiredays == null) ? "" : "; expires=" + exdate.toGMTString()) + "; path=/";
}

function ts_getCookie(c_name) {
    if(document.cookie.length > 0) {
        c_start = document.cookie.indexOf(c_name + "=");
        if(c_start != -1) {
            c_start = c_start + c_name.length + 1;
            c_end = document.cookie.indexOf(";", c_start);
            if(c_end == -1)
                c_end = document.cookie.length;
            return unescape(document.cookie.substring(c_start, c_end));
        }
    }
    return false;
}


function ts_loadTeamsDropdown($teams) {
    var teamname = "";
    for(var index = 0; index < $teams.length; index++) {
        var item = $teams[index];
        if (item.id == initialSelectedTeamID){
            teamname = item.teamname;
        }
    }
    if (document.getElementById('headerteamname')!=null){
        document.getElementById('headerteamname').innerHTML=teamname;
    }
    
}   


function ts_loadTeamsDropdownOld($teams) {
    var select = document.getElementById('selectteam');
    var teamname = "";
    if(select==null) return;

    if($teams.length == 0) {
        // no team found
        var theOption = new Option;
        theOption.text = /*T1457T*/"Geen team"/*T1457T*/;
        theOption.value = -1;
        select.options[0] = theOption;
    }

    for(var index = 0; index < $teams.length; index++) {
        var item = $teams[index];
        var theOption = new Option;
        theOption.text = item.teamname;
        theOption.value = item.id;
        theOption.selected = item.id == initialSelectedTeamID;
        select.options[index] = theOption;
        if (item.id == initialSelectedTeamID){
            teamname = item.teamname;
        }
    }
    
   document.getElementById('headerteamname').innerHTML=teamname;
    
}   


function ts_loadTeamsUsermenu($teams) {
    var resultText = "";
    resultText+="<table width=100%>";
    if ($teams.length>1){
       resultText+="<tr><td>&nbsp;&nbsp;&nbsp;</td><td class='usersMenuItem'>";
       resultText+="<!--T1458T-->Kies je actieve team:<!--T1458T-->";
       resultText+="<table width=100%>";
        
        for(var index = 0; index < $teams.length; index++) {
            var item = $teams[index];
                resultText+="<tr>";
                if (item.id==initialSelectedTeamID){
                    resultText+="<td class='usersMenuItem'><large>&bull;</large></td>";
                }
                else{
                    resultText+="<td></td>";
                }
                resultText+="<td onclick='selectTeam("+item.id+")' class='usersMenuItem'>";
                resultText+="<!--T1459T-->Selecteer team <!--T1459T-->"+item.teamname+"<br>";
                resultText+="</td></tr>";
        }
       resultText+="</table>";
       resultText+="</td></tr>";
        resultText+="<tr><td colspan=99><hr size='3' noshade color='#000'></td></tr>";
        
        
    }
    resultText+="<tr><td>&nbsp;&nbsp;&nbsp;</td><td onclick='javascript:ts_openNewTeam();' class='usersMenuItem'>";
    resultText+="<!--T1460T-->Richt nieuw team op<!--T1460T-->";
    resultText+="</td></tr>";
    resultText+="<tr><td>&nbsp;&nbsp;&nbsp;</td><td onclick='javascript:ts_openNewCompetition();' class='usersMenuItem'>";
    resultText+="<!--T1461T-->Richt te eigen competitie op<!--T1461T-->";
    resultText+="</td></tr>";
    
    // resultText+="<tr><td onclick='ts_changeSection(\"register\");' class='usersMenuItem'>";
    // resultText+="Registreer nieuwe gebruiker";
    // resultText+="</td></tr>";
    // resultText+="<tr><td onclick='javascript:window.location=\"logout.php\";' class='usersMenuItem'>";
    // resultText+="Uitloggen";
    // resultText+="</td></tr>";
    
    
    resultText+="</table>";
    document.getElementById('usersMenu').innerHTML=resultText;
}   



function ts_escapeQuotes (str) {
    // Escapes single quote, double quotes and backslash characters in a string with backslashes  
    return (str + '').replace(/\'/g,'&#39;').replace(/\"/g,'&quot;');
}


function GetTopLeft(elm)
{

    var x, y = 0;
    
    //set x to elm’s offsetLeft
    x = elm.offsetLeft;
    
    //set y to elm’s offsetTop
    y = elm.offsetTop;
    
    //set elm to its offsetParent
    elm = elm.offsetParent;
    
    //use while loop to check if elm is null
    // if not then add current elm’s offsetLeft to x
    //offsetTop to y and set elm to its offsetParent
    
    while(elm != null)
    {
    
    x = parseInt(x) + parseInt(elm.offsetLeft);
    y = parseInt(y) + parseInt(elm.offsetTop);
    elm = elm.offsetParent;
    }
    
    //here is interesting thing
    //it return Object with two properties
    //Top and Left
    
    return {Top:y, Left: x};
}


function searchCompetition() {
    var organisation = document.getElementById('organisation').value;
    var team = document.getElementById('team').value;
    organisation = encodeUTF(organisation); 
    team = encodeUTF(team); 

    window.location.href = "index.php?section=searchCompetition&searchorg="+organisation+"&searchteam="+team;
}
