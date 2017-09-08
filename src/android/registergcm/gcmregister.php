<?
include_once ("../../platform/platformsettings.php");
include_once ("../../database.php");


if (isset($_GET['key']) && isset($_GET['app']) && isset($_GET['data'])) {
    $key = $_GET['key'];
    $app = $_GET['app'];
    $data = $_GET['data'];
    echo "key=".$key."<br>";
    echo "app=".$app."<br>";
    echo "data=".$data."<br>";
    
    $q = "select id from gcmclients where regid = '$key' and application = '$app'";
    $result = mysql_query($q, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    
    echo "found:=".mysql_numrows($result);
    if (mysql_numrows($result) == 0){
        $q = "INSERT INTO gcmclients (`regid`,`application`,`applicationData`,registrationdate) VALUES ('$key','$app','$data',NOW())";
    
        $res = mysql_query($q, $conn);
        if (mysql_errno()) {
            throw new \Exception(mysql_error());
        }
        $id = mysql_insert_id();
        echo "id=".$id;
    }
    else{
        $q = "update gcmclients set registrationdate=NOW() where regid = '$key' and application = '$app'";
        $res = mysql_query($q, $conn);
    
        
    }

    
    
}
?>
