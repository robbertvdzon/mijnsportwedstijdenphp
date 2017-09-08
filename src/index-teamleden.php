<?
function printTeamleden(){
?>
<script src="teamsport-teamleden.js"></script>


        <table width=100% border=0 cellspacing='0'>

            <tr height=20>
                <td align=left bgcolor=#2e6735><b><font color=white>&nbsp;<!--T1291T-->Teamleden<!--T1291T--></font></b>
                </td>
                <td colspan=99 align=right bgcolor=#2e6735>
                    <a id="modifyButton1a" class=none>&nbsp;</a>
                </td>
            </tr>            
            <tr height=5><td colspan=99 ></td></tr>            

            <tr>
                <td colspan=99 valign=top align=left >
                    <p id=teammembers></p>
                    <p id=textForAnonimousTeam>
                        <!-- Deze text is alleen zichtbaar als het een anonieme team is! -->
                        <!--T1292T-->Deze informatie is alleen beschikbaar als je lid bent van dit team.<!--T1292T--><br><br>
                        <a href=# onClick="openConnectTeam()" class="none2"> <!--T1293T-->Is dit jouw team, klik dan hier<!--T1293T--></a>
                    </p>
                    <br>
                </td>
            </tr>
            
        </table>
<br>
<p id="tip">    
<b><!--T1294T-->Tip: druk op het edit icoontje van het programma om teamleden aan te passen of nieuwe teamleden uit te nodigen...<!--T1294T--></b>
</p>
<br><br>
<img src="../images/edit.png" height=35 id="modifyButton1b" onclick='document.getElementById("editTeammembers").style.display = "";' style="cursor: pointer;">    





<!--  EDIT  --->

<div class="popup800" id="editTeammembers" style="display:none">    
<div class="popup800Close" >
    <img src="../images/close.png"  onClick="javascript:document.getElementById('editTeammembers').style.display = 'none'">
</div>        

<table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
    <tr>
        <td align=middle height=30>
            <big><b><font color=white><!--T1295T-->Bewerk teamleden<!--T1295T--></font></b></big>
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
                        <p id="teammembersEditList" ></p>
                        <br>
                        <table cellspacing='0' cellspacing='0'>
                            <tr>
                                <td>
                                    <? printButton2("<!--T1296T-->aanpassingen opslaan<!--T1296T-->","javascript:saveChanges();")  ?>
                                </td>
                                <td>
                                    &nbsp;&nbsp;
                                </td>
                                <td>
                                    <? printButton2("<!--T1297T-->nodig teamleden uit<!--T1297T-->","javascript:openInvitation();")  ?>
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
              




<div class="popup400" id="inviteUsers" style="display:none">
    <div class="popup400Close" >
        <img src="../images/close.png"  onClick="javascript:document.getElementById('inviteUsers').style.display = 'none'">
    </div>        
    <table width=100% border=0 bgcolor=#263f24>
        <tr>
            <td align=middle height=30>
                <big><b><font color=white><!--T1298T-->Teamleden uitnodigingen<!--T1298T--></font></b></big>
            </td>
        </tr>
    </table>

    <table width=100% border=0 cellspacing='0'>
        <tr>
            <td align=center>

			<br>
			<br>
			<table width=200 border=0 cellspacing='0'>
			    <table cellspacing='0'>
    				<tr>
    					<td><b><!--T1299T-->Bijnaam<!--T1299T--></b></td>
    					<td width=20></td>
    					<td><b><!--T1300T-->Email adres<!--T1300T--></b></td>
    				</tr>
<?

for ($i=1;$i<=15;$i++){

?>                    
    				
    				<tr>
    					<td>
    					<input id="name_<? echo $i ?>" type="text" />
    					</td>
    					<td></td>
    					<td>
    					<input id="email_<? echo $i ?>" type="text" />
    					</td>
    				</tr>

<?

}

?>                    

    			</table>
              <br>   		  
    			<a href="#" onclick="javascript:sendInvitation()"><!--T1301T-->Verstuur uitnodigingen<!--T1301T--></a>
              <br>
              <br>
              <!--T1302T-->Door het invullen van het email adres wordt direct een uitnodiging gestuurd naar deze speler. Dit is echter niet verplicht, dan wordt de speler wel aangemaakt maar kan niet inloggen. Later kan een speler altijd alsnog uitgenodigd worden.<!--T1302T--> 
              <br>
    			
            </td>
            </tr>
	</table>
	<br><br>
</div>


<div class="popup400" id="changeNickname" style="display:none">
    <div class="popup400Close" >
        <img src="../images/close.png"  onClick="javascript:document.getElementById('changeNickname').style.display = 'none'">
    </div>        
    <table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
        <tr>
            <td align=middle height=30>
                <big><b><font color=white><!--T1303T-->Verander bijnaam<!--T1303T--></font></b></big>
            </td>
        </tr>
    </table>

    <table width=100% border=0 cellspacing='0'>
        <tr>
            <td align=center>

                <br>
                <br>
                <table border=0 cellspacing='0'>
                    <tr>
                        <td><b><!--T1304T-->Nieuwe bijnaam<!--T1304T--></b></td>
                        <td width=20>&nbsp;:&nbsp;</td>
                        <td><input id="newNickname" type="text" /></td>
                    </tr>
    
                </table>
                <br>
                <a href="#" onclick="javascript:changeNickname()"><!--T1305T-->Verander bijnaam<!--T1305T--></a>
                </td>
            </tr>
        </table>
        <br><br>
</div>



<div class="popup400" id="reInviteUsers" style="display:none">
    <div class="popup400Close" >
        <img src="../images/close.png"  onClick="javascript:document.getElementById('reInviteUsers').style.display = 'none'">
    </div>        
    <table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
        <tr>
            <td align=middle height=30>
                <big><b><font color=white><!--T1306T-->Opnieuw uitnodigingen<!--T1306T--></font></b></big>
            </td>
        </tr>
    </table>

    <table width=100% border=0 cellspacing='0'>
        <tr>
            <td align=center>
            <br>
            <table width=300 border=0 cellspacing='0'>
                <tr>
                    <td><b>Bijnaam</b></td>
                    <td width=20></td>
                    <td>
                    <input id="reInviteNickname" type="text" />
                    <input id="reInviteMemberID" type="hidden" />
                    </td>
                </tr>
                <tr>
                    <td><b>Email adres</b></td>
                    <td width=20></td>
                    <td>
                    <input id="reInviteEmail" type="text" />
                    </td>
                </tr>
            </table>
            <br>
            <a href="#" onclick="javascript:reInviteTeammember()"><!--T1307T-->Verstuur uitnodiging<!--T1307T--></a>
            </td>
        </tr>
    </table>
    <br><br>
</div>


<script language="JavaScript" type="text/JavaScript">
    ts_loadTeamsDropdown(eval('(' + initalTeams + ')'));
    loadTeammembersData(eval('(' + initialTeammembers + ')'), true);
    // enable or disable edit buttons
    checkPermissions();
    
</script>


<?
}
?>
