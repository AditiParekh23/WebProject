<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user']['VendorID'])) {
    header('Location: login.php');
    exit();
}

$vendorID = $_SESSION['user']['VendorID'];

// SQL to get the service name based on vendor ID
$sql = "
    SELECT 
        v.ServiceID,
        s.Name AS ServiceName
    FROM 
        tbl_Vendor v
    JOIN 
        tbl_Service s ON v.ServiceID = s.ID
    WHERE 
        v.ID = ?;
";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $vendorID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $serviceName = strtolower($row['ServiceName']);
    
    // Redirect to the corresponding service page
    switch ($serviceName) {
        case 'decoration':
            header('Location: vendor_decoration_service.php');
            break;
        case 'venue':
            header('Location: vendor_venue_service.php');
            break;
        case 'photography':
            header('Location: vendor_photographer_service.php');
            break;
        case 'catering':
            header('Location: vendor_caterer_service.php');
            break;
        case 'dj':
            header('Location: vendor_dj_service.php');
            break;
        default:
            echo "Service not recognized.";
            exit();
    }
} else {
    echo "No service found for the vendor.";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
