<?php
require_once 'config.php';
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

// Retrieve user data safely
$user = $_SESSION['user'] ?? [];
$name = $user['Name'] ?? 'N/A';  // Default to 'N/A' if Name is not set
$email = $_SESSION['email'] ?? 'N/A';  // Email is stored separately in the session
$contact_number = $user['Contact_Number'] ?? 'N/A';  // Default to 'N/A' if Contact_Number is not set

// Handle form submission to update customer data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_name = $conn->real_escape_string($_POST['customerName']);
    $new_contact_number = $conn->real_escape_string($_POST['customerPhone']);
    
    // Assuming the user's ID is stored in the session
    $user_id = $user['ID'];

    // Update the user data in the database
    $sql = "UPDATE tbl_customer SET Name = '$new_name', Contact_Number = '$new_contact_number' WHERE ID = $user_id";
    
    if ($conn->query($sql) === TRUE) {
        // Update session data with new values
        $_SESSION['user']['Name'] = $new_name;
        $_SESSION['user']['Contact_Number'] = $new_contact_number;

        // Redirect back to the profile page with a success message
        header('Location: customerProfile.php?success=1');
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profile</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <style>
            body {
                font-family: 'Arial', sans-serif;
                background-color: #f5f5f5;
            }

            .profile-container {
                margin-top: 50px;
                max-width: 600px;
                margin-left: auto;
                margin-right: auto;
                padding: 20px;
                border: 1px solid #ddd;
                border-radius: 10px;
                background-color: #ffffff;
            }

            .profile-container h2 {
                text-align: center;
                margin-bottom: 20px;
            }

            .form-group label {
                font-weight: bold;
            }

            .btn-update {
                display: block;
                width: 100%;
                margin-top: 20px;
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

            .alert {
                margin-top: 20px;
            }
        </style>
    </head>
    <body>
        <div class="wrapper">
            <nav class="sidebar">
                <h4 class="text-white" style="font-family: 'Arial', sans-serif;">My Account</h4><br><br>
                <a href="customer_dashboard.php"><i class="fa-solid fa-house" style="font-size: 20px;" ></i> Home</a>
                <a href="customerProfile.php"><i class="fa-solid fa-id-badge" style="font-size: 20px;" ></i> Profile</a>
                <a href="booking.php"><i class="fa-solid fa-calendar-days" style="font-size: 20px;"></i> Bookings</a>
                <a href="payment.php"><i class="fa-solid fa-hand-holding-dollar" style="font-size: 20px;"></i> Payments</a>
                <a href="setting.php"><i class="fa-solid fa-gear" style="font-size: 20px;"></i> Settings</a>
                <a href="logout.php" onclick="confirmLogout()"> <i class="fa-solid fa-right-from-bracket" style="font-size: 20px;"></i> Logout</a>
            </nav>
            <div class="content">
                <div class="profile-container">
                    <h2 style="font-family: 'Arial', sans-serif;">Customer Profile</h2>

                    <!-- Display Success Message -->
                    <?php if (isset($_GET['success'])): ?>
                        <div class="alert alert-success">Profile updated successfully!</div>
                    <?php endif; ?>

                    <form action="customerProfile.php" method="POST">
                        <div class="form-group">
                            <label for="customerName">Name:</label>
                            <input type="text" class="form-control" id="customerName" name="customerName" value="<?php echo htmlspecialchars($name); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="customerEmail">Email:</label>
                            <input type="email" class="form-control" id="customerEmail" name="customerEmail" value="<?php echo htmlspecialchars($email); ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label for="customerPhone">Phone Number:</label>
                            <input type="text" class="form-control" id="customerPhone" name="customerPhone" value="<?php echo htmlspecialchars($contact_number); ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-update">Save Changes</button>
                    </form>
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
