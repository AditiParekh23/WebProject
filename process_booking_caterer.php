<?php

// Start session
session_start();
include 'config.php'; // Include your database connection script
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $vendorID = $_POST['vendor_id'];
    $customerID = $_SESSION['user']['ID']; // Assuming user ID is stored in session
    $catererID = $_POST['caterer_id'];  // Decoration ID
    $serviceID = $_POST['service_id']; // Service ID (e.g., venue, catering)
    $startDate = $_POST['start_event_date_time'];
    $endDate = $_POST['end_event_date_time'];
    $address = $_POST['address'];
    $areaID = $_POST['area'];
    $razorpayPaymentID = $_POST['razorpay_payment_id'];
    $bookingPrice = $_POST['booking_price'];
    $eventType = $_POST['event_type'];

    // Check if session user ID is set
    if (!isset($_SESSION['user']['ID'])) {
        die("User session not set. Please log in.");
    }

    // Calculate the split amounts
    $adminAmount = $bookingPrice * 0.20; // 20% for admin
    $vendorAmount = $bookingPrice * 0.80; // 80% for vendor
    // Begin transaction
    mysqli_begin_transaction($conn);

    try {
        // Insert into tbl_booking
        $bookingQuery = "INSERT INTO tbl_booking (VendorID, CustomerID, ServiceID, Date, Status, Amount,PaymentKey) 
                         VALUES (?, ?, ?, NOW(), 'confirmed', ?, ?)";
        $stmt = mysqli_prepare($conn, $bookingQuery);
        if (!$stmt) {
            throw new Exception("Error preparing booking query: " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt, 'iiids', $vendorID, $customerID, $serviceID, $vendorAmount, $razorpayPaymentID);
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Error executing booking query: " . mysqli_error($conn));
        }
        $bookingID = mysqli_insert_id($conn);

        // Insert into tbl_admin_booking
        $adminBookingQuery = "INSERT INTO tbl_admin_booking (VendorID, CustomerID, ServiceID, BookingID, Date, Status, Amount) 
                              VALUES (?, ?, ?, ?, NOW(), 'confirm', ?)";
        $stmt = mysqli_prepare($conn, $adminBookingQuery);
        if (!$stmt) {
            throw new Exception("Error preparing admin booking query: " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt, 'iiiid', $vendorID, $customerID, $serviceID, $bookingID, $adminAmount);
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Error executing admin booking query: " . mysqli_error($conn));
        }

        // Insert into tbl_event (added additionaldetails)
        $eventQuery = "INSERT INTO tbl_event (EventType, VendorID, BookingID, CustomerID, CatererDetailID, EventStartDate, EventEndDate, EventStatus, EventAmount, EventLocation, AreaID, AdditionalDetails) 
               VALUES (?, ?, ?, ?, ?, ?, ?, 'pending', ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $eventQuery);
        if (!$stmt) {
            throw new Exception("Error preparing event query: " . mysqli_error($conn));
        }

// Bind parameters, including additionaldetails (even if it is NULL)
        mysqli_stmt_bind_param($stmt, 'siiiissdsis', $eventType, $vendorID, $bookingID, $customerID, $catererID, $startDate, $endDate, $bookingPrice, $address, $areaID, $additionaldetails);

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Error executing event query: " . mysqli_error($conn));
        }


        // Commit transaction
        mysqli_commit($conn);
        $_SESSION['booking_message'] = "Thank you for booking on Eventify. Your booking is confirmed.";

        // Redirect to success page
        header("Location: booking.php");
        exit;
    } catch (Exception $e) {
        // Rollback transaction on error and log the error
        mysqli_rollback($conn);
        error_log("Error: " . $e->getMessage());  // Log error to server
        echo "Payment successful, but an error occurred: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
