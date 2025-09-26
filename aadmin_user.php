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
                    <li class="sidebar-item">
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
                    <li class="sidebar-item active">
                        <a class="sidebar-link" href="aadmin_user.php">
                            <i class="align-middle" data-feather="user"></i> <span class="align-middle">Users</span>
                        </a>
                    </li>
                    <br>
                    <li class="sidebar-item"></li>
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
                                    <a href="aadmin_feedback.php" style="text-decoration: none; color: black;">Admin</a>
                                </span>
                            </a>

                        </li>
                    </ul>
                </div>
            </nav>

            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3">User Details</h1>

                    <div class="row">
                        <div class="col-xl-12 d-flex">
                            <div class="w-100">
                                <div class="row">

                                    <!-- Earnings -->
                                    <div class="col-sm-4"> <!-- Changed to col-sm-4 for larger size -->
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
                                    <div class="col-sm-4"> <!-- Changed to col-sm-4 for larger size -->
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

                                    <!-- Events -->
                                    <div class="col-sm-4"> <!-- Changed to col-sm-4 for larger size -->
                                        <div class="card" style="height: 200px;"> <!-- Set a height for the card -->
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col mt-0">
                                                        <h5 class="card-title">Events</h5>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="stat text-primary">
                                                            <i class="fa-solid fa-calendar-days"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h1 class="mt-1 mb-3"><?php echo $total_events; ?></h1>
                                                <!-- Display total events -->
                                                <div class="mb-0 <?php echo $color; ?>">
                                                    <!-- Change color based on percentage change -->
                                                    <i class="mdi mdi-arrow-bottom-right"></i>
                                                    <?php echo number_format(abs($percentage_change), 2) . '%'; ?>
                                                    <!-- Format percentage -->
                                                    <span
                                                        class="text-muted"><?php echo $percentage_change > 0 ? " Increase" : " Decrease"; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <!-- <div
                            style="display: flex; justify-content: center; align-items: center; height: 100vh; width: 100vw; background-color: #ffffff;">

                            <div class="col-12 col-md-6 col-xxl-6 d-flex order-2 order-xxl-3">
                                <div class="card flex-fill w-100">
                                    <div class="card-header">

                                        <h5 class="card-title mb-0">users</h5>
                                    </div>
                                    <div class="card-body d-flex">
                                        <div class="align-self-center w-100">
                                            <div class="py-3">
                                                <div class="chart chart-xs">
                                                    <canvas id="chartjs-dashboard-pie"></canvas>
                                                </div>
                                            </div>

                                            <table class="table mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td>Customer</td>
                                                        <td class="text-end">20</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Vendor</td>
                                                        <td class="text-end">10</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Admin</td>
                                                        <td class="text-end">1</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div> -->



                        </div>

                        <div class="row">
                            <div class="container-fluid" style="padding: 12px;">
                                <div class="row">
                                    <div class="col-12 d-flex">
                                        <div class="card flex-fill"
                                            style="width: 100%; max-width: 1240px; margin: auto; padding: 25px;">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0">Customers</h5>
                                            </div>

                                            <div class="mb-3">
                                                <input type="text" id="customerSearch" class="form-control"
                                                    placeholder="Search for customers..." style="width: 300px;">
                                            </div>

                                            <table class="table table-hover my-0">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th class="d-none d-md-table-cell">Contact</th>
                                                        <th class="d-none d-md-table-cell">Email</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="customerTableBody">
                                                    <?php
                                                    $sql = "SELECT c.Name, c.Contact_Number AS Contact, u.EmailID AS EmailID FROM tbl_customer c JOIN tbl_user u ON u.ID = c.UserID";
                                                    $result = mysqli_query($conn, $sql);
                                                    $customers = [];
                                                    if ($result) {
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            $customers[] = $row;
                                                        }
                                                    }
                                                    echo "<script>const customers = " . json_encode($customers) . ";</script>";
                                                    ?>
                                                </tbody>
                                            </table>

                                            <div id="customerPagination" class="d-flex justify-content-between mt-3">
                                                <button id="customerPrevButton" class="btn btn-primary"
                                                    disabled>Previous</button>
                                                <span id="customerPageNumberDisplay" class="mx-2">Page 1 of 5</span>
                                                <button id="customerNextButton" class="btn btn-primary">Next</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                const customerRowsPerPage = 5;
                                let customerCurrentPage = 1;
                                let customerFilteredCustomers = customers;

                                function displayCustomers() {
                                    const tableBody = document.getElementById('customerTableBody');
                                    tableBody.innerHTML = '';
                                    const start = (customerCurrentPage - 1) * customerRowsPerPage;
                                    const end = start + customerRowsPerPage;

                                    for (let i = start; i < end && i < customerFilteredCustomers.length; i++) {
                                        const customer = customerFilteredCustomers[i];
                                        const row = document.createElement('tr');
                                        row.innerHTML = `
                    <td>${customer.Name}</td>
                    <td>${customer.Contact}</td>
                    <td>${customer.EmailID}</td>
                `;
                                        tableBody.appendChild(row);
                                    }

                                    updateCustomerPagination();
                                }

                                function updateCustomerPagination() {
                                    const totalPages = Math.ceil(customerFilteredCustomers.length / customerRowsPerPage);
                                    document.getElementById('customerPrevButton').disabled = customerCurrentPage === 1;
                                    document.getElementById('customerNextButton').disabled = customerCurrentPage === totalPages;
                                    document.getElementById('customerPageNumberDisplay').textContent = `Page ${customerCurrentPage} of ${Math.min(totalPages, 5)}`;
                                }

                                displayCustomers();

                                document.getElementById('customerPrevButton').addEventListener('click', () => {
                                    if (customerCurrentPage > 1) {
                                        customerCurrentPage--;
                                        displayCustomers();
                                    }
                                });

                                document.getElementById('customerNextButton').addEventListener('click', () => {
                                    if (customerCurrentPage < Math.ceil(customerFilteredCustomers.length / customerRowsPerPage)) {
                                        customerCurrentPage++;
                                        displayCustomers();
                                    }
                                });

                                document.getElementById('customerSearch').addEventListener('keyup', function () {
                                    let filter = this.value.toLowerCase();
                                    customerFilteredCustomers = customers.filter(customer => {
                                        return (
                                            customer.Name.toLowerCase().includes(filter) ||
                                            customer.Contact.toLowerCase().includes(filter) ||
                                            customer.EmailID.toLowerCase().includes(filter)
                                        );
                                    });

                                    customerCurrentPage = 1; // Reset to first page on search
                                    displayCustomers();
                                });
                            </script>
                        </div>

                        <div class="row">
                            <div class="container-fluid" style="padding: 12px;">
                                <div class="row">
                                    <div class="col-12 d-flex">
                                        <div class="card flex-fill"
                                            style="width: 100%; max-width: 1240px; margin: auto; padding: 25px;">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0">Vendors</h5>
                                            </div>

                                            <div class="mb-3">
                                                <input type="text" id="vendorSearch" class="form-control"
                                                    placeholder="Search for vendors..." style="width: 300px;">
                                            </div>

                                            <table class="table table-hover my-0">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th class="d-none d-md-table-cell">Contact</th>
                                                        <th class="d-none d-md-table-cell">Email</th>
                                                        <th class="d-none d-md-table-cell">Service Name</th>
                                                        <th class="d-none d-md-table-cell">Company Name</th>
                                                        <th class="d-none d-md-table-cell">GST Number</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="vendorTableBody">
                                                    <?php
                                                    // SQL query to fetch vendor details
                                                    $sql = "SELECT v.Name, v.Contact_Number, u.EmailID, s.Name AS Sname, v.CompanyName, v.GST_Number FROM tbl_vendor v JOIN tbl_user u ON u.ID = v.UserID JOIN tbl_service s ON s.ID = v.ServiceID";
                                                    $result = mysqli_query($conn, $sql);
                                                    $vendors = [];

                                                    // Check if the query was successful and fetch results
                                                    if ($result) {
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            $vendors[] = $row;
                                                        }
                                                    } else {
                                                        echo "<tr><td colspan='6'>Query failed: " . mysqli_error($conn) . "</td></tr>";
                                                    }

                                                    // Convert PHP array to JavaScript
                                                    echo "<script>const vendors = " . json_encode($vendors) . ";</script>";
                                                    ?>
                                                </tbody>
                                            </table>

                                            <!-- Pagination Controls -->
                                            <div id="vendorPagination" class="d-flex justify-content-between mt-3">
                                                <button id="vendorPrevButton" class="btn btn-primary"
                                                    disabled>Previous</button>
                                                <span id="vendorPageNumberDisplay" class="mx-2">Page 1 of 5</span>
                                                <button id="vendorNextButton" class="btn btn-primary">Next</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                const vendorTableBody = document.getElementById('vendorTableBody');
                                const vendorSearch = document.getElementById('vendorSearch');
                                const vendorPrevButton = document.getElementById('vendorPrevButton');
                                const vendorNextButton = document.getElementById('vendorNextButton');
                                const vendorPageNumberDisplay = document.getElementById('vendorPageNumberDisplay');

                                let vendorCurrentPage = 1;
                                const vendorRowsPerPage = 5;  // Change this to 5 for 5 pages
                                let vendorFilteredVendors = vendors;

                                // Function to render vendors on the current page
                                function renderVendorTable(vendorsToDisplay) {
                                    const start = (vendorCurrentPage - 1) * vendorRowsPerPage;
                                    const end = start + vendorRowsPerPage;

                                    vendorTableBody.innerHTML = ''; // Clear table

                                    // Loop through the vendors to display
                                    vendorsToDisplay.slice(start, end).forEach(vendor => {
                                        const row = document.createElement('tr');
                                        row.innerHTML = `
                    <td>${vendor.Name}</td>
                    <td class="d-none d-md-table-cell">${vendor.Contact_Number}</td>
                    <td class="d-none d-md-table-cell">${vendor.EmailID}</td>
                    <td class="d-none d-md-table-cell">${vendor.Sname}</td>
                    <td class="d-none d-md-table-cell">${vendor.CompanyName}</td>
                    <td class="d-none d-md-table-cell">${vendor.GST_Number}</td>
                `;
                                        vendorTableBody.appendChild(row);
                                    });

                                    // If no vendors found, display a message
                                    if (vendorsToDisplay.length === 0) {
                                        vendorTableBody.innerHTML = "<tr><td colspan='6'>No records found.</td></tr>";
                                    }

                                    updateVendorPaginationControls(vendorsToDisplay);
                                }

                                // Update pagination controls
                                function updateVendorPaginationControls(vendorsToDisplay) {
                                    const totalPages = Math.ceil(vendorsToDisplay.length / vendorRowsPerPage);
                                    vendorPageNumberDisplay.textContent = `Page ${vendorCurrentPage} of ${Math.min(totalPages, 5)}`;
                                    vendorPrevButton.disabled = vendorCurrentPage === 1;
                                    vendorNextButton.disabled = vendorCurrentPage === totalPages;
                                }

                                // Search functionality
                                vendorSearch.addEventListener('keyup', function () {
                                    const filter = this.value.toLowerCase();
                                    vendorFilteredVendors = vendors.filter(vendor =>
                                        vendor.Name.toLowerCase().includes(filter) ||
                                        vendor.Contact_Number.toLowerCase().includes(filter) ||
                                        vendor.EmailID.toLowerCase().includes(filter) ||
                                        vendor.Sname.toLowerCase().includes(filter) ||
                                        vendor.CompanyName.toLowerCase().includes(filter) ||
                                        vendor.GST_Number.toLowerCase().includes(filter)
                                    );
                                    vendorCurrentPage = 1; // Reset to first page on search
                                    renderVendorTable(vendorFilteredVendors);
                                });

                                // Pagination button listeners
                                vendorPrevButton.addEventListener('click', () => {
                                    if (vendorCurrentPage > 1) {
                                        vendorCurrentPage--;
                                        renderVendorTable(vendorFilteredVendors);
                                    }
                                });

                                vendorNextButton.addEventListener('click', () => {
                                    const totalPages = Math.ceil(vendorFilteredVendors.length / vendorRowsPerPage);
                                    if (vendorCurrentPage < totalPages) {
                                        vendorCurrentPage++;
                                        renderVendorTable(vendorFilteredVendors);
                                    }
                                });

                                // Initial render
                                renderVendorTable(vendorFilteredVendors);
                            </script>
                        </div>



            </main>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-start">
                            <p class="mb-0">
                                <a class="text-muted" href="index.php" target="_blank"><strong>Eventify</strong></a> -
                                <a class="text-muted" href="aaadmin_dashboard.php" target="_blank"><strong>Admin
                                        Panel</strong></a> &copy;
                            </p>
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
    <!-- pie chart -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Pie chart
            new Chart(document.getElementById("chartjs-dashboard-pie"), {
                type: "pie",
                data: {
                    labels: ["Customer", "Vendor", "Admin"],
                    datasets: [{
                        data: [20, 10, 1],
                        backgroundColor: [
                            window.theme.primary,
                            window.theme.warning,
                            window.theme.danger
                        ],
                        borderWidth: 5
                    }]
                },
                options: {
                    responsive: !window.MSInputMethodContext,
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    cutoutPercentage: 75
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


    <!-- bar chart -->
    <!--<script>
            document.addEventListener("DOMContentLoaded", function () {
                // Bar chart
                new Chart(document.getElementById("chartjs-dashboard-bar"), {
                    type: "bar",
                    data: {
                        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                        datasets: [{
                                label: "This year",
                                backgroundColor: window.theme.primary,
                                borderColor: window.theme.primary,
                                hoverBackgroundColor: window.theme.primary,
                                hoverBorderColor: window.theme.primary,
                                data: [54, 67, 41, 55, 62, 45, 55, 73, 60, 76, 48, 79],
                                barPercentage: .75,
                                categoryPercentage: .5
                            }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        legend: {
                            display: false
                        },
                        scales: {
                            yAxes: [{
                                    gridLines: {
                                        display: false
                                    },
                                    stacked: false,
                                    ticks: {
                                        stepSize: 20
                                    }
                                }],
                            xAxes: [{
                                    stacked: false,
                                    gridLines: {
                                        color: "transparent"
                                    }
                                }]
                        }
                    }
                });
            });
        </script>-->
</body>

</html>