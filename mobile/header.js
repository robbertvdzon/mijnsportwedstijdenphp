var pageWidth = 100;
var pageHeight = 100;
var heightScaleFactor = 0; // 0 to 3
var widthScaleFactor = 0; // 0 to 3

var heightScales=new Array();// bij welke hoogte resoluties veranderen we de scale
heightScales[0]=0;
heightScales[1]=200;
heightScales[2]=400;
heightScales[3]=6000;

var widthScales=new Array();// bij welke breedte resoluties veranderen we de scale
widthScales[0]=0;
widthScales[1]=300;
widthScales[2]=400;
widthScales[3]=670;

var iconImagesPrefix=new Array(); // bij de verschillende scales, zet de prefix van de icons
iconImagesPrefix[0]="A";
iconImagesPrefix[1]="A";
iconImagesPrefix[2]="A";
iconImagesPrefix[3]="B";

var iconImagesWidth=new Array();  // bij de verschillende scales, zet image width
iconImagesWidth[0]=40;
iconImagesWidth[1]=60;
iconImagesWidth[2]=75;
iconImagesWidth[3]=150;

var headerHeigthsTable=new Array();  // bij de verschillende scales, zet de header hoogte
headerHeigthsTable[0]=20;
headerHeigthsTable[1]=30;
headerHeigthsTable[2]=40;
headerHeigthsTable[3]=40;

var headerButtonHeigthsTable=new Array();  // bij de verschillende scales, zet de button layer hoogte
headerButtonHeigthsTable[0]=30;
headerButtonHeigthsTable[1]=35;
headerButtonHeigthsTable[2]=35;
headerButtonHeigthsTable[3]=37;

var headerFontSizeTable=new Array();  // bij de verschillende scales, zet de font van de header
headerFontSizeTable[0]=7;
headerFontSizeTable[1]=12;
headerFontSizeTable[2]=15;
headerFontSizeTable[3]=21;



