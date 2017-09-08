<?

/* Include Files *********************/
session_start();
include_once ("database.php");
include_once ("globals.php");
include_once ("dbcalls.php");
include_once ("tablestruct.php");
include_once ("request-invite.php");
include_once ("request-join.php");
include_once ("request-session.php");
include_once ("request-teamers.php");
include_once ("request-demodata.php");
include_once ("request-cron.php");
include_once ("platform/platformsettings.php");

/*************************************/

try {

    //sleep(1);


    if (empty($_REQUEST["u"])) {
        throw new Exception("ERROR, geen username");
    }

    if (empty($_REQUEST["p"])) {
        throw new Exception("ERROR, geen password");
    }
    
    if (empty($_REQUEST["request"])) {
        //throw new Exception("ERROR, geen request");
    }

    $username = $_REQUEST["u"];
    $passwd = $_REQUEST["p"];
    $request = $_REQUEST["request"];
    $userID = dbcalls\checkUser($username,$passwd);

    if ($userID==-1){
        $returnObject -> hasError = true;
        $returnObject -> errorMsg = /*T1005T*/"Ongeldige login"/*T1005T*/;
        $returnObject -> result = false;
        echo json_encode($returnObject);
        return;
    }


    $result = "";

    $functionFound = false;

    if ($request == "checkLogin") {
        $result = checkUser($userID);
        $functionFound = true;
    }
    if ($request == "getTeams") {
        $result = getTeams($userID);
        $functionFound = true;
    }
    if ($request == "getUpcomingGames") {
        $result = getUpcomingGames($userID);
        $functionFound = true;
    }
    if ($request == "getPreviousGames") {
        $result = getPreviousGames($userID);
        $functionFound = true;
    }
    if ($request == "updateGame") {
        $result = updateGame($userID);
        $functionFound = true;
    }
    
  
    


    if (!$functionFound) {
        throw new Exception("Functie $request bestaat niet");
    }

    $returnObject -> hasError = false;
    $returnObject -> errorMsg = null;
    $returnObject -> result = $result;
    echo json_encode($returnObject);



    die();

} catch (Exception $e) {
    $returnObject -> hasError = true;
    $returnObject -> errorMsg = $e -> getMessage();
    $returnObject -> result = null;
    echo json_encode($returnObject);
    die();
}

/*************************************/
/***         FUNCTIONS     ***********/
/*************************************/

function checkUser($userID) {
    return true;
}

function getTeams($userID) {
    return dbcalls\loadTeams($userID);
}

function getUpcomingGames($userID) {
    if (empty($_REQUEST["filter"])) {
        throw new Exception("ERROR, geen filter");
    }
    if (empty($_REQUEST["numDays"])) {
        throw new Exception("ERROR, geen numDays");
    }
    $filter = $_REQUEST["filter"];
    $numDays = $_REQUEST["numDays"];
    return dbcalls\getUpcomingGames($userID, $filter, $numDays);
}

function getPreviousGames($userID) {
    if (empty($_REQUEST["filter"])) {
        throw new Exception("ERROR, geen filter");
    }
    if (empty($_REQUEST["numDays"])) {
        throw new Exception("ERROR, geen numDays");
    }
    $filter = $_REQUEST["filter"];
    $numDays = $_REQUEST["numDays"];
    return dbcalls\getPreviousGames($userID, $filter, $numDays);
}

function updateGame($userID) {
    if (empty($_REQUEST["gameid"])) {
        throw new Exception("ERROR, geen gameid");
    }
    if (empty($_REQUEST["type"])) {
        throw new Exception("ERROR, geen type");
    }
    if (empty($_REQUEST["teamid"])) {
        throw new Exception("ERROR, geen teamid");
    }
    if (empty($_REQUEST["message"])) {
        throw new Exception("ERROR, geen messsage");
    }
    $teamid = $_REQUEST["teamid"];
    $gameid = $_REQUEST["gameid"];
    $type = $_REQUEST["type"];
    $message = $_REQUEST["message"];
    return dbcalls\updateGame($userID, $type, $gameid,$teamid,$message);
}


?>