<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'vendor') {
    // If the user is not logged in, redirect them to the index page
    header('Location: index.php');
    exit();
}

// Retrieve user data safely
$user = $_SESSION['user'] ?? [];
$name = $user['Name'] ?? '';
$email = $user['EmailID'] ?? ''; // Ensure email is captured
$contact_number = $user['Contact_Number'] ?? '';
$vendorId = $user['VendorID'] ?? 0;

// Check if VendorID is set in the session
if (isset($_SESSION['user']['VendorID'])) {
    $vendorID = $_SESSION['user']['VendorID'];
} else {
    echo "VendorID is not set. Please log in again.";
    exit();
}

if ($vendorID) {
    // Handle Album Images Upload (multiple images allowed)
    if (isset($_POST['uploadAlbumImages']) && isset($_FILES['albumImages'])) {
        $albumImages = $_FILES['albumImages'];
        $albumTargetDirectory = 'uploads/album_images/';

        // Check if the directory exists, if not, create it
        if (!is_dir($albumTargetDirectory)) {
            mkdir($albumTargetDirectory, 0777, true); // Create the directory with full permissions
        }

        // Limit upload to 10 images
        if (count($albumImages['name']) > 10) {
            echo "You can upload a maximum of 10 images at a time.";
        } else {
            // Loop through each uploaded album image
            for ($i = 0; $i < count($albumImages['name']); $i++) {
                // Check if the file was uploaded without errors
                if ($albumImages['error'][$i] === 0) {
                    // Get the file extension
                    $fileExtension = strtolower(pathinfo($albumImages['name'][$i], PATHINFO_EXTENSION));

                    // Check for valid image formats
                    if (in_array($fileExtension, ['jpg', 'jpeg', 'png'])) {
                        // Generate a unique filename based on vendor ID and timestamp
                        $albumFilename = $vendorID . '_album_' . time() . '_' . $i . '.' . $fileExtension;

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
                        echo "Invalid file format for album image $i. Only JPG, JPEG, and PNG files are allowed.";
                    }
                } else {
                    echo "Error in album image $i upload.";
                }
            }
        }
    }

    // Handle image deletion
    if (isset($_POST['imagesToDelete'])) {
        $imagesToDelete = json_decode($_POST['imagesToDelete'], true);

        if (is_array($imagesToDelete)) {
            foreach ($imagesToDelete as $image) {
                // Prepare statement to delete image from database
                $stmt = $conn->prepare("DELETE FROM tbl_image WHERE VendorID = ? AND Image = ?");
                $stmt->bind_param('is', $vendorID, $image);
                $stmt->execute();
                $stmt->close();

                // Delete the image file from the folder
                $imagePath = 'uploads/album_images/' . $image;
                if (file_exists($imagePath)) {
                    unlink($imagePath); // Delete the file
                }
            }
            echo "Selected images deleted successfully.";
        } else {
            echo "No images selected for deletion.";
        }
    }

    // Fetch the vendor's uploaded images to display
    $stmt = $conn->prepare("SELECT Image FROM tbl_image WHERE VendorID = ?");
    $stmt->bind_param('i', $vendorID);
    $stmt->execute();
    $result = $stmt->get_result();
    $uploadedImages = $result->fetch_all(MYSQLI_ASSOC); // Fetch all images as an associative array
    $stmt->close();
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
        <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
        <meta name="author" content="AdminKit">
        <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, php, theme, front-end, ui kit, web">

        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

        <link rel="canonical" href="https://demo-basic.adminkit.io/" />

        <title>AdminKit Demo - Bootstrap 5 Admin Template</title>

        <link href="css/app.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
              integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
              crossorigin="anonymous" referrerpolicy="no-referrer" />

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
                font-size: 26px;
                font-weight: 600;
                color: #333;
            }

            .profile-card {
                background-color: #fff;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
                max-width: 1000px; /* Increased width for larger screens */
                margin: 20px auto;
            }

            .form-group {
                margin-bottom: 20px;
            }

            .form-label {
                font-weight: 500;
                margin-bottom: 8px;
                display: block;
            }

            .form-control {
                font-size: 14px;
                padding: 12px;
                border-radius: 5px;
                border: 1px solid #ddd;
                width: 100%;
            }

            .submit-btn {
                background-color: #28a745;
                color: white;
                border: none;
                padding: 12px 25px;
                font-size: 16px;
                border-radius: 5px;
                cursor: pointer;
                margin-top: 10px;
            }

            .submit-btn:hover {
                background-color: #218838;
            }

            .gallery {
                margin-top: 30px;
                text-align: center; /* Center images in the gallery */
            }

            .gallery img {
                width: 150px;
                height: 150px;
                object-fit: cover;
                margin: 10px;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                cursor: pointer; /* Change cursor to indicate clickable images */
            }

            .image-container {
                position: relative; /* Make sure it's relative for absolute positioning */
                display: inline-block; /* Allows multiple containers in a row */
                margin: 10px; /* Spacing between images */
            }

            .image-checkbox {
                position: absolute; /* Position the checkbox absolutely */
                top: 10px; /* Adjust position from top */
                left: 10px; /* Adjust position from left */
                z-index: 10; /* Ensure checkbox appears above the image */
                cursor: pointer; /* Change cursor to indicate clickable checkbox */
            }

            .gallery img.selected {
                border: 2px solid red; /* Red border to indicate image is selected for deletion */
            }

            /* Context Menu Styles */
            .context-menu {
                display: none;
                position: absolute;
                background: white;
                border: 1px solid #ddd;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
                z-index: 1000;
                border-radius: 5px;
            }

            .context-menu-item {
                padding: 10px 15px;
                cursor: pointer;
                white-space: nowrap;
            }

            .context-menu-item:hover {
                background: #f1f1f1;
            }

            /* Modal Styles */
            .modal {
                display: none; /* Hidden by default */
                position: fixed; /* Stay in place */
                z-index: 1000; /* Sit on top */
                padding-top: 60px; /* Location of the box */
                left: 0;
                top: 0;
                width: 100%; /* Full width */
                height: 100%; /* Full height */
                overflow: auto; /* Enable scroll if needed */
                background-color: rgba(0, 0, 0, 0.9); /* Black with opacity */
            }

            .modal-content {
                margin: auto;
                display: block;
                width: 80%;
                max-width: 700px;
                border-radius: 10px;
            }

            #caption {
                margin: auto;
                display: block;
                width: 80%;
                max-width: 700px;
                text-align: center;
                color: #ccc;
                padding: 10px 0;
            }

            .modal-content, #caption {
                animation-name: zoom;
                animation-duration: 0.6s;
            }

            @keyframes zoom {
                from {
                    transform: scale(0);
                }
                to {
                    transform: scale(1);
                }
            }

            /* Close Button */
            .close {
                position: absolute;
                top: 15px;
                right: 35px;
                color: #f1f1f1;
                font-size: 40px;
                font-weight: bold;
                transition: 0.3s;
            }

            .close:hover,
            .close:focus {
                color: #bbb;
                text-decoration: none;
                cursor: pointer;
            }

            /* Previous and Next buttons */
            .prev, .next {
                cursor: pointer;
                position: absolute;
                top: 50%;
                width: auto;
                padding: 16px;
                margin-top: -22px;
                color: white;
                font-weight: bold;
                font-size: 20px;
                transition: 0.3s;
                user-select: none;
                border-radius: 3px;
            }

            .next {
                right: 0;
                border-radius: 3px 0 0 3px;
            }

            .prev {
                left: 0;
                border-radius: 0 3px 3px 0;
            }

            .prev:hover, .next:hover {
                background-color: rgba(0, 0, 0, 0.8);
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .profile-card {
                    max-width: 90%; /* Reduce width on smaller screens */
                }

                .gallery img {
                    width: 120px; /* Slightly smaller images on small screens */
                    height: 120px;
                }

                .modal-content {
                    width: 90%; /* Smaller modal on small screens */
                }

                .prev, .next {
                    font-size: 16px;
                    padding: 10px;
                }

                #caption {
                    font-size: 14px;
                }
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
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="service.php">
                                <i class="fa-solid fa-gears"></i><span class="align-middle">services</span>
                            </a>
                        </li>
                        <li  class="sidebar-item active">
                            <a class="sidebar-link" href="icons-feather.php">
                                <i class="align-middle" data-feather="image"></i> <span class="align-middle">image</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="service.php">
                                <i class="align-middle" data-feather="settings"></i> <span class="align-middle">settings</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="vendor_review.php">
                               <i class="fa-regular fa-message" style="color: #949494;"></i><span class="align-middle">Reviews</span>
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
                                        <img src="img/profile.png" class="avatar img-fluid rounded me-1" alt="<?php echo $user['Name']; ?>" /> 
                                        <span class="text-dark"><?php echo $user['Name']; ?></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="pages-profile.php"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
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

            <div class="main">
                <div class="profile-header">
                    <h2>Upload Vendor Album Images</h2>
                </div>

                <div class="profile-card">
                    <form id="deleteImagesForm" method="post">
                        <input type="hidden" name="imagesToDelete" id="imagesToDelete" value="">
                    </form>

                    <form method="post" enctype="multipart/form-data">
                        <!-- Album Images Section -->
                        <div class="form-group">
                            <label for="albumImages" class="form-label">Choose album images to upload (you can select multiple images):</label>
                            <input type="file" name="albumImages[]" id="albumImages" class="form-control" accept="image/*" multiple>
                            <button type="submit" name="uploadAlbumImages" class="submit-btn">Upload Album Images</button>
                        </div>
                    </form>

                    <!-- Display Uploaded Images -->
                    <!-- Display Uploaded Images -->
                    <div class="gallery">
                        <h3>Uploaded Images:</h3>
                        <?php if (!empty($uploadedImages)): ?>
                            <?php foreach ($uploadedImages as $image): ?>
                                <div class="image-container">
                                    <img src="uploads/album_images/<?php echo htmlspecialchars($image['Image']); ?>" alt="Vendor Image" class="gallery-image" data-checkbox-id="checkbox-<?php echo htmlspecialchars($image['Image']); ?>">
                                    <input type="checkbox" class="image-checkbox" id="checkbox-<?php echo htmlspecialchars($image['Image']); ?>" style="display:none;">
                                    <label for="checkbox-<?php echo htmlspecialchars($image['Image']); ?>" class="checkbox-label"></label>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No images uploaded yet.</p>
                        <?php endif; ?>
                    </div>
                    <div id="imageModal" class="modal">
                        <span class="close">&times;</span>
                        <img class="modal-content" id="modalImage">
                        <div id="caption"></div>
                        <div class="modal-content">
                            <img id="modal-image">
                            <a class="prev">&#10094;</a>
                            <a class="next">&#10095;</a>
                        </div>
                    </div>

                </div>

                <!-- Context Menu -->
                <div class="context-menu" id="contextMenu">
                    <div class="context-menu-item" id="selectImage">Select</div>
                    <div class="context-menu-item" id="deleteImage">Delete</div>
                </div>
            </div>
        </div>

        <script src="js/app.js"></script>
        <script>
            // Handle Select action
            document.getElementById('selectImage').addEventListener('click', () => {
                const checkboxes = document.querySelectorAll('.image-checkbox');
                checkboxes.forEach(checkbox => {
                    checkbox.style.display = checkbox.style.display === 'none' ? 'block' : 'none'; // Toggle visibility
                });
                document.getElementById('contextMenu').style.display = 'none'; // Hide context menu
            });

            // Context Menu Functionality
            document.addEventListener('contextmenu', function (event) {
                event.preventDefault();
                const contextMenu = document.getElementById('contextMenu');
                contextMenu.style.display = 'block';
                contextMenu.style.left = event.pageX + 'px';
                contextMenu.style.top = event.pageY + 'px';
            });

            document.addEventListener('click', function () {
                const contextMenu = document.getElementById('contextMenu');
                contextMenu.style.display = 'none';
            });

            // Toggle checkbox selection on image click
            document.querySelectorAll('.gallery-image').forEach(image => {
                image.addEventListener('click', function () {
                    const checkboxId = this.getAttribute('data-checkbox-id');
                    const checkbox = document.getElementById(checkboxId);

                    // Toggle the checkbox checked state
                    checkbox.checked = !checkbox.checked;

                    // Optionally, you can add styles or effects here to indicate the selection
                    if (checkbox.checked) {
                        this.style.border = "2px solid #28a745"; // Example: change border color when selected
                    } else {
                        this.style.border = ""; // Reset border when not selected
                    }
                });
            });

            document.getElementById('deleteImage').addEventListener('click', () => {
                const selectedImages = [];
                const checkboxes = document.querySelectorAll('.image-checkbox');

                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        const img = checkbox.closest('.image-container').querySelector('img');
                        const imgFileName = img.src.split('/').pop(); // Extract the filename from the image source
                        selectedImages.push(imgFileName);
                    }
                });

                if (selectedImages.length > 0) {
                    // Send the selected images to be deleted via the hidden form
                    document.getElementById('imagesToDelete').value = JSON.stringify(selectedImages);
                    document.getElementById('deleteImagesForm').submit(); // Submit the form to delete the images
                } else {
                    alert("No images selected for deletion.");
                }

                document.getElementById('contextMenu').style.display = 'none'; // Hide context menu after deletion
            });

            // Toggle checkbox selection on image click and open modal for big view
            document.querySelectorAll('.gallery-image').forEach(image => {
                image.addEventListener('dblclick', function () {
                    // Show the modal
                    const modal = document.getElementById('imageModal');
                    const modalImg = document.getElementById('modalImage');
                    const captionText = document.getElementById('caption');

                    modal.style.display = "block"; // Display the modal
                    modalImg.src = this.src; // Set the modal image source to the clicked image's source
                    captionText.innerHTML = this.alt; // Set the caption to the alt text of the image

                    // Optional: Style the selected image differently if necessary
                    const checkboxId = this.getAttribute('data-checkbox-id');
                    const checkbox = document.getElementById(checkboxId);
                    checkbox.checked = !checkbox.checked; // Toggle checkbox

                    if (checkbox.checked) {
                        this.style.border = "2px solid #28a745"; // Change border when selected
                    } else {
                        this.style.border = ""; // Reset border when not selected
                    }
                });
            });

