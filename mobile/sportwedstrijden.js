var fullyLoaded = false;
var usePhoneGap = false;

function initialize() {
    fullyLoaded = true;
    onPageResize();
    
    var username=getCookie("username");
    var passwd=getCookie("passwd");
    
    if (username!=null && username!="")
    {
    }
    else{
        username = window.localStorage.getItem("username");
        passwd = window.localStorage.getItem("passwd");
    }

    // register back button handler
    document.addEventListener("backbutton", backButtonPressed, false);
    document.addEventListener("menubutton", menuButtonPressed, false);
 
       
    setCurrentUsername(username);
    setCurrentPasswd(passwd);
    
    testLogin(true);
}

function testProUser(){
    if (hasPremiumAccount()) return;
    throw new Error("NOPROERROR");
}


function backButtonPressed() { 
    // check if there is an error op, close that is that is open
    if (document.getElementById('errorpage').style.display == ""){
        hideGlobalError();
    }
    else if (document.getElementById('noPropage').style.display == ""){
        hideNoProError();
    }
    else{
        // no error page is open, check normal pages
        var page = getPage();
        if (page=="settings") {
            hideSettings();
        }
        else if (page=="selectTeam") {
            hideSelectTeam();
        }
        else if (page=="premium") {
            hidePremium();
        }
        else if (page=="game"){ 
            hideGame();
        } 
        else if (page=="addmessage"){ 
            hideAddMessage();
        }
        else if (page=="editgame"){ 
            hideEditGame();
        }
        else if (page=="mgamespage"){
            hideMGames();
        }
        else if (page=="stat2"){
            selectStat();
        }
        else{
            device.exitApp();
        }
    } 
     
}

function menuButtonPressed() { 
     // Call my back key code here.
    openSettings();
}
function testLogin(autologin){
    var username = getCurrentUsername();
    var passwd = getCurrentPasswd();
    var JSONObject = new Object;
    JSONObject.request = "getMobileAppData";
    if (username==null) username = "";
    JSONObject.username=username;
    if (hasPremiumAccount()){
        JSONObject.proApp="premium";
    }
    else{
        JSONObject.proApp="free";
    }
    JSONObject.platform=getPlatform();
    JSONObject.version=getVersion();
    JSONObject.firstCall=true;
    firstCall = false;
    if (passwd==null) passwd = "";
    JSONObject.passwd=calcMD5(passwd);
    JSONObject.requestedCompetitionID = getLastUsedCompetitionID(); 
    JSONObject.requestedTeamID = getLastUsedTeamID();
    setUsername(username);
    runAjax(JSONObject, function onSuccess(resultJSON) {
        //alert(resultJSON.result.userID);
        if (resultJSON.result!=null){
            var appData = resultJSON.result;
            saveUserData(appData);
            refreshData();
            openFirstPage();
        }
        else{
            if (!autologin){
                document.getElementById('loginError').innerHTML = 
                "<font color=red>Ongeldige gebruikersnaam of wachtwoord</font>";
            }
            openLogin();
        }
//        alert(resultJSON.result);
    }, function onError(resultJSON) {
        showGlobalError("Fout bij user check "+resultJSON.errorMsg);
    }, false);
}


function selectCompetitionAllFromTeam(teamID){
    saveLastUsedCompetitionID(0);    
    saveLastUsedTeamID(teamID);    
    hideSettings();
    showCurrentPage();
    testLogin(false);
}
function selectCompetitionAllFromUser(){
    saveLastUsedCompetitionID(0);    
    saveLastUsedTeamID(0);    
    hideSettings();
    showCurrentPage();
    testLogin(false);
}

function selectCompetition(compID){
    saveLastUsedCompetitionID(compID);    
    saveLastUsedTeamID(0);    
    //setCurrentCompetition(compID);      
    hideSettings();
    showCurrentPage();
    testLogin(false);
}

function phonegapReady(){
    usePhoneGap = true;
    initialize();
}


