<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'vendor') {
    // If the user is not logged in, redirect them to the index page
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['images'])) {
    $imagesToDelete = $_POST['images'];
    $vendorID = $_SESSION['user']['VendorID'] ?? 0;

    foreach ($imagesToDelete as $image) {
        // Get the full path of the image
        $imagePath = 'uploads/album_images/' . $image;

        // Delete from filesystem
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Delete from database
        $stmt = $conn->prepare("DELETE FROM tbl_image WHERE VendorID = ? AND Image = ?");
        $stmt->bind_param('is', $vendorID, $image);
        $stmt->execute();
        $stmt->close();
    }

    // Redirect back to the vendor profile or image view page
    header('Location: vendorImgView.php?message=Images deleted successfully.');
    exit();
} else {
    echo "No images specified for deletion.";
}
?>
