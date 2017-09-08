<?
namespace requestsession;

function getSessionCompetition() {
	if (!isset($_SESSION['competition']))
		return "-1";
	return $_SESSION['competition'];
}

function setSessionCompetition($competition) {
	$_SESSION['competition'] = $competition;
}

function getSessionGame() {
	if (!isset($_SESSION['game']))
		return "-1";
	return $_SESSION['game'];
}

function setSessionGame($game) {
	$_SESSION['game'] = $game;
}
 ?>