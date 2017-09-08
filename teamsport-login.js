/***********************************
 *
 **************************************************/
function forgotPassword() {
    
    /*
     * Create JSON object with all modified fields
     */
    var JSONObject = new Object;
    JSONObject.request = "forgotPassword";
    JSONObject.email = document.getElementById('email').value; 
    document.getElementById('forgotpasswd').style.display = 'none';
    ts_runAjax(JSONObject, function onSucces(resultJSON) {
        /*T1071T*/
        ts_showGlobalSuccess("<!--T1608T-->Wachtwoord vergeten<!--T1608T-->", "<!--T1609T-->Een email met de login gegevens is verstuurd<!--T1609T-->", function() {
        /*T1071T*/
        });
        
    }, function onError(resultJSON) {
        ts_showGlobalError("Fout", resultJSON.errorMsg);
    }, false);
}