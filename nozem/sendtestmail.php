
<?php
$email = json_decode($_POST['email']);
$subject = json_decode($_POST['subject']);
echo exec('java -classpath nozem.jar com.vdzon.nennmailer.SendMail mail/index.html '.$email.' "'.$subject.'"');
echo "sended to ".$email;
?>