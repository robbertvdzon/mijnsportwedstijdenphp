<?
namespace demodata;

/* Include Files *********************/
include_once ("database.php");
/*************************************/

/**************************************************
 */
function removeDemodata() {
    for ($index=-100; $index>-103; $index--){
        removeGames($index); 
        removeCompetition($index);
        removeDemoTeam($index);
    }
    for ($index=-100; $index>-110; $index--){
        removeDemoUser($index);
    }
    return true;
}

/*************************************/

/**************************************************
 */
function generateDemodata() {
    global $conn;

    for ($index=-100; $index>-103; $index--){
        createDemoTeam($index);
        generateCompetition($index);// 1 seizoen per team
        generateGames($index); // elke week een wedstrijd
    }


    for ($index=-100; $index>-110; $index--){
        createDemoUser($index);
        if ($index!=-109){ // demo9 heeft geen team
            addTeamsToUser($index); // sowiso eerste team en misschien meer
        }
    }
}

/**************************************************
 */
function removeGames($teamID) {
	global $conn;
	$q = "DELETE from games WHERE teamID = '" . $teamID . "';";
	$res = mysql_query($q, $conn);
	if (mysql_errno()) {
		throw new \Exception(mysql_error());
	}
}

/**************************************************
 */
function removeCompetition($teamID) {
    global $conn;
    $q = "DELETE from competition WHERE teamID = '" . $teamID . "';";
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
}

/**************************************************
 */
function removeDemoTeam($teamID) {
    global $conn;
    $q = "DELETE from team WHERE id = '" . $teamID . "';";
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
}

/**************************************************
 */
function removeDemoUser($userID) {
    global $conn;
    $q = "DELETE from teammember WHERE userID = '" . $userID . "';";
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    
    $q = "DELETE from users WHERE id = '" . $userID . "';";
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }    
}

/**************************************************
 */
function createDemoTeam($teamID){
    global $conn;
    $teamName = "";
/*T1405T*/    
    if ($teamID==-100) $teamName = "De Slagers";
    if ($teamID==-101) $teamName = "De Bouwvakkers";
    if ($teamID==-102) $teamName = "De Monteurs";
    if ($teamID==-103) $teamName = "De Slagers";
/*T1405T*/    
        
    $q = "INSERT INTO team (`id`,`teamname`) VALUES ('$teamID','$teamName')";
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
}

/**************************************************
 */
function generateCompetition($teamID){
    global $conn;
    $year = date("Y");
    $q = "INSERT INTO competition (`teamID`,`id`,`season`,`description`) VALUES ('$teamID','$teamID',$year,'Poule A')";
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
}

/**************************************************
 */
function getRandomOpponent(){
    $index = rand(0,12);
/*T1406T*/        
    if ($index==0) return "De Stratenmakers";
    if ($index==1) return "De Voegers";
    if ($index==2) return "De Molenaars";
    if ($index==3) return "De Vissers";
    if ($index==4) return "De Jagers";
    if ($index==5) return "De Kapiteinen";
    if ($index==6) return "De Knechten";
    if ($index==7) return "De Zangers";
    if ($index==8) return "De Wachtlopers";
    if ($index==9) return "De Bakkers";
    if ($index==10) return "De Boeren";
    if ($index==11) return "De Tuinders";
    if ($index==12) return "De Chauffeurs";
/*T1406T*/        
}
 
/**************************************************
 */
