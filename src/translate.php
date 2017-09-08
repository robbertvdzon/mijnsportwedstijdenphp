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

        <link rel="stylesheet" href="translate.css"/>
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
global $allowTranslateAccess1;
global $allowTranslateAccess2;
global $allowTranslateAccess3;
global $allowTranslateAccess4;
global $translatepasswd;

$ok=false;
$ipGood = false;
$clientIP = "";
if (!empty($_REQUEST["pw"])){
    $pw = $_REQUEST["pw"];
    if ($pw==$translatepasswd){
        $ok=true;
    }
}
// get ip
    $clientIP = getRealIpAddr();

// test of het van DAX vandaan komt
if ($allowTranslateAccess1==$clientIP){
    $ipGood = true;
}
 
// test of het van huis vandaan komt
if ($allowTranslateAccess2==$clientIP){
    $ipGood = true;
}

// test of het van localhost vandaan komt
if ($allowTranslateAccess3==$clientIP){
    $ipGood = true;
}
// test of het van localhost vandaan komt
if ($allowTranslateAccess4==$clientIP){
    $ipGood = true;
}

 

if (!$ipGood){
        $ok=false;
    } 



if ($ok) {
?>
        <script src="translate.js"></script>

        <div style="width:95%;height:15%;background-color:#ffffff;overflow:auto;">
                <a href="#"  onclick="javascript:tr_listIDs();">Show lines to translate</a>
                &nbsp;&nbsp;
                <a href="#"  onclick="javascript:tr_updateIDs();">Rescan original source</a>
                &nbsp;&nbsp;
                <a href="#"  onclick="javascript:tr_saveChanges();">Save all changes</a>
                &nbsp;&nbsp;
                <a href="#"  onclick="javascript:tr_translate();">Translate all files</a>
                &nbsp;&nbsp;
                <a href="#"  onclick="javascript:tr_debug_translate();">Debug translate</a>
                <br>
                <br>
                <b>Filter:</b>
                &nbsp;
                &nbsp;
                &nbsp;
                Filename:
                <input type="text" id='filenamefilter' size="30">
                &nbsp;
                ID:
                <input type="text" id='keyfilter' size="5">
                &nbsp;
                Original text:
                <input type="text" id='orginalfilter' size="30">
                &nbsp;
                Translated text:
                <input type="text" id='translatedfilter' size="30">
                &nbsp;
                <input  type="checkbox" id='empty'>
                Only empty lines
                &nbsp;
                <input  type="checkbox" id='notempty'>
                Only translated lines
                
                <hr>
        </div>
        <div style="position:absolute;
            width:98%;
            height:83%;
            background-color:#ffffff;
            overflow:auto;">
                <p id=listIDs></p>
        </div>
        
        <div style="position:absolute;
            width:98%;
            height:83%;
            background-color:#ffffff;
            overflow:auto;  display:none" id="othertranslationsScreen">
            <a href="#"  onclick="javascript:closeOtherTransactions();">Close</a>
            
            <p id=othertranslations></p>
        </div>
        
        <br>
        <br>
        <br>

<?
}
else{
    if ($ipGood){
?>
        <big><b>Translate</b></big><br>
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
        <big><b>Translate</b></big><br>
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
