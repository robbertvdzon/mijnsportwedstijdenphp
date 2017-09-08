<?
/* Include Files *********************/
session_start();
include_once("database.php");
include_once("header.php");
include_once("globals.php");
include_once("request-connectteam.php");
include_once ("platform/platformsettings.php");

/*************************************/


/**
 * Inserts the given (username, password) pair
 * into the database. Returns true on success,
 * false otherwise.
 */
function enableUser(){
   global $conn;

	$activationID="";
	if (!empty($_GET["activationID"])){
		$activationID=$_GET["activationID"];
		$q = "UPDATE users SET activeAccount=1 WHERE activationID = '".$activationID."';";
		$res = mysql_query($q,$conn);
		if (mysql_errno()) {
            throw new \Exception(mysql_error());
		}
        
        
        //*********************************************
        // find userID
        $q = "select id,requestConnectTeam from users WHERE activationID = '".$activationID."';";
        $result = mysql_query($q, $conn);
        if (mysql_errno()) {
            throw new \Exception(mysql_error());
        }
        $num = mysql_numrows($result);
        if ($num == 0)
            return;// no user found    
        $userID = mysql_result($result, 0, "id");           
        $requestConnectTeamID = mysql_result($result, 0, "requestConnectTeam");
        
        if ($requestConnectTeamID!=0) connectteam\createTeamIfNeeded($userID,$requestConnectTeamID);
        
                
	}


}



printHeaderIndex("mijnsportwedstrijden.nl","mijnsportwedstrijden.nl",false);

        try{
            enableUser();
        ?>
            <big><b><!--T1073T-->Account geactiveerd<!--T1073T--></b></big><br>
            <br>
            <!--T1074T-->Het is nu mogelijk om in te loggen.<!--T1074T-->
            <br>
            <br>
            <br>
            <? printButton1("<!--T1075T-->inloggen<!--T1075T-->","javascript:ts_changeSection('login');")  ?>
            
        <?
        }
        catch (Exception $ex){
        ?>
        
            <big><b><!--T1076T-->Foutmelding bij registratie<!--T1076T--></b></big><br>
            <br><br>
            <? echo $ex->getMessage() ?>
            <br>
            <br>
            <br>
        
        <?
        }
        ?>
    
        
<?

printFooter();

?>