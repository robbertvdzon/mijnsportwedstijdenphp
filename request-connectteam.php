<?
namespace connectteam;
include_once("globals.php");
include_once("dbcalls.php");


/**
 */
function getUserDetails($userID){
   global $conn;
   $item = new \stdClass();
   $item->name = "";
   $item->requestConnectTeamID = 0;
      
   $q = "select name,requestConnectTeam from users WHERE id = '".$userID."';";
   $result = mysql_query($q, $conn);
   if (mysql_errno()) {
       throw new \Exception(mysql_error());
   }
   $num = mysql_numrows($result);
   if ($num == 0)
       return null;// no user found    
   $item->name = mysql_result($result, 0, "name");           
   $item->requestConnectTeamID = mysql_result($result, 0, "requestConnectTeam");
   return $item;
}


/**
 */
function getRequestedCompetitionDetails($userID,$requestConnectTeamID){
    global $conn;
    $item = new \stdClass();
    $item->id = 0;

    $q = "select competition.id from competition,team,teammember where competition.teamID=team.id and teammember.teamID = team.id and teammember.userID = ".$userID." and competition.mTeamID = ".$requestConnectTeamID;
    $result = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    if ($num == 0){
        return null;// there already is a competition for this user that is connected to this team. Return here            
    }
      
    $item->id = mysql_result($result, 0, "competition.id");           
    return $item;
}


/**
 */
function findTeamConnectedToAnonymousTeam($requestConnectTeamID){
    global $conn;

    $q = "select teamID from competition where mTeamID=".$requestConnectTeamID;
    $result = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    if ($num == 0){
        return -1;// there already is a competition for this user that is connected to this team. Return here            
    }
      
    return mysql_result($result, 0, "teamID");           
}

/**
 */
function getTeamname($teamID){
    global $conn;
    $item = new \stdClass();
    $item->teamname= "";
      
    $q = "select teamname from team WHERE id = '".$teamID."';";
    $result = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    if ($num == 0)
        return null;// no team found    
    $item->teamname = mysql_result($result, 0, "teamname");
    return $item;
}

/**
 */
function newTeam($teamname){
    global $conn;
      
    $q = "INSERT INTO team (`teamname`) VALUES ('".mysql_real_escape_string($teamname)."')";
    \dbcalls\logSQL($q,"add team", 0);

    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    return mysql_insert_id();
}

/**
 */
function newCompetition($requestConnectTeamID,$newTeamID,$competition,$season, $managedCompetitionID){
    global $conn;
    $q = "INSERT INTO competition (`mTeamID`,`teamID`,`description`,`season`,`type`,`mCompetition`) VALUES (".
    $requestConnectTeamID.",".
    $newTeamID.",".
    "'".mysql_real_escape_string($competition)."',".
    "'".mysql_real_escape_string($season)."',".
    "1,".
    $managedCompetitionID.
    ")";
    \dbcalls\logSQL($q,"add competition", 0);

    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    return mysql_insert_id();
}

/**
 */
function newTeammember($newTeamID,$userID,$name){
    global $conn;
    // check if there is already a teammember with admin rights 
    $array = array();
    $query = "SELECT * FROM teammember where teammember.teamID=$newTeamID and admin=1";
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $teamHasAdmin = $num>0;
    
    // insert new user (with admin right if there is no admin user)
    $adminRights = "1";
    if ($teamHasAdmin){
        $adminRights = "0";
    }
    
    $q = "INSERT INTO teammember (`teamID`,`userID`,`nickname`,`admin`) VALUES (".
    $newTeamID.",".
    $userID.",".
    "'".mysql_real_escape_string($name)."',".
    $adminRights.")";
    \dbcalls\logSQL($q,"add teammember", 0);
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    return mysql_insert_id();
}


/**
 */
function getCompetitionDetails($targetCompetitionID){
    global $conn;
    $item = new \stdClass();
    $item->competition= "";
    $item->season= "";
      
    $q = "SELECT teamID,mTeamID FROM competition where id=".$targetCompetitionID;
    $result = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    if ($num == 0)
        return null;// no team found    
    $item->teamID = mysql_result($result, 0, "teamID");           
    $item->mTeamID = mysql_result($result, 0, "mTeamID");
    return $item;
}


/**
 */
function getManagedCompetitionDetails($requestConnectTeamID){
    global $conn;
    $item = new \stdClass();
    $item->competition= "";
    $item->season= "";
      
    $q = "select managedcompetition.id as id, managedcompetition.description as competition, managedcompetitionseason.description as season from team,managedcompetition,managedcompetitionseason where team.id=".$requestConnectTeamID." and team.managedCompetitieID = managedcompetition.id and managedcompetition.managedCompetitionSeasonID = managedcompetitionseason.id"; 
    $result = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    if ($num == 0)
        return null;// no team found    
    $item->competition = mysql_result($result, 0, "competition");           
    $item->season = mysql_result($result, 0, "season");
    $item->id = mysql_result($result, 0, "id");
    return $item;
}


/**
 */
