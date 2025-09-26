<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // put your code here
        include 'config.php'; // Include your database connection
// Query to count total events
        $query = "SELECT COUNT(*) as total_events FROM tbl_event";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $total_events = $row['total_events'];

        // Get current month events count
        $current_month_query = "SELECT COUNT(*) as current_month_events FROM tbl_event WHERE MONTH(EventStartDate) = MONTH(CURRENT_DATE()) AND YEAR(EventStartDate) = YEAR(CURRENT_DATE())";
        $current_month_result = mysqli_query($conn, $current_month_query);
        $current_month_row = mysqli_fetch_assoc($current_month_result);
        $current_month_events = $current_month_row['current_month_events'];

// Get previous month events count
        $previous_month_query = "SELECT COUNT(*) as previous_month_events FROM tbl_event WHERE MONTH(EventStartDate) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH) AND YEAR(EventStartDate) = YEAR(CURRENT_DATE())";
        $previous_month_result = mysqli_query($conn, $previous_month_query);
        $previous_month_row = mysqli_fetch_assoc($previous_month_result);
        $previous_month_events = $previous_month_row['previous_month_events'];

// Calculate percentage change
        $percentage_change = 0;
        if ($previous_month_events > 0) {
            $percentage_change = (($current_month_events - $previous_month_events) / $previous_month_events) * 100;
        }

// Determine color based on change
        $color = "text-muted"; // Default color
        if ($percentage_change > 0) {
            $color = "text-success"; // Green for increase
        } elseif ($percentage_change < 0) {
            $color = "text-danger"; // Red for decrease
        }

// Close the database connection
        mysqli_close($conn);
        ?>
    </body>
</html>
