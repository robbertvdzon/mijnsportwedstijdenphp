<?
/* Include Files *********************/
session_start();
include_once ("database.php");
include_once ("header.php");
include_once ("dbcalls.php");
include_once ("globals.php");
include_once ("teamsport.php");
include_once ("request-session.php");
include_once ("platform/platformsettings.php");

/*************************************/
header('Expires: ' . gmdate("D, d M Y H:i:s", time() + 1000) . ' GMT');
header('Cache-Control: Private');
/************ AUTHENTICATION ROUTINES *****************/
/**
 * Checks to see if the user has submitted his
 * username and password through the login form,
 * if so, checks authenticity in database and
 * creates session.
 */
 if (isset($_REQUEST['sublogin'])) {
    if (login()){
      exit();
    }
}

/* Sets the value of the logged_in variable, which can be used in your code */
checkLogin();

// if the given team is anonymous team, the you may enter without loggin in!
$anonymousTeam = false;
$teamID = -1;
if (isset($_REQUEST['team'])) {
    $teamID = $_REQUEST['team'];
    $anonymousTeam = dbcalls\checkAnonymousTeam($teamID);
}
globals\setAnonymousLogin($anonymousTeam);

// If the user is NOT logged in, and the team is NOT anonymous, then redirect to login screen (and save the section, team and game)
if (
    (getSection() != "home")&&
    (getSection() != "login")&&
    (getSection() != "register")&&
    (getSection() != "wat")&&
    (getSection() != "openCompetition")&&
    (getSection() != "searchCompetition")
    ) {
    if (!globals\isLoggedIn()) {
        if (!$anonymousTeam){
            // save the initial page which was requested
            if (isset($_REQUEST['team'])) {
                $_SESSION['requested_team'] = $_REQUEST['team'];
            }
            if (isset($_REQUEST['section'])) {
                $_SESSION['requested_section'] = $_REQUEST['section'];
            }
            if (isset($_REQUEST['game'])) {
                $_SESSION['requested_game'] = $_REQUEST['game'];
            }
            // redirect page
            echo "<meta http-equiv=\"Refresh\" content=\"0;url=index.php?section=login\">";
            //return;
        }
    }
}

// if the user IS logged in, and the team is anonymous, then check if this user has the same
// team in his competitions (as managed team), then use that team.

$currentUserID = getUserID(); // will be -1 if not found


if (globals\isLoggedIn()  && ($anonymousTeam)){
    $newRequestedTeam = dbcalls\findCorrespondingTeam($teamID,$currentUserID);
    if ($newRequestedTeam!=$teamID){
        $teamID = $newRequestedTeam;
        $anonymousTeam = false;
        globals\setAnonymousLogin($anonymousTeam);
    }    
}

/************ LOAD INITIAL DATA  *****************/

if ($anonymousTeam && $currentUserID==-1){
    $currentUserID = -99;// -99 is the anonymous userID
}
$currentUserData = dbcalls\getUserData($currentUserID);
$currentTeams = dbcalls\loadTeams2($currentUserID,$anonymousTeam,$teamID);
$currentSelectedTeamID = getCurrentTeamID($currentUserID,$teamID);
if ($anonymousTeam ){
    $currentSelectedTeamID = $teamID;
}
$currentSelectedTeamName = getCurrentTeamName($currentTeams,$currentSelectedTeamID);
$currentSelectedTeamData = dbcalls\loadTeam($currentSelectedTeamID);
// Load current team
$teamData = dbcalls\loadTeam($currentSelectedTeamID);

// Find first upcoming game detauls
$firstUpcomingData = dbcalls\findFirstUpcomingGame($currentSelectedTeamID );

//error_log("------------------\ndate:".date('l jS \of F Y h:i:s A')."\n", 3, "c:\\my-errors.log");

// Find competitions and current competition
$competitions = dbcalls\loadCompetitions($currentSelectedTeamID);
$rememberredCompetition = requestsession\getSessionCompetition();

// error_log("rememberredCompetition:".print_r($rememberredCompetition, TRUE)."\n", 3, "c:\\my-errors.log");

if (!in_array($rememberredCompetition, $competitions)){       
    $rememberredCompetition = -1;    
}

$defaultCompetition = $rememberredCompetition;
 
if ($defaultCompetition==-1){
    $defaultCompetition = $firstUpcomingData->competitionID;    
}

$currentSelectedCompetition = getCurrentCompetition($competitions, $defaultCompetition);
$currentSelectedMCompetition = getCurrentMCompetition($competitions, $defaultCompetition);

// Find games and current game
$games = dbcalls\loadGames($currentSelectedCompetition);
$rememberredGame = requestsession\getSessionGame();

if (!in_array($rememberredGame, $games)){
    $rememberredGame = -1;    
}


$defaultGame = $rememberredGame; 
if ($defaultGame==-1){
    $defaultGame = $firstUpcomingData->gameID;    
}
$requestedGame = getRequestedGame();
if ($requestedGame!=-1){
    $defaultGame = $requestedGame;    
}

$currentSelectedGame = getCurrentGame($games, $defaultGame);

