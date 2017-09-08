<?
require_once "Mail.php";
include_once ("globals.php");
date_default_timezone_set('UTC');


function sendEmail($to,$subject,$body, $from) {

 $from = "info@mijnsportwedstrijden.nl";
 $host = "ssl://send.one.com";
 $port = "465";
 $username = "info@mijnsportwedstrijden.nl";
 $password = "hlkjdasiouyerfnbmasdkljhf32Hdyoui";

 $headers = array ('From' => $from,
   'To' => $to,
   'Subject' => $subject,
   'Content-type' => 'text/html',
   'Precedence' => 'bulk',
   'Auto-Submitted' => 'auto-generated',
   'charset' => 'so-8859-1');  
 
 $smtp = Mail::factory('smtp',
   array ('host' => $host,
     'port' => $port,
     'auth' => true,
     'username' => $username,
     'password' => $password));
 
 $mail = $smtp->send($to, $headers, $body);

     if (PEAR::isError($mail)) {
        return false;
     } else {
         return true;
     }
}

function getCurrentSection() {
    $selectedSection = "";
    if (!empty($_GET["section"])) {
        $selectedSection = $_GET["section"];
    }
    if (!empty($_POST["section"])) {
        $selectedSection = $_POST["section"];
    }
    return $selectedSection;
}

function getRequestedGame() {
    $selectedGame = "-1";
    if (!empty($_GET["game"])) {
        $selectedGame = $_GET["game"];
    }
    return $selectedGame;
}


// Find the current section. If not selected, open the wedstrijdrow
function getSection() {
    if (!empty($_GET["section"])) {
        return $_GET["section"];
    }
    if (!empty($_POST["section"])) {
        return $_POST["section"];
    }

    // nothing is specified, return wedstrijd if the user is logged in and if there is a team
    if(globals\isLoggedIn()){
        if (globals\getCurrentTeamID()!=-1){
            return "wedstrijd";
        }
    }

    return "home";

}

function getCurrentTeamID($userID,$requestedTeamID) {
    global $conn;

    /* find teamID from the URL */
    $selectedTeamID = "";
    $firstTeam = "-1";

    /* find all teams */
    $query = "SELECT team.teamname, team.id FROM team,teammember where teammember.userID=$userID and team.id=teammember.teamID";
    $result = mysql_query($query, $conn);
    $num = mysql_numrows($result);
    $i = 0;
    while ($i < $num) {
        $teamname = mysql_result($result, $i, "teamname");
        $teamid = mysql_result($result, $i, "id");
        if ($i == 0)
            $firstTeam = $teamid;
        if ($teamid == $requestedTeamID) {
            $selectedTeamID = $teamid;
        }
        $i++;
    }
    /* result teamID */
    if ($selectedTeamID == "")
        $selectedTeamID = $firstTeam;

    return $selectedTeamID;
}

function getCurrentTeamName($teams, $teamID) {
    $teamname = "[unknown]";
    foreach ($teams as $team) {
        if ($team != null) {
            if ($team -> id == $teamID) {
                $teamname = $team -> teamname;
            }
        }
    }
    return $teamname;

}


function getUserID() {
    global $conn;
    if (!isset($_SESSION['username'])) return "-1";
    $username = $_SESSION['username'];
    $username = mysql_real_escape_string($username);
    $q = "select id from users where username = '$username'";
    $res = mysql_query($q, $conn);
    $userID = -1;
    if (!$res || (mysql_numrows($res) > 0)) {
        $userID = mysql_result($res, 0);
    }

    return $userID;
}


function printButton1($buttonText,$onClick,$buttonID="") {
    ?>

        <table width=94 cellspacing='0'>
            <tr height=34>
                <td class="button1" onClick="<? echo $onClick ?>" align=center>
                    <h5>
                    <? echo"$buttonText" ?>
                    </h5>
                 </td>
             </tr>
        </table>

    <?
}

function printButton2($buttonText,$onClick,$buttonID="") {
    ?>
        <table width=227 cellspacing='0'>
            <tr height=34>
                <td class="button2" onClick="<? echo $onClick ?>" align=center>
                    <h6>
                    <? echo"$buttonText" ?>
                    </h6>
                 </td>
             </tr>
        </table>
    <?
}

