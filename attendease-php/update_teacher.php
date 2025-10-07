<?php
include 'db/connect.php'; // 🔹 make sure this connects to your database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userID = intval($_POST['user_ID']);
    $username = trim($_POST['username']);
    $fullName = trim($_POST['fullName']);
    $email = trim($_POST['email']);
    $accountType = trim($_POST['accountType']);

    // Split full name into parts
    $parts = explode(" ", $fullName);
    $first_name = $parts[0];
    $last_name = count($parts) > 1 ? array_pop($parts) : '';
    $middle_name = count($parts) > 2 ? implode(" ", array_slice($parts, 1, -1)) : '';

    $sql = "UPDATE user 
          SET firstName=?, middleName=?, lastName=?, username=?, email=?, accountType=? 
          WHERE user_ID=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $first_name, $middle_name, $last_name, $username, $email, $accountType, $userID);

    if ($stmt->execute()) {
        echo "Teacher updated successfully!";
    } else {
        echo "Error updating teacher: " . $conn->error;
    }
}
?>