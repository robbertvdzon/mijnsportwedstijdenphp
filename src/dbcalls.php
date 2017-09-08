<?
namespace dbcalls;

/* Include Files *********************/
include_once ("database.php");
/*************************************/


/**************************************************
 */
function logSQL($sql,$description, $type) {
    global $conn;
    $username = getSessionUserName();
    logSQL2($sql,$description, $type, $username);
}

/**************************************************
 */
function logSQLExtra($sql,$description, $type, $gameID, $teamID, $userID, $memberID) {
    global $conn;
    $username = getSessionUserName();
    logSQL3($sql,$description, $type, $username, $gameID, $teamID, $userID, $memberID);
}

/**************************************************
 */
function logSQL2($sql,$description, $type, $username) {
    global $conn;
    logSQL3($sql,$description, $type, $username, 0, 0, 0, 0);
}

/**************************************************
 */
function logSQL3($sql,$description, $type, $username, $gameID, $teamID, $userID, $memberID){
    global $conn;
    $sql = mysql_real_escape_string($sql);
    $username = mysql_real_escape_string($username);
    $description = mysql_real_escape_string($description);
//    $q = "INSERT INTO log (`username` , `date`, `time`, `statement`, `type`, `description`,`gameID`,`teamID`,`userID`,`memberID`) VALUES ('".$username."',CURDATE(), NOW() ,'".$sql."',".$type.",'".$description."')";
    
    $q = "INSERT INTO log (`username` , `date`, `time`, `statement`, `type`, `description`,`gameID`,`teamID`,`userID`,`memberID`) VALUES ('".$username."',CURDATE(), NOW() ,'".$sql."',".$type.",'".$description."','".$gameID."','".$teamID."','".$userID."','".$memberID."')";
    
    
    

    
    
    
    
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
}


/**************************************************
 */
function clearOrphanData() {
    
    // managedcompetitionorganisation:
    // wis als userID niet bestaat in users
    performSQL("delete from managedcompetitionorganisation where userID not in (select id from users)"); 

    // managedcompetitionseason:
    // wis als managedCompetitionOrganisationID niet bestaat in managedcompetitionorganisation
    performSQL("delete from managedcompetitionseason where managedCompetitionOrganisationID not in (select id from managedcompetitionorganisation)"); 

    // managedcompetition:
    // wis als managedCompetitionSeasonID niet bestaat in managedcompetitionseason
    performSQL("delete from managedcompetition where managedCompetitionSeasonID not in (select id from managedcompetitionseason)"); 

    // playround
    // wis als managedCompetitionID niet bestaat in managedcompetition
    performSQL("delete from playround where managedCompetitionID not in (select id from managedcompetition)"); 

    // managedgames
    // wis als playroundID niet bestaat in playround
    performSQL("delete from managedgames where playroundID not in (select id from playround)"); 

    // team:
    // wis als managedCompetitieID niet bestaat in managedcompetition
    performSQL("delete from team where managedCompetitieID not in (select id from managedcompetition) and managedCompetitieID<>0");

    // competition:
    // als mTeamID niet bestaat: dan op 0 zetten
    // als mCompetition niet bestaat: dan op 0 zetten
    // wis als teamID niet bestaat
    performSQL("delete from competition where teamID not in (select id from team)");
    performSQL("update competition  set mTeamID=0 where mTeamID not in (select id from team) and mTeamID<>0");
    performSQL("update competition  set mCompetition=0 where mCompetition not in (select id from managedcompetition) and mCompetition<>0");

    // games:
    // - wis als mGameID niet bestaat in managedgames (behalve als mGameID==0)
    // - wis als competitionID niet bestaat in competition
    // - wis als teamID niet bestaat in competition
    performSQL("update games set mGameID = 0 where mGameID not in (select id from managedgames) and mGameID<>0");
    performSQL("delete from games where teamID not in (select id from team)");
    performSQL("delete from games where competitionID not in (select id from competition)");

    // teammember:
    // - wis als teamID niet bestaat
    // - wis als userID niet bestaat
    performSQL("delete from teammember where teamID not in (select id from team)"); 
    performSQL("delete from teammember where userID not in (select id from users)"); 
    
    return true;
}

/**************************************************
 */
function performSQL($q) {
    global $conn;
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
}

/**************************************************
 */
function checkAnonymousTeam($teamid) {
    global $conn;

    $q = "select managedCompetitieID from team where id = '$teamid'";
    $result = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    if ($num == 0)
        return false;
    $managedCompetitionID = mysql_result($result, 0, "managedCompetitieID");     
    $anonymous = $managedCompetitionID!=0;   
    return $anonymous;
}




/**************************************************
 */
function teamnameTaken($teamname) {
	global $conn;
	if (!get_magic_quotes_gpc()) {
		$username = addslashes($teamname);
	}
	$q = "select teamname from team where teamname = '$teamname'";
	$result = mysql_query($q, $conn);
	if (mysql_errno()) {
		throw new \Exception(mysql_error());
	}
	return (mysql_numrows($result) > 0);
}

/**************************************************
 */
function getSessionUserName() {
	global $conn;
	if (!isset($_SESSION['username']))
		return "";
	$username = $_SESSION['username'];
	return $username;
}
 
/**************************************************
 */
function getUserID($username) {
	global $conn;
	$q = "select id from users where username = '".mysql_real_escape_string($username)."'";
	$res = mysql_query($q, $conn);
	$num = mysql_numrows($res);
	if ($num == 0)
		return -1;
	$userID = mysql_result($res, 0);
	if (mysql_errno()) {
		throw new \Exception(mysql_error());
	}
	return $userID;
}

/**************************************************
 */
function getProUser($userID) {
    global $conn;
    $q = "select proUser from users where id = ".$userID;
    $res = mysql_query($q, $conn);
    $num = mysql_numrows($res);
    if ($num == 0)
        return -1;
    $proUser = mysql_result($res, 0);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    return $proUser;
}


/**************************************************
 */
function getProEndDate($userID) {
    global $conn;
    $q = "select endProDate from users where id = ".$userID;
    $res = mysql_query($q, $conn);
    $num = mysql_numrows($res);
    if ($num == 0)
        return -1;
    $endProDate = mysql_result($res, 0);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    return $endProDate;
}

/**************************************************
 */
function setProEndDate($userID, $endDate) {
    global $conn;
    $q = "UPDATE users SET endProDate='".$endDate."' WHERE id = '$userID';";
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }    
}


/**************************************************
 */
function getUserData($userID) {
    global $conn;
    $item = new \stdClass();
    
    if ($userID==-99){
        // this is the anonymous user
        $item -> id = -99;
        $item -> email = "";
        $item -> name = "Anoniem";
        $item -> username = "anoniem";
        $item -> phonenumber = "";
        return $item;
    }
    
    
    $q = "select * from users where id = '$userID'";
    $result = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    if ($num == 0) {
        return null;
    }
    $item -> id = mysql_result($result, 0, "id");
    $item -> email = mysql_result($result, 0, "email");
    $item -> name = mysql_result($result, 0, "name");
    $item -> username = mysql_result($result, 0, "username");
    $item -> phonenumber = mysql_result($result, 0, "phonenumber");
    
    return $item;
}


/**************************************************
 */
function saveUser($userID,$name,$email,$phonenumber) {
    global $conn;
    $email = mysql_real_escape_string($email);
    $name = mysql_real_escape_string($name);
    $phonenumber = mysql_real_escape_string($phonenumber);
        
    $q = "UPDATE users SET email='$email' , name='$name', phonenumber='$phonenumber'".
    "  WHERE id = '$userID';";
    logSQLExtra($q,"saveUser", 0,0,0,$userID,0);
    
    
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }    
}


/**************************************************
 */
function getUsername($userID) {
	global $conn;
	$q = "select * from users where id = '$userID'";
	$result = mysql_query($q, $conn);
	if (mysql_errno()) {
		throw new \Exception(mysql_error());
	}
	$num = mysql_numrows($result);
	if ($num == 0) {
		throw new \Exception(/*T1077T*/"gebruiker niet gevonden"/*T1077T*/);
		return null;
	}
	$name = mysql_result($result, 0, "username");
	if ($name == null) {
		$name = mysql_result($result, 0, "id");
	}
	return $name;
}


/**************************************************
 */
function getName($userID) {
    global $conn;
    $q = "select * from users where id = '$userID'";
    $result = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    if ($num == 0) {
        throw new \Exception(/*T1078T*/"gebruiker niet gevonden"/*T1078T*/);
        return null;
    }
    $name = mysql_result($result, 0, "name");
    return $name;
}

/**************************************************
 */
function addNewManagedOrganisation($org, $userID) {
    global $conn;
    $q = "INSERT INTO managedcompetitionorganisation (`userID` , `description`) VALUES ($userID,'".mysql_real_escape_string($org)."')";
    logSQLExtra($q,"add managedcompetitionorganisation", 0,0,0,$userID,0);
    

    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $id = mysql_insert_id();
    return $id;
}

/**************************************************
 */
function addNewManagedSeason($season, $orgID) {
    global $conn;
    $q = "INSERT INTO managedcompetitionseason (`managedCompetitionOrganisationID` , `description`) VALUES ($orgID,'".mysql_real_escape_string($season)."')";
    logSQL($q,"add managedcompetitionseason", 0);

    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $id = mysql_insert_id();
    return $id;
}

/**************************************************
 */
function addNewManagedCompetition($compName, $seasonID) {
    global $conn;
    $q = "INSERT INTO managedcompetition (`managedCompetitionSeasonID` , `description`) VALUES ($seasonID,'".mysql_real_escape_string($compName)."')";
    logSQL($q,"add managedcompetition", 0);

    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $id = mysql_insert_id();
    return $id;
}



/**************************************************
 */
function addNewTeamMember($teamID, $userID, $nickname) {
	global $conn;

    // check if there is already a teammember with admin rights 
    $array = array();
    $query = "SELECT * FROM teammember where teammember.teamID=$teamID and admin=1";
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
    $teamID.",".
    $userID.",".
    "'".mysql_real_escape_string($nickname)."',".
    $adminRights.")";
    \dbcalls\logSQL($q,"add teammember", 0);
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    return mysql_insert_id();


/*
	$q = "INSERT INTO teammember (`teamID` , `userID`, `nickname`, `admin`) VALUES ($teamID,$userID,'".mysql_real_escape_string($nickname)."','1')";
    logSQLExtra($q,"add user", 0,0,$teamID,$userID,0);

	$res = mysql_query($q, $conn);
	if (mysql_errno()) {
		throw new \Exception(mysql_error());
	}
	$id = mysql_insert_id();
	return $id;

 */ 
 }

/**************************************************
 */
function addNewTeam($teamname, $userID) {
	global $conn;

	// check if user exists and get hist name
	$name = getUsername($userID);
	if ($name == null)
		return;

	// insert team
	$q = "INSERT INTO team (`teamname`) VALUES ('".mysql_real_escape_string($teamname)."')";
    logSQLExtra($q,"add team", 0,0,0,$userID,0);
	$res = mysql_query($q, $conn);
	if (mysql_errno()) {
		throw new \Exception(mysql_error());
	}
	$teamID = mysql_insert_id();

	// insert teammember
	addNewTeamMember($teamID, $userID, $name);
    
    // insert new season
    addCompetition($teamID, date("Y"),"competitie", 0);

	return $teamID;
}


/**************************************************
 */
