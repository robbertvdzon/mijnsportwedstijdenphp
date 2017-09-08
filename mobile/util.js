

function setCookie(c_name,value,exdays)
{
    var exdate=new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
    document.cookie=c_name + "=" + c_value;
}

function getCookie(c_name)
{
    var i,x,y,ARRcookies=document.cookie.split(";");
    for (i=0;i<ARRcookies.length;i++)
    {
      x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
      y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
      x=x.replace(/^\s+|\s+$/g,"");
      if (x==c_name)
        {
        return unescape(y);
        }
      }
}

function gameDateInPast(gameData){
    var timeArray = extractTime(gameData);
    var today = new Date();
    var todayYear = ""+today.getFullYear();
    var todayMonth = (today.getMonth()+1);
    var todayDay = today.getDate();
    if (todayDay<10){
         todayDay="0"+todayDay;
     }
     else{
         todayDay=""+todayDay;
     }
    if (todayMonth<10){
         todayMonth="0"+todayMonth;
     }
     else{
         todayMonth=""+todayMonth;
     }
    var todayStrAlpha = todayYear+todayMonth+todayDay;
    var gamedateStrAplha = timeArray.year+timeArray.month+timeArray.day;
    return (todayStrAlpha>gamedateStrAplha);
    
}

/*************************************************
 *
 **************************************************/
function runAjax(JSONObject, functionSuccess, functionError, showURLAsDebug) {
    for(var propertyName in JSONObject) {
       JSONObject[propertyName] = encodeUTF(JSONObject[propertyName]) 
    }
    
    
    var JSONstring = escape(JSON.stringify(JSONObject));
    var urlbase = getURLBase();
    var url = urlbase+"/requests.php/requests.php";
    //var url = "http://www.mijnsportwedstrijden.nl/requests.php";
    var httpRequest = getHTTPRequest();
    httpRequest.open("POST", url, true);
    
    var params = "json=" + JSONstring;
    httpRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   // httpRequest.setRequestHeader("Content-length", params.length);
    httpRequest.setRequestHeader("Connection", "close");    
    
//        alert(url+"?json=" + JSONstring);
    if(showURLAsDebug) {
        alert(url+"?json=" + JSONstring);
    }
    
    document.getElementById('refreshButton').src = "ajax-loader.gif";
    

    /*
     * Result callback
     */
    httpRequest.onreadystatechange = function saveSeasonResult() {
        var request = httpRequest;
        if(request.readyState == 4) {
//    alert("t3-"+request.status);
            if(request.status == 0 || request.status == 200) {
                setTimeout(function () { 
                    document.getElementById('refreshButton').src = "refresh.png"; 
                    }, 500);
                
//                document.getElementById('refreshButton').src = "refresh.png";
            // parser.php response
                try {
                    
                    var JSONtext = request.responseText;
                    if (JSONtext=="") throw new Error("Geen verbinding met server");
                    var resultJSON = eval('(' + JSONtext + ')');
                    if(resultJSON.hasError) {
                        if(functionError != null)
                            functionError(resultJSON);
                    } else {
                        if(functionSuccess != null)
                            functionSuccess(resultJSON);
                    }
                } catch(err) {
                    showGlobalError(err);
//                    showGlobalError("Interne fout(1)"+ err + "<br><br>Requested call:<br><a target=_blank class=noneBlack href=" + url + "?json=" + JSONstring+ ">" + url + "?json="+JSONstring+"</a>");
                    throw err;
                }
            }
        }
    }
    httpRequest.send(params);
}


function showGlobalError(err){
    if (err.message=="NOPROERROR"){
        showNoProError();
        return;
    }
    document.getElementById('errorText').innerHTML = err.message;
    document.getElementById('workArea').style.display = "none";
    document.getElementById('headerTop').style.display = "none";
    document.getElementById('headerTopButtons').style.display = "none";
    document.getElementById('headerIcons').style.display = "none";
    document.getElementById('errorpage').style.display = "";
    
}

function hideGlobalError(){
    document.getElementById('workArea').style.display = "";
    document.getElementById('headerTop').style.display = "";
    document.getElementById('headerTopButtons').style.display = "";
    document.getElementById('errorpage').style.display = "none";
    document.getElementById('headerIcons').style.display = "";
}

function showNoProError (){
    var message = "Helaas, deze functie is alleen beschikbaar voor premium gebruikers. Het is mogelijk om premium gebruiker te worden voor 0,7 euro per 3 maanden of voor 1,99 euro per jaar. Neem hiervoor contact op met <a href=mailto:registratie@mijnsportwedstrijden.nl>registratie@mijnsportwedstrijden.nl</a>";
    if (getPlatform()=="Android"){
        message = "Helaas, deze functie is alleen beschikbaar voor premium gebruikers. Het is mogelijk om premium gebruiker te worden voor 0,7 euro per 3 maanden of voor 1,99 euro per jaar."; 
        message += "<br><br><br><table width=100%><tr><td align=center>  <table><tr><td>";
        message += "<p onclick='openPremium()' class='knop'>Wordt premium lid...</p>"; 
        message += "</td></tr></table> </td></tr></table>";

    }    
    document.getElementById('noProMessage').innerHTML = message;
    


    document.getElementById('workArea').style.display = "none";
    document.getElementById('headerTop').style.display = "none";
    document.getElementById('headerTopButtons').style.display = "none";
    document.getElementById('headerIcons').style.display = "none";
    document.getElementById('noPropage').style.display = "";
    
}

function hideNoProError(){
    document.getElementById('workArea').style.display = "";
    document.getElementById('headerTop').style.display = "";
    document.getElementById('headerTopButtons').style.display = "";
    document.getElementById('noPropage').style.display = "none";
    document.getElementById('headerIcons').style.display = "";
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

function getHTTPRequest() {
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

function extractTime(datetime){
    var datestrSplit=datetime.split(" ");
    var dow = "";
    var date = "";
    var time = "";
    if (datestrSplit.length==3){
        dow = datestrSplit[0];
        date = datestrSplit[1];
        time = datestrSplit[2];
    }
    var day = "";
    var month = "";
    var year = "";
    if (date!=null){
        var datestrSplit2=date.split("-");
        if (datestrSplit2.length==3){
            day = datestrSplit2[0];
            month = datestrSplit2[1];
            year = datestrSplit2[2];
        }
    }
    
    var dowShort = "";
    if (dow.length>2) dowShort = dow.substring(0,2); 
    
    var result=new Array();
    result.dow = dow; 
    result.dowShort = dowShort; 
    result.date = date; 
    result.day = day; 
    result.month = month; 
    result.year = year; 
    result.time = time;
    return result;  
}

function hasPremiumAccount(){
   var appData = getUserData();
   if (appData==null) return false;
   if (appData.proUser=="1"){
        return true;
   }
   
   
   var now = new Date();
   var endDate = new Date(appData.proEndDate);
   var dateStringSplit = appData.proEndDate.split('-');
   endDate.setYear(parseInt(dateStringSplit[0]), 10);
   endDate.setMonth(parseInt(dateStringSplit[1], 10) - 1);
   endDate.setDate(parseInt(dateStringSplit[2], 10));   
   
   return now<endDate;
}

