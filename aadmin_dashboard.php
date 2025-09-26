<!-- 
eventify75@gmail.com
Eventify@009
-->

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
                    <li class="sidebar-item active">
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
                                    <a href="aadmin_dashboard.php"
                                        style="text-decoration: none; color: black;">Admin</a>
                                </span>

                            </a>

                        </li>
                    </ul>
                </div>
            </nav>

            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3"><strong>Analytics</strong> Dashboard</h1>

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
                    <div class="col-12 col-md-6 col-xxl-6 d-flex order-2 order-xxl-3">
                        <div class="card flex-fill w-100">
                            <div class="card-header">

                                <h5 class="card-title mb-0">Event Packages:</h5>
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
                                                <td>Silver</td>
                                                <td class="text-end">10</td>
                                            </tr>
                                            <tr>
                                                <td>Gold</td>
                                                <td class="text-end">5</td>
                                            </tr>
                                            <tr>
                                                <td>Platinum</td>
                                                <td class="text-end">2</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xxl-6 d-flex order-1 order-xxl-1">
                        <div class="card flex-fill" style="width: 100%; height: 500px;">
                            <!-- Adjust width and height -->
                            <div class="card-header">
                                <h5 class="card-title mb-0">Calendar</h5>
                            </div>
                            <div class="card-body d-flex">
                                <div class="align-self-center w-100">
                                    <div class="chart">
                                        <div id="datetimepicker-dashboard"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <!-- upcoming events table -->
                    <div class="container-fluid" style="padding: 12px;"> <!-- Full-width container with padding -->
                        <div class="row">
                            <div class="col-12 d-flex">
                                <div class="card flex-fill"
                                    style="width: 100%; max-width: 1240px; margin: auto; padding: 25px;">
                                    <!-- Card styling -->
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Upcoming Events (Current Week & Next Week)</h5>
                                    </div>
                                    <table class="table table-hover my-0"> <!-- Table font size -->
                                        <thead>
                                            <tr>
                                                <th>Event Name</th>
                                                <th class="d-none d-xl-table-cell">Start Date</th>
                                                <th class="d-none d-xl-table-cell">End Date</th>
                                                <th>Status</th>
                                                <th class="d-none d-md-table-cell">Vendor Name</th>
                                                <th class="d-none d-md-table-cell">Service Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Check if any rows were returned
                                            if ($result && mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    // Output for debugging
                                                    echo "<!-- Debug: Event Status: " . $row['EventStatus'] . " -->"; // Debug line
                                                    // Determine badge class based on the status
                                                    $badge_class = '';
                                                    if ($row['EventStatus'] === 'confirmed') {
                                                        $badge_class = 'bg-success'; // Green for booked
                                                    } elseif ($row['EventStatus'] === 'cancelled') {
                                                        $badge_class = 'bg-danger'; // Red for cancelled
                                                    } elseif ($row['EventStatus'] == 'pending') {
                                                        $badge_class = 'bg-warning'; // Yellow for in progress
                                                    }

                                                    echo "<tr>";
                                                    echo "<td>" . $row['EventType'] . "</td>";
                                                    echo "<td class='d-none d-xl-table-cell'>" . $row['StartDate'] . "</td>";
                                                    echo "<td class='d-none d-xl-table-cell'>" . $row['EndDate'] . "</td>";
                                                    echo "<td><span class='badge $badge_class'>" . ucfirst($row['EventStatus']) . "</span></td>";
                                                    echo "<td class='d-none d-md-table-cell'>" . $row['VendorName'] . "</td>";
                                                    echo "<td class='d-none d-md-table-cell'>" . $row['ServiceName'] . "</td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='6'>No events found for the current or next week.</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--<div class="col-12 col-lg-4 col-xxl-3 d-flex">
                            <div class="card flex-fill w-100">
                                <div class="card-header">

                                    <h5 class="card-title mb-0">Monthly Sales</h5>
                                </div>
                                <div class="card-body d-flex w-100">
                                    <div class="align-self-center chart chart-lg">
                                        <canvas id="chartjs-dashboard-bar"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>-->

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
    <!-- pie chart -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Pie chart
            new Chart(document.getElementById("chartjs-dashboard-pie"), {
                type: "pie",
                data: {
                    labels: ["Silver", "Gold", "Platinum"],
                    datasets: [{
                        data: [10, 5, 2],
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