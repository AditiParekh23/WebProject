<?php
include 'config.php'; // Include your database connection

// Check if the vendor is logged in and their VendorID is available
if (!isset($_SESSION['user']['VendorID'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

$vendorID = $_SESSION['user']['VendorID']; // Get the logged-in vendor's ID

// Get the start date of the current week (Monday)
$current_week_start = date('Y-m-d', strtotime('monday this week'));

// Get the end date of the next week (Sunday)
$next_week_end = date('Y-m-d', strtotime('sunday next week'));

// SQL query to fetch events for the current week and next week for the logged-in vendor
$sql = "SELECT e.EventType, v.Name AS VendorName, s.Name AS ServiceName, 
               e.EventStartDate AS StartDate, e.EventEndDate AS EndDate, e.EventStatus AS Status 
        FROM tbl_event e
        JOIN tbl_Vendor v ON e.VendorID = v.ID
        JOIN tbl_Service s ON v.ServiceID = s.ID -- Get ServiceID from tbl_Vendor
        WHERE e.EventStartDate >= ? 
        AND e.EventStartDate <= ? 
        AND e.VendorID = ?"; // Reference e.VendorID, not vs.VendorID

// Prepare and execute the statement
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $current_week_start, $next_week_end, $vendorID); // Bind parameters
$stmt->execute();
$result = $stmt->get_result(); // Get the result set from the prepared statement

// Check if the query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$stmt->close();
mysqli_close($conn);
?>
