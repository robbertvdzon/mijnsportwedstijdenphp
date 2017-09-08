<?
include_once("globals.php");

function printHome(){
?>
<script src="teamsport-home.js"></script>


        <script type="text/javascript">
            Cufon.replace('#optie1'); // Requires a selector engine for IE 6-7, see above
            Cufon.replace('#optie2'); // Requires a selector engine for IE 6-7, see above
        </script>


<table border=0 width=100% cellspacing='0'>
        <tr>
        <td valign=top>


<br>
<big><b><!--T8T-->Welkom bij mijnsportwedstrijden.nl<!--T8T--></b></big>
<br><br>

<table width=100%  border=0>
    <tr>
        <td valign="top" >
<!--T1072T-->            
Met mijnsportwedstrijden.nl kun je GRATIS makkelijk en overzichtelijk je wedstrijden en de aanwezigheid van je teamgenoten bekijken. Via mijnsportwedstrijden.nl geef je eenvoudig je aanwezigheid door voor de komende wedstrijden. Bij te weinig spelers of teamgenoten die nog niet hebben gereageerd, ontvang je automatisch bericht. Met mijnsportwedstrijden.nl kun je de gehele competitie en alle uitslagen bekijken.
<br><br>
Wedstrijdgegevens kun je makkelijk importeren uit teamers.nl. Als je competitie al is aangesloten op mijnsportwedstrijden.nl dan is het nog makkelijker. Zoek je eigen competitie en schijf je in op je team. Je ziet nu in een handig overzicht je eigen wedstrijden, de uitslagen en de stand. Tevens kun je de wedstrijden en uitslagen van je tegenstanders bekijken.
<br><br>
Met de bijbehorende android app kun je alles nog sneller en eenvoudiger bijhouden!
<!--T1072T-->            
<br><br>
       
       
            
<table>
    <tr>
        <td valign=center>
            <img src="../images/pijl.png" >
        </td>
        <td>
            &nbsp;&nbsp;<a id="optie1" class="homelinks" href=# onClick="javascript:document.getElementById('zoekcompetitie').style.display = ''"><!--T1119T-->Zoek je eigen competitie<!--T1119T--></a>
        </td>
    </tr>

    <tr>
        <td >
            &nbsp;
        </td>
    </tr>

    <tr>
        <td valign=center>
            <img src="../images/pijl.png" >
        </td>
        <td>
            &nbsp;&nbsp;<a id="optie2" class="homelinks" href=# onClick="javascript:document.getElementById('rondleiding').style.display = ''"><!--T1120T-->Klik hier voor een rondleiding<!--T1120T--></a>
        </td>
    </tr>
</table>        
        
        <br>
        <br>


        <?

if( globals\isLoggedIn()){
    if (globals\getCurrentTeamID()==-1){
        ?>
        <!--T1121T-->
        <b>Je bent nog geen lid van een team!</b>
        <br>
        Vraag een beheerder van je team om je uit te nodigen voor het team of richt zelf een team op met onderstaande knop.
        <br>
        Zodra je lid bent van een team is het mogelijk om wedstrijden toe te voegen en het team te beheren.
        <br>
        <br>
        <!--T1121T-->
        <? printButton2("<!--T1122T-->Richt nieuw team op<!--T1122T-->","javascript:ts_openNewTeam();")  ?>
        
        <?
    }
}
        ?>
<table>
    <tr>
        <td>
<!--T1123T-->            
<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.mijnsportwedstrijden.nl" data-text="Handige site om je sportwedstrijden te beheren!" data-count="none">Tweet</a>
<!--T1123T-->
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
        </td><td>
        &nbsp;&nbsp;&nbsp;&nbsp;
        </td><td>

    <g:plusone size="small" annotation="none"></g:plusone>
        </td><td>
        &nbsp;&nbsp;&nbsp;&nbsp;
        </td><td>
<!--T1124T-->            
    <div class="fb-like" data-href="http://www.mijnsportwedstrijden.nl" data-send="false" data-layout="button_count" data-width="5" data-show-faces="false" data-action="recommend"></div>
<!--T1124T-->    
        </td>
   </tr>
</table>
<br>
<img src="../images/slogan.png" width=480px  >

           
        </td>
    </tr>

    
    
</table>
            
        

        <br>

        </td>
        <td>
             &nbsp;&nbsp;&nbsp;
        </td>
        <td valign="top" align="right" width=1px>
             <img src="../images/app_telefoon.gif" >
        </td>
    </tr>


</table>




<script language="JavaScript" type="text/JavaScript">
    ts_loadTeamsDropdown(eval('(' + initalTeams + ')'));
</script>
<?
}
?>