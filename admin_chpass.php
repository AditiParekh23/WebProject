<?php
session_start();
error_reporting(0);
include_once('./config.php'); // Database connection

// Check if the user is a customer and logged in
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if (isset($_POST['verify'])) {
    $email = $_SESSION['email']; // Assuming email is stored in session after login
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['ConfrimPassword'];

    $error_message = '';

    // Check if the old password matches the one in the database
    $sql = "SELECT Password FROM tbl_user WHERE EmailID='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['Password'];

        // Verify the old password
        if (password_verify($oldPassword, $hashedPassword)) {
            // Proceed to check the new password
            if (strlen($newPassword) < 8) {
                $error_message .= "Password must be at least 8 characters long.";
            }
            if (!preg_match("/[A-Z]/", $newPassword)) {
                $error_message .= "Password must contain at least one uppercase letter.";
            }
            if (!preg_match("/[a-z]/", $newPassword)) {
                $error_message .= "Password must contain at least one lowercase letter.";
            }
            if (!preg_match("/[0-9]/", $newPassword)) {
                $error_message .= "Password must contain at least one digit.";
            }
            if (!preg_match("/[\W]/", $newPassword)) {
                $error_message .= "Password must contain at least one special character.";
            }

            if ($newPassword !== $confirmPassword) {
                $error_message .= "Passwords do not match.<br>";
            }

            if (empty($error_message)) {
                // Hash the new password
                $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // SQL query to update the password
                $updateSql = "UPDATE tbl_user SET Password='$newHashedPassword' WHERE EmailID='$email'";

                if ($conn->query($updateSql) === TRUE) {
                    echo "<script>alert('Password Update Successful!');
                    window.location.replace('./login.php');</script>";
                } else {
                    echo "<script>alert('Password Update Failed! Please try again.');
                    window.location.replace('./changePassword.php');</script>";
                }
            } else {
                echo "<script>alert('$error_message');</script>";
            }
        } else {
            // If the old password doesn't match
            echo "<script>alert('Old password is incorrect.');</script>";
        }
    } else {
        echo "<script>alert('User not found.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->

    <link rel="icon" href="Favicon.png">
    <title>Eventify | Change Password</title>

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
            margin-bottom: 20px; /* Ensures consistent spacing between input fields */
        }

        /* Set equal padding/margin for all form elements */
        .form-control {
            padding: 10px;
            margin-bottom: 15px;
            width: 100%;
        }

        /* For Password Strength and Match Feedback */
        #password-strength,
        #password-match {
            margin-top: -10px;
            margin-bottom: 15px;
            font-weight: bold;
            font-size: 14px;
        }

        /* Styles for password strength */
        .strength-weak {
            color: red !important;
        }

        .strength-medium {
            color: orange !important;
        }

        .strength-strong {
            color: green !important;
        }

        /* Styles for password match */
        .match-no {
            color: red !important;
        }

        .match-yes {
            color: green !important;
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
                                        <form method="post">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <input type="password" id="old-password" class="form-control" required placeholder="Enter your Old Password" name="old_password">
                                                </div>
                                                <div class="col-xl-12">
                                                    <input type="password" id="password" class="form-control" required placeholder="Enter your New Password" name="password">
                                                    <p id="password-strength"></p> <!-- Password strength feedback -->
                                                </div>
                                                <div class="col-xl-12">
                                                    <input type="password" id="cpassword" class="form-control" required placeholder="Re-Enter your New Password" name="ConfrimPassword">
                                                    <p id="password-match"></p> <!-- Password match feedback -->
                                                </div>
                                                <div class="col-xl-12">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <button type="submit" class="boxed_btn3" name="verify" style="width: 100%;">Submit</button>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <a href="setting.php" class="boxed_btn3" style="display: inline-block; text-align: center; width: 100%;">Cancel</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12">
                                                    <br>
                                                    <p style="text-align: center"><a href="EmailId.php" style="color: #C78665">Forgot Password?</a></p>
                                                </div>
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
        // Password strength checker
        document.getElementById('password').addEventListener('input', function () {
            var password = this.value;
            var strengthLabel = document.getElementById('password-strength');
            var strength = '';
            var strengthClass = '';

            if (password.length >= 8 &&
                /[A-Z]/.test(password) &&
                /[a-z]/.test(password) &&
                /[0-9]/.test(password) &&
                /[\W]/.test(password)) {
                strength = 'Strong Password';
                strengthClass = 'strength-strong';
            } else if (password.length >= 6) {
                strength = 'Medium Password';
                strengthClass = 'strength-medium';
            } else {
                strength = 'Weak Password';
                strengthClass = 'strength-weak';
            }

            // Remove existing classes and add the new one
            strengthLabel.className = '';
            strengthLabel.classList.add(strengthClass);
            strengthLabel.textContent = strength;
        });

        // Password match checker
        document.getElementById('cpassword').addEventListener('input', function () {
            var password = document.getElementById('password').value;
            var confirmPassword = this.value;
            var matchLabel = document.getElementById('password-match');
            var matchClass = '';

            if (password === confirmPassword) {
                matchLabel.textContent = 'Passwords match';
                matchClass = 'match-yes';
            } else {
                matchLabel.textContent = 'Passwords do not match';
                matchClass = 'match-no';
            }

            // Remove existing classes and add the new one
            matchLabel.className = '';
            matchLabel.classList.add(matchClass);
        });
    </script>

</body>

</html>