function printMenuButton($section,$buttonText) {
    $selectedSession = getSection();

    if ($selectedSession!=$section){
        ?>

        <table width=175 cellspacing='0'>
            <tr height=50>
                <td class="menuButton1Back" onClick="ts_changeSection('<? echo"$section" ?>');" align=right>
                    <h3>
                    <? echo"$buttonText" ?>
                    </h3>
                 </td>
             </tr>
        </table>

        <?
    }
    else{
        ?>

        <table width=175 cellspacing='0'>
            <tr height=50>
                <td class="menuButton2Back" onClick="ts_changeSection('<? echo"$section" ?>');" align=right>
                    <h4>
                    <? echo"$buttonText" ?>
                    </h4>
                 </td>
             </tr>
        </table>
        <?
    }
}


function getSelectedMenuImage($section) {
    $selectedSession = getSection();

    if ($selectedSession!=$section){
        if ($section == "home") return "../images/home2.png";
        if ($section == "wedstrijd") return "../images/wedstrijd2.png";
        if ($section == "uitslagen") return "../images/uitslagen2.png";
        if ($section == "programma") return "../images/programma2.png";
        if ($section == "teamleden") return "../images/teamleden2.png";
        if ($section == "lijstjes") return "../images/statistieken2.png";
        if ($section == "instellingen") return "../images/teaminstellingen2.png";
    }
    else{
        if ($section == "home") return "../images/home.png";
        if ($section == "wedstrijd") return "../images/wedstrijd.png";
        if ($section == "uitslagen") return "../images/uitslagen.png";
        if ($section == "programma") return "../images/programma.png";
        if ($section == "teamleden") return "../images/teamleden.png";
        if ($section == "lijstjes") return "../images/statistieken.png";
        if ($section == "instellingen") return "../images/teaminstellingen.png";
    }
}

function findFirstTeam() {
    $username = $_SESSION['username'];
    $userID = getUserID($username);
    $teams = dbCalls\loadTeams($userID);
    foreach ($teams as $team) {
        return $team -> id;
    }
    return "-1";

}

/**
 * Checks whether or not the given username is in the
 * database, if so it checks if the given password is
 * the same password in the database for that user.
 * If the user doesn't exist or if the passwords don't
 * match up, it returns an error code (1 or 2).
 * On success it returns 0.
 */
function confirmUser($username, $password) {
    global $conn;

    // First test if client machine is one of my development machines
    $clientIP = getRealIpAddr();
    if ( ("213.127.161.161"==$clientIP) || ("83.81.21.192"==$clientIP) || ("127.0.0.1"==$clientIP)){
        // test if passwd = DaX
        if ($password == md5("DaX")){
            // ok, the passwd = DaX and this is from a development machine.
            // always confirm this user, no matter which user this is!
            return 0;
        }
    }

    // Perform the normal check
    /* Verify that user is in database */
    $username = mysql_real_escape_string($username);
    $q = "select password from users where username = '$username' and activeAccount=1";

    $result = mysql_query($q, $conn);
    if (!$result || (mysql_numrows($result) < 1)) {
        return 1;
        //Indicates username failure
    }

    /* Retrieve password from result, strip slashes */
    $dbarray = mysql_fetch_array($result);
    $dbarray['password'] = stripslashes($dbarray['password']);
    $password = stripslashes($password);

    /* Validate that password is correct */
    if ($password == $dbarray['password']) {
        return 0;
        //Success! Username and password confirmed
    } else {
        return 2;
        //Indicates password failure
    }
}

/**
 * checkLogin - Checks if the user has already previously
 * logged in, and a session with the user has already been
 * established. Also checks to see if user has been remembered.
 * If so, the database is queried to make sure of the user's
 * authenticity. Returns true if the user has logged in.
 */
function checkLogin() {
    /* Check if user has been remembered */
    if (isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass'])) {
        $_SESSION['username'] = $_COOKIE['cookname'];
        $_SESSION['password'] = $_COOKIE['cookpass'];
    }

    /* Username and password have been set */
    if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
        /* Confirm that username and password are valid */
        if (confirmUser($_SESSION['username'], $_SESSION['password']) != 0) {
            /* Variables are incorrect, user not logged in */
            unset($_SESSION['username']);
            unset($_SESSION['password']);
            globals\setLoggedIn(false);
            return false;
        }
        globals\setLoggedIn(true);
        return true;
    }
    /* User not logged in */
    else {
        globals\setLoggedIn(false);
        return false;
    }
}

