<?php
include 'config.php'; // Include database connection

$sql = "SELECT e.EventType, v.Name AS VendorName, c.Name AS CustomerName, s.Name AS ServiceName, 
               e.EventStartDate AS StartDate, e.EventEndDate AS EndDate, e.EventStatus 
        FROM tbl_event e
        JOIN tbl_Vendor v ON e.VendorID = v.ID
        JOIN tbl_customer c ON e.CustomerID = c.ID
        JOIN tbl_Service s ON v.ServiceID = s.ID
        ORDER BY e.EventStartDate";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>
