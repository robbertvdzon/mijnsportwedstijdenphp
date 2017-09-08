<?
namespace cron;

/* Include Files *********************/
include_once ("database.php");
include_once ("teamsport.php");
include_once ("dbcalls.php");
include_once ("platform/platformsettings.php");

/*************************************/


$testmode = false;

/**************************************************
 */
function callCron() {
    global $conn;
    // find now()
    echo "START AT: ".date('h:i:s:u')."<br>";
    $now=date("U",time())+date("Z",time());
    $date =  new \DateTime('@'.$now);   
    echo "timestamp used to compare ".$date->format('Y-m-d H:i:s')."(".$now.")<br>";
    \dbcalls\logSQL2("","Start send reminders/warnings and errors", 1, "root");
     
    $afterTwoWeeks = $now+(2*7*24*60*60);
    

    // find all games
    $query = "SELECT ".
    "games.datetime, ".
    "games.id, ".
    "games.remindersSended, ".
    "games.tooShortSended, ".
    "games.warningSended, ".
    "games.teamID, ".
    "games.membersPresentYes, ".
    "games.membersPresentNo, ".
    "games.opponent, ".
    "games.homegame, ".
    "games.meetingpoint, ".
    "games.messages, ".
    "team.voorkeursNrAanwezig, ".
    "team.tekortMailTo, ".
    "team.waarschuwingMailTo, ".
    "team.waarschuwingMailDagen, ".
    "team.reminderDays, ".
    "team.teamname ".
    "FROM games,team where games.teamID=team.id";
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    
    $daysfWeek = array(
    0 => "zondag",
    1 => "maandag",
    2 => "dinsdag",
    3 => "woensdag",
    4 => "donderdag",
    5 => "vrijdag",
    6 => "zaterdag");
    
    $i = 0;
    while ($i < $num) {
        $gameID = mysql_result($result, $i, "games.id");
        $datetime = mysql_result($result, $i, "datetime");
        $dateStr =   date('d-m-Y', $datetime-date("Z",$datetime)); 
        $timeStr =   date('H:i', $datetime-date("Z",$datetime)); 
        $dayOfWeek =   $daysfWeek[date('w', $datetime-date("Z",$datetime))]; 
        $remindersSended = mysql_result($result, $i, "games.remindersSended");
        $tooShortSended = mysql_result($result, $i, "games.tooShortSended");
        $warningSended = mysql_result($result, $i, "games.warningSended");
        $teamID = mysql_result($result, $i, "games.teamID");
        $membersPresentYes = mysql_result($result, $i, "games.membersPresentYes");
        $membersPresentNo = mysql_result($result, $i, "games.membersPresentNo");
        $opponent = mysql_result($result, $i, "games.opponent");
        $homegame = mysql_result($result, $i, "games.homegame");
        $meetingpoint = mysql_result($result, $i, "games.meetingpoint");
        $messages = mysql_result($result, $i, "games.messages");
        $voorkeursNrAanwezig = mysql_result($result, $i, "team.voorkeursNrAanwezig");
        $tekortMailTo = mysql_result($result, $i, "team.tekortMailTo");
        $waarschuwingMailTo = mysql_result($result, $i, "team.waarschuwingMailTo");
        $waarschuwingMailDagen = mysql_result($result, $i, "team.waarschuwingMailDagen");
        $reminderDays = mysql_result($result, $i, "team.reminderDays");
        $teamname = mysql_result($result, $i, "team.teamname");
                
        $gameStr = $opponent."-".$teamname;
        if ($homegame==1){
            $gameStr = $teamname."-".$opponent;
        }
// echo $datetimeStr."  ".$gameStr."<br>";
                
        $inCheckPeriod = true;
        if ($datetime>$afterTwoWeeks) $inCheckPeriod = false;
        if ($datetime<$now) $inCheckPeriod = false;
        
        $daysLeft = ($datetime-$now)/(24*60*60);

        if ($inCheckPeriod){
            echo "check ".$dayOfWeek." ".$dateStr." ".$timeStr."  ".$gameStr."<br>";
            checkGame($teamID,$gameID,$messages,$gameStr,$meetingpoint,$dateStr,$timeStr,$dayOfWeek,$datetime,$remindersSended,$tooShortSended,$warningSended,$voorkeursNrAanwezig,$tekortMailTo,$waarschuwingMailTo,$waarschuwingMailDagen,$reminderDays, $teamID, $daysLeft,$membersPresentYes,$membersPresentNo);
        }
        $i++;
    }
    echo "FINISHED AT: ".date('h:i:s:u')."<br>";
    \dbcalls\logSQL2("","Finished send reminders/warnings and errors", 1, "root");

}