function printHeader() {
    
    var headerTopHeight = headerHeigthsTable[heightScaleFactor];
    var headerIconsHeight = headerButtonHeigthsTable[heightScaleFactor];
    var headerFontSize = headerFontSizeTable[heightScaleFactor]+"px";
 
    document.getElementById('headerTop').style.height = headerTopHeight+"px";
    document.getElementById('headerNoProTop').style.height = headerTopHeight+"px";
    document.getElementById('headerTopSettings').style.height = headerTopHeight+"px";
    document.getElementById('headerTopSelectTeam').style.height = headerTopHeight+"px";
    document.getElementById('headerTopDepricated').style.height = headerTopHeight+"px";
    document.getElementById('headerTopPremium').style.height = headerTopHeight+"px";
    document.getElementById('headerTopEditGame').style.height = headerTopHeight+"px";
    document.getElementById('headerTopAddMessage').style.height = headerTopHeight+"px";
    document.getElementById('headerTopLogin').style.height = headerTopHeight+"px";
    document.getElementById('headerIcons').style.height = headerIconsHeight+"px";
    document.getElementById('headerNoProIcons').style.height = headerIconsHeight+"px";
    document.getElementById('headerIconsSettings').style.height = headerIconsHeight+"px";
    document.getElementById('headerIconsSelectTeam').style.height = headerIconsHeight+"px";
    document.getElementById('headerIconsDepricated').style.height = headerIconsHeight+"px";
    document.getElementById('headerIconsPremium').style.height = headerIconsHeight+"px";
    document.getElementById('headerIconsEditGame').style.height = headerIconsHeight+"px";
    document.getElementById('headerIconsAddMessage').style.height = headerIconsHeight+"px";
    
    
    // reposition layers
    document.getElementById('headerIcons').style.top = headerTopHeight+"px";
    document.getElementById('headerNoProIcons').style.top = headerTopHeight+"px";
    document.getElementById('headerIconsSettings').style.top = headerTopHeight+"px";
    document.getElementById('headerIconsSelectTeam').style.top = headerTopHeight+"px";
    document.getElementById('headerIconsDepricated').style.top = headerTopHeight+"px";
    document.getElementById('headerIconsPremium').style.top = headerTopHeight+"px";
    document.getElementById('headerIconsEditGame').style.top = headerTopHeight+"px";
    document.getElementById('headerIconsAddMessage').style.top = headerTopHeight+"px";
    document.getElementById('wrapper').style.top = headerTopHeight+headerIconsHeight+"px";
    document.getElementById('loginPageBody').style.top = headerTopHeight+"px";
    document.getElementById('settingsPageBody').style.top = headerTopHeight+headerIconsHeight+"px";
    document.getElementById('selectTeamPageBody').style.top = headerTopHeight+headerIconsHeight+"px";
    document.getElementById('depricatedPageBody').style.top = headerTopHeight+headerIconsHeight+"px";
    document.getElementById('premiumPageBody').style.top = headerTopHeight+headerIconsHeight+"px";
    document.getElementById('editGamePageBody').style.top = headerTopHeight+headerIconsHeight+"px";
    document.getElementById('addMessagePageBody').style.top = headerTopHeight+headerIconsHeight+"px";
    
    //var topp = headerTopHeight+headerIconsHeight;
    //alert(headerIconsHeight);
    
    // change font
    document.getElementById('headerText').style.fontSize = headerFontSize;
    
    // choose icon images
    loadButtonImages();
    iconImageWidth  = iconImagesWidth[widthScaleFactor];
/*
    document.getElementById('buttonProg').width = iconImageWidth;
    document.getElementById('buttonUitsl').width = iconImageWidth;
    document.getElementById('buttonStat').width = iconImageWidth;
    document.getElementById('buttonStand').width = iconImageWidth;
    */
   
    // resize the top buttons (settings and refresh)    
    document.getElementById('headerTopButtons').style.left = pageWidth - 2*headerTopHeight-1+"px";
    document.getElementById('settingsButton').height = headerTopHeight-12;
    document.getElementById('refreshButton').height = headerTopHeight-12;
    
    // move pull-down element
//    var halfPageWidth = pageWidth/2-document.getElementById('pullDownIcon').style.width/2;
    document.getElementById('pullDown').style.width = pageWidth+"px";
//    document.getElementById('pullDownIcon').style.left = halfPageWidth+"px";
    
//    document.getElementById('pullDown').style.left = "400px";
    

    // show all elements
//    document.getElementById('headerTop').style.display = "";
//    document.getElementById('headerTopButtons').style.display = "";
//--    document.getElementById('headerIcons').style.display = "none";
//    document.getElementById('workArea').style.display = "";
    
    // resize errorScreen
    document.getElementById('errorpage').style.left = "50px";
    document.getElementById('errorpage').style.width = (pageWidth-100)+"px";
    
    // resize settingsScreen
    document.getElementById('settingspage').style.left = "0px";
    document.getElementById('settingspage').style.width = pageWidth+"px";
    
    // resize settingsScreen
    document.getElementById('selectTeampage').style.left = "0px";
    document.getElementById('selectTeampage').style.width = pageWidth+"px";
    
    // resize settingsScreen
    document.getElementById('depricatedpage').style.left = "0px";
    document.getElementById('depricatedpage').style.width = pageWidth+"px";
    
    // resize settingsScreen
    document.getElementById('premiumpage').style.left = "0px";
    document.getElementById('premiumpage').style.width = pageWidth+"px";
    
    
    
}

function loadButtonImages(){
    // choose icon images
    var iconImagesPrefixChar = iconImagesPrefix[widthScaleFactor];
    var colorProg = "#555555";
    var colorUitsl = "#555555";
    var colorStat = "#555555";
    var colorStand = "#555555";
    var page = getPage();
    if (page=="prog") colorProg = "#ffffff";
    if (page=="uitsl") colorUitsl = "#ffffff";
    if (page=="stat") colorStat = "#ffffff";
    if (page=="stand") colorStand = "#ffffff";
    document.getElementById('buttonProg').style.color = colorProg;
    document.getElementById('buttonUitsl').style.color = colorUitsl;
    document.getElementById('buttonStat').style.color = colorStat;
    document.getElementById('buttonStand').style.color = colorStand;
    
    if (getUserData()==null){
        //document.getElementById('headerIcons').style.display = "none";
        document.getElementById('settingsButton').style.display = "none";
        document.getElementById('refreshButton').style.display = "none";
        
    }
    else{
        //document.getElementById('headerIcons').style.display = "";
        document.getElementById('settingsButton').style.display = "";
        document.getElementById('refreshButton').style.display = "";
    }
    
}

