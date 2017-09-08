<?
/* Include Files *********************/
session_start();
include_once("database.php");
include_once("teamsport.php");
include_once("header.php");
include_once("globals.php");
include_once ("platform/platformsettings.php");

/*************************************/

$found=false;
$teamID="";
$nickname="";
$invitationDate="";
$teamname="";
$stepOne=false;

function loadInvitationData($id){
   global $conn;
   global $found,$teamID,$nickname,$invitationDate,$teamname;

   $options = "";
    $teamname="";
    $query="SELECT * FROM teammember where invitationID='".$id."'";
    $result=mysql_query($query,$conn);
    if (mysql_errno()) {
        echo mysql_error();
        return;
    }
    $num=mysql_numrows($result);
    if ($num>0){
        $found=true;
        $teamID=mysql_result($result,0,"teamID");
        $nickname=mysql_result($result,0,"nickname");
        $invitationDate=mysql_result($result,0,"invitationDate");
        $teamname=getTeamname($teamID);
    }
}

/*T1383T*/printHeader("mijnsportwedstrijden.nl","mijnsportwedstrijden.nl");/*T1383T*/
$invitationID = "";
$ok=true;
if (empty($_GET["id"])){
    $ok=false;
    $stepOne=true;
}

if ($ok){
    $stepOne=false;
    $invitationID =$_GET["id"];
    loadInvitationData($invitationID);
}

if ($stepOne){
?>
<script src="join.js"></script>
<big><b><!--T1384T-->Uitnodiging voor mijnsportwedstrijden.nl!<!--T1384T--></b></big>
<br>
<br>
<!--T1385T-->
Als het goed is heeft u een uitnodigings code gekregen per email<br>
Vul de uitnodigings code in het onderstaand veld:<br>
<!--T1385T-->
<form>
<input type="text" id="uitnodigingscode"><br>
</form>
<br>
<? printButton2("Verder","javascript:verder();")  ?>

<?

}


else if ($found){
?>
<script src="join.js"></script>
<big><b>Welkom <? echo $nickname
    ?></b></big>
<br>
<!--T1386T-->Je bent uitgenodigd om lid te worden van<!--T1386T--> <? echo $teamname
?>.
<br>
<br>
<!--T1387T-->Als je nog geen account hebt, dan kun je hieronder een nieuw account aanmaken. <br>Dit account wordt direct gekoppeld aan je team.<!--T1387T--> 
<br>

<table cellspacing='0'>
    <tr>
        <td><!--T1388T-->Gebruikersnaam<!--T1388T--></td>
        <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
        <td>
        <input id="newUsername" type="text" />
        </td>
    </tr>
    <tr>
        <td><!--T1389T-->Wachtwoord<!--T1389T--></td>
        <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
        <td>
        <input id="newPassword" type="password" />
        </td>
    </tr>
    <tr>
        <td><!--T1390T-->Naam<!--T1390T-->/td>
        <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
        <td>
        <input id="newName" type="text" value="<? echo $nickname;?>" />
        </td>
    </tr>
    <tr>
        <td><!--T1391T-->Email<!--T1391T--></td>
        <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
        <td>
        <input id="newEmail" type="text" value="" />
        </td>
    </tr>
    <tr>
        <td><!--T1392T-->Bijnaam in team<!--T1392T--></td>
        <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
        <td>
        <input id="newNickname" type="text" value="<? echo $nickname;?>" />
        </td>
    </tr>
    <br>
</table></td>
<br>
<table>
<tr>
<td>
<? printButton2("<!--T1393T-->Maak account aan<!--T1393T-->","javascript:acceptNew('$invitationID')")  ?>
</td>
<td>
</td>
</tr>
</table>
<br>
<!--T1394T-->Als je al een account hebt, klik dan op 'Bestaand account' of klik op 'afwijzen' als je geen lid wilt worden.<!--T1394T-->
<br><br>

<table>
<tr>
<td>        
<? printButton2("<!--T1395T-->Bestaand account<!--T1395T-->","javascript:document.getElementById('existingUser').style.display = ''")  ?>
</td>        
<td>        
&nbsp;&nbsp;
</td>        
<td>        
<? printButton2("<!--T1396T-->Afwijzen<!--T1396T-->","javascript:rejectInvitation('$invitationID')")  ?>
</td>        
<tr>
</table>

<br>



<div class="popup400" id="existingUser" style="display:none">
    <div class="popup400Close" >
        <img src="../images/close.png"  onClick="javascript:document.getElementById('existingUser').style.display = 'none'">
    </div>        
    <table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
        <tr>
            <td align=middle height=30>
                <big><b><font color=white><!--T1397T-->Gebruik bestaan account<!--T1397T--></font></b></big>
            </td>
        </tr>
    </table>

    <table width=100% border=0 cellspacing='0'>
        <tr>
            <td align=center>


                <table border=0 cellspacing='0'>
                    <tr>
                        <td width=20></td>
                        <td valign=top>
                        <br>
                        <!--T1398T-->Ik heb al een account en gebruik
                        onderstaande gegevens:<!--T1398T-->
                        <br>
                        <table cellspacing='0'>
                            <tr>
                                <td><!--T1399T-->Gebruikersnaam<!--T1399T--></td>
                                <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                <td>
                                <input id="existingUsername" type="text" />
                                </td>
                            </tr>
                            <tr>
                                <td><!--T1400T-->Wachtwoord<!--T1400T--></td>
                                <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                <td>
                                <input id="existingPassword" type="password" />
                                </td>
                            </tr>
                            <tr>
                                <td><!--T1401T-->Bijnaam in team<!--T1401T--></td>
                                <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                <td>
                                <input id="existingNickname" type="text" value="<? echo $nickname;?>" />
                                </td>
                            </tr>
                            <br>
                        </table></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                        <br>
                        <? printButton2("<!--T1402T-->Accepteer<!--T1402T-->","javascript:acceptExisting('$invitationID')")  ?>
                        <td>
                    </tr>
                </table>
                </td>
            </tr>
        </table>
        <br><br>
</div>




<br>
<?
}
else {
?>
<big><b><!--T1403T-->Uitnodiging bestaat niet of is reeds verwerkt<!--T1403T--></b></big>
<br>
<br>
<a href=index.php><!--T1404T-->terug<!--T1404T--></a>
<?
}
?>


</div> <?
printFooter();
?>
