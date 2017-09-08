var $translations;

/*************************************************
 *
 **************************************************/

function tr_updateIDs() {
    var JSONObject = new Object;
    JSONObject.request = "tr_updateIDs";

    ts_runAjax(JSONObject, function onSuccess(resultJSON) {
        loadUpdateIDs(resultJSON.result);
    }, function onError(resultJSON) {
        ts_showGlobalError("Error:", resultJSON.errorMsg);
    }, false);
}

/*************************************************
 *
 **************************************************/

function tr_listIDs() {
    var JSONObject = new Object;
    JSONObject.request = "tr_listIDs";

    var filenamefilter = document.getElementById('filenamefilter').value;
    var keyfilter = document.getElementById('keyfilter').value;
    var orginalfilter = document.getElementById('orginalfilter').value;
    var translatedfilter = document.getElementById('translatedfilter').value;
    var empty = document.getElementById('empty').checked;
    var notempty = document.getElementById('notempty').checked;
    
    var where = "1=1";
    //translatekeys,translation
    
    if (filenamefilter!=""){
        where += " and ";
        where += "translatekeys.filename like '%"+filenamefilter+"%'";
    }
    if (keyfilter!=""){
        where += " and ";
        where += "translatekeys.keyNr = '"+keyfilter+"'";
    }
    if (orginalfilter!=""){
        where += " and ";
        where += "tr.keyCode like '%"+orginalfilter+"%'";
    }
    if (translatedfilter!=""){
        where += " and ";
        where += "tr.translatedText like '%"+translatedfilter+"%'";
    }
    if (empty!=""){
        where += " and ";
        where += "tr.translatedText =  ''";
    }
    if (notempty!=""){
        where += " and ";
        where += "tr.translatedText !=  ''";
    }

    JSONObject.where = where;

    ts_runAjax(JSONObject, function onSuccess(resultJSON) {
        loadList(resultJSON.result);
    }, function onError(resultJSON) {
        ts_showGlobalError("Error:", resultJSON.errorMsg);
    }, false);
}

/*************************************************
 *
 **************************************************/

function tr_translate() {
    var JSONObject = new Object;
    JSONObject.request = "tr_translate";

    ts_runAjax(JSONObject, function onSuccess(resultJSON) {
        translated(resultJSON.result);
    }, function onError(resultJSON) {
        ts_showGlobalError("Error:", resultJSON.errorMsg);
    }, false);
}


/*************************************************
 *
 **************************************************/

function tr_debug_translate() {
    var JSONObject = new Object;
    JSONObject.request = "tr_debug_translate";

    ts_runAjax(JSONObject, function onSuccess(resultJSON) {
        translated(resultJSON.result);
    }, function onError(resultJSON) {
        ts_showGlobalError("Error:", resultJSON.errorMsg);
    }, false);
}


/*************************************************
 *
 **************************************************/
function loadUpdateIDs($list) {

    var resultText = "<table width=100% id=dualcolortable1 cellspacing='0'>";
    resultText += "<tr height=25>";
    resultText += "<td ><b>File</b></td>";
    resultText += "<td width=10></td>";
    resultText += "<td></td></tr>";

    for(var index = 0; index < $list.length; index++) {
        var item = $list[index];
        
        resultText += "<tr height=25>";
        resultText += "<td >"+item.filename+"</td>";
        resultText += "<td width=10></td>";
        resultText += "<td></td></tr>";
    }
    resultText += "</table>";
    
    document.getElementById('listIDs').innerHTML = resultText;
}


/*************************************************
 *
 **************************************************/
function showOtherTranslationsResult($changes) {
    $otherTranslations = $changes;
    var resultText = "<table width=100% id=dualcolortable1 cellspacing='0'>";

    for(var index = 0; index < $otherTranslations.length; index++) {
        var color = "#ffffff";
        if (index %2 ==0){
            color = "#aaaaaa";
        }
        else{
            color = "#ffffff";
        }    

        var item = $changes[index];
        
        resultText += "<tr height=25 bgcolor="+color+" >";
        resultText += "<td colspan=3>"+item.ID+"</td>";
        resultText += "</tr>";

        resultText += "<tr height=25 bgcolor="+color+" >";
        resultText += "<td ><textarea id='orig"+item.ID+"' cols=100 rows=5></textarea></td>";
        resultText += "<td ><textarea id='new"+item.ID+"' cols=100 rows=5></textarea></td>";
        resultText += "</tr>";

        resultText += "<tr height=25 bgcolor="+color+" >";
        resultText += "<td colspan=3>&nbsp;</td>";
        resultText += "</tr>";
        
        resultText += "<tr height=25 bgcolor="+color+" >";
        resultText += "<td colspan=3>&nbsp;</td>";
        resultText += "</tr>";
        
    }
    resultText += "</table>";

    document.getElementById('othertranslations').innerHTML = resultText;

    for(var index = 0; index < $changes.length; index++) {
        var item = $changes[index];
        document.getElementById('orig'+item.ID).value = item.keyCode;
        document.getElementById('new'+item.ID).value = item.translation;
    }
    document.getElementById('othertranslationsScreen').style.display = "";
}
/*************************************************
 *
 **************************************************/

