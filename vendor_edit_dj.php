<?php
include 'config.php';

// Fetch the DJ data for the given ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT 
                d.ID AS DJID,  
                d.Type AS DJType, 
                dd.EquipmentDetails,
                dd.Price,
                dd.BookingPrice,
                dd.DisplayImg 
            FROM 
                tbl_DJ_Details dd 
            JOIN 
                tbl_Vendor v ON dd.VendorID = v.ID 
            JOIN 
                tbl_DJ d ON dd.DJID = d.ID 
            WHERE 
                dd.ID = $id"; 
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $dj = $result->fetch_assoc();
    } else {
        // Redirect if the DJ ID is not found
        header('Location: index.php');
        exit;
    }
} else {
    // Redirect if no ID is provided
    header('Location: index.php');
    exit;
}

// Handle form submission
if (isset($_POST['update'])) {
    $djType = $_POST['djType'];
    $equipmentDetails = $_POST['equipmentDetails'];
    $price = $_POST['price'];
    $bookingPrice = $_POST['bookingPrice'];

    // Handle file upload for the display image
    $displayImg = $dj['DisplayImg']; // Default to existing image
    if ($_FILES['displayImg']['name']) {
        $targetDir = "uploads/dj_images/";
        $targetFile = $targetDir . basename($_FILES["displayImg"]["name"]);
        if (move_uploaded_file($_FILES["displayImg"]["tmp_name"], $targetFile)) {
            $displayImg = $targetFile; // Update to the new image path
        }
    }

    // Update the DJ details in the database
    $sql = "UPDATE tbl_DJ_Details 
            SET DJID = '$djType', EquipmentDetails = '$equipmentDetails', 
                Price = '$price', BookingPrice = '$bookingPrice', 
                DisplayImg = '$displayImg' 
            WHERE ID = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Record updated successfully!'); window.location.href='service.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch DJ types for dropdown
$djTypeQuery = "SELECT ID, Type FROM tbl_DJ"; // Adjust as per your table
$djTypes = $conn->query($djTypeQuery);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit DJ</title>
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
        <h1>Edit DJ</h1>
        <form method="POST" enctype="multipart/form-data">
            <label for="djType">DJ Type:</label>
            <select id="djType" name="djType" required>
                <?php while ($row = $djTypes->fetch_assoc()) { ?>
                    <option value="<?php echo $row['ID']; ?>" <?php echo $row['ID'] == $dj['DJID'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($row['Type']); ?>
                    </option>
                <?php } ?>
            </select>

            <label for="equipmentDetails">Equipment Details:</label>
            <textarea id="equipmentDetails" name="equipmentDetails" rows="4" required><?php echo htmlspecialchars($dj['EquipmentDetails']); ?></textarea>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($dj['Price']); ?>" required step="0.01">

            <label for="bookingPrice">Booking Price:</label>
            <input type="number" id="bookingPrice" name="bookingPrice" value="<?php echo htmlspecialchars($dj['BookingPrice']); ?>" required step="0.01">

            <label for="displayImg">Display Image:</label>
            <input type="file" id="displayImg" name="displayImg">
            <?php if ($dj['DisplayImg']) { ?>
                <img src="<?php echo $dj['DisplayImg']; ?>" alt="DJ Image" width="200">
            <?php } ?>

            <input type="hidden" name="id" value="<?php echo htmlspecialchars($dj['DJID']); ?>">
            
            <button type="submit" name="update">Update</button>
        </form>
    </div>
</body>
</html>