function loadTeam($teamID) {
    global $conn;
    $item = new \stdClass();
    
    $q = "select * from team where id = '$teamID'";
    $result = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    if ($num == 0) {
        return $item;
    }

    $item -> id = mysql_result($result, 0, "id");
    $item -> teamname = mysql_result($result, 0, "teamname");
    $item -> vereniging = mysql_result($result, 0, "vereniging");
    $item -> sport = mysql_result($result, 0, "sport");
    $item -> voorkeursNrAanwezig = mysql_result($result, 0, "voorkeursNrAanwezig");
    $item -> reminderDays = mysql_result($result, 0, "reminderDays");
    $item -> tekortMailTo = mysql_result($result, 0, "tekortMailTo");
    $item -> waarschuwingMailTo = mysql_result($result, 0, "waarschuwingMailTo");
    $item -> waarschuwingMailDagen = mysql_result($result, 0, "waarschuwingMailDagen");    
    $item -> listname1 = mysql_result($result, 0, "listname1");
    $item -> listname2 = mysql_result($result, 0, "listname2");
    $item -> listname3 = mysql_result($result, 0, "listname3");
    $item -> listname4 = mysql_result($result, 0, "listname4");
    $item -> listname5 = mysql_result($result, 0, "listname5");
    $item -> listname6 = mysql_result($result, 0, "listname6");
    $item -> listname7 = mysql_result($result, 0, "listname7");
    $item -> listname8 = mysql_result($result, 0, "listname8");
    $item -> listname9 = mysql_result($result, 0, "listname9");
    $item -> listname10 = mysql_result($result, 0, "listname10");
    $item -> listtype1 = mysql_result($result, 0, "listtype1");
    $item -> listtype2 = mysql_result($result, 0, "listtype2");
    $item -> listtype3 = mysql_result($result, 0, "listtype3");
    $item -> listtype4 = mysql_result($result, 0, "listtype4");
    $item -> listtype5 = mysql_result($result, 0, "listtype5");
    $item -> listtype6 = mysql_result($result, 0, "listtype6");
    $item -> listtype7 = mysql_result($result, 0, "listtype7");
    $item -> listtype8 = mysql_result($result, 0, "listtype8");
    $item -> listtype9 = mysql_result($result, 0, "listtype9");
    $item -> listtype10 = mysql_result($result, 0, "listtype10");
    if ($item -> vereniging==null) $item -> vereniging = ""; 
    if ($item -> sport==null) $item -> sport = ""; 
    return $item;
}




/**************************************************
 */
function saveTeam($teamID, $teamname, $vereniging, $sport, $voorkeursNrAanwezig, $reminderDays, $tekortMailTo, $waarschuwingMailTo, $waarschuwingMailDagen) {
    global $conn;

    $teamname = mysql_real_escape_string($teamname); 
    $vereniging = mysql_real_escape_string($vereniging); 
    $sport = mysql_real_escape_string($sport); 
    $voorkeursNrAanwezig = mysql_real_escape_string($voorkeursNrAanwezig); 
    $reminderDays = mysql_real_escape_string($reminderDays); 
    $tekortMailTo = mysql_real_escape_string($tekortMailTo); 
    $waarschuwingMailTo = mysql_real_escape_string($waarschuwingMailTo); 
    $waarschuwingMailDagen = mysql_real_escape_string($waarschuwingMailDagen);
        
    $q = "UPDATE team SET ".
    "teamname='$teamname'".
    ", vereniging='$vereniging'".
    ", sport='$sport'".
    ", voorkeursNrAanwezig='$voorkeursNrAanwezig'".
    ", reminderDays='".$reminderDays."'".
    ", tekortMailTo='".$tekortMailTo."'".
    ", waarschuwingMailTo='".$waarschuwingMailTo."'".
    ", waarschuwingMailDagen='".$waarschuwingMailDagen."'".    
    "  WHERE id = '$teamID';";
    logSQLExtra($q,"saveTeam", 0,0,$teamID,0,0);
    
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
}


/**************************************************
 */
function loadTeams($userID) {
    global $conn;
    $array = array();
    $query = "SELECT team.* FROM team,teammember where teammember.userID=$userID and team.id=teammember.teamID and (teammember.deleted=0 || teammember.deleted is NULL)";
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    while ($i < $num) {
        $teamname = mysql_result($result, $i, "teamname");
        $teamid = mysql_result($result, $i, "team.id");
        $item = new \stdClass();
        $item -> id = $teamid;
        $item -> teamname = $teamname;
        $item -> listname1 = mysql_result($result, $i, "team.listname1");
        $item -> listname2 = mysql_result($result, $i, "team.listname2");
        $item -> listname3 = mysql_result($result, $i, "team.listname3");
        $item -> listname4 = mysql_result($result, $i, "team.listname4");
        $item -> listname5 = mysql_result($result, $i, "team.listname5");
        $item -> listname6 = mysql_result($result, $i, "team.listname6");
        $item -> listname7 = mysql_result($result, $i, "team.listname7");
        $item -> listname8 = mysql_result($result, $i, "team.listname8");
        $item -> listname9 = mysql_result($result, $i, "team.listname9");
        $item -> listname10 = mysql_result($result, $i, "team.listname10");
        $item -> listtype1 = mysql_result($result, $i, "team.listtype1");
        $item -> listtype2 = mysql_result($result, $i, "team.listtype2");
        $item -> listtype3 = mysql_result($result, $i, "team.listtype3");
        $item -> listtype4 = mysql_result($result, $i, "team.listtype4");
        $item -> listtype5 = mysql_result($result, $i, "team.listtype5");
        $item -> listtype6 = mysql_result($result, $i, "team.listtype6");
        $item -> listtype7 = mysql_result($result, $i, "team.listtype7");
        $item -> listtype8 = mysql_result($result, $i, "team.listtype8");
        $item -> listtype9 = mysql_result($result, $i, "team.listtype9");
        $item -> listtype10 = mysql_result($result, $i, "team.listname10");

        $array[] = $item;
        $i++;
    }
    return $array;
}

/**************************************************
 */
function loadTeams2($userID,$anonymousTeam,$anonymousTeamID) {
	global $conn;
	$array = array();
	$query = "SELECT team.teamname, team.id FROM team,teammember where teammember.userID=$userID and team.id=teammember.teamID and (teammember.deleted=0 || teammember.deleted is NULL)";
	$result = mysql_query($query, $conn);
	if (mysql_errno()) {
		throw new \Exception(mysql_error());
	}
	$num = mysql_numrows($result);
	$i = 0;
	$anonymousTeamIDFound = false;
	while ($i < $num) {
		$teamname = mysql_result($result, $i, "teamname");
		$teamid = mysql_result($result, $i, "team.id");
		$item = new \stdClass();
		$item -> id = $teamid;
		$item -> teamname = $teamname;
		$array[] = $item;
		$i++;
        if ($teamid==$anonymousTeamID) $anonymousTeamIDFound = true;
	}
	
	
	// If needed, add the anonymousTeam to the list!!!
	if ($anonymousTeam && !$anonymousTeamIDFound){
        $query = "SELECT team.teamname, team.id  FROM team where team.id=$anonymousTeamID";
        $result = mysql_query($query, $conn);
        if (mysql_errno()) {
            throw new \Exception(mysql_error());
        }
        $num = mysql_numrows($result);
        $i = 0;
        while ($i < $num) {
            $teamname = mysql_result($result, $i, "teamname");
            $teamid = mysql_result($result, $i, "team.id");
            $item = new \stdClass();
            $item -> id = $teamid;
            $item -> teamname = $teamname;
            $array[] = $item;
            $i++;
        }
    }
	
	return $array;
}

/**************************************************
 */
function loadGames($competitionID) {
    global $conn;
    $array = array();
    $query = "";
    $query .= "(SELECT *, 0 as teamID1, 0 as teamID2 FROM games where competitionID='" . $competitionID . "' and games.mGameID = 0)";
    $query .= " UNION ";
    $query .= "(SELECT games.*,managedgames.teamID1 as teamID1,managedgames.teamID2 as teamID2 FROM games,managedgames where competitionID=" . $competitionID . " and games.mGameID =managedgames.id order by games.datetime )";   
    $query .= " order by datetime";
    
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    while ($i < $num) {
        $gamedate = mysql_result($result, $i, "datetime");
        $gameid = mysql_result($result, $i, "id");
        $opponent = mysql_result($result, $i, "opponent");
        
        $item = new \stdClass();
        $item -> id = $gameid;
        $item -> gamedate = $gamedate;
        $item -> opponent = $opponent;
        $item -> homegame = mysql_result($result, $i, "homegame");
        $item -> teamID1 = mysql_result($result, $i, "teamID1");
        $item -> teamID2 = mysql_result($result, $i, "teamID2");
        $item -> mGameID = mysql_result($result, $i, "mGameID");
//        $item -> membersPresentUnknown = mysql_result($result, $i, "membersPresentUnknown");
        $item -> membersPresentYes = mysql_result($result, $i, "membersPresentYes");
        $item -> membersPresentNo = mysql_result($result, $i, "membersPresentNo");
        $item -> score = mysql_result($result, $i, "score");
        $item -> points = mysql_result($result, $i, "points");
        $item -> gameType = mysql_result($result, $i, "gameType");
        $item -> gameStatus = mysql_result($result, $i, "gameStatus");
        if ($item -> points==null) $item -> points = 0;
        if ($item -> score==null) $item -> score = "";
        $array[] = $item;
        $i++;
    }
    return $array;
}

/**************************************************
 */
function loadMTeamGames($teamID) {
    global $conn;
    
    $daysfWeek = array(
    /*T1079T*/
    0 => "zondag",
    1 => "maandag",
    2 => "dinsdag",
    3 => "woensdag",
    4 => "donderdag",
    5 => "vrijdag",
    6 => "zaterdag");    
    /*T1079T*/
    
    $array = array();
    $query = "select * from managedgames,playround where (teamID1=".$teamID." or teamID2=".$teamID.") and playroundID = playround .id order by datetime";
    
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $managedCompetitionID = 0;// save the competitionID (should be the same for all games)
    $i = 0;
    while ($i < $num) {
        $gamedate = mysql_result($result, $i, "datetime");
        $item = new \stdClass();
        $managedCompetitionID = mysql_result($result, $i, "managedCompetitionID");
        $item -> id = mysql_result($result, $i, "managedgames.id");
        $item -> gamedate = $gamedate;
        $dateStr =   date('d-m-Y', $gamedate-date("Z",$gamedate)); 
        $timeStr =   date('H:i', $gamedate-date("Z",$gamedate));
        $dayOfWeek =   $daysfWeek[date('w', $gamedate-date("Z",$gamedate))]; 
        $item -> dateTimeStr = $dayOfWeek." ".$dateStr." ".$timeStr;
        $item -> teamID1 = mysql_result($result, $i, "teamID1");
        $item -> teamID2 = mysql_result($result, $i, "teamID2");
        $item -> score = mysql_result($result, $i, "score");
        $array[] = $item;
        $i++;
    }
    
    // now search all the team names for this competition
    $teamarray = array();
    $query = "select * from team where managedCompetitieID = ".$managedCompetitionID;
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    while ($i < $num) {
        $teamid = mysql_result($result, $i, "team.id");
        $teamname = mysql_result($result, $i, "team.teamname");
        $teamarray[$teamid] = $teamname; 
        $i++;
    }
    
    // connect the team names to the games
    foreach ($array as $game) {
        $game->teamname1 = $teamarray[$game->teamID1];
        $game->teamname2 = $teamarray[$game->teamID2];
    }       
    
    return $array;
}


/**************************************************
 */
function deleteGame($gameID) {
    global $conn;
    $array = array();
    $query = "DELETE FROM games where id='" . $gameID."'";
    logSQLExtra($query,"deleteGame", 0,$gameID,0,0,0);
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
}


/**************************************************
 */
function findCorrespondingTeam($teamID,$userID) {
    global $conn;
    if ($teamID!=="") {
        $query = "select competition.teamID from competition,team,teammember where mTeamID = ".$teamID." and competition.teamID = team.id and teammember.userID=".$userID." and team.id=teammember.teamID and (teammember.deleted=0 || teammember.deleted is NULL)";
        $result = mysql_query($query, $conn);
        if (mysql_errno()) {
            return $teamID;// return given teamID
        }
        $num = mysql_numrows($result);
        if ($num>0){
            $found = mysql_result($result, 0, "teamID");
            return mysql_result($result, 0, "teamID");
        }
    }
    
    return $teamID;
}


/**************************************************
 */
function findFirstUpcomingGame($teamID) {
    global $conn;

    $item = new \stdClass();
    $item -> id = -1;
    $item -> gameID = -1;
    $item -> competitionID = -1;

    $array = array();
    if ($teamID!=="") {
        $now = time();

        $query = "select * from games,competition where games.competitionID = competition.id and games.datetime > ".$now." and competition.teamID=".$teamID." order by games.datetime";
        $result = mysql_query($query, $conn);
        if (mysql_errno()) {
            throw new \Exception(mysql_error());
        }
        $num = mysql_numrows($result);
        if ($num>0){
            $item -> id = mysql_result($result, 0, "games.id");
            $item -> gameID = mysql_result($result, 0, "games.id");
            $item -> competitionID = mysql_result($result, 0, "games.competitionID");
            $item -> homegame = mysql_result($result, 0, "games.homegame");
//            $item -> membersPresentUnknown = mysql_result($result, 0, "games.membersPresentUnknown");
            $item -> membersPresentYes = mysql_result($result, 0, "games.membersPresentYes");
            $item -> membersPresentNo = mysql_result($result, 0, "games.membersPresentNo");
            $item -> score = mysql_result($result, 0, "games.score");
            $item -> points = mysql_result($result, 0, "games.points");
            $item -> gameType = mysql_result($result, 0, "games.gameType");
            $item -> gameStatus = mysql_result($result, 0, "games.gameStatus");
            if ($item -> points==null) $item -> points = 0;
            if ($item -> score==null) $item -> score = "";
        }
    }
    return $item;
}



