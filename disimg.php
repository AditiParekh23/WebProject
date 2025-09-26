<?php
include 'header.php';
// If the user role is not set or not a customer, redirect to login
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'customer') {
    header('Location: login.php');
    exit();
}

// Retrieve user data safely
$user = $_SESSION['user'] ?? [];
$name = $user['Name'] ?? '';
$email = $user['EmailID'] ?? ''; // Ensure email is captured
$contact_number = $user['Contact_Number'] ?? '';

include 'config.php'; // Database connection
// Fetch decoration details with vendor info
$sql = "
    SELECT 
        p.DisplayImg, 
        v.CompanyName,
        p.PackageName,
        v.Address, 
        a.Name AS AreaName, 
        p.Price, 
        v.Overall_Ratings,
        v.ID AS VendorID  -- Fetch Vendor ID for the Book Now button
    FROM 
        tbl_photographer_details p
    JOIN 
        tbl_Vendor v ON p.VendorID = v.ID
    JOIN 
        tbl_Area a ON v.AreaID = a.ID
";
$result = $conn->query($sql);
$PhotogrphyData = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $PhotogrphyData[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>Decoration Display Images</title>
        <style>
            /* Custom CSS Overrides */
            body, h2, h3,h4, p, a {
                font-family: Arial, sans-serif; /* Set font to Arial */
            }
            div.decor .container {
                display: flex !important;
                flex-wrap: wrap !important;
                justify-content: space-between !important; /* Distribute cards evenly */
                gap: 20px; /* Maintain spacing between cards */
                padding: 0px 10px !important; /* Reduced left and right padding */
            }

            div.decor .card {
                flex: 0 1 calc(33.33% - 20px) !important; /* Increase card width for larger viewports */
                margin: 15px 0 !important; /* Reduced top and bottom margin */
                border: 1px solid #ccc !important;
                border-radius: 8px !important;
                overflow: hidden !important;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
                background-color: white !important;
                transition: 0.3s !important;
            }

            div.decor .card img {
                width: 100% !important;
                height: 250px !important; /* Increased image height */
                object-fit: cover !important;
            }

            div.decor .card-body {
                padding: 15px; /* Keep card content padding */
                text-align: left; /* Text alignment inside cards */
            }

            div.decor .card h3 {
                font-size: 20px !important; /* Slightly larger heading size */
                color: #333 !important;
                margin-bottom: 10px !important;
            }

            div.decor .card p {
                font-size: 14px !important;
                color: #555 !important;
                margin-bottom: 5px !important;
            }

            div.decor .rating {
                font-size: 16px !important;
                color: #C78665 !important;
                display: flex;
                align-items: center;
            }

            div.decor .rating i {
                margin-right: 5px;
            }

            div.decor .card:hover {
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2) !important;
                transform: translateY(-5px); /* Hover effect */
            }

            div.decor h2 {
                text-align: center !important;
                font-size: 24px !important;
                margin-bottom: 20px !important;
                color: #333 !important;
            }
            div.decor h4 {
                margin-bottom: 20px !important;
                color: #514e4e !important;
            }

            /* Style for the Book Now button */
            .btn-primary {
                background-color: #C78665; /* Custom background color */
                border: none; /* Remove default border */
                color: white; /* Text color */
                font-size: 16px; /* Font size */
                padding: 10px 20px; /* Padding for top-bottom and left-right */
                border-radius: 5px; /* Rounded corners */
                transition: background-color 0.3s ease, transform 0.3s ease; /* Transition effect */
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Shadow effect */
            }

            .btn-primary:hover {
                background-color: #a06f55; /* Darker background on hover */
                transform: translateY(-2px); /* Lift effect on hover */
            }

            .btn-primary:active {
                background-color: #8a5b43; /* Darker background when clicked */
                transform: translateY(0); /* Reset lift effect on click */
            }

            .btn-primary:focus {
                outline: none; /* Remove default focus outline */
                box-shadow: 0 0 0 0.2rem rgba(199, 134, 101, 0.5); /* Focus ring */
            }

            @media (max-width: 1024px) {
                div.decor .card {
                    flex: 0 1 calc(48% - 20px) !important; /* Two cards per row on medium screens */
                }
            }

            @media (max-width: 768px) {
                div.decor .card {
                    flex: 0 1 calc(48% - 10px) !important; /* Wider cards on tablet */
                }
            }

            @media (max-width: 576px) {
                div.decor .card {
                    flex: 0 1 calc(100% - 20px) !important; /* Full width on mobile */
                }
            }
        </style>
    </head>
    <body>

        <!-- Main Content -->
        <div class="decor">
            <div class="heading">
                <img src="img/banner/flowers.png" alt="">
                <h1>Photographers</h1>
            </div>

            <div class="container">
                <div class="row">
                    <?php if (!empty($PhotogrphyData)): ?>
                        <?php foreach ($PhotogrphyData as $item): ?>
                            <div class="col-md-4"> <!-- Bootstrap grid column -->
                                <div class="card">
                                    <img src="uploads/vendor_images/<?php echo htmlspecialchars($item['DisplayImg']); ?>" alt="Decoration Image" class="img-fluid"> <!-- Bootstrap's img-fluid class -->
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h3 class="card-title"><strong><?php echo htmlspecialchars($item['CompanyName']); ?></strong></h3>
                                            <div class="rating">
                                                <i class="fa-solid fa-star"></i>
                                                <span><?php echo htmlspecialchars($item['Overall_Ratings']); ?></span>
                                            </div>
                                        </div>
                                        <p> <?php echo htmlspecialchars($item['PackageName']); ?></p>
                                        <p><i class="fa-solid fa-location-dot" style="color: #be8250;"></i> <?php echo htmlspecialchars($item['Address'] . ', ' . $item['AreaName']); ?></p>
                                        <h4> <strong>₹<?php echo htmlspecialchars($item['Price']); ?></strong> </h4>
                                        <a href="booknow.php?vendor_id=<?php echo $item['VendorID']; ?>" class="btn btn-primary">Book Now</a> <!-- Updated button link -->
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-md-12">
                            <p>No decoration data available.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </body>
</html>
