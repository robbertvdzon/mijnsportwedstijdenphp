<?
include_once("globals.php");
include_once("request-register.php");





function printRegister(){


    if(isset($_POST['subjoin'])){
        
        try{
            /* Make sure all fields were entered */
            if(!$_POST['user'] || !$_POST['pass'] || !$_POST['name'] || !$_POST['email']){
              throw new Exception(/*T1205T*/'Niet alle velden zijn ingevuld'/*T1205T*/);
            }
        
            /* Add the new account to the database */
            $user = $_POST['user'];
            $pass = $_POST['pass'];
            $name = $_POST['name'];
            $email= $_POST['email'];
            $testveld= $_POST['testveld'];
            
            $to_check = md5($testveld);            
            if($to_check != $_SESSION['security_code']){
                throw new \Exception(/*T1206T*/"De beveiligingscode is onjuist!"/*T1206T*/);
            }
            
            registerUser\registerNewUser($user,$pass,$name,$email,0);
        }
        catch (Exception $ex){
            ?>
        
            <big><b><!--T1207T-->Foutmelding bij registratie<!--T1207T--></b></big><br>
            <br><br>
            <? echo $ex->getMessage() ?>
            <br>
            <br>
            <br>
            <? printButton1("<!--T1208T-->terug<!--T1208T-->","javascript:history.go(-1);")  ?>
            
        
        <?
            return;
        }
    
        ?>
    
        <big><b><!--T1209T-->Registratie is gelukt<!--T1209T--></b></big><br>
    
        <!--T1210T-->Het is nu mogelijk om met de opgegevens gebruikersnaam en wachtwoord in te loggen<!--T1210T--><br>
        <br>
        <br>
        <? printButton1("<!--T1211T-->Inloggen<!--T1211T-->","ts_changeSection('login');")  ?>
    <?
        return;
    }

?>

	<big><b><!--T1212T-->Registreer bij mijnsportwedstrijden.nl<!--T1212T--></b></big>
	<br><br>
	<!--T1213T-->Vul hieronder de gegevens in voor een nieuw account:<!--T1213T--><br><br>

	<form action="index.php" method="post" name="registerForm">
	<input type="hidden" name="section" value="register">
	<table align="left" border="0" cellspacing="0" cellpadding="3">
	<tr height=30><td><!--T1214T-->Gebruikersnaam<!--T1214T--></td>
	    <td align=center>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
	    <td><input type="text" name="user" id="username" maxlength="100" autocomplete="off"></td>
	    <td width=100%></td>
	</tr>
	<tr height=30><td><!--T1215T-->Wachtwoord<!--T1215T--></td>
        <td align=center>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
	    <td><input type="password" name="pass" maxlength="100" autocomplete="off"></td>
        <td></td>
    </tr>
	<tr height=30><td><!--T1216T-->Email<!--T1216T--></td>
        <td align=center>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
	    <td><input type="text" name="email" maxlength="100" autocomplete="off"></td>
        <td></td>
    </tr>
	<tr height=30><td><!--T1217T-->Naam<!--T1217T--></td>
        <td align=center>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
	    <td><input type="text" name="name" maxlength="100" autocomplete="off"></td>
        <td></td>
    </tr>
    <tr height=30>
        <td colspan=99>
            <br>            
            <img border="0" id="captcha" src="captcha/image.php" alt="" >
            <br>
            <!--T1218T-->Ter preventie van spam, noteer bovenstaande code in het onderstaand veld<!--T1218T-->
        </td>
    </tr>
        
    <tr height=30><td><!--T1219T-->Beveiligingscode<!--T1219T--></td>
        <td align=center>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
        <td align=top> <input type="text" name="testveld" value="">
        </td></tr>
	<tr><td colspan="3" align="right">
	    <br>
	    <input type="hidden" name="subjoin" value="Registreer">
	    <input type="submit" style="position: absolute; left: -9999px; width: 1px; height: 1px;"/>
        <? printButton1(/*T1798T*/"registreer"/*T1798T*/,"javascript:document.forms['registerForm'].submit();")  ?>
        
        
	    
	    </td><td></td></tr>
	</table>
	</form>
	


<script language="JavaScript" type="text/JavaScript">
    // focus first field
    document.getElementById("username").focus();
</script>

<?
	}
?>