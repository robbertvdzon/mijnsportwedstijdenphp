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
/*************************************/

function mijnCompetitiesOpen($competitionID,$reportType){
    
    $compData = dbcalls\loadManagedCompetitionData($competitionID);
    
    if ($reportType=="programma"){
    ?>
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
                    echo "<tr height=10px><td colspan=99><b><br>Speelronde ".$game->playround."&nbsp;,&nbsp; ".$dateStr."</b></td></tr>";    
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
                    <a target=_blank href="http://www.mijnsportwedstrijden.nl/index.php?team=<? echo $game->teamID1?>&section=competitie" class=none3>
                    <? echo $game->teamName1 ?>
                    </a>
                </td>    
                <td>&nbsp;&nbsp;&nbsp;</td>    
                <td>-</td>    
                <td>&nbsp;&nbsp;&nbsp;</td>    
                <td >
                    <a target=_blank href="http://www.mijnsportwedstrijden.nl/index.php?team=<? echo $game->teamID2?>&section=competitie" class=none3>
                    <? echo $game->teamName2 ?>
                    </a>
                </td>    
                
                </tr>
    <?
            }
    ?>
        </table>    
    <?
    }
    
    if ($reportType=="uitslagen"){
    ?>
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
                echo "<tr height=10px><td colspan=99><b><br>Speelronde ".$game->playround."&nbsp;,&nbsp; ".$dateStr."</b></td></tr>";    
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
            <a target=_blank href="http://www.mijnsportwedstrijden.nl/index.php?team=<? echo $game->teamID1?>&section=competitie" class=none3>
            <? echo $game->teamName1 ?>
            </a>
        </td>    
        <td>&nbsp;&nbsp;&nbsp;</td>    
        <td>-</td>    
        <td>&nbsp;&nbsp;&nbsp;</td>    
        <td >
            <a target=_blank href="http://www.mijnsportwedstrijden.nl/index.php?team=<? echo $game->teamID2?>&section=competitie" class=none3>
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
    <?
        
    }
    
    if ($reportType=="stand"){
    ?>
        <table>
        
        
        <tr>
        <td>
            <b>Plaats</b>
        </td>    
        <td>&nbsp;&nbsp;&nbsp;</td>    
        <td>
            <b>Team</b>
        </td>    
        <td>&nbsp;&nbsp;&nbsp;</td>    
        <td>
            <b>Punten</b>
        </td>    
        <td>&nbsp;&nbsp;&nbsp;</td>    
        <td>
            <b>Gespeeld</b>
        </td>    
        <td>&nbsp;&nbsp;&nbsp;</td>    
        <td>
            <b>Gewonnen</b>
        </td>    
        <td>&nbsp;&nbsp;&nbsp;</td>    
        <td>
            <b>Verloren</b>
        </td>    
        <td>&nbsp;&nbsp;&nbsp;</td>    
        <td>
            <b>Gelijk</b>
        </td>    
        <td>&nbsp;&nbsp;&nbsp;</td>    
        <td>
            <b>Saldo</b>
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
            <a target=_blank href="http://www.mijnsportwedstrijden.nl/index.php?team=<? echo $team->id?>&section=competitie" class=none2>
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
    
    <?    
        
        
    }
}
?>
