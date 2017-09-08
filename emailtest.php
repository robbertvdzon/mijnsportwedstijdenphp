<?
 require_once "Mail.php";
include_once ("globals.php");
date_default_timezone_set('UTC');

sendEmail('robbert@vdzon.com','mijnsportwedstrijden test','mijnsportwedstrijden body','robbert@vdzon.com');

function sendEmail($to,$subject,$body, $from) {

 $from = "mijnsportwedstrijden@vdzon.com";
 $host = "ssl://send.one.com";
 $port = "465";
 $username = "mijnsportwedstrijden@vdzon.com";
 $password = "hlkjdasiouyerfnbmasdkljhf32Hdyoui";
 
 $headers = array ('From' => $from,
   'To' => $to,
   'Subject' => $subject);
 $smtp = Mail::factory('smtp',
   array ('host' => $host,
     'port' => $port,
     'auth' => true,
     'username' => $username,
     'password' => $password));
 
 $mail = $smtp->send($to, $headers, $body);

     if (PEAR::isError($mail)) {
        return false;
     } else {
         return true;
     }
}

