<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'db/connect.php';

// 🧠 Retrieve form data safely
$subject = trim($_POST['subject']);
$sectionID = intval($_POST['sectionID']);
$room = trim($_POST['roomAssignment']);
$teacherID = intval($_POST['teacherID']);
$day = trim($_POST['day']);
$startTime = $_POST['startTime'];
$endTime = $_POST['endTime'];
$schoolYear = trim($_POST['schoolYear']);

// ✅ Basic validation
if (
    empty($subject) || empty($sectionID) || empty($room) || empty($teacherID) ||
    empty($day) || empty($startTime) || empty($endTime) || empty($schoolYear)
) {
    echo "<script>alert('Please fill in all required fields.'); window.location='schedule.php';</script>";
    exit;
}

// ⚠️ Optional: check overlapping schedule for same section/day
$checkOverlap = $conn->prepare("
    SELECT COUNT(*) AS count FROM schedule 
    WHERE sectionID = ? AND day = ? 
      AND (
        (startTime < ? AND endTime > ?) OR
        (startTime >= ? AND startTime < ?)
      )
");
$checkOverlap->bind_param("isssss", $sectionID, $day, $endTime, $startTime, $startTime, $endTime);
$checkOverlap->execute();
$res = $checkOverlap->get_result()->fetch_assoc();

if ($res['count'] > 0) {
    echo "<script>alert('This section already has a schedule overlapping that time.'); window.location='schedule.php';</script>";
    exit;
}

// 💾 Insert new schedule
$stmt = $conn->prepare("INSERT INTO schedule (subject, sectionID, roomAssignment, teacherID, day, startTime, endTime, schoolYear)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sissssss", $subject, $sectionID, $room, $teacherID, $day, $startTime, $endTime, $schoolYear);

if ($stmt->execute()) {
    echo "<script>alert('Schedule added successfully!'); window.location='schedule.php';</script>";
} else {
    echo "<script>alert('Error adding schedule: " . addslashes($stmt->error) . "'); window.location='schedule.php';</script>";
}
?>