/**************************************************
 */
function loadGame($gameID) {
	global $conn;
	$item = new \stdClass();
	//$query = "SELECT * FROM games,team where games.teamID=team.id and games.id='" . $gameID . "'";
    $query = "";
    $query .= "(SELECT games.*,team.*,0 as teamID1, 0 as teamID2 FROM games,team where games.teamID=team.id and games.id='" . $gameID . "'  and games.mGameID =0)";
    $query .= " UNION ";
    $query .= "(SELECT games.*,team.*,managedgames.teamID1 as teamID1,managedgames.teamID2 as teamID2 FROM games,team,managedgames where games.teamID=team.id and games.id=" . $gameID . " and games.mGameID =managedgames.id)";
    
    
	$result = mysql_query($query, $conn);
	if (mysql_errno()) {
		throw new \Exception(mysql_error());
	}
	$num = mysql_numrows($result);
	if ($num > 0) {
        $item -> id = mysql_result($result, 0, "id");
        $item -> competitionID = mysql_result($result, 0, "competitionID");

        $item -> teamID1 = mysql_result($result, 0, "teamID1");
        $item -> teamID2 = mysql_result($result, 0, "teamID2");
        $item -> mGameID = mysql_result($result, 0, "mGameID");
        
        $item -> opponent = mysql_result($result, 0, "opponent");
        $item -> messages = mysql_result($result, 0, "messages");
		$item -> gamedate = mysql_result($result, 0, "datetime");
//        $item -> membersPresentUnknown = mysql_result($result, 0, "games.membersPresentUnknown");
        $item -> membersPresentYes = mysql_result($result, 0, "membersPresentYes");
        $item -> membersPresentNo = mysql_result($result, 0, "membersPresentNo");
        $item -> goals = mysql_result($result, 0, "goals");
        $item -> homegame = mysql_result($result, 0, "homegame");
        $item -> meetingpoint = mysql_result($result, 0, "meetingpoint");
        $item -> score = mysql_result($result, 0, "score");
        $item -> membersPresentYes = mysql_result($result, 0, "membersPresentYes");
        $item -> points = mysql_result($result, 0, "points");
        $item -> gameType = mysql_result($result, 0, "gameType");
        $item -> gameStatus = mysql_result($result, 0, "gameStatus");
        if ($item -> points==null) $item -> points = 0;
        if ($item -> score==null) $item -> score = "";
        
        $item -> list1 = mysql_result($result, 0, "list1");
        $item -> list2 = mysql_result($result, 0, "list2");
        $item -> list3 = mysql_result($result, 0, "list3");
        $item -> list4 = mysql_result($result, 0, "list4");
        $item -> list5 = mysql_result($result, 0, "list5");
        $item -> list6 = mysql_result($result, 0, "list6");
        $item -> list7 = mysql_result($result, 0, "list7");
        $item -> list8 = mysql_result($result, 0, "list8");
        $item -> list9 = mysql_result($result, 0, "list9");
        $item -> list10 = mysql_result($result, 0, "list10");
                
        $item -> listname1 = mysql_result($result, 0, "listname1");
        $item -> listname2 = mysql_result($result, 0, "listname2");
        $item -> listname3 = mysql_result($result, 0, "listname3");
        $item -> listname4 = mysql_result($result, 0, "listname4");
        $item -> listname5 = mysql_result($result, 0, "listname5");
        $item -> listname6 = mysql_result($result, 0, "listname6");
        $item -> listname7 = mysql_result($result, 0, "listname7");
        $item -> listname8 = mysql_result($result, 0, "listname8");
        $item -> listname9 = mysql_result($result, 0, "listname9");
        $item -> listname10 = mysql_result($result, 0, "listname10");
                
        $item -> listtype1 = mysql_result($result, 0, "listtype1");
        $item -> listtype2 = mysql_result($result, 0, "listtype2");
        $item -> listtype3 = mysql_result($result, 0, "listtype3");
        $item -> listtype4 = mysql_result($result, 0, "listtype4");
        $item -> listtype5 = mysql_result($result, 0, "listtype5");
        $item -> listtype6 = mysql_result($result, 0, "listtype6");
        $item -> listtype7 = mysql_result($result, 0, "listtype7");
        $item -> listtype8 = mysql_result($result, 0, "listtype8");
        $item -> listtype9 = mysql_result($result, 0, "listtype9");
        $item -> listtype10 = mysql_result($result, 0, "listtype10");
                
        if ($item -> homegame==null) $item -> homegame = false;
	}
	return $item;
}


/**************************************************
 */
function saveGame($gameID, $score, $points,$meetingpoint, $homegame, $datetime, $membersPresentYes, $membersPresentNo, $opponent,
        $goals,$gameType, $gameStatus, $list1,$list2,$list3,$list4,$list5,$list6,$list7,$list8,$list9,$list10) {
	global $conn;
    $homegameInt = 0;
    if ($homegame==true) {
        $homegameInt=1;
    } 
    
    
    $score = mysql_real_escape_string($score);
    $meetingpoint = mysql_real_escape_string($meetingpoint);
    $membersPresentYes = mysql_real_escape_string($membersPresentYes);
    $membersPresentNo = mysql_real_escape_string($membersPresentNo);
//    $membersPresentUnknown = mysql_real_escape_string($membersPresentUnknown);
    $opponent = mysql_real_escape_string($opponent);
    $goals = mysql_real_escape_string($goals);
    $list1 = mysql_real_escape_string($list1);
    $list2 = mysql_real_escape_string($list2);
    $list3 = mysql_real_escape_string($list3);
    $list4 = mysql_real_escape_string($list4);
    $list5 = mysql_real_escape_string($list5);
    $list6 = mysql_real_escape_string($list6);
    $list7 = mysql_real_escape_string($list7);
    $list8 = mysql_real_escape_string($list8);
    $list9 = mysql_real_escape_string($list9);
    $list10 = mysql_real_escape_string($list10);
    $gameType = mysql_real_escape_string($gameType);
    $gameStatus = mysql_real_escape_string($gameStatus);
        
        
	$q = "UPDATE games SET score='$score' , points='.$points.', meetingpoint='".$meetingpoint."', ".   
	"homegame='$homegameInt', datetime='$datetime'".
	", membersPresentYes='$membersPresentYes', membersPresentNo='$membersPresentNo' ".
    ", opponent='$opponent'".
    ", goals='$goals'".
    ", gameType='$gameType'".
    ", gameStatus='$gameStatus'".
    ", list1='".$list1."'".
    ", list2='".$list2."'".
    ", list3='".$list3."'".
    ", list4='".$list4."'".
    ", list5='".$list5."'".
    ", list6='".$list6."'".
    ", list7='".$list7."'".
    ", list8='".$list8."'".
    ", list9='".$list9."'".
    ", list10='".$list10."'".
    "  WHERE id = '$gameID';";
    logSQLExtra($q,"saveGame", 0,$gameID,0,0,0);
    
	$res = mysql_query($q, $conn);
	if (mysql_errno()) {
		throw new \Exception(mysql_error());
	}

}

/**************************************************
 */
function addMessage($gameID, $newMessage) {
    global $conn;
    $message = "";
    $query = "SELECT messages FROM games where id=" . $gameID;
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    if ($num>0) {
        $message = mysql_result($result, 0, "messages");
    }
    
    $message = $newMessage.$message;
    
    $q = "UPDATE games SET messages='".mysql_real_escape_string($message)."' WHERE id = ".$gameID.";";
    logSQLExtra($q,"addMessage", 0,$gameID,0,0,0);
        $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    
}



function getGameDetails($messages,$membersYesStr, $membersNoStr, $membersUnknownStr,$game,$meetingpoint,$dateStr,$timeStr,$dayOfWeek, $link){
    $resultText='
<!--T1080T-->
<table>
<tr>
<td colspan=99>
<b><u>Wedstrijd gegevens</u></b>
</td>
</tr>
<tr>
<td>wedstrijd</td>
<td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
<td>'.$game.'</td>
</tr>
<tr>
<td>datum</td>
<td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
<td>'.$dayOfWeek." ".$dateStr.'</td>
</tr>
<tr>
<td>tijd</td>
<td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
<td>'.$timeStr.'</td>
</tr>

<tr>
<td>verzamelplek</td>
<td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
<td>'.$meetingpoint.'</td>
</tr>
<tr>
<td>link naar wedstrijd</td>
<td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
<td><a href='.$link.'>'.$link.'</a></td>
</tr>

<tr>
<td colspan=99>
<b><u>Aanwezigheid</u></b>
</td>
</tr>

<tr>
<td>Aanwezig</td>
<td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
<td>'.$membersYesStr.'</td>
</tr>

<tr>
<td>Afwezig</td>
<td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
<td>'.$membersNoStr.'</td>
</tr>

<tr>
<td>Nog niet aangegeven</td>
<td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
<td>'.$membersUnknownStr.'</td>
</tr>

<tr>
<td colspan=99>
<b><u>Berichten</u></b>
</td>
</tr>

<tr>
<td colspan=99>'.$messages.'</td>
</tr>


</table>
<!--T1080T-->
';
    
    return $resultText;
    
}

/**************************************************
 */
function emailMessages($gameID) {
    global $conn;
    $item = new \stdClass();
    $query = "SELECT *,date_format(games.datetime, '%d %M %Y') as gameDateStr, date_format(games.datetime, '%k:%i') as gameTimeStr FROM games,team where games.teamID=team.id and games.id='" . $gameID . "'";
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    
    $opponent = "";
    $messages = "";
    $gamedate = "";
    $homegame = "";
    $meetingpoint = "";
    $teamname = "";
    $teamID = 0;
    
    $daysfWeek = array(
    /*T1081T*/
    0 => "zondag",
    1 => "maandag",
    2 => "dinsdag",
    3 => "woensdag",
    4 => "donderdag",
    5 => "vrijdag",
    6 => "zaterdag");
    /*T1081T*/
    
   
    if ($num > 0) {
        $opponent = mysql_result($result, 0, "games.opponent");
        $messages = mysql_result($result, 0, "games.messages");
        $datetime = mysql_result($result, 0, "games.datetime");
        $gamedate =   date('d-m-Y', $datetime-date("Z",$datetime)); 
        $gametime =   date('H:i', $datetime-date("Z",$datetime)); 
        $dayOfWeek =   $daysfWeek[date('w', $datetime-date("Z",$datetime))]; 
        $homegame = mysql_result($result, 0, "games.homegame");
        $meetingpoint = mysql_result($result, 0, "games.meetingpoint");
        $teamname = mysql_result($result, 0, "team.teamname");
        $teamID = mysql_result($result, 0, "team.id");
        $membersPresentYes = mysql_result($result, 0, "games.membersPresentYes");
        $membersPresentNo = mysql_result($result, 0, "games.membersPresentNo");
        if ($homegame==null) $homegame = false;
    }
    
    $game = $teamname."-".$opponent;
    if (!$homegame){
        $game = $opponent."-".$teamname;
    }
    
    
    $link = /*T1082T*/ "http://www.mijnsportwedstrijden.nl/index.php?team=".$teamID."&section=wedstrijd&game=".$gameID;/*T1082T*/
    
    
    // split all present members-ids in an array
    $presentIDs = explode(" ", $membersPresentYes);    
    $notpresentIDs = explode(" ", $membersPresentNo);

    // find all members and players
    $allMembers = array();  
    $allPlayers = array();  
    $query = "SELECT * FROM teammember where teammember.teamID='" . $teamID . "'";
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    while ($i < $num) {
        $deleted = 1==mysql_result($result, $i, "teammember.deleted");
        $supporter = 1==mysql_result($result, $i, "teammember.supporter");
        $nickname = mysql_result($result, $i, "teammember.nickname");
        $id = mysql_result($result, $i, "teammember.id");
        $i++;
        $allMembers[$id]=$nickname;
        if ($deleted) continue;
        if ($supporter) continue;
        $allPlayers[$id]=$id;
    }
    // replace IDs for names for YES
    $presentOrNotPresentIDsArray = array();  
    
    $presentText = "";
    $count = 0;
    foreach ($presentIDs as $id) {
        if ($id=="") continue;
        if ($count>0) $presentText .= ", ";
        $count++;
        $presentText .= $allMembers[$id];
        $presentOrNotPresentIDsArray[$id]="yes";
    }
    /*T1083T*/$presentText = $count." spelers (".$presentText.")";/*T1083T*/

    // replace IDs for names for NO
    $notpresentText = "";
    $count = 0;
    foreach ($notpresentIDs as $id) {
        if ($id=="") continue;
        if ($count>0) $notpresentText .= ", ";
        $count++;
        $notpresentText .= $allMembers[$id];
        $presentOrNotPresentIDsArray[$id]="yes";
    }
    /*T1084T*/$notpresentText = $count." spelers (".$notpresentText.")";/*T1084T*/
    
    // find IDs for names for Unknown
    $unknownText = "";
    $count = 0;
        foreach ($allPlayers as $id) {
        if (!isset($presentOrNotPresentIDsArray[$id])){
            if ($count>0) $unknownText .= ", ";
            $count++;
            $unknownText .= $allMembers[$id];
        }
    }
    /*T1085T*/$unknownText = $count." spelers (".$unknownText.")";/*T1085T*/
    
        
    
    $message = "";
    $message .= "<body BGCOLOR='#fff'>";
    $message .= " <STYLE type='text/css'>";
    $message .= "   body {font-family: Arial;color: #000;text-decoration : none; }";       
    $message .= " </STYLE>";    
    $message .= getGameDetails($messages,$presentText, $notpresentText, $unknownText,$game,$meetingpoint,$gamedate,$gametime,$dayOfWeek, $link);
    
    $message .= "</body>";
    
    
    
    $message;
    

    $query = "SELECT * FROM teammember,users where teammember.teamID='" . $teamID . "' and teammember.userID=users.id and (deleted is NULL or deleted=0)";
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    while ($i < $num) {
        $admin = mysql_result($result, $i, "teammember.admin");
        $deleted = 1==mysql_result($result, $i, "teammember.deleted");
        $supporter = 1==mysql_result($result, $i, "teammember.supporter");
        $acceptEmail = mysql_result($result, $i, "teammember.acceptEmail");
        $email = mysql_result($result, $i, "users.email");
        $phonenumber = mysql_result($result, $i, "users.phonenumber");
        if ($email==null) $email = ""; 
        if ($phonenumber==null) $phonenumber = "";
        $i++;
        
        if ($deleted) continue;
        if ($supporter) continue;
        if (!$acceptEmail) continue;
        if ($email=="") continue;
                        
        //echo  $email.":".$admin;
        /*T1086T*/sendEmail($email,"mijnsportwedstrijden.nl update: nieuw bericht voor ".$game." op ".$gamedate." ".$gametime,$message, "Teamsport <team".$teamID."@mijnsportwedstrijden.nl>");/*T1086T*/
    }
    
}

