<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // put your code here
        include 'dbconn.php'; // Include your database connection file
// SQL query to count total users
        $sql = "SELECT COUNT(*) AS total_users FROM tbl_user";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $total_users = intval($row['total_users']); // Convert to integer
        } else {
            $total_users = 0; // In case of an error, set to 0
        }

        mysqli_close($conn); // Close the connection
        ?>
    </body>
</html>