function login(){
    username = document.getElementById('usernameField').value;
    passwd = document.getElementById('passwdField').value;
        document.getElementById('logpage').innerHTML = "save " + username;
    setCookie("username",username,36500);
    setCookie("passwd",passwd,36500);
    window.localStorage.setItem("username", username);
    window.localStorage.setItem("passwd", passwd);    
    document.getElementById('logpage').innerHTML = "saved " + username;
    
    setCurrentUsername(username);
    setCurrentPasswd(passwd);
    testLogin(false);    
}

var prevPage = "";
function openSettings(){
    if (getUserData()==null) return;// settings cannot be opened without being logged in
    prevPage = getPage(); 
    setPage("settings");
    loadButtonImages();
    showCurrentPage();
}

function hideSettings(){
    setPage(prevPage);
    loadButtonImages();
    showCurrentPage();
}

function openSelectTeam(){
    if (getUserData()==null) return;// settings cannot be opened without being logged in
    prevPage = getPage(); 
    setPage("selectTeam");
    loadButtonImages();
    showCurrentPage();
}

function hideSelectTeam(){
    setPage(prevPage);
    loadButtonImages();
    showCurrentPage();
}

function openDepricated(){
    if (getUserData()==null) return;// settings cannot be opened without being logged in
    prevPage = getPage(); 
    setPage("depricated");
    loadButtonImages();
    showCurrentPage();
}

function openPremium(){
    hideNoProError();
    if (getUserData()==null) return;// settings cannot be opened without being logged in
    setPage("premium");
    loadButtonImages();
    showCurrentPage();
}

function hidePremium(){
    setPage("settings");
    loadButtonImages();
    showCurrentPage();
}

function openGame(gameID){
    setCurrentGameID(gameID);
    setPage("game");
    loadButtonImages();
    showCurrentPage();
}

function hideGame(){
    setPage(getCurrentMode());
    loadButtonImages();
    showCurrentPage();
}

function openEditGame(){
    try{
        testProUser();
        setPage("editgame");
        loadButtonImages();
        showCurrentPage();
    }
    catch(err){
        showGlobalError(err);
    }     
}

function hideEditGame(){
    setPage("game");
    loadButtonImages();
    showCurrentPage();
}

function openAddMessage(){
    try{
        testProUser();
        document.getElementById('newGameMessageTextArea').value = "";
        
        setPage("addmessage");
        loadButtonImages();
        showCurrentPage();
    }
    catch(err){
        showGlobalError(err);
    }     
}

function hideAddMessage(){
    setPage("game");
    loadButtonImages();
    showCurrentPage();
}

function openMGames(){
    try{
        testProUser();
        setPage("mgamespage");
        showCurrentPage();
    }
    catch(err){
        showGlobalError(err);
    }     
}

function hideMGames(){
    setPage("stand");
    showCurrentPage();
}



function logoff(){
    setCookie("username","",36500);
    window.localStorage.setItem("username", "");
    setCurrentUsername("");
    setCurrentPasswd("");
    saveUserData(null);
    testLogin(true);
    hideSettings();
    printCurrentCompetitionHeader();        
}



function openFirstPage(){
    var showDepricatedPage = false;
    
    if (showDepricatedPage){
        openDepricated();
        return;
    }
    
    var page = getStartPage();
    if (page==null || page==""){
        page = "prog";
    }
    setCurrentMode(page);
    setPage(page);
    loadButtonImages();
    showCurrentPage();
    
}

function openLogin(){
    setPage("login");
    loadButtonImages();
    showCurrentPage();
}


function selectStand(){
    try{
        testProUser();
        setCurrentMode("stand");
        setPage("stand");
        loadButtonImages();
        showCurrentPage();
        saveStartPage("stand");
    }
    catch(err){
        showGlobalError(err);
    }     
}
function selectStat(){
    try{
        testProUser();
        setCurrentMode("stat");
        setPage("stat");
        loadButtonImages();
        showCurrentPage();
        saveStartPage("stat");
    }
    catch(err){
        showGlobalError(err);
    }     
}
function selectStat2(){
    try{
        testProUser();
        setCurrentMode("stat2");
        setPage("stat2");
        loadButtonImages();
        showCurrentPage();
    }
    catch(err){
        showGlobalError(err);
    }     
}

