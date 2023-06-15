<?php
require 'class.phpmailer.php';

$mail = new PHPMailer;

$mail->IsSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'mail.archcorner.org';  // Specify main and backup server
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'smtp@archcorner.org';                            // SMTP username
$mail->Password = 'MdfUOeiM0Gqn';                           // SMTP password
$mail->SMTPSecure = 'tls'; 
$mail->Port = 465;   // Enable encryption, 'ssl' also accepted

$mail->From = 'smtp@archcorner.org';
$mail->FromName = 'wondersand test';
$mail->AddAddress('sareerihsan@gmail.com', 'Sareer ihsan');  // Add a recipient
               // Name is optional

//$mail->AddCC('nomi737@gmail.com');
//$mail->AddBCC('uredens01@gmail.com');

$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
//$mail->AddAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->AddAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->IsHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Here is the subject';
$mail->Body    = '
<font color="red"><h2>Please enable image in the email so you can see image also.</h2></font>
url to this test page is:
http://wondersandtourism.com/demo/phpmailer/example.php
<br />
<style type="text/css">
                @import url("http://wondersandtourism.com/demo/print.css");
                </style>
                <table width="500" border="0" align="center">
                <tr>
                <td colspan="2"><img src="http://wondersandtourism.com/demo/images/logo.png" /></td>
                </tr>
                <tr>
                <td colspan="2">&nbsp;</td>
                </tr>

                <tr>
                <td colspan="2">testing message 2</td>
                </tr>
                <tr>
                <td colspan="2"></td>
                </tr>
                <tr>
                <td colspan="2" class="mail-text">Wonder Sand Tourism</td>
                </tr>
                <tr>
                <td colspan="2"></td>
                </tr>

                </table>
This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->Send()) {
   echo 'Message could not be sent.';
   echo 'Mailer Error: ' . $mail->ErrorInfo;
   exit;
}
?>