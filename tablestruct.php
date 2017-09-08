<?
namespace tablestruct;

/* Include Files *********************/
include_once ("database.php");
include_once("dbstruct.php");
/*************************************/

/**************************************************
 */
function getRequiredSQLSchema($tablename) {
    global $conn;
    $item = new \stdClass();
    $item->schema="";

    if ($tablename=="team"){
        $item->schema.="CREATE TABLE `team` (";
        $item->schema.="`id` bigint(20) NOT NULL AUTO_INCREMENT,";
        $item->schema.="`teamname` varchar(256) NOT NULL,";
        $item->schema.="`listname1` varchar(1024) DEFAULT NULL,";
        $item->schema.="`listname2` varchar(1024) DEFAULT NULL,";
        $item->schema.="`listname3` varchar(1024) DEFAULT NULL,";
        $item->schema.="`listname4` varchar(1024) DEFAULT NULL,";
        $item->schema.="`listname5` varchar(1024) DEFAULT NULL,";
        $item->schema.="`listname6` varchar(1024) DEFAULT NULL,";
        $item->schema.="`listname7` varchar(1024) DEFAULT NULL,";
        $item->schema.="`listname8` varchar(1024) DEFAULT NULL,";
        $item->schema.="`listname9` varchar(1024) DEFAULT NULL,";
        $item->schema.="`listname10` varchar(1024) DEFAULT NULL,";
        $item->schema.="`listtype1` int(11) DEFAULT NULL,";
        $item->schema.="`listtype2` int(11) DEFAULT NULL,";
        $item->schema.="`listtype3` int(11) DEFAULT NULL,";
        $item->schema.="`listtype4` int(11) DEFAULT NULL,";
        $item->schema.="`listtype5` int(11) DEFAULT NULL,";
        $item->schema.="`listtype6` int(11) DEFAULT NULL,";
        $item->schema.="`listtype7` int(11) DEFAULT NULL,";
        $item->schema.="`listtype8` int(11) DEFAULT NULL,";
        $item->schema.="`listtype9` int(11) DEFAULT NULL,";
        $item->schema.="`listtype10` int(11) DEFAULT NULL,";
        $item->schema.="`vereniging` varchar(1024) DEFAULT NULL,";
        $item->schema.="`sport` varchar(1024) DEFAULT NULL,";
        $item->schema.="`voorkeursNrAanwezig` int(10) DEFAULT '13',";
        $item->schema.="`tekortMailTo` int(10) DEFAULT '0',";
        $item->schema.="`waarschuwingMailTo` int(10) DEFAULT '0',";
        $item->schema.="`waarschuwingMailDagen` int(10) DEFAULT '2',";
        $item->schema.="`reminderDays` int(10) DEFAULT '5',";
        $item->schema.="`managedCompetitieID` bigint(20) NOT NULL,";
        $item->schema.="`strafpunten` bigint(20) NOT NULL,";
        $item->schema.="`aanvoerder` varchar(1024) DEFAULT NULL,";
        $item->schema.="`email` varchar(1024) DEFAULT NULL,";
        $item->schema.="UNIQUE KEY `id` (`id`)";
        $item->schema.=") ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1";
    }

    if ($tablename=="games"){
        $item->schema.="CREATE TABLE `games` (";
        $item->schema.=" `teamID` bigint(20) NOT NULL,";
        $item->schema.=" `datetime` bigint(20) NOT NULL,";
        $item->schema.=" `opponent` varchar(100) DEFAULT NULL,";
        $item->schema.=" `id` bigint(20) NOT NULL AUTO_INCREMENT,";
        $item->schema.=" `competitionID` bigint(20) NOT NULL,";
        $item->schema.=" `membersPresentYes` varchar(255) DEFAULT NULL,";
        $item->schema.=" `membersPresentNo` varchar(255) DEFAULT NULL,";
        $item->schema.=" `goals` varchar(255) DEFAULT NULL,";
        $item->schema.=" `meetingpoint` varchar(100) DEFAULT '',";
        $item->schema.=" `score` varchar(10) DEFAULT NULL,";
        $item->schema.=" `homegame` tinyint(1) DEFAULT NULL,";
        $item->schema.=" `list1` varchar(1024) DEFAULT NULL,";
        $item->schema.=" `list2` varchar(1024) DEFAULT NULL,";
        $item->schema.=" `list3` varchar(1024) DEFAULT NULL,";
        $item->schema.=" `list4` varchar(1024) DEFAULT NULL,";
        $item->schema.=" `list5` varchar(1024) DEFAULT NULL,";
        $item->schema.=" `list6` varchar(1024) DEFAULT NULL,";
        $item->schema.=" `list7` varchar(1024) DEFAULT NULL,";
        $item->schema.=" `list8` varchar(1024) DEFAULT NULL,";
        $item->schema.=" `list9` varchar(1024) DEFAULT NULL,";
        $item->schema.=" `list10` varchar(1024) DEFAULT NULL,";
        $item->schema.=" `points` int(11) DEFAULT NULL,";
        $item->schema.=" `messages` mediumtext,";
        $item->schema.=" `gameType` int(11) DEFAULT NULL,";
        $item->schema.=" `gameStatus` int(11) DEFAULT NULL,";
        $item->schema.=" `gameDetails` varchar(1024) DEFAULT NULL,";
        $item->schema.=" `gameReport` varchar(20480) DEFAULT NULL,";
        $item->schema.=" `remindersSended` int(10) NOT NULL DEFAULT '0',";
        $item->schema.=" `tooShortSended` int(11) NOT NULL DEFAULT '0',";
        $item->schema.=" `warningSended` int(11) NOT NULL DEFAULT '0',";
        $item->schema.=" `mGameID` bigint(20) NOT NULL,";
        $item->schema.=" `gameUID` varchar(1024) DEFAULT NULL,";
        //        $item->schema.=" `gameUID` varchar(1024) DEFAULT NULL,";
        $item->schema.=" UNIQUE KEY `id` (`id`),";
        $item->schema.=" KEY `teamID` (`teamID`),";
        $item->schema.=" KEY `competitionID` (`competitionID`),";
        $item->schema.=" KEY `gameType` (`gameType`)";
        $item->schema.=") ENGINE=MyISAM AUTO_INCREMENT=131 DEFAULT CHARSET=latin1";
    }

    if ($tablename=="managedgames"){
        $item->schema.="CREATE TABLE `managedgames` (";
        $item->schema.=" `id` bigint(20) NOT NULL AUTO_INCREMENT,";
        $item->schema.=" `teamID1` bigint(20) NOT NULL,";
        $item->schema.=" `teamID2` bigint(20) NOT NULL,";
        $item->schema.=" `playroundID` bigint(20) NOT NULL,";
        $item->schema.=" `lookup1ID` bigint(20) NOT NULL,";
        $item->schema.=" `lookup2ID` bigint(20) NOT NULL,";
        $item->schema.=" `lookup3ID` bigint(20) NOT NULL,";
        $item->schema.=" `lookup4ID` bigint(20) NOT NULL,";
        $item->schema.=" `lookup5ID` bigint(20) NOT NULL,";
        $item->schema.=" `datetime` bigint(20) NOT NULL,";
        $item->schema.=" `location` varchar(100) DEFAULT '',";
        $item->schema.=" `score` varchar(10) DEFAULT NULL,";
        $item->schema.=" `gameUID` varchar(1024) DEFAULT NULL,";
        $item->schema.=" UNIQUE KEY `id` (`id`),";
        $item->schema.=" KEY `teamID1` (`teamID1`),";
        $item->schema.=" KEY `teamID2` (`teamID2`),";
        $item->schema.=" KEY `playroundID` (`playroundID`)";
        $item->schema.=") ENGINE=MyISAM AUTO_INCREMENT=131 DEFAULT CHARSET=latin1";
    }

    if ($tablename=="playround"){
        $item->schema.="CREATE TABLE `playround` (";
        $item->schema.=" `id` bigint(20) NOT NULL AUTO_INCREMENT,";
        $item->schema.=" `managedCompetitionID` bigint(20) NOT NULL,";
        $item->schema.=" `description` varchar(100) DEFAULT NULL,";
        $item->schema.=" UNIQUE KEY `id` (`id`),";
        $item->schema.=" KEY `managedCompetitionID` (`managedCompetitionID`)";
        $item->schema.=") ENGINE=MyISAM AUTO_INCREMENT=131 DEFAULT CHARSET=latin1";
    }

    if ($tablename=="managedcompetition"){
        $item->schema.="CREATE TABLE `managedcompetition` (";
        $item->schema.=" `id` bigint(20) NOT NULL AUTO_INCREMENT,";
        $item->schema.=" `managedCompetitionSeasonID` bigint(20) NOT NULL,";
        $item->schema.=" `description` varchar(100) DEFAULT NULL,";
        $item->schema.=" UNIQUE KEY `id` (`id`),";
        $item->schema.=" KEY `managedCompetitionSeasonID` (`managedCompetitionSeasonID`)";
        $item->schema.=") ENGINE=MyISAM AUTO_INCREMENT=131 DEFAULT CHARSET=latin1";
    }

    if ($tablename=="managedcompetitionseason"){
        $item->schema.="CREATE TABLE `managedcompetitionseason` (";
        $item->schema.=" `id` bigint(20) NOT NULL AUTO_INCREMENT,";
        $item->schema.=" `managedCompetitionOrganisationID` bigint(20) NOT NULL,";
        $item->schema.=" `description` varchar(100) DEFAULT NULL,";
        $item->schema.=" `status` int(11) DEFAULT NULL,";
        $item->schema.=" UNIQUE KEY `id` (`id`),";
        $item->schema.=" KEY `managedCompetitionOrganisationID` (`managedCompetitionOrganisationID`)";
        $item->schema.=") ENGINE=MyISAM AUTO_INCREMENT=131 DEFAULT CHARSET=latin1";
    }

    if ($tablename=="managedcompetitionorganisation"){
        $item->schema.="CREATE TABLE `managedcompetitionorganisation` (";
        $item->schema.=" `id` bigint(20) NOT NULL AUTO_INCREMENT,";
        $item->schema.=" `userID` bigint(20) NOT NULL,";
        $item->schema.=" `description` varchar(100) DEFAULT NULL,";
        $item->schema.=" UNIQUE KEY `id` (`id`),";
        $item->schema.=" KEY `userID` (`userID`)";
        $item->schema.=") ENGINE=MyISAM AUTO_INCREMENT=131 DEFAULT CHARSET=latin1";
    }
    
    if ($tablename=="competition"){
        $item->schema.="CREATE TABLE `competition` (";
        $item->schema.=" `id` bigint(20) NOT NULL AUTO_INCREMENT,";
        $item->schema.=" `mTeamID` bigint(20) NOT NULL,";
        $item->schema.=" `teamID` bigint(20) NOT NULL,";
        $item->schema.=" `mCompetition` bigint(20) NOT NULL,";
        $item->schema.=" `description` varchar(100) DEFAULT NULL,";
        $item->schema.=" `season` varchar(100) DEFAULT NULL,";
        $item->schema.=" `type` int(11) DEFAULT NULL,";
        $item->schema.=" `status` int(11) DEFAULT NULL,";
        $item->schema.=" UNIQUE KEY `id` (`id`),";
        $item->schema.=" KEY `teamid` (`teamID`)";
        $item->schema.=") ENGINE=MyISAM AUTO_INCREMENT=131 DEFAULT CHARSET=latin1";
    }


    if ($tablename=="teammember"){
        $item->schema.=" CREATE TABLE `teammember` (";
        $item->schema.=" `admin` varchar(1) NOT NULL,";
        $item->schema.=" `teamID` bigint(20) NOT NULL,";
        $item->schema.=" `nickname` varchar(100) DEFAULT NULL,";
        $item->schema.=" `id` bigint(20) NOT NULL AUTO_INCREMENT,";
        $item->schema.=" `userID` bigint(20) DEFAULT NULL,";
        $item->schema.=" `deleted` tinyint(1) DEFAULT '0',";
        $item->schema.=" `supporter` tinyint(1) DEFAULT '0',";
        $item->schema.=" `invaller` tinyint(1) DEFAULT '0',";
        $item->schema.=" `invitationEmail` varchar(100) DEFAULT NULL,";
        $item->schema.=" `invitationDate` date DEFAULT NULL,";
        $item->schema.=" `invitationID` varchar(20) NOT NULL,";
        $item->schema.=" `acceptEmail` int(10) DEFAULT '1',";
        $item->schema.=" UNIQUE KEY `id` (`id`),";
        $item->schema.=" KEY `teamid` (`teamID`),";
        $item->schema.=" KEY `userID` (`userID`)";
        $item->schema.=") ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=latin1";
    }
    if ($tablename=="users"){
        $item->schema.="CREATE TABLE `users` (";
        $item->schema.=" `email` varchar(100) DEFAULT NULL,";
        $item->schema.=" `name` varchar(100) DEFAULT NULL,";
        $item->schema.=" `id` bigint(20) NOT NULL AUTO_INCREMENT,";
        $item->schema.=" `username` varchar(100) DEFAULT NULL,";
        $item->schema.=" `password` varchar(100) DEFAULT NULL,";
        $item->schema.=" `activeAccount` tinyint(1) NOT NULL,";
        $item->schema.=" `activationID` varchar(30) NOT NULL,";
        $item->schema.=" `creationDate` date NOT NULL,";
        $item->schema.=" `endProDate` date NOT NULL,";
        $item->schema.=" `phonenumber` varchar(64) DEFAULT NULL,";
        $item->schema.=" `requestConnectTeam` varchar(30) NOT NULL,";
        $item->schema.=" `proUser` tinyint(1) NOT NULL,";
        $item->schema.=" UNIQUE KEY `id` (`id`),";
        $item->schema.=" UNIQUE KEY `username` (`username`)";
        $item->schema.=") ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1";
    }
    if ($tablename=="payment"){
        $item->schema.="CREATE TABLE `payment` (";
        $item->schema.=" `id` bigint(20) NOT NULL AUTO_INCREMENT,";
        $item->schema.=" `userID` bigint(20) NOT NULL,";
        $item->schema.=" `product` varchar(100) DEFAULT NULL,";
        $item->schema.=" `paymentDate` date NOT NULL,";
        $item->schema.=" `previousEndProDate` date NOT NULL,";
        $item->schema.=" `newEndProDate` date NOT NULL,";
        $item->schema.=" UNIQUE KEY `id` (`id`),";
        $item->schema.=" KEY `userID` (`userID`)";
        $item->schema.=") ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1";
    }
    if ($tablename=="paymentlog"){
        $item->schema.="CREATE TABLE `paymentlog` (";
        $item->schema.=" `id` bigint(20) NOT NULL AUTO_INCREMENT,";
        $item->schema.=" `userID` bigint(20) NOT NULL,";
        $item->schema.=" `action` varchar(100) DEFAULT NULL,";
        $item->schema.=" `result` varchar(100) DEFAULT NULL,";
        $item->schema.=" `logDate` datetime NOT NULL,";
        $item->schema.=" `currentEndProDate` date NOT NULL,";
        $item->schema.=" UNIQUE KEY `id` (`id`),";
        $item->schema.=" KEY `userID` (`userID`)";
        $item->schema.=") ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1";
    }
        if ($tablename=="log"){
        $item->schema.="CREATE TABLE `log` (";
        $item->schema.=" `id` bigint(20) NOT NULL AUTO_INCREMENT,";
        $item->schema.=" `username` varchar(30) NOT NULL,";
        $item->schema.=" `date` date NOT NULL,";
        $item->schema.=" `time` time NOT NULL,";
        $item->schema.=" `statement` varchar(10240) DEFAULT '',";
        $item->schema.=" `type` bigint(20) DEFAULT NULL,";
        $item->schema.=" `gameID` bigint(20) DEFAULT NULL,";
        $item->schema.=" `teamID` bigint(20) DEFAULT NULL,";
        $item->schema.=" `userID` bigint(20) DEFAULT NULL,";
        $item->schema.=" `memberID` bigint(20) DEFAULT NULL,";
        $item->schema.=" `description` varchar(100) DEFAULT NULL,";
        $item->schema.=" UNIQUE KEY `id` (`id`)";
        $item->schema.=") ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1";
    }
    if ($tablename=="translatekeys"){
        $item->schema.="CREATE TABLE `translatekeys` (";
        $item->schema.=" `id` bigint(20) NOT NULL AUTO_INCREMENT,";
        $item->schema.=" `filename` varchar(300) NOT NULL,";
        $item->schema.=" `keyCode` varchar(10240) NOT NULL,";
        $item->schema.=" `keyNr` varchar(20) DEFAULT NULL,";
        $item->schema.=" `pos1` bigint(20) DEFAULT NULL,";
        $item->schema.=" `pos2` bigint(20) DEFAULT NULL,";
        $item->schema.=" UNIQUE KEY `id` (`id`)";
        $item->schema.=") ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1";
    }
    if ($tablename=="translation"){
        $item->schema.="CREATE TABLE `translation` (";
        $item->schema.=" `id` bigint(20) NOT NULL AUTO_INCREMENT,";
        $item->schema.=" `keyCode` varchar(10240) NOT NULL,";
        $item->schema.=" `keyNr` bigint(20) DEFAULT NULL,";
        $item->schema.=" `translatedText` varchar(10240) DEFAULT NULL,";
        $item->schema.=" UNIQUE KEY `id` (`id`)";
        $item->schema.=") ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1";
    }
            
            
    if ($tablename=="gcmclients"){ // this contains all google cloud message phone clients that needs callback (also use for other applications besides teamsport)
        $item->schema.="CREATE TABLE `gcmclients` (";
        $item->schema.="`id` bigint(20) NOT NULL AUTO_INCREMENT,";
        $item->schema.="`regid` varchar(256) NOT NULL,";
        $item->schema.="`registrationdate` datetime DEFAULT NULL,";
        $item->schema.="`application` varchar(256) DEFAULT NULL,";
        $item->schema.="`applicationData` varchar(256) DEFAULT NULL,";
        $item->schema.="UNIQUE KEY `id` (`id`)";
        $item->schema.=") ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1";
    }
                        
            
    return $item;
}



