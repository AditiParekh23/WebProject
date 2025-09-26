<?php
include 'dbconn.php';

// SQL query for current month's sales (all vendors)
$currentMonthQuery = "
SELECT 
    COALESCE(SUM(b.Amount), 0) AS total_booking, 
    (SELECT COALESCE(SUM(p.Amount), 0) FROM tbl_admin_payment p 
     WHERE MONTH(p.Date) = MONTH(CURRENT_DATE()) 
     AND YEAR(p.Date) = YEAR(CURRENT_DATE())) AS total_payment
FROM 
    tbl_admin_booking b
WHERE 
    MONTH(b.Date) = MONTH(CURRENT_DATE()) 
    AND YEAR(b.Date) = YEAR(CURRENT_DATE())
";

// Prepare and execute query for current month
$stmt = $conn->prepare($currentMonthQuery);
$stmt->execute();
$currentMonthResult = $stmt->get_result();

// Fetch results for current month
$currentMonthData = $currentMonthResult->fetch_assoc();

// If current month data is empty, initialize to zero
if (!$currentMonthData) {
    $currentMonthData = [
        'total_booking' => 0,
        'total_payment' => 0,
    ];
}

// SQL query for previous month's sales (all vendors)
$previousMonthQuery = "
SELECT 
    COALESCE(SUM(b.Amount), 0) AS total_booking, 
    (SELECT COALESCE(SUM(p.Amount), 0) FROM tbl_admin_payment p 
     WHERE MONTH(p.Date) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH) 
     AND YEAR(p.Date) = YEAR(CURRENT_DATE() - INTERVAL 1 MONTH)) AS total_payment
FROM 
    tbl_admin_booking b
WHERE 
    MONTH(b.Date) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH) 
    AND YEAR(b.Date) = YEAR(CURRENT_DATE() - INTERVAL 1 MONTH)
";

// Prepare and execute query for previous month
$stmt = $conn->prepare($previousMonthQuery);
$stmt->execute();
$previousMonthResult = $stmt->get_result();

// Fetch results for previous month
$previousMonthData = $previousMonthResult->fetch_assoc();

// If previous month data is empty, initialize to zero
if (!$previousMonthData) {
    $previousMonthData = [
        'total_booking' => 0,
        'total_payment' => 0,
    ];
}

// Calculate total sales for the current and previous months
$currentMonthSales = $currentMonthData['total_booking'] + $currentMonthData['total_payment'];
$previousMonthSales = $previousMonthData['total_booking'] + $previousMonthData['total_payment'];

// Calculate percentage change
if ($previousMonthSales > 0) {
    $percentageChange = (($currentMonthSales - $previousMonthSales) / $previousMonthSales) * 100;
} else {
    $percentageChange = 100; // If no sales in previous month, consider it a 100% increase
}

// Cap the percentage change
if ($percentageChange > 100) {
    $percentageChange = 100;
} elseif ($percentageChange < 0) {
    $percentageChange = 0;
}

// Determine if it's an increase or decrease
$isIncrease = $percentageChange > 0;
$changeColor = $isIncrease ? 'text-success' : 'text-danger'; // Green if increase, red if decrease

// Close the prepared statement
$stmt->close();

// Close the database connection
mysqli_close($conn);
?>