function onPageResize() {

    getPageSize();
    // bepaal scaleFactor in de hoogte
    heightScaleFactor = 0;
    for (i = 0; i<heightScales.length; i++){
        if (pageHeight>heightScales[i]) heightScaleFactor = i;
    }
    
    // bepaal scaleFactor in de breedte
    widthScaleFactor = 0;
    for (i = 0; i<widthScales.length; i++){
        if (pageWidth>widthScales[i]) widthScaleFactor = i;
    }
    
    // repaint de header
    printSize();
    printHeader();
    refreshData();
}
function getPageSize() {
  if (!fullyLoaded) return;
  var myWidth = 0;
  var myHeight = 0;
  if( typeof( window.innerWidth ) == 'number' ) {
//Non-IE
    myWidth = window.innerWidth;
    myHeight = window.innerHeight;
  } else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
    //IE 6+ in 'standards compliant mode'
    myWidth = document.documentElement.clientWidth;
    myHeight = document.documentElement.clientHeight;
  } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
    //IE 4 compatible
    myWidth = document.body.clientWidth;
    myHeight = document.body.clientHeight;
  }
  pageWidth = myWidth;
  pageHeight = myHeight;
}  

function printSize() {
    document.getElementById('pagesize').innerHTML = pageWidth+"x"+pageHeight+" h:"+heightScaleFactor+"  w:"+widthScaleFactor;
}  


function printCompetitionsInSettings(){
    var compText1 = "";
    var appData = getUserData();
    if (appData==null) return;

    var allUser = false;
    var allTeam = false;
    var singleComp = false;
    var rowIndex = 0;
    
    var colorHeader = "#dbe4c8";
    var color1 = "#ecf4d9";
    var color2 = "#ffffff";
    var color = color1;

   
    
    
    if (appData.foundMultipleTeams){
        allUser = true;
    }
    else if (appData.foundMultipleCompetitions){
        allTeam = true;
    }
    else{
        singleComp = true;
    }
    compText1 += "<table width=100%>";
    
    // single competition
    //var lastCompetitionID = appData.usedCompetitions[0];
    
    for(var index = 0; index < appData.teams.length; index++) {
        var team = appData.teams[index];
        for(var index2 = 0; index2 < team.competitions.length; index2++) {
            rowIndex++;
            color = color1;
            if (rowIndex %2 ==0){
                color = color2;
            }
            
            
            var comp = team.competitions[index2];
            var selected = false;
            
            if (singleComp){
                for (var index3 = 0; index3 < appData.usedCompetitions.length; index3++) {                
                    if (comp.id==appData.usedCompetitions[index3]){
                       selected = true;
                    }
                }
            }
            compText1 += "<tr bgcolor="+color+" onClick='selectCompetition("+comp.id+")'>";
            if (selected){
                compText1 += "<td align=left width=20><img src='check.png'></td>";


            }
            else{
                compText1 += "<td align=left width=20>&nbsp;</td>";
            }
                        
            compText1 += "<td align=left ><br>"+
                        team.teamname+
                        "<br><br></td>";
            compText1 += "<td >&nbsp;&nbsp;</td>";
            compText1 += "<td align=left ><br>"+
                        comp.season+
                        "<br><br></td>";
            compText1 += "<td >&nbsp;&nbsp;</td>";
            compText1 += "<td align=left ><br>"+
                        comp.description+
                        "<br><br></td>";
            compText1 += "</tr>";
        }
    }

    // competitions user (only when there are more then one teams)
    if (appData.teams.length>1){
        rowIndex++;
        color = color1;
        if (rowIndex %2 ==0){
            color = color2;
        }
        
        compText1 += "<tr bgcolor="+color+" onClick='selectCompetitionAllFromUser()'>";
        if (allUser){
            compText1 += "<td align=left width=20><img src='check.png'><br></td>";
        }
        else{
            compText1 += "<td align=left width=20>&nbsp;</td>";
        }
        compText1 += "<td align=left colspan=99>"+
                    "<br>Alle wedstrijden van "+appData.username+"<br><br>"+
                    "</td></tr>";
        
                    
        
    }

    // competitions teams
    for(var index = 0; index < appData.teams.length; index++) {
        var team = appData.teams[index];
        if (team.competitions.length>1){
            rowIndex++;
            color = color1;
            if (rowIndex %2 ==0){
                color = color2;
            }
            
            var selected = false;
            if (allTeam){
                for (var index2 = 0; index2 < appData.usedTeams.length; index2++) {                
                    if (team.id==appData.usedTeams[index2]){
                       selected = true;
                    }
                }
            } 
            compText1 += "<tr bgcolor="+color+" onClick='selectCompetitionAllFromTeam("+team.id+")'>";
            if (selected){
                compText1 += "<td align=left width=20><img src='check.png'></td>";
            }
            else{
                compText1 += "<td align=left width=20>&nbsp;</td>";
            }
            compText1 += "<td align=left colspan=99>"+
                        "<br>Alle wedstrijden van "+team.teamname+"<br><br>"+
                        "</td></tr>";
        }
    }

    compText1 += "</table>";
    
    document.getElementById('selectCompetitionsText1').innerHTML = ""+compText1+"";
    document.getElementById('endDatePro').innerHTML = appData.proEndDate;
    
    if (hasPremiumAccount()){
        document.getElementById('hasPremiumAccount').innerHTML = "ja";
        
    }
    else{
        document.getElementById('hasPremiumAccount').innerHTML = "nog niet";
    } 

    if (getPlatform()=="Android"){
        if (hasPremiumAccount()){
            document.getElementById('wordtPremiumKnopAndroid').style.display = "none";
            document.getElementById('verlengPremiumKnopAndroid').style.display = "";
            document.getElementById('wordtPremiumBrowser').style.display = "none";
            
        }
        else{
            document.getElementById('wordtPremiumKnopAndroid').style.display = "";
            document.getElementById('verlengPremiumKnopAndroid').style.display = "none";
            document.getElementById('wordtPremiumBrowser').style.display = "none";
        }
    }
    else{
        if (hasPremiumAccount()){
            document.getElementById('wordtPremiumKnopAndroid').style.display = "none";
            document.getElementById('verlengPremiumKnopAndroid').style.display = "none";
            document.getElementById('wordtPremiumBrowser').style.display = "none";
            
        }
        else{
            document.getElementById('wordtPremiumKnopAndroid').style.display = "none";
            document.getElementById('verlengPremiumKnopAndroid').style.display = "none";
            document.getElementById('wordtPremiumBrowser').style.display = "";
        }
    } 
    
    
}

