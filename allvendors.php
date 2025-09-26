<?php
include 'config.php';

$sql = "SELECT 
            v.ID AS VendorID,
            v.Name AS VendorName,
            v.CompanyName,
            vs.Price,
            vs.BookingPrice,
            v.Overall_Ratings,
            s.Name AS ServiceName,
            v.DisplayImage
        FROM 
            tbl_Vendor_Service_Selection vs
        JOIN 
            tbl_Vendor v ON vs.VendorID = v.ID
        JOIN 
            tbl_Service s ON vs.ServiceID = s.ID";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendors</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .vendor-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
        }

        .vendor-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 15px;
            width: calc(20% - 0px); /* Adjust width to fit 4 cards in a row */
            text-align: center;
            transition: transform 0.2s;
        }

        .vendor-card:hover {
            transform: scale(1.05);
        }

        .vendor-card img {
            max-width: 100%;
            border-radius: 8px;
            height: 150px; /* Fixed height for uniformity */
            object-fit: cover;
        }

        h2 {
            margin: 10px 0 5px;
            font-size: 1.5em;
        }

        p {
            margin: 5px 0;
        }

        @media (max-width: 768px) {
            .vendor-card {
                width: calc(48% - 20px); /* Responsive width for smaller screens */
            }
        }

        @media (max-width: 480px) {
            .vendor-card {
                width: 100%; /* Full width for mobile */
            }
        }
    </style>
</head>
<body>

<h1>Vendors</h1>

<div class="vendor-container">
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='vendor-card'>";

            // Build the full image path
            $imagePath = 'uploads/vendor_images/' . htmlspecialchars($row['DisplayImage']);
            echo "<img src='" . $imagePath . "' alt='Vendor Image' onerror='this.onerror=null; this.src=\"default-image.jpg\"' />";
            echo "<h2>" . htmlspecialchars($row['VendorName']) . "</h2>";
            echo "<p>Company: " . htmlspecialchars($row['CompanyName']) . "</p>";
            echo "<p>Service: " . htmlspecialchars($row['ServiceName']) . "</p>";
            echo "<p>Rating: " . htmlspecialchars($row['Overall_Ratings']) . " / 5</p>";
            echo "<p>Booking Price: ₹" . htmlspecialchars($row['BookingPrice']) . "</p>"; // Changed to ₹ symbol
            echo "</div>";
        }
    } else {
        echo "<p>No vendors found.</p>";
    }
    ?>
</div>

</body>
</html>
