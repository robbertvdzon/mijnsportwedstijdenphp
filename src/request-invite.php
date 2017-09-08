<?
namespace invite;

/* Include Files *********************/
include_once ("database.php");
include_once ("teamsport.php");

function emailUser($name, $email, $invitationID, $teamname, $from) {
	$recipients = $email;
	$headers["From"] = $from;
	$headers["To"] = $email;
	$headers["Subject"] = /*T1410T*/"Inschrijving mijnsportwedstrijden.nl"/*T1410T*/;

	$to = $email;

	// subject
	$subject = /*T1411T*/'Uitnodiging voor mijnsportwedstrijden.nl...'/*T1411T*/;

	// message
	/*T1412T*/
	$message = '
	<html>
	<head>
	  <title>Uitnodiging</title>
	</head>
	<body>
	  <b>Beste ' . $name . '</b>
	  <br>
	  <br>
	  ' . $teamname . ' wil je graag uitnodigen om lid te worden van hun team bij mijnsportwedstrijden.nl.<br>
	  Met de App kun je via je adroid app of via de website makkelijk de wedstrijden bekijken en doorgeven of je wel of niet aanwezig bent.
	  <br>
	  <br>
      Om je account bij mijnsportwedstrijden.nl te activeren, ga dan naar <a href=http://www.mijnsportwedstrijden.nl/join.php>www.mijnsportwedstrijden.nl/join.php</a> in vul de volgende code in: '.$invitationID.'
	  <br>
	</body>
	</html>
	';
    /*T1412T*/


	// Mail it
	$result = true;

    $result = sendEmail($to ,$subject,$message, $from);

//    	$result = mail($to, $subject, $message, $headers);
//    }
	return $result;
}


function reInviteTeammember($teamMemberID,$name,$email){
   global $conn;

    $invitationID = uniqid();
    $name = mysql_real_escape_string($name);
    $email = mysql_real_escape_string($email);

    $q = "UPDATE teammember set nickname='".$name."',invitationID='".$invitationID."' where id=".$teamMemberID;
    $res = mysql_query($q,$conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }

    // check if user exists
    $q = "select teamID from teammember where id = ".$teamMemberID;
    $result = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    if ($num == 0) {
        throw new \Exception("Team niet gevonden!");
    }
    $teamID = mysql_result($result, 0, "teamID");
    $teamname = getTeamname($teamID);


    if (!emailUser($name,$email,$invitationID,$teamname,/*T1413T*/"Teamsport <team".$teamID."@mijnsportwedstrijden.nl>"/*T1413T*/)){
        return false;
    }
    return true;
}


function invite($name, $email, $teamID, $inviterUserID) {
	global $conn;
	$teamname = getTeamname($teamID);
    $name = mysql_real_escape_string($name);
    $email = mysql_real_escape_string($email);

	if ($name == ""){
		return false;
    }

	$invitationID = uniqid();
    $invitationID = mysql_real_escape_string($invitationID);

    if ($email == ""){
        // clear the $invitationID to indocate that no invitation is send. The status will then be: (geen login) instead (uitgenodigd) 
        $invitationID = "-1";
    }
    
		$q = "INSERT INTO teammember (`teamID` , `invitationID`, `nickname`, `invitationDate`) " . "VALUES ($teamID,'$invitationID' ,'$name',CURDATE())";

	$res = mysql_query($q, $conn);
	if (mysql_errno()) {
		throw new \Exception(mysql_error());
	}
    if ($email!=""){
    	if (!emailUser($name,$email,$invitationID,$teamname,/*T1414T*/"Teamsport <team".$teamID."@mijnsportwedstrijden.nl>"/*T1414T*/)){
    		return false;
    	}
    }
	return true;
}

function addToSuccessString($success, $oldString, $name) {
	if ($name == null)
		return $oldString;
	if ($success) {
		if ($oldString == null)
			return $name;
		return $oldString . "," . $name;
	}
	return $oldString;
}

function addToFailureString($success, $oldString, $name) {
	if ($name == null)
		return $oldString;
	if (!$success) {
		if ($oldString == null)
			return $name;
		return $oldString . "," . $name;
	}
	return $oldString;
}

function inviteNewMembers($parameters) {
	$result = new \stdClass();
    $result -> success = "";
    $result -> failed = "";
    for ($i=1;$i<=15;$i++){
        $nameStr = "name_".$i;
        $emailStr = "email_".$i;
        $ok = invite(
        $parameters->$nameStr, 
        $parameters->$emailStr, 
        $parameters -> teamID, 
        $parameters -> inviterUserID);
        $result -> success = addToSuccessString($ok, $result -> success, $parameters->$nameStr);
        $result -> failed = addToFailureString($ok, $result -> failed, $parameters->$nameStr);
    }

	return ($result);
}

function forgotPassword($email) {
    global $conn;
    if ($email=="") return;
    $email = mysql_real_escape_string($email);
    $loginmessage = "";
    $sqlUpdates = "";

    $query = "SELECT id,username from users where email = '".$email."'";
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    while ($i < $num) {

        $username = mysql_result($result, $i, "username");
        $userID = mysql_result($result, $i, "id");
        $newPassword = generatePassword();
        $newmd5pass = md5($newPassword);
        $loginmessage .= /*T1415T*/"Gebruikersnaam:".$username."  wachtwoord:".$newPassword."<br>"/*T1415T*/;
        $sqlUpdates[$i]= "UPDATE users SET password='".mysql_real_escape_string($newmd5pass)."' where id=".$userID.";";
        $i++;
    }

    // chang the passwords
    $i = 0;
    while ($i < $num) {
        $query = $sqlUpdates[$i];
        $result = mysql_query($query, $conn);
        if (mysql_errno()) {
            throw new \Exception(mysql_error());
        }
        $i++;
    }

    $headers["From"] = /*T1416T*/"registratie@teamsport-app.nl"/*T1416T*/;
    $headers["To"] = $email;
    $headers["Subject"] = /*T1417T*/"Inloggegevens mijnsportwedstrijden.nl"/*T1417T*/;

    $to = $email;

    // subject
    $subject = /*T1418T*/'Inloggegevens mijnsportwedstrijden.nl'/*T1418T*/;

    // message
    /*T1419T*/
    $message = '    
    <html>
    <head>
      <title>Inloggegevens</title>
    </head>
    <body>
      <b>Hierbij de inloggegevens van mijnsportwedstrijden.nl</b>
      <br>
      <br>
      '.$loginmessage.'
    </body>
    </html>
    ';
    /*T1419T*/
    // Mail it
    $result = sendEmail($email ,$subject,$message, /*T1420T*/"Teamsport <registratie@mijnsportwedstrijden.nl>"/*T1420T*/);

    return "";

}

function generatePassword($length=9, $strength=0) {
    $vowels = 'aeuy';
    $consonants = 'bdghjmnpqrstvz';
    if ($strength & 1) {
        $consonants .= 'BDGHJLMNPQRSTVWXZ';
    }
    if ($strength & 2) {
        $vowels .= "AEUY";
    }
    if ($strength & 4) {
        $consonants .= '23456789';
    }
    if ($strength & 8) {
        $consonants .= '@#$%';
    }

    $password = '';
    $alt = time() % 2;
    for ($i = 0; $i < $length; $i++) {
        if ($alt == 1) {
            $password .= $consonants[(rand() % strlen($consonants))];
            $alt = 0;
        } else {
            $password .= $vowels[(rand() % strlen($vowels))];
            $alt = 1;
        }
    }
    return $password;
}



?>