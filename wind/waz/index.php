<?
$conn=mysql_connect("localhost", "root", "luttikcie teamsport");
mysql_select_db('wind', $conn) or die(mysql_error());

$day=2014002;

$sth = mysql_query("select wind as w, gust as g, angle as a, day as d, hour as h2, minute as m2, starthour as h1, startminute as m1, lastModified as t, spotid as s from wind where wind>=0 and gust>=0 and angle>=0 and spotid=1  order by id desc limit 150");

$index =0;
while($row = mysql_fetch_assoc($sth) ) {
	//$index++;
	$yearday=$row['d'];
	$dayOfYear=$yearday%1000;
	$year=($yearday-$dayOfYear)/1000;
	$lastmodified=0;
	$date = getDateFromDay($dayOfYear,$year);

 	print $date->format('d/m ');
 	print "&nbsp;";
 	print getDoubleDigits($row['h1']) . ":" . getDoubleDigits($row['m1']);
 	print "&nbsp;";
 	print "-";
 	print "&nbsp;";
 	print getDoubleDigits($row['h2']) . ":" . getDoubleDigits($row['m2']);
 	print "&nbsp;:&nbsp;";
 	print printWindWithColor($row['w']);
 	print "&nbsp;";
 	print printGustWithColor($row['g']);
 	print "&nbsp;";
 	print printAngleWithColor((int)$row['a']);
 	print "&nbsp;";
 	print printAngleImage((int)$row['a']);
 	print "<br>";
}

function getDateFromDay($dayOfYear, $year) {
  	$date = DateTime::createFromFormat('z Y', strval($dayOfYear-1) . ' ' . strval($year));
  	return $date;
}

function getDoubleDigits($number) {
	if (strlen($number)==1){
		return "0".$number;
	}
  	return $number;
}

function formatFloat($float){
	$str = number_format($float, 1, '.', '');
	if ($float<10){
		$str="0".$str;
	}
	return $str;
}


function formatAngle($int){
	$str = "".$int;
	if ($int<100){
		$str="0".$str;
	}
	else if ($int<10){
		$str="00".$str;
	}
	return $str;
}

function printAngleWithColor($angleInt){
	$angleStr = formatAngle($angleInt);
	$color = "#00AA00";
	if (($angleInt>=13)&&($angleInt<=23)) $color = "#AAAAAA";
	if (($angleInt>=24)&&($angleInt<=202)) $color = "red";
	if (($angleInt>=203)&&($angleInt<=213)) $color = "#AAAAAA";
	return "<font color='$color'><b>$angleStr</b></font>";
}

function printWindWithColor($windFloat){
	$windStr = formatFloat($windFloat);
	$color = "#00AA00";
	if ($windFloat<7) $color = "#AAAAAA";
	if ($windFloat>13) $color = "red";
	return "<font color='$color'><b>$windStr</b></font>";
}

function printGustWithColor($windFloat){
	$windStr = formatFloat($windFloat);
	$color = "#00AA00";
	if ($windFloat<7) $color = "#AAAAAA";
	if ($windFloat>17) $color = "red";
	return "<font color='$color'><b>$windStr</b></font>";
}

function printAngleImage($angle){
	$angle2 = $angle+11;
	$angle2 = $angle2*10;
	$imageNr = round($angle2/225);
	if ($imageNr==16) $imageNr = 0;
	return "<img src='s".$imageNr.".gif' width=\"10\" alt='' >";
}




?>