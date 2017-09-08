<?
include_once("teamsport.php");

function printHeader($pageTitle, $pageDescription){
    printHeaderIndex($pageTitle, $pageDescription, true);
}

function printHeaderIndex($pageTitle, $pageDescription){
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="UTF-8">
    <head>
        <!--T1022T-->
        <title>Mijn Sportwedstrijden</title>
        <!--T1022T-->
        <link rel="shortcut icon" href="favicon.ico" >
        <meta name="viewport" content="width=1200, user-scalable=yes" />
        <!--T6T-->
        <META NAME="keywords" CONTENT="sport wedstrijden zaalvoetbal handbal volleybal teamsport">
        <META NAME="description" CONTENT="Mijn Sportwedstrijden is een handige website voor het beheren van je sport teams.
        Samen met de android app is het nu nog gemakkelijker om aan zien welke teamleden er bij de volgende wedstrijd aanwezig is.">
        <!--T6T-->
        <META NAME="expires" CONTENT="never">

<!--T1023T-->
<meta property="og:title" content="mijnsportwedstrijden.nl" />
<meta property="og:type" content="" />
<meta property="og:url" content="http://www.mijnsportwedstrijden.nl" />
<meta property="og:image" content="" />
<meta property="og:site_name" content="http://www.mijnsportwedstrijden.nl" />
<meta property="fb:admins" content="100001285620265" />
<!--T1023T-->
        <link rel="stylesheet" href="site.css"/>
        <link rel="stylesheet" href="font.css"/>

        <!-- Update your html tag to include the itemscope and itemtype attributes -->
        <html itemscope itemtype="http://schema.org/Organization"/>
        <!-- Add the following three tags inside head -->
<!--T1024T-->        
        <meta itemprop="name" content="Mijn Sportwedstrijden">
        <meta itemprop="description" content="Mijn Sportwedstrijden is een handige website voor het beheren van je sport teams.
        Samen met de android app is het nu nog gemakkelijker om aan zien welke teamleden er bij de volgende wedstrijd aanwezig is.">
<!--T1024T-->        
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
    <body >

<div class="wrapper">






        <div class="siteTop">
        </div>
        <div class="siteTop2">
        </div>
        <div class="siteTop3">
        </div>


            <?
/*
 * PRINT LOGIN MENU
 */

?>
<div class="teamLayer" id="teamLayer">
<table width=100%>
<tr>
<td align=right valign=bottom >
    <table>
    <tr>
    <td class=headerusername1 >

        <a href=# class=none2 onclick='ts_changeSection("wat");'>
            Help           
        </a>
        
        &nbsp;|&nbsp;

        <a href=# class=none2 onclick='ts_changeSection("register");'>
            <!--T1025T-->Registreren<!--T1025T-->           
        </a>
        
        &nbsp;|&nbsp;

        <a href=# class=none2 onclick='javascript:document.getElementById("zoekcompetitie").style.display = ""'>
            <!--T1026T-->Zoek<!--T1026T-->           
        </a>
        
        &nbsp;|&nbsp;



<? 
 
if(globals\isLoggedIn()){
    try{
        $userName = dbcalls\getName(dbcalls\getUserID($_SESSION['username']));
    }
    catch(Exception $ex){
        $userName = "";
    }
    ?>
        <a href=# class=none2 onclick='javascript:window.location="logout.php";'>
            <!--T1027T-->Uitloggen<!--T1027T-->           
        </a>
        
        &nbsp;|&nbsp;

        <a href=# class=none2 onClick="javascript:document.getElementById('userMenu').style.display = ''">           
        <? echo $userName;?>
        <img src="../images/pijl2.png" >
        </a>
    <?
}
else{    ?>
        <a href=# class=none2 onclick='javascript:document.getElementById("rondleiding").style.display = ""'>
            <!--T1028T-->Demo<!--T1028T-->           
        </a>
        &nbsp;|&nbsp;
        <a href=# class=none2 onclick='ts_changeSection("login");'>
            <!--T1029T-->Login<!--T1029T-->           
        </a>
        
    <?
    
}

?>
    </td>
    </tr>
    </table>

</td>
</tr>
</table>
</div>
<? 
   
   

/*
 * PRINT HEADER TEXT
 */
               

if(globals\isLoggedIn()){
    
            ?>
            <div class="headerTextTeamname" id="headerTextTeamname" >
                <p id="headerteamname" class="headerTextTeamNameFont"></p>
            </div>            
            <div class="headerTextAppName" id="headerTextAppName" >
                <p id="headertitlename" class="headerTextAppNameFont"><!--T1030T-->mijn sportwedstrijden<!--T1030T--></p>
            </div>
            <?
            }
else{
    if(globals\isAnonymousLogin()){
            ?>
            <div class="headerTextTeamname" id="headerTextTeamname" >
                <p id="headerteamname" class="headerTextTeamNameFont"></p>
            </div>            
            <div class="headerTextAppName" id="headerTextAppName" >
                <p id="headertitlename" class="headerTextAppNameFont"><!--T1031T-->mijn sportwedstrijden<!--T1031T--></p>
            </div>
            <?
    }            
    else {
            ?>
            <div class="headerTextAppNameLoggedOff" id="headerTextAppNameLoggedOff" >
                <p id="headertitlenameLoggedOff" class="headerTextAppNameLoggedOffFont"><!--T1032T-->mijn sportwedstrijden<!--T1032T--></p>
            </div>
            <?
   }
}
 
 
/*
 * PRINT "DIT IS MIJN TEAM" IMAGE
 */
         
 
if(globals\isAnonymousLogin()){
?>
            <div class="ditismijnteam" id="ditismijnteam" >
                <img src="images/mijnteam.png" onClick="openConnectTeam()">
                        

            </div>
<?
}
?>
            
            <div id="menuLayer" class="menuLayer" style="display:none">
                    <table border=0 width=100%  cellspacing='0'>
                          <tr height=50><td></td></tr>
                          <tr ><td align=right>
                        <?
                        
/*
 * PRINT LEFT MENU
 */
                        
                                                
if(!globals\isLoggedIn()){
    
    if (getSection()=="login") {
                            ?>
                            <? echo printMenuButton('home',/*T1033T*/'home'/*T1033T*/)?>
                            <?
    }
    else if (getSection()=="register") {
                            ?>
                            <? echo printMenuButton('home',/*T1034T*/'home'/*T1034T*/)?>
                            <?
    }
    else{
                            ?>
                            <? echo printMenuButton('home',/*T1035T*/'home'/*T1035T*/)?>
                            <?
    }


    if(globals\isAnonymousLogin()){
        ?>
        
                        <? echo printMenuButton('wedstrijd',/*T1036T*/'wedstrijd'/*T1036T*/)?>
                        <? echo printMenuButton('competitie',/*T1037T*/'competitie'/*T1037T*/)?>
                        <? echo printMenuButton('teamleden',/*T1038T*/'teamleden'/*T1038T*/)?>
                        <? echo printMenuButton('lijstjes',/*T1039T*/'lijstjes'/*T1039T*/)?>
                        <? echo printMenuButton('instellingen',/*T1040T*/'instellingen'/*T1040T*/)?>
        <?        
    }
    
    
}
else{
    if (globals\getCurrentTeamID()==-1){
                        ?>
                        <? echo printMenuButton('home',/*T1041T*/'home'/*T1041T*/)?>
                        <? echo printMenuButton('instellingen',/*T1042T*/'instellingen'/*T1042T*/)?>
                        <?

                        }
    else{
                        ?>



                        <!-- menu -->
                        <? echo printMenuButton('home',/*T1043T*/'home'/*T1043T*/)?>
                        <? echo printMenuButton('wedstrijd',/*T1044T*/'wedstrijd'/*T1044T*/)?>
                        <? echo printMenuButton('competitie',/*T1045T*/'competitie'/*T1045T*/)?>
                        <? echo printMenuButton('teamleden',/*T1046T*/'teamleden'/*T1046T*/)?>
                        <? echo printMenuButton('lijstjes',/*T1047T*/'lijstjes'/*T1047T*/)?>
                        <? echo printMenuButton('instellingen',/*T1048T*/'instellingen'/*T1048T*/)?>

                        <?
    }
    if (globals\isCompetitionManager()){
                    ?>
                    <? echo printMenuButton('mijncompetities',/*T1049T*/'mijn competities'/*T1049T*/)?>
                    <?
    }
}
                        ?>
                </td></tr>
                    </table>
                    <br>
                    <br>
                    
                    
                    
    </div>
    
<div class="ad1" id="ad1"   >
    <script type="text/javascript"><!--
    google_ad_client = "ca-pub-0739674513712934";
    /* ad5 */
    google_ad_slot = "4124143769";
    google_ad_width = 200;
    google_ad_height = 90;
    //-->
    </script>
    <script type="text/javascript"
    src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
    </script>
</div>       

<div class="ad2" id="ad2"   >
    <script type="text/javascript"><!--
    google_ad_client = "ca-pub-0739674513712934";
    /* ad6 */
    google_ad_slot = "1281035860";
    google_ad_width = 200;
    google_ad_height = 200;
    //-->
    </script>
    <script type="text/javascript"
    src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
    </script>
</div>        

    
   <div class="workLayer" >
    <?
}

