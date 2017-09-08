<?
include_once ("dbcalls.php");

if (isset($argv[1])){
    dbcalls\logSQL2("",$argv[1], 1, "root");
}

?>