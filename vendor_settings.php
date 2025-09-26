<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
        <meta name="author" content="AdminKit">
        <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

        <link rel="canonical" href="https://demo-basic.adminkit.io/pages-profile.html" />

        <title>Profile | AdminKit Demo</title>

        <link href="css/app.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <style>
            body {
                font-family: 'Inter', sans-serif;
                background-color: #f8f9fa; /* Light background for the entire page */
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
                background-color: #f1f1f1; /* Light gray background */
                border-radius: 8px;
                border: 1px solid #ddd;
            }

            .option {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px;
                border-bottom: 1px solid #ddd; /* Divider line between options */
            }

            .option:last-child {
                border-bottom: none; /* Remove border for the last option */
            }

            .option span {
                font-size: 16px;
                color: #555;
            }

            .btn {
                padding: 8px 15px;
                border: none;
                border-radius: 5px;
                background-color: #007bff; /* Primary color */
                color: white;
                cursor: pointer;
                text-decoration: none; /* Remove underline */
                display: inline-block; /* Make the link behave like a button */
                transition: background-color 0.3s;
            }

            .btn:hover {
                background-color: #0056b3; /* Darker blue on hover */
            }

            .danger-zone {
                margin-top: 40px;
            }

            .danger-zone h3 {
                color: #dc3545; /* Danger color */
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
                color: #007bff; /* Primary color for footer links */
            }
        </style>
    </head>

    <body>
        <div class="wrapper">
            <nav id="sidebar" class="sidebar js-sidebar">
                <div class="sidebar-content js-simplebar">
                    <a class="sidebar-brand" href="index.php"> 
                        <img src="img/adminlogo.png" alt="Company Logo" class="align-middle" style="width: 100%;"> 
                    </a>

                    <ul class="sidebar-nav">
                        <li class="sidebar-header">Pages</li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="vendor_dashboard.php">
                                <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="vendor_profile.php">
                                <i class="align-middle" data-feather="user"></i> <span class="align-middle">Profile</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="service.php">
                                <i class="fa-solid fa-gears"></i><span class="align-middle">Services</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="vendor_images.php">
                                <i class="align-middle" data-feather="image"></i> <span class="align-middle">Image</span>
                            </a>
                        </li>
                        <li class="sidebar-item active">
                            <a class="sidebar-link" href="vendor_settings.php">
                                <i class="align-middle" data-feather="settings"></i> <span class="align-middle">Settings</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="vendor_review.php">
                                <i class="fa-regular fa-message" style="color: #949494;"></i><span class="align-middle">Reviews</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="logout.php">
                                <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Log-out</span>
                            </a>
                        </li>

                    </ul>
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
                                        <span class="indicator">4</span>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
                                    <div class="dropdown-menu-header">4 New Notifications</div>
                                    <div class="list-group">
                                        <a href="#" class="list-group-item">
                                            <div class="row g-0 align-items-center">
                                                <div class="col-2">
                                                    <i class="text-danger" data-feather="alert-circle"></i>
                                                </div>
                                                <div class="col-10">
                                                    <div class="text-dark">Update completed</div>
                                                    <div class="text-muted small mt-1">Restart server 12 to complete the update.</div>
                                                    <div class="text-muted small mt-1">30m ago</div>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#" class="list-group-item">
                                            <div class="row g-0 align-items-center">
                                                <div class="col-2">
                                                    <i class="text-warning" data-feather="bell"></i>
                                                </div>
                                                <div class="col-10">
                                                    <div class="text-dark">Lorem ipsum</div>
                                                    <div class="text-muted small mt-1">Aliquam ex eros, imperdiet vulputate hendrerit et.</div>
                                                    <div class="text-muted small mt-1">2h ago</div>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#" class="list-group-item">
                                            <div class="row g-0 align-items-center">
                                                <div class="col-2">
                                                    <i class="text-primary" data-feather="home"></i>
                                                </div>
                                                <div class="col-10">
                                                    <div class="text-dark">Login from 192.186.1.8</div>
                                                    <div class="text-muted small mt-1">5h ago</div>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#" class="list-group-item">
                                            <div class="row g-0 align-items-center">
                                                <div class="col-2">
                                                    <i class="text-success" data-feather="user-plus"></i>
                                                </div>
                                                <div class="col-10">
                                                    <div class="text-dark">New connection</div>
                                                    <div class="text-muted small mt-1">Christina accepted your request.</div>
                                                    <div class="text-muted small mt-1">1d ago</div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="dropdown-menu-footer">
                                        <a href="#" class="text-muted">Show all notifications</a>
                                    </div>
                                </div>
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
                                <a href="changepassword.php" class="btn">Change</a>
                            </div>
                            <div class="option">
                                <span>Change Email Address</span>
                                <a href="update_email.php" class="btn">Change</a>
                            </div>
                            <div class="option">
                                <span>Update Profile</span>
                                <a href="emailpreferences.php" class="btn">Update</a>
                            </div>
                            <div class="option">
                                <span>Delete Account</span>
                                <a href="deleteaccount.php" class="btn" style="background-color: #dc3545;">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="js/app.js"></script>
    </body>

</html>