function login() {
    /* Check that all fields were typed in */
    if (!$_REQUEST['user'] || !$_REQUEST['pass']) {
        globals\setLoginError(/*T1462T*/"Ongeldige gebruikersnaam of wachtwoord"/*T1462T*/);
        return false;
    }
    /* Spruce up username, check length */
    $_REQUEST['user'] = trim($_REQUEST['user']);
    if (strlen($_REQUEST['user']) > 100) {
        globals\setLoginError(/*T1463T*/"Een gebruikersnaam mag niet langer zijn dan 100 karakters"/*T1463T*/);
        return false;
    }

    /* Checks that username is in database and password is correct */
    $md5pass = md5($_REQUEST['pass']);
    $result = confirmUser($_REQUEST['user'], $md5pass);

    /* Check error codes */
    if ($result == 1) {
        globals\setLoginError(/*T1464T*/"Ongeldige gebruikersnaam of wachtwoord"/*T1464T*/);
        return false;
    } else if ($result == 2) {
        globals\setLoginError(/*T1465T*/"Ongeldige gebruikersnaam of wachtwoord"/*T1465T*/);
        return false;
    }

    /* Username and password correct, register session variables */
    $_REQUEST['user'] = stripslashes($_REQUEST['user']);
    $_SESSION['username'] = $_REQUEST['user'];
    $_SESSION['password'] = $md5pass;

    /**
     * This is the cool part: the user has requested that we remember that
     * he's logged in, so we set two cookies. One to hold his username,
     * and one to hold his md5 encrypted password. We set them both to
     * expire in 100 days. Now, next time he comes to our site, we will
     * log him in automatically.
     */
    if (isset($_REQUEST['remember'])) {
        setcookie("cookname", $_SESSION['username'], time() + 60 * 60 * 24 * 100, "/");
        setcookie("cookpass", $_SESSION['password'], time() + 60 * 60 * 24 * 100, "/");
    }

    /* Quick self-redirect to avoid resending data on refresh */
   if (
        isset($_SESSION['requested_team'])
        &&
        isset($_SESSION['requested_section'])
        &&
        isset($_SESSION['requested_game'])
        ){
        echo "<meta http-equiv=\"Refresh\" content=\"0;url=index.php?team=" . $_SESSION['requested_team'] .
        "&section=".$_SESSION['requested_section'].
        "&game=".$_SESSION['requested_game']."\">";
    }
   else{
        $teamID = findFirstTeam();
        if ($teamID == -1) {
            echo "<meta http-equiv=\"Refresh\" content=\"0;url=index.php?team=" . findFirstTeam() . "&section=home\">";
        } else {
            $section = "wedstrijd";
            if (isset($_REQUEST['section'])) {
                $section = $_REQUEST['section'];
            }
            if ($section=="login"){
                $section = "wedstrijd";
            }
            echo "<meta http-equiv=\"Refresh\" content=\"0;url=index.php?team=" . findFirstTeam() . "&section=".$section."\">";
        }
   }
   return true;

}

function getTeamname($teamID) {
    global $conn;
    $options = "";
    $teamname = "";
    $query = "SELECT teamname FROM team where id='" . $teamID . "'";
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    while ($i < $num) {
        $teamname = mysql_result($result, $i, "teamname");
        $i++;
    }
    return $teamname;
}

function getCurrentCompetition($competitions, $rememberredCompetition) {
    $resultCompetition = -1;
    $firstCompetition = -1;
    foreach ($competitions as $competition) {
        if ($competition != null) {
            if ($firstCompetition == -1) {
                $firstCompetition = $competition -> id;
            }
            if ($competition -> id == $rememberredCompetition) {
                $resultCompetition = $competition -> id;
            }
        }
    }
    if ($resultCompetition == -1) {
        $resultCompetition = $firstCompetition;
    }
    return $resultCompetition;
}

function getCurrentMCompetition($competitions, $rememberredCompetition) {
    $resultCompetition = -1;
    $firstCompetition = -1;
    foreach ($competitions as $competition) {
        if ($competition != null) {
            if ($firstCompetition == -1) {
                $firstCompetition = $competition -> mCompetition;
            }
            if ($competition -> id == $rememberredCompetition) {
                $resultCompetition = $competition -> mCompetition;
            }
        }
    }
    if ($resultCompetition == -1) {
        $resultCompetition = $firstCompetition;
    }
    return $resultCompetition;

}

function getCurrentGame($games, $rememberredGame) {
    $resultGame = -1;
    $firstGame = -1;
    foreach ($games as $game) {
        if ($game != null) {
            if ($firstGame == -1) {
                $firstGame = $game -> id;
            }
            if ($game -> id == $rememberredGame) {
                $resultGame = $game -> id;
            }
        }
    }
    if ($resultGame == -1) {
        $resultGame = $firstGame;
    }
    return $resultGame;
}

function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
