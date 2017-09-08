<?
include_once("globals.php");

/**
 * Determines whether or not to display the login
 * form or to show the user that he is logged in
 * based on if the session variables are set.
 */
function displayLogin(){
?>


		<div style="border:0px solid #000;">
		<form action="" method="post">
		<table cellspacing='0'>
		<tr>
		<td><b><!--T1429T-->Inloggen:<!--T1429T--></b></td>
		<td></td>
		</tr>
		<tr height=30>
		<td><!--T1430T-->Gebruikersnaam:<!--T1430T--></td>
		<td>
		<input name="user" type="text" autocomplete="off" />
		</td>
		</tr>
		<tr height=30>
		<td><!--T1431T-->Wachtwoord:<!--T1431T--></td>
		<td>
		<input name="pass" type="password" autocomplete="off" />
		&nbsp;&nbsp;&nbsp;
		<!--T1432T-->[wachtwoord vergeten]<!--T1432T-->
		</td>
		</tr>
		<tr height=30>
		<td><!--T1433T-->Blijf ingelogd:<!--T1433T--></td>
		<td>
		<input name="remember" type="checkbox" value="true" />
		</td>
		</tr>
		<tr>
		<td>
		<br>
		<input type="submit" name="sublogin" value="Login">
		</td>
		<td></td>
		</tr>
		</table>
		</form>
		</div>


<?
}

function printHome(){
?>
	<table border=0 width=100% cellspacing='0'>
	<tr>
	<td width=400 valign=top>
<!--T1434T-->
		Met mijnsportwedstrijden.nl kun je op een overzichtelijke en makkelijke manier de wedstrijden en aanwezigheid van de spelers bijhouden van je eigen clubteams.
		<br><br>
		Met de bijbehorende android app kun je dat nu zelf nog sneller en eenvoudiger doen.
		<br><br>
<!--T1434T-->		
<?


if( !globals\isLoggedIn()){
	displayLogin();
}
else{
	if ($currentSelectedTeamID==-1){
?>
<!--T1435T-->
	Je bent nog geen lid van een team!<br>
	Richt een nieuw team aan of vraag iemand je uit te nodigen voor een team.<br>
<!--T1435T-->	
	<br>
	<b><a href=# onclick="javascript:openNewTeam();"><!--T1436T-->Richt niew team op<!--T1436T--></a></b>
	<br>
	<br>
	<!--T1437T-->
	Zodra je lid bent van een team is het mogelijk om wedstrijden toe te voegen en het team te beheren.
	<!--T1437T-->
	<br>
<?
	}
}
?>


		<br>
		<a href="register.php">Inschrijven</a>

	</td>
	<td width=10>
	<td valign=top>
	<div style="border:1px solid #000;background:#99CCFF;padding: 10px;">
	<big><b>Teamsport App website</b></big>
	<br>
	<br>
	- Automatische notificatie bij tekort spelers
	<br>
	<br>
	- Verstuur automatische reminders voor teamspelers die zijn aanwezigheid nog niet heeft doorgegeven
	<br>
	<br>
	- Geef aanwezigheid door via adroid app, email of deze website
	<br>
	<br>
	- Importeer gegevens uit teamers.nl
	</b>
	<br>
	<br>
	- Berichten services
	<br>
	<br>
	- Gratis
	</b>
	</div>
<br>
	<div style="border:1px solid #000;background:#99CCFF;padding: 10px;">
	<big><b>Teamsport Android App </b></big>
	<br>
	<br>
	- Bekijk je wedstrijd agenda makkelijk met de app op je telefoon
	<br>
	<br>
	- Geef je aanwezigheid makkelijk en snel door via de app
	<br>
	<br>
	- Alle notificaties,berichten en reminders worden direct op je telefoon getoont
	<br>
	<br>
	- Plaast gemakkelijk de wedstrijden in je agenda
	<br>
	<br>
	- Koppeling met twitter zodat je je wedstrijd of eindstand kunt tweeten
	</b>
	</div>


	</td>
	</table>


<script language="JavaScript" type="text/JavaScript">
function afterCreateNewTeamWelkom(team)
{
	window.location = 'index.php?team='+team+'&section=wedstrijd';
}
</script>


<script language="JavaScript" type="text/JavaScript">
	addAfterCreateNewTeamHandlers(afterCreateNewTeamWelkom);
</script>


<?
}
?>