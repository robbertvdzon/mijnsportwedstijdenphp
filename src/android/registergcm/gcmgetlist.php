<?

include_once ("../../platform/platformsettings.php");
include_once ("../../database.php");

if (isset($_GET['app'])) {
    $app = $_GET['app'];

    global $conn;
    $array = array();
    $query = "SELECT * FROM gcmclients where application='$app'";
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    while ($i < $num) {
        $regid = mysql_result($result, $i, "regid");
        $applicationData = mysql_result($result, $i, "applicationData");
        echo $regid."\t".$applicationData."\n"; 
        $i++;
     }
  }
?>
