<?php
session_start();
include_once('./config.php');
include './forgetMail.php';

if (isset($_POST['resend_otp']) && $_POST['resend_otp'] == 'resend') {
    sendMail($_SESSION['email']);
    echo "<script>alert('OTP has been resent.');</script>";
}

$otpE = ""; // Initialize $otpE as an empty string

if (isset($_POST['verify'])) {
    $otp = $_POST['otp_code'];

    if (!empty($otp) && preg_match("/[0-9]{6}/", $otp)) {
        if ($otp == $_SESSION['sesOtp']) {
            echo "<script>alert('now you change the password!');
            window.location.replace('newPassword.php');</script>";
        } else {
            $otpE = "Invalid OTP!";
        }
    } else {
        $otpE = "Please enter a valid 6-digit OTP!";
    }
}
?>


<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!-- Include the above in your HEAD tag -->
        <!-- Fonts -->
        <link rel="dns-prefetch" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

        <link rel="stylesheet" href="styleverfication.css">

        <link rel="icon" href="Favicon.png">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

        <title>Eventify | Verification</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <script>
            // Prevent the login page from being cached
        window.history.forward();

        // Prevent navigating back to the login page
        window.onload = function() {
            if (window.history && window.history.pushState) {
                window.history.pushState(null, null, window.location.href);
                window.onpopstate = function() {
                    window.history.pushState(null, null, window.location.href);
                };
            }
        };
            function resendOtp() {
                document.getElementById('resend_form').submit();
            }
        </script>
        <style>
            .resend-link {
                color: #C78665; /* Original link color */
                transition: color 0.3s; /* Smooth transition for color change */
            }

            .resend-link:hover {
                color: #a97152; /* Change this to your desired hover color */
                text-decoration: underline; /* Optional: underline on hover */
            }
        </style>
    </head>

    <body>

        <div class="attending_area">
            <div class="container">
                <div class="row">
                    <div class="col-xl-10 offset-xl-1 col-lg-10 offset-lg-1">
                        <div class="main_attending_area">
                            <div class="row justify-content-center">
                                <div class="col-xl-7 col-lg-8">
                                    <div class="popup_box">
                                        <div class="popup_inner">
                                            <div class="form_heading text-center">
                                                <h3>OTP Verification</h3><br>
                                            </div>
                                            <form action="#" method="POST">
                                                <div class="col-xl-12">
                                                    <input type="text" id="otp" class="form-control" required  name="otp_code" autofocus placeholder="OTP">

                                                </div>
                                                <?php if (!empty($otpE)) : ?>
                                                    <div class="col-md-6 offset-md-4">
                                                        <small class="text-danger"><?php echo $otpE; ?></small>
                                                    </div>
                                                <?php endif; ?>
                                        </div>

                                        <div class="col-xl-12">
                                            <button type="submit" value="Verify" class="boxed_btn3" name="verify">verify Now</button>

                                        </div>
                                        <div class="col-xl-12">
                                            <br>
                                            <p>
                                                <a href="javascript:void(0);" onclick="resendOtp();" class="resend-link">Resend OTP</a>
                                            </p>
                                        </div>
                                        </form>
                                        <form id="resend_form" action="#" method="POST" style="display:none;">
                                            <input type="hidden" name="resend_otp" value="resend">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