function selectUitsl(){
    try{
        testProUser();
        setCurrentMode("uitsl");
        setPage("uitsl");
        loadButtonImages();
        showCurrentPage();
        saveStartPage("uitsl");
    }
    catch(err){
        showGlobalError(err);
    }     
}
function selectProg(){
    try{
        setCurrentMode("prog");
        setPage("prog");
        loadButtonImages();
        showCurrentPage();
        saveStartPage("prog");
    }
    catch(err){
        showGlobalError(err);
        
    }     
}

function resetScrollerWidth(){
    document.getElementById('scroller').style.width = "2000px";
} 

function enlargeTablesIfNeeded(newWidth){
    try{
        var widthElementName = "";
        //alert(page); 
        if (page=="") return;
        if (page=="log") widthElementName = "spaceleft_log";
        if (page=="prog") {
            // check if table is smaller then screen
            var diff = pageWidth-document.getElementById('table_prog').clientWidth;
            if (diff>0){
                // table is smaller, change to pagewidth
                document.getElementById('table_prog').style.width = pageWidth+"px";
                var halfDiff = (diff/2)-5;
                document.getElementById('spaceleft_prog').style.width = halfDiff+"px";
                document.getElementById('spaceright_prog').style.width = halfDiff+"px";
            }
            
            // check if table is height enough (if not, then the pull-down refresh will not work!)
            document.getElementById('progData').style.height = "100%";
            if (document.getElementById('progData').clientHeight<pageHeight){
                document.getElementById('progData').style.height = pageHeight+"px";
            }
        }
            
        if (page=="uitsl") {
            // check if table is smaller then screen
            var diff = pageWidth-document.getElementById('table_uitsl').clientWidth;
            if (diff>0){
                // table is smaller, change to pagewidth
                document.getElementById('table_uitsl').style.width = pageWidth+"px";
                var halfDiff = (diff/2)-5;
                document.getElementById('spaceleft_uitsl').style.width = halfDiff+"px";
                document.getElementById('spaceright_uitsl').style.width = halfDiff+"px";
            }
            // check if table is height enough (if not, then the pull-down refresh will not work!)
            document.getElementById('uitslData').style.height = "100%";
            if (document.getElementById('uitslData').clientHeight<pageHeight){
                document.getElementById('uitslData').style.height = pageHeight+"px";
            }
        }
        if (page=="stat") {
            // check if table is smaller then screen
            var diff = pageWidth-document.getElementById('table_stat').clientWidth;
            if (diff>0){
                // table is smaller, change to pagewidth
                document.getElementById('table_stat').style.width = pageWidth+"px";
                var halfDiff = (diff/2)-5;
                document.getElementById('spaceleft_stat').style.width = halfDiff+"px";
                document.getElementById('spaceright_stat').style.width = halfDiff+"px";
                
            }
            // check if table is height enough (if not, then the pull-down refresh will not work!)
            document.getElementById('statData').style.height = "100%";
            if (document.getElementById('statData').clientHeight<pageHeight){
                document.getElementById('statData').style.height = pageHeight+"px";
            }
        }
        if (page=="stat2") {
            // check if table is height enough (if not, then the pull-down refresh will not work!)
            document.getElementById('stat2Data').style.height = "100%";
            if (document.getElementById('stat2Data').clientHeight<pageHeight){
                document.getElementById('stat2Data').style.height = pageHeight+"px";
            }
        }
        if (page=="stand") {
            // check if table is height enough (if not, then the pull-down refresh will not work!)
            document.getElementById('standData').style.height = "100%";
            if (document.getElementById('standData').clientHeight<pageHeight){
                document.getElementById('standData').style.height = pageHeight+"px";
            }
        }
        if (page=="login") {
        }
        if (page=="settings") {
            // check if table is height enough (if not, then the pull-down refresh will not work!)
            document.getElementById('settingsData').style.height = "100%";
            if (document.getElementById('settingsData').clientHeight<pageHeight){
                document.getElementById('settingsData').style.height = pageHeight+"px";
            }
        }
        if (page=="selectTeam") {
            // check if table is height enough (if not, then the pull-down refresh will not work!)
            document.getElementById('selectTeamData').style.height = "100%";
            if (document.getElementById('selectTeamData').clientHeight<pageHeight){
                document.getElementById('selectTeamData').style.height = pageHeight+"px";
            }
        }
        if (page=="depricated") {
            // check if table is height enough (if not, then the pull-down refresh will not work!)
            document.getElementById('depricatedData').style.height = "100%";
            if (document.getElementById('depricatedData').clientHeight<pageHeight){
                document.getElementById('depricatedData').style.height = pageHeight+"px";
            }
        }
        if (page=="premium") {
            // check if table is height enough (if not, then the pull-down refresh will not work!)
            document.getElementById('premiumData').style.height = "100%";
            if (document.getElementById('premiumData').clientHeight<pageHeight){
                document.getElementById('premiumData').style.height = pageHeight+"px";
            }
        }
        if (page=="game") {
            // check if table is smaller then screen
            var tableWidth = pageWidth-document.getElementById('table_game').clientWidth;
            if (tableWidth<400){
                document.getElementById('table_game').style.width = "400px";
                myScroll.refresh();
            }
            if (tableWidth>1000){
                document.getElementById('table_game').style.width = "1000px";
                myScroll.refresh();
            }
/*
            if (diff<0){
                var colSize = document.getElementById('table_game').clientWidth;
                var newSize = colSize + diff;
                // table is smaller, change to pagewidth
            }
  */          
            // check if table is height enough (if not, then the pull-down refresh will not work!)
//                var newHeight = pageHeight+10;
            document.getElementById('gameData').style.height = "100%";
            var currentPageHeight = document.getElementById('gameData').clientHeight;
//            alert("pageHeight="+pageHeight+",currentPageHeight="+currentPageHeight);
            if (currentPageHeight<pageHeight){
                var newHeight = pageHeight+100;
//                alert("newHeight="+newHeight);
                document.getElementById('gameData').style.height = newHeight+"px";
            }
        }
        if (page=="editgame") {
        }
        if (page=="addmessage") {
        }
        if (page=="mgamespage") {
            // check if table is height enough (if not, then the pull-down refresh will not work!)
            document.getElementById('mgamesData').style.height = "100%";
            if (document.getElementById('mgamesData').clientHeight<pageHeight){
                document.getElementById('mgamesData').style.height = pageHeight+"px";
            }
        }
        

        //document.getElementById('scroller').style.width = "100%";
        //alert(document.getElementById('scroller').clientWidth);
        //alert(pageWidth);

/*
        alert("page="+pageWidth+"  table="+newWidth+"  tdWidthLeft="+tdWidthLeft+"  "+widthElementName);
        test.style.width="500px";
        var tdWidthLeft = test.clientWidth;
        alert("page="+pageWidth+"  table="+newWidth+"  tdWidthLeft="+tdWidthLeft+"  "+widthElementName);
*/        
    }
    catch(errr){
        alert("error:"+errr);
    }     
}