function closeOtherTransactions() {
    document.getElementById('othertranslationsScreen').style.display = "none";
}

/*************************************************
 *
 **************************************************/
function loadList($changes) {
    $translations = $changes;
    var resultText = "<table width=100% id=dualcolortable1 cellspacing='0'>";

    for(var index = 0; index < $changes.length; index++) {
        var color = "#ffffff";
        if (index %2 ==0){
            color = "#aaaaaa";
        }
        else{
            color = "#ffffff";
        }    

        var item = $changes[index];
        
        resultText += "<tr height=25 bgcolor="+color+" >";
        resultText += "<td colspan=3>"+item.filename+" ("+item.keyNr+")</td>";
        resultText += "</tr>";

        resultText += "<tr height=25 bgcolor="+color+" >";
        resultText += "<td ><textarea id='key"+item.ID+"' cols=100 rows=5></textarea></td>";
        resultText += "<td ><textarea id='newkey"+item.ID+"' cols=100 rows=5></textarea></td>";
        resultText += "</tr>";

        resultText += "<tr height=25 bgcolor="+color+" >";
        resultText += "<td colspan=3>&nbsp;</td>";
        resultText += "</tr>";
        
        resultText += "<tr height=25 bgcolor="+color+" >";
        resultText += "<td colspan=3>";
        resultText += "&nbsp;<a href='#'  onclick=\"saveSingle("+item.ID+");\">save</a>";
        resultText += "&nbsp;&nbsp;&nbsp;&nbsp;<a href='#'  onclick=\"translateFile('"+item.ID+"','"+escape(item.filename)+"');\">translate "+item.filename+"</a>";
        
        if (item.nr_translations>1){
            var otherTranslations = item.nr_translations-1; 
            resultText += "&nbsp;&nbsp;&nbsp;&nbsp;<a href='#'  onclick=\"showOtherTranslations('"+item.keyNr+"');\">view other "+otherTranslations+" translations</a>";
        }
        
        resultText += "</td>";
        resultText += "</tr>";

        resultText += "<tr height=25 bgcolor="+color+" >";
        resultText += "<td colspan=3>&nbsp;</td>";
        resultText += "</tr>";
        
    }
    resultText += "</table>";

    document.getElementById('listIDs').innerHTML = resultText;

    for(var index = 0; index < $changes.length; index++) {
        var item = $changes[index];
        document.getElementById('key'+item.ID).value = item.keyCode;
        document.getElementById('newkey'+item.ID).value = item.translation;
    }

}

/*************************************************
 *
 **************************************************/
function translated($changes) {
    alert("Finished");
}

/*************************************************
 *
 **************************************************/
function tr_saveChanges() {
    for(var index = 0; index < $translations.length; index++) {
        var item = $translations[index];
        var val = document.getElementById('newkey'+item.ID).value;
        tr_update_translation(item.ID,val);
    }
}

/*************************************************
 *
 **************************************************/
function saveSingle(keyID){
    var val = document.getElementById('newkey'+keyID).value;
    tr_update_translation(keyID,val);
}

/*************************************************
 *
 **************************************************/
function tr_update_translation($keyID, $translation) {
    var JSONObject = new Object;
    JSONObject.request = "tr_update_translation";
    JSONObject.keyID = $keyID;
    JSONObject.translation = $translation;

    ts_runAjax(JSONObject, function onSuccess(resultJSON) {
    }, function onError(resultJSON) {
        ts_showGlobalError("Error:", resultJSON.errorMsg);
    }, false);
}

/*************************************************
 *
 **************************************************/
function showOtherTranslations($keyNr) {
    var JSONObject = new Object;
    
    JSONObject.request = "tr_list_all_translations";
    JSONObject.keyNr = $keyNr;
    
    ts_runAjax(JSONObject, function onSuccess(resultJSON) {
        showOtherTranslationsResult(resultJSON.result);
    }, function onError(resultJSON) {
        ts_showGlobalError("Error:", resultJSON.errorMsg);
    }, false);
}


/*************************************************
 *
 **************************************************/
function translateFile($keyID,$filename) {
    var JSONObject = new Object;
    var $translation = document.getElementById('newkey'+$keyID).value;
    
    JSONObject.request = "tr_translate_file";
    JSONObject.filename = unescape($filename);
    JSONObject.keyID = $keyID;
    JSONObject.translation = $translation;
    
    //JSONObject.filename = "C:\\prive sugarsync\\teamsport\\header.php";
    //alert(unescape($filename));
    ts_runAjax(JSONObject, function onSuccess(resultJSON) {
    }, function onError(resultJSON) {
        ts_showGlobalError("Error:", resultJSON.errorMsg);
    }, false);
}