function checkGame($teamID,$gameID,$messages,$gameStr,$meetingpoint,$dateStr,$timeStr,$dayOfWeek,$datetime,$remindersSended,$tooShortSended,$warningSended,$voorkeursNrAanwezig,$tekortMailTo,$waarschuwingMailTo,$waarschuwingMailDagen,$reminderDays,$teamID, $daysLeft,$membersPresentYes,$membersPresentNo){
    checkReminderSended($teamID,$gameID,$messages,$gameStr,$meetingpoint,$dateStr,$timeStr,$dayOfWeek,$datetime,$remindersSended,$tooShortSended,$warningSended,$voorkeursNrAanwezig,$tekortMailTo,$waarschuwingMailTo,$waarschuwingMailDagen,$reminderDays,$teamID, $daysLeft,$membersPresentYes,$membersPresentNo);
    $hadTooShort = checkTooShortPlayers($teamID,$gameID,$messages,$gameStr,$meetingpoint,$dateStr,$timeStr,$dayOfWeek,$datetime,$remindersSended,$tooShortSended,$warningSended,$voorkeursNrAanwezig,$tekortMailTo,$waarschuwingMailTo,$waarschuwingMailDagen,$reminderDays,$teamID, $daysLeft,$membersPresentYes,$membersPresentNo);
        if (!$hadTooShort){
        checkWarning($teamID,$gameID,$messages,$gameStr,$meetingpoint,$dateStr,$timeStr,$dayOfWeek,$datetime,$remindersSended,$tooShortSended,$warningSended,$voorkeursNrAanwezig,$tekortMailTo,$waarschuwingMailTo,$waarschuwingMailDagen,$reminderDays,$teamID, $daysLeft,$membersPresentYes,$membersPresentNo);
    }
}

function checkReminderSended($teamID,$gameID,$messages,$gameStr,$meetingpoint,$dateStr,$timeStr,$dayOfWeek,$datetime,$remindersSended,$tooShortSended,$warningSended,$voorkeursNrAanwezig,$tekortMailTo,$waarschuwingMailTo,$waarschuwingMailDagen,$reminderDays,$teamID, $daysLeft,$membersPresentYes,$membersPresentNo){
    global $conn;
    global $testmode;
    // check if reminder has been checked
    if ($remindersSended==1) return;
    
    // find days left
     // echo "days left=".$daysLeft."  reminderDays=".$reminderDays."<br>";   
    if ($daysLeft>$reminderDays) return;


    // echo "<br>CHECK REMINDER<br>";   
    $membersPresentYesArray = explode(" ", $membersPresentYes);    
    $membersPresentNoArray = explode(" ", $membersPresentNo);    
    // echo "membersPresentYesArray".$membersPresentYes."<br>";   
    // echo "membersPresentNoArray".$membersPresentNo."<br>";  


// Build the membersYesStr, membersNoStr, membersUnknownStr string with nickname
    $query = "SELECT teammember.id, teammember.nickname FROM teammember where teamID=".$teamID." and (deleted is NULL or deleted=0) and  (supporter is NULL or supporter=0)";
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);

    $membersYesStr = ""; 
    $membersNoStr = ""; 
    $membersUnknownStr = "";
    $membersYesCount = 0; 
    $membersNoCount = 0; 
    $membersUnknownCount = 0;
    $i = 0;
    while ($i < $num) {
        $memberID = mysql_result($result, $i, "teammember.id");
        $nickname = mysql_result($result, $i, "teammember.nickname");
        if (in_array($memberID, $membersPresentYesArray)){
            if ($membersYesCount>0) $membersYesStr.=", ";
            $membersYesStr.=$nickname;
            $membersYesCount++;
        }    
        else if (in_array($memberID, $membersPresentNoArray)){
            if ($membersNoCount>0) $membersNoStr.=", ";
            $membersNoStr.=$nickname;
            $membersNoCount++;
            
        }    
        else{
            if ($membersUnknownCount>0) $membersUnknownStr.=", ";
            $membersUnknownStr.=$nickname;
            $membersUnknownCount++;
        }
        $i++;
    }
    $membersYesStr = $membersYesCount." spelers (".$membersYesStr.")"; 
    $membersNoStr = $membersNoCount." spelers (".$membersNoStr.")"; 
    $membersUnknownStr = $membersUnknownCount." spelers (".$membersUnknownStr.")"; 
    if ($membersYesCount==0) $membersYesStr = "0 spelers";
    if ($membersNoCount==0) $membersNoStr = "0 spelers";
    if ($membersUnknownCount==0) $membersUnknownStr = "0 spelers";

