<?
function printReports(){


?>
<script src="teamsport-report.js"></script>



<p id=reportData>

<table width=100% border=0 cellspacing='0'>

    <tr height=20>
        <td align=left bgcolor=#2e6735><b><font color=white><!--T1220T-->&nbsp;Lijsten<!--T1220T--></font></b>
        </td>
        <td colspan=99 align=right bgcolor=#2e6735>
            <a id="modifyButton1a" class=none>&nbsp;</a>
        </td>
    </tr>            
    <tr height=5><td colspan=99 ></td></tr>            

    <tr>
        <td colspan=99 valign=top align=left width=140>
            <table  cellspacing='0'><tr><td><!--T1221T-->Selecteer&nbsp;een&nbsp;lijst:<!--T1221T--></td>
            <td>&nbsp;&nbsp;</td>    
            <td id=listButtons></td>
            </tr>
            <tr><td><!--T1222T-->Selecteer&nbsp;een&nbsp;Competitie:<!--T1222T--></td>
                <td>&nbsp;&nbsp;</td>    
                <td><select id= "selectcompetition2" class="selectCompetitionDropdown" onchange="javascript:competitionSelect();"></select></td>
                </tr>    
            </table>
            <br>
        </td>
    </tr>
    <tr height=20>
        <td align=left bgcolor=#2e6735><b><font color=white id="listTitle"><!--T1223T-->&nbsp;Lijsten<!--T1223T--></font></b>
        </td>
        <td colspan=99 align=right bgcolor=#2e6735>
            <a id="modifyButton2a" class=none>&nbsp;</a>
        </td>
    </tr>            
    <tr height=5><td colspan=99 ></td></tr>            
        <td colspan=99 valign=top align=left width=140>
            <p id=listData></p>
            <br>
        </td>
    </tr>
    
</table>
</p>

<p id=textForAnonimousTeam>
<!-- Deze text is alleen zichtbaar als het een anonieme team is! -->

<table width=100% border=0 cellspacing='0'>

    <tr height=20>
        <td align=left bgcolor=#2e6735><b><font color=white><!--T1224T-->&nbsp;Lijsten<!--T1224T--></font></b>
        </td>
        <td colspan=99 align=right bgcolor=#2e6735>
        </td>
    </tr>            
    <tr height=5><td colspan=99 ></td></tr>            
        <td colspan=99 valign=top align=left width=140>
            <!--T1225T-->Deze informatie is alleen beschikbaar als je lid bent van dit team.<br><br>
            <a href=# onClick="openConnectTeam()" class="none2"> Is dit jouw team, klik dan hier</a>
            <br><!--T1225T-->
        </td>
    </tr>
    
</table>


</p>


<br>
<p id="tip">    
<b><!--T1226T-->Tip: druk op het edit icoontje van het programma om nieuwe lijsten aan te maken, of de data aan te passen...<!--T1226T--></b>
</p>

<br><br>
    
<img src="../images/edit.png" height=35 id="modifyButton1b" onclick='javascript:document.getElementById("editList").style.display = ""' style="cursor: pointer;">    
<img src="../images/edit.png" height=35 id="modifyButton2b" onclick='document.getElementById("editReport").style.display = "";' style="cursor: pointer;">    





<!--  EDIT UITSLAGEN --->

<div class="popup1000" id="editReport" style="display:none">    
<div class="popup1000Close" >
    <img src="../images/close.png"  onClick="javascript:document.getElementById('editReport').style.display = 'none'">
</div>        

<table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
    <tr>
        <td align=middle height=30>
            <big><b><font color=white><!--T1227T-->Bewerk lijst gegevens<!--T1227T--></font></b></big>
        </td>
    </tr>
</table>    
<br>
<table width=100% border=0 cellspacing='0'>
    <tr>
        <td align=middle>
            <table width=100% border=0 cellspacing='0'>
                <tr>
                    <td colspan=99 valign=top align=center>
                        <p id=listEditData></p>
                        <br>
                        <table cellspacing='0' cellspacing='0'>
                            <tr>
                                <td>
                                    <? printButton2("<!--T1228T-->aanpassingen opslaan<!--T1228T-->","javascript:saveListData();")  ?>
                                </td>
                            </tr>
                        </table>
                        
                        
                    </td>
                </tr>
            </table>
            <br><br>                    
        </td>
    </tr>
</table>
</div>    
              



<div class="popup400" id="editList" style="display:none">
    <div class="popup400Close" >
        <img src="../images/close.png"  onClick="javascript:document.getElementById('editList').style.display = 'none'">
    </div>        
    <table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
        <tr>
            <td align=middle height=30>
                <big><b><font color=white><!--T1229T-->Bewerk lijsten<!--T1229T--></font></b></big>
            </td>
        </tr>
    </table>

    <table width=100% border=0 cellspacing='0'>
        <tr>
            <td align=center>
            <br>
            <p id='lists'></p>
            <br>
            <br>
            <a href="#" onclick="javascript:saveLists();"><!--T1230T-->Sla veranderingen op<!--T1230T--></a>
            &nbsp;&nbsp;
            <a href="#" onclick="javascript:addLijst();"><!--T1231T-->Voeg lijst toe<!--T1231T--></a>
            </td>
        </tr>
    </table>
    <br><br>                        
</div>


<div class="popup400" id="newList" style="display:none">
    <div class="popup400Close" >
        <img src="../images/close.png"  onClick="javascript:document.getElementById('newList').style.display = 'none'">
    </div>        
    <table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
        <tr>
            <td align=middle height=30>
                <big><b><font color=white><!--T1232T-->Nieuwe lijst definieren<!--T1232T--></font></b></big>
            </td>
        </tr>
    </table>

    <table width=100% border=0 cellspacing='0'>
        <tr>
            <td align=center>
                <br>
                <br>
                <table cellspacing='0'>
                <tr>
                <td><b><!--T1233T-->Lijstnaam<!--T1233T--></b></td>
                <td><b>&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;</b></td>
                <td>
                <input id="newListName"  class='gameEditFields' type="text" />
                </td>
                </tr>
            
                <tr>
                <td><b><!--T1234T-->Lijsttype<!--T1234T--></b></td>
                <td><b>&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;</b></td>
                <td>
                <input type="radio" id="newListType_0" name="newListType" value="0"> <!--T1235T-->Getallenlijst<!--T1235T-->&nbsp;&nbsp;&nbsp;
                <input type="radio" id="newListType_1" name="newListType" value="1"> <!--T1236T-->Geldlijst<!--T1236T-->&nbsp;&nbsp;&nbsp;     
                <input type="radio" id="newListType_2" name="newListType" value="2" checked> <!--T1237T-->Aanvinklijst<!--T1237T-->&nbsp;&nbsp;&nbsp;     
                </td>
                </tr>
                </table>
                <br><br>
                <a href="#" onclick="javascript:addLijst2()">Voeg toe</a>
            </td>
        </tr>
    </table>
    <br><br>
</div>



<script language="JavaScript" type="text/JavaScript">
    ts_loadTeamsDropdown(eval('(' + initalTeams + ')'));
    loadCompetitionsData(eval('('+initialCompetitions+')'),true);
    loadReportButtons(eval('(' + initialSelectedTeam + ')'));
    loadListsOverview(eval('(' + initialSelectedTeam + ')')); 
    loadListDataHandler(eval('('+initialListData+')'));
    // enable or disable edit buttons
    checkPermissions();
</script>

<?
}
?>
