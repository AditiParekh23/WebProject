<?php



// Start the session
session_start();
require_once 'config.php';
require_once 'admin_earning.php';
require_once 'admin_events.php';
require_once 'admin_users.php';
require_once 'admin_earning_data.php';
require_once 'admin_devent_table.php';

// If the user role is not set or not a customer, redirect to login
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords"
        content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, php, theme, front-end, ui kit, web">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

    <link rel="canonical" href="https://demo-basic.adminkit.io/" />


    <title>Admin</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <div class="wrapper">
        <nav id="sidebar" class="sidebar js-sidebar">
            <div class="sidebar-content js-simplebar">
                <a class="sidebar-brand" href="index.php">
                    <img src="img/adminlogo.png" alt="Company Logo" class="align-middle" style="width: 100%;">
                </a>

                <ul class="sidebar-nav">
                    <li class="sidebar-header">
                        Pages
                    </li>
                    <br>
                    <li class="sidebar-item ">
                        <a class="sidebar-link" href="aadmin_dashboard.php">
                            <i class="align-middle" data-feather="sliders"></i> <span
                                class="align-middle">Dashboard</span>
                        </a>
                    </li>
                    <br>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="aadmin_eve.php">
                            <i class="align-middle" data-feather="star"></i> <span class="align-middle">Events</span>
                        </a>
                    </li>
                    <br>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="aadmin_user.php">
                            <i class="align-middle" data-feather="user"></i> <span class="align-middle">Users</span>
                        </a>
                    </li>
                    <br>
                    <li class="sidebar-item active">
                        <a class="sidebar-link" href="aadmin_payments.php">
                            <i class="align-middle" data-feather="dollar-sign"></i> <span
                                class="align-middle">Payments</span>
                        </a>
                    </li>
                    <br>
                    <li class="sidebar-item"></li>
                    <a class="sidebar-link" href="aadmin_feedback.php">
                        <i class="align-middle" data-feather="thumbs-up"></i> <span class="align-middle">Feedback</span>
                    </a>
                    </li>
                    <br>
                    <li class="sidebar-item"></li>
                    <a class="sidebar-link" href="aadmin_settings.php">
                        <i class="align-middle" data-feather="settings"></i> <span class="align-middle">Settings</span>
                    </a>
                    </li>
                    <br>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="logout.php">
                            <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Log-out</span>
                        </a>
                    </li>
                    <br>
            </div>
        </nav>

        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle js-sidebar-toggle">
                    <i class="hamburger align-self-center"></i>
                </a>

                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav navbar-align">
                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
                                <div class="position-relative">
                                    <i class="align-middle" data-feather="bell"></i>
                                    <span class="indicator">.</span>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0"
                                aria-labelledby="alertsDropdown">

                                <div class="list-group">
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">

                                        </div>
                                    </a>

                                </div>
                                <div class="dropdown-menu-footer">
                                    <a href="#" class="text-muted">Show all notifications</a>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle" href="#" id="messagesDropdown"
                                data-bs-toggle="dropdown">
                                <div class="position-relative">
                                    <i class="align-middle" data-feather="message-square"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0"
                                aria-labelledby="messagesDropdown">
                                <div class="dropdown-menu-header">
                                    <div class="position-relative">
                                        4 New Messages
                                    </div>
                                </div>
                                <div class="list-group">
                                    <a href="#" class="list-group-item">
                                        <div class="row g-0 align-items-center">

                                        </div>
                                    </a>

                                </div>


                                <div class="dropdown-menu-footer">
                                    <a href="#" class="text-muted">Show all messages</a>
                                </div>
                            </div>
                        <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#"
                                data-bs-toggle="dropdown">
                                <i class="align-middle" data-feather="settings"></i>
                            </a>



                            <a class="nav-link d-none d-sm-inline-block">
                                <img src="img/profile.png" class="avatar img-fluid rounded me-1" alt="Charles Hall" />
                                <span class="text-dark">
                                    <a href="aadmin_payments.php" style="text-decoration: none; color: black;">Admin</a>
                                </span>
                            </a>

                        </li>
                    </ul>
                </div>
            </nav>

            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3">Payment Details</h1>

                    <div class="row">
                        <div class="col-xl-12 d-flex">
                            <div class="w-100">
                                <div class="row">

                                    <!-- Earnings -->
                                    <div class="col-sm-3"> <!-- Changed to col-sm-4 for larger size -->
                                        <div class="card" style="height: 200px;"> <!-- Set a height for the card -->
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col mt-0">
                                                        <h5 class="card-title">Earnings</h5>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="stat text-primary">
                                                            <i class="fa-solid fa-indian-rupee-sign"></i>
                                                            <!-- Currency icon -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <h1 class="mt-1 mb-3">
                                                    <?php echo number_format($currentMonthSales, 2); ?>
                                                </h1>
                                                <!-- Display current month's sales -->
                                                <div class="mb-0">
                                                    <span class="<?php echo $changeColor; ?>">
                                                        <i
                                                            class="mdi mdi-arrow-<?php echo $isIncrease ? 'top-right' : 'bottom-right'; ?>"></i>
                                                        <?php echo number_format(abs($percentageChange), 2); ?>%
                                                        <!-- Percentage change from last month -->
                                                    </span>
                                                    <span class="text-muted">Since last month</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Users -->
                                    <div class="col-sm-3"> <!-- Changed to col-sm-4 for larger size -->
                                        <div class="card" style="height: 200px;"> <!-- Set a height for the card -->
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col mt-0">
                                                        <h5 class="card-title">Users</h5>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="stat text-primary">
                                                            <i class="fa-solid fa-user-shield"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h1 class="mt-1 mb-3"><?php echo $total_users; ?></h1>
                                                <div class="mb-0" style="height: 21px;">
                                                    <!-- Set a specific height for the spacer -->
                                                    <!-- Clean space instead of dots -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-3"> <!-- Changed to col-sm-4 for larger size -->
                                        <div class="card" style="height: 200px;"> <!-- Set a height for the card -->
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col mt-0">
                                                        <h5 class="card-title">Current Month Events</h5>
                                                        <!-- Changed the title to indicate current month -->
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="stat text-primary">
                                                            <i class="fa-solid fa-calendar-days"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h1 class="mt-1 mb-3"><?php echo $current_month_events; ?></h1>
                                                <!-- Display current month events -->
                                                <div class="mb-0">
                                                    <span class="<?php echo $changeColor; ?>">
                                                        <i
                                                            class="mdi mdi-arrow-<?php echo $isIncrease ? 'top-right' : 'bottom-right'; ?>"></i>
                                                        <?php echo number_format(abs($percentageChange), 2); ?>%
                                                        <!-- Percentage change from last month -->
                                                    </span>
                                                    <span class="text-muted">Since last month</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Total Events -->
                                    <div class="col-sm-3"> <!-- Changed to col-sm-4 for larger size -->
                                        <div class="card" style="height: 200px;"> <!-- Set a height for the card -->
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col mt-0">
                                                        <h5 class="card-title">Total Events</h5>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="stat text-primary">
                                                            <i class="fa-solid fa-calendar-days"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h1 class="mt-1 mb-3"><?php echo $total_events; ?></h1>
                                                <!-- Display total events -->
                                                <div class="mb-0" style="height: 21px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- current year Earning Line bar -->
                    <div class="row">
                        <div class="col-xl-8 col-xxl-12">
                            <div class="card flex-fill w-100" style="height: 400px;">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Current Year Earnings</h5>
                                    <button id="previousYearButton" class="btn btn-primary btn-sm">Previous</button>
                                    <!-- Previous Year Button -->
                                </div>
                                <div class="card-body py-3">
                                    <div class="chart chart-sm">
                                        <canvas id="chartjs-dashboard-line"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="row">



                    <div class="container-fluid" style="padding: 12px;">
                        <div class="row">
                            <div class="col-12 d-flex">
                                <div class="card flex-fill"
                                    style="width: 100%; max-width: 1240px; margin: auto; padding: 25px;">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">Booking</h5>
                                        <div class="d-flex gap-2">
                                            <input type="text" id="searchInput" class="form-control"
                                                placeholder="Search...">
                                            <input type="date" id="dateInput" class="form-control">
                                        </div>
                                    </div>

                                    <!-- Booking Table -->
                                    <table class="table table-hover my-0" id="bookingTable">
                                        <thead>
                                            <tr>
                                                <th>Vendors</th>
                                                <th class="d-none d-xl-table-cell">Customers</th>
                                                <th class="d-none d-xl-table-cell">Service</th>
                                                <th>Date</th>
                                                <th class="d-none d-md-table-cell">Amount</th>
                                                <th class="d-none d-md-table-cell">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "
                                           SELECT 
                                               tbl_admin_booking.ID, 
                                               tbl_vendor.Name AS VendorName, 
                                               tbl_customer.Name AS CustomerName, 
                                               tbl_service.Name AS ServiceName, 
                                               tbl_admin_booking.Date, 
                                               tbl_admin_booking.Amount, 
                                               tbl_admin_booking.Status
                                           FROM tbl_admin_booking
                                           JOIN tbl_Vendor ON tbl_admin_booking.VendorID = tbl_Vendor.ID
                                           JOIN tbl_Customer ON tbl_admin_booking.CustomerID = tbl_Customer.ID
                                           JOIN tbl_Service ON tbl_admin_booking.ServiceID = tbl_Service.ID
                                       ";
                                            $result = mysqli_query($conn, $sql);

                                            if ($result && mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $badge_class = $row['Status'] === 'confirmed' ? 'bg-success' :
                                                        ($row['Status'] === 'cancelled' ? 'bg-danger' : 'bg-warning');
                                                    echo "<tr>";
                                                    echo "<td>" . htmlspecialchars($row['VendorName']) . "</td>";
                                                    echo "<td class='d-none d-xl-table-cell'>" . htmlspecialchars($row['CustomerName']) . "</td>";
                                                    echo "<td class='d-none d-xl-table-cell'>" . htmlspecialchars($row['ServiceName']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['Date']) . "</td>";
                                                    echo "<td class='d-none d-md-table-cell'>" . htmlspecialchars($row['Amount']) . "</td>";
                                                    echo "<td><span class='badge $badge_class'>" . ucfirst($row['Status']) . "</span></td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='6'>No booking found.</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>

                                    <!-- Pagination Controls -->
                                    <div id="pagination" class="d-flex justify-content-between mt-3">
                                        <button id="prevButton" class="btn btn-primary" disabled>Previous</button>
                                        <span id="pageNumberDisplay" class="mx-2">Page 1 of 1</span>
                                        <button id="nextButton" class="btn btn-primary">Next</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        const rows = Array.from(document.querySelectorAll('#bookingTable tbody tr')); // All table rows
                        const searchInput = document.getElementById('searchInput');
                        const dateInput = document.getElementById('dateInput');
                        const prevButton = document.getElementById('prevButton');
                        const nextButton = document.getElementById('nextButton');
                        const pageNumberDisplay = document.getElementById('pageNumberDisplay');

                        let currentPage = 1; // Track current page
                        const rowsPerPage = 5; // Number of rows per page
                        let filteredRows = rows; // Store filtered rows

                        // Render table for the current page
                        function renderTable() {
                            const start = (currentPage - 1) * rowsPerPage;
                            const end = start + rowsPerPage;

                            // Hide all rows first
                            rows.forEach(row => row.style.display = 'none');

                            // Show only the rows for the current page
                            filteredRows.slice(start, end).forEach(row => row.style.display = '');

                            // Update pagination display
                            const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
                            pageNumberDisplay.textContent = `Page ${currentPage} of ${totalPages}`;

                            // Enable/Disable pagination buttons
                            prevButton.disabled = currentPage === 1;
                            nextButton.disabled = currentPage >= totalPages;
                        }

                        // Filter rows based on search and date input
                        function filterRows() {
                            const textFilter = searchInput.value.toLowerCase();
                            const dateFilter = dateInput.value;

                            // Filter the rows
                            filteredRows = rows.filter(row => {
                                const cells = Array.from(row.cells).map(cell => cell.textContent.toLowerCase());
                                const dateCell = row.cells[3].textContent.trim();

                                const textMatch = cells.some(cellText => cellText.includes(textFilter));
                                const dateMatch = dateFilter ? dateCell === dateFilter : true;

                                return textMatch && dateMatch;
                            });

                            // Reset to first page after filtering
                            currentPage = 1;
                            renderTable(); // Render filtered rows
                        }

                        // Pagination button listeners
                        prevButton.addEventListener('click', () => {
                            if (currentPage > 1) {
                                currentPage--;
                                renderTable();
                            }
                        });

                        nextButton.addEventListener('click', () => {
                            const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
                            if (currentPage < totalPages) {
                                currentPage++;
                                renderTable();
                            }
                        });

                        // Event listeners for search and date inputs
                        searchInput.addEventListener('keyup', filterRows);
                        dateInput.addEventListener('change', filterRows);

                        // Initial render
                        renderTable();
                    </script>


                </div>

                <div class="row">

                    <!-- upcoming events table -->
                    <div class="container-fluid" style="padding: 12px;">
    <div class="row">
        <div class="col-12 d-flex">
            <div class="card flex-fill" style="width: 100%; max-width: 1240px; margin: auto; padding: 25px;">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Confirm Payments</h5>
                    <div class="d-flex gap-2">
                        <input type="text" id="paymentSearch" onkeyup="searchPayments()" class="form-control"
                            placeholder="Search payments..." style="max-width: 200px;">
                        <input type="date" id="dateSearch" oninput="searchPayments()" class="form-control"
                            style="max-width: 200px;">
                    </div>
                </div>
                <table class="table table-hover my-0" id="paymentTable">
                    <thead>
                        <tr>
                            <th class="d-none d-xl-table-cell">Booking ID</th>
                            <th class="d-none d-xl-table-cell">Vendor Name</th>
                            <th class="d-none d-xl-table-cell">Customer Name</th>
                            <th class="d-none d-xl-table-cell">Amount</th>
                            <th class="d-none d-md-table-cell">Payment Date</th>
                            <th class="d-none d-md-table-cell">Status</th>
                        </tr>
                    </thead>
                    <tbody id="paymentTableBody">
                        <?php
                        // SQL Query to fetch payment data
                        $sql = "
                            SELECT 
                                tbl_admin_payment.ID, 
                                tbl_Vendor.Name AS VendorName, 
                                tbl_Customer.Name AS CustomerName, 
                                tbl_admin_booking.Date AS BookingDate,
                                tbl_admin_payment.Amount, 
                                tbl_admin_payment.Date AS PaymentDate,
                                tbl_admin_payment.BookingID AS bid, 
                                tbl_admin_payment.Status
                            FROM tbl_admin_payment
                            JOIN tbl_admin_booking ON tbl_admin_payment.BookingID = tbl_admin_booking.ID
                            JOIN tbl_Vendor ON tbl_admin_booking.VendorID = tbl_Vendor.ID
                            JOIN tbl_Customer ON tbl_admin_booking.CustomerID = tbl_Customer.ID
                        ";

                        $result = mysqli_query($conn, $sql);

                        if ($result && mysqli_num_rows($result) > 0) {
                            $payments = [];
                            while ($row = mysqli_fetch_assoc($result)) {
                                $payments[] = $row;
                            }
                            // Output the payments array to JavaScript
                            echo "<script>const payments = " . json_encode($payments) . ";</script>";
                        } else {
                            // Display a message if no data is found
                            echo "<tr><td colspan='6'>No payment found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <!-- Pagination Controls -->
                <div id="pagination" class="d-flex justify-content-between mt-3">
                    <button id="prevButton" class="btn btn-primary" disabled>Previous</button>
                    <span id="pageNumberDisplay" class="mx-2">Page 1 of 1</span>
                    <button id="nextButton" class="btn btn-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const rowsPerPage = 5;
    let currentPage = 1;
    let filteredPayments = [];

    // Check if payments data is loaded correctly
    console.log('Loaded payments:', payments);

    // Populate filteredPayments initially
    filteredPayments = payments;

    function displayPayments() {
        const tableBody = document.getElementById('paymentTableBody');
        tableBody.innerHTML = ''; // Clear the table body

        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        for (let i = start; i < end && i < filteredPayments.length; i++) {
            const payment = filteredPayments[i];
            const badgeClass =
                payment.Status === 'confirmed' ? 'bg-success' :
                payment.Status === 'cancelled' ? 'bg-danger' : 'bg-warning';

            const row = `
                <tr>
                    <td>${payment.bid}</td>
                    <td class='d-none d-xl-table-cell'>${payment.VendorName}</td>
                    <td class='d-none d-xl-table-cell'>${payment.CustomerName}</td>
                    <td>${payment.Amount}</td>
                    <td class='d-none d-md-table-cell'>${payment.PaymentDate}</td>
                    <td><span class='badge ${badgeClass}'>${payment.Status.charAt(0).toUpperCase() + payment.Status.slice(1)}</span></td>
                </tr>
            `;
            tableBody.innerHTML += row;
        }

        updatePagination();
    }

    function updatePagination() {
        const totalPages = Math.ceil(filteredPayments.length / rowsPerPage);
        document.getElementById('prevButton').disabled = currentPage === 1;
        document.getElementById('nextButton').disabled = currentPage === totalPages;
        document.getElementById('pageNumberDisplay').textContent = `Page ${currentPage} of ${totalPages}`;
    }

    document.getElementById('prevButton').addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            displayPayments();
        }
    });

    document.getElementById('nextButton').addEventListener('click', () => {
        if (currentPage < Math.ceil(filteredPayments.length / rowsPerPage)) {
            currentPage++;
            displayPayments();
        }
    });

    function searchPayments() {
        const input = document.getElementById("paymentSearch").value.toUpperCase();
        const dateInput = document.getElementById("dateSearch").value;

        filteredPayments = payments.filter(payment => {
            const textMatch = Object.values(payment).some(value =>
                value.toString().toUpperCase().includes(input)
            );
            const dateMatch = !dateInput || payment.PaymentDate === dateInput;
            return textMatch && dateMatch;
        });

        currentPage = 1; // Reset to the first page
        displayPayments();
    }

    // Initial render
    displayPayments();
