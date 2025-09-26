<?php
include 'config.php';

// Fetch the photographer data for the given ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT 
                p.ID AS PhotographyID,
                p.PhotographyType,
                pd.PackageName,
                pd.PackageDetails,
                pd.Price,
                pd.BookingPrice,
                pd.DisplayImg
            FROM 
                tbl_Photographer_Details pd
            JOIN 
                tbl_Vendor v ON pd.VendorID = v.ID
            JOIN 
                tbl_Photography p ON pd.PhotographyID = p.ID
            WHERE 
                pd.ID = $id"; 
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $photographer = $result->fetch_assoc();
    } else {
        // Redirect if the photographer ID is not found
        header('Location: index.php');
        exit;
    }
} else {
    // Redirect if no ID is provided
    header('Location: index.php');
    exit;
}

// Fetch photography types for dropdown
$photographyTypeQuery = "SELECT ID, PhotographyType FROM tbl_Photography";
$photographyTypes = $conn->query($photographyTypeQuery);

// Handle form submission
if (isset($_POST['update'])) {
    $packageName = $_POST['packageName'];
    $packageDetails = $_POST['packageDetails'];
    $price = $_POST['price'];
    $bookingPrice = $_POST['bookingPrice'];
    $photographyType = $_POST['photographyType'];

    // Handle file upload for the display image
    $displayImg = $photographer['DisplayImg']; // Default to existing image
    if ($_FILES['displayImg']['name']) {
        $targetDir = "uploads/photographer_images/";
        $targetFile = $targetDir . basename($_FILES["displayImg"]["name"]);
        if (move_uploaded_file($_FILES["displayImg"]["tmp_name"], $targetFile)) {
            $displayImg = $targetFile; // Update to the new image path
        } else {
            echo "Error uploading the image.";
        }
    }

    // Update the photographer details in the database
    $sql = "UPDATE tbl_Photographer_Details 
            SET PackageName = '$packageName', PackageDetails = '$packageDetails', 
                Price = '$price', BookingPrice = '$bookingPrice', 
                PhotographyID = '$photographyType', DisplayImg = '$displayImg' 
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
    <title>Edit Photographer</title>
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
        <h1>Edit Photographer</h1>
        <form method="POST" enctype="multipart/form-data">
            <label for="packageName">Package Name:</label>
            <input type="text" id="packageName" name="packageName" value="<?php echo htmlspecialchars($photographer['PackageName']); ?>" required>

            <label for="packageDetails">Package Details:</label>
            <textarea id="packageDetails" name="packageDetails" rows="4" required><?php echo htmlspecialchars($photographer['PackageDetails']); ?></textarea>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($photographer['Price']); ?>" required step="0.01">

            <label for="bookingPrice">Booking Price:</label>
            <input type="number" id="bookingPrice" name="bookingPrice" value="<?php echo htmlspecialchars($photographer['BookingPrice']); ?>" required step="0.01">

            <!-- Photography Type Dropdown -->
            <label for="photographyType">Photography Type:</label>
            <select id="photographyType" name="photographyType" required>
                <?php while ($row = $photographyTypes->fetch_assoc()) { ?>
                    <option value="<?php echo $row['ID']; ?>" <?php echo $row['ID'] == $photographer['PhotographyID'] ? 'selected' : ''; ?>>
                        <?php echo $row['PhotographyType']; ?>
                    </option>
                <?php } ?>
            </select>

            <!-- Display Image -->
            <label for="displayImg">Display Image:</label>
            <input type="file" id="displayImg" name="displayImg">
            <?php if ($photographer['DisplayImg']) { ?>
                <img src="<?php echo htmlspecialchars($photographer['DisplayImg']); ?>" alt="Photographer Image" width="200">
            <?php } ?>

            <input type="hidden" name="id" value="<?php echo htmlspecialchars($photographer['PhotographyID']); ?>">
            
            <button type="submit" name="update">Update</button>
        </form>
    </div>
</body>
</html>
