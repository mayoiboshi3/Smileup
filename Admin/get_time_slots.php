<?php
header('Content-Type: application/json');

// Get date parameter
$date = $_GET['date'] ?? null;

if (!$date) {
    echo json_encode(['error' => 'Date parameter is required']);
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
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

// Prepare and execute query
$sql = "SELECT id, date, time_slot, status FROM availability WHERE date = ? ORDER BY time_slot";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(['error' => 'Prepare failed: ' . $conn->error]);
    $conn->close();
    exit;
}

$stmt->bind_param("s", $date);
$stmt->execute();
$result = $stmt->get_result();

// Fetch results
$time_slots = [];
while ($row = $result->fetch_assoc()) {
    $time_slots[] = $row;
}

// Output as JSON
echo json_encode(['time_slots' => $time_slots]);

// Close connections
$stmt->close();
$conn->close();
?>
