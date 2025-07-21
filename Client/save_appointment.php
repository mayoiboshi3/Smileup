<?php
$conn = new mysqli("localhost", "root", "882372", "your_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$gender = $_POST['gender'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$date = $_POST['date'];
$timeSlot = $_POST['time_slot'];

// Insert appointment
$stmt = $conn->prepare("INSERT INTO appointments (first_name, last_name, gender, phone, email, date, time_slot) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $firstName, $lastName, $gender, $phone, $email, $date, $timeSlot);

if ($stmt->execute()) {
    $stmt->close();
    // Update availability
    $stmt2 = $conn->prepare("UPDATE availability SET status = 2 WHERE date = ? AND time_slot = ?");
    $stmt2->bind_param("ss", $date, $timeSlot);
    if ($stmt2->execute()) {
        echo "Appointment booked";
    } else {
        echo "error in updating status " . $stmt2->error;
    }
    $stmt2->close();
} else {
    echo "Error booking appointment: " . $stmt->error;
    $stmt->close();
}


$conn->close();
?>
