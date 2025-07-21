<?php
header('Content-Type: application/json');

// Get POST data
$id = $_POST['id'] ?? null;
$status = $_POST['status'] ?? null;

// Debug information
error_log("Received update request for time slot ID: $id with status: $status");

if ($id === null || $status === null) {
    echo json_encode(['success' => false, 'error' => 'ID and status are required']);
    error_log("Error: ID or status missing in update request");
    exit;
}

// Validate status is within allowed range
if (!in_array((int)$status, [0, 1, 2, 3, 4, 5])) {
    echo json_encode(['success' => false, 'error' => 'Invalid status value. Must be 0-5']);
    error_log("Error: Invalid status value: $status");
    exit;
}

// Database connection details
$host = 'localhost';
$dbname = 'your_db';
$username = 'root';
$password = '882372';

// Create MySQLi connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit;
}

// Prepare and execute update
$stmt = $conn->prepare("UPDATE availability SET status = ? WHERE id = ?");
$stmt->bind_param("ii", $status, $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    error_log("Successfully updated time slot ID: $id to status: $status");
    echo json_encode(['success' => true]);
} else {
    error_log("No rows updated for ID: $id. Time slot may not exist.");
    echo json_encode(['success' => false, 'error' => 'No time slot found with ID: ' . $id]);
}

$stmt->close();
$conn->close();
?>
