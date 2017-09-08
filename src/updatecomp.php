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
include_once ("request-connectteam.php");
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


    $result = "";

    $functionFound = false;

    if ($request == "update") {
        $result = update();
        $functionFound = true;
    }
    if ($request == "updateteam") {
        $result = updateteam();
        $functionFound = true;
    }
    if ($request == "synccompetition") {
        $result = synccompetition();
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


function checkUser($username,$passwd) {
    return dbcalls\checkUser($username,$passwd);
}

/**
 */
function findAnonimousTeams($managedCompetitionID){    
    global $conn;
    $array = array();
    
    $query = "SELECT id FROM team where managedCompetitieID='" . $managedCompetitionID . "' ";
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    while ($i < $num) {
        $item = new \stdClass();
        $item -> id = mysql_result($result, $i, "id");
        $array[] = $item;
        $i++;
    }
    return $array;
}

/**
 */
function findCompetitionsOfMTeamID($anonimousTeamID){    
    global $conn;
    $array = array();
    
    $query = "SELECT id FROM competition where mTeamID=" . $anonimousTeamID;
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    while ($i < $num) {
        $item = new \stdClass();
        $item -> id = mysql_result($result, $i, "id");
        $array[] = $item;
        $i++;
    }
    return $array;
}



/*************************************/
/***         FUNCTIONS     ***********/
/*************************************/

function synccompetition() {
    if (empty($_REQUEST["u"])) {
        throw new Exception("ERROR, geen username");
    }
    if (empty($_REQUEST["p"])) {
        throw new Exception("ERROR, geen passwd");
    }
    if (empty($_REQUEST["competitie"])) {
        throw new Exception("ERROR, geen competitie");
    }
    if (empty($_REQUEST["season"])) {
        throw new Exception("ERROR, geen season");
    }
    if (empty($_REQUEST["organisation"])) {
        throw new Exception("ERROR, geen organisation");
    }
    

    $competitie = $_REQUEST["competitie"];
    $season = $_REQUEST["season"];
    $organisation = $_REQUEST["organisation"];
    $username = $_REQUEST["u"];
    $passwd = $_REQUEST["p"];
    
    // find username
    $userID = checkUser($username,$passwd);
    if ($userID==-1) throw new Exception("ERROR, ongeldige gebruikersnaam of wachtwoord");

    // find $organisation
    $organisationID = findOrCreateOrganisation($userID,$organisation);

    // find $season
    $seasonID = findOrCreateSeason($organisationID,$season);

    // find $competitie
    $managedCompetitionID = findOrCreateManagedCompetition($seasonID,$competitie);
    
    // find all anonimous teams that belong to this managedCompetition
    $anonimousTeams = findAnonimousTeams($managedCompetitionID);
    if ($anonimousTeams==null) return;
    
    foreach ($anonimousTeams as $anonimousTeam) {
        // find all competition that have the $anonimousTeam as his mTeamID 
        $competitions = findCompetitionsOfMTeamID($anonimousTeam->id);
        if ($competitions!=null){
            foreach ($competitions as $competition) {
                connectteam\syncCompetition($competition->id);
            }
        }
    }
}


function updateteam() {
    if (empty($_REQUEST["u"])) {
        throw new Exception("ERROR, geen username");
    }
    if (empty($_REQUEST["p"])) {
        throw new Exception("ERROR, geen passwd");
    }
    if (empty($_REQUEST["competitie"])) {
        throw new Exception("ERROR, geen competitie");
    }
    if (empty($_REQUEST["season"])) {
        throw new Exception("ERROR, geen season");
    }
    if (empty($_REQUEST["organisation"])) {
        throw new Exception("ERROR, geen organisation");
    }
    if (empty($_REQUEST["t"])) {
        throw new Exception("ERROR, geen team");
    }
    
    
    $competitie = $_REQUEST["competitie"];
    $season = $_REQUEST["season"];
    $organisation = $_REQUEST["organisation"];
    $username = $_REQUEST["u"];
    $passwd = $_REQUEST["p"];
    
    // find username
    $userID = checkUser($username,$passwd);
    if ($userID==-1) throw new Exception("ERROR, ongeldige gebruikersnaam of wachtwoord");

    // find $organisation
    $organisationID = findOrCreateOrganisation($userID,$organisation);

    // find $season
    $seasonID = findOrCreateSeason($organisationID,$season);

    // find $competitie
    $competitionID = findOrCreateManagedCompetition($seasonID,$competitie);    
    
    $team = $_REQUEST["t"];
    
    $teamFields = explode("\t", $team);
    $index = 0;
    if (sizeof($teamFields)==4){
        $teamname = $teamFields[0];
        $strafpunten = $teamFields[1];
        $aanvoerder = $teamFields[2];
        $email = $teamFields[3];

        // find or create team
        $teamID = findOrCreateTeam($teamname,$competitionID);

        // update team
        updateTeamData($competitionID,$teamID,$strafpunten,$aanvoerder,$email);
    }
}


function update() {
    if (empty($_REQUEST["g"])) {
        throw new Exception("ERROR, geen game");
    }

    if (empty($_REQUEST["u"])) {
        throw new Exception("ERROR, geen username");
    }
    if (empty($_REQUEST["p"])) {
        throw new Exception("ERROR, geen passwd");
    }
    if (empty($_REQUEST["competitie"])) {
        throw new Exception("ERROR, geen competitie");
    }
    if (empty($_REQUEST["season"])) {
        throw new Exception("ERROR, geen season");
    }
    if (empty($_REQUEST["organisation"])) {
        throw new Exception("ERROR, geen organisation");
    }
    
    
    $competitie = $_REQUEST["competitie"];
    $season = $_REQUEST["season"];
    $organisation = $_REQUEST["organisation"];
    $username = $_REQUEST["u"];
    $passwd = $_REQUEST["p"];
    $game = $_REQUEST["g"];

    // find username
    $userID = checkUser($username,$passwd);
    if ($userID==-1) throw new Exception("ERROR, ongeldige gebruikersnaam of wachtwoord");

    // find $organisation
    
        
    
    $organisationID = findOrCreateOrganisation($userID,$organisation);

    // find $season
    $seasonID = findOrCreateSeason($organisationID,$season);

    // find $competitie
    $competitionID = findOrCreateManagedCompetition($seasonID,$competitie);

    //error_log("Game:".print_r($game, TRUE)."\n", 3, "c:\\my-errors.log");
        
    $gameFields = explode("\t", $game);
    $index = 0;
    if (sizeof($gameFields)==8){
        $playround = $gameFields[0];
        $date = $gameFields[1];
        $time = $gameFields[2];
        $location = $gameFields[3];
        $team1 = $gameFields[4];
        $team2 = $gameFields[5];
        $score = $gameFields[6];
        $lookup1 = $gameFields[7];

        
    // error_log("date:".print_r($date, TRUE)."\n", 3, "c:\\my-errors.log");
    // error_log("time:".print_r($time, TRUE)."\n", 3, "c:\\my-errors.log");
    // error_log("team1:".print_r($team1, TRUE)."\n", 3, "c:\\my-errors.log");
    // error_log("team2:".print_r($team2, TRUE)."\n", 3, "c:\\my-errors.log");
            
                
        // define uniquestring
        $gameidstring1 = $competitionID.$playround.$team1.$team2;
        $gameidstring2 = $competitionID.$playround.$team2.$team1;
                
        // find or create teams
        $team1ID = findOrCreateTeam($team1,$competitionID);
        $team2ID = findOrCreateTeam($team2,$competitionID);

        // find or create playround
        $playRoundID = findOrCreatePlayround($playround,$competitionID);
        
        // find or create mGame
        $managedGameID = findOrCreateMGame($gameidstring1,$playRoundID);
        
        // find seasonDescription of this competition
        $competitionDescription = findCompetitionDescription($competitionID);
        $seasonDescription = findCompetitionSeason($competitionID);
        
        // find or competition
        $team1CompetitionID = findOrCreateCompetition($competitionDescription,$seasonDescription,$team1ID, $competitionID);
        $team2CompetitionID = findOrCreateCompetition($competitionDescription,$seasonDescription,$team2ID, $competitionID);

        // find or create game1
        $gameID1 = findOrCreateGame($gameidstring1,$team1CompetitionID,$managedGameID);
        $gameID2 = findOrCreateGame($gameidstring2,$team2CompetitionID,$managedGameID);
    // error_log("test 05-6 \n", 3, "c:\\my-errors.log");
//         
    // error_log("date:".print_r($date, TRUE)."\n", 3, "c:\\my-errors.log");
    // error_log("time:".print_r($time, TRUE)."\n", 3, "c:\\my-errors.log");
        
        // update MGame
        updateMGame($managedGameID,$date,$time,$location,$team1ID,$team2ID,$score,$lookup1);
        
    // error_log("test 06 \n", 3, "c:\\my-errors.log");

        // update Game for team1
        updateGame($gameID1,$date,$time,$location,$team1ID,$team2,$score,$team1CompetitionID,1);
        
        // reverse score
        $scoreArray = explode("-", $score);
        $score2 = $score;
        if (sizeof($scoreArray)==2){
            $score2 = $scoreArray[1]."-".$scoreArray[0];
        }
        
        // update Game for team2
        updateGame($gameID2,$date,$time,$location,$team2ID,$team1,$score2,$team2CompetitionID,0);
    }
}


function findOrCreateCompetition($competitionDescription,$seasonDescription,$teamID,$managedCompetitionID) {
    global $conn;
    $seasonDescription = mysql_real_escape_string($seasonDescription); 
    $competitionDescription = mysql_real_escape_string($competitionDescription); 

    $q = "select id from competition where season = '$seasonDescription' and description = '$competitionDescription' and teamID = ".$teamID;
    $result = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    if ($num > 0) {
        $id = mysql_result($result, 0, "id");
        return $id;
    }
    
    // not found
    $q = "INSERT INTO competition (`season`,`description`,`teamID`,`mCompetition`) VALUES ('$seasonDescription','$competitionDescription',$teamID,$managedCompetitionID)";
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $id = mysql_insert_id();
    return $id;    
}


function findCompetitionDescription($competitionID) {
    global $conn;

    $q = "select description from managedcompetition where id = '$competitionID'";
    $result = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    if ($num > 0) {
        $description = mysql_result($result, 0, "description");
        return $description;
    }
    
    return "";    
}

function findCompetitionSeason($competitionID) {
    global $conn;

    $q = "select managedcompetitionseason.description as description from managedcompetitionseason,managedcompetition where managedcompetitionseason.id = managedcompetition.managedCompetitionSeasonID and managedcompetition.id='$competitionID'";
    $result = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    if ($num > 0) {
        $description = mysql_result($result, 0, "description");
        return $description;
    }
    
    return "";    
}

function findOrCreateOrganisation($userID, $organisation) {
    global $conn;
    $organisation = mysql_real_escape_string($organisation); 

    $q = "select id from managedcompetitionorganisation where description = '$organisation' and userID=$userID";
    $result = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    if ($num > 0) {
        $id = mysql_result($result, 0, "id");
        return $id;
    }
    
    // not found
    $q = "INSERT INTO managedcompetitionorganisation (`description`,`userID`) VALUES ('$organisation',$userID)";
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $id = mysql_insert_id();
    return $id;    
}

function findOrCreateSeason($organisationID, $season) {
    global $conn;
    $season = mysql_real_escape_string($season); 

    $q = "select id from managedcompetitionseason where description = '$season' and managedCompetitionOrganisationID =$organisationID";
    $result = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    if ($num > 0) {
        $id = mysql_result($result, 0, "id");
        return $id;
    }
    
    // not found
    $q = "INSERT INTO managedcompetitionseason (`description`,`managedCompetitionOrganisationID`) VALUES ('$season',$organisationID)";
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $id = mysql_insert_id();
    return $id;    
}


function findOrCreateManagedCompetition($seasonID, $competitie) {
    global $conn;
    $competitie = mysql_real_escape_string($competitie); 
 
    $q = "select id from managedcompetition where description = '$competitie' and managedCompetitionSeasonID =$seasonID";
    $result = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    if ($num > 0) {
        $id = mysql_result($result, 0, "id");
        return $id;
    }
    
    // not found
    $q = "INSERT INTO managedcompetition (`description`,`managedCompetitionSeasonID`) VALUES ('$competitie',$seasonID)";
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $id = mysql_insert_id();
    return $id;    
}


function findOrCreateTeam($teamname,$competitionID) {
    global $conn;
    $teamname = mysql_real_escape_string($teamname); 

    $q = "select id from team where teamname = '$teamname' and managedCompetitieID=$competitionID";
    $result = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    if ($num > 0) {
        $id = mysql_result($result, 0, "id");
        return $id;
    }
    
    // not found
    $q = "INSERT INTO team (`teamname`,`managedCompetitieID`) VALUES ('$teamname',$competitionID)";
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $id = mysql_insert_id();
    return $id;    
}

function findOrCreatePlayround($playround,$competitionID) {
    global $conn;
    $playround = mysql_real_escape_string($playround); 

    $q = "select id from playround where managedCompetitionID = '$competitionID' and description='$playround'";
    $result = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    if ($num > 0) {
        $id = mysql_result($result, 0, "id");
        return $id;
    }
    
    // not found
    $q = "INSERT INTO playround (`managedCompetitionID`,`description`) VALUES ('$competitionID','$playround')";
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $id = mysql_insert_id();
    return $id;    
}

function findOrCreateMGame($gameidstring,$playroundID) {
    global $conn;
    $gameidstring = mysql_real_escape_string($gameidstring);
     
    $q = "select id from managedgames where playroundID = '$playroundID' and gameUID='$gameidstring'";
    $result = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    if ($num > 0) {
        $id = mysql_result($result, 0, "id");
        return $id;
    }
    
    // not found
    $q = "INSERT INTO managedgames (`playroundID`,`gameUID`) VALUES ('$playroundID','$gameidstring')";
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $id = mysql_insert_id();
    return $id;        
}




function findOrCreateGame($gameidstring,$competitionID, $managedGameID) {
    global $conn;
    $gameidstring = mysql_real_escape_string($gameidstring);
     
    $q = "select id from games where competitionID = '$competitionID' and gameUID='$gameidstring'";
    $result = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    if ($num > 0) {
        $id = mysql_result($result, 0, "id");
        return $id;
    }
    
    // not found
    $q = "INSERT INTO games (`competitionID`,`gameUID`, `mGameID`) VALUES ('$competitionID','$gameidstring',$managedGameID)";
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $id = mysql_insert_id();
    return $id;            
}

function updateTeamData($competitionID,$teamID,$strafpunten,$aanvoerder,$email){    global $conn;
    $strafpunten = mysql_real_escape_string($strafpunten); 
    $aanvoerder = mysql_real_escape_string($aanvoerder);
    $email = mysql_real_escape_string($email);
        
    $q = "UPDATE team SET ".
    "strafpunten='$strafpunten'".
    ", aanvoerder='$aanvoerder'".
    ", email='$email'".
    "  WHERE id = '$teamID'";
    
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }    
}