/**************************************************
 */
function loadCompetition($competitionID) {
    global $conn;

    $item = null;

    $query = "SELECT season, id, mCompetition FROM competition where id=" . $competitionID;
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    if ($num>0) {
        $item = new \stdClass();
        $season = mysql_result($result, 0, "season");
        $competitionid = mysql_result($result, 0, "id");
        $item -> id = $competitionid;
        $item -> season = $season;
        $item -> mCompetition = mysql_result($result, 0, "mCompetition");
    }
    return $item;
}



/**************************************************
 */
function loadCompetitions($teamID) {
	global $conn;

	$array = array();
	$query = "SELECT season, description,id, mCompetition,status,type FROM competition where teamID='" . $teamID . "' order by season";
	$result = mysql_query($query, $conn);
	if (mysql_errno()) {
		throw new \Exception(mysql_error());
	}
	$num = mysql_numrows($result);
	$i = 0;
	while ($i < $num) {
		$item = new \stdClass();
		$item -> id = mysql_result($result, $i, "id");
        $item -> season =  mysql_result($result, $i, "season");
        $item -> description =  mysql_result($result, $i, "description");
        $item -> mCompetition = mysql_result($result, $i, "mCompetition");
        $item -> type = mysql_result($result, $i, "type");
        $item -> status = mysql_result($result, $i, "status");
		$array[] = $item;
		$i++;
	}
	return $array;
}

/**************************************************
 */
function addCompetition($teamID, $season, $competition, $status) {
	global $conn;
	$q = "INSERT INTO competition (`teamID` , `season`, `description`, `status`) VALUES (".
	"$teamID,'".mysql_real_escape_string($season)."','".mysql_real_escape_string($competition)."',$status)";
    logSQLExtra($q,"add competition", 0,0,$teamID,0,0);
	$res = mysql_query($q, $conn);
	if (mysql_errno()) {
		throw new \Exception(mysql_error());
	}
	$id = mysql_insert_id();
	return $id;
}

/**************************************************
 */
function updateCompetitions($competitions) {
	global $conn;
	foreach ($competitions as $competition) {
		if ($competition != null) {
			$q = "UPDATE competition SET ".
            "season='" . $competition -> season . "',". 
            "description='" . $competition -> description . "',". 
            "status=" . $competition -> status . 
			" WHERE id = '" . $competition -> id . "';";
            logSQLExtra($q,"updateCompetitions", 0,0,0,0,0);
			$res = mysql_query($q, $conn);
			if (mysql_errno()) {
				throw new \Exception(mysql_error());
			}
		}
	}

}

/**************************************************
 */
function removeCompetition($competitionID) {
	global $conn;
	$q = "DELETE from competition WHERE id = '" . $competitionID . "';";
    logSQLExtra($q,"removeCompetition", 0,0,0,0,0);
	$res = mysql_query($q, $conn);
	if (mysql_errno()) {
		throw new \Exception(mysql_error());
	}

    $q = "delete from games where competitionID ='".$competitionID."';";
    logSQLExtra($q,"removeGamesFromCompetition", 0,0,0,0,0);
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
}

/**************************************************
 */
function addGame($teamID, $competitionID, $gameDate, $gameOpponent, $homegame) {
	global $conn;

    $homegameInt = 0;
    if ($homegame==true) {
        $homegameInt=1;
    } 
    $gameOpponent = mysql_real_escape_string($gameOpponent);	
	$q = "INSERT INTO games (`datetime`,`opponent`,`competitionID`,`teamID`,`homegame`) VALUES ('$gameDate','$gameOpponent','$competitionID','$teamID',$homegameInt)";
    logSQLExtra($q,"add game", 0,0,$teamID,0,0);
	$res = mysql_query($q, $conn);
	if (mysql_errno()) {
		throw new \Exception(mysql_error());
	}
	$teamID = mysql_insert_id();

	return $teamID;
}

/**************************************************
 */
function addGames($games) {
    global $conn;


    foreach ($games as $game) {
        if ($game != null) {
            
            $homegameInt = 0;
            if ($game->homegame==true) {
                $homegameInt=1;
            } 
            
            $game->gameOpponent = mysql_real_escape_string($game->gameOpponent);    
            
            $q = "INSERT INTO games (`datetime`,`opponent`,`competitionID`,`teamID`,`homegame`) VALUES ('$game->gameDate','$game->gameOpponent','$game->competitionID','$game->teamID','$homegameInt')";
            logSQLExtra($q,"add game", 0,0,$game->teamID,0,0);
            $res = mysql_query($q, $conn);
            if (mysql_errno()) {
                throw new \Exception(mysql_error());
            }
        }
    }
       
    return "";
}


function saveTeammembers($changedLists){
    global $conn;
    foreach ($changedLists as $changedMember) {
        $supportedValue = 0;
        $adminValue = 0;
        $invallerValue = 0;
        if ($changedMember->admin){
            $adminValue = 1;
        }
        if ($changedMember->supporter){
            $supportedValue = 1;
        }
        if ($changedMember->invaller){
            $invallerValue = 1;
        }
        $query = "UPDATE teammember SET admin=".$adminValue.",supporter=".$supportedValue.",invaller=".$invallerValue." where id=".$changedMember->id.";";
        logSQLExtra($query,"saveTeammembers", 0,0,0,0,0);
        $result = mysql_query($query, $conn);
        if (mysql_errno()) {
            throw new \Exception(mysql_error());
        }
    }
}

function saveTeammembers2($changedLists){
    global $conn;
    foreach ($changedLists as $changedMember) {
        $acceptEmail = 0;
        if ($changedMember->acceptEmail){
            $acceptEmail = 1;
        }
        $nickname = mysql_real_escape_string($changedMember->nickname);
        $query = "UPDATE teammember SET acceptEmail=".$acceptEmail.",nickname='".$nickname."' where id=".$changedMember->id.";";
        logSQLExtra($query,"saveTeammembers2", 0,0,0,0,$changedMember->id);
        $result = mysql_query($query, $conn);
        if (mysql_errno()) {
            throw new \Exception(mysql_error());
        }
    }
}

/**************************************************
 */
function loadTeammembers($teamID) {
	global $conn;
	$array = array();
	$query = "SELECT * FROM teammember,users where teammember.teamID='" . $teamID . "' and teammember.userID=users.id";
	$result = mysql_query($query, $conn);
	if (mysql_errno()) {
		throw new \Exception(mysql_error());
	}
	$num = mysql_numrows($result);
	$i = 0;
	while ($i < $num) {
		$item = new \stdClass();
        $item -> id = mysql_result($result, $i, "teammember.id");
		$item -> userID = mysql_result($result, $i, "teammember.userID");
		$item -> nickname = mysql_result($result, $i, "teammember.nickname");
        $item -> admin = mysql_result($result, $i, "teammember.admin");
        $item -> deleted = 1==mysql_result($result, $i, "teammember.deleted");
        $item -> supporter = 1==mysql_result($result, $i, "teammember.supporter");
        $item -> invaller = 1==mysql_result($result, $i, "teammember.invaller");
        $item -> invitationID = mysql_result($result, $i, "teammember.invitationID");
        $item -> invitationEmail = mysql_result($result, $i, "teammember.invitationEmail");
        $item -> invitationDate = mysql_result($result, $i, "teammember.invitationDate");
        $item -> acceptEmail = mysql_result($result, $i, "teammember.acceptEmail");
        $item -> email = mysql_result($result, $i, "users.email");
        $item -> phonenumber = mysql_result($result, $i, "users.phonenumber");
        if ($item -> email==null) $item -> email = ""; 
        if ($item -> phonenumber==null) $item -> phonenumber = ""; 
        $array[] = $item;
		$i++;
	}

    //also return all users that are invited and have no user yet
    $query = "SELECT * FROM teammember where teammember.teamID='" . $teamID . "' and (teammember.userID is NULL || teammember.userID = 0)";
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    while ($i < $num) {
        $item = new \stdClass();
        $item -> id = mysql_result($result, $i, "teammember.id");
        $item -> userID = mysql_result($result, $i, "teammember.userID");
        $item -> nickname = mysql_result($result, $i, "teammember.nickname");
        $item -> admin = mysql_result($result, $i, "teammember.admin");
        $item -> deleted = 1==mysql_result($result, $i, "teammember.deleted");
        $item -> supporter = 1==mysql_result($result, $i, "teammember.supporter");
        $item -> invaller = 1==mysql_result($result, $i, "teammember.invaller");
        $item -> invitationID = mysql_result($result, $i, "teammember.invitationID");
        $item -> invitationEmail = mysql_result($result, $i, "teammember.invitationEmail");
        $item -> invitationDate = mysql_result($result, $i, "teammember.invitationDate");
        $item -> acceptEmail = mysql_result($result, $i, "teammember.acceptEmail");
        $item -> email = "";
        $item -> phonenumber = "";
        $array[] = $item;
        $i++;
    }

    


	return $array;
}


/**************************************************
 */
function loadTeammembersOfUser($userID) {
    global $conn;
    $array = array();
    $query = "SELECT teammember.*,team.teamname FROM teammember,team where userID='" . $userID . "' and team.id=teammember.teamID  and (teammember.deleted=0 || teammember.deleted is NULL)";
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    while ($i < $num) {
        $item = new \stdClass();
        $item -> id = mysql_result($result, $i, "teammember.id");
        $item -> userID = mysql_result($result, $i, "teammember.userID");
        $item -> nickname = mysql_result($result, $i, "teammember.nickname");
        $item -> admin = mysql_result($result, $i, "teammember.admin");
        $item -> deleted = 1==mysql_result($result, $i, "teammember.deleted");
        $item -> supporter = 1==mysql_result($result, $i, "teammember.supporter");
        $item -> invaller = 1==mysql_result($result, $i, "teammember.invaller");
        $item -> invitationID = mysql_result($result, $i, "teammember.invitationID");
        $item -> invitationEmail = mysql_result($result, $i, "teammember.invitationEmail");
        $item -> invitationDate = mysql_result($result, $i, "teammember.invitationDate");
        $item -> acceptEmail = mysql_result($result, $i, "teammember.acceptEmail");
        $item -> teamname = mysql_result($result, $i, "team.teamname");
                $array[] = $item;
        $i++;
    }
    return $array;
}
/**************************************************
 */
