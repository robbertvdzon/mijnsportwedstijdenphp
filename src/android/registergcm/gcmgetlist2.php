<?

include_once ("../../platform/platformsettings.php");
include_once ("../../database.php");


    global $conn;
    $array = array();
    $query = "SELECT * FROM gcmclients";
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    while ($i < $num) {
        $regid = mysql_result($result, $i, "regid");
        $applicationData = mysql_result($result, $i, "applicationData");
        $app = mysql_result($result, $i, "application");
        $registrationdate = mysql_result($result, $i, "registrationdate");
        $regid = substr($regid,0,20);
        echo $regid."&nbsp;&nbsp;".$applicationData."&nbsp;&nbsp;".$app."&nbsp;&nbsp;".$registrationdate."<br>"; 
        $i++;
     }
?>
