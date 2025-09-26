<?php

session_start();
include('config.php');
include './forgetMail.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $area = $_POST['area'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    $error_message = "";

    // Store form data in session variables
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
    $_SESSION['contact'] = $contact;
    $_SESSION['address'] = $address;
    $_SESSION['area'] = $area;
    $_SESSION['password']=$password;
    // Password validation
    if (strlen($password) < 8) {
        $error_message .= "Password must be at least 8 characters long.<br>";
    }
    if (!preg_match("/[A-Z]/", $password)) {
        $error_message .= "Password must contain at least one uppercase letter.<br>";
    }
    if (!preg_match("/[a-z]/", $password)) {
        $error_message .= "Password must contain at least one lowercase letter.<br>";
    }
    if (!preg_match("/[0-9]/", $password)) {
        $error_message .= "Password must contain at least one digit.<br>";
    }
    if (!preg_match("/[\W]/", $password)) {
        $error_message .= "Password must contain at least one special character.<br>";
    }
    if (!preg_match("/^[6-9][0-9]{9}$/", $contact)) {
        $error_message .= "Contact number must start with digits [6-9] and be exactly 10 digits long.<br>";
    }

    if (!empty($error_message)) {
        echo "<div style='color:red;'>$error_message</div>";
    } else {
        //$hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "SELECT * FROM tbl_user WHERE EmailID=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('User already present.')</script>";
        } else {
            if ($password == $cpassword) {
                // Generate OTP
                $otp = rand(100000, 999999);
                $_SESSION['otp'] = $otp;
                sendMail($email, $otp);

                // Redirect to OTP verification page
                header("Location: customerverification.php");
                exit();
            } else {
                echo "<script>alert('Password not matched.')</script>";
            }
        }
        $stmt->close();
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Eventify | Customer Registration</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS here -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/gijgo.css">
    <link rel="stylesheet" href="css/slicknav.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <link rel="stylesheet" href="css/responsive.css"> -->
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .popup_inner {
            font-family: Arial, sans-serif;
        }
        input, textarea, select, button {
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
                        <div class="flower_1 d-none d-lg-block">
                            <img src="img/appointment/flower-top.png" alt="">
                        </div>
                        <div class="flower_2 d-none d-lg-block">
                            <img src="img/appointment/flower-bottom.png" alt="">
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-xl-7 col-lg-8">
                                <div class="popup_box">
                                    <div class="popup_inner">
                                        <div class="form_heading text-center">
                                            <h3>Registration</h3>
                                        </div>
                                        <form method="POST">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <input type="text" required placeholder="Your Name" name="name">
                                                </div>
                                                <div class="col-xl-12">
                                                    <input type="email" required placeholder="Email" name="email">
                                                </div>
                                                <div class="col-xl-12">
                                                    <input type="text" name="contact" pattern="[6-9][0-9]{9}" title="Enter a valid phone number starting with 6-9 and 10 digits long" placeholder="Contact Number" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                                </div>
                                                <div class="col-xl-12">
                                                    <select class="form-select wide" id="default-select" name="area" required>
                                                        <option value="" disabled selected>Select Area</option>
                                                        <?php
                                                        include('config.php');
                                                        $Area = mysqli_query($conn, "SELECT * FROM tbl_area");
                                                        while ($a = mysqli_fetch_array($Area)) {
                                                            ?>
                                                            <option value="<?php echo $a['ID'] ?>"><?php echo $a['Name'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-xl-12">
                                                    <textarea required placeholder="Address" name="address"></textarea>
                                                </div>
                                                <div class="col-xl-12">
                                                    <input type="password" id="password" name="password" required placeholder="Enter your password">
                                                    <label id="password-strength"></label>
                                                </div>
                                                <div class="col-xl-12">
                                                    <input type="password" id="cpassword" name="cpassword" required placeholder="Confirm your password">
                                                    <label id="password-match"></label>
                                                </div>
                                                <div class="col-xl-12">
                                                    <button type="submit" name="submit" class="boxed_btn3">Submit</button>
                                                </div>
                                                <div class="col-xl-12">
                                                    <br><p style="text-align: center">Already have an account? <a href="login.php" style="color: #C78665">Login now</a></p>
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
    <!-- footer_end -->
    <!-- JS here -->
    <script src="js/vendor/modernizr-3.5.0.min.js"></script>
    <script src="js/vendor/jquery-1.12.4.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/isotope.pkgd.min.js"></script>
    <script src="js/ajax-form.js"></script>
    <script src="js/waypoints.min.js"></script>
    <script src="js/jquery.counterup.min.js"></script>
    <script src="js/imagesloaded.pkgd.min.js"></script>
    <script src="js/scrollIt.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
    <script src="js/wow.min.js"></script>
    <script src="js/nice-select.min.js"></script>
    <script src="js/gijgo.min.js"></script>
    <script src="js/jquery.countdown.min.js"></script>
    <script src="js/jquery.slicknav.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/plugins.js"></script>
    <!--contact js-->
    <script src="js/contact.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.form.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/mail-script.js"></script>
    <script src="js/main.js"></script>
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
