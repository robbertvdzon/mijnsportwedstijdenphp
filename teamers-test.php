<?

function findLijst($string, $startPos){

    $result = new \stdClass();
    $result->pos = -1;
    $result->name = "";
    $result->link = "?";
    $result->found = false;


    /* FIND THE BEGINNING OF A NEW PLAYER */
    $pos = strpos($string, '<li>',$startPos);   

    if (($pos === false)) return $result;
    $startIndexplayer = $pos;
    $result->pos = $startIndexplayer+1;
    


    /* FIND THE LINK */
    $searchStart='<a href="lijstjes.asp?';
    $searchEnd='" class';
    $searchStringLength = strlen($searchStart);
    $pos1 = strpos($string, $searchStart,$startIndexplayer);   
    $pos2 = strpos($string, $searchEnd,$pos1);


    if (!(($pos1 === false) || ($pos1 === false))){
        $result->link = "http://www.teamers.nl/ajx_lijstjes.asp?".trim(substr($string,$pos1+$searchStringLength,$pos2-$pos1-$searchStringLength))."&order=ascending&sortgrid=false";
    }
    $currentPos = $pos2; 
   
    /* FIND THE NAME */
    $searchStart='title="';
    $searchEnd='">';
    $searchStringLength = strlen($searchStart);
    $pos1 = strpos($string, $searchStart,$startIndexplayer);   
    $pos2 = strpos($string, $searchEnd,$pos1);
    $result->team = "";
    if (!(($pos1 === false) || ($pos1 === false))){
        $result->name = trim(substr($string,$pos1+$searchStringLength,$pos2-$pos1-$searchStringLength));
    }
    $currentPos = $pos2; 


    $result->found = true;
    return $result;
}


function zoeklijstjes($id){
$url = "http://www.teamers.nl/lijstjes.asp?s=".$id."&sub=beurten";
$lijstjedata = file_get_contents($url);
//echo $lijstjedata;

    $searchStart='<div class="lijstjes_tabs list_white">';
    $searchEnd='<div class="lijstjes_wrapper list_green">';
    $searchStringLength = strlen($searchStart);
    $searchEndStringLength = strlen($searchEnd);
    $pos1 = strpos($lijstjedata, $searchStart,0);   
    $pos2 = strpos($lijstjedata, $searchEnd,$pos1);
    $lijstData = "";
    if (!(($pos1 === false) || ($pos1 === false))){
        $lijstData = trim(substr($lijstjedata,$pos1,$pos2));
        
        echo "-- LIJSTEN:--<br>";
        $pos = 0;
        while ($pos>=0){   
            $lijst = findLijst($lijstData, $pos);
            $pos = $lijst->pos;
            if ($lijst->found){
                echo "<b>*****".$lijst->name." </b><br>\n";
                printlijstje($lijst->link);
            }
        }
        
        
    }
    $currentPos = $pos2;
    
    


    
    
}

