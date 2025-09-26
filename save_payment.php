<?php
session_start();
include 'config.php';

$data = json_decode(file_get_contents("php://input"));

if (isset($data->bookingId) && isset($data->paymentId)) {
    $bookingId = $data->bookingId;
    $paymentId = $data->paymentId;

    // Save payment details in the database
    $sql = "UPDATE tbl_booking SET Status = 'confirmed', PaymentID = ? WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $paymentId, $bookingId);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['error' => 'Failed to save payment']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Invalid input']);
}

$conn->close();
?>