function findMasterCompetition($mTeamID){
    global $conn;
      
    $q = "select id from competition where teamID=".$mTeamID; 
    $result = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    if ($num == 0)
        return -1;    
    return mysql_result($result, 0, "id");           
}

/**
 */
function getGamesFromCompetition($competitionID){    
    global $conn;
    $array = array();
    
    $query = "SELECT * FROM games where competitionID='" . $competitionID . "' ";
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    while ($i < $num) {
        $item = new \stdClass();
        $item -> id = mysql_result($result, $i, "id");
        $item -> gamedate = mysql_result($result, $i, "datetime");
        $item -> opponent = mysql_result($result, $i, "opponent");
        $item -> homegame = mysql_result($result, $i, "homegame");
        $item -> score = mysql_result($result, $i, "score");
        $item -> points = mysql_result($result, $i, "points");
        $item -> gameType = mysql_result($result, $i, "gameType");
        $item -> gameStatus = mysql_result($result, $i, "gameStatus");
        $item -> mGameID = mysql_result($result, $i, "mGameID");
        $item -> teamID = mysql_result($result, $i, "teamID");
        $item -> gameUID = mysql_result($result, $i, "gameUID");
        $item -> competitionID = $competitionID;
                
        if ($item -> points==null) $item -> points = 0;
        if ($item -> score==null) $item -> score = "";
        $array[] = $item;
        $i++;
    }
    return $array;
}

/**
 */
function getManagedGames($mTeamID){    
    global $conn;
    $array = array();
    
    // Search home games
    $query = "SELECT managedgames.id,managedgames.gameUID,managedgames.datetime,managedgames.location,managedgames.score,managedgames.gameUID,team.teamname as opponent FROM managedgames,team where teamID1=" . $mTeamID." and teamID2=team.id";
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    while ($i < $num) {
        $item = new \stdClass();
        $item -> id = mysql_result($result, $i, "managedgames.id");
        $item -> gamedate = mysql_result($result, $i, "managedgames.datetime");
        $item -> opponent = mysql_result($result, $i, "opponent");
        $item -> gameUID = mysql_result($result, $i, "gameUID");
        $item -> homegame = 1;
        $item -> score = mysql_result($result, $i, "managedgames.score");
        $item -> points = 0;
                
        if ($item -> points==null) $item -> points = 0;
        if ($item -> score==null) $item -> score = "";
        $array[] = $item;
        $i++;
    }
    
    // Search not-home games
    $query = "SELECT managedgames.id,managedgames.gameUID,managedgames.datetime,managedgames.location,managedgames.score,managedgames.gameUID,team.teamname as opponent FROM managedgames,team where teamID2=" . $mTeamID." and teamID1=team.id";
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    while ($i < $num) {
        $item = new \stdClass();
        $item -> id = mysql_result($result, $i, "managedgames.id");
        $item -> gamedate = mysql_result($result, $i, "managedgames.datetime");
        $item -> opponent = mysql_result($result, $i, "opponent");
        $item -> gameUID = mysql_result($result, $i, "gameUID");
        $item -> homegame = 0;
        $item -> score = mysql_result($result, $i, "managedgames.score");
        $item -> points = 0;
                
        if ($item -> points==null) $item -> points = 0;
        if ($item -> score==null) $item -> score = "";
        $array[] = $item;
        $i++;
    }
        
    return $array;
}


/**
 */
function removeGame($gameID) {
    global $conn;
    $array = array();
    $query = "DELETE FROM games where id='" . $gameID."'";
    \dbcalls\logSQL($query,"deleteGame", 0);
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
}

/**************************************************
 */
function addGame($teamID, $game,$competitionID) {
    global $conn;
    $teamID = $teamID;
    $gameDate = $game -> gamedate;
    $gameOpponent = $game -> opponent;
    $homegame = $game-> homegame;
    if ($homegame=='') $homegame = '0';
    $mGameID = $game-> id;
    $gameUID = mysql_real_escape_string($game->gameUID);

    $gameOpponent = mysql_real_escape_string($gameOpponent);    
    $q = "INSERT INTO games (`datetime`,`opponent`,`competitionID`,`teamID`,`homegame`,`mGameID`,`gameUID`) VALUES ".
    "('$gameDate','$gameOpponent','$competitionID','$teamID',$homegame, $mGameID,'$gameUID')";
    \dbcalls\logSQL($q,"add game", 0);
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $teamID = mysql_insert_id();

    return $teamID;
}


function syncScores($competitionID){
    global $conn;
    // sync score
    $query = "UPDATE games SET score = (SELECT DISTINCT(score) FROM managedgames WHERE managedgames.id=games.mGameID ) where games.competitionID=".$competitionID;
    \dbcalls\logSQL($query,"update all games from managedgames for competition ".$competitionID, 0);
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    
    // sync date/time
    $query = "UPDATE games SET datetime = (SELECT DISTINCT(datetime) FROM managedgames WHERE managedgames.id=games.mGameID ) where games.competitionID=".$competitionID;
    \dbcalls\logSQL($query,"update all games from managedgames for competition ".$competitionID, 0);
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    
    
}

 
/****************************************************************************************************************
 **************************************************************************************************************** 
 */
