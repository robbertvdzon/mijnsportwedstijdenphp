<?

/* Include Files *********************/
session_start();
include_once ("database.php");
include_once ("globals.php");
include_once ("dbcalls.php");
include_once ("tablestruct.php");
include_once ("request-translate.php");
include_once ("request-invite.php");
include_once ("request-join.php");
include_once ("request-session.php");
include_once ("request-teamers.php");
include_once ("request-demodata.php");
include_once ("request-payment.php");
include_once ("request-clean.php");
include_once ("request-cron.php");
include_once ("request-register.php");
include_once ("request-connectteam.php");
include_once ("platform/platformsettings.php");

/*************************************/

try {

    //sleep(1);
    if (empty($_REQUEST['json'])) {
        throw new Exception("ERROR, no valid call!");
    }

    $postData = rawurldecode($_REQUEST['json']);


    $parameters = "";
    if (isset($_REQUEST['json'])){
        $parameters = json_decode($postData);
    }

    globals\debug("Request:".$parameters -> request );
    //var_dump($parameters);

    $result = "";

    $functionFound = false;
        //throw new Exception($parameters -> request);

    if ($parameters -> request == "checkUser") {
        $result = checkUser($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "getMobileAppData") {
        $result = getMobileAppData($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "loadMTeamGames") {
        $result = loadMTeamGames($parameters);
        $functionFound = true;
    }

    if ($parameters -> request == "syncMCompetition") {
        $result = syncMCompetition($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "forgotPassword") {
        $result = forgotPassword($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "getSQLSchemaChanges") {
        $result = getSQLSchemaChanges($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "performSQLSchemaChanges") {
        $result = performSQLSchemaChanges($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "loadMCompetition") {
        $result = loadMCompetition($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "createMCompetition") {
        $result = createMCompetition($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "createTeam") {
        $result = createTeam($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "loadTeams") {
        $result = loadTeams($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "saveUser") {
        $result = saveUser($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "loadUser") {
        $result = loadUser($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "loadGames") {
        $result = loadGames($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "loadCompetitionData") {
        $result = loadCompetitionData($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "loadListData") {
        $result = loadListData($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "saveListData") {
        $result = saveListData($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "loadGame") {
        $result = loadGame($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "deleteGame") {
        $result = deleteGame($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "loadTeam") {
        $result = loadTeam($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "saveTeam") {
        $result = saveTeam($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "loadCompetitions") {
        $result = loadCompetitions($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "addCompetition") {
        $result = addCompetition($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "addGame") {
        $result = addGame($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "addGames") {
        $result = addGames($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "saveGame") {
        $result = saveGame($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "addMessage") {
        $result = addMessage($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "emailMessages") {
        $result = emailMessages($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "inviteNewMembers") {
        $result = inviteNewMembers($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "updateCompetition") {
        $result = updateCompetition($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "saveTeammembers") {
        $result = saveTeammembers($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "saveTeammembers2") {
        $result = saveTeammembers2($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "changeNickname") {
        $result = changeNickname($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "removeCompetition") {
        $result = removeCompetition($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "joinExisting") {
        $result = joinExisting($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "joinNew") {
        $result = joinNew($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "joinReject") {
        $result = joinReject($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "loadTeammembers") {
        $result = loadTeammembers($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "loadTeammembersOfUser") {
        $result = loadTeammembersOfUser($parameters);
        $functionFound = true;
    }

    if ($parameters -> request == "removeTeammember") {
        $result = removeTeammember($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "reInviteTeammember") {
        $result = reInviteTeammember($parameters);
        $functionFound = true;
    }

    if ($parameters -> request == "findFirstUpcomingGame") {
        $result = findFirstUpcomingGame($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "importFromTeamers") {
        $result = importFromTeamers($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "generateDemodata") {
        $result = generateDemodata($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "removeDemodata") {
        $result = removeDemodata($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "clearOrphanData") {
        $result = clearOrphanData($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "callCron") {
        $result = callCron($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "removeList") {
        $result = removeList($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "addList") {
        $result = addList($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "updateLists") {
        $result = updateLists($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "setAanwezig") {
        $result = setAanwezig($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "setAfwezig") {
        $result = setAfwezig($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "setOnbekend") {
        $result = setOnbekend($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "changePW") {
        $result = changePW($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "adminListAllTeams") {
        $result = adminListAllTeams($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "adminListAllChanges") {
        $result = adminListAllChanges($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "adminListAllUsers") {
        $result = adminListAllUsers($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "adminListAllTeammembers") {
        $result = adminListAllTeammembers($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "dbSummary") {
        $result = dbSummary($parameters);
        $functionFound = true;
    }

    if ($parameters -> request == "adminRemoveTeam") {
        $result = adminRemoveTeam($parameters);
        $functionFound = true;
    }

    if ($parameters -> request == "adminRemoveUser") {
        $result = adminRemoveUser($parameters);
        $functionFound = true;
    }

    if ($parameters -> request == "adminDisableProUser") {
        $result = adminDisableProUser($parameters);
        $functionFound = true;
    }

    if ($parameters -> request == "adminEnableProUser") {
        $result = adminEnableProUser($parameters);
        $functionFound = true;
    }

    if ($parameters -> request == "createUser") {
        $result = createUser($parameters);
        $functionFound = true;
    }

    if ($parameters -> request == "createTeamAndConnect") {
        $result = createTeamAndConnect($parameters);
        $functionFound = true;
    }

    if ($parameters -> request == "connectTeam") {
        $result = connectTeam($parameters);
        $functionFound = true;
    }

    if ($parameters -> request == "loadMAllCompetitionData") {
        $result = loadMAllCompetitionData($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "loadMCompetitions") {
        $result = loadMCompetitions($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "loadMSeasons") {
        $result = loadMSeasons($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "loadMOrganisations") {
        $result = loadMOrganisations($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "removeMCompetition") {
        $result = removeMCompetition($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "updateMCompetition") {
        $result = updateMCompetition($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "addMCompetition") {
        $result = addMCompetition($parameters);
        $functionFound = true;
    }

    if ($parameters -> request == "removeMSeason") {
        $result = removeMSeason($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "updateMSeason") {
        $result = updateMSeason($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "addMSeason") {
        $result = addMSeason($parameters);
        $functionFound = true;
    }

    if ($parameters -> request == "removeMOrganisation") {
        $result = removeMOrganisation($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "updateMOrganisation") {
        $result = updateMOrganisation($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "addMOrganisation") {
        $result = addMOrganisation($parameters);
        $functionFound = true;
    }

    if ($parameters -> request == "removeMGame") {
        $result = removeMGame($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "updateMGames") {
        $result = updateMGames($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "newMGames") {
        $result = newMGames($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "updateMTeams") {
        $result = updateMTeams($parameters);
        $functionFound = true;
    }
    if ($parameters -> request == "newMTeams") {
        $result = newMTeams($parameters);
        $functionFound = true;
    }

    if ($parameters -> request == "getUpcomingGames") {
        $result = getUpcomingGames($parameters);
        $functionFound = true;
    }

    if ($parameters -> request == "getPreviousGames") {
        $result = getPreviousGames($parameters);
        $functionFound = true;
    }

    if ($parameters -> request == "tr_updateIDs") {
        $result = tr_updateIDs($parameters);
        $functionFound = true;
    }

    if ($parameters -> request == "tr_listIDs") {
        $result = tr_listIDs($parameters);
        $functionFound = true;
    }

    if ($parameters -> request == "tr_list_all_translations") {
        $result = tr_list_all_translations($parameters);
        $functionFound = true;
    }

    if ($parameters -> request == "tr_update_translation") {
        $result = tr_update_translation($parameters);
        $functionFound = true;
    }

    if ($parameters -> request == "tr_translate") {
        $result = tr_translate($parameters);
        $functionFound = true;
    }

    if ($parameters -> request == "tr_debug_translate") {
        $result = tr_debug_translate($parameters);
        $functionFound = true;
    }

    if ($parameters -> request == "tr_translate_file") {
        $result = tr_translate_file($parameters);
        $functionFound = true;
    }

    if ($parameters -> request == "buyedMonth") {
        $result = buyedMonth($parameters);
        $functionFound = true;
    }

    if ($parameters -> request == "buyedYear") {
        $result = buyedYear($parameters);
        $functionFound = true;
    }

    if ($parameters -> request == "logPayment") {
        $result = logPayment($parameters);
        $functionFound = true;
    }



    if (!$functionFound) {
        throw new Exception("Functie $parameters->request bestaat niet");
    }

    $returnObject = new \stdClass();
    $returnObject -> hasError = false;
    $returnObject -> errorMsg = null;
    $returnObject -> result = $result;
    echo json_encode($returnObject);



    die();

} catch (Exception $e) {
    $returnObject = new \stdClass();
    $returnObject -> hasError = true;
    $returnObject -> errorMsg = $e -> getMessage();
    $returnObject -> result = null;
    echo json_encode($returnObject);
    die();
}

/*************************************/
/***         FUNCTIONS     ***********/
/*************************************/

function checkUser($parameters) {
    global $conn;
    if (!isset($parameters -> username)) {
        throw new Exception("ERROR, geen username");
    }
    if (!isset($parameters -> passwd)) {
        throw new Exception("ERROR, geen passwd");
    }
    $username = $parameters -> username;
    $passwd = $parameters -> passwd;
    $userID = dbcalls\getUserID($username);


    // Perform the normal check
    /* Verify that user is in database */
    $username = mysql_real_escape_string($username);
    $q = "select password from users where username = '$username' and activeAccount=1";

    $result = mysql_query($q, $conn);
    if (!$result || (mysql_numrows($result) < 1)) {
        return null;
        //Indicates username failure
    }

    /* Retrieve password from result, strip slashes */
    $dbarray = mysql_fetch_array($result);
    $dbarray['password'] = stripslashes($dbarray['password']);
    $password = stripslashes($passwd);

    /* Validate that password is correct */
    if ($password == $dbarray['password']) {
        // correct user, now get all userdata
        $teams = dbcalls\loadTeams($userID);
        $result = new \stdClass();
        $result->userID = $userID;
        $result->teams = $teams;
        foreach ($result->teams as $team) {
            $team->competitions = dbcalls\loadCompetitions($team->id);
            foreach ($team->competitions as $competition) {
                $competition->mcompetitions = dbcalls\loadManagedCompetitionData($competition->mCompetition);
            }
        }

        return $result;
        //Success! Username and password confirmed
    } else {
        return null;
        //Indicates password failure
    }


}


function getMobileAppData($parameters) {
    global $conn;
    if (!isset($parameters -> username)) {
        throw new Exception("ERROR, geen username");
    }
    if (!isset($parameters -> passwd)) {
        throw new Exception("ERROR, geen passwd");
    }
    if (!isset($parameters -> requestedCompetitionID)) {
        throw new Exception("ERROR, geen requestedCompetitionID");
    }
    if (!isset($parameters -> requestedTeamID)) {
        throw new Exception("ERROR, geen requestedTeamID");
    }


    if (!isset($parameters -> proApp)) {
        $parameters -> proApp = "unknown";
    }
    if (!isset($parameters -> platform)) {
        $parameters -> platform = "unknown";
    }
    if (!isset($parameters -> version)) {
        $parameters -> version = "unknown";
    }
    if (!isset($parameters -> firstCall)) {
        $parameters -> firstCall = false;
    }



    $username = $parameters -> username;
    $passwd = $parameters -> passwd;
    $requestedCompetitionID = $parameters -> requestedCompetitionID;
    $requestedTeamID = $parameters -> requestedTeamID;
    $proApp = $parameters -> proApp;
    $platform = $parameters -> platform;
    $version = $parameters -> version;
    $firstCall = $parameters -> firstCall;


    $userID = dbcalls\getUserID($username);

    // find out what is requested (all competitions of a user, all competitions of a team, or a single competition)
    $requestSingleCompetition = false;
    $requestSingleTeam = false;
    $requestSingleUser = false;
    if ($requestedCompetitionID<>0){
        $requestSingleCompetition = true;
    }
    else{
        if ($requestedTeamID<>0){
            $requestSingleTeam = true;
        }
        else{
            $requestSingleUser = true;
        }
    }


    /* Verify that user is in database */
    $username = mysql_real_escape_string($username);
    $q = "select password from users where username = '$username' and activeAccount=1";

    $result = mysql_query($q, $conn);
    if (!$result || (mysql_numrows($result) < 1)) {
        return null;
        //Indicates username failure
    }

    /* Retrieve password from result, strip slashes */
    $dbarray = mysql_fetch_array($result);
    $dbarray['password'] = stripslashes($dbarray['password']);
    $password = stripslashes($passwd);

    /* Validate that password is correct */
    if ($password != $dbarray['password']) {
        // invalid password
        return null;
    }

    // correct user, now get all userdata
    $proUser = dbcalls\getProUser($userID);
    $proEndDate = dbcalls\getProEndDate($userID);

    $result = new \stdClass();
    $result->userID = $userID;
    $result->username = $username;
    $result->proUser = $proUser;
    $result->proEndDate = $proEndDate;
    $result->foundGames = array();

    // load all teams
    $teams = dbcalls\loadTeams($userID);
    $result->teams = $teams;

    // load all competitions of all teams
    foreach ($result->teams as $team) {
        $competitions = dbcalls\loadCompetitions($team->id);
        $team->competitions = array();
        foreach ($competitions as $competition) {
            // status: 0=active, 1=afgelopen, 2=volgendjaar
            // skip all competitions that are afgelopen
            if ($competition->status!=1){
                $team->competitions[] = $competition;
            }
        }
    }

    // load all teammembers of all teams
    foreach ($result->teams as $team) {
        $team->teammembers = dbcalls\loadTeammembers($team->id);
    }

    /*
     * create a list of all requested competitions
     */
    $foundCompetitions = array();
    $foundTeams = array();
    foreach ($result->teams as $team) {
        $thisTeamIsUsed = false;
        foreach ($team->competitions as $competition) {
            if ($requestSingleCompetition){
                // add this competition if the competitionID is the requested ID
                if ($competition->id == $requestedCompetitionID){
                    $thisTeamIsUsed = true;
                    $foundCompetitions[] = $competition;
                }
            }
            if ($requestSingleTeam){
                // add this competition if the team is the requested team
                if ($team->id == $requestedTeamID){
                    $thisTeamIsUsed = true;
                    $foundCompetitions[] = $competition;
                }
            }
            if ($requestSingleUser){
                // always add this competition
                    $thisTeamIsUsed = true;
                    $foundCompetitions[] = $competition;
            }
        }
        if ($thisTeamIsUsed) $foundTeams[] = $team;
    }

    /*
     * if no competition was found, then use the first competition
     */
    if (count($foundCompetitions)==0){
        if (count($result->teams)>0){
            if (count($result->teams[0]->competitions)>0){
                $foundTeams[] = $result->teams[0];
                $foundCompetitions[] = $result->teams[0]->competitions[0];
            }
        }
    }

    /*
     * save the selected competitions
     */
    $result->usedCompetitions = array();
    $result->usedTeams = array();
    $result->foundCompetitions = count($foundCompetitions)>0;
    $result->foundTeam = count($foundTeams)>0;
    $result->foundMultipleCompetitions = count($foundCompetitions)>1;
    $result->foundMultipleTeams = count($foundTeams)>1;
    foreach ($foundCompetitions as $competition) {
        $result->usedCompetitions[] = $competition->id;
    }
    foreach ($foundTeams as $team) {
        $result->usedTeams[] = $team->id;
    }

    /*
     * load the mCompetition all selected competitions
     */
    $result->foundManagedCompetitions = array();
    foreach ($foundCompetitions as $competition) {

        $competitionData = new \stdClass();
        $competitionData->competitionID = $competition->id;
        $competitionData->mcompetitionData = null;
        if ($competition->mCompetition!=0){
            $competitionData->mcompetitionData = dbcalls\loadManagedCompetitionData($competition->mCompetition);
        }
        $result->foundManagedCompetitions[] = $competitionData;
   }

   /*
    * load the games of all selected competitions
    */
   if ($result->foundCompetitions){
        $result->foundGames = dbcalls\getCompetitionGames($userID,$foundCompetitions);
   }

   /*
    * save the username in the session (for logging info later)
    */
    $_SESSION['username'] = $username;


   /*
    * log the action
    */
   if ($firstCall){
    \dbcalls\logSQL($q,"Start app:username=".$username." proApp=".$proApp." platform=".$platform." version=".$version , 0);
   }
   else{
    // niet loggen, dit gebeurd te vaak
    // \dbcalls\logSQL($q,"Reload app:username=".$username." proApp=".$proApp." platform=".$platform." version=".$version , 0);
   }

   return $result;
}

function loadMTeamGames($parameters) {
    if (!isset($parameters -> mTeamID)) {
        throw new Exception("ERROR, geen mTeamID");
    }
    return dbcalls\loadMTeamGames($parameters -> mTeamID);
}



function createMCompetition($parameters) {
    if (!isset($parameters -> org)) {
        throw new Exception("ERROR, geen org");
    }
    if (!isset($parameters -> season)) {
        throw new Exception("ERROR, geen season");
    }
        if (!isset($parameters -> competition)) {
        throw new Exception("ERROR, geen competition");
    }
    $username = dbcalls\getSessionUserName();
    $userID = dbcalls\getUserID($username);
    $orgID = dbcalls\addNewManagedOrganisation($parameters -> org, $userID);
    $seasonID = dbcalls\addNewManagedSeason($parameters -> season, $orgID);
    return dbcalls\addNewManagedCompetition($parameters -> competition, $seasonID);
}

function loadMCompetition($parameters) {
    if (!isset($parameters -> compID)) {
        throw new Exception("ERROR, geen compID");
    }
    return dbcalls\loadManagedCompetitionData($parameters -> compID);
}


function createTeam($parameters) {
    if (!isset($parameters -> teamname)) {
        throw new Exception("ERROR, geen teamname");
    }
    $username = dbcalls\getSessionUserName();
    $userID = dbcalls\getUserID($username);
    return dbcalls\addNewTeam($parameters -> teamname, $userID);
}

function loadTeams($parameters) {
    $username = dbcalls\getSessionUserName();
    $userID = dbcalls\getUserID($username);
    return dbcalls\loadTeams($userID);
}

function loadUser($parameters) {
    if (!isset($parameters -> userID)) {
        throw new Exception("ERROR, geen userID");
    }
    return dbcalls\getUserData($parameters -> userID);
}

function saveUser($parameters) {
    if (!isset($parameters -> userID)) {
        throw new Exception("ERROR, geen userID");
    }
    if (!isset($parameters -> name)) {
        throw new Exception("ERROR, geen name");
    }
    if (!isset($parameters -> email)) {
        throw new Exception("ERROR, geen email");
    }
    if (!isset($parameters -> phonenumber)) {
        throw new Exception("ERROR, geen phonenumber");
    }
    return dbcalls\saveUser($parameters -> userID,$parameters -> name,$parameters -> email,$parameters -> phonenumber);
}

function loadListData($parameters) {
    if (!isset($parameters -> competitionID)) {
        throw new Exception("ERROR, geen competitionID");
    }
    requestsession\setSessionCompetition($parameters -> competitionID);
    return dbcalls\loadListData($parameters -> competitionID);
}

function loadGames($parameters) {
    if (!isset($parameters -> competitionID)) {
        throw new Exception("ERROR, geen competitionID");
    }
    requestsession\setSessionCompetition($parameters -> competitionID);
    return dbcalls\loadGames($parameters -> competitionID);
}

function deleteGame($parameters) {
    if (!isset($parameters -> gameID)) {
        throw new Exception("ERROR, geen gameID");
    }
    return dbcalls\deleteGame($parameters -> gameID);
}

function loadTeam($parameters) {
    if (!isset($parameters -> teamID)) {
        throw new Exception("ERROR, geen teamID");
    }
    return dbcalls\loadTeam($parameters -> teamID);
}

function saveTeam($parameters) {
    if (!isset($parameters -> teamID)) {
        throw new Exception("ERROR, geen teamID");
    }
    if (!isset($parameters -> teamname)) {
        throw new Exception("ERROR, geen teamname");
    }
    if (!isset($parameters -> vereniging)) {
        throw new Exception("ERROR, geen vereniging");
    }
    if (!isset($parameters -> sport)) {
        throw new Exception("ERROR, geen sport");
    }
    if (!isset($parameters -> voorkeursNrAanwezig)) {
        throw new Exception("ERROR, geen voorkeursNrAanwezig");
    }
    if (!isset($parameters -> reminderDays)) {
        throw new Exception("ERROR, geen reminderDays");
    }
    if (!isset($parameters -> tekortMailTo)) {
        throw new Exception("ERROR, geen tekortMailTo");
    }
    if (!isset($parameters -> waarschuwingMailTo)) {
        throw new Exception("ERROR, geen waarschuwingMailTo");
    }
    if (!isset($parameters -> waarschuwingMailDagen)) {
        throw new Exception("ERROR, geen waarschuwingMailDagen");
    }

    return dbcalls\saveTeam(
        $parameters -> teamID,
        $parameters -> teamname,
        $parameters -> vereniging,
        $parameters -> sport,
        $parameters -> voorkeursNrAanwezig,
        $parameters -> reminderDays,
        $parameters -> tekortMailTo,
        $parameters -> waarschuwingMailTo,
        $parameters -> waarschuwingMailDagen
        );
}

function loadCompetitions($parameters) {
    if (!isset($parameters -> teamID)) {
        throw new Exception("ERROR, geen team");
    }
    return dbcalls\loadCompetitions($parameters -> teamID);
}

function addCompetition($parameters) {
    if (!isset($parameters -> teamID)) {
        throw new Exception("ERROR, geen team");
    }
    if (!isset($parameters -> season)) {
        throw new Exception("ERROR, geen season");
    }
    if (!isset($parameters -> competition)) {
        throw new Exception("ERROR, geen competition");
    }
    if (!isset($parameters -> status)) {
        throw new Exception("ERROR, geen status");
    }
    return dbcalls\addCompetition($parameters -> teamID, $parameters -> season, $parameters -> competition, $parameters -> status);
}

function updateCompetition($parameters) {
    if (!isset($parameters -> competitions)) {
        throw new Exception("ERROR, geen competitions");
    }
//    $competitions = $parameters = json_decode($parameters -> competitions);
    return dbcalls\updateCompetitions($parameters -> competitions);
}

function inviteNewMembers($parameters) {
    return invite\inviteNewMembers($parameters);
}


function reInviteTeammember($parameters) {
    if (!isset($parameters -> teammemberID)) {
        throw new Exception("ERROR, geen teammemberID");
    }
    if (!isset($parameters -> nickname)) {
        throw new Exception("ERROR, geen nickname");
    }
    if (!isset($parameters -> email)) {
        throw new Exception("ERROR, geen email");
    }
    return invite\reInviteTeammember($parameters -> teammemberID,$parameters -> nickname,$parameters -> email);
}

function addGame($parameters) {
    if (!isset($parameters -> competitionID)) {
        throw new Exception("ERROR, geen competitionID");
    }
    if (!isset($parameters -> gameDate)) {
        throw new Exception("ERROR, geen gameDate");
    }
    if (!isset($parameters -> gameOpponent)) {
        throw new Exception("ERROR, geen gameOpponent");
    }
    if (!isset($parameters -> teamID)) {
        throw new Exception("ERROR, geen teamID");
    }
    if (!isset($parameters -> homegame)) {
        throw new Exception("ERROR, geen homegame");
    }
    requestsession\setSessionCompetition($parameters -> competitionID);
    return dbcalls\addGame($parameters -> teamID, $parameters -> competitionID, $parameters -> gameDate, $parameters -> gameOpponent, $parameters -> homegame);
}

function addGames($parameters) {
    if (!isset($parameters -> games)) {
        throw new Exception("ERROR, geen games");
    }
    return dbcalls\addGames($parameters -> games);
}

function loadGame($parameters) {
    if (!isset($parameters -> gameID)) {
        throw new Exception("ERROR, geen gameID");
    }
    requestsession\setSessionGame($parameters -> gameID);
    return dbcalls\loadGame($parameters -> gameID);
}

function removeCompetition($parameters) {
    if (!isset($parameters -> competitionID)) {
        throw new Exception("ERROR, geen competitionID");
    }
    requestsession\setSessionCompetition($parameters -> competitionID);
    return dbcalls\removeCompetition($parameters -> competitionID);
}

function joinExisting($parameters) {
    if (!isset($parameters -> username)) {
        throw new Exception("ERROR, geen username");
    }
    if (!isset($parameters -> password)) {
        throw new Exception("ERROR, geen password");
    }
    if (!isset($parameters -> nickname)) {
        throw new Exception("ERROR, geen nickname");
    }
    if (!isset($parameters -> invitationID)) {
        throw new Exception("ERROR, geen invitationID");
    }
    return requestjoin\joinExisting($parameters -> username, $parameters -> password, $parameters -> nickname, $parameters -> invitationID);
}

function joinNew($parameters) {
    if (!isset($parameters -> username)) {
        throw new Exception("ERROR, geen username");
    }
    if (!isset($parameters -> password)) {
        throw new Exception("ERROR, geen password");
    }
    if (!isset($parameters -> nickname)) {
        throw new Exception("ERROR, geen nickname");
    }
    if (!isset($parameters -> invitationID)) {
        throw new Exception("ERROR, geen invitationID");
    }
    if (!isset($parameters -> name)) {
        throw new Exception("ERROR, geen name");
    }
    if (!isset($parameters -> email)) {
        throw new Exception("ERROR, geen email");
    }

    return requestjoin\joinNew($parameters -> username, $parameters -> password, $parameters -> nickname, $parameters -> name, $parameters -> email, $parameters -> invitationID);

}

function joinReject($parameters) {
    if (!isset($parameters -> invitationID)) {
        throw new Exception("ERROR, geen invitationID");
    }
    return requestjoin\joinReject($parameters -> invitationID);
}

function loadTeammembers($parameters) {
    if (!isset($parameters -> teamID)) {
        throw new Exception("ERROR, geen teamID");
    }
    return dbcalls\loadTeammembers($parameters -> teamID);
}

function loadTeammembersOfUser($parameters) {
    if (!isset($parameters -> userID)) {
        throw new Exception("ERROR, geen userID");
    }
    return dbcalls\loadTeammembersOfUser($parameters -> userID);
}

function removeTeammember($parameters) {
    if (!isset($parameters -> teammemberID)) {
        throw new Exception("ERROR, geen teammemberID");
    }
    return dbcalls\removeTeammember($parameters -> teammemberID);
}

function findFirstUpcomingGame($parameters) {
    return dbcalls\findFirstUpcomingGame();
}

function saveGame($parameters) {
    if (!isset($parameters -> gameID)) {
        throw new Exception("ERROR, geen gameID");
    }
    if (!isset($parameters -> score)) {
        throw new Exception("ERROR, geen score");
    }
    if (!isset($parameters -> points)) {
        throw new Exception("ERROR, geen points");
    }
    if (!isset($parameters -> meetingpoint)) {
        throw new Exception("ERROR, geen meetingpoint");
    }
    if (!isset($parameters -> homegame)) {
        throw new Exception("ERROR, geen homegame");
    }
    if (!isset($parameters -> datetime)) {
        throw new Exception("ERROR, geen datetime");
    }
    if (!isset($parameters -> membersPresentYes)) {
        throw new Exception("ERROR, geen membersPresentYes");
    }
    if (!isset($parameters -> membersPresentNo)) {
        throw new Exception("ERROR, geen membersPresentNo");
    }
    if (!isset($parameters -> gameType)) {
        throw new Exception("ERROR, geen gameType");
    }
    if (!isset($parameters -> gameStatus)) {
        throw new Exception("ERROR, geen gameStatus");
    }
    // if (!isset($parameters -> membersPresentUnknown)) {
        // throw new Exception("ERROR, geen membersPresentUnknown");
    // }
    if (!isset($parameters -> opponent)) {
        throw new Exception("ERROR, geen opponent");
    }
    if (!isset($parameters -> goals)) {
        throw new Exception("ERROR, geen goals");
    }
    if (!isset($parameters -> list1)) {
        throw new Exception("ERROR, geen list1");
    }
    if (!isset($parameters -> list2)) {
        throw new Exception("ERROR, geen list2");
    }
        if (!isset($parameters -> list3)) {
        throw new Exception("ERROR, geen list3");
    }
        if (!isset($parameters -> list4)) {
        throw new Exception("ERROR, geen list4");
    }
        if (!isset($parameters -> list5)) {
        throw new Exception("ERROR, geen list5");
    }
        if (!isset($parameters -> list6)) {
        throw new Exception("ERROR, geen list6");
    }
        if (!isset($parameters -> list7)) {
        throw new Exception("ERROR, geen list7");
    }
        if (!isset($parameters -> list8)) {
        throw new Exception("ERROR, geen list8");
    }
        if (!isset($parameters -> list9)) {
        throw new Exception("ERROR, geen list9");
    }
        if (!isset($parameters -> list10)) {
        throw new Exception("ERROR, geen list10");
    }
    //print( $parameters -> goals);

    return dbcalls\saveGame($parameters -> gameID,
        $parameters -> score,
        $parameters -> points,
		$parameters -> meetingpoint,
		$parameters -> homegame,
	    $parameters -> datetime,
	    $parameters -> membersPresentYes,
        $parameters -> membersPresentNo,
        $parameters -> opponent,
        $parameters -> goals,
        $parameters -> gameType,
        $parameters -> gameStatus,
        $parameters -> list1,
        $parameters -> list2,
        $parameters -> list3,
        $parameters -> list4,
        $parameters -> list5,
        $parameters -> list6,
        $parameters -> list7,
        $parameters -> list8,
        $parameters -> list9,
        $parameters -> list10
     );
}

function importFromTeamers($parameters){
    if (!isset($parameters -> url)) {
        throw new Exception("ERROR, geen url");
    }
    return importFromTeamers2($parameters -> url);
}

function generateDemodata($parameters){
    demodata\removeDemodata();
    return demodata\generateDemodata();
}

function removeDemodata($parameters){
    return demodata\removeDemodata();
}

function clearOrphanData($parameters){
    return dbcalls\clearOrphanData();
}

function callCron($parameters){
    return cron\callCron();
}

function saveTeammembers($parameters){
    if (!isset($parameters -> changedLists)) {
        throw new Exception("ERROR, geen changedLists");
    }
    return dbcalls\saveTeammembers($parameters -> changedLists);
}

function saveTeammembers2($parameters){
    if (!isset($parameters -> changedLists)) {
        throw new Exception("ERROR, geen changedLists");
    }
    return dbcalls\saveTeammembers2($parameters -> changedLists);
}



function removeList($parameters){
    if (!isset($parameters -> listID)) {
        throw new Exception("ERROR, geen listID");
    }
    if (!isset($parameters -> teamID)) {
        throw new Exception("ERROR, geen teamID");
    }
    return dbcalls\removeList($parameters -> listID,$parameters -> teamID);
}

function addList($parameters){
    if (!isset($parameters -> request)) {
        throw new Exception("ERROR, geen request");
    }
    if (!isset($parameters -> teamID)) {
        throw new Exception("ERROR, geen teamID");
    }
    if (!isset($parameters -> listType)) {
        throw new Exception("ERROR, geen listType");
    }
    if (!isset($parameters -> listName)) {
        throw new Exception("ERROR, geen listName");
    }
    return dbcalls\addList($parameters -> listType,$parameters -> listName,$parameters -> teamID);
}

function saveListData($parameters){
    if (!isset($parameters -> changedLists)) {
        throw new Exception("ERROR, geen changedLists");
    }
    return dbcalls\saveListData($parameters -> changedLists);
}

function setAanwezig($parameters){
    if (!isset($parameters -> gameID)) {
        throw new Exception("ERROR, geen gameID");
    }
    if (!isset($parameters -> memberID)) {
        throw new Exception("ERROR, geen memberID");
    }
    return dbcalls\setAanwezig($parameters -> gameID,$parameters -> memberID);
}

function setAfwezig($parameters){
    if (!isset($parameters -> gameID)) {
        throw new Exception("ERROR, geen gameID");
    }
    if (!isset($parameters -> memberID)) {
        throw new Exception("ERROR, geen memberID");
    }
    return dbcalls\setAfwezig($parameters -> gameID,$parameters -> memberID);
}

function setOnbekend($parameters){
    if (!isset($parameters -> gameID)) {
        throw new Exception("ERROR, geen gameID");
    }
    if (!isset($parameters -> memberID)) {
        throw new Exception("ERROR, geen memberID");
    }
    return dbcalls\setOnbekend($parameters -> gameID,$parameters -> memberID);
}


function updateLists($parameters){
    if (!isset($parameters -> teamID)) {
        throw new Exception("ERROR, geen teamID");
    }
    if (!isset($parameters -> listname1)) {
        throw new Exception("ERROR, geen listname1");
    }
    if (!isset($parameters -> listname2)) {
        throw new Exception("ERROR, geen listname2");
    }
    if (!isset($parameters -> listname3)) {
        throw new Exception("ERROR, geen listname3");
    }
    if (!isset($parameters -> listname4)) {
        throw new Exception("ERROR, geen listname4");
    }
    if (!isset($parameters -> listname5)) {
        throw new Exception("ERROR, geen listname5");
    }
    if (!isset($parameters -> listname6)) {
        throw new Exception("ERROR, geen listname6");
    }
    if (!isset($parameters -> listname7)) {
        throw new Exception("ERROR, geen listname7");
    }
    if (!isset($parameters -> listname8)) {
        throw new Exception("ERROR, geen listname8");
    }
    if (!isset($parameters -> listname9)) {
        throw new Exception("ERROR, geen listname9");
    }
    if (!isset($parameters -> listname10)) {
        throw new Exception("ERROR, geen listname10");
    }
    return dbcalls\updateLists($parameters -> teamID,$parameters -> listname1,$parameters -> listname2,$parameters -> listname3
    ,$parameters -> listname4,$parameters -> listname5,$parameters -> listname6,$parameters -> listname7
    ,$parameters -> listname8,$parameters -> listname9,$parameters -> listname10);
}

function changeNickname($parameters){
    if (!isset($parameters -> nickName)) {
        throw new Exception("ERROR, geen nickName");
    }
    if (!isset($parameters -> memberID)) {
        throw new Exception("ERROR, geen memberID");
    }
    return dbcalls\changeNickname($parameters -> nickName,$parameters -> memberID);
}
function addMessage($parameters){
    if (!isset($parameters -> gameID)) {
        throw new Exception("ERROR, geen gameID");
    }
    if (!isset($parameters -> newMessage)) {
        throw new Exception("ERROR, geen newMessage");
    }
    return dbcalls\addMessage($parameters -> gameID,$parameters -> newMessage);
}
function emailMessages($parameters){
    if (!isset($parameters -> gameID)) {
        throw new Exception("ERROR, geen gameID");
    }
    return dbcalls\emailMessages($parameters -> gameID);
}

function changePW($parameters){
    if (!isset($parameters -> userID)) {
        throw new Exception("ERROR, geen userID");
    }
    if (!isset($parameters -> oldPW)) {
        throw new Exception("ERROR, geen oldPW");
    }
    if (!isset($parameters -> newPW1)) {
        throw new Exception("ERROR, geen newPW1");
    }
    if (!isset($parameters -> newPW2)) {
        throw new Exception("ERROR, geen newPW2");
    }
    return dbcalls\changePW($parameters -> userID,$parameters -> oldPW,$parameters -> newPW1,$parameters -> newPW2);
}

function getSQLSchemaChanges($parameters){
    return tablestruct\getSQLSchemaChanges();
}

function performSQLSchemaChanges($parameters){
    return tablestruct\performSQLSchemaChanges();
}

function forgotPassword($parameters){
    if (!isset($parameters -> email)) {
        throw new Exception("ERROR, geen email");
    }
    return invite\forgotPassword($parameters -> email);
}

function adminListAllTeams($parameters){
    return dbcalls\adminListAllTeams();
}
function adminListAllChanges($parameters){
    return dbcalls\adminListAllChanges($parameters);
}
function adminListAllUsers($parameters){
    return dbcalls\adminListAllUsers();
}
function adminListAllTeammembers($parameters){
    if (!isset($parameters -> filterTeamID)) {
        throw new Exception("ERROR, geen filterTeamID");
    }

    return dbcalls\adminListAllTeammembers($parameters -> filterTeamID);
}
function adminRemoveTeam($parameters){
    if (!isset($parameters -> teamID)) {
        throw new Exception("ERROR, geen teamID");
    }
    return dbcalls\adminRemoveTeam($parameters -> teamID);
}

function adminRemoveUser($parameters){
    if (!isset($parameters -> userID)) {
        throw new Exception("ERROR, geen userID");
    }
    return dbcalls\adminRemoveUser($parameters -> userID);
}

function adminDisableProUser($parameters){
    if (!isset($parameters -> userID)) {
        throw new Exception("ERROR, geen userID");
    }
    return dbcalls\adminDisableProUser($parameters -> userID);
}

function adminEnableProUser($parameters){
    if (!isset($parameters -> userID)) {
        throw new Exception("ERROR, geen userID");
    }
    return dbcalls\adminEnableProUser($parameters -> userID);
}


function dbSummary($parameters){
    return dbcalls\dbSummary();
}

function createUser($parameters){
    if (!isset($parameters -> username)) {
        throw new Exception("ERROR, geen username");
    }
    if (!isset($parameters -> password)) {
        throw new Exception("ERROR, geen password");
    }
    if (!isset($parameters -> email)) {
        throw new Exception("ERROR, geen email");
    }
    if (!isset($parameters -> name)) {
        throw new Exception("ERROR, geen name");
    }
    if (!isset($parameters -> requestConnectTeam)) {
        throw new Exception("ERROR, geen requestConnectTeam");
    }
    if (!isset($parameters -> testveld)) {
        throw new Exception("ERROR, geen testveld");
    }
    $to_check = md5($parameters -> testveld);
    if($to_check != $_SESSION['security_code']){
        throw new \Exception(/*T1579T*/"De beveiligingscode is onjuist!"/*T1579T*/);
    }

    $requestConnectTeamID = $parameters -> requestConnectTeam;
    $userID = registerUser\registerNewUser($parameters -> username, $parameters -> password, $parameters -> email, $parameters -> name, $parameters -> requestConnectTeam);
    if ($requestConnectTeamID!=0) connectteam\createTeamIfNeeded($userID,$requestConnectTeamID);

    return $userID;
}

function syncMCompetition($parameters){
     connectteam\syncAllManagedCompetitions();
     return null;
}
function createTeamAndConnect($parameters){
    if (!isset($parameters -> requestConnectTeam)) {
        throw new Exception("ERROR, geen requestConnectTeam");
    }
    // find user ID
    $username = dbcalls\getSessionUserName();
    $userID = dbcalls\getUserID($username);

    connectteam\createTeamIfNeeded($userID,$parameters -> requestConnectTeam);
    return null;
}

function connectTeam($parameters){
    if (!isset($parameters -> teamID)) {
        throw new Exception("ERROR, geen teamID");
    }
    if (!isset($parameters -> requestConnectTeam)) {
        throw new Exception("ERROR, geen requestConnectTeam");
    }

    // find user ID
    $username = dbcalls\getSessionUserName();
    $userID = dbcalls\getUserID($username);

    connectteam\connectTeam($userID, $username, $parameters -> teamID,$parameters -> requestConnectTeam, false);

    return null;
}

function loadCompetitionData($parameters){
    if (!isset($parameters -> competitionID)) {
        throw new Exception("ERROR, geen competitionID");
    }
    $result = new \stdClass();
    $result->games = dbcalls\loadGames($parameters -> competitionID);
    $competition = dbcalls\loadCompetition($parameters -> competitionID);
    $result->mCompetition = new \stdClass();
    $result->mCompetition->games = array();
    $result->mCompetition->teams = array();
    if ($competition!=null){
        $result->mCompetition = dbcalls\loadManagedCompetitionData($competition->mCompetition);
    }
    requestsession\setSessionCompetition($parameters -> competitionID);

    return $result;
}

function loadMAllCompetitionData($parameters) {
    if (!isset($parameters -> userID)) {
        throw new Exception("ERROR, geen userID");
    }
    return dbcalls\loadMAllCompetitionData($parameters -> userID);
}


function loadMCompetitions($parameters) {
    if (!isset($parameters -> userID)) {
        throw new Exception("ERROR, geen userID");
    }
    return dbcalls\loadMCompetitions($parameters -> userID);
}

function loadMSeasons($parameters) {
    if (!isset($parameters -> userID)) {
        throw new Exception("ERROR, geen userID");
    }
    return dbcalls\loadMSeasons($parameters -> userID);
}

function loadMOrganisations($parameters) {
    if (!isset($parameters -> userID)) {
        throw new Exception("ERROR, geen userID");
    }
    return dbcalls\loadMOrganisations($parameters -> userID);
}


function removeMCompetition($parameters) {
    if (!isset($parameters -> competitionID)) {
        throw new Exception("ERROR, geen competitionID");
    }
    return dbcalls\removeMCompetition($parameters -> competitionID);
}

function updateMCompetition($parameters) {
    if (!isset($parameters -> competitions)) {
        throw new Exception("ERROR, geen competitions");
    }
    return dbcalls\updateMCompetitions($parameters -> competitions);
}

function addMCompetition($parameters) {
    if (!isset($parameters -> seasonID)) {
        throw new Exception("ERROR, geen seasonID");
    }
    if (!isset($parameters -> competition)) {
        throw new Exception("ERROR, geen competition");
    }
    return dbcalls\addMCompetition($parameters -> seasonID, $parameters -> competition);
}

function removeMSeason($parameters) {
    if (!isset($parameters -> seasonID)) {
        throw new Exception("ERROR, geen seasonID");
    }
    return dbcalls\removeMSeason($parameters -> seasonID);
}

function updateMSeason($parameters) {
    if (!isset($parameters -> seasons)) {
        throw new Exception("ERROR, geen seasons");
    }
    return dbcalls\updateMSeason($parameters -> seasons);
}

function addMSeason($parameters) {
    if (!isset($parameters -> organisationID)) {
        throw new Exception("ERROR, geen organisationID");
    }
    if (!isset($parameters -> season)) {
        throw new Exception("ERROR, geen season");
    }
    return dbcalls\addMSeason($parameters -> organisationID, $parameters -> season);
}



function removeMOrganisation($parameters) {
    if (!isset($parameters -> organisationID)) {
        throw new Exception("ERROR, geen organisationID");
    }
    return dbcalls\removeMOrganisation($parameters -> organisationID);
}

function updateMOrganisation($parameters) {
    if (!isset($parameters -> organisations)) {
        throw new Exception("ERROR, geen organisations");
    }
    return dbcalls\updateMOrganisation($parameters -> organisations);
}

function addMOrganisation($parameters) {
    if (!isset($parameters -> userID)) {
        throw new Exception("ERROR, geen userID");
    }
    if (!isset($parameters -> organisation)) {
        throw new Exception("ERROR, geen organisation");
    }
    return dbcalls\addMOrganisation($parameters -> userID, $parameters -> organisation);
}


function removeMGame($parameters) {
    if (!isset($parameters -> gameID)) {
        throw new Exception("ERROR, geen gameID");
    }
    return dbcalls\removeMGame($parameters -> gameID);
}

function updateMGames($parameters) {
    if (!isset($parameters -> games)) {
        throw new Exception("ERROR, geen games");
    }
    if (!isset($parameters -> competitionID)) {
        throw new Exception("ERROR, geen competitionID");
    }
    dbcalls\updateMGames($parameters -> games,$parameters -> competitionID );
    connectteam\syncAllManagedCompetitions();

}

function newMGames($parameters) {
    if (!isset($parameters -> games)) {
        throw new Exception("ERROR, geen games");
    }
    if (!isset($parameters -> competitionID)) {
        throw new Exception("ERROR, geen competitionID");
    }
        return dbcalls\newMGames($parameters -> games,$parameters -> competitionID );
}


function updateMTeams($parameters) {
    if (!isset($parameters -> teams)) {
        throw new Exception("ERROR, geen teams");
    }
    return dbcalls\updateMTeams($parameters -> teams );
}

function newMTeams($parameters) {
    if (!isset($parameters -> teams)) {
        throw new Exception("ERROR, geen teams");
    }
    if (!isset($parameters -> competitionID)) {
        throw new Exception("ERROR, geen competitionID");
    }
        return dbcalls\newMTeams($parameters -> teams,$parameters -> competitionID );
}


function getUpcomingGames($parameters) {
    if (!isset($parameters -> competitionID)) {
        throw new Exception("ERROR, geen competitionID");
    }
    if (!isset($parameters -> userID)) {
        throw new Exception("ERROR, geen userID");
    }
    if (!isset($parameters -> filter)) {
        throw new Exception("ERROR, geen filter");
    }
    if (!isset($parameters -> numDays)) {
        throw new Exception("ERROR, geen numDays");
    }
    return dbcalls\getUpcomingGames2($parameters -> userID, $parameters -> competitionID, $parameters -> filter,$parameters -> numDays);
}

function getPreviousGames($parameters) {
    if (!isset($parameters -> competitionID)) {
        throw new Exception("ERROR, geen competitionID");
    }
    if (!isset($parameters -> userID)) {
        throw new Exception("ERROR, geen userID");
    }
    if (!isset($parameters -> filter)) {
        throw new Exception("ERROR, geen filter");
    }
    if (!isset($parameters -> numDays)) {
        throw new Exception("ERROR, geen numDays");
    }
    return dbcalls\getPreviousGames2($parameters -> userID, $parameters -> competitionID, $parameters -> filter,$parameters -> numDays);
}

function buyedMonth($parameters) {
    if (!isset($parameters -> userID)) {
        throw new Exception("ERROR, geen userID");
    }
    if (!isset($parameters -> actionResult)) {
        throw new Exception("ERROR, geen actionResult");
    }
    return payment\buyedMonth($parameters -> userID,$parameters -> actionResult);
}

function buyedYear($parameters) {
    if (!isset($parameters -> userID)) {
        throw new Exception("ERROR, geen userID");
    }
    if (!isset($parameters -> actionResult)) {
        throw new Exception("ERROR, geen actionResult");
    }
    return payment\buyedYear($parameters -> userID, $parameters -> actionResult);
}

function logPayment($parameters) {
    if (!isset($parameters -> userID)) {
        throw new Exception("ERROR, geen userID");
    }
    if (!isset($parameters -> action)) {
        throw new Exception("ERROR, geen action");
    }
    if (!isset($parameters -> actionResult)) {
        throw new Exception("ERROR, geen actionResult");
    }
    return payment\logPayment($parameters -> userID, $parameters -> action, $parameters -> actionResult);
}

?>