function printFooter()
{
        ?>

   </div>


<div class="userMenu" id="userMenu" style="display:none">
    <div class="userMenuClose" >
        <img src="../images/close.png"  onClick="javascript:document.getElementById('userMenu').style.display = 'none'">
    </div>        
    <table width=100% border=0 cellspacing='0'>
        <tr>
            <td align=left>
                <br>
                <table width=100%>
                <tr>
                    <td>
                    <p id="usersMenu"> </p>
                    
                    </td>
                </tr>
                </table>
            </td>
        </tr>
    </table>
    <br><br>
</div>
        
        
<div class="globalError" id="globalError" style="display:none">
    <div class="popup400Close" >
        <img src="../images/close.png"  onClick="javascript:document.getElementById('globalError').style.display = 'none'">
    </div>        
    <table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
        <tr>
            <td align=middle height=30>
                <big><b><font color=white id="globalErrorTitle"></font></b></big>
            </td>
        </tr>
    </table>
    <table width=100% border=0 cellspacing='0'>
        <tr>
            <td align=center>

                <br>
                <p id="globalErrorMessage"></p>
                <br>
                <br>
                </td>
            </tr>
        </table>
        <br><br>
</div>
            
            

<div class="globalSuccess" id="globalSuccess" style="display:none">
    <div class="popup400Close" >
        <img src="../images/close.png"  onClick="javascript:document.getElementById('globalSuccess').style.display = 'none';if(ts_successCallbackFunction!=null) ts_successCallbackFunction()">
    </div>        
    <table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
        <tr>
            <td align=middle height=30>
                <big><b><font color=white id="globalSuccessTitle"></font></b></big>
            </td>
        </tr>
    </table>
    <table width=100% border=0 cellspacing='0'>
        <tr>
            <td align=center>

                <br>
                <p id="globalSuccessMessage"></p>
                <br>
                <br>
                </td>
            </tr>
        </table>
        <br><br>
</div>
                        



<div class="connectTeam" id="connectTeam" style="display:none">
    <div class="popup600Close" >
        <img src="../images/close.png"  onClick="javascript:document.getElementById('connectTeam').style.display = 'none'">
    </div>
    <table width=100% border=0 bgcolor=#263f24 cellspacing='0'>
        <tr>
            <td align=middle height=30>
                <big><b><font color=white>Dit is mijn team!</font></b></big>
            </td>
        </tr>
    </table>

    <table width=100% border=0 cellspacing='0'>
        <tr>
            <td align=center>
                <table><tr><td align=left>
                <br>
                <p id='connectTeamBody'></p>
                <br>
                </td></tr></table>
            </td>
        </tr>
    </table>
    <br>
</div>

<!--
<div class="googleLike" id="googleLike" >
    <g:plusone size="small" annotation="none"></g:plusone>
    <div class="fb-like" data-href="http://www.mijnsportwedstrijden.nl" data-send="false" data-layout="button_count" data-width="5" data-show-faces="false" data-action="recommend"></div>
</div>
-->


<!--
    <div class="push"></div>
-->

</div>

<!--
<div class="footer" >
</div>
-->

    <script type="text/javascript">
    if (ts_isset("initalTeams")){
        ts_loadTeamsUsermenu(eval('(' + initalTeams + ')'));
    }
    Cufon.now(); 
    document.getElementById('menuLayer').style.display = ''
    </script>
    
    </body>
</html>
<?
}
