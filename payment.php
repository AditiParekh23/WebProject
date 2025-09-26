<?php
// Start session at the beginning of the script
session_start();

// Include database connection
include('config.php');

// Check if the user is logged in by verifying the session variable
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['ID'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit();
}

// Fetch the customer ID from the session
$customer_id = $_SESSION['user']['ID'];

// Fetch payment details with booking and vendor information
$sql = "SELECT tbl_payment.ID, tbl_payment.Date, tbl_payment.Status, tbl_payment.Amount, 
               tbl_Vendor.Name AS VendorName, tbl_booking.Date AS BookingDate
        FROM tbl_payment
        JOIN tbl_booking ON tbl_payment.BookingID = tbl_booking.ID
        JOIN tbl_Vendor ON tbl_booking.VendorID = tbl_Vendor.ID
        WHERE tbl_booking.CustomerID = ?";


// Prepare and execute the query
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $customer_id);
$stmt->execute();
$result = $stmt->get_result();

// Close the statement and connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Payments</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
            body {
                font-family: 'Arial', sans-serif;
            }
            .wrapper {
                display: flex;
                width: 100%;
            }

            .sidebar {
                width: 250px;
                background-color: #C78665;
                padding: 15px;
                height: 100vh;
            }

            .sidebar a {
                color: #ffffff;
                text-decoration: none;
                padding: 10px;
                display: block;
                border-radius: 4px;
                margin-bottom: 10px;
            }

            .sidebar a:hover {
                background-color: #ffffff;
                color: #C78665;
            }

            .content {
                flex: 1;
                padding: 20px;
                margin-left: 0; /* Remove margin to align closer to sidebar */
            }
            h2 {
                font-family: Arial, sans-serif; /* Set font family for heading */
            }
            .payment-container {
                display: flex;
                flex-wrap: wrap;
                justify-content: flex-start;
            }
            .payment-box {
                width: 300px;
                background-color: #f9f9f9;
                margin: 20px;
                padding: 15px;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            .payment-status {
                margin-top: 15px;
                font-weight: bold;
            }
            .payment-amount {
                margin-top: 10px;
                color: #C78665;
            }
            .status-pending {
                color: red;
            }
            .status-confirm {
                color: green;
            }
            .payment-box h3,
            .payment-details p {
                font-family: 'Arial', sans-serif; /* Set font family for vendor name and payment details */
            }
        </style>

    </head>
    <body>

        <div class="wrapper">
            <!-- Sidebar -->
            <nav class="sidebar">
                <h4 class="text-white" style="font-family: 'Arial', sans-serif;">My Account</h4><br><br>
                <a href="customer_dashboard.php"><i class="fa-solid fa-house" style="font-size: 20px;"></i> Home</a>
                <a href="customerProfile.php"><i class="fa-solid fa-id-badge" style="font-size: 20px;"></i> Profile</a>
                <a href="booking.php"><i class="fa-solid fa-calendar-days" style="font-size: 20px;"></i> Bookings</a>
                <a href="payment.php"><i class="fa-solid fa-hand-holding-dollar" style="font-size: 20px;"></i> Payments</a>
                <a href="setting.php"><i class="fa-solid fa-gear" style="font-size: 20px;"></i> Settings</a>
                <a href="logout.php" onclick="confirmLogout()"> <i class="fa-solid fa-right-from-bracket" style="font-size: 20px;"></i> Logout</a>
            </nav>


            <div class="content">
                <h2>Payment Details</h2>
                <div class="payment-container">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="payment-box">
                            <h3><?php echo htmlspecialchars($row['VendorName']); ?></h3>
                            <div class="payment-details">
                                <p>Date of Payment: <?php echo htmlspecialchars($row['Date']); ?></p>
                                <p>Booking Date: <?php echo htmlspecialchars($row['BookingDate']); ?></p>
                            </div>
                            <div class="payment-status <?php echo ($row['Status'] == 'confirmed') ? 'status-confirm' : 'status-pending'; ?>">
                                Status: <?php echo htmlspecialchars($row['Status']); ?>
                            </div>
                            <div class="payment-amount">
                                Amount: ₹<?php echo number_format($row['Amount'], 2); ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>

        <script>
            function confirmLogout() {
                if (confirm('Are you sure you want to logout?')) {
                    window.location.href = 'logout.php';
                }
            }
        </script>

    </body>
</html>
