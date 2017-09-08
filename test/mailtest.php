    <?php
    require_once "Mail.php";

    $from = "Teamsport <registratie@teamsport-app.nl>";
    $to = "Robbert <robbert@vdzon.com>";
    $subject = "Hi!";
    $body = "Hi,\n\nHow are you?";

    $host = "localhost";
    $port = "25";

    $headers = array ('From' => $from,
      'To' => $to,
      'Subject' => $subject);
    $smtp = Mail::factory('smtp',
      array ('host' => $host,
        'port' => $port));

    $mail = $smtp->send($to, $headers, $body);

    if (PEAR::isError($mail)) {
      echo($mail->getMessage());
     } else {
      echo('Message successfully sent!');
     }
    ?>