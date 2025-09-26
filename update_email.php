<?php
session_start();
error_reporting(0);
include_once('./config.php'); // Database connection

if (isset($_POST['update_email'])) {
    $oldEmail = $_SESSION['email']; // Current email stored in session after login
    $newEmail = $_POST['new_email'];

    $error_message = '';

    // Validate the new email
    if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        $error_message .= "Invalid email format.<br>";
    }

    // Check if the new email already exists in the database using a prepared statement
    $emailCheckSql = "SELECT * FROM tbl_user WHERE EmailID = ?";
    $stmt = $conn->prepare($emailCheckSql);
    $stmt->bind_param('s', $newEmail);
    $stmt->execute();
    $emailCheckResult = $stmt->get_result();

    if ($emailCheckResult->num_rows > 0) {
        $error_message .= "This email is already in use.<br>";
    }
    
    // Close the statement after use
    $stmt->close();

    // If no error, update the email
    if (empty($error_message)) {
        // SQL query to update the email using a prepared statement
        $updateSql = "UPDATE tbl_user SET EmailID = ? WHERE EmailID = ?";
        $stmtUpdate = $conn->prepare($updateSql);
        $stmtUpdate->bind_param('ss', $newEmail, $oldEmail);

        if ($stmtUpdate->execute()) {
            // Update session email
            $_SESSION['email'] = $newEmail;
            echo "<script>alert('Email Update Successful!');
            window.location.replace('./login.php');</script>";
        } else {
            echo "<script>alert('Email Update Failed! Please try again.');
            window.location.replace('./changeEmail.php');</script>";
        }

        // Close the update statement
        $stmtUpdate->close();
    } else {
        echo "<script>alert('" . nl2br($error_message) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventify | Change Email</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 50px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .boxed_btn3 {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            text-align: center;
            display: inline-block;
        }

        .boxed_btn3:hover {
            background-color: #0056b3;
        }

        .form-control {
            border-radius: 0;
        }

        .form-heading {
            margin-bottom: 20px;
        }

        .btn-cancel {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Change Email</h3>
                    </div>
                    <div class="card-body">
                        <form action="#" method="POST">
                            <div class="form-group">
                                <label for="new_email">New Email</label>
                                <input type="email" id="new_email" class="form-control" name="new_email" placeholder="Enter New Email" required>
                            </div>
                            <button type="submit" class="boxed_btn3" name="update_email">Update Email</button>
                        </form>
                        <a href="setting.php" class="btn btn-secondary btn-cancel">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