function setScrollerWidth(){
    try{       
        var widthElementName = "";
        //alert(page); 
        if (page=="") return;
        if (page=="log") widthElementName = "pagewidth_prog";
        if (page=="prog") widthElementName = "pagewidth_prog";
        if (page=="uitsl") widthElementName = "pagewidth_uitsl";
        if (page=="stat") widthElementName = "pagewidth_stat";
        if (page=="stat2") widthElementName = "pagewidth_stat2";
        if (page=="stand") widthElementName = "pagewidth_stand";
//        if (page=="login") widthElementName = "pagewidth_login";
//        if (page=="settings") widthElementName = "pagewidth_settings";
        if (page=="game") widthElementName = "pagewidth_game";
//        if (page=="editgame") widthElementName = "pagewidth_editgame";
//        if (page=="addmessage") widthElementName = "pagewidth_addmassage";
        if (page=="mgamespage") widthElementName = "pagewidth_mgames";
        
        if (widthElementName=="") {
            document.getElementById('scroller').style.width = "10px";
            myScroll.refresh();
            return;
        }
    
    
        var test = document.getElementById(widthElementName);
        var newWidth = test.clientWidth+30;
        document.getElementById('scroller').style.width = newWidth+"px";
        
        //alert(newWidth);
        myScroll.refresh();
        
        enlargeTablesIfNeeded(newWidth);
        
    }
    catch(errr){
        alert("error:"+errr);
    }     
}

