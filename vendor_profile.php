<?php
require_once 'config.php';
session_start();

// Prevent page caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Check if the user is logged in as a vendor
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'vendor') {
    header('Location: login.php');
    exit();
}

// Retrieve vendor data safely
$vendor = $_SESSION['user']; // Assume this contains the vendor's data
$id = $vendor['ID'] ?? 'N/A';  // Vendor ID
$name = $vendor['Name'] ?? 'N/A';  // Default to 'N/A' if Name is not set
$contact_number = $vendor['ContactNumber'] ?? 'N/A';  // Default to 'N/A' if Contact_Number is not set
$email = $_SESSION['email'] ?? 'N/A';  // Email stored in the session
$service_id = $vendor['ServiceID'] ?? 'N/A';  // Service ID
$company_name = $vendor['CompanyName'] ?? 'N/A';  // Company Name
$gst_number = $vendor['GST_Number'] ?? 'N/A';  // GST Number
// Debugging output to check the vendor data
// Uncomment the line below to see the output of the vendor array
// var_dump($vendor); exit();
// Handle form submission to update vendor data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_name = $conn->real_escape_string($_POST['vendorName']);
    $new_contact_number = $conn->real_escape_string($_POST['vendorPhone']);
    $new_company_name = $conn->real_escape_string($_POST['vendorCompany']);
    $new_gst_number = $conn->real_escape_string($_POST['vendorGST']);

    // Update the vendor data in the database
    $sql = "UPDATE tbl_Vendor SET Name = '$new_name', ContactNumber = '$new_contact_number', 
            CompanyName = '$new_company_name', GST_Number = '$new_gst_number' WHERE ID = $id";

    if ($conn->query($sql) === TRUE) {
        // Update session data with new values
        $_SESSION['user']['Name'] = $new_name;
        $_SESSION['user']['ContactNumber'] = $new_contact_number;
        $_SESSION['user']['CompanyName'] = $new_company_name;
        $_SESSION['user']['GST_Number'] = $new_gst_number;

        // Redirect back to the profile page with a success message
        header('Location: vendorProfile.php?success=1');
        exit();
    } else {
        echo "<script>alert('Error updating record: " . $conn->error . "');</script>";
    }
}