function removeTeammember($teammemberID) {
	global $conn;
	$q = "UPDATE teammember set deleted=1 WHERE id = '" . $teammemberID . "';";
    logSQLExtra($q,"removeTeammember", 0,0,0,0,$teammemberID);
	$res = mysql_query($q, $conn);
	if (mysql_errno()) {
		throw new \Exception(mysql_error());
	}
}


/**************************************************
 */
function loadListData($competitionID) {
    global $conn;
    $array = array();
    $query = "SELECT * FROM games where competitionID='" . $competitionID . "' order by games.datetime";
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    while ($i < $num) {

        $item = new \stdClass();
        $item -> id = mysql_result($result, $i, "id");
        $gamedate = mysql_result($result, $i, "datetime");
        $item -> gamedate = $gamedate;
        $item -> opponent = mysql_result($result, $i, "opponent");
        $item -> homegame = mysql_result($result, $i, "homegame");

//        $item -> membersPresentUnknown = mysql_result($result, $i, "games.membersPresentUnknown");
        $item -> membersPresentYes = mysql_result($result, $i, "games.membersPresentYes");
        $item -> membersPresentNo = mysql_result($result, $i, "games.membersPresentNo");
        $item -> goals = mysql_result($result, $i, "games.goals");

        $item -> list1 = mysql_result($result, $i, "list1");
        $item -> list2 = mysql_result($result, $i, "list2");
        $item -> list3 = mysql_result($result, $i, "list3");
        $item -> list4 = mysql_result($result, $i, "list4");
        $item -> list5 = mysql_result($result, $i, "list5");
        $item -> list6 = mysql_result($result, $i, "list6");
        $item -> list7 = mysql_result($result, $i, "list7");
        $item -> list8 = mysql_result($result, $i, "list8");
        $item -> list9 = mysql_result($result, $i, "list9");
        $item -> list10 = mysql_result($result, $i, "list10");
        $array[] = $item;
        $i++;
    }
    return $array;
}

function saveListData($changedLists) {
    global $conn;
    
    
    foreach ($changedLists as $changedList) {
//        echo "update ".$changedList->listName." to ".$changedList->listData." for game ".$changedList->gameID."\n";
        $query = "UPDATE games SET ".$changedList->listName."='".mysql_real_escape_string($changedList->listData)."' where id=".$changedList->gameID.";";
        logSQLExtra($query,"saveListData", 0,0,0,0,0);
        $result = mysql_query($query, $conn);
        if (mysql_errno()) {
            throw new \Exception(mysql_error());
        }
                
    }
}


function addList($listType,$listName,$teamID){
    global $conn;
    $query = "SELECT * FROM team where id='" . $teamID . "'";
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $listToUse = null;
    $listTypeFieldName = null;
    if ($num > 0) {
        for ($i=10; $i>0; $i--){
            $listname = mysql_result($result, 0, "team.listname".$i);
            if ($listname=="" || $listname==null) {
                $listToUse = "listname".$i;
                $listTypeFieldName = "listtype".$i;
            }
        }
    }
    if ($listToUse == null){
        throw new \Exception(/*T1087T*/"Geen vrije lijst meer over (max 10 lijsten)"/*T1087T*/);
    }

    // set the listname for the new list
    $query = "UPDATE team SET ".$listToUse."='" . $listName . "',".$listTypeFieldName."=".$listType." where id=".$teamID.";";
    logSQLExtra($query,"addList", 0,0,$teamID,0,0);
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
}

function removeList($listID,$teamID){
    global $conn;
    $query = "UPDATE team SET listname".$listID."='' where id=".$teamID.";";
    logSQLExtra($query,"removeList-team", 0,0,$teamID,0,0);
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    
        
    $query = "UPDATE games SET list".$listID."='' where teamID=".$teamID.";";
    logSQLExtra($query,"removeList-games", 0,0,$teamID,0,0);
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
}

function updateLists($teamID,$listName1,$listName2,$listName3
    ,$listName4,$listName5,$listName6,$listName7
    ,$listName8,$listName9,$listName10){
    global $conn;
    $query = "UPDATE team SET listname1='".mysql_real_escape_string($listName1)."',".
    "listname2='".mysql_real_escape_string($listName2)."',".
    "listname3='".mysql_real_escape_string($listName3)."',".
    "listname4='".mysql_real_escape_string($listName4)."',".
    "listname5='".mysql_real_escape_string($listName5)."',".
    "listname6='".mysql_real_escape_string($listName6)."',".
    "listname7='".mysql_real_escape_string($listName7)."',".
    "listname8='".mysql_real_escape_string($listName8)."',".
    "listname9='".mysql_real_escape_string($listName9)."',".
    "listname10='".mysql_real_escape_string($listName10)."' ".
        " where id=".$teamID.";";
    logSQLExtra($query,"updateListsm", 0,0,$teamID,0,0);

    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
        
}


function removeMemberFromList($list,$memberID){
    $list = " ".$list." ";
    $list = str_replace(" ".$memberID." ", " ", $list);
    return $list; 
}

function setAanwezig($gameID,$memberID){
    changeAanwezigheid($gameID,$memberID,true,false,false);
}

function setAfwezig($gameID,$memberID){
    changeAanwezigheid($gameID,$memberID,false,true,false);
}

function setOnbekend($gameID,$memberID){
    changeAanwezigheid($gameID,$memberID,false,false,true);
}


function changeAanwezigheid($gameID,$memberID,$aanwezig,$afwezig,$onbekend){
    global $conn;

    $query = "SELECT membersPresentYes,membersPresentNo FROM games where id='" . $gameID . "'";
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $listToUse = null;
    $listTypeFieldName = null;
    $membersPresentYes = "";
    $membersPresentNo = "";
    //$membersPresentUnknown = "";
    if ($num > 0) {
        $membersPresentYes = mysql_result($result, 0, "membersPresentYes");
        $membersPresentNo = mysql_result($result, 0, "membersPresentNo");
        //$membersPresentUnknown = mysql_result($result, 0, "membersPresentUnknown");
    }
    // remove the list from all 3 lists
    $membersPresentYes = removeMemberFromList($membersPresentYes,$memberID);
    $membersPresentNo = removeMemberFromList($membersPresentNo,$memberID);
    //$membersPresentUnknown = removeMemberFromList($membersPresentUnknown,$memberID);
    
    if ($aanwezig){
        $membersPresentYes = $membersPresentYes." ".$memberID;
    }
    if ($afwezig){
        $membersPresentNo = $membersPresentNo." ".$memberID;
    }
    //if ($onbekend){
    //    $membersPresentUnknown = $membersPresentUnknown." ".$memberID;
    //}
        
    $query = "UPDATE games SET membersPresentYes='" . $membersPresentYes . "', membersPresentNo='".$membersPresentNo."' where id=".$gameID.";";
    logSQLExtra($query,"changeAanwezigheid", 0,$gameID,0,0,$memberID);
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
}

function changeNickname($nickname,$memberID){
    global $conn;
        
    $query = "UPDATE teammember SET nickname='".mysql_real_escape_string($nickname)."' where id=".$memberID.";";
    logSQLExtra($query,"changeNickname", 0,0,0,0,$memberID);
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
}

function changePW($userID,$oldPW, $newPW1, $newPW2){
    global $conn;
    
    $oldmd5pass = md5($oldPW);
    $newmd5pass = md5($newPW2);
    
    /* Verify that user is in database */
    $q = "select password from users where id = ".$userID;
    $result = mysql_query($q, $conn);
    $num = mysql_numrows($result);

    if (!$result || $num < 1) {
        throw new \Exception(/*T1088T*/"gebruiker niet gevonden"/*T1088T*/);
    }
    $currpassword = mysql_result($result, 0, "password");
    
    if ($currpassword!=$oldmd5pass){
        throw new \Exception(/*T1089T*/"oud wachtwoord is niet correct"/*T1089T*/);
    }
    
    if ($newPW1!=$newPW2){
        throw new \Exception(/*T1090T*/"de wachtwoorden komen niet overeen"/*T1090T*/);
    }
    
    $query = "UPDATE users SET password='".mysql_real_escape_string($newmd5pass)."' where id=".$userID.";";
    logSQLExtra($query,"changePW", 0,0,0,$userID,0);
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    
}
/**************************************************
 */
function dbSummary() {
    global $conn;
    $item = new \stdClass();
    $query = "select". 
"(select count(*) from games ) as gamecount,".
"(select count(*) from competition ) as competitioncount,".
"(select count(*) from team ) as teamcount,".
"(select count(*) from teammember ) as teammembercount,".
"(select count(*) from users ) as userscount";
    
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    while ($i < $num) {
        $item -> gamecount = mysql_result($result, $i, "gamecount");
        $item -> competitioncount = mysql_result($result, $i, "competitioncount");
        $item -> teamcount = mysql_result($result, $i, "teamcount");
        $item -> teammembercount = mysql_result($result, $i, "teammembercount");
        $item -> userscount = mysql_result($result, $i, "userscount");
        $i++;
    }

    return $item;
}


/**************************************************
 */
function adminListAllTeams() {
    global $conn;
    $array = array();
    $query = "select team.id , team.teamname ,". 
    "(select count(*) from games where games.teamID = team.id) as gamecount,".
    "(select count(*) from competition where competition.teamID = team.id) as competitioncount,".
    "(select count(*) from teammember where teammember.teamID = team.id) as teammembercount from team where team.id>0 order by teammembercount DESC";
    
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    while ($i < $num) {
        $item = new \stdClass();
        $item -> teamname = mysql_result($result, $i, "teamname");
        $item -> teamid = mysql_result($result, $i, "id");
        $item -> gamecount = mysql_result($result, $i, "gamecount");
        $item -> competitioncount = mysql_result($result, $i, "competitioncount");
        $item -> teammembercount = mysql_result($result, $i, "teammembercount");
        $array[] = $item;
        $i++;
    }

    return $array;
}

function adminRemoveTeam($teamID){
    global $conn;
    if ($teamID=="") return;
    $query = "delete from competition where teamID=".$teamID;
    logSQLExtra($query,"adminRemoveTeam-remove competition", 0,0,$teamID,0,0);
        $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }

    $query = "delete from games where teamID=".$teamID;
    logSQLExtra($query,"adminRemoveTeam-remove games", 0,0,$teamID,0,0);
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }

    $query = "delete from teammember where teamID=".$teamID;
    logSQLExtra($query,"adminRemoveTeam-remove teammember", 0,0,$teamID,0,0);
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }

    $query = "delete from team where id=".$teamID;
    logSQLExtra($query,"adminRemoveTeam-remove team", 0,0,$teamID,0,0);
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
        
}



/**************************************************
 */
function adminListAllUsers() {
    global $conn;
    $array = array();
    $query = "select users.id , users.proUser, users.endProDate, users.email, users.username,". 
    "(select count(*) from teammember where teammember.userID = users.id) as teammembercount from users";
    
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    while ($i < $num) {
        $item = new \stdClass();
        $item -> username = mysql_result($result, $i, "username");
        $item -> id = mysql_result($result, $i, "id");
        $item -> proUser = mysql_result($result, $i, "proUser");
        $item -> endProDate = mysql_result($result, $i, "endProDate");
        $item -> email = mysql_result($result, $i, "email");
        $item -> teammembercount = mysql_result($result, $i, "teammembercount");
        $array[] = $item;
        $i++;
    }

    return $array;
}


/**************************************************
 */
function adminListAllTeammembers($filterTeamID) {
    global $conn;
    $array = array();
    $query = "select teammember.id as memberID, teammember.nickname,users.id as userID, users.username, users.email from teammember,users where teamID=".$filterTeamID." and users.ID=teammember.userID";
    
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    while ($i < $num) {
        $item = new \stdClass();
        $item -> memberID = mysql_result($result, $i, "memberID");
        $item -> userID = mysql_result($result, $i, "userID");
        $item -> nickname = mysql_result($result, $i, "nickname");
        $item -> username = mysql_result($result, $i, "username");
        $item -> email = mysql_result($result, $i, "email");
        
        $array[] = $item;
        $i++;
    }

    return $array;
}