$gameData = dbcalls\loadGame($currentSelectedGame);

// Find team members
$teammembers = dbcalls\loadTeammembers($currentSelectedTeamID);

// Find team members
$teammembersOfThisUser = dbcalls\loadTeammembersOfUser($currentUserID);

// load listData (only for list page)
$currentListData = "";
if (getSection()=="lijstjes") {
    $currentListData = dbcalls\loadListData($currentSelectedCompetition);
}

// find all managedCompetitions, seasons and organisations
$currentMCompetitionData = dbcalls\loadMAllCompetitionData($currentUserID);
globals\setCompetitionManager(sizeof($currentMCompetitionData->competitions)>0);

globals\setCurrentTeamID($currentSelectedTeamID);

/************ START BUILD HTML *****************/
/*T1T*/
printHeaderIndex("mijnsportwedstrijden.nl", "mijnsportwedstrijden.nl");
/*T1T*/

/************ PLACE INITIAL DATA IN JAVASCRIPT *****************/
?>


<script type="text/javascript">

    if(typeof String.prototype.trim !== 'function') {
      String.prototype.trim = function() {
        return this.replace(/^\s+|\s+$/g, ''); 
      }
    }
    
    var currentUserID = '<? echo $currentUserID ?>';
    var anonimousLogin = <? if ($anonymousTeam==1) echo "true"; else echo "false";  ?>;
    var currentUserData = '<? echo addslashes(json_encode($currentUserData)) ?>';
    var initalTeams = '<? echo addslashes(json_encode($currentTeams)) ?>';
    var initialSelectedTeam = '<? echo addslashes(json_encode($teamData)) ?>';
    var initialSelectedTeamID = '<? echo $currentSelectedTeamID ?>';
    var initialSelectedTeamName = '<? echo addslashes($currentSelectedTeamName) ?>';
    var initialSelectedTeamData = '<? echo addslashes(json_encode($currentSelectedTeamData)) ?>';
    var initialCompetitions = '<? echo addslashes(json_encode($competitions)) ?>  ';
    var initialSelectedCompetition = '<? echo addslashes($currentSelectedCompetition) ?>';
    var initialSelectedMCompetition = '<? echo addslashes($currentSelectedMCompetition) ?>';
    var initialGames = '<? echo addslashes(json_encode($games)) ?>';
    var initialSelectedGame = '<? echo addslashes($currentSelectedGame) ?>';
    var initialSelectedGameData = '<? echo addslashes(json_encode($gameData)) ?>';
    var initialTeammembers = '<? echo addslashes(json_encode($teammembers)) ?>'
    var teammembersOfThisUser = '<? echo addslashes(json_encode($teammembersOfThisUser)) ?>'
    var initialMCompetitionData = '<? echo addslashes(json_encode($currentMCompetitionData)) ?>'
    var userLoggedIn = '<? echo globals\isLoggedIn() ?>'
    
    
    initialListData = '<? echo addslashes(json_encode($currentListData)) ?>';

    currentSection = "<? echo getCurrentSection();?>";
    ts_setCurrentSection(currentSection);
</script>


<?


if (getSection()=="home") {
include("index-home.php");
printHome();
}

if (getSection()=="") {
include("index-wedstrijd.php");
printTeamWedstrijd();
}

if (getSection()=="login") {
include("index-login.php");
printLogin();
}

if (getSection()=="register") {
include("index-register.php");
printRegister();
}

if (getSection()=="wedstrijd") {
include("index-wedstrijd.php");
printTeamWedstrijd();
}

if (getSection()=="teamleden") {
include("index-teamleden.php");
printTeamleden();
}

if (getSection()=="uitslagen") {
include("index-uitslagen.php");
printUitslagen();
}

if (getSection()=="competitie") {
include("index-competitie.php");
printProgramma();
}


if (getSection()=="editlists") {
include("index-editlists.php");
printLists();
}

if (getSection()=="berichten") {
include("index-berichten.php");
printBerichten();
}

if (getSection()=="lijstjes") {
include("index-report.php");
printReports();
}

if (getSection()=="instellingen") {
include("index-settings.php");
printSettings();
}

if (getSection()=="instellingenuser") {
include("index-usersettings.php");
printUserSettings();
}

if (getSection()=="wat") {
include("index-wat.php");
printWat();
}

if (getSection()=="searchCompetition") {
include("index-searchcompetition.php");
printSearch();
}

if (getSection()=="openCompetition") {
include("index-opencompetition.php");
printOpen();
}

if (getSection()=="mijncompetities") {
include("index-mcompetition.php");
printCompetition();
}

if (getSection()=="download") {
include("index-download.php");
printDownload();
}






?>