// Close the database connection
$conn->close();
?>


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
            .profile-container {
                margin: 20px auto;
                max-width: 600px;
                padding: 20px;
                border: 1px solid #ddd;
                border-radius: 10px;
                background-color: #ffffff;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }

            .profile-title {
                font-family: 'Arial', sans-serif;
                font-size: 24px; /* Increased font size */
                margin-bottom: 20px;
                text-align: center;
                color: #333;
            }

            .form-group {
                margin-bottom: 15px; /* Increased spacing between form groups */
            }

            .form-group label {
                font-size: 16px; /* Larger font size for labels */
                font-weight: bold;
                margin-bottom: 5px;
                display: block;
                color: #555;
            }

            .form-control {
                font-size: 16px; /* Increased font size for inputs */
                padding: 10px;
                border-radius: 5px;
                border: 1px solid #ddd;
                transition: border-color 0.3s;
            }

            .form-control:focus {
                border-color: #007bff; /* Blue border on focus */
                box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            }

            .btn-update {
                display: block;
                width: 100%;
                padding: 10px;
                background-color: #007bff; /* Primary color */
                border: none;
                color: white;
                border-radius: 5px;
                font-size: 16px; /* Larger button font */
                transition: background-color 0.3s;
            }

            .btn-update:hover {
                background-color: #0056b3; /* Darker blue on hover */
            }

            .form-control[readonly] {
                background-color: #f5f5f5; /* Light gray background */
                cursor: not-allowed; /* Change cursor to indicate non-editable */
            }


            .alert {
                margin-top: 20px;
                padding: 10px;
                border-radius: 5px;
                background-color: #d4edda; /* Light green background */
                color: #155724; /* Dark green text */
                border: 1px solid #c3e6cb;
                text-align: center; /* Centered alert text */
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
                        <li class="sidebar-header">
                            Pages
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="vendor_dashboard.php">
                                <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                            </a>
                        </li>

                        <li class="sidebar-item active">
                            <a class="sidebar-link" href="vendor_profile.php">
                                <i class="align-middle" data-feather="user"></i> <span class="align-middle">Profile</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="service.php">
                                <i class="fa-solid fa-gears"></i><span class="align-middle">services</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="vendor_images.php">
                                <i class="align-middle" data-feather="image"></i> <span class="align-middle">image</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="vendor_settingsS.php">
                                <i class="align-middle" data-feather="settings"></i> <span class="align-middle">settings</span>
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
                                    <div class="dropdown-menu-header">
                                        4 New Notifications
                                    </div>
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
                                                    <div class="text-muted small mt-1">14h ago</div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="dropdown-menu-footer">
                                        <a href="#" class="text-muted">Show all notifications</a>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-icon dropdown-toggle" href="#" id="messagesDropdown" data-bs-toggle="dropdown">
                                    <div class="position-relative">
                                        <i class="align-middle" data-feather="message-square"></i>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="messagesDropdown">
                                    <div class="dropdown-menu-header">
                                        <div class="position-relative">
                                            4 New Messages
                                        </div>
                                    </div>
                                    <div class="list-group">
                                        <a href="#" class="list-group-item">
                                            <div class="row g-0 align-items-center">
                                                <div class="col-2">
                                                    <img src="img/avatars/avatar-5.jpg" class="avatar img-fluid rounded-circle" alt="Vanessa Tucker">
                                                </div>
                                                <div class="col-10 ps-2">
                                                    <div class="text-dark">Vanessa Tucker</div>
                                                    <div class="text-muted small mt-1">Nam pretium turpis et arcu. Duis arcu tortor.</div>
                                                    <div class="text-muted small mt-1">15m ago</div>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#" class="list-group-item">
                                            <div class="row g-0 align-items-center">
                                                <div class="col-2">
                                                    <img src="img/avatars/avatar-2.jpg" class="avatar img-fluid rounded-circle" alt="William Harris">
                                                </div>
                                                <div class="col-10 ps-2">
                                                    <div class="text-dark">William Harris</div>
                                                    <div class="text-muted small mt-1">Curabitur ligula sapien euismod vitae.</div>
                                                    <div class="text-muted small mt-1">2h ago</div>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#" class="list-group-item">
                                            <div class="row g-0 align-items-center">
                                                <div class="col-2">
                                                    <img src="img/avatars/avatar-4.jpg" class="avatar img-fluid rounded-circle" alt="Christina Mason">
                                                </div>
                                                <div class="col-10 ps-2">
                                                    <div class="text-dark">Christina Mason</div>
                                                    <div class="text-muted small mt-1">Pellentesque auctor neque nec urna.</div>
                                                    <div class="text-muted small mt-1">4h ago</div>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#" class="list-group-item">
                                            <div class="row g-0 align-items-center">
                                                <div class="col-2">
                                                    <img src="img/avatars/avatar-3.jpg" class="avatar img-fluid rounded-circle" alt="Sharon Lessman">
                                                </div>
                                                <div class="col-10 ps-2">
                                                    <div class="text-dark">Sharon Lessman</div>
                                                    <div class="text-muted small mt-1">Aenean tellus metus, bibendum sed, posuere ac, mattis non.</div>
                                                    <div class="text-muted small mt-1">5h ago</div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="dropdown-menu-footer">
                                        <a href="#" class="text-muted">Show all messages</a>
                                    </div>
                                </div>
                            </li>
<?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'vendor'): ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                                        <i class="align-middle" data-feather="settings"></i>
                                    </a>

                                    <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                                        <img src="img/profile.png" class="avatar img-fluid rounded me-1" alt="<?php echo $_SESSION['user']['Name'] ?? 'Profile'; ?>" /> 
                                        <span class="text-dark"><?php echo $_SESSION['user']['Name'] ?? 'Guest'; ?></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="vendorProfile.php"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
                                        <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="pie-chart"></i> Analytics</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="index.php"><i class="align-middle me-1" data-feather="settings"></i> Settings & Privacy</a>
                                        <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="help-circle"></i> Help Center</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="logout.php">Log out</a>
                                    </div>
                                </li>
<?php else: ?>
                                <li>
                                    <a href="login.php" class="login-button">
                                        <i class="fa-solid fa-user"></i> Log in
                                    </a>
                                </li>
<?php endif; ?>

                        </ul>
                    </div>
                </nav>

                <div class="content">
                    <div class="profile-container">
                        <h2 class="profile-title">Vendor Profile</h2>

                        <!-- Display Success Message -->
<?php if (isset($_GET['success'])): ?>
                            <div class="alert alert-success">Profile updated successfully!</div>
                        <?php endif; ?>

                        <form action="vendorProfile.php" method="POST">
                            <div class="form-group">
                                <label for="vendorName">Name:</label>
                                <input type="text" class="form-control" id="vendorName" name="vendorName" value="<?php echo htmlspecialchars($name); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="vendorEmail">Email:</label>
                                <input type="email" class="form-control" id="vendorEmail" name="vendorEmail" value="<?php echo htmlspecialchars($email); ?>" readonly>
                            </div>

                            <div class="form-group">
                                <label for="vendorPhone">Phone Number:</label>
                                <input type="text" class="form-control" id="vendorPhone" name="vendorPhone" value="<?php echo htmlspecialchars($contact_number); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="vendorCompany">Company Name:</label>
                                <input type="text" class="form-control" id="vendorCompany" name="vendorCompany" value="<?php echo htmlspecialchars($company_name); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="vendorGST">GST Number:</label>
                                <input type="text" class="form-control" id="vendorGST" name="vendorGST" value="<?php echo htmlspecialchars($gst_number); ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-update">Save Changes</button>
                        </form>
                    </div>
                </div>

                <style>
                    .profile-container {
                        margin: 20px auto;
                        max-width: 600px;
                        padding: 20px;
                        border: 1px solid #ddd;
                        border-radius: 10px;
                        background-color: #ffffff;
                        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                    }

                    .profile-title {
                        font-family: 'Arial', sans-serif;
                        font-size: 24px; /* Increased font size */
                        margin-bottom: 20px;
                        text-align: center;
                        color: #333;
                    }

                    .form-group {
                        margin-bottom: 15px; /* Increased spacing between form groups */
                    }

                    .form-group label {
                        font-size: 16px; /* Larger font size for labels */
                        font-weight: bold;
                        margin-bottom: 5px;
                        display: block;
                        color: #555;
                    }

                    .form-control {
                        font-size: 16px; /* Increased font size for inputs */
                        padding: 10px;
                        border-radius: 5px;
                        border: 1px solid #ddd;
                        transition: border-color 0.3s;
                    }

                    .form-control:focus {
                        border-color: #007bff; /* Blue border on focus */
                        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
                    }

                    .form-control[readonly] {
                        background-color: #f5f5f5; /* Light gray background */
                        cursor: not-allowed; /* Change cursor to indicate non-editable */
                    }

                    .btn-update {
                        display: block;
                        width: 100%;
                        padding: 10px;
                        background-color: #007bff; /* Primary color */
                        border: none;
                        color: white;
                        border-radius: 5px;
                        font-size: 16px; /* Larger button font */
                        transition: background-color 0.3s;
                    }

                    .btn-update:hover {
                        background-color: #0056b3; /* Darker blue on hover */
                    }

                    .alert {
                        margin-top: 20px;
                        padding: 10px;
                        border-radius: 5px;
                        background-color: #d4edda; /* Light green background */
                        color: #155724; /* Dark green text */
                        border: 1px solid #c3e6cb;
                        text-align: center; /* Centered alert text */
                    }
                </style>


                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row text-muted">
                            <div class="col-6 text-start">
                                <p class="mb-0">
                                    <a class="text-muted" href="https://adminkit.io/" target="_blank"><strong>AdminKit</strong></a> - <a class="text-muted" href="https://adminkit.io/" target="_blank"><strong>Bootstrap Admin Template</strong></a>								&copy;
                                </p>
                            </div>
                            <div class="col-6 text-end">
                                <ul class="list-inline">
                                    <li class="list-inline-item">
                                        <a class="text-muted" href="https://adminkit.io/" target="_blank">Support</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a class="text-muted" href="https://adminkit.io/" target="_blank">Help Center</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a class="text-muted" href="https://adminkit.io/" target="_blank">Privacy</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a class="text-muted" href="https://adminkit.io/" target="_blank">Terms</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <script src="js/app.js"></script>

    </body>

</html>