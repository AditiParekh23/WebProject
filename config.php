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
        $servername = "localhost";
        $username = "root";
        $password = "";
        $db = "project_eventify";

//create connection
        $conn = mysqli_connect($servername, $username, $password, $db);

//check connection

        if (!$conn) {
            die("connection failed :( " . mysqli_connect_error());
        }
        ?>
    </body>
</html>
