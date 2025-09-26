<?php
// Sample connection setup (ensure this matches your actual database setup)
$conn = new mysqli("localhost", "root", "", "project_eventify");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Receive filter parameters
$areas = isset($_POST['areas']) ? $_POST['areas'] : [];
$venueTypes = isset($_POST['venueTypes']) ? $_POST['venueTypes'] : [];
$minPrice = isset($_POST['minPrice']) ? $_POST['minPrice'] : 0;
$maxPrice = isset($_POST['maxPrice']) ? $_POST['maxPrice'] : PHP_INT_MAX;

// Build SQL query with filters
$query = "SELECT * FROM tbl_Venue_Detail WHERE Price BETWEEN $minPrice AND $maxPrice";

// Add area filters if any are selected
if (!empty($areas)) {
    $areaIds = implode(",", array_map('intval', $areas));
    $query .= " AND AreaID IN ($areaIds)";
}

// Add venue type filters if any are selected
if (!empty($venueTypes)) {
    $venueTypeIds = implode(",", array_map('intval', $venueTypes));
    $query .= " AND VenueID IN ($venueTypeIds)";
}

$result = $conn->query($query);

// Generate HTML for the filtered results
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='venue-card'>";
        echo "<h3>" . $row['Name'] . "</h3>";
        echo "<p>Price: " . $row['Price'] . "</p>";
        echo "<p>Capacity: " . $row['Capacity'] . "</p>";
        echo "</div>";
    }
} else {
    echo "<p>No venues found matching the filters.</p>";
}

$conn->close();
?>
