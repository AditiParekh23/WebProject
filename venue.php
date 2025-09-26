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
        vd.DisplayImg, 
        vd.Name, 
        v.Address, 
        a.Name AS AreaName, 
        vd.Price, 
        v.Overall_Ratings,
        v.ID AS VendorID, -- Fetch Vendor ID for the Book Now button
        vd.ID AS VenueDetailID
    FROM 
        tbl_venue_detail vd
    JOIN 
        tbl_Vendor v ON vd.VendorID = v.ID
    JOIN 
        tbl_Area a ON v.AreaID = a.ID
";
$result = $conn->query($sql);
$VenueData = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $VenueData[] = $row;
    }
}

// Fetch areas for filtering
$areas = [];
$areaQuery = "SELECT ID,Name FROM tbl_area";
$areaResult = $conn->query($areaQuery);
if ($areaResult->num_rows > 0) {
    while ($row = $areaResult->fetch_assoc()) {
        $areas[] = $row;
    }
}

// Fetch venue types for filtering
$venueTypes = [];
$venueTypeQuery = "SELECT ID,VenueType FROM tbl_venue"; // Assuming you have a venue type table
$venueTypeResult = $conn->query($venueTypeQuery);
if ($venueTypeResult->num_rows > 0) {
    while ($row = $venueTypeResult->fetch_assoc()) {
        $venueTypes[] = $row;
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
            /* General Styles */
            body, h2, h3, h4, p, a {
                font-family: Arial, sans-serif; /* Set font to Arial */
            }

            /* Search Box Styles */
            .search-box input {
                width: 540px; /* Adjusted width for search input */
                flex-grow: 1; /* Make input take all available space */
                padding: 15px; /* Increased padding for a more spacious input */
                border: 1px solid #ccc; /* Border for input */
                border-radius: 5px; /* Rounded corners */
                font-size: 16px; /* Increased font size for better readability */
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Added shadow for depth */
                transition: border-color 0.3s ease; /* Smooth transition for border color */
                margin-right: 300px; /* Space between input and dropdowns */
            }

            .search-box input:focus {
                outline: none; /* Remove default outline */
                border-color: #C78665; /* Change border color on focus */
                box-shadow: 0 0 5px rgba(199, 134, 101, 0.5); /* Shadow effect on focus */
            }

            .search-box select {
                padding: 15px; /* Match padding with input */
                border: 1px solid #ccc; /* Border for dropdowns */
                border-radius: 5px; /* Rounded corners for dropdowns */
                font-size: 16px; /* Font size for dropdowns */
                background-color: #f8f9fa; /* Light background for dropdowns */
                cursor: pointer; /* Pointer cursor for dropdowns */
                transition: border-color 0.3s ease; /* Smooth transition for border color */
                height: 54px; /* Match height with the input box */
                margin-right: 10px;
            }

            .search-box select:hover {
                border-color: #C78665; /* Change border color on hover */
            }

            .search-box select:focus {
                outline: none; /* Remove default focus outline */
                border-color: #C78665; /* Change border color on focus */
                box-shadow: 0 0 5px rgba(199, 134, 101, 0.5); /* Shadow effect on focus */
            }

            .search-box select:nth-child(2) {
                margin-left: 10px; /* Add space between the dropdowns */
            }

            /* Sidebar Styles */
            .sidebar-wrapper {
                padding-left: 15px; /* 10px space on the left of filter panel */
            }

            .sidebar {
                background-color: #f8f9fa;
                padding: 20px;
                margin-bottom: 20px;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .sidebar h4 {
                font-size: 18px;
                color: #333;
                margin-bottom: 10px;
            }

            .sidebar .form-check {
                margin-bottom: 10px;
            }

            /* Card Styling */
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

            /* Button Styles */
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

            /* Price Range Input Styles */
            input[type="number"] {
                width: calc(50% - 10px); /* Adjust width to allow two inputs side by side */
                padding: 15px; /* Padding for spacing */
                border: 1px solid #ccc; /* Border for the input */
                border-radius: 5px; /* Rounded corners */
                font-size: 16px; /* Increased font size for better readability */
                background-color: #f8f9fa; /* Light background color */
                transition: border-color 0.3s ease; /* Smooth transition for border color */
            }

            input[type="number"]:focus {
                outline: none; /* Remove default outline */
                border-color: #C78665; /* Change border color on focus */
                box-shadow: 0 0 5px rgba(199, 134, 101, 0.5); /* Shadow effect on focus */
            }

            /* Container for Price Inputs to align them properly */
            .price-range {
                display: flex; /* Use flexbox for alignment */
                justify-content: space-between; /* Space between the inputs */
                margin-bottom: 20px; /* Spacing below the price range inputs */
            }


            /* Media Queries for Responsive Design */
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
                <h1>Venue</h1>
            </div>

            <!-- Main Container with Sidebar and Content -->
            <div class="container-fluid">
                <div class="row">
                    <!-- Sidebar Filter Panel within a wrapper for padding -->
                    <div class="col-md-3 sidebar-wrapper">
                        <div class="sidebar">
                            <h4>Filter by:</h4>

                            <!-- Area Filter Checkboxes -->
                            <h4>Area</h4>
                            <div id="visible-areas">
                                <?php foreach (array_slice($areas, 0, 5) as $area): ?>
                                    <div>
                                        <input type="checkbox" id="area-<?php echo $area['ID']; ?>" />
                                        <label for="area-<?php echo $area['ID']; ?>"><?php echo htmlspecialchars($area['Name']); ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div id="hidden-areas" style="display: none;"> <!-- Initially hidden -->
                                <?php foreach (array_slice($areas, 5) as $area): ?>
                                    <div>
                                        <input type="checkbox" id="area-<?php echo $area['ID']; ?>" />
                                        <label for="area-<?php echo $area['ID']; ?>"><?php echo htmlspecialchars($area['Name']); ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- See More Button -->
                            <button id="see-more-areas" class="btn btn-link" style="display: block; margin-top: 10px;" onclick="toggleAreas()">See More</button><br>

                            <h4>Price Range</h4>
                            <div class="price-range">
                                <input type="number" id="minPrice" placeholder="Min Price" aria-label="Minimum Price">
                                <input type="number" id="maxPrice" placeholder="Max Price" aria-label="Maximum Price">
                            </div>

                            <!-- Venue Type Filter Checkboxes -->
                            <h4>Venue Type</h4>

                            <div id="visible-venue-types">
                                <?php if (!empty($venueTypes)): ?>
                                    <?php foreach (array_slice($venueTypes, 0, 5) as $type): ?>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="venueType-<?php echo htmlspecialchars($type['ID']); ?>" name="filterVenueType[]" value="<?php echo htmlspecialchars($type['ID']); ?>">
                                            <label class="form-check-label" for="venueType-<?php echo htmlspecialchars($type['ID']); ?>"><?php echo htmlspecialchars($type['VenueType']); ?></label>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>No venue types available.</p>
                                <?php endif; ?>
                            </div>

                            <div id="hidden-venue-types" style="display: none;">
                                <?php foreach (array_slice($venueTypes, 5) as $type): ?>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="venueType-<?php echo htmlspecialchars($type['ID']); ?>" name="filterVenueType[]" value="<?php echo htmlspecialchars($type['ID']); ?>">
                                        <label class="form-check-label" for="venueType-<?php echo htmlspecialchars($type['ID']); ?>"><?php echo htmlspecialchars($type['VenueType']); ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <button id="see-more-venue-types" class="btn btn-link" onclick="toggleVenueTypes()">See More</button>
                        </div>

                    </div>


                    <!-- Content Area for Venue Cards -->
                    <div class="col-md-9 content-area">
                        <div class="row">
                            <div class="col-md-12 search-box">
                                <input type="text" id="search" placeholder="Search for Venues..." aria-label="Search for caterers">
                                <!-- Dropdown for sorting by price -->
                                <select id="sortPrice" aria-label="Sort by price">
                                    <option value="">Sort by: Price or Ratings </option>
                                    <option value="asc">Price: Low to High</option>
                                    <option value="desc">Price: High to Low</option>
                                    <option value="asc">Ratings: Lowest to Highest</option>
                                    <option value="desc">Ratings: Highest to Lowest</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <?php if (!empty($VenueData)): ?>
                                <?php foreach ($VenueData as $item): ?>
                                    <div class="col-md-4"> <!-- Bootstrap grid column -->
                                        <div class="card">
                                            <img src="uploads/vendor_images/<?php echo htmlspecialchars($item['DisplayImg']); ?>" alt="Decoration Image" class="img-fluid"> <!-- Bootstrap's img-fluid class -->
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h3 class="card-title"><strong><?php echo htmlspecialchars($item['Name']); ?></strong></h3>
                                                    <div class="rating">
                                                        <i class="fa-solid fa-star"></i>
                                                        <span><?php echo htmlspecialchars($item['Overall_Ratings']); ?></span>
                                                    </div>
                                                </div>

                                                <p><i class="fa-solid fa-location-dot" style="color: #be8250;"></i> <?php echo htmlspecialchars($item['Address'] . ', ' . $item['AreaName']); ?></p>
                                                <h4>
                                                    <strong>₹<?php echo htmlspecialchars($item['Price']); ?></strong> 
                                                    <span style="font-size: 0.8em;">per day</span>
                                                </h4>
                                                <a href="venue_book.php?vendor_id=<?php echo $item['VendorID']; ?>&venue_detail_id=<?php echo $item['VenueDetailID']; ?>" class="btn btn-primary">
                                                    Book Now
                                                </a>                                            </div>
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
            </div>
        </div>

        <!-- JavaScript for Filter Functionality -->
        <script>
            function applyFilters() {
                const areaCheckboxes = document.querySelectorAll('input[name="filterArea[]"]:checked');
                const ratingCheckboxes = document.querySelectorAll('input[name="filterRating[]"]:checked');
                const venueTypeCheckboxes = document.querySelectorAll('input[name="filterVenueType[]"]:checked');

                const selectedAreas = Array.from(areaCheckboxes).map(cb => cb.value);
                const selectedRatings = Array.from(ratingCheckboxes).map(cb => cb.value);
                const selectedVenueTypes = Array.from(venueTypeCheckboxes).map(cb => cb.value);

                let queryString = `?area=${selectedAreas.join(',')}&rating=${selectedRatings.join(',')}&venueType=${selectedVenueTypes.join(',')}`;
                window.location.href = "your_php_page.php" + queryString;
            }
        </script>
        <script>
            function toggleAreas() {
                const hiddenAreas = document.getElementById('hidden-areas');
                const seeMoreButton = document.getElementById('see-more-areas');

                if (hiddenAreas.style.display === "none") {
                    hiddenAreas.style.display = "block";
                    seeMoreButton.textContent = "See Less"; // Change button text
                } else {
                    hiddenAreas.style.display = "none";
                    seeMoreButton.textContent = "See More"; // Change button text back
                }
            }
        </script>
        <script>
            function toggleVenueTypes() {
                const hiddenTypes = document.getElementById('hidden-venue-types');
                const seeMoreButton = document.getElementById('see-more-venue-types');

                if (hiddenTypes.style.display === "none") {
                    hiddenTypes.style.display = "block";
                    seeMoreButton.textContent = "See Less"; // Change button text
                } else {
                    hiddenTypes.style.display = "none";
                    seeMoreButton.textContent = "See More"; // Reset button text
                }
            }
        </script>


    </body>
</html>
