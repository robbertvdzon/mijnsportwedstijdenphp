<?
include_once ("dbcalls.php");

function printOpen(){
?>
<script src="teamsport-opencompetition.js"></script>
<?    
$comp = "";

if (isset($_REQUEST['comp'])) {
    $comp = $_REQUEST['comp'];
}

$compData = dbcalls\loadManagedCompetitionData($comp);


?>

<br>
<b><big>
    <? echo $compData->organisation?>
    <br>
    <? echo $compData->competition?>
    <br>
    </big>
    <? echo $compData->season?>
    </b>
<br><br>


<table width=100% border=0>
    <tr>
        <td width=17>
            <img id="progImage" src="images/tab-programma2.png"  height=30px onClick="javascript:showProgramma()">
        </td>
        <td width=17>
            <img id="progUitslagen" src="images/tab-uitslagen.png"  height=30px onClick="javascript:showUitslagen()">
        </td>
        <td width=17>
            <img id="progStand" src="images/tab-stand.png"  height=30px onClick="javascript:showStand()">
        </td>
        <td>
            <img src="images/tab-line.png" width=100% height=30px>
        </td>
        </tr>
</table>

<!-- ********************************************************-->
<!-- *********** PROGRAMMA **********************************-->
<!-- ********************************************************-->
<p id="programma">
<table>
    
<?
$lastPlayroundAndDate = "";
$now = time();
foreach ($compData->games as $game) {
    if ($game->datetime < $now) continue;
    $gameDate = new DateTime();
    date_timestamp_set($gameDate, $game->datetime);
    $dateStr =  $gameDate->format('l d M Y');
    $timeStr =  $gameDate->format('H:i');
        
    $newPlayroundAndDate=$game->playround.$dateStr;
        
    if ($newPlayroundAndDate!=$lastPlayroundAndDate){
        $lastPlayroundAndDate=$newPlayroundAndDate;
        echo "<tr height=10px><td colspan=99><b><br><!--T1174T-->Speelronde<!--T1174T--> ".$game->playround."&nbsp;,&nbsp; ".$dateStr."</b></td></tr>";    
    }
    
?>
<tr>
<td>
    <? echo $game->location ?>
</td>    
<td>&nbsp;&nbsp;&nbsp;</td>    
<td >
    <? echo $timeStr ?>
</td>    
<td>&nbsp;&nbsp;&nbsp;</td>    
<td >
    <a target=_blank href="index.php?team=<? echo $game->teamID1?>&section=competitie" class=none3>
    <? echo $game->teamName1 ?>
    </a>
</td>    
<td>&nbsp;&nbsp;&nbsp;</td>    
<td>-</td>    
<td>&nbsp;&nbsp;&nbsp;</td>    
<td >
    <a target=_blank href="index.php?team=<? echo $game->teamID2?>&section=competitie" class=none3>
    <? echo $game->teamName2 ?>
    </a>
</td>    

</tr>
<?
}


?>
</table>    
</p>

<!-- ********************************************************-->
<!-- *********** UITSLAGEN **********************************-->
<!-- ********************************************************-->

<p id="uitslagen" style="display:none;" >

<table>

    
<?
$lastPlayroundAndDate = "";
$now = time();
foreach ($compData->games as $game) {
    if ($game->datetime >= $now) continue;
    $gameDate = new DateTime();
    date_timestamp_set($gameDate, $game->datetime);
    $dateStr =  $gameDate->format('l d M Y');
    $timeStr =  $gameDate->format('H:i');
        
    $newPlayroundAndDate=$game->playround.$dateStr;
        
    if ($newPlayroundAndDate!=$lastPlayroundAndDate){
        $lastPlayroundAndDate=$newPlayroundAndDate;
        echo "<tr height=10px><td colspan=99><b><br><!--T1175T-->Speelronde<!--T1175T--> ".$game->playround."&nbsp;,&nbsp; ".$dateStr."</b></td></tr>";    
    }
    
?>
<tr>
<td>
    <? echo $game->location ?>
</td>    
<td>&nbsp;&nbsp;&nbsp;</td>    
<td >
    <? echo $timeStr ?>
</td>    
<td>&nbsp;&nbsp;&nbsp;</td>    
<td >
    <a target=_blank href="index.php?team=<? echo $game->teamID1?>&section=competitie" class=none3>
    <? echo $game->teamName1 ?>
    </a>
</td>    
<td>&nbsp;&nbsp;&nbsp;</td>    
<td>-</td>    
<td>&nbsp;&nbsp;&nbsp;</td>    
<td >
    <a target=_blank href="index.php?team=<? echo $game->teamID2?>&section=competitie" class=none3>
    <? echo $game->teamName2 ?>
    </a>
</td>    
<td>&nbsp;&nbsp;&nbsp;</td>    
<td>
    <? echo $game->score ?>
</td>    

</tr>
<?
}


?>
</table>    
</p>



<!-- ********************************************************-->
<!-- *********** Stand **********************************-->
<!-- ********************************************************-->
<p id="stand" style="display:none;" >
<table>


<tr>
<td>
    <b><!--T1176T-->Plaats<!--T1176T--></b>
</td>    
<td>&nbsp;&nbsp;&nbsp;</td>    
<td>
    <b><!--T1177T-->Team<!--T1177T--></b>
</td>    
<td>&nbsp;&nbsp;&nbsp;</td>    
<td>
    <b><!--T1178T-->Punten<!--T1178T--></b>
</td>    
<td>&nbsp;&nbsp;&nbsp;</td>    
<td>
    <b><!--T1179T-->Gespeeld<!--T1179T--></b>
</td>    
<td>&nbsp;&nbsp;&nbsp;</td>    
<td>
    <b><!--T1180T-->Gewonnen<!--T1180T--></b>
</td>    
<td>&nbsp;&nbsp;&nbsp;</td>    
<td>
    <b><!--T1181T-->Verloren<!--T1181T--></b>
</td>    
<td>&nbsp;&nbsp;&nbsp;</td>    
<td>
    <b><!--T1182T-->Gelijk<!--T1182T--></b>
</td>    
<td>&nbsp;&nbsp;&nbsp;</td>    
<td>
    <b><!--T1183T-->Saldo<!--T1183T--></b>
</td>    

</tr>
    
<?
$lastPlayround = "";
$index = 0;
foreach ($compData->teams as $team) {
    $index++;
?>

<tr>    
<td>
    <? echo $index ?>
</td>    
<td>&nbsp;&nbsp;&nbsp;</td>    

<td >
    <a target=_blank href="index.php?team=<? echo $team->id?>&section=competitie" class=none2>
    <? echo $team->teamname ?>
    </a>
</td>    

<td>&nbsp;&nbsp;&nbsp;</td>    
<td>
    <? echo $team->punten ?>
</td>    
<td>&nbsp;&nbsp;&nbsp;</td>    
<td>
    <? echo $team->numGespeeld ?>
</td>    
<td>&nbsp;&nbsp;&nbsp;</td>    
<td>
    <? echo $team->numGewonnen ?>
</td>    
<td>&nbsp;&nbsp;&nbsp;</td>    
<td>
    <? echo $team->numVerloren ?>
</td>    
<td>&nbsp;&nbsp;&nbsp;</td>    
<td>
    <? echo $team->numGelijk ?>
</td>    
<td>&nbsp;&nbsp;&nbsp;</td>    
<td>
    <? echo $team->saldoVoor."-".$team->saldoTegen ?>
</td>    

</tr>
<?
}


?>
</table>    
</p>


<script language="JavaScript" type="text/JavaScript">
    ts_loadTeamsDropdown(eval('(' + initalTeams + ')'));
</script>

<?
}
?>
