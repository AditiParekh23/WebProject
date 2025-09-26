<?php
session_start(); // Start the session
require 'config.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the vendor is logged in
    if (!isset($_SESSION['user']['VendorID'])) {
        header('Location: login.php');
        exit();
    }

    // Get the vendor ID from the session
    $vendorID = $_SESSION['user']['VendorID'];

    // Get the form data
    $venueID = $_POST['venueID'];
    $name = $_POST['name'];
    $capacity = $_POST['capacity'];
    $featureDescription = $_POST['featureDescription'];
    $address = $_POST['address'];
    $areaID = $_POST['areaID'];
    $price = $_POST['price'];
    $bookingPrice = $_POST['bookingPrice'];
    
    // Handle the uploaded file
    $target_dir = "uploads/vendor_images/"; // Directory to save uploaded images
    $original_file_name = basename($_FILES["displayImg"]["name"]);
    $imageFileType = strtolower(pathinfo($original_file_name, PATHINFO_EXTENSION));
    
    // Create a unique filename using timestamp
    $new_file_name = uniqid() . '_' . time() . '.' . $imageFileType;
    $target_file = $target_dir . $new_file_name;
    $uploadOk = 1;

    // Check for upload errors
    if ($_FILES["displayImg"]["error"] !== UPLOAD_ERR_OK) {
        echo "File upload error: " . $_FILES["displayImg"]["error"];
        $uploadOk = 0;
    }

    // Check if the file is an actual image
    $check = getimagesize($_FILES["displayImg"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size (limit to 5MB)
    if ($_FILES["displayImg"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk === 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // Try to upload the file
        if (move_uploaded_file($_FILES["displayImg"]["tmp_name"], $target_file)) {
            // Get just the file name to store in the database
            $file_name = basename($target_file);

            // Prepare the SQL INSERT statement
            $sql = "INSERT INTO tbl_Venue_Detail (VendorID, VenueID, Name, Capacity, FeatureDescription, Address, AreaID, Price, BookingPrice, DisplayImg)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // Prepare the statement
            $stmt = $conn->prepare($sql);
            
            // Bind parameters (store just the file name in DisplayImg)
            $stmt->bind_param("iissssidds", $vendorID, $venueID, $name, $capacity, $featureDescription, $address, $areaID, $price, $bookingPrice, $file_name);

            // Execute the statement
            if ($stmt->execute()) {
                echo "New venue detail inserted successfully!";
            } else {
                echo "Error: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Close the connection
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Venue Details</title>
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
            border-radius: 4px; /* Added border-radius for consistency */
            box-sizing: border-box; /* Added for consistent width calculation */
        }
        input[type="file"] {
            margin: 10px 0 15px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%; /* Ensuring full width for the submit button */
        }
        input[type="submit"]:hover {
            background-color: #3e8e41;
        }
        @media (max-width: 600px) {
            form {
                width: 90%; /* Responsive width for smaller screens */
                margin: 20px auto; /* Adjust margin for smaller screens */
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Insert Venue Details</h1>
        <form method="POST" enctype="multipart/form-data">

            <label for="venueID">Venue Type:</label>
            <select id="venueID" name="venueID" required>
                <option value="">Select Venue Type</option>
                <?php
                require 'config.php'; // Include your database connection
                $sql = "SELECT ID, VenueType FROM tbl_Venue";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['ID'] . "'>" . htmlspecialchars($row['VenueType']) . "</option>";
                    }
                } else {
                    echo "<option value=''>No Venue Types Available</option>";
                }
                ?>
            </select>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="capacity">Capacity:</label>
            <input type="number" id="capacity" name="capacity" required>

            <label for="featureDescription">Feature Description:</label>
            <textarea id="featureDescription" name="featureDescription" rows="4" required></textarea>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>

            <label for="areaID">Area:</label>
            <select id="areaID" name="areaID" required>
                <option value="">Select Area</option>
                <?php
                // Fetch Area Names from the database
                $sql = "SELECT * FROM tbl_Area"; // Adjust the table and column names as necessary
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['ID'] . "'>" . htmlspecialchars($row['Name']) . "</option>";
                    }
                } else {
                    echo "<option value=''>No Areas Available</option>";
                }
                ?>
            </select>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" required>

            <label for="bookingPrice">Booking Price:</label>
            <input type="number" id="bookingPrice" name="bookingPrice" step="0.01" required>

            <label for="displayImg">Display Image:</label>
            <input type="file" id="displayImg" name="displayImg" accept="image/*" required>

            <input type="submit" value="Insert Venue Detail">
        </form>
    </div>
</body>
</html>
