
<?php
$merge = json_decode($_POST['data']);
file_put_contents ( "maillist.txt" , $merge );
echo "ok";
?>