<!doctype html>
<html class="no-js" lang="zxx">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Eventify</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- <link rel="manifest" href="site.webmanifest"> -->
        <!-- <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png"> -->
        <!-- Place favicon.ico in the root directory -->

        <!-- CSS here -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/owl.carousel.min.css">
        <link rel="stylesheet" href="css/magnific-popup.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/themify-icons.css">
        <link rel="stylesheet" href="css/nice-select.css">
        <link rel="stylesheet" href="css/flaticon.css">
        <link rel="stylesheet" href="css/flaticon.css">
        <link rel="stylesheet" href="css/gijgo.css">
        <link rel="stylesheet" href="css/slicknav.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- <link rel="stylesheet" href="css/responsive.css"> -->
        <style>
            /* Sans-serif handwriting style */
            body {
                font-family: sans-serif;
                line-height: 1.6;
                color: #333;
                padding: 20px;
                padding-left: 30px;
            }

            p {
                font-family: sans-serif;
                font-size: 1.2rem; /* Adjust font size for readability */
                margin-bottom: 1.5rem;
            }

            strong {
                font-weight: bold;
                font-size: 1.4rem;
            }

            a {
                color: #C78665; /* Set color for links */
                text-decoration: none;
            }

            a:hover {
                text-decoration: underline;
            }
            /* Terms and conditions styling */
            .terms {
                font-size: 1.2rem;
                font-weight: bold;
                margin-top: 2rem;
            }

            .terms-details {
                font-size: 0.8rem; /* Smaller font size */
                color: #666; /* Subtle text color */
                margin-top: 1rem;
                font-style: italic; /* Italics for emphasis */
            }


            /* Include the same CSS here */
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
    </head>

    <body>
        <!--[if lte IE 9]>
                <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
            <![endif]-->

        <!-- header-->
        <header>
            <div class="header-area ">
                <div class="main-header-area">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-xl-3 col-lg-3">
                                <div class="logo-img">
                                    <a href="index.php">
                                        <img src="img/Eventify logo.png" alt="">
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-9 col-lg-9">
                                <div class="main-menu  d-none d-lg-block">
                                    <nav>
                                        <ul id="navigation">
                                            <li><a class="active" href="index.php">home</a></li>
                                            <li><a href="#">Vendors<i class="ti-angle-down"></i></a>
                                                <ul class="submenu">
                                                    <li><a href="decorator.php">Decorators</a></li>
                                                    <li><a href="caterer.php">Caterers</a></li>
                                                    <li><a href="venue.php">Venue</a></li>
                                                    <li><a href="dj.php">DJ</a></li>
                                                    <li><a href="photographer.php">Photographers</a></li>
                                                </ul>
                                            </li>

                                            <li><a href="#about-us">About Us</a></li>
                                            <li>    </li>
                                            <button class="login-button"><i class="fa-solid fa-user"></i><a href="login.php">Log in</a></button>
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
        <footer>
            <div class="footer-area footer-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                           

                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <p id="about-us"><strong>About Us</strong></p>
        <p>Eventify - Your Personal Wedding Planner<br>
            Plan your wedding with us.<br>
            Perfectly planned, wonderfully executed.<br><br>
            Eventify is an Indian Wedding Planning Website where you can find the best wedding vendors, with prices and reviews at the click of a button. Whether you are looking to hire wedding planners in India, or looking for the top photographers. Eventify can help you solve your wedding planning woes through its unique features. With a detailed vendor list, inspiration gallery, you won't need to spend hours planning a wedding anymore.</p>
        <p>Eventify is your go-to platform for all event vendor needs.</p>
        <p>Email: <a href="mailto:eventify75@gmail.com">eventify75@gmail.com</a></p>
        <p>Contact: +91 6351634417</p>
        <p>Registered Address: Second Floor, Rigid Mall, Althan, Surat, Gujarat, India, 122002</p>
        <br>
        <p class="terms">Terms and Conditions*</p>
        <p class="terms-details">If for any reason your booking is cancelled by you, the booking amount will not be refunded. Please ensure you review our this cancellation policy before making a booking.</p>

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




    </body>

</html>