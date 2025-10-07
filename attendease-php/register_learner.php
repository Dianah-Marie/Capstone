<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'db/connect.php';

// ✅ Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('You must be logged in to add a learner.'); window.location='login.php';</script>";
    exit;
}

$adminID = $_SESSION['user_id']; // 🧠 Logged-in Admin ID

// ✅ Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = trim($_POST['fname']);
    $mname = trim($_POST['mname']);
    $lname = trim($_POST['lname']);
    $lrn = trim($_POST['lrn']);
    $sex = trim($_POST['sex']);
    $sectionID = intval($_POST['sectionID']);

    // 🛑 Validate required fields
    if (empty($fname) || empty($lname) || empty($lrn) || empty($sex) || empty($sectionID)) {
        echo "<script>alert('All required fields must be filled!'); window.history.back();</script>";
        exit;
    }

    // 🔍 Check if LRN already exists
    $check = $conn->prepare("SELECT learnerID FROM learner WHERE LRN = ?");
    $check->bind_param("s", $lrn);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<script>alert('This LRN is already registered!'); window.history.back();</script>";
        exit;
    }
    $check->close();

    // ✅ Insert learner record
    $stmt = $conn->prepare("
        INSERT INTO learner (adminID, fname, mname, lname, LRN, sex, sectionID)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("isssssi", $adminID, $fname, $mname, $lname, $lrn, $sex, $sectionID);

    if ($stmt->execute()) {
        echo "<script>alert('Learner added successfully!'); window.location='learners.php';</script>";
    } else {
        echo "<script>alert('Error adding learner: " . addslashes($stmt->error) . "'); window.history.back();</script>";
    }

    $stmt->close();
}
?>