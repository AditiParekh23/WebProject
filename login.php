<?php
session_start();

// Prevent page caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Redirect if the user is already logged in
if (isset($_SESSION['user_role'])) {
    switch ($_SESSION['user_role']) {
        case 'admin':
            header('Location: aadmin_dashboard.php');
            exit();
        case 'vendor':
            header('Location: vendor_dashboard.php');
            exit();
        case 'customer':
            header('Location: customer_dashboard.php');
            exit();
        default:
            header('Location: index.php');
            exit();
    }
}

include('config.php');

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Sanitize input
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    // Prepare and execute query to check user credentials
    $stmt = $conn->prepare("SELECT * FROM tbl_user WHERE EmailID = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user && password_verify($password, $user['Password'])) {
        $userID = $user['ID'];
        $_SESSION['email'] = $email; // Store email in session
        // Check if the user is an admin
        if ($email === 'eventify75@gmail.com') {
            $_SESSION['user_role'] = 'admin';
            header('Location: aadmin_dashboard.php');
            exit();
        }

        // Check if the user is a vendor
        $stmt = $conn->prepare("SELECT * FROM tbl_vendor WHERE UserID = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $vendorResult = $stmt->get_result();
        $stmt->close();

        if ($vendorResult->num_rows > 0) {
            $vendorInfo = $vendorResult->fetch_assoc();
            $_SESSION['user'] = $vendorInfo;
            $_SESSION['user_role'] = 'vendor';
            $_SESSION['user']['VendorID'] = $vendorInfo['ID']; // Assuming 'ID' is VendorID

            header('Location: vendor_dashboard.php');
            exit();
        }


        // Check if the user is a customer
        $stmt = $conn->prepare("SELECT * FROM tbl_customer WHERE UserID = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $customerResult = $stmt->get_result();
        $stmt->close();

        if ($customerResult->num_rows > 0) {
            $customerInfo = $customerResult->fetch_assoc();
            $_SESSION['user'] = $customerInfo;
            $_SESSION['user_role'] = 'customer';
            header('Location: customer_dashboard.php');
            exit();
        }

        // If user is neither customer nor vendor
        echo "<script>alert('User type not found.');</script>";
    } else {
        echo "<script>alert('Incorrect email or password.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Eventify | Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <script>
            // Prevent the login page from being cached
            window.history.forward();

            // Prevent navigating back to the login page
            window.onload = function () {
                if (window.history && window.history.pushState) {
                    window.history.pushState(null, null, window.location.href);
                    window.onpopstate = function () {
                        window.history.pushState(null, null, window.location.href);
                    };
                }
            };
        </script>
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
                                                <h3>Login</h3>
                                            </div>
                                            <form method="post">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <input type="text" required placeholder="Email" name="email">
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <input type="password" name="password" required placeholder="Enter your password">
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <button type="submit" class="boxed_btn3" name="submit">Login Now</button>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <br>
                                                        <p style="text-align: center">Don't have an account? <a href="userrole.php" style="color: #C78665">Register Now</a></p>
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
        <script src="js/vendor/jquery-1.12.4.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>
