<?php
//takes the available time slots from the database for the appointment

$conn = new mysqli("localhost", "root", "882372", "your_db");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$date = $_GET['date'];

$sql = "SELECT time_slot FROM availability WHERE date = ? AND status = 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $date);
$stmt->execute();
$result = $stmt->get_result();

$available_slots = [];
while ($row = $result->fetch_assoc()) {
  $available_slots[] = $row['time_slot'];
}
$stmt->close();

$sql = "SELECT time_slot FROM appointments WHERE date = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $date);
$stmt->execute();
$result = $stmt->get_result();

$booked_slots = [];
while ($row = $result->fetch_assoc()) {
  $booked_slots[] = $row['time_slot'];
}
$stmt->close();
$conn->close();

$final_slots = array_values(array_diff($available_slots, $booked_slots));
echo json_encode($final_slots);
?>