function adminRemoveUser($userID){
    global $conn;
    if ($userID=="") return;
    $query = "delete from teammember where userID=".$userID;
    logSQLExtra($query,"adminRemoveUser-remove teammembers", 0,0,0,$userID,0);
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }

    $query = "delete from users where id=".$userID;
    logSQLExtra($query,"adminRemoveUser-remove user", 0,0,0,$userID,0);
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }       
}

function adminDisableProUser($userID){
    global $conn;
    if ($userID=="") return;
    $query = "UPDATE users SET proUser=0 where id=".$userID.";";
    logSQLExtra($query,"adminDisableProUser user "+$userID, 0,0,0,$userID,0);
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }       
}

function adminEnableProUser($userID){
    global $conn;
    if ($userID=="") return;
    $query = "UPDATE users SET endProDate='2099-01-01' where id=".$userID.";";
    logSQLExtra($query,"adminDisableProUser user "+$userID, 0, 0,0,$userID,0);
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }       
}


/**************************************************
 */
function adminListAllChanges($parameters) {
    global $conn;
    $array = array();
    $where = "1=1 ";
    if ($parameters->filterLogGameID !=""){
        $where .= " and gameID=".$parameters->filterLogGameID;
    }
    if ($parameters->filterLogTeamID !=""){
        $where .= " and teamID=".$parameters->filterLogTeamID;
    }
    if ($parameters->filterLogUserID !=""){
        $where .= " and userID=".$parameters->filterLogUserID;
    }
    if ($parameters->filterLogMemberID !=""){
        $where .= " and memberID=".$parameters->filterLogMemberID;
    }
    $query = "select * from log where ".$where." order by id desc limit 500";
    
    
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    while ($i < $num) {
        $item = new \stdClass();
        $item -> user = mysql_result($result, $i, "username");
        $item -> date = mysql_result($result, $i, "date");
        $item -> time = mysql_result($result, $i, "time");
        $item -> gameID = mysql_result($result, $i, "gameID");
        $item -> teamID = mysql_result($result, $i, "teamID");
        $item -> userID = mysql_result($result, $i, "userID");
        $item -> memberID = mysql_result($result, $i, "memberID");
        $item -> action = mysql_result($result, $i, "description");
        $item -> statement = mysql_result($result, $i, "statement");
        $array[] = $item;
        $i++;
    }

    return $array;
}


function checkUser($username,$pw){
    global $conn;
    $md5pass = md5($pw);
    $q = "select id,password from users where username = '".$username."'";
    $result = mysql_query($q, $conn);
    if (!$result) {
        return -1;
    }

    $num = mysql_numrows($result);
    if ($num < 1) {
        return -1;
    }
   
    $currpassword = mysql_result($result, 0, "password");
    $currid = mysql_result($result, 0, "id");    
    if ($currpassword!=$md5pass){
        return -1;
    }
    return $currid;
}


/**************************************************
 */
