<?php
//run when update timeslots is clicked
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['selected_date']) || !isset($data['time_slots'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required data']);
    error_log("Error: Missing required data in update_availability.php");
    exit;
}

$date = $data['selected_date'];
$timeSlots = $data['time_slots'];

$host = 'localhost';
$dbname = 'your_db';
$username = 'root';
$password = '882372';

$conn = new mysqli($host, $username, $password, $dbname);


if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}


$conn->begin_transaction();

try {
    foreach ($timeSlots as $slot) {
        error_log("Processing slot: " . json_encode($slot));
        
        if (isset($slot['id']) && $slot['id']) {

            $stmt = $conn->prepare("UPDATE availability SET status = ? WHERE id = ?");
            $stmt->bind_param("ii", $slot['status'], $slot['id']);
            $stmt->execute();
            $stmt->close();
            error_log("Updated existing slot ID: {$slot['id']} to status: {$slot['status']}");
        } else {

            $stmt = $conn->prepare("INSERT INTO availability (date, time_slot, status) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $date, $slot['time_slot'], $slot['status']);
            $stmt->execute();
            $newId = $stmt->insert_id;
            $stmt->close();
            error_log("Created new slot with ID: $newId for time: {$slot['time_slot']} with status: {$slot['status']}");
        }
    }

    $conn->commit();
    echo json_encode(['success' => true]);
    error_log("Successfully updated all time slots for date: $date");

} catch (Exception $e) {
    $conn->rollback();
    error_log("Database error in update_availability.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}

$conn->close();
?>
