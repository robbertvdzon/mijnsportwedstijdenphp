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



    $result = "";
    $functionFound = false;
    $request = $_REQUEST["request"];
    
    if ($request == "ping") {
        $result = ping();
        $functionFound = true;
    }
    if ($request == "getStructure") {
        $result = getStructure();
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

function ping() {
    return true;
}

function getStructure() {
    global $conn;

    $jukebox = new \stdClass();
    $jukebox -> drives = array();
    $jukebox -> bays = array();

    $i = 0;
    while ($i < 5) {
        $drive = new \stdClass();
        $drive -> id = $i;
        $drive -> name = "drive".$i;
        $jukebox -> drives[] = $drive;
        $i++;
    }
    
    $i = 0;
    while ($i < 5) {
        $bay = new \stdClass();
        $bay -> id = $i;
        $bay -> name = "bay".$i;
        $jukebox -> bays[] = $bay;
        $i++;
    }
    
    return $jukebox;
}

?>