function getGames($userID,$query) {
    global $conn;

    $array = array();
    
    // find all teams of this user
    $teamquery = "select team.* from teammember, users, team where users.id=teammember.userID and teammember.teamID=team.id and users.ID=".$userID;
    $result = mysql_query($teamquery, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $teamsArray = array();
    $i=0;
    while ($i < $num) {
        $item = new \stdClass();
        $item -> id = mysql_result($result, $i, "id");
        $item -> teamname = mysql_result($result, $i, "teamname");
        $item -> listname1 = mysql_result($result, 0, "listname1");
        $item -> listname2 = mysql_result($result, 0, "listname2");
        $item -> listname3 = mysql_result($result, 0, "listname3");
        $item -> listname4 = mysql_result($result, 0, "listname4");
        $item -> listname5 = mysql_result($result, 0, "listname5");
        $item -> listname6 = mysql_result($result, 0, "listname6");
        $item -> listname7 = mysql_result($result, 0, "listname7");
        $item -> listname8 = mysql_result($result, 0, "listname8");
        $item -> listname9 = mysql_result($result, 0, "listname9");
        $item -> listname10 = mysql_result($result, 0, "listname10");
        $item -> listtype1 = mysql_result($result, 0, "listtype1");
        $item -> listtype2 = mysql_result($result, 0, "listtype2");
        $item -> listtype3 = mysql_result($result, 0, "listtype3");
        $item -> listtype4 = mysql_result($result, 0, "listtype4");
        $item -> listtype5 = mysql_result($result, 0, "listtype5");
        $item -> listtype6 = mysql_result($result, 0, "listtype6");
        $item -> listtype7 = mysql_result($result, 0, "listtype7");
        $item -> listtype8 = mysql_result($result, 0, "listtype8");
        $item -> listtype9 = mysql_result($result, 0, "listtype9");
        $item -> listtype10 = mysql_result($result, 0, "listtype10");
        $teamsArray[$item -> id ] = $item;
        $i++;
    }    
    // my nickname
    $mynickname = "";
    $myTeamMemberID = "";
    
    // find all nicknames of all teammembers
    $teamPlayersArray = array();
    foreach ($teamsArray as $team) {
        $memberquery = "select teammember.deleted,teammember.id,teammember.nickname,teammember.userid from teammember where teamID=".$team->id;
        $result = mysql_query($memberquery, $conn);
        if (mysql_errno()) {
            throw new \Exception(mysql_error());
        }
        $num = mysql_numrows($result);
        $i=0;
        $team->members = array();
        while ($i < $num) {
            $item = new \stdClass();
            $item -> id = mysql_result($result, $i, "id");
            $item -> deleted = mysql_result($result, $i, "deleted");
            $item -> nickname = mysql_result($result, $i, "nickname");
            $item -> userid = mysql_result($result, $i, "userid");
            if ($item -> userid==$userID){
                $mynickname = $item -> nickname;
                $myTeamMemberID = $item -> id; 
            }
            $teamPlayersArray[$item -> id] = $item;
            $team->members[] = $item;; 
            $i++;
        }            
    }
    
//var_dump($teamsArray);    
    
    // find all games   
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    
    $daysfWeek = array(
    /*T1091T*/
    0 => "zondag",
    1 => "maandag",
    2 => "dinsdag",
    3 => "woensdag",
    4 => "donderdag",
    5 => "vrijdag",
    6 => "zaterdag");
    /*T1091T*/
    
    while ($i < $num) {
        $gamedate = mysql_result($result, $i, "datetime");
        
        $item = new \stdClass();
        $item -> gamedate = $gamedate;
        $item -> id = mysql_result($result, $i, "id");
        $item -> mynickname =  mysql_result($result, $i, "teammember.nickname");
        $item -> teammemberID = mysql_result($result, $i, "teammember.id");
        $item -> userIsAdmin = mysql_result($result, $i, "teammember.admin");
        $item -> opponent = mysql_result($result, $i, "opponent");
        $item -> teamname = mysql_result($result, $i, "team.teamname");
        $item -> teamID = mysql_result($result, $i, "teamID");
        $item -> homegame = mysql_result($result, $i, "homegame");
        $item -> membersPresentYes = mysql_result($result, $i, "membersPresentYes");
        $item -> membersPresentNo = mysql_result($result, $i, "membersPresentNo");
        $item -> score = mysql_result($result, $i, "score");
        $item -> points = mysql_result($result, $i, "points");
        $item -> gameType = mysql_result($result, $i, "gameType");
        $item -> gameStatus = mysql_result($result, $i, "gameStatus");
        $item -> messages = mysql_result($result, $i, "messages");
        $item -> meetingpoint = mysql_result($result, $i, "games.meetingpoint");
        $item -> mGameID = mysql_result($result, $i, "games.mGameID");
        $item -> goals = mysql_result($result, $i, "games.goals");
        $item -> list1 = mysql_result($result, $i, "games.list1");
        $item -> list2 = mysql_result($result, $i, "games.list2");
        $item -> list3 = mysql_result($result, $i, "games.list3");
        $item -> list4 = mysql_result($result, $i, "games.list4");
        $item -> list5 = mysql_result($result, $i, "games.list5");
        $item -> list6 = mysql_result($result, $i, "games.list6");
        $item -> list7 = mysql_result($result, $i, "games.list7");
        $item -> list8 = mysql_result($result, $i, "games.list8");
        $item -> list9 = mysql_result($result, $i, "games.list9");
        $item -> list10 = mysql_result($result, $i, "games.list10");
                
                
        $item -> gameStr = $item -> opponent." - ".$item -> teamname;
        if ($item -> homegame=="1"){
            $item -> gameStr = $item -> teamname." - ".$item -> opponent;
        }

        $dateStr =   date('d-m-Y', $gamedate-date("Z",$gamedate)); 
        $timeStr =   date('H:i', $gamedate-date("Z",$gamedate)); 
        $dayOfWeek =   $daysfWeek[date('w', $gamedate-date("Z",$gamedate))]; 

        $item -> dateTimeStr = $dayOfWeek." ".$dateStr." ".$timeStr;
        
        // find if the user is present
        $presentIDs = explode(" ", $item -> membersPresentYes);
        $notpresentIDs = explode(" ", $item -> membersPresentNo);
        $remainingMembers = array();
        
        // fill all remainingMembers
        foreach ($teamsArray[$item -> teamID]->members as $member) {
            if ($member -> deleted == null || $member -> deleted == 0){
                $remainingMembers[$member->id] = $member->id; 
            }
        }   
        // walk trough YES                
        $zelfAanwezig = "0";
        $allYes = "";
        $firstYes = true;
        foreach ($presentIDs as $id) {
            if ($id==$item -> teammemberID){
                $zelfAanwezig = "1";
            }
            if (isset($teamPlayersArray[$id])){
                $name = $teamPlayersArray[$id]->nickname;
                if (!$firstYes){
                    $allYes.=", ";
                }
                $allYes.=$name;
                $firstYes = false;
                if (isset($remainingMembers[$id])){
                    unset($remainingMembers[$id]);
                }
            }
        }
        
        // walk trough NO                
        $allNo = "";
        $firstNo = true;
        foreach ($notpresentIDs as $id) {
            if ($id==$item -> teammemberID){
                $zelfAanwezig = "2";
            }
            if (isset($teamPlayersArray[$id])){
                $name = $teamPlayersArray[$id]->nickname;
                if (!$firstNo){
                    $allNo.=", ";
                }
                $allNo.=$name;
                $firstNo = false;
                if (isset($remainingMembers[$id])){
                    unset($remainingMembers[$id]);
                }
            }
        }
        
        // walk through unknown
        $allUnknown = "";
        $firstUnknown = true;
        foreach ($remainingMembers as $id) {
            if (isset($teamPlayersArray[$id])){
                $name = $teamPlayersArray[$id]->nickname;
                if (!$firstUnknown){
                    $allUnknown.=", ";
                }
                $allUnknown.=$name;
                $firstUnknown = false;
            }
        }
        
        
        
        $item -> membersPresentYesNames = $allYes;         
        $item -> membersPresentNoNames = $allNo;         
        $item -> membersPresentUnknownNames = $allUnknown;         

        $item -> userPresent = $zelfAanwezig; 
//        $item -> presentCount = count($presentIDs);
        
        $item -> presentCount = 0;
        foreach ($presentIDs as $id) {
            if ($id!=null && $id!=""){
                $item -> presentCount ++;
            }
        }
         
        
                
        if ($item -> points==null) $item -> points = 0;
        if ($item -> score==null) $item -> score = "";
        $array[] = $item;
        $i++;
    }
//var_dump($array);
    return $array;
    
}


/**************************************************
 */
function getUpcomingGames($userID,$filter,$numDays) {
    global $conn;
    $date1 = time();
    $date2 = $date1+60*60*24*$numDays;
    $query = "SELECT distinct games.*,team.teamname, teammember.id, teammember.nickname, teammember.admin  FROM games,teammember,team  where games.teamID = team.id and games.teamID = teammember.teamID and (teammember.deleted=0 || teammember.deleted is NULL) and teammember.userID = $userID and datetime>$date1 && datetime<$date2 order by games.datetime";
    return getGames($userID,$query);
    
    
}

/**************************************************
 */
function getPreviousGames($userID,$filter,$numDays) {
    global $conn;
    $date1 = time();
    $date2 = $date1-60*60*24*$numDays;
    $query = "SELECT distinct games.*,team.teamname, teammember.id, teammember.nickname, teammember.admin FROM games,teammember,team  where games.teamID = team.id and games.teamID = teammember.teamID and (teammember.deleted=0 || teammember.deleted is NULL) and teammember.userID = $userID and datetime<$date1 && datetime>$date2 order by games.datetime";
    return getGames($userID,$query);
}


/**************************************************
 */
function getPreviousGames2($userID,$compID,$filter,$numDays) {
    global $conn;
    $date1 = time();
    $date2 = $date1-60*60*24*$numDays;
    $query = "SELECT distinct games.*,team.teamname, teammember.id, teammember.nickname, teammember.admin FROM games,teammember,team  where games.teamID = team.id and games.teamID = teammember.teamID and (teammember.deleted=0 || teammember.deleted is NULL) and teammember.userID = $userID and games.competitionID = $compID and datetime<$date1 && datetime>$date2 order by games.datetime";
    return getGames($userID,$query);
}


/**************************************************
 */
function getUpcomingGames2($userID,$compID,$filter,$numDays) {
    global $conn;
    $date1 = time();
    $date2 = $date1+60*60*24*$numDays;
    $query = "SELECT distinct games.*,team.teamname, teammember.id, teammember.nickname, teammember.admin FROM games,teammember,team  where games.teamID = team.id and games.teamID = teammember.teamID and (teammember.deleted=0 || teammember.deleted is NULL) and teammember.userID = $userID and games.competitionID = $compID and datetime>$date1 && datetime<$date2 order by games.datetime";
    return getGames($userID,$query);
}

/**************************************************
 */
function getCompetitionGames($userID,$competitions) {
    global $conn;
    $competitionFilter = "";
    foreach ($competitions as $competition) {
        if ($competitionFilter!="") $competitionFilter.=" or ";
        $competitionFilter.=" games.competitionID = ".$competition->id;
    }
    if ($competitionFilter!="") $competitionFilter=" and (".$competitionFilter.")";
    $query = "SELECT distinct games.*,team.teamname, teammember.id, teammember.nickname, teammember.admin FROM games,teammember,team  where games.teamID = team.id and games.teamID = teammember.teamID and (teammember.deleted=0 || teammember.deleted is NULL) and teammember.userID = $userID ".$competitionFilter." order by games.datetime";
    return getGames($userID,$query);
}



/**************************************************
 */
 function updateGame($userID,$type,$gameid,$teamid,$message) {
    global $conn;
    
     // find memberID
    $memberID = 0;
    $q = "select id,nickname from teammember where teamID = $teamid and userID=$userID";
    $res = mysql_query($q, $conn);
    $num = mysql_numrows($res);
    if ($num == 0)
        return -1;
    $memberID = mysql_result($res, 0,"id");
    $nickname = mysql_result($res, 0,"nickname");
        
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
     
     // update aanwezigheid
     if ($type=="setaanwezig"){
        changeAanwezigheid($gameid,$memberID,true,false,false);
     }
     if ($type=="setafwezig"){
        changeAanwezigheid($gameid,$memberID,false,true,false);
     }
     if ($type=="setweetniet"){
        changeAanwezigheid($gameid,$memberID,false,false,true);
     }
     if ($type=="addMessage"){
        // get old message
        $q = "select messages from games where id = $gameid";
        $res = mysql_query($q, $conn);
        if (mysql_errno()) {
            throw new \Exception(mysql_error());
        }        
        $num = mysql_numrows($res);
        if ($num == 0)
            return -1;
        $oldMessage = mysql_result($res, 0,"messages");
         
        date_default_timezone_set('Europe/Amsterdam');
        $gamedate = time();
        $dateStr =   date('d-m', $gamedate); 
        $timeStr =   date('H:i', $gamedate);
        
        $message = str_replace("\n", "<br>", $message);

         
        $newMessage = /*T1092T*/"<b>op $dateStr om $timeStr schreef $nickname</b><br>".$message."<br><br>"/*T1092T*/;
         
        addMessage($gameid, $newMessage);
        emailMessages($gameid);
     }
          
    $query = "SELECT distinct games.*,team.teamname, teammember.id FROM games,teammember,team  where games.teamID = team.id and games.teamID = teammember.teamID and teammember.userID = $userID and games.id = $gameid";
    return getGames($userID,$query);
}




/**************************************************
 */
function getManagedcompetitions($team,$org) {
    global $conn;
    $array = array();
    
    $filter = "";
    if ($org!=""){
        $filter =  "and managedcompetitionorganisation.description like '$org'";    
    }
    
    if ($team==""){
        $query = 
        "SELECT distinct ".
        "managedcompetition.id, ".
        "managedcompetition.description, ".
        "managedcompetitionseason.description, ".
        "managedcompetitionorganisation.description ".
        "FROM managedcompetition,managedcompetitionorganisation,managedcompetitionseason where ". 
        "managedcompetition.managedCompetitionSeasonID=managedcompetitionseason.ID AND ". 
        "managedcompetitionseason.managedCompetitionOrganisationID=managedcompetitionorganisation.ID ".
        $filter;
    }    
    else{
        $query = 
        "SELECT distinct ".
        "managedcompetition.id, ".
        "managedcompetition.description, ".
        "managedcompetitionseason.description, ".
        "managedcompetitionorganisation.description ".
        "FROM managedcompetition,managedcompetitionorganisation,managedcompetitionseason,team where ". 
        "managedcompetition.managedCompetitionSeasonID=managedcompetitionseason.ID AND ". 
        "managedcompetitionseason.managedCompetitionOrganisationID=managedcompetitionorganisation.ID and team.managedCompetitieID = managedcompetition.id ".
        $filter.
        "and team.teamname like '$team'";   
    }

    
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    while ($i < $num) {

        $item = new \stdClass();
        $item -> id = mysql_result($result, $i, "managedcompetition.id");
        $item -> competition = mysql_result($result, $i, "managedcompetition.description");
        $item -> season = mysql_result($result, $i, "managedcompetitionseason.description");
        $item -> organisation = mysql_result($result, $i, "managedcompetitionorganisation.description");
        $array[] = $item;
        $i++;
    }
    return $array;
}


/**************************************************
 */
function compareTeams($a, $b)
{
    if ($a->punten == $b->punten) {
        $diffa = $a->saldoVoor-$a->saldoTegen;
        $diffb = $b->saldoVoor-$b->saldoTegen;
        if ($diffa==$diffb) return 0;
        return ($diffa < $diffb) ? 1 : -1;
    }
    return ($a->punten < $b->punten) ? 1 : -1;
}


/**************************************************
 */
function loadManagedCompetitionData($managedCompetitionID) {
    global $conn;
    $compData = new \stdClass();
    $compData->games = array();
    $compData->teams = array();
    
    if ($managedCompetitionID==null) return $compData; 
    if ($managedCompetitionID=="") return $compData; 
        
    $query = "SELECT * FROM managedcompetition,managedcompetitionorganisation,managedcompetitionseason where ".
    "managedcompetition.managedCompetitionSeasonID=managedcompetitionseason.ID AND ".
    "managedcompetitionseason.managedCompetitionOrganisationID=managedcompetitionorganisation.ID and managedcompetition.id=$managedCompetitionID";
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    if ($num!=0) {
        $compData -> id = mysql_result($result, 0, "managedcompetition.id");
        $compData -> competition = mysql_result($result, 0, "managedcompetition.description");
        $compData -> season = mysql_result($result, 0, "managedcompetitionseason.description");
        $compData -> organisation = mysql_result($result, 0, "managedcompetitionorganisation.description");
    }
        
    
    // find all teams of this competition
    $teams = array();
    $teamsIndex = array();
    //$query = "SELECT * FROM team";
    $query = "SELECT * FROM team where managedCompetitieID='" . $managedCompetitionID . "' order by teamname";
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    while ($i < $num) {
        $item = new \stdClass();
        $item -> id = mysql_result($result, $i, "id");
        $item -> teamname = mysql_result($result, $i, "teamname");
        $item -> strafpunten = mysql_result($result, $i, "strafpunten");
        $item -> aanvoerder = mysql_result($result, $i, "aanvoerder");
        $item -> email = mysql_result($result, $i, "email");
        $item -> numGespeeld = 0;
        $item -> numGewonnen = 0;
        $item -> numVerloren = 0;
        $item -> numGelijk = 0;
        $item -> punten = 0-$item -> strafpunten;
        $item -> saldoVoor = 0;
        $item -> saldoTegen = 0;
        $teams[] = $item;
        $teamsIndex[$item -> id] = $item;
        //echo "##".$item -> id."#".$item -> teamname."<br>";
        $i++;
    }
    
    
    $array = array();
    $query = "SELECT * FROM managedgames,playround where managedgames.playroundID=playround.ID and playround.managedCompetitionID='" . $managedCompetitionID . "' order by managedgames.datetime";
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    while ($i < $num) {
        $item = new \stdClass();
        $item -> id = mysql_result($result, $i, "managedgames.id");
        $item -> teamID1 = mysql_result($result, $i, "managedgames.teamID1");
        $item -> teamID2 = mysql_result($result, $i, "managedgames.teamID2");
        $item -> teamName1 = "";
        $item -> teamName2 = "";
        $item -> score = mysql_result($result, $i, "managedgames.score");
        $item -> datetime = mysql_result($result, $i, "managedgames.datetime");
        $item -> playround = mysql_result($result, $i, "playround.description");
        $item -> location = mysql_result($result, $i, "managedgames.location");
        $team1 = null;                
        $team2 = null;                
        if (isset($teamsIndex[$item -> teamID1])){
            $team1 = $teamsIndex[$item -> teamID1];                
            $item -> teamName1 = $team1->teamname;
        }
        if (isset($teamsIndex[$item -> teamID2])){
            $team2 = $teamsIndex[$item -> teamID2];
            $item -> teamName2 = $team2->teamname;
        }
                

        $scoreArray = explode("-", $item -> score);        
        if (sizeof($scoreArray)==2){
            // update points for teams
            $goals1 = $scoreArray[0]; 
            $goals2 = $scoreArray[1];
            
            if ($team1!=null){
                $team1 -> saldoVoor+=$goals1;
                $team1 -> saldoTegen+=$goals2;
                $team1 -> numGespeeld+=1;
                if ($goals1==$goals2){
                    $team1 -> numGelijk+=1;
                    $team1 -> punten+=1;
                }
                if ($goals1>$goals2){
                    $team1 -> numGewonnen+=1;
                    $team1 -> punten+=3;
                }
                if ($goals1<$goals2){
                    $team1 -> numVerloren+=1;
                    $team1 -> punten+=0;
                }
            }
            if ($team2!=null){
                $team2 -> saldoVoor+=$goals2;
                $team2 -> saldoTegen+=$goals1;
                $team2 -> numGespeeld+=1;
                if ($goals1==$goals2){
                    $team2 -> numGelijk+=1;
                    $team2 -> punten+=1;
                }
                if ($goals2>$goals1){
                    $team2 -> numGewonnen+=1;
                    $team2 -> punten+=3;
                }
                if ($goals2<$goals1){
                    $team2 -> numVerloren+=1;
                    $team2 -> punten+=0;
                }
            }
             
        }

        
                
        
        $array[] = $item;
        $i++;
    }
    
    $compData->games = $array; 
    usort($teams,"dbcalls\compareTeams"); 
    $compData->teams = $teams; 
    return $compData;
}


/**************************************************
 */
function loadMAllCompetitionData($userID) {
    $item = new \stdClass();
    $item -> competitions = loadMCompetitions($userID);
    $item -> seasons = loadMSeasons($userID);
    $item -> organisations = loadMOrganisations($userID);    
    return $item;
}


/**************************************************
 */
function loadMCompetitions($userID) {
    global $conn;
    $array = array();
    $query = "SELECT ".
    "managedcompetition.description as competition ,".
    "managedcompetition.ID as competitionID,".
    "managedcompetitionseason.ID as seasonID,".
    "managedcompetitionorganisation.ID as organisationID,".
    "managedcompetitionseason.description as season,  ".
    "managedcompetitionorganisation.description as organisation ".
    
    "FROM managedcompetition,managedcompetitionseason,managedcompetitionorganisation where ".
    "managedcompetition.managedCompetitionSeasonID=managedcompetitionseason.id and ".
    "managedcompetitionseason.managedCompetitionOrganisationID = managedcompetitionorganisation.id and ".
    "managedcompetitionorganisation.userID = $userID";
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    while ($i < $num) {
        $item = new \stdClass();
        $item -> id = mysql_result($result, $i, "competitionID");;
        $item -> seasonID = mysql_result($result, $i, "seasonID");;
        $item -> organisationID = mysql_result($result, $i, "organisationID");;
        $item -> competition = mysql_result($result, $i, "competition");
        $item -> season = mysql_result($result, $i, "season");
        $item -> organisation = mysql_result($result, $i, "organisation");
        $array[] = $item;
        $i++;
    }
    
    return $array;
}


/**************************************************
 */
function loadMSeasons($userID) {
    global $conn;
    $array = array();
    $query = "SELECT ".
    "managedcompetitionseason.ID as seasonID,".
    "managedcompetitionorganisation.ID as organisationID,".
    "managedcompetitionseason.description as season,  ".
    "managedcompetitionorganisation.description as organisation ".
    
    "FROM managedcompetitionseason,managedcompetitionorganisation where ".
    "managedcompetitionseason.managedCompetitionOrganisationID = managedcompetitionorganisation.id and ".
    "managedcompetitionorganisation.userID = $userID";
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    while ($i < $num) {
        $item = new \stdClass();
        $item -> id = mysql_result($result, $i, "seasonID");;
        $item -> organisationID = mysql_result($result, $i, "organisationID");;
        $item -> season = mysql_result($result, $i, "season");
        $item -> organisation = mysql_result($result, $i, "organisation");
        $array[] = $item;
        $i++;
    }
    
    return $array;
}


/**************************************************
 */
function loadMOrganisations($userID) {
    global $conn;
    $array = array();
    $query = "SELECT ".
    "managedcompetitionorganisation.ID as organisationID,".
    "managedcompetitionorganisation.description as organisation ".   
    "FROM managedcompetitionorganisation where ".
    "managedcompetitionorganisation.userID = $userID";
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    while ($i < $num) {
        $item = new \stdClass();
        $item -> id = mysql_result($result, $i, "organisationID");;
        $item -> organisation = mysql_result($result, $i, "organisation");
        $array[] = $item;
        $i++;
    }
    
    return $array;
}


/**************************************************
 */
function removeMCompetition($competitionID) {
    global $conn;
    $q = "DELETE from managedcompetition WHERE id = '" . $competitionID . "';";
    logSQL($q,"remove managedcompetition", 0);
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    
    $q = "delete from playround where managedCompetitionID = ".$competitionID;
    logSQL($q,"removing playrounds belonging to managedcompetition", 0);
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    
    $q = "delete from team where managedCompetitieID = ".$competitionID;
    logSQL($q,"removing team belonging to managedcompetition", 0);
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    
    $q = "update competition set mCompetition=0 where mCompetition = ".$competitionID;
    logSQL($q,"update competition playrounds belonging to managedcompetition", 0);
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    
        
    
}


/**************************************************
 */
function updateMCompetitions($competitions) {
    global $conn;
    foreach ($competitions as $competition) {
        if ($competition != null) {
            $q = "UPDATE managedcompetition SET ".
            "description='" . $competition -> competition . "'". 
            " WHERE id = '" . $competition -> id . "';";
            logSQL($q,"update managedcompetition", 0);
            $res = mysql_query($q, $conn);
            if (mysql_errno()) {
                throw new \Exception(mysql_error());
            }
        }
    }
}


/**************************************************
 */
function addMCompetition($seasonID, $competition) {
    global $conn;
    $q = "INSERT INTO managedcompetition (`managedCompetitionSeasonID` , `description`) VALUES (".
    "$seasonID,'".mysql_real_escape_string($competition)."')";
    logSQL($q,"add managedcompetition", 0);
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $id = mysql_insert_id();
    return $id;
}



/**************************************************
 */
function removeMSeason($seasonID) {
    global $conn;
    $q = "DELETE from managedcompetitionseason WHERE id = '" . $seasonID . "';";
    logSQL($q,"remove managedcompetitionseason", 0);
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    // clean all orphan records (too much to do all separately)
    clearOrphanData();

}


/**************************************************
 */
function updateMSeason($seasons) {
    global $conn;
    foreach ($seasons as $season) {
        if ($season != null) {
            $q = "UPDATE managedcompetitionseason SET ".
            "description='" . $season -> season . "'". 
            " WHERE id = '" . $season -> id . "';";
            logSQL($q,"update managedcompetitionseason", 0);
            $res = mysql_query($q, $conn);
            if (mysql_errno()) {
                throw new \Exception(mysql_error());
            }
        }
    }

}


/**************************************************
 */
function addMSeason($organisationID, $season) {
    global $conn;
    $q = "INSERT INTO managedcompetitionseason (`managedCompetitionOrganisationID` , `description`) VALUES (".
    "$organisationID,'".mysql_real_escape_string($season)."')";
    logSQL($q,"add managedcompetitionseason", 0);
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $id = mysql_insert_id();
    return $id;
}



/**************************************************
 */
function removeMOrganisation($organisationID) {
    global $conn;
    $q = "DELETE from managedcompetitionorganisation WHERE id = '" . $organisationID . "';";
    logSQL($q,"remove managedcompetitionorganisation", 0);
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }

    // clean all orphan records (too much to do all separately)
    clearOrphanData();
}


