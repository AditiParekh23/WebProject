<?php
include 'config.php';

$sql = "SELECT 
            v.ID AS VendorID,
            v.Name AS VendorName,
            v.CompanyName,
            vs.Price,
            vs.BookingPrice,
            v.Overall_Ratings,  -- Ensure this is the correct column name
            s.Name AS ServiceName,
            v.DisplayImage  -- Ensure this column exists in tbl_Vendor
        FROM 
            tbl_Vendor_Service_Selection vs
        JOIN 
            tbl_Vendor v ON vs.VendorID = v.ID
        JOIN 
            tbl_Service s ON vs.ServiceID = s.ID";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='vendor-card'>";

        // Build the full image path
        $imagePath = 'uploads/vendor_images/' . htmlspecialchars($row['DisplayImage']);
        
        // Debugging line to see the image path
        echo "<p>Image Path: " . htmlspecialchars($imagePath) . "</p>"; 

        echo "<img src='" . $imagePath . "' alt='Vendor Image' onerror='this.onerror=null; this.src=\"default-image.jpg\"' />"; // fallback to a default image if fails
        echo "<h2>" . htmlspecialchars($row['VendorName']) . "</h2>";
        echo "<p>Company: " . htmlspecialchars($row['CompanyName']) . "</p>";
        echo "<p>Service: " . htmlspecialchars($row['ServiceName']) . "</p>";
        echo "<p>Rating: " . htmlspecialchars($row['Overall_Ratings']) . " / 5</p>";
        echo "<p>Price: $" . htmlspecialchars($row['BookingPrice']) . "</p>";
        echo "</div>";
    }
} else {
    echo "No vendors found.";
}

echo $sql; // This will show you the full SQL query being executed.

?>
