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
    // Check if delete request is made
    if (isset($_GET['delete_id'])) {
        $delete_id = intval($_GET['delete_id']);

        // Fetch the image path from the database
        $stmt = $conn->prepare("SELECT Image FROM tbl_image WHERE id = ?");
        $stmt->bind_param('i', $delete_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $image = $result->fetch_assoc();
            $imagePath = 'uploads/vendor_images/' . $image['Image'];
            // Delete the image from the filesystem
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            // Delete the image record from the database
            $stmt = $conn->prepare("DELETE FROM tbl_image WHERE id = ?");
            $stmt->bind_param('i', $delete_id);
            if ($stmt->execute()) {
                echo "<script>alert('Image deleted successfully.');</script>";
            } else {
                echo "<script>alert('Error deleting image: " . $conn->error . "');</script>";
            }
        }
        $stmt->close();
    }

    // Fetch images for the vendor
    $sql = "SELECT id, Image FROM tbl_image WHERE VendorID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $vendorID);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    echo "No vendor ID found.";
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Vendor Image View</title>
        <link href="css/app.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

        <style>
            body {
                font-family: 'Inter', sans-serif;
                background-color: #f8f9fa;
            }
            .content {
                flex-grow: 1; /* Allow content area to grow */
                background-color: white; /* Set the content background to white */
                padding: 20px; /* Optional: add some padding */
                overflow-y: auto; /* Optional: allows scrolling if content overflows */
            }


            .wrapper {
                display: flex;
                height: 100vh; /* Full viewport height */
            }

            /* Sidebar styles */
            .sidebar {
                min-width: 250px; /* Fixed width for sidebar */
                background-color: #343a40;
                color: white;
                display: flex;
                flex-direction: column;
            }

            .sidebar-content {
                overflow-y: auto; /* Scroll if content overflows */
                flex-grow: 1;
            }

            .sidebar-brand img {
                max-width: 100%;
                margin-bottom: 20px;
            }

            .sidebar-nav {
                list-style: none;
                padding: 0;
            }

            .sidebar-item {
                position: relative;
            }

            .sidebar-link {
                display: flex;
                align-items: center;
                padding: 15px 20px;
                color: white;
                text-decoration: none;
            }

            .sidebar-link:hover {
                background-color: #495057;
            }

            .sidebar-header {
                padding: 10px 20px;
                color: #adb5bd;
            }

            .image-container {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
                justify-content: center;
                padding: 20px;
                margin-left: 20px; /* Margin for sidebar */
            }

            .image-item {
                border: 1px solid #ccc;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                background-color: white;
                transition: transform 0.2s;
                max-width: 300px; /* Fixed width for cards */
            }

            .image-item:hover {
                transform: scale(1.05); /* Slight zoom effect on hover */
            }

            img {
                width: 100%;
                height: auto;
                display: block;
            }

            .delete-btn {
                background-color: #dc3545;
                color: white;
                border: none;
                padding: 8px 12px;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s;
                margin: 10px;
            }

            .delete-btn:hover {
                background-color: #c82333;
            }
        </style>
    </head>
    <body>
        <div class="wrapper">
            <nav id="sidebar" class="sidebar js-sidebar">
                <div class="sidebar-content js-simplebar">
                    <a class="sidebar-brand" href="index.php">
                        <img src="img/adminlogo.png" alt="Company Logo" class="align-middle">
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

            <div class="content">
                <div class="container">
                    <h1 class="text-center">Your Uploaded Images</h1>

                    <div class="image-container">
                        <?php
                        if ($result->num_rows > 0) {
                            // Output each image
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="image-item">';
                                echo '<img src="uploads/vendor_images/' . htmlspecialchars($row['Image']) . '" alt="Vendor Image">';
                                echo '<br>';
                                echo '<a href="?delete_id=' . $row['id'] . '" class="delete-btn" onclick="return confirm(\'Are you sure you want to delete this image?\');">Delete</a>';
                                echo '</div>';
                            }
                        } else {
                            echo "<p>No images found.</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <script src="js/app.js"></script>
    </body>
</html>

<?php
$conn->close();
?>
