<?php

// Check if the user is logged in
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'vendor') {
    header('Location: index.php');
    exit();
}

// Include your database connection file
include 'config.php';

// Check if the vendor is logged in and their VendorID is available
if (!isset($_SESSION['user']['VendorID'])) {
    header('Location: login.php');
    exit();
}

$vendorID = $_SESSION['user']['VendorID']; // Get the logged-in vendor's ID

// SQL query for current month's sales
$currentMonthQuery = "
SELECT 
    COALESCE(SUM(b.Amount), 0) AS total_booking, 
    (SELECT COALESCE(SUM(p.Amount), 0) 
     FROM tbl_payment p 
     JOIN tbl_booking b2 ON p.BookingID = b2.ID 
     WHERE MONTH(p.Date) = MONTH(CURRENT_DATE()) 
     AND YEAR(p.Date) = YEAR(CURRENT_DATE())
     AND b2.VendorID = ?) AS total_payment
FROM 
    tbl_booking b
WHERE 
    MONTH(b.Date) = MONTH(CURRENT_DATE()) 
    AND YEAR(b.Date) = YEAR(CURRENT_DATE())
    AND b.VendorID = ?
";

// Prepare and execute query for current month
$stmt = $conn->prepare($currentMonthQuery);
$stmt->bind_param("ii", $vendorID, $vendorID);
$stmt->execute();
$currentMonthResult = $stmt->get_result();
$currentMonthData = $currentMonthResult->fetch_assoc() ?? ['total_booking' => 0, 'total_payment' => 0];

// Calculate total sales for the current month
$currentMonthSales = $currentMonthData['total_booking'] + $currentMonthData['total_payment'];

// SQL query for previous month's sales
$previousMonthQuery = "
SELECT 
    COALESCE(SUM(b.Amount), 0) AS total_booking, 
    (SELECT COALESCE(SUM(p.Amount), 0) 
     FROM tbl_payment p
     JOIN tbl_booking b2 ON p.BookingID = b2.ID
     WHERE MONTH(p.Date) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH) 
     AND YEAR(p.Date) = YEAR(CURRENT_DATE() - INTERVAL 1 MONTH)
     AND b2.VendorID = ?) AS total_payment
FROM 
    tbl_booking b
WHERE 
    MONTH(b.Date) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH) 
    AND YEAR(b.Date) = YEAR(CURRENT_DATE() - INTERVAL 1 MONTH)
    AND b.VendorID = ?
";

// Prepare and execute query for previous month
$stmt = $conn->prepare($previousMonthQuery);
$stmt->bind_param("ii", $vendorID, $vendorID);
$stmt->execute();
$previousMonthResult = $stmt->get_result();
$previousMonthData = $previousMonthResult->fetch_assoc() ?? ['total_booking' => 0, 'total_payment' => 0];

// Calculate total sales for the previous month
$previousMonthSales = $previousMonthData['total_booking'] + $previousMonthData['total_payment'];

// Calculate percentage change
if ($previousMonthSales > 0) {
    $percentageChange = (($currentMonthSales - $previousMonthSales) / $previousMonthSales) * 100;
} else {
    $percentageChange = 100; // If no sales in previous month, consider it a 100% increase
}

// Cap the percentage change
$percentageChange = min(max($percentageChange, 0), 100);

// Determine if it's an increase or decrease
$isIncrease = $currentMonthSales >= $previousMonthSales;
$changeColor = $isIncrease ? 'text-success' : 'text-danger'; // Green if increase, red if decrease

// Close the database connection
mysqli_close($conn);
?>

