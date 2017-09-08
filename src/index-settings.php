<?
function printSettings(){
?>

<script src="teamsport-settings.js"></script>


<p id=settingsData>

<table width=100% border=0 cellspacing='0'>

    <tr height=20 id="teamsettingsrow1">
        <td align=left bgcolor=#2e6735><b><font color=white id="teamheader"></font></b>
        </td>
        <td colspan=99 align=right bgcolor=#2e6735>
            <a id="modifyButton1a" class=none>&nbsp;</a>
        </td>
    </tr>            
    <tr height=5  id="teamsettingsrow2"><td colspan=99 ></td></tr>            

    <tr  id="teamsettingsrow3">
        <td colspan=99 valign=top align=left>

            <table cellspacing='0'>
                <tr>
                    <td><b><!--T1242T-->Teamnaam<!--T1242T--></b></td>
                    <td width=10></td>
                    <td><b>:</b></td>
                    <td width=10></td>
                    <td>
                        <p id="teamname"></p> 
                    </td>
                </tr>
                <tr>
                    <td><b><!--T1243T-->Sport<!--T1243T--></b></td>
                    <td width=10></td>
                    <td><b>:</b></td>
                    <td width=10></td>
                    <td>
                        <p id="sport"></p> 
                    </td>
                </tr>
                <tr>
                    <td><b><!--T1244T-->Vereniging <!--T1244T--></b></td>
                    <td width=10></td>
                    <td><b>:</b></td>
                    <td width=10></td>
                    <td>
                        <p id="vereniging"></p> 
                    </td>
                </tr>
                <tr>
                    <td><b><!--T1245T-->Voorkeurs aantal aanwezigen<!--T1245T--></b></td>
                    <td width=10></td>
                    <td><b>:</b></td>
                    <td width=10></td>
                    <td>
                        <p id="voorkeur"></p> 
                    </td>
                </tr>
                <tr>
                    <td><b><!--T1246T-->Stuur email bij teveel afwezigen<!--T1246T--></b></td>
                    <td width=10></td>
                    <td><b>:</b></td>
                    <td width=10></td>
                    <td>
                        <p id="tekort"></p> 
                    </td>
                </tr>
                <tr>
                    <td><b><!--T1247T-->Stuur waarschuwing bij tekort teamleden<!--T1247T--></b></td>
                    <td width=10></td>
                    <td><b>:</b></td>
                    <td width=10></td>
                    <td>
                        <p id="waarschuwing"></p> 
                    </td>
                </tr>
                <tr>
                    <td><b><!--T1248T-->Stuur herinnering bij niet ingevuld<!--T1248T--></b></td>
                    <td width=10></td>
                    <td><b>:</b></td>
                    <td width=10></td>
                    <td>
                        <p id="reminder"></p> 
                    </td>
                </tr>
            </table>

            <br>
        </td>
    </tr>
    

    <tr height=20 id="myteamssettingsrow1">
        <td align=left bgcolor=#2e6735><b><font color=white>&nbsp;<!--T1249T-->Mijn teams instellingen<!--T1249T--></font></b>
        </td>
        <td colspan=99 align=right bgcolor=#2e6735>
            <a id="modifyButton2a" class=none>&nbsp;</a>
        </td>
    </tr>            
    <tr height=5  id="myteamssettingsrow2"><td colspan=99 ></td></tr>            

    <tr  id="myteamssettingsrow3">
        <td colspan=99 valign=top align=left>
            <p id="myTeamsData"></p>
            <br>
            <? printButton2("<!--T1250T-->Richt nieuw team op<!--T1250T-->","javascript:ts_openNewTeam();")  ?>
            <br>
            
        </td>
    </tr>	


    <tr height=20>
        <td align=left bgcolor=#2e6735><b><font color=white>&nbsp;<!--T1251T-->Gebruikers instellingen<!--T1251T--></font></b>
        </td>
        <td colspan=99 align=right bgcolor=#2e6735>
            <a id="modifyButton3a" class=none>&nbsp;</a>
        </td>
    </tr>            
    <tr height=5><td colspan=99 ></td></tr>            

    <tr>
        <td colspan=99 valign=top align=left>

            <table cellspacing='0' border=0>
                <tr>
                    <td><b><!--T1252T-->Gebruikersnaam<!--T1252T--></b></td>
                    <td width=10></td>
                    <td><b>:</b></td>
                    <td width=10></td>
                    <td>
                        <p id="username"></p> 
                    </td>
                </tr>
                <tr>
                    <td><b><!--T1253T-->Naam<!--T1253T--></b></td>
                    <td width=10></td>
                    <td><b>:</b></td>
                    <td width=10></td>
                    <td>
                        <p id="name"></p> 
                    </td>
                </tr>
                <tr>
                    <td><b><!--T1254T-->Email<!--T1254T--></b></td>
                    <td width=10></td>
                    <td><b>:</b></td>
                    <td width=10></td>
                    <td>
                        <p id="email"></p> 
                    </td>
                </tr>
                <tr>
                    <td><b><!--T1255T-->Telefoonnummer<!--T1255T--></b></td>
                    <td width=10></td>
                    <td><b>:</b></td>
                    <td width=10></td>
                    <td>
                        <p id="phonenr"></p> 
                    </td>
                </tr>
                <tr>
                    <td colspan=99 align="center">
                    <br>
                    <? printButton2("<!--T1256T-->verander wachtwoord<!--T1256T-->","javascript:document.getElementById('changePW').style.display = '';")  ?>
                    <br>
                    </td>
                </tr>
            	
            	
            	
            </table>
        </td>
    </tr>
    

    <tr height=20>
        <td align=left bgcolor=#2e6735><b><font color=white>&nbsp;<!--TT-->Google Agenda Integratie<!--TT--></font></b>
        </td>
        <td colspan=99 align=right bgcolor=#2e6735>
            <a id="modifyButton3a" class=none>&nbsp;</a>
        </td>
    </tr>            
    <tr height=5><td colspan=99 ></td></tr>            

    <tr>
        <td colspan=99 valign=top align=left>

            <table cellspacing='0' border=0>
                
                <tr>
                    <td colspan=99 align="center">
                    <br>
                    <? printButton2("<!--TT-->Voeg wedstrijden toe<!--TT-->","javascript:popupWindow = window.open('agenda-add.php','popUpWindow','height=500,width=550,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes')")  ?>
                    <br>
                    <? printButton2("<!--TT-->Verwijder wedstrijden<!--TT-->","javascript:popupWindow = window.open('agenda-remove.php','popUpWindow','height=500,width=550,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes')")  ?>
                    
                        

                    </td>
                </tr>
                
                
                
            </table>
        </td>
    </tr>    
    
</table>

</p>

<p id=textForAnonimousTeam>
<!-- Deze text is alleen zichtbaar als het een anonieme team is! -->

<table width=100% border=0 cellspacing='0'>

    <tr height=20>
        <td align=left bgcolor=#2e6735><b><font color=white>&nbsp;<!--T1257T-->Lijsten<!--T1257T--></font></b>
        </td>
        <td colspan=99 align=right bgcolor=#2e6735>
        </td>
    </tr>            
    <tr height=5><td colspan=99 ></td></tr>            
        <td colspan=99 valign=top align=left width=140>
            <!--T1258T-->Deze informatie is alleen beschikbaar als je lid bent van dit team.<br><br>
            <a href=# onClick="openConnectTeam()" class="none2"> Is dit jouw team, klik dan hier</a>
            <br><!--T1258T-->
        </td>
    </tr>
    
</table>


</p>


<img src="../images/edit.png" height=35 id="modifyButton1b" onclick='document.getElementById("editTeam").style.display = "";' style="cursor: pointer;">    
<img src="../images/edit.png" height=35 id="modifyButton2b" onclick='document.getElementById("editTeammembers").style.display = "";' style="cursor: pointer;">    
<img src="../images/edit.png" height=35 id="modifyButton3b" onclick='document.getElementById("editUser").style.display = "";' style="cursor: pointer;">    



<!--  EDIT TEAM --->

<div class="popup600" id="editTeam" style="display:none">    
<div class="popup600Close" >
    <img src="../images/close.png"  onClick="javascript:document.getElementById('editTeam').style.display = 'none'">
</div>        

<table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
    <tr>
        <td align=middle height=30>
            <big><b><font color=white><!--T1259T-->Bewerk team gegevens<!--T1259T--></font></b></big>
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
<!-- -->            
                        <table cellspacing='0'>
                            <tr>
                                <td><b><!--T1260T-->Teamnaam<!--T1260T--></b></td>
                                <td width=10></td>
                                <td><b>:</b></td>
                                <td width=10></td>
                                <td>
                                    <input id = "teamnameEdit" type="text" class="gameEditFields"/>
                                </td>
                            </tr>
                            <tr>
                                <td><b><!--T1261T-->Sport<!--T1261T--></b></td>
                                <td width=10></td>
                                <td><b>:</b></td>
                                <td width=10></td>
                                <td>
                                    <input id = "sportEdit" type="text" class="gameEditFields"/>
                                </td>
                            </tr>
                            <tr>
                                <td><b><!--T1262T-->Vereniging<!--T1262T--> </b></td>
                                <td width=10></td>
                                <td><b>:</b></td>
                                <td width=10></td>
                                <td>
                                    <input id = "verenigingEdit" type="text" class="gameEditFields"/>
                                </td>
                            </tr>
                            <tr>
                                <td><b><!--T1263T-->Voorkeurs aantal aanwezigen<!--T1263T--></b></td>
                                <td width=10></td>
                                <td><b>:</b></td>
                                <td width=10></td>
                                <td>
                                    <input id = "voorkeurEdit" type="text" class="gameEditFields"/>
                                </td>
                            </tr>
                            <tr height=10>
                                <td> 
                                </td>
                            </tr>                            
                            <tr>
                                <td><b><!--T1264T-->Stuur email bij teveel afwezigen<!--T1264T--></b></td>
                                <td width=10></td>
                                <td><b>:</b></td>
                                <td width=10></td>
                                <td>
                                    <input type="radio" id = "tekortToEdit0" name="tekortToEdit" value="0" > <!--T1265T-->Nee<!--T1265T-->&nbsp;&nbsp;
                                    <input type="radio" id = "tekortToEdit1" name="tekortToEdit" value="1" > <!--T1266T-->Naar admin<!--T1266T-->&nbsp;&nbsp;
                                    <input type="radio" id = "tekortToEdit2" name="tekortToEdit" value="2" > <!--T1267T-->Naar iedereen<!--T1267T-->                                    
                                    
                                </td>
                            </tr>
                            <tr height=10>
                                <td> 
                                </td>
                            </tr>                            

                            <tr>
                                <td><b><!--T1268T-->Stuur waarschuwing bij tekort teamleden<!--T1268T--></b></td>
                                <td width=10></td>
                                <td><b>:</b></td>
                                <td width=10></td>
                                <td>
                                    <input type="radio" id = "waarschuwingToEdit0" name="waarschuwingToEdit" value="0" onClick="javascript:document.getElementById('rowWarningEdit').style.display = 'none'"> <!--T1269T-->Nee<!--T1269T-->&nbsp;&nbsp;
                                    <input type="radio" id = "waarschuwingToEdit1" name="waarschuwingToEdit" value="1" onClick="javascript:document.getElementById('rowWarningEdit').style.display = ''"> <!--T1270T-->Naar admin<!--T1270T-->&nbsp;&nbsp;
                                    <input type="radio" id = "waarschuwingToEdit2" name="waarschuwingToEdit" value="2" onClick="javascript:document.getElementById('rowWarningEdit').style.display = ''"> <!--T1271T-->Naar iedereen<!--T1271T-->                                    
                                </td>
                            </tr>
                            <tr id="rowWarningEdit">
                                <td><b>&nbsp;&nbsp;&nbsp;<!--T1272T-->- Hoe lang van te voren<!--T1272T--></b></td>
                                <td width=10></td>
                                <td><b>:</b></td>
                                <td width=10></td>
                                <td>
                                    <input id = "waarschuwingDaysEdit" type="text" class="gameEditFields50"/> dagen
                                </td>
                            </tr>
                            
                            <tr>
                                <td><b><!--T1273T-->Stuur herinnering bij niet ingevuld<!--T1273T--></b></td>
                                <td width=10></td>
                                <td><b>:</b></td>
                                <td width=10></td>
                                <td>
                                    <input type="radio" id = "reminderEdit0" name="reminderEdit" value="0" onClick="javascript:reminderChangeClick()"> <!--T1274T-->Nee<!--T1274T-->&nbsp;&nbsp;
                                    <input type="radio" id = "reminderEdit1" name="reminderEdit" value="1" onClick="javascript:reminderChangeClick()"> <!--T1275T-->Ja<!--T1275T-->
                                </td>
                            </tr>
                            <tr id=rowReminderEdit>
                                <td><b>&nbsp;&nbsp;&nbsp;<!--T1276T-->- Hoe lang van te voren<!--T1276T--></b></td>
                                <td width=10></td>
                                <td><b>:</b></td>
                                <td width=10></td>
                                <td>
                                    <input id = "reminderDaysEdit" type="text" class="gameEditFields50"/> dagen
                                </td>
                            </tr>
                            <tr height=10>
                                <td> 
                                </td>
                            </tr>                            
                            <tr>
                                <td valign=top colspan=100 align=center>
                                    <br>
                                    <? printButton2("<!--T1277T-->aanpassingen opslaan<!--T1277T-->","javascript:saveTeam();")  ?>
                                    <br>
                                    <br>
                                </td>
                            </tr>
                        </table>
<!-- -->                        
                    </td>
                </tr>
            </table>
            <br><br>                    
        </td>
    </tr>
</table>
</div>    

<!--  EDIT TEAM MEMBERS --->

<div class="popup600" id="editTeammembers" style="display:none">    
<div class="popup600Close" >
    <img src="../images/close.png"  onClick="javascript:document.getElementById('editTeammembers').style.display = 'none'">
</div>        

<table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
    <tr>
        <td align=middle height=30>
            <big><b><font color=white><!--T1278T-->Bewerk mijn teams<!--T1278T--></font></b></big>
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
<!-- -->                        
                        <p id="myTeamsDataEdit"></p>
                        <table>
                                <tr>
                                    <td valign=top colspan=100 align=center>
                                        <br>
                                        <? printButton2("<!--T1279T-->aanpassingen opslaan<!--T1279T-->","javascript:saveTeamUsersData();")  ?>
                                        <br>
                                        <br>
                                    </td>
                                </tr>
                        </table>
<!-- -->                        
                    </td>
                </tr>
            </table>
            <br><br>                    
        </td>
    </tr>
</table>
</div>    

<!--  EDIT USER --->

<div class="popup600" id="editUser" style="display:none">    
<div class="popup600Close" >
    <img src="../images/close.png"  onClick="javascript:document.getElementById('editUser').style.display = 'none'">
</div>        

<table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
    <tr>
        <td align=middle height=30>
            <big><b><font color=white><!--T1280T-->Bewerk gebruiker gegevens<!--T1280T--></font></b></big>
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
<!-- -->
                        <table cellspacing='0' border=0>
                            <tr>
                                <td><b><!--T1281T-->Gebruikersnaam<!--T1281T--></b></td>
                                <td width=10></td>
                                <td><b>:</b></td>
                                <td width=10></td>
                                <td>
                                    <p id="usernameEdit"></p> 
                                </td>
                            </tr>
                            <tr>
                                <td><b><!--T1282T-->Naam<!--T1282T--></b></td>
                                <td width=10></td>
                                <td><b>:</b></td>
                                <td width=10></td>
                                <td>
                                    <input id = "nameEdit" type="text" class="gameEditFields"/> dagen
                                </td>
                            </tr>
                            <tr>
                                <td><b><!--T1283T-->Email<!--T1283T--></b></td>
                                <td width=10></td>
                                <td><b>:</b></td>
                                <td width=10></td>
                                <td>
                                    <input id = "emailEdit" type="text" class="gameEditFields"/> dagen
                                </td>
                            </tr>
                            <tr>
                                <td><b><!--T1284T-->Telefoonnummer<!--T1284T--></b></td>
                                <td width=10></td>
                                <td><b>:</b></td>
                                <td width=10></td>
                                <td>
                                    <input id = "phonenrEdit" type="text" class="gameEditFields"/> dagen
                                </td>
                            </tr>
                            
                            <tr>
                                <td valign=top colspan=100 align=center>
                                    <br>
                                    <? printButton2("<!--T1285T-->aanpassingen opslaan<!--T1285T-->","javascript:saveUser();")  ?>
                                    <br>
                                    <br>
                                </td>
                            </tr>
                            
                            
                        </table>
                        
<!-- -->                        
                    </td>
                </tr>
            </table>
            <br><br>                    
        </td>
    </tr>
</table>
</div>    



<!--  CHANGE PASSWD --->

<div class="popup600" id="changePW" style="display:none">    
<div class="popup600Close" >
    <img src="../images/close.png"  onClick="javascript:document.getElementById('changePW').style.display = 'none'">
</div>        

<table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
    <tr>
        <td align=middle height=30>
            <big><b><font color=white><!--T1286T-->Verander wachtwoord<!--T1286T--></font></b></big>
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
<!-- -->
                        <table cellspacing='0' border=0>
                            <tr>
                                <td><b><!--T1287T-->Oud wachtwoord<!--T1287T--></b></td>
                                <td width=10></td>
                                <td><b>:</b></td>
                                <td width=10></td>
                                <td>
                                    <input id = "oldPW" type="password" /> 
                                </td>
                            </tr>
                            <tr>
                                <td><b><!--T1288T-->Nieuw wachtwoord<!--T1288T--></b></td>
                                <td width=10></td>
                                <td><b>:</b></td>
                                <td width=10></td>
                                <td>
                                    <input id = "newPW1" type="password" />
                                </td>
                            </tr>
                            <tr>
                                <td><b><!--T1289T-->Nogmaals nieuw wachtwoord<!--T1289T--></b></td>
                                <td width=10></td>
                                <td><b>:</b></td>
                                <td width=10></td>
                                <td>
                                    <input id = "newPW2" type="password" />
                                </td>
                            </tr>

                            <tr>
                                <td valign=top colspan=100 align=center>
                                    <br>
                                    <? printButton2("<!--T1290T-->verander wachtwoord<!--T1290T-->","javascript:changePW();")  ?>
                                    <br>
                                    <br>
                                </td>
                            </tr>
                            
                            
                        </table>
                        
<!-- -->                        
                    </td>
                </tr>
            </table>
            <br><br>                    
        </td>
    </tr>
</table>
</div>    


<script language="JavaScript" type="text/JavaScript">

<?
if (globals\getCurrentTeamID()==-1){
?>
    document.getElementById('teamsettingsrow1').style.display = 'none';
    document.getElementById('teamsettingsrow2').style.display = 'none';
    document.getElementById('teamsettingsrow3').style.display = 'none';
<?
}
?>

    ts_loadTeamsDropdown(eval('(' + initalTeams + ')'));
    loadTeamData(eval('(' + initialSelectedTeamData + ')'));
    loadUserData(eval('(' + currentUserData + ')'));
    loadTeamUsersData(eval('(' + teammembersOfThisUser + ')'));
    loadEditButtons();
    // enable or disable edit buttons
    checkPermissions();
    


<?
if (globals\getCurrentTeamID()==-1){
?>
    document.getElementById('modifyButton1b').style.display = 'none';
    document.getElementById('modifyButton2b').style.display = 'none';
<?
}
?>

    
</script>

<?
}
?>