// send email
    // find all users
    $query = "SELECT teammember.id, teammember.nickname, users.email FROM teammember,users where teamID=".$teamID." and users.id=teammember.userID and (deleted is NULL or deleted=0) and  (supporter is NULL or supporter=0)";
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);

    $i = 0;
    while ($i < $num) {
        $memberID = mysql_result($result, $i, "teammember.id");
        $email = mysql_result($result, $i, "users.email");
        $i++;
        //echo "user ".$memberID.":".$email." ";
        if (in_array($memberID, $membersPresentYesArray)){
        }    
        else if (in_array($memberID, $membersPresentNoArray)){
        }    
        else{
            $emailBody = getEmailReminder($messages,$membersYesStr, $membersNoStr, $membersUnknownStr,$gameStr,$meetingpoint,$dateStr,$timeStr,$dayOfWeek,"http://www.mijnsportwedstrijden.nl/index.php?section=wedstrijd&team=".$teamID."&game=".$gameID);
            $header="mijnSportwedstrijden: Herinnering voor ".$gameStr." op ".$dayOfWeek." ".$dateStr." ".$timeStr;
            if (strpos($email,"@")) {
                echo "Mail ".$header." to ".$email."<br>";
                 // echo "<hr>SEND REMINDER EMAIL TO ".$email."<br>";
                 echo $header."<br><br>";
                 echo $emailBody."<br><br>";                 
                 sendEmail($email,$header,$emailBody, "Teamsport <team".$teamID."@mijnsportwedstrijden.nl>");
                 \dbcalls\logSQL2("","Emailed to ".$email.":".$header, 1, "root");
            }
        }
    }
    
    // change DB that reminder has been send
    $q = "UPDATE games SET remindersSended=1 WHERE id = '" . $gameID . "';";
    if (!$testmode) $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
}