</script>

                </div>

            </main>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-start">
                            <p class="mb-0">
                                <a class="text-muted" href="https://adminkit.io/"
                                    target="_blank"><strong>Eventify</strong></a> - <a class="text-muted"
                                    href="https://adminkit.io/" target="_blank"><strong>Admin Panel</strong></a> &copy;
                            </p>
                        </div>
                        <div class="col-6 text-end">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a class="text-muted" href="https://adminkit.io/" target="_blank">Support</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="https://adminkit.io/" target="_blank">Help Center</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="https://adminkit.io/" target="_blank">Privacy</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="https://adminkit.io/" target="_blank">Terms</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="js/app.js"></script>
    <!-- Earning Line Bar -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var ctx = document.getElementById("chartjs-dashboard-line").getContext("2d");
            var gradient = ctx.createLinearGradient(0, 0, 0, 225);
            gradient.addColorStop(0, "rgba(215, 227, 244, 1)");
            gradient.addColorStop(1, "rgba(215, 227, 244, 0)");

            // Fixed months from January to December
            var allMonths = [
                "January", "February", "March", "April",
                "May", "June", "July", "August",
                "September", "October", "November", "December"
            ];

            // Fetching data from PHP
            var months = <?php echo json_encode($months); ?>; // should contain full month names
            var earnings = <?php echo json_encode($earnings); ?>;

            // Create an array of 12 months initialized to 0
            var earningsPerMonth = new Array(12).fill(0);

            // Populate earningsPerMonth based on the data retrieved
            months.forEach(function (month, index) {
                var monthIndex = allMonths.indexOf(month);
                if (monthIndex !== -1) {
                    earningsPerMonth[monthIndex] = earnings[index];
                }
            });

            // Line chart
            new Chart(document.getElementById("chartjs-dashboard-line"), {
                type: "line",
                data: {
                    labels: allMonths, // Use full month names
                    datasets: [{
                        label: "Earnings ",
                        fill: true,
                        backgroundColor: gradient,
                        borderColor: window.theme.primary,
                        data: earningsPerMonth // Data mapped to each month
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    tooltips: {
                        intersect: false
                    },
                    hover: {
                        intersect: true
                    },
                    plugins: {
                        filler: {
                            propagate: false
                        }
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                color: "rgba(0,0,0,0.0)"
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                stepSize: 10000 // Adjust step size if needed
                            },
                            display: true,
                            borderDash: [3, 3],
                            gridLines: {
                                color: "rgba(0,0,0,0.0)"
                            }
                        }]
                    }
                }
            });
        });
    </script>


    <script>
        // Dynamically add CSS to style the flatpickr calendar
        var style = document.createElement('style');
        style.innerHTML = `
        .flatpickr-calendar .flatpickr-weekdays {
            display: flex; /* Use flexbox for better control of spacing */
            justify-content: space-around; /* Distribute weekday names evenly */
        }
        .flatpickr-calendar .flatpickr-weekday {
            text-align: center;
            padding: 5px; /* Adjust padding around weekday names */
            margin: 0 20px; /* Increased horizontal margin for more space between weekdays */
            font-weight: bold;
            font-size: 14px; /* Optional: Adjust the font size */
        }
        .flatpickr-calendar .flatpickr-days {
            margin-top: 15px; /* Add some space between the weekdays and the days grid */
        }
    `;
        document.head.appendChild(style); // Append the style to the head

        document.addEventListener("DOMContentLoaded", function () {
            var date = new Date(Date.now() - 5 * 24 * 60 * 60 * 1000);
            var defaultDate = date.getUTCFullYear() + "-" + (date.getUTCMonth() + 1) + "-" + date.getUTCDate();
            document.getElementById("datetimepicker-dashboard").flatpickr({
                inline: true,
                prevArrow: "<span title=\"Previous month\">&laquo;</span>",
                nextArrow: "<span title=\"Next month\">&raquo;</span>",
                defaultDate: defaultDate
            });
        });
    </script>

</body>

</html>