// Close the modal when clicking on the "close" button
            const modal = document.getElementById('imageModal');
            const closeBtn = document.getElementsByClassName('close')[0];

            closeBtn.onclick = function () {
                modal.style.display = "none"; // Hide the modal
            }

// Close the modal when clicking outside the image
            modal.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }

        </script>
        <script>
        let currentIndex = 0;
        const images = document.querySelectorAll('.gallery img');
        const modal = document.getElementById("myModal");
        const modalImage = document.getElementById("modal-image");
        const prevBtn = document.querySelector(".prev");
        const nextBtn = document.querySelector(".next");

        // Open Modal and show clicked image
        images.forEach((image, index) => {
            image.addEventListener('click', function () {
                currentIndex = index;
                openModal();
                showImage(currentIndex);
            });
        });

        // Open the modal
        function openModal() {
            modal.style.display = "flex";
        }

        // Close the modal
        document.querySelector(".close").addEventListener('click', function () {
            modal.style.display = "none";
        });

        // Show image based on index
        function showImage(index) {
            const imageUrl = images[index].src;
            modalImage.src = imageUrl;
        }

        // Next/Previous controls
        nextBtn.addEventListener('click', function () {
            currentIndex = (currentIndex + 1) % images.length;
            showImage(currentIndex);
        });

        prevBtn.addEventListener('click', function () {
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            showImage(currentIndex);
        });

        // Close modal when clicking outside of the image
        window.addEventListener('click', function (event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        });
    </script>

    </body>

</html>
