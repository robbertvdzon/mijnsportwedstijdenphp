<?
include_once ("dbcalls.php");

function printSearch(){
?>
<script src="teamsport-seachcompetition.js"></script>
<?    
$team = "";
$org = "";

if (isset($_REQUEST['searchteam'])) {
    $team = $_REQUEST['searchteam'];
}

if (isset($_REQUEST['searchorg'])) {
    $org = $_REQUEST['searchorg'];    
}

$mCompetitions =dbcalls\getManagedcompetitions($team,$org);


?>

<br>
<big><b><!--T1238T-->Gevonden competities<!--T1238T--></b></big>
<br><br>

<table>
    
<tr>
<td>
    <b><!--T1239T-->Organisatie<!--T1239T--></b>
</td>    
<td>&nbsp;&nbsp;&nbsp;</td>    
<td>
    <b><!--T1240T-->Seizoen<!--T1240T--></b>
</td>    
<td>&nbsp;&nbsp;&nbsp;</td>    
<td>
    <b><!--T1241T-->Competitie<!--T1241T--></b>
</td>    

</tr>
        
<?

foreach ($mCompetitions as $mCompetition) {
?>
<tr class="clickabletable" onClick="openCompetition(<? echo $mCompetition->id ?>)">
<td>
    <? echo $mCompetition->organisation ?>
</td>    
<td>&nbsp;&nbsp;&nbsp;</td>    
<td>
    <? echo $mCompetition->season ?>
</td>    
<td>&nbsp;&nbsp;&nbsp;</td>    
<td>
    <? echo $mCompetition->competition ?>
</td>    

</tr>
<?
}

?>
</table>    



<script language="JavaScript" type="text/JavaScript">
    ts_loadTeamsDropdown(eval('(' + initalTeams + ')'));
//    loadCompetitionsData(eval('('+initialCompetitions+')'),true);
//    loadReportButtons(eval('(' + initialSelectedTeam + ')'));
//    loadListsOverview(eval('(' + initialSelectedTeam + ')')); 
//    loadListDataHandler(eval('('+initialListData+')'));
    // enable or disable edit buttons
    //checkPermissions();
</script>

<?
}
?>