/**************************************************
 */
function updateMOrganisation($organisations) {
    global $conn;
    foreach ($organisations as $organisation) {
        if ($organisation != null) {
            $q = "UPDATE managedcompetitionorganisation SET ".
            "description='" . $organisation -> organisation . "'". 
            " WHERE id = '" . $organisation -> id . "';";
            logSQL($q,"update managedcompetitionorganisation", 0);
            $res = mysql_query($q, $conn);
            if (mysql_errno()) {
                throw new \Exception(mysql_error());
            }
        }
    }

}


/**************************************************
 */
function addMOrganisation($userID, $organisation) {
    global $conn;
    $q = "INSERT INTO managedcompetitionorganisation (`userID` , `description`) VALUES (".
    "$userID,'".mysql_real_escape_string($organisation)."')";
    logSQL($q,"add managedcompetitionorganisation", 0);
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $id = mysql_insert_id();
    return $id;
}




/**************************************************
 */
function removeMGame($gameID) {
    global $conn;
    $q = "DELETE from managedgames WHERE id = '" . $gameID . "';";
    logSQL($q,"remove managedgames", 0);
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }

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


/**************************************************
 */
function updateMGames($games,$competitionID) {
    global $conn;
    foreach ($games as $game) {
        if ($game != null) {
            // first find or create the playround
            $playroundID = findOrCreatePlayround($game -> playround,$competitionID);            
            
            $q = "UPDATE managedgames SET ".
            "teamID1='" . $game -> teamID1 . "' ,".
            "teamID2='" . $game -> teamID2 . "' ,".
            "location='" . mysql_real_escape_string($game -> location) . "' ,".
            "playroundID='" . $playroundID . "' ,".
            "datetime='" . $game -> datetime . "' ,".
            "score='" . $game -> stand . "' ".
            " WHERE id = '" . $game -> id . "';";
            logSQL($q,"update managedgames", 0);
            $res = mysql_query($q, $conn);
            if (mysql_errno()) {
                throw new \Exception(mysql_error());
            }
        }
    }

}


/**************************************************
 */
function newMGames($games,$competitionID) {
    global $conn;
    foreach ($games as $game) {
        if ($game != null) {
            // first find or create the playround
            $playroundID = findOrCreatePlayround($game -> playround,$competitionID);
            $uid = $competitionID.$game -> playround.$game -> teamID1.$game -> teamID2;             

            
            $q = "INSERT INTO managedgames (".
            "`teamID1`,".
            "`teamID2`,".
            "`location`,".
            "`playroundID`,".
            "`datetime`,".
            "`gameUID`,".
            "`score`".
            ") VALUES (".
            "'" . $game -> teamID1 . "' ,".
            "'" . $game -> teamID2 . "' ,".
            "'" . mysql_real_escape_string($game -> location) . "' ,".
            "'" . $playroundID . "' ,".
            "'" . $game -> datetime . "' ,".
            "'" . mysql_real_escape_string($uid) . "' ,".
            "'" . $game -> stand . "' )";
            logSQL($q,"update managedgames", 0);
            $res = mysql_query($q, $conn);
            if (mysql_errno()) {
                throw new \Exception(mysql_error());
            }
        }
    }

}


/**************************************************
 */
function updateMTeams($teams) {
    global $conn;
    foreach ($teams as $team) {
        if ($team != null) {
            $q = "UPDATE team SET ".
            "teamname='" . mysql_real_escape_string($team -> teamname) . "' ,".
            "aanvoerder='" . mysql_real_escape_string($team -> aanvoerder) . "' ,".
            "email='" . mysql_real_escape_string($team -> email) . "' ,".
            "strafpunten='" . $team -> strafpunten . "' ".
            " WHERE id = '" . $team -> id . "';";
            logSQL($q,"updateMTeams", 0);
            $res = mysql_query($q, $conn);
            if (mysql_errno()) {
                throw new \Exception(mysql_error());
            }
        }
    }

}


/**************************************************
 */
function newMTeams($teams,$competitionID) {
    global $conn;
    foreach ($teams as $team) {
        if ($team != null) {
            $q = "INSERT INTO team (".
            "`teamname`,".
            "`aanvoerder`,".
            "`email`,".
            "`managedCompetitieID`".
            ") VALUES (".
            "'" . mysql_real_escape_string($team -> teamname) . "' ,".
            "'" . mysql_real_escape_string($team -> aanvoerder) . "' ,".
            "'" . mysql_real_escape_string($team -> email) . "' ,".
            "'" . $competitionID . "' )";
            logSQL($q,"newMTeams", 0);
            $res = mysql_query($q, $conn);
            if (mysql_errno()) {
                throw new \Exception(mysql_error());
            }
        }
    }

}


/**************************************************
 */
function clearTranslationKeys() {
    global $conn;
    $q = "DELETE from translatekeys";
    logSQL($q,"clearTranslationKeys", 0);
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
}

/**************************************************
 */
function newTranslateKey($filename, $key, $keynr, $pos1, $pos2) {
    global $conn;
    $q = "INSERT INTO translatekeys (".
    "`filename`,".
    "`keyCode`,".
    "`keyNr`,".
    "`pos1`,".
    "`pos2`".
    ") VALUES (".
    "'" . mysql_real_escape_string($filename) . "' ,".
    "'" . mysql_real_escape_string($key) . "' ,".
    "'" . mysql_real_escape_string($keynr) . "' ,".
    "" . $pos1 . " ,".
    "" . $pos2 . " )";
    
    logSQL($q,"newTranslateKey", 0);
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }

    // check if key is already in translated list
    $q = "select id from translation where keyCode = '" . mysql_real_escape_string($key) . "' and keyNr='$keynr'";
    $result = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    if ($num ==  0) {
        $q = "INSERT INTO translation (".
        "`keyCode`,".
        "`keyNr`".
        ") VALUES (".
        "'" . mysql_real_escape_string($key) . "' ,".
        "'" . mysql_real_escape_string($keynr) . "' )";

        $res = mysql_query($q, $conn);
        if (mysql_errno()) {
            throw new \Exception(mysql_error());
        }
    }


}


/**************************************************
 */
function addPayment($userID, $dateInterval) {
    global $conn;
    
    $oldDate = getProEndDate($userID);
    $format = 'Y-m-d';
    $newDate = \DateTime::createFromFormat($format, $oldDate);
    $currentDate = new \DateTime();
    if ($currentDate>$newDate){
        $newDate = $currentDate;
    }
    $newDate->add(new \DateInterval($dateInterval));
    $newDateStr = $newDate->format( 'Y-m-d' );
    setProEndDate($userID, $newDateStr);
    $q = "INSERT INTO payment (".
    "`userID`,".
    "`product`,".
    "`paymentDate`,".
    "`previousEndProDate`,".
    "`newEndProDate`".
    ") VALUES (".
    "".$userID." ,".
    "'MONTH' ,".
    " NOW() ,".
    " '".$oldDate."' ,".
    " '".$newDateStr."' )";
    $result = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    return $newDateStr;
}

/**************************************************
 */
function logPayment($userID, $result , $action) {
    global $conn;
    
    $oldDate = getProEndDate($userID);
    $format = 'Y-m-d';
    $newDate = \DateTime::createFromFormat($format, $oldDate);
    $newDateStr = $newDate->format( 'Y-m-d' );
    $q = "INSERT INTO paymentlog (".
    "`userID`,".
    "`action`,".
    "`result`,".
    "`logDate`,".
    "`currentEndProDate` ".
    ") VALUES (".
    "".$userID." ,".
    "'" . mysql_real_escape_string($action) . "' ,".
    "'" . mysql_real_escape_string($result) . "' ,".
    " NOW() ,".
    " '".$newDateStr."' )";
    //echo $q;
    $result = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    return true;
}