function checkTooShortPlayers($teamID,$gameID,$messages,$gameStr,$meetingpoint,$dateStr,$timeStr,$dayOfWeek,$datetime,$remindersSended,$tooShortSended,$warningSended,$voorkeursNrAanwezig,$tekortMailTo,$waarschuwingMailTo,$waarschuwingMailDagen,$reminderDays,$teamID, $daysLeft,$membersPresentYes,$membersPresentNo){
    global $conn;
    global $testmode;
    // check if reminder has been checked
    if ($tooShortSended==1) return;
    
    // skip als mail bij tooShort is gedisabled
    if ($tekortMailTo==0) return;

    // zoek aantal alle spelers (zonder supporters of deleted)
    $query = "SELECT count(*) as count FROM teammember where teamID=".$teamID." and (deleted is NULL or deleted=0) and  (supporter is NULL or supporter=0);";
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    if ($num==0) return;
    $memberCount = mysql_result($result, $i, "count");
    
    // bepaal max afwezig
    $maxAfwezig = $memberCount-$voorkeursNrAanwezig;

    // Build the membersYesStr, membersNoStr, membersUnknownStr string with nickname
    $membersPresentYesArray = explode(" ", $membersPresentYes);    
    $membersPresentNoArray = explode(" ", $membersPresentNo);
        
    // find all users
    $query = "SELECT teammember.id, teammember.nickname FROM teammember where teamID=".$teamID." and (deleted is NULL or deleted=0) and  (supporter is NULL or supporter=0)";
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);    
    $membersYesStr = ""; 
    $membersNoStr = ""; 
    $membersUnknownStr = "";
    $membersYesCount = 0; 
    $membersNoCount = 0; 
    $membersUnknownCount = 0;
    $i = 0;
    while ($i < $num) {
        $memberID = mysql_result($result, $i, "teammember.id");
        $nickname = mysql_result($result, $i, "teammember.nickname");
        if (in_array($memberID, $membersPresentYesArray)){
            if ($membersYesCount>0) $membersYesStr.=", ";
            $membersYesStr.=$nickname;
            $membersYesCount++;
        }    
        else if (in_array($memberID, $membersPresentNoArray)){
            if ($membersNoCount>0) $membersNoStr.=", ";
            $membersNoStr.=$nickname;
            $membersNoCount++;
            
        }    
        else{
            if ($membersUnknownCount>0) $membersUnknownStr.=", ";
            $membersUnknownStr.=$nickname;
            $membersUnknownCount++;
        }
        $i++;
    }


    if ($maxAfwezig<$membersNoCount){

        $membersYesStr = $membersYesCount." spelers (".$membersYesStr.")"; 
        $membersNoStr = $membersNoCount." spelers (".$membersNoStr.")"; 
        $membersUnknownStr = $membersUnknownCount." spelers (".$membersUnknownStr.")"; 
        if ($membersYesCount==0) $membersYesStr = "0 spelers";
        if ($membersNoCount==0) $membersNoStr = "0 spelers";
        if ($membersUnknownCount==0) $membersUnknownStr = "0 spelers";
        

        $emailBody = getEmailTemplateTooShort($messages,$membersYesStr, $membersNoStr, $membersUnknownStr,$gameStr,$meetingpoint,$dateStr,$timeStr,$dayOfWeek,$membersNoCount, $membersYesCount,$membersUnknownCount, "http://www.mijnsportwedstrijden.nl/index.php?section=wedstrijd&team=".$teamID."&game=".$gameID);
        $header="mijnSportwedstrijden: Te veel afmeldingen voor ".$gameStr." op ".$dayOfWeek." ".$dateStr." ".$timeStr;

        $emailAdresses = array();
        if ($tekortMailTo==1){
            $emailAdresses = getEmailAddressesAdmin($teamID);
        }
        if ($tekortMailTo==2){
            $emailAdresses = getEmailAddressesAll($teamID);
        }
        foreach ($emailAdresses as $email) {
            if (strpos($email,"@")) {
                echo "Mail ".$header." to ".$email."<br>";
                // echo $header."<br><br>";
                echo $emailBody."<br><br>";
                sendEmail($email,$header,$emailBody, "Teamsport <team".$teamID."@mijnsportwedstrijden.nl>");
                \dbcalls\logSQL2("","Emailed to ".$email.":".$header, 1, "root");
            }
        }            

        // change DB that reminder has been send
        $q = "UPDATE games SET tooShortSended=1 WHERE id = '" . $gameID . "';";
        if (!$testmode) $res = mysql_query($q, $conn);
        if (mysql_errno()) {
            throw new \Exception(mysql_error());
        }
        return true;
    }
}

