<?php
include('config.php');

// Query to get earnings for the past 12 months
$query = "SELECT 
            MONTH(Date) AS month, 
            SUM(Amount) AS total_earnings
          FROM (
              SELECT Date, Amount FROM tbl_admin_booking
              UNION ALL
              SELECT Date, Amount FROM tbl_admin_payment
          ) AS earnings
          WHERE Date >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
          GROUP BY month
          ORDER BY month";

$result = mysqli_query($conn, $query);

$months = [];
$earnings = [];

while ($row = mysqli_fetch_assoc($result)) {
    $months[] = date("F", mktime(0, 0, 0, $row['month'], 10)); // Converts month number to month name
    $earnings[] = $row['total_earnings'];
}

mysqli_close($conn);
?>