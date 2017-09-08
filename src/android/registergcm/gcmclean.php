<?
include_once ("../../platform/platformsettings.php");
include_once ("../../database.php");


$q = "DELETE FROM `gcmclients` WHERE Date(registrationdate) < DATE_SUB(CURDATE(), INTERVAL 2 DAY)";
$result = mysql_query($q, $conn);
echo "finished";
?>