function printlijstje($url){
    // FIND LIJSTJES

//$url = "http://www.teamers.nl/ajx_lijstjes.asp";
//$url = "http://www.teamers.nl/ajx_lijstjes.asp?s=EAF40EC7-0A28-485E-BD09-BACDE9670A8C&sub=beurten&ssub=19109EF8-C399-4E2F-B31A-00A7181277C0&typ=&sort=Naam&order=ascending&sortgrid=false";
//$url = "http://www.teamers.nl/ajx_lijstjes.asp?s=228D55CC-7E5B-48DC-AD08-DEB562F1B238&sub=statistieken&ssub=doelpunten&typ=&sort=Naam&order=ascending&sortgrid=false";


//s=228D55CC-7E5B-48DC-AD08-DEB562F1B238&sub=statistieken&ssub=doelpunten&typ=&sort=Naam&order=ascending&sortgrid=false

// opt voor doelpunten    
//$opts = array('http' =>
//    array(
//        'method'  => 'POST',
//        'header'  => 'Content-type: application/x-www-form-urlencoded',
//        'content' => 's=228D55CC-7E5B-48DC-AD08-DEB562F1B238&sub=statistieken&ssub=doelpunten&typ=&sort=Naam&order=ascending&sortgrid=false'
//    )
//);

// opt voor lijst    
//$opts = array('http' =>
//    array(
//        'method'  => 'POST',
//        'header'  => 'Content-type: application/x-www-form-urlencoded',
//        'content' => 's=EAF40EC7-0A28-485E-BD09-BACDE9670A8C&sub=beurten&ssub=19109EF8-C399-4E2F-B31A-00A7181277C0&typ=&sort=Naam&order=ascending&sortgrid=false'
//        
//    )
//);
//
//$context  = stream_context_create($opts);
//$lijstjedata = file_get_contents($url,false,$context);
$lijstjedata = file_get_contents($url);
$lijstjedata = str_replace ( "display:none" , "" , $lijstjedata );

    
    
    //header('Content-Type: text/plain; charset=utf-8');     
   // $string = http_post($url,$fields);
    //$lijstjedata =  $string['content'];
    
echo $lijstjedata;

    $searchStart='<table width="215" cellspacing="0" cellpadding="5" border="0" dependentalternateclasses="yellow_row,lightyellow_row"';
    $searchEnd='</table>';
    $searchStringLength = strlen($searchStart);
    $searchEndStringLength = strlen($searchEnd);
    $pos1 = strpos($lijstjedata, $searchStart,0);   
    $pos2 = strpos($lijstjedata, $searchEnd,$pos1);
    $lijstes = "";
    if (!(($pos1 === false) || ($pos1 === false))){
        $lijstes = trim(substr($lijstjedata,$pos1,$pos2-$pos1+$searchEndStringLength));
    }
    $currentPos = $pos2;
    echo $lijstes; 


    $searchStart='<tbody xmlns="http://www.w3.org/1999/xhtml">';
    $searchEnd='</tbody>';
    $searchStringLength = strlen($searchStart);
    $searchEndStringLength = strlen($searchEnd);
    $pos1 = strpos($lijstjedata, $searchStart,0);   
    $pos2 = strpos($lijstjedata, $searchEnd,$pos1);
    $lijstes = "";
    if (!(($pos1 === false) || ($pos1 === false))){
        $lijstes = trim(substr($lijstjedata,$pos1,$pos2-$pos1+$searchEndStringLength));
    }
    $currentPos = $pos2;
    echo $lijstes; 




   // echo $string[content];
    
}


function findPlayerDetails($playerdetails){
    if (!isset($playerdetails->link)) return;
    $url = "http://www.teamers.nl/".$playerdetails->link;
    $string = file_get_contents($url);

    /* FIND EMAIL */
    $searchStart='<a href="mailto:';
    $searchEnd='" class';
    $searchStringLength = strlen($searchStart);
    $pos1 = strpos($string, $searchStart,0);   
    $pos2 = strpos($string, $searchEnd,$pos1);
    $wij = "?";
    if (!(($pos1 === false) || ($pos1 === false))){
        $playerdetails->email = trim(substr($string,$pos1+$searchStringLength,$pos2-$pos1-$searchStringLength));
    }
    
}


function findPlayer($string, $startPos){

    $result = new \stdClass();
    $result->pos = -1;
    $result->name = "";
    $result->email = "";
    $result->link = "?";
    $result->found = false;


    /* FIND THE BEGINNING OF A NEW PLAYER */
    $pos = strpos($string, 'div class="teammember_name_inactive_2">',$startPos);   

    if (($pos === false)) return $result;
    $startIndexplayer = $pos;
    $result->pos = $startIndexplayer+1;
    


    /* FIND THE LINK */
    $searchStart='<a href="';
    $searchEnd='" target';
    $searchStringLength = strlen($searchStart);
    $pos1 = strpos($string, $searchStart,$startIndexplayer);   
    $pos2 = strpos($string, $searchEnd,$pos1);


    if (!(($pos1 === false) || ($pos1 === false))){
        $result->link = trim(substr($string,$pos1+$searchStringLength,$pos2-$pos1-$searchStringLength));
    }
    $currentPos = $pos2; 
   
    /* FIND THE NAME */
    $searchStart='title="';
    $searchEnd='">';
    $searchStringLength = strlen($searchStart);
    $pos1 = strpos($string, $searchStart,$startIndexplayer);   
    $pos2 = strpos($string, $searchEnd,$pos1);
    $result->team = "";
    if (!(($pos1 === false) || ($pos1 === false))){
        $result->name = trim(substr($string,$pos1+$searchStringLength,$pos2-$pos1-$searchStringLength));
    }
    $currentPos = $pos2; 


    $result->found = true;
    return $result;
}


function findAllScoreMembers($scoreblock, $gamedetails){
    $searchStart='target="_self" class="link">';
    $searchEnd='</a';
    $searchStringLength = strlen($searchStart);
    $startPos = 0;
    $gamedetails->scoreMember = "";

    $continueSearch = true;
    while ($continueSearch){
        $pos1 = strpos($scoreblock, $searchStart,$startPos);   
        $pos2 = strpos($scoreblock, $searchEnd,$pos1);
        $scoreMember = "";
        if (!(($pos1 === false) || ($pos1 === false))){
            $scoreMember  = trim(substr($scoreblock,$pos1+$searchStringLength,$pos2-$pos1-$searchStringLength));
        }
        else{
            $continueSearch = false;
        }
        $gamedetails->scoreMember = $gamedetails->scoreMember.",".$scoreMember;
        $startPos = $pos2;
    }
}



