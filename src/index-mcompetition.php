<?


function printCompetition(){
?>
<script src="teamsport-mcompetition.js"></script>


<table>
<tr>
<td>
<b><!--T1136T-->Organisatie:<!--T1136T--></b>
</td>
<td>
<select id= "selectorganisations2" class="selectSeasonDropdown" onchange="javascript:organisationSelect();"></select>
</td>
<td>
&nbsp;&nbsp; <a href=# onClick="document.getElementById('editOrganisation').style.display = '';"><!--T1137T-->Bewerk organisatie<!--T1137T--></a>
</td>
</tr>

<tr>
<td>
<b><!--T1138T-->Seizoen:<!--T1138T--></b>
</td>
<td>
<select id= "selectseason2" class="selectSeasonDropdown" onchange="javascript:seasonSelect();"></select>
</td>
<td>
&nbsp;&nbsp; <a href=# onClick="document.getElementById('editSeasons').style.display = '';"><!--T1139T-->Bewerk seizoenen<!--T1139T--></a>
</td>
</tr>

<tr>
<td>
<b><!--T1140T-->Competitie:<!--T1140T--></b>
</td>
<td>
<select id= "selectcompetition2" class="selectSeasonDropdown" onchange="javascript:competitionSelect();"></select>
</td>
<td>
&nbsp;&nbsp; <a href=# onClick="document.getElementById('editCompetitions').style.display = '';"><!--T1141T-->Bewerk competities<!--T1141T--></a>
</td>
</tr>

</table>



<table width=100% border=0>
    <tr>
        <td width=178>
            <img id="progTeams" src="images/tab-teams2.png" height=30px onClick="javascript:showTeams()">
        </td>
        <td width=178>
            <img id="progImage" src="images/tab-programma.png" height=30px onClick="javascript:showProgramma()">
        </td>
        <td width=178>
            <img id="progUitslagen" src="images/tab-uitslagen.png" height=30px onClick="javascript:showUitslagen()">
        </td>
        <td width=178>
            <img id="progStand" src="images/tab-stand.png" height=30px onClick="javascript:showStand()">
        </td>
        <td width=100%>
            <img src="images/tab-line.png" width=100% height=30px >
        </td>
        <td align=right>
            <a id="modifyButton1a" class=none>&nbsp;</a>
        </td>

        </tr>
</table>

<!-- ********************************************************-->
<!-- *********** Teams **********************************-->
<!-- ********************************************************-->
<p id="teams" >
<!--T1142T-->teams<!--T1142T-->
</p>

<!-- ********************************************************-->
<!-- *********** PROGRAMMA **********************************-->
<!-- ********************************************************-->
<p id="programma" style="display:none;" >
<!--T1143T-->programma<!--T1143T-->
</p>

<!-- ********************************************************-->
<!-- *********** UITSLAGEN **********************************-->
<!-- ********************************************************-->

<p id="uitslagen" style="display:none;" >
<!--T1144T-->uitslagen<!--T1144T-->
</p>



<!-- ********************************************************-->
<!-- *********** Stand **********************************-->
<!-- ********************************************************-->
<p id="stand" style="display:none;" >
<!--T1145T-->stand<!--T1145T-->
</p>

<!-- ********************************************************-->
<!-- *********** Stand **********************************-->
<!-- ********************************************************-->
<p id="details" style="display:none;" >
<!--T1146T-->details<!--T1146T-->
</p>



<img src="../images/edit.png" height=35 id="modifyButton1b" onclick='editCompetition()' style="cursor: pointer;">

   
<div class="popup400" id="editCompetitions" style="display:none">
    <div class="popup400Close" >
        <img src="../images/close.png"  onClick="javascript:document.getElementById('editCompetitions').style.display = 'none'">
    </div>
    <table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
        <tr>
            <td align=middle height=30>
                <big><b><font color=white><!--T1147T-->Competities<!--T1147T--></font></b></big>
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
                <a href="#" onclick="javascript:saveCompetitions();"><!--T1148T-->Sla veranderingen op<!--T1148T--></a>
                &nbsp;&nbsp;
                <a href="#" onclick="javascript:openNewCompetition();"><!--T1149T-->Voeg competitie toe<!--T1149T--></a>
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
                <big><b><font color=white><!--T1150T-->Nieuwe competitie toevoegen<!--T1150T--></font></b></big>
            </td>
        </tr>
    </table>

    <table width=100% border=0 cellspacing='0'>
        <tr>
            <td align=center>
            <br>            
            <table>
                <tr>
                    <td><b><!--T1151T-->Competitie<!--T1151T--></b></td>
                    <td width=10px>&nbsp;:&nbsp;</br>
                    <td><input id="newCompetitionText" type="text" /></td>
                </tr>
            </table>
            <br>
            <br><br>
            <a href="#" onclick="javascript:addCompetition()"><!--T1152T-->Voeg toe<!--T1152T--></a>
            <br><br>
            </td>
        </tr>
    </table>
</div>




   
<div class="popup400" id="editSeasons" style="display:none">
    <div class="popup400Close" >
        <img src="../images/close.png"  onClick="javascript:document.getElementById('editSeasons').style.display = 'none'">
    </div>
    <table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
        <tr>
            <td align=middle height=30>
                <big><b><font color=white><!--T1153T-->Seizoenen<!--T1153T--></font></b></big>
            </td>
        </tr>
    </table>

    <table width=100% border=0 cellspacing='0'>
        <tr>
            <td align=center>
                <br>
                <p id='seasonList'></p>
                <br>
                <br>
                <a href="#" onclick="javascript:saveSeasons();"><!--T1154T-->Sla veranderingen op<!--T1154T--></a>
                &nbsp;&nbsp;
                <a href="#" onclick="javascript:openNewSeason();"><!--T1155T-->Voeg seizoen toe<!--T1155T--></a>
                <br><br>
            </td>
        </tr>
    </table>
</div>



<div class="popup300Lower" id="newSeason" style="display:none">
    <div class="popup300Close" >
        <img src="../images/close.png"  onClick="javascript:document.getElementById('newSeason').style.display = 'none'">
    </div>
    <table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
        <tr>
            <td align=middle height=30>
                <big><b><font color=white><!--T1156T-->Nieuw seizoen toevoegen<!--T1156T--></font></b></big>
            </td>
        </tr>
    </table>

    <table width=100% border=0 cellspacing='0'>
        <tr>
            <td align=center>
            <br>            
            <table>
                <tr>
                    <td><b><!--T1157T-->Seizoen<!--T1157T--></b></td>
                    <td width=10px>&nbsp;:&nbsp;</br>
                    <td><input id="newSeasonText" type="text" /></td>
                </tr>
            </table>
            <br>
            <br><br>
            <a href="#" onclick="javascript:addSeason()"><!--T1158T-->Voeg toe<!--T1158T--></a>
            <br><br>
            </td>
        </tr>
    </table>
</div>



<div class="popup400" id="editOrganisation" style="display:none">
    <div class="popup400Close" >
        <img src="../images/close.png"  onClick="javascript:document.getElementById('editOrganisation').style.display = 'none'">
    </div>
    <table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
        <tr>
            <td align=middle height=30>
                <big><b><font color=white><!--T1159T-->Organisaties<!--T1159T--></font></b></big>
            </td>
        </tr>
    </table>

    <table width=100% border=0 cellspacing='0'>
        <tr>
            <td align=center>
                <br>
                <p id='organisationList'></p>
                <br>
                <br>
                <a href="#" onclick="javascript:saveOrganisations();"><!--T1160T-->Sla veranderingen op<!--T1160T--></a>
                &nbsp;&nbsp;
                <a href="#" onclick="javascript:openNewOrganisation();"><!--T1161T-->Voeg organisatie toe<!--T1161T--></a>
                <br><br>
            </td>
        </tr>
    </table>
</div>



<div class="popup300Lower" id="newOrganisation" style="display:none">
    <div class="popup300Close" >
        <img src="../images/close.png"  onClick="javascript:document.getElementById('newOrganisation').style.display = 'none'">
    </div>
    <table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
        <tr>
            <td align=middle height=30>
                <big><b><font color=white><!--T1162T-->Nieuwe organisatie toevoegen<!--T1162T--></font></b></big>
            </td>
        </tr>
    </table>

    <table width=100% border=0 cellspacing='0'>
        <tr>
            <td align=center>
            <br>            
            <table>
                <tr>
                    <td><b>Organisatie</b></td>
                    <td width=10px>&nbsp;:&nbsp;</br>
                    <td><input id="newOrganisationText" type="text" /></td>
                </tr>
            </table>
            <br>
            <br><br>
            <a href="#" onclick="javascript:addOrganisation()"><!--T1163T-->Voeg toe<!--T1163T--></a>
            <br><br>
            </td>
        </tr>
    </table>
</div>



<!--  EDIT UITSLAGEN --->

        <div class="popup1000" id="editGames" style="display:none">
        <div class="popup1000Close" >
            <img src="../images/close.png"  onClick="javascript:document.getElementById('editGames').style.display = 'none'">
        </div>

        <table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
            <tr>
                <td align=middle height=30>
                    <big><b><font color=white><!--T1164T-->Bewerk wedstrijden<!--T1164T--></font></b></big>
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
                                <p id="gamesList" ></p>
                                <br>
                            </td>
                        </tr>
                    </table>
                    <table cellspacing='0'>
                        <tr>
                        <td>
                            <table>
                                <tr>
                                    <td>
                                        <? printButton2("<!--T1165T-->Opslaan<!--T1165T-->","javascript:saveGames();")  ?>
                                    </td>
                                    <td>
                                        <? printButton2("<!--T1166T-->voeg wedstrijden toe<!--T1166T-->","javascript:openNewGames();")  ?>
                                    </td>
                            </table>
                        </td>
                        </tr>
                    </table>

                    <br><br>
                </td>
            </tr>
        </table>
        </div>



<div class="popup1000" id="newGames" style="display:none">
    <div class="popup1000Close" >
        <img src="../images/close.png"  onClick="javascript:document.getElementById('newGames').style.display = 'none'">
    </div>
    <table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
        <tr>
            <td align=middle height=30>
                <big><b><font color=white><!--T1167T-->Voeg wedstrijden toe<!--T1167T--></font></b></big>
            </td>
        </tr>
    </table>

    <table width=100% border=0 cellspacing='0' cellspacing='0'>
        <tr>
            <td align=center>

                <br>
                <p id="newGamesList" ></p>
                <br>

                <? printButton2("<!--T1168T-->Voeg toe<!--T1168T-->","javascript:addGames();")  ?>

                <br><br>
            </td>
        </tr>
    </table>
</div>


            
<div class="popup800" id="editTeams" style="display:none">
    <div class="popup800Close" >
        <img src="../images/close.png"  onClick="javascript:document.getElementById('editTeams').style.display = 'none'">
    </div>
    <table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
        <tr>
            <td align=middle height=30>
                <big><b><font color=white><!--T1169T-->Bewerk team gegevens<!--T1169T--></font></b></big>
            </td>
        </tr>
    </table>

    <table width=100% border=0 cellspacing='0'>
        <tr>
            <td align=center>
                <br>
                <p id='teamsList'></p>
                <br>
                <br>
                <a href="#" onclick="javascript:saveTeams();"><!--T1170T-->Sla veranderingen op<!--T1170T--></a>
                &nbsp;&nbsp;
                <a href="#" onclick="javascript:openNewTeams();"><!--T1171T-->Voeg team toe<!--T1171T--></a>
                <br><br>
            </td>
        </tr>
    </table>
</div>



<div class="popup800" id="newTeams" style="display:none">
    <div class="popup800Close" >
        <img src="../images/close.png"  onClick="javascript:document.getElementById('newTeams').style.display = 'none'">
    </div>
    <table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
        <tr>
            <td align=middle height=30>
                <big><b><font color=white><!--T1172T-->Voeg teams toe<!--T1172T--></font></b></big>
            </td>
        </tr>
    </table>

    <table width=100% border=0 cellspacing='0' cellspacing='0'>
        <tr>
            <td align=center>

                <br>
                <p id="newTeamsList" ></p>
                <br>

                <? printButton2("<!--T1173T-->Voeg toe<!--T1173T-->","javascript:addTeams();")  ?>

                <br><br>
            </td>
        </tr>
    </table>
</div>


            

<script language="JavaScript" type="text/JavaScript">
    ts_loadTeamsDropdown(eval('(' + initalTeams + ')'));
    setCompetitions(eval('('+initialMCompetitionData+')'));
    loadOrganisationData();

    //select the dropdown
    // document.getElementById('selectseason2').value = initialSelectedSeason;

    // enable or disable edit buttons
    checkPermissions();

</script>

<?
}
?>