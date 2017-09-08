<?php

echo "sending email from script:".__FILE__."<br>";
require_once "teamsport.php";
echo "before email<br>";
emailUserInvite("Robbert","robbert@vdzon.com","noreply@teamsport-app.nl");
//emailUserInvite("Robbert","robbert@vdzon.com","noreply@mijnsportwedstrijden.nl");
echo "after email<br>";


function emailUserInvite($name, $email, $from) {
    $to = $email;
    $subject = 'Test email message';
    $message = '
    <html>
    <head><title>test email message</title></head>
    <body>
    <b>Hi </b><br>This is a test email message
    </body>
    </html>
    ';
    $result = sendEmail($to ,$subject,$message, $from);
}



?>