<?


function printProgramma(){
?>
<script src="teamsport-programma.js"></script>


<b>Competitie:</b>
<select id= "selectcompetition2" class="selectCompetitionDropdown" onchange="javascript:competitionSelect();"></select>
&nbsp;&nbsp; <a href=# onClick="document.getElementById('editCompetitions').style.display = '';"><!--T1184T-->Bewerk competities<!--T1184T--></a>

        <br><br>
        <table width=100% border=0 cellspacing='0'>

            <tr height=20>
                <td align=left bgcolor=#2e6735><b><font color=white><!--T1185T-->&nbsp;Gespeeld<!--T1185T--></font></b>
                </td>
                <td colspan=99 align=right bgcolor=#2e6735>
                    <a id="modifyButton1a" class=none>&nbsp;</a>
                </td>
            </tr>
            <tr height=5><td colspan=99 ></td></tr>

            <tr>
                <td colspan=99 valign=top algign=center width=140>
                    <p id="uitslagenList" ></p>
                    <br>
                </td>
            </tr>

            <tr height=20>
                <td align=left bgcolor=#2e6735><b><font color=white><!--T1186T-->&nbsp;Programma<!--T1186T--></font></b>
                </td>
                <td colspan=99 align=right bgcolor=#2e6735>
                    <a id="modifyButton2a" class=none>&nbsp;</a>
                </td>
            </tr>
            <tr height=5><td colspan=99 ></td></tr>

            <tr>
                <td colspan=99 valign=top algign=center width=140>
                    <p id="programmaList" ></p>
                </td>
            </tr>

        </table>

<br>
<p id="tip1">
<!--T1187T--><b>Tip: druk op het edit icoontje van het programma om wedstrijden toe te voegen of je aanwezigheid aan te passen...</b><!--T1187T-->
</p>
<p id="tip2">
<!--T1188T--><b>Tip: druk op het edit icoontje van het programma om je aanwezigheid aan te passen...</b><!--T1188T-->
</p>
<br><br>
<img src="../images/edit.png" height=35 id="modifyButton1b" onclick='document.getElementById("editUitslagen").style.display = "";' style="cursor: pointer;">
<img src="../images/edit.png" height=35 id="modifyButton2b" onclick='document.getElementById("editProgramma").style.display = "";' style="cursor: pointer;">




<!--  EDIT UITSLAGEN --->

        <div class="popup800" id="editUitslagen" style="display:none">
        <div class="popup800Close" >
            <img src="../images/close.png"  onClick="javascript:document.getElementById('editUitslagen').style.display = 'none'">
        </div>

        <table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
            <tr>
                <td align=middle height=30>
                    <big><b><font color=white><!--T1189T-->Bewerk uitslagen<!--T1189T--></font></b></big>
                </td>

            </tr>
        </table>
        <br>
        <table width=100% border=0 cellspacing='0'>
            <tr>
                <td align=middle>
                    <table width=100% border=0 cellspacing='0'>
                        <tr>
                            <td colspan=99 valign=top align=center >
                                <p id="uitslagenEditList" ></p>
                                <br>
                            </td>
                        </tr>
                    </table>
                    <table cellspacing='0'>
                        <tr>
                        <td>
                            <? printButton2("<!--T1190T-->voeg een wedstrijd toe<!--T1190T-->","javascript:openNewGame();")  ?>
                        </td>
                        <td>
                            <? printButton2("<!--T1191T-->importeer uit teamers<!--T1191T-->","javascript:importFromTeamersOpen();")  ?>
                        </td>
                        </tr>
                    </table>

                    <br><br>
                </td>
            </tr>
        </table>
        </div>


<!--  EDIT PROGRAMMA --->

        <div class="popup800" id="editProgramma" style="display:none">
        <div class="popup800Close" >
            <img src="../images/close.png"  onClick="javascript:document.getElementById('editProgramma').style.display = 'none'">
        </div>

        <table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
            <tr>
                <td align=middle height=30>
                    <big><b><font color=white><!--T1192T-->Bewerk programma<!--T1192T--></font></b></big>
                </td>

            </tr>
        </table>
        <br>
        <table width=100% border=0 cellspacing='0'>
            <tr>
                <td align=middle>
                    <table width=100% border=0 cellspacing='0'>
                            <td colspan=99 valign=top align=center >
                                <p id="programmaEditList" ></p>
                                <br>
                            </td>
                        </tr>
                    </table>


                    <table cellspacing='0'>
                        <tr>
                        <td>
                            <? printButton2("<!--T1193T-->voeg een wedstrijd toe<!--T1193T-->","javascript:openNewGame();")  ?>
                        </td>
                        </tr>
                    </table>
                    <br><br>
                </td>
            </tr>
        </table>
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
                <big><b><font color=white><!--T1194T-->Voeg wedstrijden toe<!--T1194T--></font></b></big>
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
                        <td><b><!--T1195T-->Datum (dd-mm-yyyy)<!--T1195T--></b></td>
                        <td width=10>&nbsp;</td>
                        <td><b><!--T1196T-->Tijd<!--T1196T--></b></td>
                        <td width=10>&nbsp;</td>
                        <td><b><!--T1197T-->Tegenstander<!--T1197T--></b></td>
                        <td width=10>&nbsp;</td>
                        <td><b><!--T1198T-->Thuiswedstrijd<!--T1198T--></b></td>
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

                <? printButton2("<!--T1199T-->Voeg toe<!--T1199T-->","javascript:addGame();")  ?>

                <br><br>
            </td>
        </tr>
    </table>
</div>


<div class="popup400" id="editCompetitions" style="display:none">
    <div class="popup400Close" >
        <img src="../images/close.png"  onClick="javascript:document.getElementById('editCompetitions').style.display = 'none'">
    </div>
    <table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
        <tr>
            <td align=middle height=30>
                <big><b><font color=white><!--T1200T-->Competities<!--T1200T--></font></b></big>
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
                <a href="#" onclick="javascript:saveCompetitions();"><!--T1201T-->Sla veranderingen op<!--T1201T--></a>
                &nbsp;&nbsp;
                <a href="#" onclick="javascript:openNewCompetition();"><!--T1202T-->Voeg competitie toe<!--T1202T--></a>
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
                <big><b><font color=white><!--T1203T-->Nieuw competitie toevoegen<!--T1203T--></font></b></big>
            </td>
        </tr>
    </table>

    <table width=100% border=0 cellspacing='0'>
        <tr>
            <td align=center>
            <br>
            <br>
            <input id="newSeasonText" type="text" />
            <br><br>
            <a href="#" onclick="javascript:addCompetition()"><!--T1204T-->Voeg toe<!--T1204T--></a>
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

    //select the dropdown
    document.getElementById('selectcompetition2').value = initialSelectedCompetition;

    // enable or disable edit buttons
    checkPermissions();

</script>

<?
}
?>