function checkWarning($teamID,$gameID,$messages,$gameStr,$meetingpoint,$dateStr,$timeStr,$dayOfWeek,$datetime,$remindersSended,$tooShortSended,$warningSended,$voorkeursNrAanwezig,$tekortMailTo,$waarschuwingMailTo,$waarschuwingMailDagen,$reminderDays, $teamID, $daysLeft,$membersPresentYes,$membersPresentNo){
    global $conn;
    global $testmode;
    // check if reminder has been checked
    if ($warningSended==1) return;

    // skip als mail bij warning is gedisabled
    if ($waarschuwingMailTo==0) return; 
    
    // also skip this when tooShort was already sended
    if ($tooShortSended==1) return;
    
    // find days left
    if ($daysLeft>$waarschuwingMailDagen) return;

    // zoek aantal alle spelers (zonder supporters of deleted)
    $query = "SELECT count(*) as count FROM teammember where teamID=".$teamID." and (deleted is NULL or deleted=0) and  (supporter is NULL or supporter=0);";
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    if ($num==0) return;
    $memberCount = mysql_result($result, $i, "count");

    // Build the membersYesStr, membersNoStr, membersUnknownStr string with nickname
    $membersPresentYesArray = explode(" ", $membersPresentYes);    
    $membersPresentNoArray = explode(" ", $membersPresentNo);    
    // find all users
    $query = "SELECT teammember.id, teammember.nickname FROM teammember where teamID=".$teamID." and (deleted is NULL or deleted=0) and  (supporter is NULL or supporter=0)";
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);    
    $membersYesStr = ""; 
    $membersNoStr = ""; 
    $membersUnknownStr = "";
    $membersYesCount = 0; 
    $membersNoCount = 0; 
    $membersUnknownCount = 0;
    $i = 0;
    while ($i < $num) {
        $memberID = mysql_result($result, $i, "teammember.id");
        $nickname = mysql_result($result, $i, "teammember.nickname");
        if (in_array($memberID, $membersPresentYesArray)){
            if ($membersYesCount>0) $membersYesStr.=", ";
            $membersYesStr.=$nickname;
            $membersYesCount++;
        }    
        else if (in_array($memberID, $membersPresentNoArray)){
            if ($membersNoCount>0) $membersNoStr.=", ";
            $membersNoStr.=$nickname;
            $membersNoCount++;
            
        }    
        else{
            if ($membersUnknownCount>0) $membersUnknownStr.=", ";
            $membersUnknownStr.=$nickname;
            $membersUnknownCount++;
        }
        $i++;
    }

    if ($voorkeursNrAanwezig>$membersYesCount){

        $membersYesStr = $membersYesCount." spelers (".$membersYesStr.")"; 
        $membersNoStr = $membersNoCount." spelers (".$membersNoStr.")"; 
        $membersUnknownStr = $membersUnknownCount." spelers (".$membersUnknownStr.")"; 
        if ($membersYesCount==0) $membersYesStr = "0 spelers";
        if ($membersNoCount==0) $membersNoStr = "0 spelers";
        if ($membersUnknownCount==0) $membersUnknownStr = "0 spelers";
            
        // send email 
        $emailBody = getEmailTemplateWarning($messages,$membersYesStr, $membersNoStr, $membersUnknownStr,$gameStr,$meetingpoint,$dateStr,$timeStr,$dayOfWeek,$membersNoCount, $membersYesCount,$membersUnknownCount, "http://www.mijnsportwedstrijden.nl/index.php?section=wedstrijd&team=".$teamID."&game=".$gameID);
    
        $header="mijnSportwedstrijden: Te weinig aanmeldingen voor ".$gameStr." op ".$dayOfWeek." ".$dateStr." ".$timeStr;
        $emailAdresses = array();
        if ($waarschuwingMailTo==1){
            $emailAdresses = getEmailAddressesAdmin($teamID);
        }
        if ($waarschuwingMailTo==2){
            $emailAdresses = getEmailAddressesAll($teamID);
        }
        foreach ($emailAdresses as $email) {
            if (strpos($email,"@")) {
                echo "Mail ".$header." to ".$email."<br>";
                // echo $header."<br><br>";
                echo $emailBody."<br><br>";
                sendEmail($email,$header,$emailBody, "Teamsport <team".$teamID."@mijnsportwedstrijden.nl>");
                \dbcalls\logSQL2("","Emailed to ".$email.":".$header, 1, "root");
            }
        }            
        
        
        // change DB that reminder has been send
        $q = "UPDATE games SET warningSended=1 WHERE id = '" . $gameID . "';";
        if (!$testmode) $res = mysql_query($q, $conn);
        if (mysql_errno()) {
            throw new \Exception(mysql_error());
        }
    }
}

