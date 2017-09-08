
function getURLBase(){
//    return "http://192.168.178.29";
    return "http://www.mijnsportwedstrijden.nl";
//    return "http://localhost";   
}

function getPlatform(){
    var OSName=navigator.appVersion;
    if (navigator.appVersion.indexOf("Win")!=-1) OSName="Windows";
    if (navigator.appVersion.indexOf("Mac")!=-1) OSName="MacOS";
    if (navigator.appVersion.indexOf("X11")!=-1) OSName="UNIX";
    if (navigator.appVersion.indexOf("Linux")!=-1) OSName="Linux";    
    if (navigator.appVersion.indexOf("Android")!=-1) OSName="Android";    
    if (navigator.appVersion.indexOf("iPhone")!=-1) OSName="iPhone";        
    if (navigator.appVersion.indexOf("iPad")!=-1) OSName="iPad";        
    return OSName;
}
