<?php
include 'config.php';

// Fetch the venue data for the given ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM tbl_Venue_Detail WHERE ID = $id"; 
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $venue = $result->fetch_assoc();
    } else {
        // Redirect if the venue ID is not found
        header('Location: index.php');
        exit;
    }
} else {
    // Redirect if no ID is provided
    header('Location: index.php');
    exit;
}

// Fetch venue types for dropdown
$venueTypeQuery = "SELECT ID, VenueType FROM tbl_Venue";
$venueTypes = $conn->query($venueTypeQuery);

// Fetch areas for dropdown
$areaQuery = "SELECT ID, Name FROM tbl_Area";
$areas = $conn->query($areaQuery);

// Handle form submission
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $capacity = $_POST['capacity'];
    $address = $_POST['address'];
    $featureDescription = $_POST['featureDescription'];
    $price = $_POST['price'];
    $bookingPrice = $_POST['bookingPrice'];
    $venueType = $_POST['venueType'];
    $area = $_POST['area'];

    // Handle file upload for the display image
    $displayImg = $venue['DisplayImg']; // Default to existing image
    if ($_FILES['displayImg']['name']) {
        $targetDir = "uploads/venue_images/";
        $targetFile = $targetDir . basename($_FILES["displayImg"]["name"]);
        if (move_uploaded_file($_FILES["displayImg"]["tmp_name"], $targetFile)) {
            $displayImg = $targetFile; // Update to the new image path
        }
    }

    // Update the venue details in the database
    $sql = "UPDATE tbl_Venue_Detail 
            SET Name = '$name', Capacity = '$capacity', Address = '$address', 
                FeatureDescription = '$featureDescription', Price = '$price', 
                BookingPrice = '$bookingPrice', VenueID = '$venueType', 
                AreaID = '$area', DisplayImg = '$displayImg' 
            WHERE ID = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Record updated successfully!'); window.location.href='service.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Venue</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        form {
            width: 50%;
            margin: 40px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: white;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"], button[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover, button[type="submit"]:hover {
            background-color: #3e8e41;
        }
        @media (max-width: 600px) {
            form {
                width: 90%;
                margin: 20px auto;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Venue</h1>
        <form method="POST" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($venue['Name']); ?>" required>

            <label for="capacity">Capacity:</label>
            <input type="number" id="capacity" name="capacity" value="<?php echo htmlspecialchars($venue['Capacity']); ?>" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($venue['Address']); ?>" required>

            <label for="featureDescription">Feature Description:</label>
            <textarea id="featureDescription" name="featureDescription" rows="4" required><?php echo htmlspecialchars($venue['FeatureDescription']); ?></textarea>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($venue['Price']); ?>" required step="0.01">

            <label for="bookingPrice">Booking Price:</label>
            <input type="number" id="bookingPrice" name="bookingPrice" value="<?php echo htmlspecialchars($venue['BookingPrice']); ?>" required step="0.01">

            <!-- Venue Type Dropdown -->
            <label for="venueType">Venue Type:</label>
            <select id="venueType" name="venueType" required>
                <?php while ($row = $venueTypes->fetch_assoc()) { ?>
                    <option value="<?php echo $row['ID']; ?>" <?php echo $row['ID'] == $venue['VenueID'] ? 'selected' : ''; ?>>
                        <?php echo $row['VenueType']; ?>
                    </option>
                <?php } ?>
            </select>

            <!-- Area Dropdown -->
            <label for="area">Area:</label>
            <select id="area" name="area" required>
                <?php while ($row = $areas->fetch_assoc()) { ?>
                    <option value="<?php echo $row['ID']; ?>" <?php echo $row['ID'] == $venue['AreaID'] ? 'selected' : ''; ?>>
                        <?php echo $row['Name']; ?>
                    </option>
                <?php } ?>
            </select>

            <!-- Display Image -->
            <label for="displayImg">Display Image:</label>
            <input type="file" id="displayImg" name="displayImg">
            <?php if ($venue['DisplayImg']) { ?>
                <img src="<?php echo $venue['DisplayImg']; ?>" alt="Venue Image" width="200">
            <?php } ?>

            <input type="hidden" name="id" value="<?php echo htmlspecialchars($venue['ID']); ?>">
            
            <button type="submit" name="update">Update</button>
        </form>
    </div>
</body>
</html>
