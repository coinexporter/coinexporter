<?php
    $to      = 'talk2binayak@gmail.com';
    $subject = 'the subject';
    $message = 'hello';
    $headers = 'From: webmaster@example.com'       . "\r\n" .
                 'Reply-To: webmaster@example.com' . "\r\n" .
                 'X-Mailer: PHP/' . phpversion();

$sendmail = mail($to, $subject, $message, $headers);
    if($sendmail)
    {
        echo "success";
    }
    else
    {
        echo "Failed";
    }
?>