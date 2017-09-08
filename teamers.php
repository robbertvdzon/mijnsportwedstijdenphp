<?



function findOpponent($string, $startPos, $team_prefix, $datePrefix){
	$pos = strpos($string, $team_prefix,$startPos);

	$result = new \stdClass();
	$result->pos = -1;
	$result->date = "";
	$result->team = "";
	$result->uitthuis ="";
	$result->found = false;

	if (!($pos === false)) { // there must be three === chars!!
		/* FIND THE BEGINNING OF A NEW GAME */
		$startIndexTeam = $pos+strlen($team_prefix);
		$result->pos = $startIndexTeam;
		$pos = strpos($string, "(",$startIndexTeam);
		if (!($pos === false)) {
			/* FIND THE TEAM NAME */
			$endIndexTeamname = $pos;
			$result->team = trim(substr($string,$startIndexTeam,$endIndexTeamname-$startIndexTeam));

			$pos = strpos($string, ")",$endIndexTeamname);
			if (!($pos === false)) { // there must be three === chars!!
				/* FIND THUIS OR UIT */
				$result->uitthuis = trim(substr($string,$endIndexTeamname+1,$pos-$endIndexTeamname-1));
				$pos = strpos($string, $datePrefix,$startIndexTeam);
				if (!($pos === false)) {
					$startDate = $pos+strlen($datePrefix);
					$pos = strpos($string, "<",$startDate);
					if (!($pos === false)) {
						$date = trim(substr($string,$startDate,$pos-$startDate));

						$date = str_replace("januari", "January",$date);
						$date = str_replace("februari", "February",$date);
						$date = str_replace("maart", "March",$date);
						$date = str_replace("mei", "may",$date);
						$date = str_replace("juni", "june",$date);
						$date = str_replace("juli", "july",$date);
						$date = str_replace("augustus", "august",$date);
						$date = str_replace("oktober", "october",$date);


						$new_date=date_parse_from_format('dS M Y H:i', $date);
						$result->date = $new_date['day']."/".$new_date['month']."/".$new_date['year'];
						$result->time = $new_date['hour'].":".$new_date['minute'];
						$result->found = true;
					}
				}
			}
		}
	}
	return $result;
}

$url = "http://www.teamers.nl/mijnseizoen.asp?s=62DE8111-939D-433F-B4D9-4236A6A8E474";

$response = file_get_contents($url);

$pos = 0;
while ($pos>=0){
	$res = findOpponent($response, $pos, 'class="link_passed">', 'archive_item_date_passed">');
	$pos = $res->pos;
	if ($res->found){
		echo $res->team.":".$res->uitthuis.":".$res->date." ".$res->time." <br>";
	}
}

$pos = 0;
while ($pos>=0){
	$res = findOpponent($response, $pos, 'class="link">', 'archive_item_date">');
	$pos = $res->pos;
	if ($res->found){
		echo $res->team.":".$res->uitthuis.":".$res->date." ".$res->time." <br>";
	}
}



?>
