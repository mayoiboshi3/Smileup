<?php
//weekly data

$conn = new mysqli("localhost", "root", "882372", "your_db");

if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

$dates = isset($_POST['dates']) ? json_decode($_POST['dates'], true) : [];

if (empty($dates)) {
    die(json_encode(['error' => 'No dates provided']));
}

$response = [];
function getBusinessHours() {
    $businessHours = [];
    for ($hour = 9; $hour < 17; $hour++) {
        $nextHour = $hour + 1;
        $businessHours[] = [
            'time_slot' => sprintf("%02d:00-%02d:00", $hour, $nextHour),
            'display_time' => formatTimeSlot(sprintf("%02d:00-%02d:00", $hour, $nextHour))
        ];
    }
    return $businessHours;
}

function formatTimeSlot($timeSlot) {
    if (strpos($timeSlot, '-') !== false) {
        list($start, $end) = explode('-', $timeSlot);
        return formatTime($start) . ' - ' . formatTime($end);
    }
    return formatTime($timeSlot);
}

function formatTime($time) {
    list($hour, $minute) = explode(':', $time);
    $hour = (int)$hour;
    $ampm = ($hour >= 12) ? 'PM' : 'AM';
    $hour = ($hour > 12) ? $hour - 12 : $hour;
    $hour = ($hour == 0) ? 12 : $hour;
    return $hour . ':' . $minute . $ampm;
}

foreach ($dates as $date) {
    $stmt = $conn->prepare("
        SELECT a.id, a.first_name, a.last_name, a.gender, a.phone, a.email, a.time_slot, a.date, a.created_at 
        FROM appointments a
        INNER JOIN availability av ON a.date = av.date AND a.time_slot = av.time_slot
        WHERE a.date = ? AND av.status = 2
    ");
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $appointments = [];
    $bookedTimeSlots = [];
    
    while ($row = $result->fetch_assoc()) {
        $row['display_time'] = formatTimeSlot($row['time_slot']);
        $appointments[] = $row;
        $bookedTimeSlots[] = $row['time_slot'];
    }
    
    $allTimeSlots = getBusinessHours();
    
    $emptySlots = array_filter($allTimeSlots, function($slot) use ($bookedTimeSlots) {
        return !in_array($slot['time_slot'], $bookedTimeSlots);
    });
    
    $response[$date] = [
        'date' => $date,
        'appointments' => $appointments,
        'emptySlots' => array_values($emptySlots)
    ];
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($response);