/**************************************************
 */
function getSQLSchema($tablename) {
    global $conn;
    $item = new \stdClass();
    $item->schema.="";

    // test if table exists
    if( !mysql_num_rows( mysql_query("SHOW TABLES LIKE '".$tablename."'"))){
        return $item;
    }

    $query = "SHOW CREATE TABLE ".$tablename;
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    if ($num==1) {
        $item->schema = mysql_result($result, $i, "CREATE TABLE");
        //echo $item->schema;
    }
    return $item;
}


/**************************************************
 */
function performSQLSchemaChanges() {
    global $conn;
    $changes = getSQLSchemaChanges();
  //  echo $changes->changes;
    foreach ($changes->changes as &$change) {
        if ($change!='ALTER TABLE `competition` DROP PRIMARY') {
                
//        echo $change."<br><br>";
                
            $query = $change;
            $result = mysql_query($query, $conn);
            if (mysql_errno()) {
                throw new \Exception(mysql_error());
            }
        }

    }
}


/**************************************************
 */
function getSQLSchemaChanges() {
    $item = new \stdClass();
    $item->schema.="";
    $schema1=getSQLSchema("team");
    $schema2=getRequiredSQLSchema("team");

    $updater = new \dbStructUpdater();

    $item->changes = array();
    $item->changes = array_merge((array)$item->changes, (array)getSQLSchemaChangesTable("games",$updater));
    $item->changes = array_merge((array)$item->changes, (array)getSQLSchemaChangesTable("team",$updater));
    $item->changes = array_merge((array)$item->changes, (array)getSQLSchemaChangesTable("teammember",$updater));
    $item->changes = array_merge((array)$item->changes, (array)getSQLSchemaChangesTable("users",$updater));
    $item->changes = array_merge((array)$item->changes, (array)getSQLSchemaChangesTable("payment",$updater));
    $item->changes = array_merge((array)$item->changes, (array)getSQLSchemaChangesTable("paymentlog",$updater));
    $item->changes = array_merge((array)$item->changes, (array)getSQLSchemaChangesTable("log",$updater));
    $item->changes = array_merge((array)$item->changes, (array)getSQLSchemaChangesTable("managedgames",$updater));
    $item->changes = array_merge((array)$item->changes, (array)getSQLSchemaChangesTable("playround",$updater));
    $item->changes = array_merge((array)$item->changes, (array)getSQLSchemaChangesTable("managedcompetition",$updater));
    $item->changes = array_merge((array)$item->changes, (array)getSQLSchemaChangesTable("managedcompetitionseason",$updater));
    $item->changes = array_merge((array)$item->changes, (array)getSQLSchemaChangesTable("managedcompetitionorganisation",$updater));
    $item->changes = array_merge((array)$item->changes, (array)getSQLSchemaChangesTable("managedcompetitionuser",$updater));
    $item->changes = array_merge((array)$item->changes, (array)getSQLSchemaChangesTable("competition",$updater));
    $item->changes = array_merge((array)$item->changes, (array)getSQLSchemaChangesTable("translatekeys",$updater));
    $item->changes = array_merge((array)$item->changes, (array)getSQLSchemaChangesTable("translation",$updater));
    $item->changes = array_merge((array)$item->changes, (array)getSQLSchemaChangesTable("gcmclients",$updater));
    
        

    return $item;
}

/**************************************************
 */
function getSQLSchemaChangesTable($table,$updater) {
    $item = new \stdClass();
    $item->schema="";
    $schema1=getSQLSchema($table);
    $schema2=getRequiredSQLSchema($table);
    $updater = new \dbStructUpdater();
    $res = $updater->getUpdates($schema1->schema,$schema2->schema);
    return $res;
}



?>