function printCurrentCompetitionHeader(){
    var appData = getUserData();

    var teamname = "";
    var competition = "";

    if (appData==null){
        document.getElementById('headerText').innerHTML = "";
        return;
    }
    
    
    
    if (appData.foundMultipleTeams){
        teamname = appData.username;
        competition = "Alle competities";
    }
    else if (appData.foundMultipleCompetitions){
        competition = "Alle competities";
        competition = "Alle competities";
        for(var index = 0; index < appData.teams.length; index++) {
            var team = appData.teams[index];
            for(var index2 = 0; index2 < team.competitions.length; index2++) {
                var comp = team.competitions[index2];
                 if (comp.id==appData.usedCompetitions[0]){
                    teamname = team.teamname;
                }
            }
        }
        
    }
    else if (appData.foundCompetitions){
        competition = "Alle competities";
        for(var index = 0; index < appData.teams.length; index++) {
            var team = appData.teams[index];
            for(var index2 = 0; index2 < team.competitions.length; index2++) {
                var comp = team.competitions[index2];
                 if (comp.id==appData.usedCompetitions[0]){
                    teamname = team.teamname;
                    var season = comp.season;
                    var description = comp.description;
                    competition = season+"-"+description;
                }
            }
        }
    }
    else{
        teamname = "Geen teams";
        competition = "Geen competities";
    }
    document.getElementById('headerText').innerHTML = teamname+"<br>"+competition;
/*
    if (appData.usedCompetitionData.competition.mCompetition==0){
        document.getElementById('buttonStand').style.display = "none";
    }
    else{
        document.getElementById('buttonStand').style.display = "";
    }
*/    
}
