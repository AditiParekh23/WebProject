<?php
session_start();
include 'config.php';

// Check if the vendor is logged in
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'vendor') {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}

// Assuming the vendor ID is stored in the session
$vendorID = $_SESSION['user']['VendorID'] ?? null;

if ($vendorID) {
    // Handle Display Image Upload (only one image)
    if (isset($_POST['uploadDisplayImage']) && isset($_FILES['displayImage'])) {
        $image = $_FILES['displayImage'];

        // Check if the file was uploaded without errors
        if ($image['error'] === 0) {
            $targetDirectory = 'uploads/vendor_images/';

            // Check if the directory exists, if not, create it
            if (!is_dir($targetDirectory)) {
                mkdir($targetDirectory, 0777, true); // Create the directory with full permissions
            }

            // Generate a unique filename based on vendor ID and timestamp
            $newFilename = $vendorID . '_display_' . time() . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);

            $targetFile = $targetDirectory . $newFilename;

            // Move the uploaded file to the destination folder
            if (move_uploaded_file($image['tmp_name'], $targetFile)) {
                echo "Display image uploaded successfully.";

                // Update your database with the new file path for the display image
                $stmt = $conn->prepare("INSERT INTO tbl_image (VendorID, Image) VALUES (?, ?)");
                $stmt->bind_param('is', $vendorID, $newFilename);  // VendorID is 'i', image path is 's'
                $stmt->execute();
                $stmt->close();

                echo "Display image path updated in the database.";
            } else {
                echo "Failed to move uploaded display image.";
            }
        } else {
            echo "Error in display image upload.";
        }
    }

    // Handle Album Images Upload (multiple images allowed)
    if (isset($_POST['uploadAlbumImages']) && isset($_FILES['albumImages'])) {
        $albumImages = $_FILES['albumImages'];
        $albumTargetDirectory = 'uploads/album_images/';

        // Check if the directory exists, if not, create it
        if (!is_dir($albumTargetDirectory)) {
            mkdir($albumTargetDirectory, 0777, true); // Create the directory with full permissions
        }

        // Loop through each uploaded album image
        for ($i = 0; $i < count($albumImages['name']); $i++) {
            // Check if the file was uploaded without errors
            if ($albumImages['error'][$i] === 0) {
                // Generate a unique filename based on vendor ID and timestamp
                $albumFilename = $vendorID . '_album_' . time() . '_' . $i . '.' . pathinfo($albumImages['name'][$i], PATHINFO_EXTENSION);

                $albumTargetFile = $albumTargetDirectory . $albumFilename;

                // Move the uploaded file to the destination folder
                if (move_uploaded_file($albumImages['tmp_name'][$i], $albumTargetFile)) {
                    echo "Album image $i uploaded successfully.";

                    // Update your database with the new file path for the album image
                    $stmt = $conn->prepare("INSERT INTO tbl_image (VendorID, Image) VALUES (?, ?)");
                    $stmt->bind_param('is', $vendorID, $albumFilename);  // VendorID is 'i', image path is 's'
                    $stmt->execute();
                    $stmt->close();
                } else {
                    echo "Failed to move album image $i.";
                }
            } else {
                echo "Error in album image $i upload.";
            }
        }
    }
} else {
    echo "No vendor ID or image uploaded.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin & Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="canonical" href="https://demo-basic.adminkit.io/pages-profile.html" />
    <title>Profile | AdminKit Demo</title>

    <!-- Bootstrap and AdminKit Styles -->
    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        .profile-header {
            text-align: center;
            margin-top: 20px;
        }

        .profile-header h2 {
            font-size: 24px;
        }

        .profile-card {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 20px auto;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 5px;
            display: block;
        }

        .form-control {
            font-size: 14px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            width: 100%;
        }

        .submit-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        .submit-btn:hover {
            background-color: #218838;
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
                    <li class="sidebar-item active">
                        <a class="sidebar-link" href="vendor_profile.php">
                            <i class="align-middle" data-feather="user"></i> <span class="align-middle">Profile</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="vimg.php">
                            <i class="align-middle" data-feather="image"></i> <span class="align-middle">Upload Image</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="vendorImgView.php">
                            <i class="align-middle" data-feather="image"></i> <span class="align-middle">View Image</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="charts-chartjs.php">
                            <i class="align-middle" data-feather="settings"></i> <span class="align-middle">Settings</span>
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
            <div class="profile-header">
                <h2>Upload Vendor Images</h2>
            </div>

            <div class="profile-card">
                <form action="vimg.php" method="post" enctype="multipart/form-data">
                    <!-- Display Image Section -->
                    <div class="form-group">
                        <label for="displayImage" class="form-label">Choose a display image to upload:</label>
                        <input type="file" name="displayImage" id="displayImage" class="form-control" accept="image/*">
                        <button type="submit" name="uploadDisplayImage" class="submit-btn">Upload Display Image</button>
                    </div>

                    <!-- Album Images Section -->
                    <div class="form-group">
                        <label for="albumImages" class="form-label">Choose album images to upload (you can select multiple images):</label>
                        <input type="file" name="albumImages[]" id="albumImages" class="form-control" accept="image/*" multiple>
                        <button type="submit" name="uploadAlbumImages" class="submit-btn">Upload Album Images</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="js/app.js"></script>
</body>

</html>
