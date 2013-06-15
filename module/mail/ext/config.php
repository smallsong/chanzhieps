<?php
$config->mail->turnon         = true;   // trun on email feature or not.
$config->mail->fromAddress    = 'robot@zentao.net';      // The from address.
$config->mail->fromName       = '禅道';      // The from name.
$config->mail->mta            = 'smtp'; // phpmail|sendmail|smtp|gmail

/* SMTP settings. */
if($config->mail->mta == 'smtp')
{
    $config->mail->smtp->debug    = 0;          // Debug level, 0,1,2.
    $config->mail->smtp->auth     = false;       // Need auth or not.
    $config->mail->smtp->host     = 'localhost';         // The smtp server host address.
    $config->mail->smtp->port     = '25';         // The smtp server host port.
    $config->mail->smtp->username = '';         // The smtp user, may be a full email adress.
    $config->mail->smtp->password = '';         // The smtp user's password.
}
/* Gmail setting. */
elseif($config->mail->mta == 'gmail')
{
    $config->mail->gmail->debug      = 0;       // Debug level, 0,1,2.
    $config->mail->gmail->username   = "";      // GMAIL username
    $config->mail->gmail->password   = "";      // GMAIL password
}
