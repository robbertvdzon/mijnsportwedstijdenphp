<?
$conn=mysql_connect("localhost", "root", "luttikcie teamsport");
mysql_select_db('wind', $conn) or die(mysql_error());

$day=$_GET["day"];
$lastmodified=$_GET["lastmodified"];


$sth = mysql_query("select wind as w, gust as g, angle as a, day as d, hour as h2, minute as m2, starthour as h1, startminute as m1, lastModified as t, spotid as s from wind where day=$day and lastModified>=$lastmodified and wind>=0 and gust>=0 and angle>=0");

$rows = array();
while($r = mysql_fetch_assoc($sth)) {
    $rows[] = $r;
}
print "{   \"values\":";
print json_encode($rows);
print "}";

?>