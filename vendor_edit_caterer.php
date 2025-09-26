<?php
include 'config.php';

// Fetch the caterer data for the given ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT 
                c.Type AS MenuType,
                cd.MenuName,
                cd.MenuDetails,
                cd.Price,
                cd.BookingPrice,
                cd.DisplayImg,
                cd.CatererID
            FROM 
                tbl_Caterer_Details cd
            JOIN 
                tbl_Vendor v ON cd.VendorID = v.ID
            JOIN 
                tbl_Caterer c ON cd.CatererID = c.ID
            WHERE 
                cd.CatererID = $id"; 
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $caterer = $result->fetch_assoc();
    } else {
        // Redirect if the caterer ID is not found
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
    $menuName = $_POST['menuName'];
    $menuDetails = $_POST['menuDetails'];
    $price = $_POST['price'];
    $bookingPrice = $_POST['bookingPrice'];
    $type = $_POST['type'];

    // Handle file upload for the display image
    $displayImg = $caterer['DisplayImg']; // Default to existing image
    if ($_FILES['displayImg']['name']) {
        $targetDir = "uploads/caterer_images/";
        $targetFile = $targetDir . basename($_FILES["displayImg"]["name"]);
        if (move_uploaded_file($_FILES["displayImg"]["tmp_name"], $targetFile)) {
            $displayImg = $targetFile; // Update to the new image path
        }
    }

    // Update the caterer details in the database
    $sql = "UPDATE tbl_Caterer_Details 
            SET MenuName = '$menuName', MenuDetails = '$menuDetails', 
                Price = '$price', BookingPrice = '$bookingPrice', 
                DisplayImg = '$displayImg', CatererID = '$type' 
            WHERE CatererID = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Record updated successfully!'); window.location.href='service.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch caterer types for dropdown
$catererTypeQuery = "SELECT ID, Type FROM tbl_Caterer";
$catererTypes = $conn->query($catererTypeQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Caterer</title>
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
        <h1>Edit Caterer</h1>
        <form method="POST" enctype="multipart/form-data">
            <label for="menuName">Menu Name:</label>
            <input type="text" id="menuName" name="menuName" value="<?php echo htmlspecialchars($caterer['MenuName']); ?>" required>

            <label for="menuDetails">Menu Details:</label>
            <textarea id="menuDetails" name="menuDetails" rows="4" required><?php echo htmlspecialchars($caterer['MenuDetails']); ?></textarea>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($caterer['Price']); ?>" required step="0.01">

            <label for="bookingPrice">Booking Price:</label>
            <input type="number" id="bookingPrice" name="bookingPrice" value="<?php echo htmlspecialchars($caterer['BookingPrice']); ?>" required step="0.01">

            <!-- Caterer Type Dropdown -->
            <label for="type">Caterer Type:</label>
            <select id="type" name="type" required>
                <?php while ($row = $catererTypes->fetch_assoc()) { ?>
                    <option value="<?php echo $row['ID']; ?>" <?php echo $row['ID'] == $caterer['CatererID'] ? 'selected' : ''; ?>>
                        <?php echo $row['Type']; ?>
                    </option>
                <?php } ?>
            </select>

            <!-- Display Image -->
            <label for="displayImg">Display Image:</label>
            <input type="file" id="displayImg" name="displayImg">
            <?php if ($caterer['DisplayImg']) { ?>
                <img src="<?php echo $caterer['DisplayImg']; ?>" alt="Caterer Image" width="200">
            <?php } ?>

            <input type="hidden" name="id" value="<?php echo htmlspecialchars($caterer['CatererID']); ?>">
            
            <button type="submit" name="update">Update</button>
        </form>
    </div>
</body>
</html>
