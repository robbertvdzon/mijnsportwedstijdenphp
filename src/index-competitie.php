<?

$compData = dbcalls\loadManagedCompetitionData($currentSelectedMCompetition);

?>
<script type="text/javascript">
    var initialCompetitionData = '<? echo addslashes(json_encode($compData)) ?>';
</script>
<?


function printProgramma(){
?>
<script src="teamsport-competitie.js"></script>


        <table width=100% border=0 cellspacing='0'>

            <tr height=20>
                <td align=left bgcolor=#2e6735><b><font color=white><!--T1093T-->&nbsp;Mijn competities<!--T1093T--></font></b>
                </td>
                <td colspan=99 align=right bgcolor=#2e6735>
                    <a id="modifyButton1a" class=none>&nbsp;</a>
                </td>
            </tr>
            <tr height=5><td colspan=99 ></td></tr>

            <tr>
                <td colspan=99 valign=top align=center width=140>
                    <p id="competitiesList" ></p>
                    <br>
                </td>
            </tr>
            
            </table>
            


<table width=100% border=0>
    <tr>
        <td width=17>
            <img id="ownprogImageA" src="images/tab-programma2.png" height=30px onClick="javascript:showOwnProgramma()">
        </td>
        <td width=17>
            <img id="ownuitslagenImageA" src="images/tab-uitslagen.png" height=30px onClick="javascript:showOwnUitslagen()">
        </td>
        <td width=17>
            <img id="ownprogImageB" src="images/tab-teamprogramma2.png" height=30px onClick="javascript:showOwnProgramma()">
        </td>
        <td width=17>
            <img id="ownuitslagenImageB" src="images/tab-teamuitslagen.png" height=30px onClick="javascript:showOwnUitslagen()">
        </td>
        <td width=17>
            <img id="progImage" src="images/tab-compprogramma.png" height=30px onClick="javascript:showProgramma()">
        </td>
        <td width=17>
            <img id="progUitslagen" src="images/tab-compuitslagen.png" height=30px onClick="javascript:showUitslagen()">
        </td>
        <td width=17>
            <img id="progStand" src="images/tab-stand.png" height=30px onClick="javascript:showStand()">
        </td>
<!--
        <td width=17>
            <img id="progDetails" src="images/tab-details.png" height=30px onClick="javascript:showDetails()">
        </td>
-->        
        <td width=100%>
            <img src="images/tab-line.png" width=100% height=30px >
        </td>
        <td align=right>
            <a id="modifyButton2a" class=none>&nbsp;</a>
        </td>
        
        </tr>
</table>



<!-- ********************************************************-->
<!-- *********** PROGRAMMA **********************************-->
<!-- ********************************************************-->
<p id="programma">
<!--T1094T-->programma<!--T1094T-->
</p>

<!-- ********************************************************-->
<!-- *********** UITSLAGEN **********************************-->
<!-- ********************************************************-->

<p id="uitslagen" style="display:none;" >
<!--T1095T-->uitslagen<!--T1095T-->
</p>



<!-- ********************************************************-->
<!-- *********** Stand **********************************-->
<!-- ********************************************************-->
<p id="stand" style="display:none;" >
<!--T1096T-->stand<!--T1096T-->
</p>

<!-- ********************************************************-->
<!-- *********** Stand **********************************-->
<!-- ********************************************************-->
<p id="details" style="display:none;" >
<!--T1097T-->details<!--T1097T-->
</p>

<!-- ********************************************************-->
<!-- *********** own programma **********************************-->
<!-- ********************************************************-->
<p id="ownprogramma" style="display:none;" >
<!--T1098T-->details<!--T1098T-->
</p>

<!-- ********************************************************-->
<!-- *********** own uitslag **********************************-->
<!-- ********************************************************-->
<p id="ownuitslagen" style="display:none;" >
<!--T1099T-->details<!--T1099T-->
</p>

<img src="../images/edit.png" height=35 id="modifyButton1b" onclick='document.getElementById("editCompetitions").style.display = "";' style="cursor: pointer;">
<img src="../images/edit.png" height=35 id="modifyButton2b" onclick='document.getElementById("addGamesScreen").style.display = "";' style="cursor: pointer;">


<div class="popup400" id="addGamesScreen" style="display:none">
    <div class="popup400Close" >
        <img src="../images/close.png"  onClick="javascript:document.getElementById('addGamesScreen').style.display = 'none'">
    </div>
    <table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
        <tr>
            <td align=middle height=30>
                <big><b><font color=white><!--T1100T-->Voeg wedstrijden toe<!--T1100T--></font></b></big>
            </td>
        </tr>
    </table>

    <table width=100% border=0 cellspacing='0'>
        <tr>
            <td align=center>
            <br>
            <br>
            <? printButton2("<!--T1101T-->voeg wedstrijden toe<!--T1101T-->","javascript:openNewGame();")  ?>
            <br><br>
            <!--
            <? printButton2("importeer uit teamers","javascript:importFromTeamersOpen();")  ?>
            -->

            <br>
        </tr>
    </table>
    <br><br>
</div>



<div class="popup800" id="importFromTeamersPage1" style="display:none">
    <div class="popup800Close" >
        <img src="../images/close.png"  onClick="javascript:document.getElementById('importFromTeamersPage1').style.display = 'none'">
    </div>
    <table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
        <tr>
            <td align=middle height=30>
                <big><b><font color=white>Importeer uit teamers.nl</font></b></big>
            </td>
        </tr>
    </table>

    <table width=100% border=0 cellspacing='0'>
        <tr>
            <td align=center>
            <br>
            <br>
            Log in op teamers.nl en kies selecteer 'mijn seizoen'.<br>
            Als het goed is zie je nu al je wedstrijden van dit seizoen staan.<br>
            Kies eventueel eerst het goede team of een ander seizoen.<br>
            <br>
            Kopieer nu de het web adres van teamers in onderstaande invul veld.<br><br>
            <input id="importTeamersURL" type="text" size=90/ value="http://www.teamers.nl/mijnseizoen.asp?s=xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx">
<!--
            <input id="importTeamersURL" type="text" size=90/ value="http://www.teamers.nl/mijnseizoen.asp?s=62DE8111-939D-433F-B4D9-4236A6A8E474">
-->

            <br><br>
            <a href="#" onclick="javascript:importFromTeamersStep1()">Zoek de wedstrijden via teamers</a>

            <br>
        </tr>
    </table>
    <br><br>
</div>


<div class="popup800" id="importFromTeamersPage2" style="display:none">
    <div class="popup800Close" >
        <img src="../images/close.png"  onClick="javascript:document.getElementById('importFromTeamersPage2').style.display = 'none'">
    </div>
    <table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
        <tr>
            <td align=middle height=30>
                <big><b><font color=white>Importeer uit teamers.nl</font></b></big>
            </td>
        </tr>
    </table>

    <table width=100% border=0 cellspacing='0'>
        <tr>
            <td align=center>
                <br>
                <br>
                <p id="importFromTeamersGames">
                </p>
                <br>
                <a href='#' onclick='javascript:importFromTeamersStep2()'>Importeer bovenstaande wedstrijden</a>
            </td>
            </tr>
        </table>
        <br><br>
</div>


<div class="popup800" id="newGame" style="display:none">
    <div class="popup800Close" >
        <img src="../images/close.png"  onClick="javascript:document.getElementById('newGame').style.display = 'none'">
    </div>
    <table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
        <tr>
            <td align=middle height=30>
                <big><b><font color=white><!--T1102T-->Voeg wedstrijden toe<!--T1102T--></font></b></big>
            </td>
        </tr>
    </table>

    <table width=100% border=0 cellspacing='0' cellspacing='0'>
        <tr>
            <td align=center>

                <br>
                <table>
                    <tr>
                        <td width=10>&nbsp;</td>
                        <td><b><!--T1103T-->Datum (dd-mm-yyyy)<!--T1103T--></b></td>
                        <td width=10>&nbsp;</td>
                        <td><b><!--T1104T-->Tijd<!--T1104T--></b></td>
                        <td width=10>&nbsp;</td>
                        <td><b><!--T1105T-->Tegenstander<!--T1105T--></b></td>
                        <td width=10>&nbsp;</td>
                        <td><b><!--T1106T-->Thuiswedstrijd<!--T1106T--></b></td>
                    </tr>
<?

for ($i=1;$i<10;$i++){

?>
                    <tr>
                        <td width=10>&nbsp;</td>
                        <td><input id="newGameDate<? echo $i ?>" type="text" class="gameEditFields150" value=""/></td>
                        <td width=10>&nbsp;</td>
                        <td><input id="newGameTime<? echo $i ?>"" type="text" class="gameEditFields50" value=""/></td>
                        <td width=10>&nbsp;</td>
                        <td><input id="newGameOpponent<? echo $i ?>"" type="text" class="gameEditFields" value=""/></td>
                        <td width=10>&nbsp;</td>
                        <td><input id="newHomegame<? echo $i ?>"" type="checkbox" value="true" class="gameCheckbox"/></td>
                    </tr>
<?

}

?>


                </table>

                <br>

                <? printButton2("<!--T1107T-->Voeg toe<!--T1107T-->","javascript:addGame();")  ?>

                <br><br>
            </td>
        </tr>
    </table>
</div>

                          
<div class="popup800" id="editCompetitions" style="display:none">
    <div class="popup800Close" >
        <img src="../images/close.png"  onClick="javascript:document.getElementById('editCompetitions').style.display = 'none'">
    </div>
    <table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
        <tr>
            <td align=middle height=30>
                <big><b><font color=white><!--T1108T-->Competities<!--T1108T--></font></b></big>
            </td>
        </tr>
    </table>

    <table width=100% border=0 cellspacing='0'>
        <tr>
            <td align=center>
                <br>
                <p id='competitionList'></p>
                <br>
                <br>
                <a href="#" onclick="javascript:saveCompetitions();"><!--T1109T-->Sla veranderingen op<!--T1109T--></a>
                &nbsp;&nbsp;
                <a href="#" onclick="javascript:openNewCompetition();"><!--T1110T-->Voeg competitie toe<!--T1110T--></a>
                <br><br>
            </td>
        </tr>
    </table>
</div>



<div class="popup300Lower" id="newCompetition" style="display:none">
    <div class="popup300Close" >
        <img src="../images/close.png"  onClick="javascript:document.getElementById('newCompetition').style.display = 'none'">
    </div>
    <table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
        <tr>
            <td align=middle height=30>
                <big><b><font color=white><!--T1111T-->Nieuw competitie toevoegen<!--T1111T--></font></b></big>
            </td>
        </tr>
    </table>

    <table width=100% border=0 cellspacing='0'>
        <tr>
            <td align=center>
            <br>            
            <table>
                <tr>
                    <td><b><!--T1112T-->Seizoen<!--T1112T--></b></td>
                    <td width=10px>&nbsp;:&nbsp;</br>
                    <td><input id="newSeasonText" type="text" /></td>
                </tr>
                <tr>
                    <td><b><!--T1113T-->Competitie<!--T1113T--></b></td>
                    <td width=10px>&nbsp;:&nbsp;</br>
                    <td><input id="newCompetitionText" type="text" /></td>
                </tr>
                <tr>
                    <td><b><!--T1114T-->Status<!--T1114T--></b></td>
                    <td width=10px>&nbsp;:&nbsp;</br>
                    <td>
                        <select id=newStatusText>
                        <option selected  value=0><!--T1115T-->Actief<!--T1115T--></option>
                        <option value=1><!--T1116T-->Afgelopen<!--T1116T--></option>
                        <option value=2><!--T1117T-->Volgend jaar<!--T1117T--></option>
                        </select>
                    </td>
                </tr>
            </table>
            <br>
            <br><br>
            <a href="#" onclick="javascript:addCompetition()"><!--T1118T-->Voeg toe<!--T1118T--></a>
            <br><br>
            </td>
        </tr>
    </table>
</div>


<script language="JavaScript" type="text/JavaScript">
    ts_loadTeamsDropdown(eval('(' + initalTeams + ')'));
    loadCompetitionsData(eval('('+initialCompetitions+')'),true);
    loadGamesDataUitslagen(eval('('+initialGames+')'));
    loadGamesDataProgramma(eval('('+initialGames+')'));
    loadCompetitieProgrammaData(eval('('+initialCompetitionData+')'));
    loadCompetitieUitslagenData(eval('('+initialCompetitionData+')'));
    loadCompetitieStand(eval('('+initialCompetitionData+')'));
  
    showOwnProgramma();
    competitionSelectionChanged();

    // enable or disable edit buttons
    checkPermissions();

</script>

<?
}
?>