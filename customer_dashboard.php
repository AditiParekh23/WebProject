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

            .vendor .box-container {
                display: flex;
                align-items: center;
                justify-content: center;
                flex-wrap: wrap;
            }

            .vendor .box-container .box {
                flex: 1 1 calc(33% - 2rem); /* Adjust box size to fit within the container */
                margin: 1rem;
                overflow: hidden;
                position: relative;
                border-radius: 0.5rem;
                box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.9);
                height: 25rem;
                cursor: pointer;
            }

            /* Anchor wrapping the box */
            .vendor .box-container a {
                flex: 1 1 30rem; /* Adjust the size of the anchor */
                margin: 1rem;
                text-decoration: none;
            }

            .vendor .box-container .box {
                flex: 1 1 calc(33% - 2rem); /* Box size to fit within container */
                margin: 1rem;
                position: relative;
                border-radius: 0.5rem;
                box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.9);
                height: 300px; /* Set a fixed height for all boxes */
                overflow: hidden;
                cursor: pointer;
            }

            .vendor .box-container .box img {
                width: 100%;
                height: 100%;
                object-fit: cover; /* Ensures the image covers the box area without distorting */
            }


            .vendor .box-container .box .info {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                position: absolute;
                top: 0;
                left: 0;
                height: 100%;
                width: 100%;
                background: rgba(255, 255, 255, 0.8);
                text-align: center;
                transform: scale(1.3);
                opacity: 0;
                transition: opacity 0.5s ease, transform 0.5s ease;
            }

            .vendor .box-container .box:hover .info {
                opacity: 1;
                transform: scale(1);
            }

            .vendor .box-container .box .info h3 {
                font-size: 2rem;
                color: #333;
            }

            .vendor .box-container .box .info p {
                font-size: 1.2rem;
                color: #666;
                margin: 0.5rem 0 1rem 0;
            }

            .vendor .box-container .box .info .btn {
                display: inline-block;
                padding: 0.8rem 2rem;
                background-color: #C78665;
                color: white;
                text-decoration: none;
                border-radius: 5px;
                transition: background-color 0.3s ease, color 0.3s ease;
            }

            .vendor .box-container .box .info .btn:hover {
                background-color: white;
                color: #C78665;
                border: 1px solid #C78665;
            }

            /* Responsive design for smaller screens */
            @media (max-width: 768px) {
                .vendor .box-container .box {
                    flex: 1 1 calc(100% - 2rem);
                    margin: 1rem;
                }

                .vendor .box-container a {
                    flex: 1 1 calc(100% - 2rem); /* Ensure the anchor behaves similarly */
                }
            }

            .carousel {
                max-height: 600px; /* Set a max height for the carousel */
                overflow: hidden; /* Hide overflow to prevent image spilling */
            }

            .carousel-item img {
                width: 100%;
                height: 100%; /* Fill the entire height of the carousel */
                object-fit: cover; /* Cover the area without distortion */
            }

            @media (max-width: 768px) {
                .carousel {
                    max-height: 300px; /* Adjust for smaller screens */
                }
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
                                            <li><a class="active" href="customer_dashboard">Home</a></li>
                                            <li><a href="#">Vendors<i class="ti-angle-down"></i></a>
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

        <!--/ slider_area -->
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="3000">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="img/slider/7.jpg" alt="First slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="img/slider/1.jpg" alt="Third slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="img/slider/20.jpg" alt="Fourth slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="img/slider/13.jpg" alt="Fifth slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="img/slider/12.jpg" alt="sixth slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="img/slider/16.jpg" alt="seventh slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="img/slider/8.jpg" alt="eightth slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="img/slider/9.jpg" alt="nineth slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="img/slider/23.jpg" alt="tenth slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="img/slider/21.jpg" alt="eleventh slide">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <!-- vendor section starts  -->

        <section class="vendor" id="vendor">
            <div class="heading">
                <img src="img/banner/flowers.png" alt="Flowers">
                <h1>Top Wedding Vendors</h1>
            </div>

            <div class="box-container">
                <a href="decorator.php">
                    <div class="box">
                        <img src="img/vendor/img4.jpg" alt="Decorator">
                        <div class="info">
                            <h3>Decorators</h3>
                        </div>
                    </div>
                </a>

                <a href="caterer.php">
                    <div class="box">
                        <img src="img/vendor/img7.jpg" alt="Caterers">
                        <div class="info">
                            <h3>Caterers</h3>
                        </div>
                    </div>
                </a>

                <a href="venue.php">
                    <div class="box">
                        <img src="img/vendor/img8.jpg" alt="Venue and Hall">
                        <div class="info">
                            <h3>Venue</h3>
                        </div>
                    </div>
                </a>

                <a href="dj.php">
                    <div class="box">
                        <img src="img/vendor/img11.jpg" alt="DJ Party">
                        <div class="info">
                            <h3>DJ Party</h3>
                        </div>
                    </div>
                </a>

                <a href="photographer.php">
                    <div class="box">
                        <img src="img/vendor/img10.jpg" alt="Photographer">
                        <div class="info">
                            <h3>Photographers</h3>
                        </div>
                    </div>
                </a>
            </div>
        </section>



        <!-- footer_start -->
        <footer class="footer">
            <div class="footer_top">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="quick_links">
                                <ul>
                                    <li><a href="#">Home</a></li>
                                    <li><a href="#">Our Story</a></li>
                                    <li><a href="#">Gallery</a></li>
                                    <li><a href="#">Accommodation</a></li>
                                    <li><a href="#">Contact</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </footer>
        <!-- footer_end -->

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
