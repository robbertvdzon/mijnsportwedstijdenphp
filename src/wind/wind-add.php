<?
/* Include Files *********************/
        echo "stap 1..";
/**
 * Connect to the mysql database.
 * http://www.mijnsportwedstrijden.nl/wind/wind-add.php?id=2&date=10/12/2013&time=13.12&wind=10.2&gust=15.6
 */
$conn=mysql_connect("localhost", "root", "luttikcie teamsport");
        echo "stap 2..";
mysql_select_db('wind', $conn) or die(mysql_error());

        echo "stap 3..";

$spotID=$_GET["id"];
$day=$_GET["day"];
$hour=$_GET["hour"];
$minute=$_GET["minute"];
$starthour=$_GET["starthour"];
$startminute=$_GET["startminute"];
$wind=$_GET["wind"];
$gust=$_GET["gust"];
$updatetime=round(microtime(true) * 1000);

echo "find prev record";

    global $conn;
    $q = "select id from wind where spotid=".$spotID." and day = ".$day." and hour=".$hour." and minute=".$minute;
	echo "<br><br>sql=".$q."<br><br>";
    $res = mysql_query($q, $conn);
    $num = mysql_numrows($res);
    if ($num > 0){
    	// update this record
		echo "record is found";
	    $id = mysql_result($res, 0);
		$q = "UPDATE wind SET wind=".$wind.", gust=".$gust." , lastModified=".$updatetime." WHERE id=".$id;
		echo "<br><br>sql=".$q."<br><br>";
		$result = mysql_query($q, $conn);
		if (mysql_errno()) {
			echo "error:".mysql_error();
		}
    }
    else{
    	// create record
		echo "record is not found";
		$q = "INSERT INTO wind (".
		"`spotid`,".
		"`lastModified`,".
		"`day`,".
		"`hour`,".
		"`minute`,".
		"`starthour`,".
		"`startminute`,".
		"`wind`,".
		"`gust`".
		") VALUES (".
		"".$spotID." ,".
		" '".$updatetime."' ,".
		" '".$day."' ,".
		" '".$hour."' ,".
		" '".$minute."' ,".
		" '".$starthour."' ,".
		" '".$startminute."' ,".
		" '".$wind."' ,".
		" '".$gust."' )";
		echo "<br><br>sql=".$q."<br><br>";
		$result = mysql_query($q, $conn);
		if (mysql_errno()) {
			echo "error:".mysql_error();
		}
	}

        echo "stap 7..:".$result;
?>