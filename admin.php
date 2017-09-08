<?
/* Include Files *********************/
session_start();
include_once("database.php");
include_once("header.php");
include_once("globals.php");
include_once("dbcalls.php");
include_once ("platform/platformsettings.php");

/*************************************/


//printHeaderIndex("mijnsportwedstrijden.nl","mijnsportwedstrijden.nl",false);


?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="UTF-8">
    <head>
        <title>Mijn Sportwedstrijden</title>
        <link rel="shortcut icon" href="favicon.ico" >
        <meta name="viewport" content="width=1200, user-scalable=yes" />
        <META NAME="keywords" CONTENT="sport wedstrijden zaalvoetbal handbal volleybal teamsport">
        <META NAME="description" CONTENT="Mijn Sportwedstrijden is een handige website voor het beheren van je sport teams.
        Samen met de android app is het nu nog gemakkelijker om aan zien welke teamleden er bij de volgende wedstrijd aanwezig is.">
        <META NAME="expires" CONTENT="never">

        <link rel="stylesheet" href="admin.css"/>
        <link rel="stylesheet" href="font.css"/>

        <!-- Update your html tag to include the itemscope and itemtype attributes -->
        <html itemscope itemtype="http://schema.org/Organization"/>
        <!-- Add the following three tags inside head -->
        <meta itemprop="name" content="Mijn Sportwedstrijden">
        <meta itemprop="description" content="Mijn Sportwedstrijden is een handige website voor het beheren van je sport teams.
        Samen met de android app is het nu nog gemakkelijker om aan zien welke teamleden er bij de volgende wedstrijd aanwezig is.">
        
        <script src="teamsport.js"></script>
        <script src="teamsport-connectteam.js"></script>
        <script src="jquery.js"></script>
        <script src="jquery.maskedinput-1.3.min.js"></script>
        <script src="json2.js"></script>
        <script src="cufon-yui.js"></script>
        <script src="Harabara_700-Harabara_700.font.js"></script>
        <script type="text/javascript">
            Cufon.replace('#headerteamname'); // Requires a selector engine for IE 6-7, see above
            Cufon.replace('#headertitlename'); // Requires a selector engine for IE 6-7, see above
            Cufon.replace('#headertitlenameLoggedOff'); // Requires a selector engine for IE 6-7, see above
            Cufon.replace('#headerusername'); // Requires a selector engine for IE 6-7, see above
            Cufon.replace('#homedescriptionsite'); // Requires a selector engine for IE 6-7, see above
            Cufon.replace('#homedescriptionapp'); // Requires a selector engine for IE 6-7, see above
            Cufon.replace('h3'); // Requires a selector engine for IE 6-7, see above
            Cufon.replace('h4'); // Requires a selector engine for IE 6-7, see above
            Cufon.replace('h5'); // Requires a selector engine for IE 6-7, see above
            Cufon.replace('h6'); // Requires a selector engine for IE 6-7, see above
            Cufon.replace('h7'); // Requires a selector engine for IE 6-7, see above
        </script>
        
        <script type="text/javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-29138791-1']);
            _gaq.push(['_trackPageview']);
            (function() {
                var ga = document.createElement('script');
                ga.type = 'text/javascript';
                ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(ga, s);
            })();

        </script>



    </head>
    <body class="empty">
<?






/*-----------------------------------------*/

global $allowAdminAccess1;
global $allowAdminAccess2;
global $allowAdminAccess3;
global $allowAdminAccess4;
global $adminpasswd;


$ok=false;
$ipGood = false;
$clientIP = "";
if (!empty($_REQUEST["pw"])){
    $pw = $_REQUEST["pw"];
    if ($pw==$adminpasswd){
        $ok=true;
    }
}
// get ip
    $clientIP = getRealIpAddr();

// test of het van DAX vandaan komt
if ($allowAdminAccess1==$clientIP){
    $ipGood = true;
}
 
// test of het van huis vandaan komt
if ($allowAdminAccess2==$clientIP){
    $ipGood = true;
}

// test of het van localhost vandaan komt
if ($allowAdminAccess3==$clientIP){
    $ipGood = true;
}
// test of het van localhost vandaan komt
if ($allowAdminAccess4==$clientIP){
    $ipGood = true;
}

 

if (!$ipGood){
        $ok=false;
    } 



if ($ok) {
?>
        <script src="admin.js"></script>

		<big><b>mijnsportwedstrijden.nl admin</b></big><br>
		<br>
        <br>
        <br>
		<br>
        <a href="#"  onclick="javascript:syncMCompetition();">Sync all managed competitions</a>
        <br>
        <br>
        <br>
        <a href="#"  onclick="javascript:ts_generateDemoData();">Genereer demo data</a>
        <br>
        <br>
        <br>
        <a href="#"  onclick="javascript:ts_removeDemoData();">Remove demo data</a>
        <br>
        <br>
        <br>
        <a href="#"  onclick="javascript:ts_clearOrphanData();">Verwijder orphan data</a>
        <br>
        <br>
        <br>
        
        <a href="#"  onclick="javascript:ts_callCron();">Email all reminders, warnings and errors</a>
        <br>
        <br>
        <br>
        <a href="#"  onclick="javascript:ts_getAllSchemaChanges();">Show all schema changes</a>
        <br>
        <p id=sqlschemaChanges></p>
        <br>
        <a href="#"  onclick="javascript:ts_performAllSchemaChanges();">Perform all schema changes</a>
        <br>
        <br>
        <p id=sqlschemaChangesFinished></p>
        <a href="#"  onclick="javascript:dbSummary();">List DB summary</a>
        <br>
        <br>
        <p id=dbSummary></p>
        <a href="#"  onclick="javascript:listTeams();">List all teams</a>
        <br>
        <br>
        <p id=teamlist></p>
        <table>
            <tr>
            <td>filter op teamID</td><td>&nbsp;:&nbsp;</td><td><input type=text id=filterTeamID></td>
            </tr>
        </table>
        <a href="#"  onclick="javascript:listTeammembers();">List all teammembers</a>
        <br>
        <br>
        <a href="#"  onclick="javascript:listUsers();">List all users</a>
        <br>
        <br>
        <p id=userlist></p>
        <a href="#"  onclick="javascript:listChanges();">List last changes</a>
        <br>
        <table>
            <tr>
            <td>filter op gameID</td><td>&nbsp;:&nbsp;</td><td><input type=text id=filterLogGameID></td>
            </tr>
            <tr>
            <td>filter op teamID</td><td>&nbsp;:&nbsp;</td><td><input type=text id=filterLogTeamID></td>
            </tr>
            <tr>
            <td>filter op userID</td><td>&nbsp;:&nbsp;</td><td><input type=text id=filterLogUserID></td>
            </tr>
            <tr>
            <td>filter op memberID</td><td>&nbsp;:&nbsp;</td><td><input type=text id=filterLogMemberID></td>
            </tr>
        </table>
        
        <p id=changesist></p>
        <br>

        <a href="translate.php"  >Translate</a>

<?
}
else{
    if ($ipGood){
?>
        <big><b>mijnsportwedstrijden.nl admin</b></big><br>
        <br>
        <br>
        <br>
        <br>
        <form >
        Password: <input type="password" name="pw" />
        </form>

<?
    }
    else{
?>
        <big><b>mijnsportwedstrijden.nl admin</b></big><br>
        <br>
        <br>
        <br>
        <br>
        Dit niet mogelijk vanaf client <?echo $clientIP ?>...

<?
    }
    
}

printFooter();

?>
