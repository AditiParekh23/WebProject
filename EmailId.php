<?php
@session_start();
error_reporting(0);
include_once('./config.php');

if (isset($_POST['verify'])) {
    $email = $_POST['email_Id'];
    $_SESSION['email'] = $email;

    $check_query = "SELECT * FROM tbl_user WHERE EmailID = '$email'";
    $result = $conn->query($check_query);


    if ($result->num_rows > 0) {
        include './forgetMail.php';
        sendMail($email);
        echo "<script>window.location.replace('./forgetVerification.php');</script>";
    } else {
        echo '<script>alert("Email Id is not exists!")</script>';
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
<!------ Include the above in your HEAD tag ---------->
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
   
    <link rel="stylesheet" href="css/style.css">
  
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
                                            <h3>Verify Account</h3><br>
                                        </div>
                                        <form action="#" method="POST" onsubmit="return checkEmail()">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <input type="text"  id="email" required placeholder="Email" name="email_Id" autofocus>
                                                    
                                                </div>
                                                <span id="emailError"></span>
                                             
                                                <div class="col-xl-12">
                                                    <button type="submit" value="Verify" class="boxed_btn3" name="verify">verify Now</button>
                                         
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
        function checkEmail(){
    var email = document.getElementById("email").value;
    var emailCheck = /^[A-Za-z_0-9]{3,}@[A-Za-z.]{3,}[.]{1}[A-Za-z]{2,10}$/;

            if (emailCheck.test(email)) {
      document.getElementById('emailError').innerHTML = "";
    }
    else {
      document.getElementById('emailError').innerHTML = "**Please Enter EmailId";
      return false;
    }

        }
    </script>
</body>
</html>
