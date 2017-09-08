<?
include_once("globals.php");



function printLogin(){
?>

<script src="teamsport-login.js"></script>

<big><b><!--T1125T-->Login bij mijnsportwedstrijden.nl<!--T1125T--></b></big>
<br><br>

    <form action="" name="loginform" method="post">
        <table cellspacing='0'>
            <tr height=30>
                <td><!--T1126T-->Gebruikersnaam<!--T1126T--></td>
                <td width=20 align=center>:</td>
                <td>
                <input name="user" id="username" type="text" autocomplete="off" />
                </td>
            </tr>
            <tr height=30>
                <td><!--T1127T-->Wachtwoord<!--T1127T-->:</td>
                <td width=20 align=center>:</td>
                <td>
                <input name="pass" type="password" autocomplete="off" />
                </td>
            </tr>
            <tr height=30>
                <td><!--T1128T-->Blijf ingelogd:<!--T1128T--></td>
                <td width=20 align=center>:</td>
                <td>
                <input name="remember" type="checkbox" value="true" checked/>
                </td>
            </tr>
            <tr>
                <td colspan=3>
                <br>
                <input type="hidden" name="sublogin" value="Login">
                <input type="submit" style="position: absolute; left: -9999px; width: 1px; height: 1px;"/>
                <? printButton1("<!--T1129T-->inloggen<!--T1129T-->","javascript:document.forms['loginform'].submit();")  ?>
                
                
                </td>
            </tr>
        </table>
    </form>
       
    <br>
    <a href=# class=none2 onClick="javascript:document.getElementById('forgotpasswd').style.display = ''">
        <small><!--T1130T-->Wachtwoord vergeten? Klik dan hier<!--T1130T--></small>
    </a>
    <br>
    <br>
    <a href=index.php?section=competitie&user=demo&pass=demo&sublogin class='none2'>
       <small><!--T1131T-->Nieuwsgierig? Klik dan hier om als demo gebruiker in te loggen<!--T1131T--></small>
    </a>




<!--  FORGOT PASSWORD --->

<div class="popup400" id="forgotpasswd" style="display:none">    
<div class="popup400Close" >
    <img src="../images/close.png"  onClick="javascript:document.getElementById('forgotpasswd').style.display = 'none'">
</div>        

<table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
    <tr>
        <td align=middle height=30>
            <big><b><font color=white><!--T1132T-->Wachtwoord vergeten<!--T1132T--></font></b></big>
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
                        <!--T1133T-->Vul het email adres in waarmee is geregistreerd. Naar dit adres worden de login gegevens verstuurd.<!--T1133T-->
                        <br><br>
                    </td>
                </tr>                    
            </table>

            <table border=0 cellspacing='0'>
                <tr>
                    <td colspan=99 valign=top align=center width=140>

<!-- -->            
                        <table cellspacing='0'>
                            <tr>
                                <td><b><!--T1134T-->Email<!--T1134T--></b></td>
                                <td width=10></td>
                                <td><b>:</b></td>
                                <td width=10></td>
                                <td>
                                    <input id = "email" type="text" class="gameEditFields"/>
                                </td>
                            </tr>
                            
                            <tr>
                                <td valign=top colspan=100 align=center>
                                    <br>
                                    <? printButton2("<!--T1135T-->verstuur login gegevens<!--T1135T-->","javascript:forgotPassword();")  ?>
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
    ts_loadTeamsDropdown(eval('(' + initalTeams + ')'));
    // focus first field
    document.getElementById("username").focus();
    
</script>
<?
}
?>