function findAllAanwezig($aanwezigblock, $gamedetails){
    $searchStart='title="aangemeld:';
    $searchEnd='</a';
    $searchStringLength = strlen($searchStart);
    $startPos = 0;
    $gamedetails->aanwezig = "";

    $continueSearch = true;
    while ($continueSearch){
        $pos1 = strpos($aanwezigblock, $searchStart,$startPos);   
        $pos2 = strpos($aanwezigblock, $searchEnd,$pos1);
        $aanwezig = "";
        if (!(($pos1 === false) || ($pos1 === false))){
            $aanwezig  = trim(substr($aanwezigblock,$pos1+$searchStringLength,$pos2-$pos1-$searchStringLength));
            
            // again, but start from '">'
            $pos3 = strpos($aanwezig, '">',0);
            $aanwezig  = trim(substr($aanwezig,$pos3+2));
            
        }
        else{
            $continueSearch = false;
        }
        $gamedetails->aanwezig = $gamedetails->aanwezig.",".$aanwezig;
        $startPos = $pos2;
    }
}




function findGameDetails($gamedetails){
    $gamedetails->score = "?-?";
    if (!isset($gamedetails->link)) return;
    $url = "http://www.teamers.nl/".$gamedetails->link;
    $string = file_get_contents($url);

    /* FIND WIJ */
    $searchStart='>wij: <strong>';
    $searchEnd='</strong>';
    $searchStringLength = strlen($searchStart);
    $pos1 = strpos($string, $searchStart,0);   
    $pos2 = strpos($string, $searchEnd,$pos1);
    $wij = "?";
    if (!(($pos1 === false) || ($pos1 === false))){
        $wij = trim(substr($string,$pos1+$searchStringLength,$pos2-$pos1-$searchStringLength));
    }
    
    
    $currentPos = $pos2; 

    /* FIND ZIJ */
    $searchStart=' zij: <strong>';
    $searchEnd='</strong>';
    $searchStringLength = strlen($searchStart);
    $pos1 = strpos($string, $searchStart,0);   
    $pos2 = strpos($string, $searchEnd,$pos1);
    $zij = "?";
    if (!(($pos1 === false) || ($pos1 === false))){
        $zij = trim(substr($string,$pos1+$searchStringLength,$pos2-$pos1-$searchStringLength));
    }
    $currentPos = $pos2; 
    $gamedetails->score = $wij."-".$zij;
    
    /* FIND SCORE MEMBERS (whole block) */
    $searchStart='<strong>Wie scoorde er?</strong>';
    $searchEnd='class="content_title_container">';
    $searchStringLength = strlen($searchStart);
    $pos1 = strpos($string, $searchStart,0);   
    $pos2 = strpos($string, $searchEnd,$pos1);
    $scoreblock = "";
    if (!(($pos1 === false) || ($pos1 === false))){
        $scoreblock  = trim(substr($string,$pos1+$searchStringLength,$pos2-$pos1-$searchStringLength));
    }
    $currentPos = $pos2;
    
    /* FIND SCORE MEMBER (within whole block) */
    findAllScoreMembers($scoreblock,$gamedetails);
    
    
    /* FIND SCORE MEMBERS (whole block) */
    $searchStart='div id="aanwezigheid_wrapper">';
    $searchEnd='<div id="aanwezigheid_wrapper_bottom"></div>';
    $searchStringLength = strlen($searchStart);
    $pos1 = strpos($string, $searchStart,0);   
    $pos2 = strpos($string, $searchEnd,$pos1);
    $aanwezigblock = "";
    if (!(($pos1 === false) || ($pos1 === false))){
        $aanwezigblock  = trim(substr($string,$pos1+$searchStringLength,$pos2-$pos1-$searchStringLength));
    }
    else{
    }
    $currentPos = $pos2;
    
    /* FIND SCORE MEMBER (within whole block) */
    findAllAanwezig($aanwezigblock,$gamedetails);
    
    
     
       
}


