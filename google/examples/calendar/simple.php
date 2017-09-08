<?php
require_once '../../src/Google_Client.php';
require_once '../../src/contrib/Google_CalendarService.php';
session_start();

$client = new Google_Client();
$client->setApplicationName("Google Calendar PHP Starter Application");

// Visit https://code.google.com/apis/console?api=calendar to generate your
// client id, client secret, and to register your redirect uri.

$client->setClientId('648572068323.apps.googleusercontent.com');
$client->setClientSecret('7VkWPSkwHhm4hYts4RbtO7HM');
$client->setRedirectUri('http://www.mijnsportwedstrijden.nl/google/examples/calendar/simple.php');
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

if ($client->getAccessToken()) {

	$calendarList = $cal->calendarList->listCalendarList();
	while(true){
	  foreach($calendarList->getItems()as $calendarListEntry){
		  echo "name:".$calendarListEntry->getSummary()."<br>";
	   }
	  $pageToken = $calendarList->getNextPageToken();
	  if($pageToken){
		  $optParams = array('pageToken'=> $pageToken);
		  $calendarList = $service->calendarList->listCalendarList($optParams);
	  }else{
		  break;
	  }
	}


  $calList = $cal->calendarList->listCalendarList();
  //print "<h1>Calendar List</h1><pre>" . print_r($calList, true) . "</pre>";

  //$calendarListEntry = $cal->calendarList->get("robbertvdzon@gmail.com");


$game = "FA - Boerderij";
$gameStartDate = '2013-01-12T12:00:00+01:00';
$gameEndDate =   '2013-01-12T12:40:00+01:00';

$gameFound = false;

$events = $cal->events->listEvents("primary");
while(true) {
  foreach ($events->getItems() as $event) {
    echo "<br>SUMMARY:::".$event->summary." - ".$event->start->dateTime."<br>";
	$gameStartDate = $event->start->dateTime;
	$date = new DateTime($gameStartDate);
	$dateStr = date_format($date,"d-m-Y H:i");
	echo $dateStr."<br>";



    if ($event->start->dateTime == $gameStartDate){
    	$gameFound = true;
    }
    //print_r($event);
  }
  $pageToken = $events->getNextPageToken();
  if ($pageToken) {
    $optParams = array('pageToken' => $pageToken);
    $events = $cal->events->listEvents("primary", $optParams);
  } else {
    break;
  }
}



  //print "<h1>Events</h1><pre>". print_r($events, true) . "</pre>";

  //print_r($calendarListEntry->getSummary(),true);
if (!$gameFound){
	$event = new Google_Event();
	$event->setSummary($game);
	$start = new Google_EventDateTime();
	$start->setDateTime($gameStartDate);
	$event->setStart($start);
	$end = new Google_EventDateTime();
	$end->setDateTime($gameEndDate);
	$event->setEnd($end);
	$createdEvent = $cal->events->insert('primary', $event);
	echo $createdEvent->getId();
}
else{
	echo "Event is al aangemaakt!";
}



  $_SESSION['token'] = $client->getAccessToken();
} else {
  $authUrl = $client->createAuthUrl();
  print "<a class='login' href='$authUrl'>Connect Me!</a>";
}