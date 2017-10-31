<?
include_once ("request-cron.php");
include_once ("request-demodata.php");
include_once ("request-connectteam.php");
include_once ("database.php");
include_once ("platform/platformsettings.php");

echo "Run php cron\n";
echo "Send email\n";
echo cron\callCron();

echo "Generate demodata\n";
demodata\removeDemodata();
#demodata\generateDemodata();

echo "Clean log tabel\n";
cleanLogTable();

echo "Sycn all managed competitions\n";
connectteam\syncAllManagedCompetitions();

echo "Cleanup the database (remove orphan records)\n";
dbcalls\clearOrphanData();


/**************************************************
 */
function cleanLogTable() {
    global $conn;
    $array = array();
    $query = "DELETE FROM log where date<DATE_SUB(CURDATE(),INTERVAL 60 DAY)";
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
}



?>