var page = "";
var scrollXPositions = new Array();
var scrollYPositions = new Array();

function savePagePosition(page){
    scrollXPositions[page] = myScroll.getScrollX();
    scrollYPositions[page] = myScroll.getScrollY();
}

function restorePagePosition(page){
    try{
        var x = scrollXPositions[page];
        var y = scrollYPositions[page];
        myScroll.scrollTo(x,y,10,false);
    }
    catch(err){
    }
}
function getPage(){
    return page;
}


function setPage(_page){
    savePagePosition(page);
    page = _page;
    restorePagePosition(page)
}

function saveStartPage(_page){
    setCookie("startPage",_page,36500);
    window.localStorage.setItem("startPage", _page);
}

function getStartPage(){
    var startPage=getCookie("startPage");
    if (startPage==null || startPage==""){
        startPage = window.localStorage.getItem("startPage");
    }
    return startPage;
}

function saveLastUsedCompetitionID(_lastUsedCompetitionID){
    setCookie("lastUsedCompetitionID",_lastUsedCompetitionID,36500);
    window.localStorage.setItem("lastUsedCompetitionID", _lastUsedCompetitionID);
}

function getLastUsedCompetitionID(){
    var lastUsedCompetitionID=getCookie("lastUsedCompetitionID");
    if (lastUsedCompetitionID==null || lastUsedCompetitionID==""){
        lastUsedCompetitionID = window.localStorage.getItem("lastUsedCompetitionID");
    }
    if (lastUsedCompetitionID==null) return 0;
    if (lastUsedCompetitionID=="null") return 0;
    return lastUsedCompetitionID;
}


function saveLastUsedTeamID(_lastUsedTeamID){
    setCookie("lastUsedTeamID",_lastUsedTeamID,36500);
    window.localStorage.setItem("lastUsedTeamID", _lastUsedTeamID);
}

function getLastUsedTeamID(){
    var lastUsedTeamID=getCookie("lastUsedTeamID");
    if (lastUsedTeamID==null || lastUsedTeamID==""){
        lastUsedTeamID = window.localStorage.getItem("lastUsedTeamID");
    }
    if (lastUsedTeamID==null) return 0;
    if (lastUsedTeamID=="null") return 0;
    return lastUsedTeamID;
}

var userData = null;
function saveUserData(_userData){
//    alert(_userData.proUser+":"+_userData.proEndDate);
//    alert(JSON.stringify(_userData));
    userData = _userData;
}

function getUserData(){
    return userData;
}


var username = null;
function setCurrentUsername(_username){
    username = _username;
}

function getCurrentUsername(){
    return username;
}

var passwd = null;
function setCurrentPasswd(_passwd){
    passwd = _passwd;
}

function getCurrentPasswd(){
    return passwd;
}


var gameID = null;
function setCurrentGameID(_gameID){
    gameID = _gameID;
}

function getCurrentGameID(){
    return gameID;
}

var currentMode = null;
function setCurrentMode(_currentMode){
    currentMode = _currentMode;
}

function getCurrentMode(){
    return currentMode;
}

var username ="";
function getUsername(){
    return username;
}
function setUsername(_username){
    username = _username;
}