function updateMGame($managedGameID,$date,$time,$location,$team1ID,$team2ID,$score,$lookup1){
    global $conn;

    $location = mysql_real_escape_string($location); 
    $lookup1 = mysql_real_escape_string($lookup1);

    // error_log("old:".$date." ".$time."\n", 3, "c:\\my-errors.log");

    if (strlen($date)==8){
        // format is 12-03-12, change that to 12-03-2012 
        $year=substr($date, -2, 2);
        $date=substr($date, 0, -2)."20".$year;
    }
    // error_log("new:".$date." ".$time."\n", 3, "c:\\my-errors.log");
        
    $datetime = date_create_from_format('j-n-Y G:i', $date." ".$time);


    $q = "UPDATE managedgames SET ".
    "teamID1='$team1ID'".
    ", teamID2='$team2ID'".
    ", datetime=".$datetime->getTimestamp().
    ", location='$location'".
    ", score='$score'".
    "  WHERE id = '$managedGameID';";

    // error_log("q=".$q." \n", 3, "c:\\my-errors.log");
    
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }    
}

function updateGame($gameID,$date,$time,$location,$teamID,$opponent,$score,$teamCompetitionID,$homegame){
    global $conn;

    $location = mysql_real_escape_string($location); 
    $opponent = mysql_real_escape_string($opponent); 
    if (strlen($date)==8){
        // format is 12-03-12, change that to 12-03-2012 
        $year=substr($date, -2, 2);
        $date=substr($date, 0, -2)."20".$year;
    }
    $datetime = date_create_from_format('j-n-Y G:i', $date." ".$time);
        
    
            
    $q = "UPDATE games SET ".
    "teamID='$teamID'".
    ", opponent='$opponent'".
    ", meetingpoint='$location'".
    ", datetime=".$datetime->getTimestamp().
    ", competitionID='$teamCompetitionID'".
    ", homegame='$homegame'".
    ", score='".$score."'".
    "  WHERE id = '$gameID';";
    
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }    
    
}


?>