function createTeamIfNeeded($userID,$requestConnectTeamID){
   global $conn;

    //*********************************************
    // find userID,name and requestConnectTeam
    $result = getUserDetails($userID);
    if ($result==null) return;// no user found  
    $name = $result->name;           
    //*********************************************
    // return if $requestConnectTeamID = 0;
    if ($requestConnectTeamID==0) return; // there is no team to connect
                              
    //*********************************************
    // find all competitions of this user and check if there is a competition that is connected to requestConnectTeam
    $result = getRequestedCompetitionDetails($userID,$requestConnectTeamID);
    if ($result!=null) return;// there already is a competition for this user that is connected to this team. Return here
    
        //*********************************************
    // check if there is already a team, then use that team
    // the user is not connected to that team, otherwise this team would be returned
    // by the previous call (getRequestedCompetitionDetails)
    $newTeamID = findTeamConnectedToAnonymousTeam($requestConnectTeamID);
    
    if ($newTeamID!=-1){
        // add this user to this team
        \dbcalls\addNewTeamMember($newTeamID, $userID, $name);
    }
    else{
        //*********************************************
        // find the name of the team of requestConnectTeam
        $result = getTeamname($requestConnectTeamID);
        if ($result==null) return;
        $teamname = $result->teamname;           
        
        //*********************************************
        // create a new team with the name of requestConnectTeam
        $newTeamID = newTeam($teamname);
        
        connectTeam($userID, $name, $newTeamID,$requestConnectTeamID, true);
    }
}



/****************************************************************************************************************
 **************************************************************************************************************** 
 */
function connectTeam($userID, $username, $teamID,$requestConnectTeamID, $addUser){
   global $conn;

    //*********************************************
    // find all competitions of this user and check if there is a competition that is connected to requestConnectTeam
    $result = getRequestedCompetitionDetails($userID,$requestConnectTeamID);
    if ($result!=null) return;// there already is a competition for this user that is connected to this team. Return here 

    //*********************************************
    // find the season and competition name of requestConnectTeam
    $result = getManagedCompetitionDetails($requestConnectTeamID);
    if ($result==null) return;
    $competition = $result->competition;           
    $season = $result->season;
    $managedCompetitionID = $result->id;
    
    //*********************************************
    // create a new competition with the name of the season and competition name of requestConnectTeam 
    $competitionID = newCompetition($requestConnectTeamID,$teamID,$competition,$season,$managedCompetitionID);
    
    //*********************************************
    // create a new teammember
    if ($addUser){
        $teammemberID = newTeammember($teamID,$userID,$username);
    }
    
    //*********************************************
    // sync the competition
    syncCompetition($competitionID);
}



/**
 */
function syncAllManagedCompetitions(){
    global $conn;
    $query = "SELECT id,teamID,mTeamID FROM competition where mTeamID!=0";
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    while ($i < $num) {
        $teamID = mysql_result($result, $i, "teamID");
        $mTeamID = mysql_result($result, $i, "mTeamID");
        $competitionID = mysql_result($result, $i, "id");
        syncCompetition($competitionID);
        $i++;
    }
}


function syncCompetition($targetCompetitionID){
    global $conn;
    // find teamID and mTeamID    
    $result = getCompetitionDetails($targetCompetitionID);
    if ($result==null) return;// no competition found
    $teamID = $result->teamID;
    $mTeamID = $result->mTeamID;
    
        
    // find all managed games that belong to the mTeam
    $managedGames = getManagedGames($mTeamID);    
    
    // get target games for the normal competition
    $targetGames = getGamesFromCompetition($targetCompetitionID); 
    syncCompetitionGames($teamID, $managedGames,$targetGames,$targetCompetitionID);

    // update the score for all games
    syncScores($targetCompetitionID);  
     
}


function syncCompetitionGames($teamID, $managedGames,$competitionGames,$competitionID){
    // find all competition games that do not have a corresponding game in the managed games list
    $gamesToRemove = array();
    foreach ($competitionGames as $competitionGame) {
        $found = false;
        foreach ($managedGames as $managedGame) {
            if ($managedGame->gameUID == $competitionGame->gameUID){
                $found = true;
            }
        }
        if (!$found){
            $gamesToRemove[] = $competitionGame;
        }
    }    
    
    
    // find all competition games that do not have an entry in the managed games list
    $gamesToAdd = array();
    foreach ($managedGames as $managedGame) {
        $found = false;
        foreach ($competitionGames as $competitionGame) {
            if ($managedGame->gameUID == $competitionGame->gameUID){
                $found = true;
            }
        }
        if (!$found){
            $gamesToAdd[] = $managedGame;
        }
    }    

    // remove these competition games
    foreach ($gamesToRemove as $gameToRemove) {
        removeGame($gameToRemove->id);
    }
    

    
    // create new games and add to the competition
    foreach ($gamesToAdd as $gameToAdd) {
        addGame($teamID,$gameToAdd,$competitionID);
    }
}


