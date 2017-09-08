<?
function printTeamWedstrijd(){
?>

<script src="teamsport-wedstrijd.js"></script>

  <input type="hidden" name= "selectwedstrijd" id= "selectwedstrijd" >
  <table cellspacing='0'>
      <tr>
          <td width=610>
          <p id="selectwedstrijd2"></p>
          </td>
          <td width=10>
          </td>
          <td>
          <img src='images/prev.gif' onclick='javascript:prevGame();' style="cursor: pointer;" height=42>
          <img src='images/browse.gif' onclick='javascript:document.getElementById("selectGameList").style.display = "";' style="cursor: pointer;" height=42>
          <img src='images/next.gif' onclick='javascript:nextGame();' style="cursor: pointer;" height=42>
          
          </td>
      </tr>
  </table>

<p id="siteDataEnabled">
  
<br>
<img id='presenceJa' src='images/ikbenerbij.png' onclick='javascript:setPrecenseYes();' width=249px height=59px style="cursor: pointer;">
<img id='presenceNee' src='images/ikbenernietbij.png' onclick='javascript:setPrecenseNo();' width=249px  height=59px style="cursor: pointer;">
<img id='presenceWeetNiet' src='images/ikweethetnogniet.png' onclick='javascript:setPrecenseUnknown();' width=249px  height=59px style="cursor: pointer;">


<br><br>
<table width=100% border=0 cellspacing='0'>

    <tr>
        <td valign=top>
            
        <p id="selectedGameData">
            



        <table width=500 border=0 cellspacing='0'>

            <tr height=20>
                <td align=left bgcolor=#2e6735><b><font color=white>&nbsp;<!--T1323T-->Wedstrijd gegevens<!--T1323T--></font></b>
                </td>
                <td colspan=99 align=right bgcolor=#2e6735>
                    <a id="modifyButton1a" class=none>&nbsp;</a>
                </td>
            </tr>            
            <tr height=5><td colspan=99 ></td></tr>            

            <tr>
                <td valign=top width=140><!--T1324T-->Datum<!--T1324T--></td>
                <td valign=top align=center width=10>:</td>
                <td valign=top>
                <p id="gameDate2"></p>              
                </td>
            </tr>
            <tr>
                <td valign=top><!--T1325T-->Tijd<!--T1325T--></td>
                <td valign=top align=center>:</td>
                <td valign=top>
                <p id="gameTime2"></p>              
                </td>
            </tr>
            <tr>
                <td valign=top><!--T1326T-->Tegenstander<!--T1326T--></td>
                <td valign=top align=center>:</td>
                <td valign=top>
                <p id="opponent2"></p>              
                </td>
            </tr>
            <tr>
                <td valign=top><!--T1327T-->Uit/Thuis<!--T1327T--></td>
                <td valign=top align=center>:</td>
                <td valign=top>
                <p id="homegame2"></p>              
                </td>
            </tr>
            <tr>
                <td valign=top><!--T1328T-->Verzamelplek<!--T1328T--></td>
                <td valign=top align=center>:</td>
                <td valign=top>
                <p id="meetingpoint2"></p>              
                </td>
            </tr>

            <tr height=20>
                <td colspan=99 ></td>
            </tr>
            <tr height=20>
                <td align=left bgcolor=#2e6735><b><font color=white>&nbsp;<!--T1329T-->Eindstand en score<!--T1329T--></font></b>
                </td>
                <td colspan=99 align=right bgcolor=#2e6735>
                    <a id="modifyButton2a" class=none>&nbsp;</a>
                </td>
            </tr>
            <tr height=5><td colspan=99 ></td></tr>            
            <tr>
                <td valign=top><!--T1330T-->Stand<!--T1330T--></td>
                <td valign=top align=center>:</td>
                <td valign=top>
                <p id="score2"></p>              
                </td>
            </tr>

            <tr>
                <td valign=top><!--T1331T-->Punten<!--T1331T--></td>
                <td valign=top align=center>:</td>
                <td valign=top>
                <p id="points2"></p>              
                </td>
            </tr>
            
            
            <tr>
                <td valign=top><p id=goalsName></p></td>
                <td valign=top align=center>:</td>
                <td valign=top>
                <p id="goalsValue"></p>              
                </td>
            </tr>

            <tr height=20>
                <td colspan=99></td>
            </tr>
            <tr height=20>
                <td align=left bgcolor=#2e6735><b><font color=white>&nbsp;<!--T1332T-->Aanwezigheid<!--T1332T--></font></b>
                </td>
                <td colspan=99 align=right bgcolor=#2e6735>
                    <a id="modifyButton3a" class=none>&nbsp;</a>
                </td>
            </tr>
            <tr height=5><td colspan=99 ></td></tr>            
            <tr>
                <td valign=top><p id=aanwezigName></p></td>
                <td valign=top align=center>:</td>
                <td valign=top>
                <p id="aanwezigValue"></p>              
                </td>
            </tr>

            <tr>
                <td valign=top><p id=afwezigName></p></td>
                <td valign=top align=center>:</td>
                <td valign=top>
                <p id="afwezigValue"></p>              
                </td>
            </tr>

            <tr>
                <td valign=top><p id=onbekendName></p></td>
                <td valign=top align=center>:</td>
                <td valign=top>
                <p id="onbekendValue"></p>              
                </td>
            </tr>

            <tr height=20>
                <td colspan=99></td>
            </tr>
            <tr height=20 id=lijstGegevensHeader>
                <td align=left bgcolor=#2e6735><b><font color=white>&nbsp;<!--T1333T-->Lijstgegevens<!--T1333T--></font></b>
                </td>
                <td colspan=99 align=right bgcolor=#2e6735>
                    <a id="modifyButton4a" class=none>&nbsp;</a>
                </td>
            </tr>
            <tr height=5><td colspan=99 ></td></tr>            
            <tr id='list1Row'>
                <td valign=top><p id=list1Name></p></td>
                <td valign=top align=center>:</td>
                <td valign=top>
                <p id="list1Value"></p>              
                </td>
            </tr>

            <tr id='list2Row'>
                <td valign=top><p id=list2Name></p></td>
                <td valign=top align=center>:</td>
                <td valign=top>
                <p id="list2Value"></p>              
                </td>
            </tr>

            <tr id='list3Row'>
                <td valign=top><p id=list3Name></p></td>
                <td valign=top align=center>:</td>
                <td valign=top>
                <p id="list3Value"></p>              
                </td>
            </tr>

            <tr id='list4Row'>
                <td valign=top><p id=list4Name></p></td>
                <td valign=top align=center>:</td>
                <td valign=top>
                <p id="list4Value"></p>              
                </td>
            </tr>

            <tr id='list5Row'>
                <td valign=top><p id=list5Name></p></td>
                <td valign=top align=center>:</td>
                <td valign=top>
                <p id="list5Value"></p>              
                </td>
            </tr>

            <tr id='list6Row'>
                <td valign=top><p id=list6Name></p></td>
                <td valign=top align=center>:</td>
                <td valign=top>
                <p id="list6Value"></p>              
                </td>
            </tr>

            <tr id='list7Row'>
                <td valign=top><p id=list7Name></p></td>
                <td valign=top align=center>:</td>
                <td valign=top>
                <p id="list7Value"></p>              
                </td>
            </tr>

            <tr id='list8Row'>
                <td valign=top><p id=list8Name></p></td>
                <td valign=top align=center>:</td>
                <td valign=top>
                <p id="list8Value"></p>              
                </td>
            </tr>

            <tr id='list9Row'>
                <td valign=top><p id=list9Name></p></td>
                <td valign=top align=center>:</td>
                <td valign=top>
                <p id="list9Value"></p>              
                </td>
            </tr>

            <tr id='list10Row'>
                <td valign=top><p id=list10Name></p></td>
                <td valign=top align=center>:</td>
                <td valign=top>
                <p id="list10Value"></p>              
                </td>
            </tr>


            
        </table>
        <br>
        
        </p>
       
       
       
        <p id="textForAnonimousTeam">
        <table width=500 border=0 cellspacing='0'>

            <tr height=20>
                <td align=left bgcolor=#2e6735><b><font color=white>&nbsp;<!--T1334T-->Wedstrijd gegevens<!--T1334T--></font></b>
                </td>
                <td colspan=99 align=right bgcolor=#2e6735>
                </td>
            </tr>            
            <tr height=5><td colspan=99 ></td></tr>            

            <tr>
                <td valign=top width=140><!--T1335T-->Datum<!--T1335T--></td>
                <td valign=top align=center width=10>:</td>
                <td valign=top>
                <p id="gameDate2Anoniem"></p>              
                </td>
            </tr>
            <tr>
                <td valign=top><!--T1336T-->Tijd<!--T1336T--></td>
                <td valign=top align=center>:</td>
                <td valign=top>
                <p id="gameTime2Anoniem"></p>              
                </td>
            </tr>
            <tr>
                <td valign=top><!--T1337T-->Tegenstander<!--T1337T--></td>
                <td valign=top align=center>:</td>
                <td valign=top>
                <p id="opponent2Anoniem"></p>              
                </td>
            </tr>
            <tr>
                <td valign=top><!--T1338T-->Uit/Thuis<!--T1338T--></td>
                <td valign=top align=center>:</td>
                <td valign=top>
                <p id="homegame2Anoniem"></p>              
                </td>
            </tr>
            <tr>
                <td valign=top><!--T1339T-->Verzamelplek<!--T1339T--></td>
                <td valign=top align=center>:</td>
                <td valign=top>
                <p id="meetingpoint2Anoniem"></p>              
                </td>
            </tr>

            <tr height=20>
                <td colspan=99 ></td>
            </tr>
            <tr height=20>
                <td align=left bgcolor=#2e6735><b><font color=white>&nbsp;<!--T1340T-->Eindstand en score<!--T1340T--></font></b>
                </td>
                <td colspan=99 align=right bgcolor=#2e6735>
                </td>
            </tr>
            <tr height=5><td colspan=99 ></td></tr>            
            <tr>
                <td valign=top><!--T1341T-->Stand<!--T1341T--></td>
                <td valign=top align=center>:</td>
                <td valign=top>
                <p id="score2Anoniem"></p>              
                </td>
            </tr>

            <tr>
                <td valign=top><!--T1342T-->Punten<!--T1342T--></td>
                <td valign=top align=center>:</td>
                <td valign=top>
                <p id="points2Anoniem"></p>              
                </td>
            </tr>

            <tr height=20>
                <td colspan=99></td>
            </tr>
            <tr height=20>
                <td align=left bgcolor=#2e6735><b><font color=white>&nbsp;<!--T1343T-->Aanwezigheid<!--T1343T--></font></b>
                </td>
                <td colspan=99 align=right bgcolor=#2e6735>
                </td>
            </tr>
            <tr >
                <td colspan=99 valign=top align=left >
                    <p id=textForAnonimousTeam>
                        <!-- Deze text is alleen zichtbaar als het een anonieme team is! -->
                        <!--T1344T-->Deze informatie is alleen beschikbaar als je lid bent van dit team.<!--T1344T-->
                    </p>
                </td>
            </tr>

            <tr height=5><td colspan=99 ></td></tr>            
            
            <tr height=20>
                <td colspan=99></td>
            </tr>
            <tr height=20 id=lijstGegevensHeader>
                <td align=left bgcolor=#2e6735><b><font color=white>&nbsp;<!--T1345T-->Lijstgegevens<!--T1345T--></font></b>
                </td>
                <td colspan=99 align=right bgcolor=#2e6735>
                </td>
            </tr>
            <tr height=5><td colspan=99 ></td></tr>            
            <tr >
                <td colspan=99 valign=top align=left >
                    <p id=textForAnonimousTeam>
                        <!-- Deze text is alleen zichtbaar als het een anonieme team is! -->
                        <!--T1346T-->Deze informatie is alleen beschikbaar als je lid bent van dit team.<br><br><!--T1346T-->
                        <a href=# onClick="openConnectTeam()" class="none2"> <!--T1347T-->Is dit jouw team, klik dan hier<!--T1347T--></a>
                    </p>
                    <br>
                </td>
            </tr>

            
        </table>
        <br>
        
        </p>
       
       

        </td>
        
        <td width=240 valign=top>
            <table width=100%  cellspacing='0'>
                <tr height=20>
                    <td align=left bgcolor=#2e6735>
                        <b><font color=white>&nbsp;<!--T1348T-->Berichten<!--T1348T--></font></b>
                    </td>
                    <td align=right bgcolor=#2e6735>
                        <a id="newMessagea" class=none>&nbsp;</a>
                    </td>
                </tr>            
                <tr height=5><td colspan=99 ></td></tr>            
                <tr>
                    <td align=left colspan=2>
                        <p id=gameMessages></p>
                        <p id="textForAnonimousTeamMessages">
                            <!--T1349T-->Het is alleen mogelijk berichten te plaatsen als je lid bent van dit team.<!--T1349T-->
                        </p>

                    </td>
                </tr>
            </table>
            
            
        </td>
        
        
    </tr>
    
    
</table>
<br>

<img id='presenceVink' src='images/vink.png' width=200px style="display:none">
<img src="../images/edit.png" height=35 id="modifyButton1b" onclick='document.getElementById("selectedGameDataEdit1").style.display = "";' style="cursor: pointer;">    
<img src="../images/edit.png" height=35 id="modifyButton2b" onclick='document.getElementById("selectedGameDataEdit2").style.display = "";' style="cursor: pointer;">    
<img src="../images/edit.png" height=35 id="modifyButton3b" onclick='document.getElementById("selectedGameDataEdit3").style.display = "";' style="cursor: pointer;">    
<img src="../images/edit.png" height=35 id="modifyButton4b" onclick='document.getElementById("selectedGameDataEdit4").style.display = "";' style="cursor: pointer;">    
<img src="../images/newmessage.png" height=35 id="newMessageb" onclick='document.getElementById("newMessage").style.display = "";' style="cursor: pointer;">    

</p>

<p id="siteDataEmpty" style="display:none">
    <!--T1350T-->Er zijn nog geen wedstrijden voor deze competitie. <br><!--T1350T-->
    <!--T1351T-->Maak eerst wedstrijden aan via de competitie menu of kies een andere competitie.<!--T1351T-->
</p>

<!--  EDIT 1 --->

        <div class="popup800" id="selectedGameDataEdit1" style="display:none">    
        <div class="popup800Close" >
            <img src="../images/close.png"  onClick="javascript:document.getElementById('selectedGameDataEdit1').style.display = 'none'">
        </div>        

        <table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
            <tr>
                <td align=middle height=30>
                    <big><b><font color=white><!--T1352T-->Bewerk wedstrijd gegevens<!--T1352T--></font></b></big>
                </td>
                
            </tr>
        </table>    
        <br>


        <table width=100% border=0 cellspacing='0'>



            <tr>
                <td align=middle>
                    <table cellspacing='0'>
                    <tr>
                        <td valign=top width=100><b><!--T1353T-->Datum<!--T1353T--></b></td>
                        <td valign=top align=center>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                        <td valign=top>
                        <input id="gameDate" type="text" class="gameEditFields" />              
                            &nbsp;&nbsp;<!--T1354T-->(dd-mm-yyyy)<!--T1354T-->
                        </td>
                    </tr>
                    <tr>
                        <td valign=top><b>Tijd</b></td>
                        <td valign=top align=center>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                        <td valign=top>
                        <input id="gameTime"type="text" class="gameEditFields" />
                        </td>
                    </tr>
                    <tr>
                        <td valign=top><b><!--T1355T-->Tegenstander<!--T1355T--></b></td>
                        <td valign=top align=center>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                        <td valign=top>
                        <input id="opponentTextbox" type="text" class="gameEditFields"/>
                        </td>
                    </tr>
                    <tr>
                        <td valign=top><b><!--T1356T-->Thuiswedstrijd<!--T1356T--></b></td>
                        <td valign=top align=center>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                        <td valign=top>
                        <input id="homegame" type="checkbox" value="true" class="gameCheckbox"/>
                        </td>
                    </tr>
                    <tr>
                        <td valign=top><b><!--T1357T-->Verzamelplek<!--T1357T--></b></td>
                        <td valign=top align=center>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                        <td valign=top>
                        <input id = "meetingpoint" type="text" class="gameEditFields"/>
                        </td>
                    </tr>
                    </table>
                </td>
                
            </tr>
        
        
                    <tr>
                        <td valign=top colspan=100 align=center>
                            <br>
                            <? printButton2("<!--T1358T-->aanpassingen opslaan<!--T1358T-->","javascript:saveGame();")  ?>
                            <br>
                            <br>
                        </td>
                    </tr>
            </td>
            </tr>                   

        </table>
        
        </div>


<!--  EDIT 2 --->
       
        <div class="popup800" id="selectedGameDataEdit2" style="display:none">    
        <div class="popup800Close" >
            <img src="../images/close.png"  onClick="javascript:document.getElementById('selectedGameDataEdit2').style.display = 'none'">
        </div>        

        <table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
            <tr>
                <td align=middle height=30>
                    <big><b><font color=white><!--T1359T-->Bewerk wedstrijd gegevens<!--T1359T--></font></b></big>
                </td>
                
            </tr>
        </table>    
        <br>


        <table width=100% border=0 cellspacing='0'>



            <tr>
                <td align=middle>
                    <table cellspacing='0'>

                    <tr>
                        <td valign=top><b>Score wij</b></td>
                        <td valign=top align=center>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                        <td valign=top>
                        <input id="scoreWij" type="text" class="gameEditFields50"/>
                        </td>
                    </tr>
                        
                    <tr>
                        <td valign=top><b>Score zij</b></td>
                        <td valign=top align=center>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                        <td valign=top>
                        <input id="scoreZij" type="text" class="gameEditFields50"/>
                        </td>
                    </tr>
                        
                    <tr>
                        <td valign=top><b>Punten</b></td>
                        <td valign=top align=center>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                        <td valign=top>
                        <input id="points" type="text" class="gameEditFields"/>
                        </td>
                    </tr>
                        
                    
                    </table>
                </td>
                
            </tr>
        
            <tr>
                <td align=middle>
                    <table cellspacing='0'>
                        
                    <tr>
                        <td valign=top colspan=4>
                            <br>
                                <input id="goals" type="text" class="gameEditFields" style="display:none "/>
                            <div style='overflow:auto;width:750px;' align=center>
                            <p id=listDataGoals></p>
                            </div>
                        </td>
                    </tr>
                                
                    <tr>
                        <td valign=top colspan=100 align=center>
                            <br>
                            <? printButton2("<!--T1360T-->aanpassingen opslaan<!--T1360T-->","javascript:saveGame();")  ?>
                            <br>
                            <br>
                        </td>
                    </tr>
                    </table>
            </td>
            </tr>                   

        </table>
        
        </div>



<!--  EDIT 3 --->
       
        <div class="popup800" id="selectedGameDataEdit3" style="display:none">    
        <div class="popup800Close" >
            <img src="../images/close.png"  onClick="javascript:document.getElementById('selectedGameDataEdit3').style.display = 'none'">
        </div>        

        <table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
            <tr>
                <td align=middle height=30>
                    <big><b><font color=white><!--T1361T-->Bewerk wedstrijd gegevens<!--T1361T--></font></b></big>
                </td>
                
            </tr>
        </table>    
        <br>


        <table width=100% border=0 cellspacing='0'>

        
            <tr>
                <td align=middle>
                    <table cellspacing='0'>
                    <tr>
                        <td valign=top colspan=4>
                            <br>
                                <input id="gamePresentYesField" type="text" class="gameEditFields" style="display:none "/>
                                <input id="gamePresentNoField" type="text" class="gameEditFields" style="display:none "/>
                                <input id="gamePresentUnknownField" type="text" class="gameEditFields" style="display:none "/>
                            <div style='overflow:auto;width:750px;' align=center>
                            <p id=listDataPresent></p>
                            </div>
                        </td>
                    </tr>
        
        
        
                    <tr>
                        <td valign=top colspan=100 align=center>
                            <br>
                            <? printButton2("<!--T1362T-->aanpassingen opslaan<!--T1362T-->","javascript:saveGame();")  ?>
                            <br>
                            <br>
                        </td>
                    </tr>
                    </table>
            </td>
            </tr>                   

        </table>
        
        </div>

<!--  EDIT 4 --->
       
        <div class="popup800" id="selectedGameDataEdit4" style="display:none">    
        <div class="popup800Close" >
            <img src="../images/close.png"  onClick="javascript:document.getElementById('selectedGameDataEdit4').style.display = 'none'">
        </div>        

        <table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
            <tr>
                <td align=middle height=30>
                    <big><b><font color=white><!--T1363T-->Bewerk wedstrijd gegevens<!--T1363T--></font></b></big>
                </td>
                
            </tr>
        </table>    
        <br>


        <table width=100% border=0 cellspacing='0'>
            <tr>
                <td align=middle>
                    <table cellspacing='0'>
                    <tr>
                        <td valign=top colspan=4>
                            <br>
                                <input id="list1" type="text" class="gameEditFields" style="display:none "/>
                                <input id="list2" type="text" class="gameEditFields" style="display:none "/>
                                <input id="list3" type="text" class="gameEditFields" style="display:none "/>
                                <input id="list4" type="text" class="gameEditFields" style="display:none "/>
                                <input id="list5" type="text" class="gameEditFields" style="display:none "/>
                                <input id="list6" type="text" class="gameEditFields" style="display:none "/>
                                <input id="list7" type="text" class="gameEditFields" style="display:none "/>
                                <input id="list8" type="text" class="gameEditFields" style="display:none "/>
                                <input id="list9" type="text" class="gameEditFields" style="display:none "/>
                                <input id="list10" type="text" class="gameEditFields" style="display:none "/>
                            <div style='overflow:auto;width:750px;' align=center>
                            <p id=listData></p>
                            </div>
                        </td>
                    </tr>
        
        
        
                    <tr>
                        <td valign=top colspan=100 align=center>
                            <br>
                            <? printButton2("<!--T1364T-->aanpassingen opslaan<!--T1364T-->","javascript:saveGame();")  ?>
                            <br>
                            <br>
                        </td>
                    </tr>
                    </table>
            </td>
            </tr>                   

        </table>
        
        </div>


<div class="popup800" id="newMessage" style="display:none">    
    <div class="popup800Close" >
        <img src="../images/close.png"  onClick="javascript:document.getElementById('newMessage').style.display = 'none'">
    </div>        
    <table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
        <tr>
            <td align=middle height=30>
                <big><b><font color=white><!--T1365T-->Voeg bericht toe<!--T1365T--></font></b></big>
            </td>
        </tr>
    </table>
    <table width=100% border=0  cellspacing='0'>
        <tr>
            <td align=middle height=30>
                <b>Bericht:</b>
                <br>
                <TEXTAREA id="newMessageData" rows="10" cols="80"></TEXTAREA>
                <br><br>
                <a href=# onclick="javascript:addMessage();"><!--T1366T-->Verstuur<!--T1366T--></a>    
            </td>
        </tr>
    </table>
    <br>
</div>




<div class="popup600" id="selectGameList" style="display:none">
    <div class="popup600Close" >
        <img src="../images/close.png"  onClick="javascript:document.getElementById('selectGameList').style.display = 'none'">
    </div>        
    <table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
        <tr>
            <td align=middle height=30>
                <big><b><font color=white><!--T1367T-->Selecteer een wedstrijd<!--T1367T--></font></b></big>
            </td>
        </tr>
    </table>

    <table width=100% border=0 cellspacing='0'>
        <tr>
            <td align=center>
            <br>
            <select id= "selectcompetition2" class="selectCompetitionDropdown" onchange="javascript:competitionSelect();"></select>
            <br>
            <br>
            <p id="selectGameData">
            </p>
            <br><br>
        </tr>
    </table>
</div>



<script language="JavaScript" type="text/JavaScript">
    ts_loadTeamsDropdown(eval('(' + initalTeams + ')'));
    loadCompetitionsData(eval('(' + initialCompetitions + ')'), true);
    loadGamesData(eval('(' + initialGames + ')'), true);
    loadGameData(eval('(' + initialSelectedGameData + ')'));
    if (initialSelectedGame==-1){
        disableAll();
    }

    //select any dropdown items
    document.getElementById('selectcompetition2').value = initialSelectedCompetition;
    
    // enable or disable edit buttons
    checkPermissions();
</script>


<?
}
?>
