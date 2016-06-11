<?php
include __DIR__.'/vendor/autoload.php';
define("SMTP", "smtp.zoho.com");
define("PORT", "465");
define("SECURE", "ssl");
define("USERNAME", "ttbsolutions@zoho.com");
define("PASSWORD", ">X9:{Bb2-Epb>6/D");
define("FROM", "contact@ttb.solutions");
define("FROM_NAME", "TTB Solutions Co., Ltd");
define("REPLY_TO", "contact@ttb.solutions");

ini_set('default_charset', 'UTF-8');

$email = @$_GET['email'];
$name = @$_GET['name'];
$phone = @$_GET['phone'];

if ($name && $email && $phone) {
	$name = trim($name);
	$email = trim($email);
	$phone = trim($phone);
	send($name, $email, $phone);
}

$ref = @$_SERVER['HTTP_REFERER'];
$host = @$_SERVER['HTTP_HOST'];
header('Location: ' . ($ref ? $ref : '/index.html'));

function send($name, $email, $phone)
{
	$mail = new PHPMailer();
	$mail->CharSet = 'utf-8';

	$mail->SMTPDebug = 3;                               // Enable verbose debug output

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host        = SMTP;  // Specify main and backup SMTP servers
	$mail->SMTPAuth    = true;                               // Enable SMTP authentication
	$mail->Username    = USERNAME;                 // SMTP username
	$mail->Password    = PASSWORD;                           // SMTP password
	$mail->SMTPSecure  = SECURE;                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port        = PORT;                                    // TCP port to connect to

	$mail->setFrom(FROM, FROM_NAME);
	$mail->addAddress(FROM, FROM_NAME);     // Add a recipient
	$mail->addReplyTo($email, $name);
	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = 'Khách hàng liên hệ #' . date('Y-m-d H:i:s');
	$mail->Body    = sprintf('<p>Khách hàng: %s</p><p>Số điện thoại: %s</p><p>Email: %s</p>',
		$name, $phone, $email
	);
	$mail->AltBody = sprintf('#Khách hàng: %s - #Số điện thoại: %s - #Email: %s',
		$name, $phone, $email
	);

	return $mail->send();
}