function refresh(){
    
//    showGlobalError("test");
    setScrollerWidth();
    var username = getCurrentUsername();
    var passwd = getCurrentPasswd();
    var JSONObject = new Object;
    JSONObject.request = "getMobileAppData";
    if (username==null) username = "";
    JSONObject.username=username;
    if (hasPremiumAccount()){
        JSONObject.proApp="pro";
    }
    else{
        JSONObject.proApp="free";
    }
    JSONObject.platform=getPlatform();
    JSONObject.version=getVersion();
    JSONObject.firstCall=false;
    if (passwd==null) passwd = "";
    JSONObject.passwd=calcMD5(passwd);
    JSONObject.requestedCompetitionID = getLastUsedCompetitionID(); 
    JSONObject.requestedTeamID = getLastUsedTeamID();
    setUsername(username);
    runAjax(JSONObject, function onSuccess(resultJSON) {
        //alert(resultJSON.result.userID);
        if (resultJSON.result!=null){
            var appData = resultJSON.result;
            saveUserData(appData);
            
            refreshData();
            
        }
        else{
            document.getElementById('loginError').innerHTML = 
            "<font color=red>Ongeldige gebruikersnaam of wachtwoord</font>";
            openLogin();
        }
//        alert(resultJSON.result);
    }, function onError(resultJSON) {
        showGlobalError("Fout bij user check "+resultJSON.errorMsg);
    }, false);
}


function refreshData(){
    var appData = getUserData();
    var proUser = "";      
    if (hasPremiumAccount()){
        proUser = "(premium)";
        // disable ad's
        try{
            window.disableAds(function() { },function(error) {});        
        } catch(err) {
        }              
    }
    if (appData!=null) document.getElementById('currentUsername').innerHTML = appData.username+" "+proUser ;
    printCompetitionsInSettings();
    printCurrentCompetitionHeader();
    
    
    if (page=="prog") loadProgData();
    if (page=="uitsl") loadUitslData();
    if (page=="stat") loadStatData();
    if (page=="stand") loadStandData();
    if (page=="game") {
        if (getCurrentMode()=="prog") loadProgData();
        if (getCurrentMode()=="uitsl") loadUitslData();
        if (getCurrentMode()=="stat") loadStatData();
    }
    setScrollerWidth();
    myScroll.refresh();
    
}

