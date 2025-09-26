<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Vendor Events Statistics</title>
    </head>
    <body>
        <?php

        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'vendor') {
            // If the user is not logged in, redirect them to the index page
            header('Location: index.php');
            exit();
        }

        // Include your database connection file
        include 'config.php';

        // Check if the vendor is logged in and their VendorID is available
        if (!isset($_SESSION['user']['VendorID'])) {
            header('Location: login.php'); // Redirect to login if not logged in
            exit();
        }

        $vendorID = $_SESSION['user']['VendorID']; // Get the logged-in vendor's ID

        // Query to count total events for the logged-in vendor
        $query = "SELECT COUNT(*) as total_events FROM tbl_event WHERE VendorID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $vendorID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $total_events = $row['total_events'];

        // Get current month events count for the logged-in vendor
        $current_month_query = "SELECT COUNT(*) as current_month_events 
                                FROM tbl_event e
                                WHERE e.VendorID = ? 
                                AND MONTH(e.EventStartDate) = MONTH(CURRENT_DATE()) 
                                AND YEAR(e.EventStartDate) = YEAR(CURRENT_DATE())";
        $stmt = $conn->prepare($current_month_query);
        $stmt->bind_param("i", $vendorID);
        $stmt->execute();
        $current_month_result = $stmt->get_result();
        $current_month_row = $current_month_result->fetch_assoc();
        $current_month_events = $current_month_row['current_month_events'];

        // Get previous month events count for the logged-in vendor
        $previous_month_query = "SELECT COUNT(*) as previous_month_events 
                                 FROM tbl_event e
                                 WHERE e.VendorID = ? 
                                 AND MONTH(e.EventStartDate) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH) 
                                 AND YEAR(e.EventStartDate) = YEAR(CURRENT_DATE() - INTERVAL 1 MONTH)";
        $stmt = $conn->prepare($previous_month_query);
        $stmt->bind_param("i", $vendorID);
        $stmt->execute();
        $previous_month_result = $stmt->get_result();
        $previous_month_row = $previous_month_result->fetch_assoc();
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
        $stmt->close();
        $conn->close();
        ?>
    </body>
</html>
