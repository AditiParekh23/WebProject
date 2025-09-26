<?php
include 'config.php';

// Fetch records from tbl_service
$sql = "SELECT * FROM tbl_service";
$result = $conn->query($sql);

if (!$result) {
    die("Error executing query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service List</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .container {
            width: 90%;
            max-width: 800px; /* Max width for better readability */
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: auto; /* Center the container horizontally */
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #C78665;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
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
    </style>
</head>
<body>
    <div class="wrapper">
        <nav class="sidebar">
                <h4 class="text-white" style="font-family: 'Arial', sans-serif;">My Account</h4><br><br>
                <a href="customer_dashboard.php"><i class="fa-solid fa-house" style="font-size: 20px;" ></i> Home</a>
                <a href="customerProfile.php"><i class="fa-solid fa-id-badge" style="font-size: 20px;" ></i> Profile</a>
                <a href="vendors.php"><i class="fa-solid fa-user-tie" style="font-size: 20px;"></i> Vendors</a>
                <a href="#bookings"><i class="fa-solid fa-calendar-days" style="font-size: 20px;"></i> Bookings</a>
                <a href="#payments"><i class="fa-solid fa-hand-holding-dollar" style="font-size: 20px;"></i> Payments</a>
                <a href="#settings"><i class="fa-solid fa-gear" style="font-size: 20px;"></i> Settings</a>
                <a href="logout.php" onclick="confirmLogout()"> <i class="fa-solid fa-right-from-bracket" style="font-size: 20px;"></i> Logout</a>
            </nav>
        
        <!-- Main Content -->
        <div class="container" style="margin-left: 270px; padding: 20px;">
            <h2>Service List</h2>

            <!-- Table displaying services -->
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Check if there are any results
                    if ($result->num_rows > 0) {
                        // Fetch each row and display the data
                        while($row = $result->fetch_assoc()) {
                            $serviceName = htmlspecialchars($row['Name']);
                            $servicePage = strtolower(str_replace(' ', '_', $serviceName)) . '.php'; // Create page name
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['ID']) . "</td>";
                            echo "<td><a href='" . $servicePage . "'>" . $serviceName . "</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2'>No services found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
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
