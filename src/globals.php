<?
namespace globals;

include_once ("Logging.php");


$loggedIn = false;
$loginError = "";
$hasLoginError = false;
$currentTeamID = -1;
$log = null;
$anonymousLogin = false;
$competitionManager = false;

function debug($message){
    global $log;
    if ($log==null){
        $log = new \Logging();
    }
    $log->lwrite($message);
}

function isCompetitionManager() {
    global $competitionManager;
    return $competitionManager;
}

function setCompetitionManager($val) {
    global $competitionManager;
    $competitionManager = $val;
}



function isAnonymousLogin() {
    global $anonymousLogin;
    return $anonymousLogin;
}

function setAnonymousLogin($val) {
    global $anonymousLogin;
    $anonymousLogin = $val;
}

 
function isLoggedIn() {
    global $loggedIn;
    return $loggedIn;
}

function setLoggedIn($val) {
    global $loggedIn;
    $loggedIn = $val;
}

function setLoginError($val) {
    global $loginError;
    global $hasLoginError;
    $loginError = $val;
    $hasLoginError = true;
}

function getLoginError() {
    global $loginError;
    return $loginError;
}

function hasLoginError() {
    global $hasLoginError;
    if (!isset($hasLoginError))
        return false;
    return $hasLoginError;
}
function setCurrentTeamID($id){
    global $currentTeamID;
    $currentTeamID = $id;    
}

function getCurrentTeamID(){
    global $currentTeamID;
    return $currentTeamID ;    
}


?>