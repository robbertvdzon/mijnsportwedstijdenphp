<?
namespace requestjoin;
/* Include Files *********************/

include_once ("database.php");
include_once ("dbcalls.php");

function performJoin($username, $password, $nickname, $invitationID) {
	global $conn;
	$password = md5($password);
	$userID = "";
	$teamID = "";

    $username = mysql_real_escape_string($username);
    $password = mysql_real_escape_string($password);
    $nickname = mysql_real_escape_string($nickname);

	// check username/passwd and get userID
	$q = "select id from users where username = '$username' and password = '$password' and activeAccount=1 ";
	$result = mysql_query($q, $conn);
	if (mysql_errno()) {
		throw new \Exception(mysql_error());
	}
	$num = mysql_numrows($result);
	if ($num == 0) {
		throw new \Exception(/*T1421T*/"Error: Ongeldige gebruikersnaam of wachtwoord"/*T1421T*/);
	}
	$userID = mysql_result($result, 0, "id");

	// update teammember
	$q = "UPDATE teammember set userID=".$userID.",nickname='".$nickname."' where invitationID='".$invitationID."'";
	$res = mysql_query($q, $conn);
	if (mysql_errno()) {
		throw new \Exception(mysql_error());
	}
	return ("Aanmelding is gelukt");
}

function createUser($username, $password, $nickname, $name, $email) {
	global $conn;

	$password = md5($password);
	$userID = "";
	$teamID = "";

    $username = mysql_real_escape_string($username);
    $password = mysql_real_escape_string($password);
    $nickname = mysql_real_escape_string($nickname);
    $name = mysql_real_escape_string($name);


	// check if user exists
	$q = "select id from users where username = '$username'";
	$result = mysql_query($q, $conn);
	if (mysql_errno()) {
		throw new \Exception(mysql_error());
	}
	$num = mysql_numrows($result);
	if ($num > 0) {
		throw new \Exception(/*T1422T*/"ERROR: Er bestaat al een gebruiker met deze naam!"/*T1422T*/);
	}

	if (trim($username) == "") {
		throw new \Exception("ERROR: Ongeldige username");
	}

	// create user
	$q = "INSERT INTO users (`email` , `name`, `username`,`password`, `activeAccount`,`activationID`,`creationDate`) " . "VALUES ('$email','$name' ,'$username','$password','1','0',CURDATE())";
	$res = mysql_query($q, $conn);
	if (mysql_errno()) {
		throw new \Exception(mysql_error());
	}

	return true;
}

function processReject($invitationID) {
	global $conn;

	// remove invitation
    // update teammember
    $q = "UPDATE teammember set `invitationID`=0 where invitationID='".$invitationID."'";
    $res = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
	return (/*T1423T*/"Aanmelding verwijderd"/*T1423T*/);
}

function joinExisting($username, $password, $nickname, $invitationID) {
	performJoin($username, $password, $nickname, $invitationID);

}

function joinNew($username, $password, $nickname, $name, $email, $invitationID) {
	if (createUser($username, $password, $nickname, $name, $email)) {
		performJoin($username, $password, $nickname, $invitationID);
	}

}

function joinReject($invitationID) {
	processReject($invitationID);
}
?>