<div class="popup400" id="newMCompetition" style="display:none">
    <div class="popup400Close" >
        <img src="../images/close.png"  onClick="javascript:document.getElementById('newMCompetition').style.display = 'none'">
    </div>        
    <table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
        <tr>
            <td align=middle height=30>
                <big><b><font color=white><!--T3T-->Beheer eigen competitie<!--T3T--></font></b></big>
            </td>
        </tr>
    </table>
    <br>
    <table border=0 width=100% cellspacing='0'>
        <tr>
            <td align=center>
            <table border=0 cellspacing='0'>
                <tr>
                    <td><b><!--T1051T-->Organisatie<!--T1051T--></b></td>
                    <td width=20 align=center>:</td>
                    <td>
                    <input id="newMCompOrganisation" type="text" />
                    </td>
                </tr>
                <tr>
                    <td><b><!--T1052T-->Seizoen<!--T1052T--></b></td>
                    <td width=20 align=center>:</td>
                    <td>
                    <input id="newMCompSeason" type="text" />
                    </td>
                </tr>
                <tr>
                    <td><b><!--T1053T-->Competitie<!--T1053T--></b></td>
                    <td width=20 align=center>:</td>
                    <td>
                    <input id="newMCompCompetition" type="text" />
                    </td>
                </tr>
            </table>
            <br><br>
            <a href="#" onclick="javascript:ts_createNewMCompetition()"><!--T1054T-->Maak aan<!--T1054T--></a> &nbsp;&nbsp; 
            </td>
        </tr>
    </table>
    <br><br>
</div>


<div class="popup400" id="newTeam" style="display:none">
    <div class="popup400Close" >
        <img src="../images/close.png"  onClick="javascript:document.getElementById('newTeam').style.display = 'none'">
    </div>        
    <table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
        <tr>
            <td align=middle height=30>
                <big><b><font color=white><!--T1055T-->Nieuw team aanmaken<!--T1055T--></font></b></big>
            </td>
        </tr>
    </table>
    <br>
    <table border=0 width=100% cellspacing='0'>
        <tr>
            <td align=center>
            <table border=0 cellspacing='0'>
                <tr>
                    <td><b>Teamnaam</b></td>
                    <td width=20 align=center>:</td>
                    <td>
                    <input id="newTeamName" type="text" />
                    </td>
                </tr>
            </table>
            <br><br>
            <a href="#" onclick="javascript:ts_createNewTeam()"><!--T1056T-->Maak aan<!--T1056T--></a> &nbsp;&nbsp; 
            </td>
        </tr>
    </table>
    <br><br>
</div>




<!--  RONDLEIDING  --->


<div class="popup400" id="rondleiding" style="display:none">    
<div class="popup400Close" >
    <img src="../images/close.png"  onClick="javascript:document.getElementById('rondleiding').style.display = 'none'">
</div>        

<table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
    <tr>
        <td align=middle height=30>
            <big><b><font color=white><!--T1057T-->Rondleiding<!--T1057T--></font></b></big>
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

                        <!--T1058T--><b>Nieuwsgierig?</b> <br>Log dan in hier in onder onze demo gebruiker: <br><!--T1058T-->
                        <br>
                        <a href=index.php?section=competitie&user=demo&pass=demo&sublogin class='none2'><!--T1059T-->[login als demo gebruiker]<!--T1059T--></a><br>
                        <br><br>
                        <small><!--T1060T-->De demo gebruikers gegevens worden elke nacht gewist..<!--T1060T--></small>  
                        <br>        
                    </td>
                </tr>
            </table>
            <br><br>                    
        </td>
    </tr>
</table>
</div>    


<!--  ZOEKEN  --->

<div class="popup400" id="zoekcompetitie" style="display:none">    
<div class="popup400Close" >
    <img src="../images/close.png"  onClick="javascript:document.getElementById('zoekcompetitie').style.display = 'none'">
</div>        

<table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
    <tr>
        <td align=middle height=30>
            <big><b><font color=white><!--T1061T-->Zoek je competitie<!--T1061T--></font></b></big>
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
                        <table>
                            <tr>
                                <td>&nbsp;</td>
                                <td colspan=3>
                                    <!--T1062T-->Zoek je competitie aan de hand van de organisatie of van je teamnaam.<!--T1062T--><br><br> 
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <b><!--T1063T-->Organisatie<!--T1063T--></b>
                                </td>
                                <td>
                                    <b>&nbsp;:&nbsp;</b>
                                </td>
                                <td>
                                    <input type=text id="organisation">
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                    <b><!--T1064T-->teamnaam<!--T1064T--></b>
                                </td>
                                <td>
                                    <b>&nbsp;:&nbsp;</b>
                                </td>
                                <td>
                                    <input type=text id="team">
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>
                                </td>
                                <td>
                                </td>
                                <td>
                                    <br>
                                    <? printButton1(/*T2T*/"zoek"/*T2T*/,"javascript:searchCompetition();")  ?>
                                </td>
                                <td>&nbsp;</td>
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

<script language="JavaScript" type="text/JavaScript">

</script>
<script type="text/javascript">
window.___gcfg = {lang: 'nl'};

(function() {
var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
po.src = 'https://apis.google.com/js/plusone.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();
</script>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/nl_NL/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<?
printFooter();


if(globals\hasLoginError()){
?>
<script language="JavaScript" type="text/JavaScript">
    ts_showGlobalError(/*T1065T*/"Login"/*T1065T*/,"<? echo globals\getLoginError();?>");</script>
<?
}


?>