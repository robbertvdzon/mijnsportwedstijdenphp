<?php
$merge = $_POST['data'];
$merge = urldecode ($merge);
if (!file_put_contents ( "mail/merge.txt" , $merge )){
	echo "error saving merge.txt";
}
else{
	echo "saved correctly";
}
echo exec('java -classpath nozem.jar com.vdzon.nennmailer.MergeToHtml mail');
?>