function showCurrentPage(){
    var MAIN_BUTTONS = 0;
    var GAME_BUTTONS = 1;
    var STAT2_BUTTONS = 2;
    var MGAMES_BUTTONS = 3;
    var buttons=MAIN_BUTTONS; 


    document.getElementById('progpage').style.display = "none";
    document.getElementById('uitslpage').style.display = "none";
    document.getElementById('statpage').style.display = "none";
    document.getElementById('stat2page').style.display = "none";
    document.getElementById('standpage').style.display = "none";
    document.getElementById('loginpage').style.display = "none";
    document.getElementById('settingspage').style.display = "none";
    document.getElementById('selectTeampage').style.display = "none";
    document.getElementById('depricatedpage').style.display = "none";
    document.getElementById('premiumpage').style.display = "none";
    document.getElementById('gamepage').style.display = "none";
    document.getElementById('editgamepage').style.display = "none";
    document.getElementById('addMessagepage').style.display = "none";
    document.getElementById('mgamespage').style.display = "none";
    
    
    var page = getPage();
    var hideScrollPane = false;
    resetScrollerWidth();
    

    if (page=="prog") loadProgData();
    if (page=="uitsl") loadUitslData();
    if (page=="stat") loadStatData();
    if (page=="stand") loadStandData();
    if (page=="game") loadGameData();
    
    if (page=="prog") document.getElementById('progpage').style.display = "";
    if (page=="uitsl") document.getElementById('uitslpage').style.display = "";
    if (page=="stat") document.getElementById('statpage').style.display = "";
    if (page=="stat2") {
        buttons=STAT2_BUTTONS;
        document.getElementById('stat2page').style.display = "";
    }
    if (page=="stand") document.getElementById('standpage').style.display = "";
    if (page=="login") {
        hideScrollPane = true;
        document.getElementById('loginpage').style.display = "";
    }
    if (page=="settings") {
        hideScrollPane = true;
        document.getElementById('settingspage').style.display = "";
    }
    if (page=="selectTeam") { 
        hideScrollPane = true;
        document.getElementById('selectTeampage').style.display = "";
    }
    if (page=="depricated") { 
        hideScrollPane = true;
        document.getElementById('depricatedpage').style.display = "";
    }
    if (page=="premium") { 
        hideScrollPane = true;
        document.getElementById('premiumpage').style.display = "";
    }
    if (page=="game") {
        buttons=GAME_BUTTONS; 
        document.getElementById('gamepage').style.display = "";
    }
    if (page=="editgame") {
        hideScrollPane = true;
        document.getElementById('editgamepage').style.display = "";
    }
    if (page=="addmessage") {
        hideScrollPane = true;
        document.getElementById('addMessagepage').style.display = "";
    }
    if (page=="mgamespage") {
        buttons=MGAMES_BUTTONS;
        document.getElementById('mgamespage').style.display = "";
    }


    // show or hide the workarea
    if (hideScrollPane){
        document.getElementById('workArea').style.display = "none";
        document.getElementById('headerTop').style.display = "none";
        document.getElementById('headerTopButtons').style.display = "none";
        document.getElementById('headerIcons').style.display = "none";
    } else{
        document.getElementById('workArea').style.display = "";
        document.getElementById('headerTop').style.display = "";
        document.getElementById('headerTopButtons').style.display = "";
        document.getElementById('headerIcons').style.display = "";
    }
    
    
    if (buttons==MAIN_BUTTONS){
        document.getElementById('mainButtons').style.display = "";
        document.getElementById('gameButtons').style.display = "none";
        document.getElementById('stat2Buttons').style.display = "none";
        document.getElementById('mgamesButtons').style.display = "none";
    }
    if (buttons==GAME_BUTTONS){
        document.getElementById('mainButtons').style.display = "none";
        document.getElementById('gameButtons').style.display = "";
        document.getElementById('stat2Buttons').style.display = "none";
        document.getElementById('mgamesButtons').style.display = "none";
    }
    if (buttons==STAT2_BUTTONS){
        document.getElementById('mainButtons').style.display = "none";
        document.getElementById('gameButtons').style.display = "none";
        document.getElementById('stat2Buttons').style.display = "";
        document.getElementById('mgamesButtons').style.display = "none";
    }
    if (buttons==MGAMES_BUTTONS){
        document.getElementById('mainButtons').style.display = "none";
        document.getElementById('gameButtons').style.display = "none";
        document.getElementById('stat2Buttons').style.display = "none";
        document.getElementById('mgamesButtons').style.display = "";
    }
    
    
    setScrollerWidth();
    myScroll.refresh();
    
    
}

function gamePrev(){
    var games = getUserData().foundGames;

    var currentID = getCurrentGameID();
    var nextID=currentID;
    var nextIndex=-1;
    for(var index = 0; index < games.length; index++) {
        var game = games[index];
        if (game.id==currentID){
            nextIndex = index-1;
        }
    }
    if (nextIndex>=0 && nextIndex<games.length){
        nextID = games[nextIndex].id;
    } 
    openGame(nextID);
}

function gameNext(){
    var games = getUserData().foundGames;

    var currentID = getCurrentGameID();
    var nextID=currentID;
    var nextIndex=-1;
    for(var index = 0; index < games.length; index++) {
        var game = games[index];
        if (game.id==currentID){
            nextIndex = index+1;
        }
    }
    if (nextIndex>=0 && nextIndex<games.length){
        nextID = games[nextIndex].id;
    } 
    openGame(nextID);
}

