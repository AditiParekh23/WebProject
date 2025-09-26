<?php
include 'config.php'; // Include your database connection

// Get the start date of the current week (Monday)
$current_week_start = date('Y-m-d', strtotime('monday this week'));

// Get the end date of the next week (Sunday)
$next_week_end = date('Y-m-d', strtotime('sunday next week'));

// SQL query to fetch events for the entire current week and the next week
$sql = "SELECT e.EventType , v.Name AS VendorName, s.Name AS ServiceName, e.EventStartDate AS StartDate, e.EventEndDate AS EndDate, e.EventStatus
        FROM tbl_event e
        JOIN tbl_Vendor v ON e.VendorID = v.ID
        JOIN tbl_Service s ON v.ServiceID = s.ID
        WHERE e.EventStartDate >= '$current_week_start' AND e.EventStartDate <= '$next_week_end'";


// Execute the query
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>