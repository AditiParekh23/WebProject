<?php
include 'config.php';

$id = $_GET['id'];
$sql = "DELETE FROM tbl_venue_detail WHERE id=$id";
if ($conn->query($sql) === TRUE) {
    header('Location: service.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>