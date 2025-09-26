<?php
session_start();

// Prevent page caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Settings - Event Management</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <style>
            * {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }

            body {
                font-family: 'Arial', sans-serif;
                background-color: #f8f9fa;
                margin: 0;
                padding: 0;
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
                position: fixed;
            }

            .sidebar h4 {
                color: #ffffff;
                font-family: 'Arial', sans-serif;
                margin-bottom: 20px;
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
                margin-left: 270px;
                padding: 20px;
                flex: 1;
            }

            .container {
                max-width: 900px;
                background-color: #fff;
                border-radius: 8px;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
                padding: 20px;
                margin-top: 20px;
            }

            .heading {
                text-align: center;
                margin-bottom: 20px;
            }

            .heading h2 {
                font-size: 2rem;
                color: #333;
            }

            .heading h2,
            .settings-section h3,
            .danger-zone h3 {
                font-family: 'Arial', sans-serif; /* Ensure these headings use Arial */
            }


            .settings-section {
                margin-bottom: 30px;
            }

            .settings-section h3 {
                font-size: 1.5rem;
                margin-bottom: 10px;
                color: #555;
            }

            .settings-options {
                display: flex;
                flex-direction: column;
            }

            .settings-options .option {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 15px;
                background-color: #f9f9f9;
                margin-bottom: 10px;
                border-radius: 6px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            }

            .option span {
                font-size: 1rem;
                color: #333;
            }

            .option button {
                background-color: #C78665;
                color: white;
                padding: 8px 15px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 0.9rem;
                transition: background-color 0.3s ease;
            }

            .option button:hover {
                background-color: #a85a43;
            }

            .danger-zone {
                margin-top: 30px;
                padding-top: 20px;
                border-top: 2px solid #f1f1f1;
            }

            .danger-zone h3 {
                color: #d9534f;
            }

            .danger-zone .option button {
                background-color: #d9534f;
            }

            .danger-zone .option button:hover {
                background-color: #c9302c;
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
                <a href="logout.php" onclick="confirmLogout()"><i class="fa-solid fa-right-from-bracket" style="font-size: 20px;"></i> Logout</a>
            </nav>

            <div class="content">
                <div class="container">
                    <div class="heading">
                        <h2>Settings</h2>
                    </div>

                    <!-- Account Management -->
                    <div class="settings-section">
                        <h3>Account Management</h3>
                        <div class="settings-options">
                            <div class="option">
                                <span>Change Password</span>
                                <a href="changepassword.php"> <button>Change</button></a>
                            </div>
                            <div class="option">
                                <span>Update Email</span>
                                <a href="otpemail.php"> <button>Change</button></a>
                            </div>
                        </div>
                    </div>

                    <!-- Danger Zone: Deactivate/Delete Account -->
                    <div class="danger-zone">
                        <h3>Account actions</h3>
                        <div class="settings-options">
                            <div class="option">
                                <span>Deactivate Account</span>
                                <button>Deactivate</button>
                            </div>
                            <div class="option">
                                <span>Delete Account Permanently</span>
                                <button>Delete</button>
                            </div>
                        </div>
                    </div>
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
