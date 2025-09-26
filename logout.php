<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Logout</title>
    <script>
        alert("You have been successfully logged out.");
        window.location.href = "index.php";
    </script>
</head>
<body>
</body>
</html>
