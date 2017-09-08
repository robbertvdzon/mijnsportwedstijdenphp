<?
function printUserSettings(){
?>
<big><b><!--T1308T-->Gebruikers instellingen<!--T1308T--></b></big>
<br>
<br>
<table cellspacing='0'>
	<tr>
		<td><b><!--T1309T-->Naam:<!--T1309T--></b></td>
		<td>
		<input name="" type="text" />
		</td>
	</tr>
	<tr>
		<td><b><!--T1310T-->Email:<!--T1310T--></b></td>
		<td>
		<input name="" type="text" />
		</td>
	</tr>
	<tr>
		<td></td>
		<td>
		<br>
		<a href=game.php><!--T1311T-->Opslaan<!--T1311T--></a>
		<br>
		<br>
		<a href=index.php><!--T1312T-->Verander wachtwoord<!--T1312T--></a>
		<br>
		<a href=index.php><!--T1313T-->Verwijder dit account<!--T1313T--></a></td>
	</tr>
</table>

<script language="JavaScript" type="text/JavaScript">
    ts_loadTeamsDropdown(eval('(' + initalTeams + ')'));
    
    //select any dropdown items 
    
    //set the handlers
</script>

<?
}
?>
