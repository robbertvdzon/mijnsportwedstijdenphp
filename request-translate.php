<?


function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}





/**************************************************
 */
function tr_updateIDForFile($filename, $tag1, $tag2) {
    if (endswith($filename,"request-translate.php")) return;
    global $result;
    $item = new \stdClass();
    $item -> filename = $filename;
    
    $my_file = file_get_contents($filename);
    
    $pos = 0;
    $stopSearch = false;
    $lastKeyIDFound = "";
    $lastKeyPosFound = 0;
    
    $i = 0;
    while (!$stopSearch){
        $i++;
        $pos1 = strpos($my_file, $tag1,$pos);
        if (!$pos1) $stopSearch = true;
        if (!$stopSearch){
            $pos2 = strpos($my_file, $tag2,$pos1);
            if (!$pos2) $stopSearch = true;
        }
        if (!$stopSearch){

            if ($pos2>$pos1){
                $ID = substr($my_file, $pos1+strlen($tag1), $pos2-$pos1-strlen($tag1));
                //$ID2 = substr($my_file, $pos1, $pos2-$pos1);
                $empty = $ID!="";
                if ($ID!=""){
                    $newKeyID = $filename.$ID;
                    if ($newKeyID==$lastKeyIDFound){
                        $strPos2 = $pos1;
                        $strPos1 = $lastKeyPosFound;
                        $str = substr($my_file, $strPos1, $strPos2-$strPos1);
                        dbcalls\newTranslateKey($filename, $str, $ID, $strPos1, $strPos2);
                    }                    
                    $lastKeyIDFound = $newKeyID;
                    $lastKeyPosFound = $pos2+strlen($tag2);
                }
                $pos = $pos2;            
            }
        }
    }
    
    $result[] = $item;
}


/**************************************************
 */
function tr_updateIDs() {
    global $result;
    global $sourceFolder1;
    global $sourceFolder2;
    global $targetFolder1;
    global $separator;
    
    $result = array();

    
    /*
     * clear current IDs 
     */
    dbcalls\clearTranslationKeys();
         
    /*
     * walk though files 
     */
    if ($handle = opendir($sourceFolder1)) {    
        /* This is the correct way to loop over the directory. */
        while (false !== ($entry = readdir($handle))) {
            if (endswith($entry,".php") || endswith($entry,".js") || endswith($entry,".html")) {
                tr_updateIDForFile($sourceFolder1.$separator.$entry,"/*T","T*/");
                tr_updateIDForFile($sourceFolder1.$separator.$entry,"<!--T","T-->");
            }
        }
        closedir($handle);
    }    
    
    /*
     * walk though files for mobile 
     */
    if ($handle = opendir($sourceFolder2)) {    
        /* This is the correct way to loop over the directory. */
        while (false !== ($entry = readdir($handle))) {
            if (endswith($entry,".php") || endswith($entry,".js") || endswith($entry,".html")) {
                tr_updateIDForFile($sourceFolder2.$separator.$entry,"/*T","T*/");
                tr_updateIDForFile($sourceFolder2.$separator.$entry,"<!--T","T-->");
            }
        }
        closedir($handle);
    }    
    

    $item = new \stdClass();
    $item -> filename = $sourceFolder1;
    $result[] = $item;
    
    $item = new \stdClass();
    $item -> filename = $sourceFolder2;
    $result[] = $item;
   
   
    
    
    return $result;
}

/**************************************************
 */
function tr_list_all_translations($parameters) {
    global $conn;
    $array = array();
    $keyNr = $parameters->keyNr;
    $query = "select * from translation where keyNr=".$keyNr."  order by ID";



    
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    while ($i < $num) {
        $item = new \stdClass();
        $item -> ID = mysql_result($result, $i, "ID");
        $item -> keyCode = mysql_result($result, $i, "keyCode");
        $item -> translation = mysql_result($result, $i, "translatedText");
        $array[] = $item;
        $i++;
    }

    return $array;
}

/**************************************************
 */
function tr_listIDs($parameters) {
    global $conn;
    $array = array();
    $where = $parameters->where;
    if ($where==""){
        $query = "SELECT translatekeys.filename, translatekeys.pos1, translatekeys.pos2, tr.*, (SELECT count(*) from translation where translation.keyNr=tr.keyNr) as nr_translations from translatekeys,translation tr where translatekeys.keyNr=tr.keyNr and translatekeys.keyCode=tr.keyCode order by translatekeys.id"; 
    }
    else{ 
        $query = "SELECT translatekeys.filename, translatekeys.pos1, translatekeys.pos2, tr.*, (SELECT count(*) from translation where translation.keyNr=tr.keyNr) as nr_translations from translatekeys,translation tr where translatekeys.keyNr=tr.keyNr and translatekeys.keyCode=tr.keyCode and ".$where."  order by translatekeys.id"; 
    }
    

    
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    while ($i < $num) {
        $item = new \stdClass();
        $item -> filename = mysql_result($result, $i, "filename");
        $item -> keyCode = mysql_result($result, $i, "keyCode");
        $item -> keyNr = mysql_result($result, $i, "keyNr");
        $item -> pos1 = mysql_result($result, $i, "pos1");
        $item -> pos2 = mysql_result($result, $i, "pos2");
        $item -> ID = mysql_result($result, $i, "ID");
        $item -> translation = mysql_result($result, $i, "translatedText");
        $item -> nr_translations = mysql_result($result, $i, "nr_translations");
        $array[] = $item;
        $i++;
    }

    return $array;
}