function getGameDetails($messages,$membersYesStr, $membersNoStr, $membersUnknownStr,$game,$meetingpoint,$dateStr,$timeStr,$dayOfWeek, $link){
    $resultText='
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
';
    
    return $resultText;
    
}


function getEmailReminder($messages,$membersYesStr, $membersNoStr, $membersUnknownStr,$game,$meetingpoint,$dateStr,$timeStr,$dayOfWeek, $link){
    $resultText = "";
    $resultText.= "<body BGCOLOR='#fff'>";
    $resultText.= " <STYLE type='text/css'>";
    $resultText.= "   body {font-family: Arial;color: #000;text-decoration : none; }";       
    $resultText.= " </STYLE>";    
    $resultText.='Herinnering: Je hebt nog niet aangegeven of je aanwezig bent bij '.$game.'<br><br>';
    $resultText.=getGameDetails($messages,$membersYesStr, $membersNoStr, $membersUnknownStr,$game,$meetingpoint,$dateStr,$timeStr,$dayOfWeek, $link);
    return $resultText;
}

function getEmailTemplateTooShort($messages,$membersYesStr, $membersNoStr, $membersUnknownStr,$game  , $meetingpoint,$dateStr,$timeStr,$dayOfWeek, $nrAfzeggingen, $nrYes, $nrUnknown, $link){
    $resultText = "";
    $resultText.= "<body BGCOLOR='#fff'>";
    $resultText.= " <STYLE type='text/css'>";
    $resultText.= "   body {font-family: Arial;color: #000;text-decoration : none; }";       
    $resultText.= " </STYLE>";    
    $resultText.="Voor ".$game." op ".$dateStr." zijn er al ".$nrAfzeggingen." afzeggingen.<br>";
    $resultText.="Er zijn ".$nrYes." toezeggingen en ".$nrUnknown." teamleden weten het nog niet</a><br><br>";
    $resultText.=getGameDetails($messages,$membersYesStr, $membersNoStr, $membersUnknownStr,$game,$meetingpoint,$dateStr,$timeStr,$dayOfWeek, $link);
    return $resultText;
}

function getEmailTemplateWarning($messages,$membersYesStr, $membersNoStr, $membersUnknownStr,$game, $meetingpoint,$dateStr,$timeStr,$dayOfWeek, $nrAfzeggingen, $nrYes, $nrUnknown, $link){
    $resultText = "";
    $resultText.= "<body BGCOLOR='#fff'>";
    $resultText.= " <STYLE type='text/css'>";
    $resultText.= "   body {font-family: Arial;color: #000;text-decoration : none; }";       
    $resultText.= " </STYLE>";    
    $resultText.="Voor ".$game." op ".$dateStr." zijn nog maar ".$nrYes." toezeggingen.<br>";
    $resultText.="Er zijn ".$nrAfzeggingen." afzeggingen en ".$nrUnknown." teamleden weten het nog niet</a><br><br>";
    $resultText.=getGameDetails($messages,$membersYesStr, $membersNoStr, $membersUnknownStr,$game,$meetingpoint,$dateStr,$timeStr,$dayOfWeek, $link);
    return $resultText;
}

function getEmailAddressesAdmin($teamID){
    global $conn;
    $query = "SELECT users.email FROM teammember,users where teammember.teamID='" . $teamID . "' and teammember.userID=users.id and (deleted is NULL or deleted=0) and teammember.admin=1";
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    $emails = array();
    while ($i < $num) {
        $email = mysql_result($result, $i, "users.email");
        $emails[] = $email; 
        $i++;
    }
    return $emails;
}
    
function getEmailAddressesAll($teamID){    global $conn;
    $query = "SELECT users.email FROM teammember,users where teammember.teamID='" . $teamID . "' and teammember.userID=users.id and (deleted is NULL or deleted=0)";
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    $emails = array();
    while ($i < $num) {
        $email = mysql_result($result, $i, "users.email");
        $emails[] = $email; 
        $i++;
    }
    return $emails;    
}
    
