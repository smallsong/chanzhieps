<?php
$config->mail->turnon         = false;
$config->mail->fromAddress    = '';       // The from address.
$config->mail->fromName       = '';       // The from name.
$config->mail->mta            = 'gmail';  // MTA:phpmail|sendmail|smtp|gmail

/* Common smtp settings. */
if($config->mail->mta == 'smtp')
{
    $config->mail->smtp->debug    = 0;          // The debug level, the greater, the more info.  0, 1, 2
    $config->mail->smtp->auth     = true;       // Need auth or not.
    $config->mail->smtp->host     = '';         // The host.
    $config->mail->smtp->port     = '';         // The port.
    $config->mail->smtp->username = '';         // The login name, if the auth if true. Perhaps is the full email address.
    $config->mail->smtp->password = '';         // The login password.
}
/* The gmail settings. */
elseif($config->mail->mta == 'gmail')
{
    $config->mail->gmail->debug      = 0;       // The debug level, the greater, the more info.  0, 1, 2
    $config->mail->gmail->username   = "";      // GMAIL username
    $config->mail->gmail->password   = "";      // GMAIL password
}
