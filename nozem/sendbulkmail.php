
<?php
$subject = json_decode($_POST['subject']);
echo exec('java -classpath nozem.jar com.vdzon.nennmailer.SendMail mail/index.html maillist.txt "'.$subject.'"');
?>