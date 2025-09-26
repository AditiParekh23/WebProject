<?php
session_start();

// If the user role is not set or not a customer, redirect to login
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'customer') {
    header('Location: login.php');
    exit();
}

// Retrieve user data safely
$user = $_SESSION['user'] ?? [];
$name = $user['Name'] ?? '';
$email = $user['EmailID'] ?? ''; // Ensure email is captured
$contact_number = $user['Contact_Number'] ?? '';
?>


<!doctype html>
<html class="no-js" lang="zxx">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Eventify</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <style>
            /* Dropdown Container */
            .dropdown {
                position: relative;
                display: inline-block;
            }

            /* Dropdown Button */
            .dropdown-toggle {
                cursor: pointer;
            }

            /* Dropdown Content (Hidden by Default) */
            .dropdown-menu {
                display: none;
                position: absolute;
                background-color: #f9f9f9;
                min-width: 160px;
                box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
                z-index: 1;
            }

            /* Dropdown Links */
            .dropdown-menu li {
                padding: 8px 16px;
            }

            .dropdown-menu li a {
                text-decoration: none;
                color: black;
                display: block;
            }

            /* Show the Dropdown Menu */
            .dropdown:hover .dropdown-menu {
                display: block;
            }

            /* Change color of dropdown links on hover */
            .dropdown-menu li a:hover {
                background-color: #f1f1f1;
            }

        </style>

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
    </head>

    <body>
        <!-- header-->
        <header>
            <div class="header-area ">
                <div class="main-header-area">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-xl-3 col-lg-3">
                                <div class="logo-img">
                                    <a href="vendordashboard.html">
                                        <img src="img/Eventify logo.png" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-9 col-lg-9">
                                <div class="main-menu d-none d-lg-block">
                                    <nav>
                                        <ul id="navigation">
                                            <li><a  href="customer_dashboard">Home</a></li>
                                            <li><a class="active" href="#">Vendors<i class="ti-angle-down"></i></a>
                                                <ul class="submenu">
                                                    <li><a href="decorator.php">Decorators</a></li>
                                                    <li><a href="caterer.php">Caterers</a></li>
                                                    <li><a href="venue.php">Venue</a></li>
                                                    <li><a href="dj.php">DJ</a></li>
                                                    <li><a href="photographer.php">Photographers</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="">Ideas</a></li>
                                            <li><a href="#">Blog <i class="ti-angle-down"></i></a>
                                                <ul class="submenu">
                                                    <li><a href="">Decorators</a></li>
                                                    <li><a href="">Caterers</a></li>
                                                    <li><a href="">Venue</a></li>
                                                    <li><a href="">DJ</a></li>
                                                    <li><a href="">Photographers</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="">Contact</a></li>
                                            <li><span></span></li>
                                            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'customer'): ?>
                                                <li>
                                                    <i class="fa-solid fa-user"></i>
                                                    <a href="customerProfile.php"><?php echo htmlspecialchars($_SESSION['user']['Name']); ?></a>
                                                    <ul class="submenu">
                                                        <li>
                                                            <a href="customerprofile.php">
                                                                <i class="fa-solid fa-id-card" style="font-size: 15px;"></i> My Account
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="logout.php" onclick="confirmLogout()">
                                                                <i class="fa-solid fa-right-from-bracket" style="font-size: 15px;"></i> Logout
                                                            </a>
                                                        </li>
                                                    </ul>

                                                </li>
                                            <?php else: ?>
                                                <li>
                                                    <a href="login.php" class="login-button">
                                                        <i class="fa-solid fa-user"></i> Log in
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mobile_menu d-block d-lg-none"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!--/ header-->

        <script>
            function confirmLogout() {
                var confirmation = confirm("Are you sure you want to log out?");
                if (confirmation) {
                    window.location.href = 'logout.php';
                }
            }
        </script>

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
    </body>

</html>
