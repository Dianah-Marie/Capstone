<?php
session_start();
require_once 'db/connect.php';

// ✅ check login
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$userID = $_SESSION['user_id'];

// ✅ get user info
$userQuery = $conn->query("SELECT * FROM user WHERE user_ID = '$userID'");
$user = $userQuery->fetch_assoc();

$username = $user['username'];
$email = $user['email'];
$role = $user['accountType'];
$firstName = ucfirst($user['firstName']);
$lastName = ucfirst($user['lastName']);

// ✅ get teacher details if role is teacher/adviser
$subjects = [];
$advisory = "N/A";

if ($role === 'teacher' || $role === 'adviser') {
  $tQuery = $conn->query("SELECT * FROM teacher WHERE user_ID = '$userID'");
  if ($tQuery && $tQuery->num_rows > 0) {
    $teacher = $tQuery->fetch_assoc();
    $teacherID = $teacher['teacher_ID'];

    // fetch subjects taught
    $subjQuery = $conn->query("SELECT DISTINCT subject FROM schedule WHERE teacherID = '$teacherID'");
    while ($row = $subjQuery->fetch_assoc()) {
      $subjects[] = $row['subject'];
    }

    // fetch advisory class (first section assigned)
    $secQuery = $conn->query("SELECT sectionName, gradeLevel FROM section WHERE teacherID = '$teacherID' LIMIT 1");
    if ($secQuery && $secQuery->num_rows > 0) {
      $sec = $secQuery->fetch_assoc();
      $advisory = "Grade " . $sec['gradeLevel'] . " - " . $sec['sectionName'];
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <link rel="icon" href="images/icon.png" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Teacher Profile | AttendEase</title>

  <!-- 🎨 Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bebas+Neue&display=swap" />

  <!-- Main CSS -->
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/profile.css" />
  <link rel="stylesheet" href="css/notification.css" />
  <link rel="stylesheet" href="css/table.css" />
  <link rel="stylesheet" href="css/confirmation.css" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <div class="container">
    <?php
    include_once 'includes/sidebar.php';
    include_once 'includes/header.php';
    ?>

    <!-- Main Content -->
    <main class="main-content">
      <div class="profile-card">
        <!-- Banner -->
        <div class="profile-banner">
          <img src="images/gate.jpg" alt="School Banner" />
        </div>

        <!-- Avatar + Name + Role -->
        <div class="profile-header">
          <img src="images/profile.jpg" alt="Profile Picture" class="profile-avatar" />
          <div class="profile-info">
            <span class="teacher-name"><?= htmlspecialchars($firstName . " " . $lastName) ?></span> <br>
            <span class="teacher-role"><?= htmlspecialchars($role) ?></span>
          </div>
          <button class="btn-edit" id="openEditModal">
            <i class="fas fa-pen"></i> Edit Profile
          </button>
        </div>


        <!-- Details Section -->
        <div class="profile-details">
          <div class="detail-item">
            <i class="fas fa-envelope"></i>
            <div>
              <strong>Email:</strong>
              <p><?= htmlspecialchars($email) ?></p>
            </div>
          </div>

          <div class="detail-item">
            <i class="fas fa-book"></i>
            <div>
              <strong>Subjects:</strong>
              <p><?= !empty($subjects) ? implode(", ", $subjects) : "No subjects assigned" ?></p>
            </div>
          </div>

          <div class="detail-item">
            <i class="fas fa-users"></i>
            <div>
              <strong>Advisory Class:</strong>
              <p><?= $advisory ?></p>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <div class="edit-modal" id="editModal">
    <div class="edit-modal-content">
      <span class="close" id="closeEditModal">&times;</span>
      <h2>Edit Profile</h2>

      <form id="editForm">
        <!-- Profile Picture Upload -->
        <div class="avatar-upload">
          <label for="avatarUpload" class="avatar-label">
            <div class="avatar-circle">
              <i class="fas fa-camera"></i>
              <span>Upload Photo</span>
            </div>
          </label>
          <input type="file" id="avatarUpload" accept="image/*" hidden>
        </div>

        <!-- Password Fields -->
        <div class="form-group">
          <label for="oldPassword">Old Password:</label>
          <input type="password" id="oldPassword" name="oldPassword" required>
        </div>

        <div class="form-group">
          <label for="newPassword">New Password:</label>
          <input type="password" id="newPassword" name="newPassword" required>
        </div>

        <div class="form-group">
          <label for="confirmPassword">Confirm Password:</label>
          <input type="password" id="confirmPassword" name="confirmPassword" required>
        </div>

        <!-- Save Button -->
        <button type="submit" class="btn-save">
          <i class="fas fa-save"></i> Save Changes
        </button>
      </form>
    </div>
  </div>



  <script src="js/script.js" defer></script>
  <script src="js/profile.js" defer></script>
</body>

</html>