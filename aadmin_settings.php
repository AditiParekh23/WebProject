<!-- 
eventify75@gmail.com
Eventify@009
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords"
        content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="canonical" href="https://demo-basic.adminkit.io/pages-profile.html" />

    <title>Profile | AdminKit Demo</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            /* Light background for the entire page */
        }

        .main {
            padding: 20px;
        }

        .content {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }

        .heading {
            margin-bottom: 20px;
            text-align: center;
        }

        .settings-section {
            margin-bottom: 30px;
        }

        .settings-section h3 {
            font-size: 20px;
            color: #333;
            margin-bottom: 15px;
        }

        .settings-options {
            padding: 10px;
            background-color: #f1f1f1;
            /* Light gray background */
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .option {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ddd;
            /* Divider line between options */
        }

        .option:last-child {
            border-bottom: none;
            /* Remove border for the last option */
        }

        .option span {
            font-size: 16px;
            color: #555;
        }

        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            /* Primary color */
            color: white;
            cursor: pointer;
            text-decoration: none;
            /* Remove underline */
            display: inline-block;
            /* Make the link behave like a button */
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
            /* Darker blue on hover */
        }

        .danger-zone {
            margin-top: 40px;
        }

        .danger-zone h3 {
            color: #dc3545;
            /* Danger color */
        }

        .footer {
            background-color: #ffffff;
            border-top: 1px solid #ddd;
            padding: 10px 20px;
            margin-top: 20px;
            text-align: center;
        }

        .footer p {
            margin: 0;
            color: #888;
        }

        .footer a {
            color: #007bff;
            /* Primary color for footer links */
        }
    </style>
</head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
<meta name="author" content="AdminKit">
<meta name="keywords"
    content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, php, theme, front-end, ui kit, web">

<link rel="preconnect" href="https://fonts.gstatic.com">
<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

<link rel="canonical" href="https://demo-basic.adminkit.io/" />


<title>Admin</title>

<link href="css/app.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <div class="wrapper">
        <nav id="sidebar" class="sidebar js-sidebar">
            <div class="sidebar-content js-simplebar">
                <a class="sidebar-brand" href="index.php">
                    <img src="img/adminlogo.png" alt="Company Logo" class="align-middle" style="width: 100%;">
                </a>

                <ul class="sidebar-nav">
                    <li class="sidebar-header">
                        Pages
                    </li>
                    <br>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="aadmin_dashboard.php">
                            <i class="align-middle" data-feather="sliders"></i> <span
                                class="align-middle">Dashboard</span>
                        </a>
                    </li>
                    <br>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="aadmin_eve.php">
                            <i class="align-middle" data-feather="star"></i> <span class="align-middle">Events</span>
                        </a>
                    </li>
                    <br>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="aadmin_user.php">
                            <i class="align-middle" data-feather="user"></i> <span class="align-middle">Users</span>
                        </a>
                    </li>
                    <br>
                    <li class="sidebar-item"></li>
                    <a class="sidebar-link" href="aadmin_payments.php">
                        <i class="align-middle" data-feather="dollar-sign"></i> <span
                            class="align-middle">Payments</span>
                    </a>
                    </li>

                    <br>
                    <li class="sidebar-item"></li>
                    <a class="sidebar-link" href="aadmin_feedback.php">
                        <i class="align-middle" data-feather="thumbs-up"></i> <span class="align-middle">Feedback</span>
                    </a>
                    </li>
                    <br>

                    <li class="sidebar-item active">
                        <a class="sidebar-link" href="aadmin_settings.php">
                            <i class="align-middle" data-feather="settings"></i> <span
                                class="align-middle">Settings</span>
                        </a>
                    </li>
                    <br>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="logout.php">
                            <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Log-out</span>
                        </a>
                    </li>
                    <br>
            </div>
        </nav>

        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle js-sidebar-toggle">
                    <i class="hamburger align-self-center"></i>
                </a>

                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav navbar-align">
                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
                                <div class="position-relative">
                                    <i class="align-middle" data-feather="bell"></i>
                                    <span class="indicator">.</span>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0"
                                aria-labelledby="alertsDropdown">

                                <div class="list-group">
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">

                                        </div>
                                    </a>

                                </div>
                                <div class="dropdown-menu-footer">
                                    <a href="#" class="text-muted">Show all notifications</a>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle" href="#" id="messagesDropdown"
                                data-bs-toggle="dropdown">
                                <div class="position-relative">
                                    <i class="align-middle" data-feather="message-square"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0"
                                aria-labelledby="messagesDropdown">
                                <div class="dropdown-menu-header">
                                    <div class="position-relative">
                                        4 New Messages
                                    </div>
                                </div>
                                <div class="list-group">
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">

                                        </div>
                                    </a>

                                </div>


                                <div class="dropdown-menu-footer">
                                    <a href="#" class="text-muted">Show all messages</a>
                                </div>
                            </div>
                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#"
                                data-bs-toggle="dropdown">
                                <i class="align-middle" data-feather="settings"></i>
                            </a>



                            <a class="nav-link d-none d-sm-inline-block">
                                <img src="img/profile.png" class="avatar img-fluid rounded me-1" alt="Charles Hall" />
                                <span class="text-dark">
                                    <a href="aadmin_settings.php" style="text-decoration: none; color: black;">Admin</a>
                                </span>
                            </a>

                        </li>
                    </ul>
                </div>
            </nav>

            <div class="content">
                <div class="heading">
                    <h2>Profile Settings</h2>
                </div>

                <div class="settings-section">
                    <h3>Account Settings</h3>
                    <div class="settings-options">
                        <div class="option">
                            <span>Change Password</span>
                            <a href="admin_chpass.php" class="btn">Change</a>
                        </div>
                       
                      

                    </div>
                </div>
            </div>

            <footer class="footer">
                <p class="mb-0">© 2024 Your Company. All rights reserved.</p>
                <p class="mb-0"><a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
            </footer>
        </div>
    </div>

    <script src="js/app.js"></script>

</body>

</html>