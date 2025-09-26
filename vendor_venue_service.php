<?php
session_start();
require 'config.php';

// Check if the vendor is logged in
if (!isset($_SESSION['user']['VendorID'])) {
    header('Location: login.php');
    exit();
}

$vendorID = $_SESSION['user']['VendorID'];

// Fetch venue data
$venues = [];
$sql = "
    SELECT 
        ve.VenueType,
        vd.ID as VenueDetailID,
        vd.Name,
        vd.Capacity,
        vd.FeatureDescription,
        vd.Address,
        vd.AreaID,
        vd.Price,
        vd.BookingPrice,
        vd.DisplayImg
    FROM 
        tbl_Venue_Detail vd
    JOIN 
        tbl_Vendor v ON vd.VendorID = v.ID
    JOIN 
        tbl_Venue ve ON vd.VenueID = ve.ID
    WHERE 
        v.ID = ?;  
";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $vendorID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $venues[] = $row;
    }
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
        <meta name="author" content="AdminKit">
        <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, php, theme, front-end, ui kit, web">

        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link rel="shortcut icon" href="img/icons/icon-48x48.png" />
        <link rel="canonical" href="https://demo-basic.adminkit.io/" />

        <title>Venue Service</title>

        <link href="css/app.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <style>
            img {
                max-width: 100px; /* Set a maximum width */
                height: auto; /* Maintain aspect ratio */
            }
            .action-buttons a {
                margin-right: 10px;
                text-decoration: none;
            }
        </style>
    </head>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
            <meta name="author" content="AdminKit">
            <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, php, theme, front-end, ui kit, web">

            <link rel="preconnect" href="https://fonts.gstatic.com">
            <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

            <link rel="canonical" href="https://demo-basic.adminkit.io/" />


            <title>Decoration Service</title>

            <link href="css/app.css" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

            <style>
                img {
                    max-width: 100px; /* Set a maximum width */
                    height: auto; /* Maintain aspect ratio */
                }
                .action-buttons a {
                    margin-right: 10px;
                    text-decoration: none;
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

                            <li class="sidebar-item">
                                <a class="sidebar-link" href="vendor_profile.php">
                                    <i class="align-middle" data-feather="user"></i> <span class="align-middle">Profile</span>
                                </a>
                            </li>
                            <li class="sidebar-item active">
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
                                <a class="sidebar-link" href="vendor_settings.php">
                                    <i class="align-middle" data-feather="settings"></i> <span class="align-middle">settings</span>
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

                    <div class="container-fluid" style="padding: 12px;">
                        <div class="row">
                            <div class="col-12 d-flex">
                                <div class="card flex-fill" style="width: 100%; max-width: 1240px; margin: auto; padding: 25px;">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">Venue Services</h5>
                                        <a href="vendor_add_venue.php" class="btn btn-success">Add</a>
                                    </div>
                                    <table class="table table-hover my-0">
                                        <thead>
                                            <tr>
                                                <th>Venue Type</th>
                                                <th class="d-none d-xl-table-cell">Venue Name</th>
                                                <th class="d-none d-xl-table-cell">Capacity</th>
                                                <th class="d-none d-xl-table-cell">Feature Description</th>
                                                <th class="d-none d-md-table-cell">Price</th>
                                                <th class="d-none d-md-table-cell">Booking Price</th>
                                                <th class="d-none d-md-table-cell">Display Image</th>
                                                <th class="d-none d-md-table-cell">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($venues)): ?>
                                                <?php foreach ($venues as $venue): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($venue['VenueType']); ?></td>
                                                        <td class="d-none d-xl-table-cell"><?php echo htmlspecialchars($venue['Name']); ?></td>
                                                        <td class="d-none d-xl-table-cell"><?php echo htmlspecialchars($venue['Capacity']); ?></td>
                                                        <td class="d-none d-xl-table-cell"><?php echo htmlspecialchars($venue['FeatureDescription']); ?></td>
                                                        <td class="d-none d-md-table-cell"><?php echo htmlspecialchars($venue['Price']); ?></td>
                                                        <td class="d-none d-md-table-cell"><?php echo htmlspecialchars($venue['BookingPrice']); ?></td>
                                                        <td class="d-none d-md-table-cell">
                                                            <img src="uploads/vendor_images/<?php echo htmlspecialchars($venue['DisplayImg']); ?>" alt="Image" />
                                                        </td>
                                                        <td class="action-buttons d-none d-md-table-cell">
                                                            <a href="vendor_edit_venue.php?id=<?php echo $venue['VenueDetailID']; ?>" >
                                                                <i class="fa-solid fa-pen-to-square" style="font-size: 20px;"></i>
                                                            </a>
                                                            <a href="vendor_del_venue.php?id=<?php echo $venue['VenueDetailID']; ?>" >
                                                                <i class="fa-solid fa-trash" style="color: #d70909; font-size: 20px;"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="8">No details found for Venues.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>

            <script src="js/app.js"></script>

        </body>

    </html>