function generateGames($teamID){
    global $conn;
    $year = date('Y');

    $offsetDay = rand(10,7);
    $now = time();
    while ($offsetDay<364){
        $homeGame = rand(0,1);
        $opponent = getRandomOpponent();
        $date = strtotime("1 Jan $year +$offsetDay day");
        $date += 21*60*60;
        $stand = "";
        $points = 0;
        if ($date<$now){
            $score1 = rand(0,5);
            $score2 = rand(0,5);
            $stand = $score1."-".$score2;
            if ($score1==$score2){
                $points = 1;
            }
            else {
                if ($homeGame==1){
                    if ($score1>$score2){
                        $points = 3;
                    }
                }
                else{
                    if ($score1<$score2){
                        $points = 3;
                    }
                }
            }
        }
        
        $messagesNr1 = rand(0,20);
        $messagesNr2 = rand(0,20);
        $messagesNr3 = rand(0,20);
        $messages = "";
        if ($messagesNr2==$messagesNr1) $messagesNr2 = -1;
        if ($messagesNr3==$messagesNr1 || $messagesNr3==$messagesNr2) $messagesNr3 = -1;
        $messages .= getMessage($messagesNr1);
        $messages .= getMessage($messagesNr2);
        $messages .= getMessage($messagesNr3);
        
        
        //$dateTime = date("Y-m-d",$date);
        //$dateTime.=" 21:00";
        $q = "INSERT INTO games (`teamID`,`competitionID`,`opponent`,`homegame`,`datetime`,`score`,`points`,`messages`) VALUES ('$teamID','$teamID','$opponent',$homeGame,$date,'$stand',$points,'$messages')";
        $res = mysql_query($q, $conn);
        if (mysql_errno()) {
            throw new \Exception(mysql_error());
        }
        $offsetDay += rand(10,7);
    }
}

function getMessage($messagesNr){
    switch ($messagesNr) {
/*T1407T*/            
        case 0: return "<b>om 09:41 schreef Peter</b><br>Ik weet nog niet of ik er ben<br><br>";
        case 1: return "<b>om 10:22 schreef Jan</b><br>Ik moet nog even overleggen met mijn werk, later horen jullie meer<br><br>";
        case 2: return "<b>om 11:42 schreef Kees</b><br>Ik ben er gewoon hoor!<br><br>";
        case 3: return "<b>om 12:11 schreef Peter</b><br>Zal ik anders keepen? Heb een beetje last van mn knie...<br><br>";
        case 4: return "<b>om 13:15 schreef John</b><br>Wie heeft de shirts eigenlijk?<br><br>";
/*T1407T*/    
                
    }
    return "";
}


/**************************************************
 */
function getUsername($userID){
    $userName = $userID;
/*T1408T*/        
    if ($userID==-100) $userName = "demo";
    if ($userID==-101) $userName = "demo1";
    if ($userID==-102) $userName = "demo2";
    if ($userID==-103) $userName = "demo3";    
    if ($userID==-104) $userName = "demo4";    
    if ($userID==-105) $userName = "demo5";    
    if ($userID==-106) $userName = "demo6";    
    if ($userID==-107) $userName = "demo7";    
    if ($userID==-108) $userName = "demo8";    
    if ($userID==-109) $userName = "demo9";
/*T1408T*/    
    return $userName;    
}

/**************************************************
 */
function getName($userID){
    $userName = $userID;
/*T1409T*/    
    if ($userID==-100) $userName = "Peter";
    if ($userID==-101) $userName = "Jan";
    if ($userID==-102) $userName = "Kees";
    if ($userID==-103) $userName = "Rob";    
    if ($userID==-104) $userName = "Bob";    
    if ($userID==-105) $userName = "Ben";    
    if ($userID==-106) $userName = "Dirk";    
    if ($userID==-107) $userName = "Sjaak";    
    if ($userID==-108) $userName = "Marcel";    
    if ($userID==-109) $userName = "Piet";
/*T1409T*/    
    return $userName;
        
}

/**************************************************
 */
function createDemoUser($userID){   
    global $conn;
//    $email = getName($userID)."@demo.nl";
    $email = "";
    $name = getName($userID);
    $username = getUsername($userID);
    $md5pass = md5('demo');            
    $q = "INSERT INTO users (`id`,`email`,`name`,`username`,`password`,`activeAccount`,`activationID`,`creationDate`, `proUser`) ".
        "VALUES ('$userID','$email','$name','$username','$md5pass',1,0,0,1)";
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
}

/**************************************************
 */
function addTeamsToUser($userID){
    global $conn;
    // altijd -100, en soms ook -101, -102 en -103
    $nickname = getName($userID);
    for ($index=-100; $index>-103; $index--){
        $add = rand(0,1);
        if ($index==-100) $add = 1;
        if ($add==1){
            $q = "INSERT INTO teammember (`teamID`,`nickname`,`userID`,`admin`) ".
                "VALUES ('$index','$nickname','$userID','1')";
            $res = mysql_query($q, $conn);
            if (mysql_errno()) {
                throw new \Exception(mysql_error());
            }
        }        
    }
    
}
