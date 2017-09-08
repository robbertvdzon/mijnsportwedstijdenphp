<?
namespace registerUser;
include_once("globals.php");




/**
 * Returns true if the username has been taken
 * by another user, false otherwise.
 */
function usernameTaken($username){
   global $conn;
   if(!get_magic_quotes_gpc()){
      $username = addslashes($username);
   }
   $q = "select username from users where username = '$username'";
   $result = mysql_query($q,$conn);
   return (mysql_numrows($result) > 0);
}

/**
 * Inserts the given (username, password) pair
 * into the database. Returns true on success,
 * false otherwise.
 */
function addNewUser($username, $password, $email, $name,$requestConnectTeam){
   global $conn;

   $activationID = uniqid();
   $username = mysql_real_escape_string($username);
   $password = mysql_real_escape_string($password);
   $email = mysql_real_escape_string($email);
   $name = mysql_real_escape_string($name);

	if (trim($username) == "") {
		throw new \Exception("ERROR: Ongeldige username");
	}


   $q = "INSERT INTO users (`username` , `password`,`email`,`name`, `activeAccount`,`activationID`,`requestConnectTeam`,`creationDate`) VALUES ('$username', '$password', '".$email."', '".$name."',1,'".$activationID."',".$requestConnectTeam." ,CURDATE())";
   $res = mysql_query($q,$conn);
   return $activationID;
}

function emailUser($name,$email,$activationID,$username,$from){
    $to  = $email;

    // subject
    $subject = /*T1424T*/'Aanmelding voor mijnsportwedstrijden.nl...'/*T1424T*/;

    // message
    /*T1425T*/
    $message = '
    <html>
    <head>
      <title>Aanmelding</title>
    </head>
    <body>
      <b>Beste '.$name.'</b>
      <br>
      <br>
      Welkom bij mijnsportwedstrijden.nl<br>
      <br>
      Met de gebruikersnaam '.$username.' is het mogelijk om met je opgegeven wachtwoord in te loggen<br>
      Op de site kun je een team aanmaken, beheren en delen met je teamleden.
      <br>
      <br>
      Veel plezier op mijnsportwedstrijden.nl!
    </body>
    </html>
    ';
    /*T1425T*/

    // Mail it
 //   if (!isLocalDatabase()){
    $result = sendEmail($to ,$subject,$message, $from);
 //   }
}




function registerNewUser($user, $passwd, $name, $email,$requestConnectTeam){

            /* Spruce up username, check length */
            if(strlen($user) > 100){
              throw new Exception(/*T1426T*/"De gebruikersnaam mag niet langer dan 100 karakters zijn"/*T1426T*/);
            }

            /* Check if username is already in use */
            if(usernameTaken($user)){
              throw new \Exception(/*T1427T*/"Deze gebruikersnaam is al bezet."/*T1427T*/);
            }

            /* Add the new account to the database */
            $md5pass = md5($passwd);
            $activationID = addNewUser($user, $md5pass,$email,$name,$requestConnectTeam);
            $userID = mysql_insert_id();
            emailUser($name,$email,$activationID,$user,/*T1428T*/"Teamsport <registratie@mijnsportwedstrijden.nl>"/*T1428T*/);
            return $userID;
}

