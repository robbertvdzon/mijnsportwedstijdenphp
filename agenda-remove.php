<?
/* Include Files *********************/
session_start();
include_once ("database.php");
include_once ("header.php");
include_once ("dbcalls.php");
include_once ("globals.php");
include_once ("teamsport.php");
include_once ("request-session.php");
include_once ("platform/platformsettings.php");

require_once ("google/src/Google_Client.php");
require_once ("google/src/contrib/Google_CalendarService.php");


if (isset($_GET['logout'])) {
  unset($_SESSION['token']);
}


$client = new Google_Client();
$client->setApplicationName("Verwijder wedstrijden");
$client->setClientId('648572068323-f6tti0vlb9vh0jmve1lnsohmrs9pjc9j.apps.googleusercontent.com');
$client->setClientSecret('9W3nlG7dnwmm0NixVLKmvsQ5');
$client->setRedirectUri('http://www.mijnsportwedstrijden.nl/agenda-remove.php');
$client->setDeveloperKey('AIzaSyDRGbQso3UmbTjyOrDThBkM4zBvNIl7Mz0');
$client->setUseObjects(true);
$cal = new Google_CalendarService($client);
if (isset($_GET['logout'])) {
  unset($_SESSION['token']);
}
if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['token'] = $client->getAccessToken();
  header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
}
if (isset($_SESSION['token'])) {
  $client->setAccessToken($_SESSION['token']);
}

$step1 = true;
$step2 = false;
if (isset($_GET['step2'])) {   
    $step1 = false;
    $step2 = true;
}




/*************************************/
header('Expires: ' . gmdate("D, d M Y H:i:s", time() + 1000) . ' GMT');
header('Cache-Control: Private');
/************ AUTHENTICATION ROUTINES *****************/
/* Sets the value of the logged_in variable, which can be used in your code */
checkLogin();


?>
    <html>
    <head>
    <title>Mijn Sportwedstrijden</title>
    </head>    
    <body>

<style>
A{
 font-family: Arial;
 text-decoration : none;
 color: #333333;
 font-weight:bold;font-size: 13px;
}


body {font-family: Arial;color: #333;text-decoration : none;font-size: 13px; }


ul,li
{
font-size:20px;
}

td, th, ul, ol, li, sub, sup, p
{
    font-family: Arial;
    color: #333;
    font-size: 13px
}


</style>
        
        
        
        <link rel="stylesheet" href="font.css"/>        
<?     


if (!globals\isLoggedIn()) {
        echo "ERROR, NIET INGELOGD";
        return;
}

// if the user IS logged in, and the team is anonymous, then check if this user has the same
// team in his competitions (as managed team), then use that team.

$currentUserID = getUserID(); // will be -1 if not found
$currentUserData = dbcalls\getUserData($currentUserID);
$currentTeams = dbcalls\loadTeams2($currentUserID,false,-1);


//$gameStartDate = '2013-01-12T12:00:00+01:00';
//$date = new DateTime($gameStartDate);
//$dateStr = date_format($date,"d-m-Y H:i");
//echo $dateStr."<br>";


// each team
$agendaIDs = array();


// get all agenda items

if ($client->getAccessToken()) {
    $events = $cal->events->listEvents("primary");
    date_default_timezone_set($events->getTimeZone());
    while(true) {
      foreach ($events->getItems() as $event) {
        $gameStartDate = $event->start->dateTime;
        $date = new DateTime($gameStartDate);
        $dateStr = date_format($date,"d-m-Y H:i");        
        $token = $dateStr.$event->summary;
//            var_dump($event);
        $agendaIDs[$token] = $event->id; 
//        $agendaIDs[$token] = 111; 
      }
      $pageToken = $events->getNextPageToken();
      if ($pageToken) {
        $optParams = array('pageToken' => $pageToken);
        $events = $cal->events->listEvents("primary", $optParams);
      } else {
        break;
      }
    }
  $_SESSION['token'] = $client->getAccessToken();
} else {
  $authUrl = $client->createAuthUrl();
  print "<table width=100% border=0><tr><td></td><td align=center>";
  print "<a class='login' href='$authUrl'><u>Klik hier om een google agenda te selecteren</u></a>";
  print "</td><td></td></tr></table>";
  return;
}



$todays_date = date("Y-m-d"); 
$today = strtotime($todays_date); 


// get all games
$foundCount = 0;

$gamesInAgenda = array();
$gamesNotInAgenda = array();
$gamesRemoved = array();


foreach ($currentTeams as $currentTeam) {
    $competitions = dbcalls\loadCompetitions($currentTeam->id);
    foreach ($competitions as $competition) {
        $games = dbcalls\loadGames($competition->id);
        foreach ($games as $game) {
//            var_dump($game);

            $gamedate = $game->gamedate;
            $dateTimeStr = date('d-m-Y H:i', $gamedate-date("Z",$gamedate));
            $dateStr = date('d-m-Y', $gamedate-date("Z",$gamedate));

            //echo $game->opponent." ".$foundCount." ".$dateStr."<br>";


            $date = strtotime($dateStr);
            if ($date<$today){
                continue;
            }
            
            $foundCount++;
            //if ($foundCount>15) continue;
            
            $dateTimeAtom = date('c', $gamedate-date("Z",$gamedate));
            $summary = $game->opponent." - ".$currentTeam->teamname;
            if ($game->homegame=="1"){
                $summary = $currentTeam->teamname." - ".$game->opponent;
            }
            $token = $dateTimeStr.$summary;

            $gameObject = new \stdClass();
            $gameObject->gameStr = $summary;
            $gameObject->dateTimeStr = $dateTimeStr;
            
            
//            echo "<br>token:".$token;
            
            if (isset($agendaIDs[$token])) {
                $gamesInAgenda[] = $gameObject;
                $eventID = $agendaIDs[$token];
                
                if ($step2){
                    $cal->events->delete('primary', $eventID);
                    $gamesRemoved[] = $gameObject;
                }
                
                
            }
            else{
                // not found, add to agenda
                $gamesNotInAgenda[] = $gameObject;
            }
        }
    }
        
}


if ($step1){
        if (count($gamesInAgenda)>0){
            print "<a href=agenda-remove.php?step2=step2><u>Klik hier om de onderstaande wedstrijden te verwijderen van je agenda</u></a><br><br>";    
            print "<table>";    
            print "<tr><td><b>Wedstrijd</b></td><td><b>Datum/Tijd</b></td></tr>";    
            foreach ($gamesInAgenda as $game) {
                print "<tr><td>".$game->gameStr."</td><td>".$game->dateTimeStr."</td></tr>";    
            }
            print "</table>";
        }
        else{
            print "<b>Er zijn geen wedstrijden in je agenda om te verwijderen</b><br>";    
        }    
        print "<br><a href=agenda-remove.php?logout=logout><u>Klik hier om een ander google account te selecteren</u></a><br>";    
            
}

if ($step2){
    print "De volgende wedstrijden zijn verwijderd van je agenda:<br><br>";    
    print "<table>";    
    print "<tr><td><b>Westrijd</b></td><td><b>Datum/Tijd</b></td></tr>";    
    foreach ($gamesRemoved as $game) {
            print "<tr><td>".$game->gameStr."</td><td>".$game->dateTimeStr."</td></tr>";    
    }
    print "</table>";    
    print "<br><a href='JavaScript:window.close()'><u>sluit dit scherm</u></a>";    
}






?>
</body>
