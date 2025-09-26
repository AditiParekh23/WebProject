<?php
// Start session
session_start();

// Check if the booking message is set in the session
if (isset($_SESSION['booking_message'])) {
    // Display the alert using JavaScript
    echo "<script type='text/javascript'>
            alert('" . $_SESSION['booking_message'] . "');
          </script>";

    // Unset the session variable so the message doesn't show again on page refresh
    unset($_SESSION['booking_message']);
}
?>

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

// SQL Query to fetch bookings with total amount
$sql = "
SELECT 
    tbl_booking.ID, 
    tbl_booking.Date, 
    tbl_booking.Status, 
    (tbl_booking.Amount + tbl_admin_booking.Amount) AS TotalAmount, 
    tbl_Vendor.Name AS VendorName, 
    tbl_Vendor.CompanyName, 
    tbl_Service.Name AS ServiceName 
FROM 
    tbl_booking
JOIN 
    tbl_Vendor ON tbl_booking.VendorID = tbl_Vendor.ID
JOIN 
    tbl_Service ON tbl_booking.ServiceID = tbl_Service.ID
JOIN 
    tbl_admin_booking ON tbl_booking.ID = tbl_admin_booking.BookingID
WHERE 
    tbl_booking.CustomerID = ?";

// Prepare and execute the query
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $customer_id);
$stmt->execute();
$result = $stmt->get_result();

// Close the connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Bookings</title>
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

            .booking-container {
                display: flex;
                flex-wrap: wrap;
                justify-content: flex-start; /* Align boxes to the left */
            }

            .booking-box {
                width: 300px;
                background-color: #f9f9f9;
                margin: 10px; /* Adjust margin as needed */
                padding: 15px;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            .booking-box h3 {
                font-family: Arial, sans-serif; /* Set font family for service name */
                font-size: 1.2rem;
                color: #333;
                margin-bottom: 10px;
            }

            .booking-details p {
                font-family: Arial, sans-serif; /* Set font family for details */
                margin: 0; /* Reset margin for cleaner look */
            }

            .booking-status {
                margin-top: 15px;
                font-weight: bold;
                color: #008000;
            }

            .booking-amount {
                margin-top: 10px;
                color: #C78665;
            }

            .booking-status.pending {
                color: red; /* Color for pending status */
            }

            .booking-status.confirmed {
                color: green; /* Color for confirmed status */
            }

            @media (max-width: 768px) {
                .booking-box {
                    width: 100%;
                }
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

            <!-- Content -->
            <div class="content">
                <h2>Your Bookings</h2>
                <div class="booking-container">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="booking-box">
                            <h3><?php echo htmlspecialchars($row['ServiceName']); ?></h3>
                            <div class="booking-details">
                                <p>Vendor: <?php echo htmlspecialchars($row['VendorName']); ?> (<?php echo htmlspecialchars($row['CompanyName']); ?>)</p>
                                <p>Date: <?php echo htmlspecialchars($row['Date']); ?></p>
                            </div>
                            <div class="booking-status <?php echo strtolower(htmlspecialchars($row['Status'])); ?>">
                                Status: <?php echo htmlspecialchars($row['Status']); ?>
                            </div>
                            <div class="booking-amount">
                                Amount: ₹<?php echo number_format($row['TotalAmount'], 2); ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>

        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script>
            function confirmLogout() {
                if (confirm('Are you sure you want to logout?')) {
                    window.location.href = 'logout.php';
                }
            }
        </script>

    </body>
</html>
