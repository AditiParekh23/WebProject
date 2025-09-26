<?php
session_start();
require 'config.php';

// Check if the vendor is logged in
if (!isset($_SESSION['user']['VendorID'])) {
    header('Location: login.php');
    exit();
}

$vendorID = $_SESSION['user']['VendorID'];

// Fetch decoration data
$decorations = [];
$sql = "
    SELECT 
        d.DecorationType,
        dd.ID as DecorationDetailID,
        dd.Description,
        dd.Price,
        dd.BookingPrice,
        dd.DisplayImg 
    FROM 
        tbl_Decoration_Details dd
    JOIN 
        tbl_Vendor v ON dd.VendorID = v.ID
    JOIN 
        tbl_Decoration d ON dd.DecorationID = d.ID
    WHERE 
        v.ID = ?;
";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $vendorID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $decorations[] = $row;
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
        <meta name="description" content="Responsive Admin & Dashboard Template based on Bootstrap 5">
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
                                    <div class="dropdown-menu-header">
                                        4 New Notifications
                                    </div>
                                    <div class="list-group">
                                        <!-- Notification content here -->
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
                                    <div class="dropdown-menu-header">4 New Messages</div>
                                    <div class="list-group">
                                        <!-- Message content here -->
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
                                    <h5 class="card-title mb-0">Decoration Services</h5>
                                    <a href="vendor_add_decoration.php" class="btn btn-success">Add</a>
                                </div>

                                <table class="table table-hover table-responsive">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Decoration Type</th>
                                            <th>Description</th>
                                            <th>Price</th>
                                            <th>Booking Price</th>
                                            <th>Image</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($decorations) > 0): ?>
                                            <?php foreach ($decorations as $index => $decoration): ?>
                                                <tr>
                                                    <td><?php echo $index + 1; ?></td>
                                                    <td><?php echo htmlspecialchars($decoration['DecorationType']); ?></td>
                                                    <td><?php echo htmlspecialchars($decoration['Description']); ?></td>
                                                    <td><?php echo htmlspecialchars($decoration['Price']); ?></td>
                                                    <td><?php echo htmlspecialchars($decoration['BookingPrice']); ?></td>
                                                    <td>
                                                        <img src="uploads/vendor_images/<?php echo htmlspecialchars($decoration['DisplayImg']); ?>" alt="Decoration Image">
                                                    </td>
                                                    <td class="action-buttons">
                                                        <a href="vendor_edit_decoration.php?id=<?php echo $decoration['DecorationDetailID']; ?>"><i class="fa-solid fa-pen-to-square" style="font-size: 20px;"></i></a>
                                                        <a href="vendor_delete_decoration.php?id=<?php echo $decoration['DecorationDetailID']; ?>"  onclick="return confirm('Are you sure you want to delete this decoration?');"><i class="fa-solid fa-trash" style="color: #d70909; font-size: 20px;"></i></a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="7" class="text-center">No decoration services available.</td>
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