function findOpponent($string, $startPos, $gamelink_prefix,$team_prefix, $datePrefix){

    $result = new \stdClass();
    $result->pos = -1;
    $result->date = "";
    $result->team = "";
    $result->uitthuis ="";
    $result->found = false;


    /* FIND THE BEGINNING OF A NEW GAME */
    $pos = strpos($string, $gamelink_prefix,$startPos);   
    if (($pos === false)) return $result;
    $startIndexGame = $pos;
    $result->pos = $startIndexGame+1;


    /* FIND THE LINK */
    $searchStart='mijnseizoen.asp?s=';
    $searchEnd='"';
    $searchStringLength = strlen($searchStart);
    $pos1 = strpos($string, $searchStart,$startIndexGame);   
    $pos2 = strpos($string, $searchEnd,$pos1);
    $link = "?";
    if (!(($pos1 === false) || ($pos1 === false))){
        $link = trim(substr($string,$pos1,$pos2-$pos1));
    }
    $currentPos = $pos2; 
   
    /* FIND THE TEAM */
    $searchStart=$team_prefix;
    $searchEnd='(';
    $searchStringLength = strlen($searchStart);
    $pos1 = strpos($string, $searchStart,$startIndexGame);   
    $pos2 = strpos($string, $searchEnd,$pos1);
    $result->team = "";
    if (!(($pos1 === false) || ($pos1 === false))){
        $result->team = trim(substr($string,$pos1+$searchStringLength,$pos2-$pos1-$searchStringLength));
    }
    $currentPos = $pos2; 

    /* FIND THUIS OR UIT */
    $searchStart='(';
    $searchEnd=')';
    $searchStringLength = strlen($searchStart);
    $pos1 = strpos($string, $searchStart,$startIndexGame);   
    $pos2 = strpos($string, $searchEnd,$pos1);
    $result->uitthuis = "";
    if (!(($pos1 === false) || ($pos1 === false))){
        $result->uitthuis = trim(substr($string,$pos1+$searchStringLength,$pos2-$pos1-$searchStringLength));
    }
    $currentPos = $pos2; 
    

    /* FIND START DATE */
    $searchStart=$datePrefix;
    $searchEnd='<';
    $searchStringLength = strlen($searchStart);
    $pos1 = strpos($string, $searchStart,$startIndexGame);   
    $pos2 = strpos($string, $searchEnd,$pos1);
    $date = "";
    if (!(($pos1 === false) || ($pos1 === false))){
        $date = trim(substr($string,$pos1+$searchStringLength,$pos2-$pos1-$searchStringLength));
    }
    $currentPos = $pos2; 

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
    $result->link = $link;
    $result->found = true;
    return $result;
}



$teamersID = "228D55CC-7E5B-48DC-AD08-DEB562F1B238";
$url = "http://www.teamers.nl/mijnseizoen.asp?s=".$teamersID;
$membersurl = "http://www.teamers.nl/team.asp?s=".$teamersID;

$response = file_get_contents($url);
$membersresponse = file_get_contents($membersurl);


// FIND PLAYERS
echo "-- PLAYERS:--<br>";
$pos = 0;
while ($pos>=0){   
    $player = findPlayer($membersresponse, $pos);
    $pos = $player->pos;
    if ($player->found){
        findPlayerDetails($player);
        echo $player->name.":".$player->email." <br>\n";
    }
}


echo "<br><br>-- GAMED PLAYED:--<br>";
// FIND GAMES PLAYED
$pos = 0;
while ($pos>=0){   
    $res = findOpponent($response, $pos, 'class="archive_item_title_passed"','class="link_passed">', 'archive_item_date_passed">');
    $pos = $res->pos;
    if ($res->found){
        findGameDetails($res);
        echo $res->team." uit/thuis:".$res->uitthuis." date:".$res->date." ".$res->time.":".$res->score.":<br>- scored by".$res->scoreMember."<br>- aanwezig:".$res->aanwezig." <br>\n";
        
    }
}

echo "<br><br>-- GAMED TO PLAY:--<br>";
// FIND GAMES TO PLAY
$pos = 0;
while ($pos>=0){
    $res = findOpponent($response, $pos, 'class="archive_item_title"','class="link">', 'archive_item_date">');
    $pos = $res->pos;
    if ($res->found){
        findGameDetails($res);
        echo $res->team.":".$res->uitthuis.":".$res->date." ".$res->time.":<br>- aanwezig:".$res->aanwezig." <br>\n";
    }
}


$lijstjes = zoeklijstjes($teamersID);


//wasbeurten:
$url = "http://www.teamers.nl/ajx_lijstjes.asp?s=EAF40EC7-0A28-485E-BD09-BACDE9670A8C&sub=beurten&ssub=B5E72DB7-F032-4506-9010-9D990C6560AE&order=ascending&sortgrid=false";
//teampot
$url = "http://www.teamers.nl/ajx_lijstjes.asp?s=EAF40EC7-0A28-485E-BD09-BACDE9670A8C&sub=beurten&ssub=19109EF8-C399-4E2F-B31A-00A7181277C0&order=ascending&sortgrid=false";

printlijstje($url);

?>