/**************************************************
 */
function tr_update_translation($parameters) {
    global $conn;
    $keyID = $parameters->keyID;
    $translation = $parameters->translation;
    $translation = mysql_real_escape_string($translation);
    $query = "update translation set translatedText='".$translation."' where ID='".$keyID."'";;
    
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    return true;
}

/**************************************************
 */
function tr_translate_file($parameters){
    global $conn;
    
    $keyID = $parameters->keyID;
    $translation = $parameters->translation;
    $query = "update translation set translatedText='".$translation."' where ID='".$keyID."'";;
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    
    $filename = $parameters->filename;
    $filename = mysql_real_escape_string($filename);
    tr_translate2($filename,false);
}

/**************************************************
 */
function tr_translate() {
    tr_translate2(null,false);
}

/**************************************************
 */
function tr_debug_translate() {
    tr_translate2(null,true);
}


/**************************************************
 */
function tr_translate2($filename,$debug){
    global $conn;
    global $sourceFolder1;
    global $sourceFolder2;
    global $targetFolder1;
    
    
    if ($filename==null){
        $query = "select * from translatekeys,translation where translatekeys.keyCode=translation.keyCode and translatekeys.keyNr=translation.keyNr order by translatekeys.filename,translatekeys.pos1 ";
    }
    else{
        $query = "select * from translatekeys,translation where translatekeys.keyCode=translation.keyCode and translatekeys.keyNr=translation.keyNr and translatekeys.filename='".$filename."' order by translatekeys.filename,translatekeys.pos1 ";
    }
    $resultText = "";
    
    
    $result = mysql_query($query, $conn);
    if (mysql_errno()) {
        throw new \Exception(mysql_error());
    }
    $num = mysql_numrows($result);
    $i = 0;
    
    $lastFilename = "";
    $lastFileData = "";
    $origFile = "";
    $lastPos = 0;
    
    while ($i < $num) {
        $item = new \stdClass();
        $item -> filename = mysql_result($result, $i, "filename");
        $item -> keyCode = mysql_result($result, $i, "keyCode");
        $item -> keyNr = mysql_result($result, $i, "keyNr");
        $item -> pos1 = mysql_result($result, $i, "pos1");
        $item -> pos2 = mysql_result($result, $i, "pos2");
        $item -> translation = mysql_result($result, $i, "translatedText");
        $item -> translation = htmlspecialchars_decode(htmlentities($item -> translation, ENT_NOQUOTES, 'UTF-8'), ENT_NOQUOTES);
        
        if ($item -> translation==""){
            $item -> translation=$item -> keyCode;
        }
        
        $i++;
        
        if ($item -> filename != $lastFilename){
            // new file, save last file
            if ($lastFilename!=null){
                $resultText.="add remaining, from pos ".$lastPos." to end <br>";
                $remain = substr($origFile, $lastPos);
                $lastFileData.=$remain;
                // save file
                $newFilename = str_replace($sourceFolder1, $targetFolder1, $lastFilename);
                if ($newFilename!=$lastFilename){
                    // double check if we are not overwriting ourself
                    $resultText.="new file=".$newFilename." <br>";
                    file_put_contents($newFilename, $lastFileData);
                }
            }
            $lastFilename = $item -> filename; 
            $lastFileData = "";
            $lastPos = 0;
            $origFile = file_get_contents($lastFilename);
            $resultText.="new file:".$item -> filename." pos1=".$item -> pos1."<br>";
        }
        $resultText.="add subtext :".$lastPos." to ".$item -> pos1."<br>";
        $part1 = substr($origFile, $lastPos,$item -> pos1-$lastPos);
//echo "id:<br>".$item -> keyNr;
        

        $printDebugCode = $debug; 

        if (endsWith($part1,"*/")){// do not print debug for javascript text
            $printDebugCode = false;
        }
        
        if ($printDebugCode){
            $resultText.="add subtext :-".$item -> keyNr."-".$item -> translation."<br>";
            $lastFileData.=$part1."-".$item -> keyNr."-".$item -> translation;
        }
        else{
            $resultText.="add subtext :".$item -> translation."<br>";
            $lastFileData.=$part1.$item -> translation;
        }
        $lastPos = $item -> pos2;
    }
    // save last file
    if ($lastFilename!=null){
        $resultText.="add remaining, from pos ".$item -> pos2." to end <br>";
        $remain = substr($origFile, $lastPos);
        $lastFileData.=$remain;
        // save file
        $newFilename = str_replace($sourceFolder1, $targetFolder1, $lastFilename);
        if ($newFilename!=$lastFilename){
            // double check if we are not overwriting ourself
            $resultText.="new file=".$newFilename." <br>";
            file_put_contents($newFilename, $lastFileData);
        }
        
    }
    return $resultText;    
}

 ?>