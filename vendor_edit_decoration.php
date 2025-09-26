<?php
include 'config.php';

// Fetch the decoration data for the given ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT dd.*, d.DecorationType FROM tbl_Decoration_Details dd 
            JOIN tbl_Decoration d ON dd.DecorationID = d.ID 
            WHERE dd.ID = $id"; 
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $decoration = $result->fetch_assoc();
    } else {
        // Redirect if the decoration ID is not found
        header('Location: index.php');
        exit;
    }
} else {
    // Redirect if no ID is provided
    header('Location: index.php');
    exit;
}

// Fetch decoration types for dropdown
$decorationTypeQuery = "SELECT ID, DecorationType FROM tbl_Decoration";
$decorationTypes = $conn->query($decorationTypeQuery);

// Handle form submission
if (isset($_POST['update'])) {
    $description = $_POST['description'];
    $price = $_POST['price'];
    $bookingPrice = $_POST['bookingPrice'];
    $decorationType = $_POST['decorationType'];

    // Handle file upload for the display image
    $displayImg = $decoration['DisplayImg']; // Default to existing image
    if ($_FILES['displayImg']['name']) {
        $targetDir = "uploads/decoration_images/";
        $targetFile = $targetDir . basename($_FILES["displayImg"]["name"]);
        if (move_uploaded_file($_FILES["displayImg"]["tmp_name"], $targetFile)) {
            $displayImg = $targetFile; // Update to the new image path
        }
    }

    // Update the decoration details in the database
    $sql = "UPDATE tbl_Decoration_Details 
            SET Description = '$description', Price = '$price', 
                BookingPrice = '$bookingPrice', DecorationID = '$decorationType', 
                DisplayImg = '$displayImg' 
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
    <title>Edit Decoration</title>
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
        <h1>Edit Decoration</h1>
        <form method="POST" enctype="multipart/form-data">
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($decoration['Description']); ?></textarea>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($decoration['Price']); ?>" required step="0.01">

            <label for="bookingPrice">Booking Price:</label>
            <input type="number" id="bookingPrice" name="bookingPrice" value="<?php echo htmlspecialchars($decoration['BookingPrice']); ?>" required step="0.01">

            <!-- Decoration Type Dropdown -->
            <label for="decorationType">Decoration Type:</label>
            <select id="decorationType" name="decorationType" required>
                <?php while ($row = $decorationTypes->fetch_assoc()) { ?>
                    <option value="<?php echo $row['ID']; ?>" <?php echo $row['ID'] == $decoration['DecorationID'] ? 'selected' : ''; ?>>
                        <?php echo $row['DecorationType']; ?>
                    </option>
                <?php } ?>
            </select>

            <!-- Display Image -->
            <label for="displayImg">Display Image:</label>
            <input type="file" id="displayImg" name="displayImg">
            <?php if ($decoration['DisplayImg']) { ?>
                <img src="<?php echo $decoration['DisplayImg']; ?>" alt="Decoration Image" width="200">
            <?php } ?>

            <input type="hidden" name="id" value="<?php echo htmlspecialchars($decoration['ID']); ?>">
            
            <button type="submit" name="update">Update</button>
        </form>
    </div>
</body>
</html>
