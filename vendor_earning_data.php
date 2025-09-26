<?php
include('config.php');

// Check if the vendor is logged in and their VendorID is available
if (!isset($_SESSION['user']['VendorID'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

$vendorID = $_SESSION['user']['VendorID']; // Get the logged-in vendor's ID

// Query to get earnings for the past 12 months for the logged-in vendor
$query = "SELECT 
            MONTH(Date) AS month, 
            SUM(Amount) AS total_earnings
          FROM (
              SELECT b.Date, b.Amount 
              FROM tbl_booking b
              WHERE b.VendorID = ?
              UNION ALL
              SELECT p.Date, p.Amount 
              FROM tbl_payment p
              JOIN tbl_booking b ON p.BookingID = b.ID
              WHERE b.VendorID = ?
          ) AS earnings
          WHERE Date >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
          GROUP BY month
          ORDER BY month";

$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $vendorID, $vendorID); // Bind VendorID for both queries
$stmt->execute();
$result = $stmt->get_result();

$months = [];
$earnings = [];

while ($row = $result->fetch_assoc()) {
    $months[] = date("F", mktime(0, 0, 0, $row['month'], 10)); // Converts month number to month name
    $earnings[] = $row['total_earnings'];
}

$stmt->close();
mysqli_close($conn);
?>
