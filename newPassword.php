<?php
session_start();
error_reporting(0);
include_once('./config.php');

if (isset($_POST['verify'])) {
    $email = $_SESSION['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['ConfrimPassword']; // Corrected name attribute in form to match this

    $error_message = '';

    if (strlen($password) < 8) {
        $error_message .= "Password must be at least 8 characters long.";
    }
    if (!preg_match("/[A-Z]/", $password)) {
        $error_message .= "Password must contain at least one uppercase letter.>";
    }
    if (!preg_match("/[a-z]/", $password)) {
        $error_message .= "Password must contain at least one lowercase letter.";
    }
    if (!preg_match("/[0-9]/", $password)) {
        $error_message .= "Password must contain at least one digit.<br>";
    }
    if (!preg_match("/[\W]/", $password)) {
        $error_message .= "Password must contain at least one special character.";
    }

    if ($password !== $confirmPassword) {
        $error_message .= "Passwords do not match.";
    }

    if (empty($error_message)) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE tbl_user SET Password='$password' WHERE EmailID='$email'";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Password Update Successful!');
            window.location.replace('./login.php');</script>";
        } else {
            echo "<script>alert('Password Update Failed!');
            window.location.replace('./forgetPassword.php');</script>";
        }
    } else {
        echo "<script>alert('$error_message');</script>";
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="styleverfication.css">

    <link rel="icon" href="Favicon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Eventify | Change Password</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .popup_inner {
            font-family: Arial, sans-serif;
        }

        input,
        textarea,
        select,
        button {
            font-family: Arial, sans-serif;
        }

        #password-strength {
            margin-top: 5px;
        }

        .strength-weak {
            color: red;
        }

        .strength-medium {
            color: orange;
        }

        .strength-strong {
            color: green;
        }

        #password-match {
            margin-top: 5px;
        }

        .match-yes {
            color: green;
        }

        .match-no {
            color: red;
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
                                            <h3>Change Password</h3><br>
                                        </div>
                                        <form action="#" method="POST">
                                            <div class="form-group row">
                                                <div class="col-xl-12">
                                                    <input type="password" id="password" class="form-control" name="password" placeholder="New Password" required autofocus>
                                                    <label id="password-strength"></label>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-xl-12">
                                                    <input type="password" id="cpassword" class="form-control" name="ConfrimPassword" placeholder="Confirm Password" required>
                                                    <label id="password-match"></label>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <button type="submit" value="Verify" class="boxed_btn3" name="verify">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('password').addEventListener('input', function() {
            var password = this.value;
            var strengthLabel = document.getElementById('password-strength');
            var strength = '';

            if (password.length >= 8 &&
                /[A-Z]/.test(password) &&
                /[a-z]/.test(password) &&
                /[0-9]/.test(password) &&
                /[\W]/.test(password)) {
                strength = 'Strong Password';
                strengthLabel.className = 'strength-strong';
            } else if (password.length >= 6) {
                strength = 'Weak Password';
                strengthLabel.className = 'strength-weak';
            } else {
                strength = 'Too Short Password';
                strengthLabel.className = 'strength-weak';
            }

            strengthLabel.textContent = strength;
        });

        document.getElementById('cpassword').addEventListener('input', function() {
            var password = document.getElementById('password').value;
            var confirmPassword = this.value;
            var matchLabel = document.getElementById('password-match');

            if (password === confirmPassword) {
                matchLabel.textContent = 'Passwords match';
                matchLabel.className = 'match-yes';
            } else {
                matchLabel.textContent = 'Passwords do not match';
                matchLabel.className = 'match-no';
            }
        });
    </script>

</body>

</html>
