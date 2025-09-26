<?php
@session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($email)
{
    $otp = rand(100000, 999999);
    $_SESSION['sesOtp'] = $otp;

    require("./PHPMailer/Exception.php");
    require("./PHPMailer/PHPMailer.php");
    require("./PHPMailer/SMTP.php");

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'Eventify75@gmail.com';                              //set email
        $mail->Password = 'ydii lmkg hpyt wnhe';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;
        //Recipients
        $mail->setFrom('Eventify75@gmail.com', 'OTP Verification');
        $mail->addAddress($email);                                             //Add a recipient

        $mail->isHTML(true);                                                  //Set email format to HTML
        $mail->Subject = 'OTP Verification';
        $mail->Body = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
        </head>
        <body>
            <div
                style="font-family: Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2">
                <div style="margin:50px auto;width:70%;padding:20px 0">
                    <div style="border-bottom:1px solid #eee">>
                                            
                        <a href
                           style="font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600">
                           Eventify OTP Verification :</a>
                    </div>
                    <p style="font-size:1.1em">Hi,</p>
                    <p>Thank you for choosing Eventify! Please use the following OTP to complete your account verification: If you did not request this OTP, please ignore this email.</p><br>
                    <h2
                            style="background: #FF5757;margin: 0 auto;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px;">' . $otp . '</h2><br>
                    <p style="font-size:0.9em;">Regards,<br />Eventify</p>
                    <hr style="border:none;border-top:1px solid #eee" />
                    <div
                            style="float:right;padding:8px 0;color:#aaa;font-size:0.8em;line-height:1;font-weight:300">
                       
                    </div>
                </div>
            </div>
        </body>
        </html>';

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "<script> alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}')</script>";
    }
}