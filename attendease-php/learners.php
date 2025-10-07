<?php
// ✅ Start session
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// ✅ Database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "attendease";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// =========================
// 🗑️ DELETE LEARNER
// =========================
if (isset($_POST['action']) && $_POST['action'] === 'delete') {
  $learnerID = intval($_POST['learnerID']);
  $stmt = $conn->prepare("DELETE FROM learner WHERE learnerID = ?");
  $stmt->bind_param("i", $learnerID);
  echo $stmt->execute() ? "success" : "error";
  exit;
}

// =========================
// ✏️ EDIT LEARNER
// =========================
if (isset($_POST['action']) && $_POST['action'] === 'edit') {
  $learnerID = intval($_POST['learnerID']);
  $fname = $_POST['fname'];
  $mname = $_POST['mname'];
  $lname = $_POST['lname'];
  $lrn = $_POST['lrn'];
  $sex = $_POST['sex'];
  $sectionID = intval($_POST['sectionID']);

  $stmt = $conn->prepare("UPDATE learner SET fname=?, mname=?, lname=?, LRN=?, sex=?, sectionID=? WHERE learnerID=?");
  $stmt->bind_param("ssssssi", $fname, $mname, $lname, $lrn, $sex, $sectionID, $learnerID);

  echo $stmt->execute() ? "success" : "error";
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <link rel="icon" href="images/icon.png" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Learners | AttendEase</title>
  <link rel="stylesheet" href="css/style.css" />
</head>

<body>
  <div class="container">
    <?php include_once 'includes/sidebar.php'; ?>
    <?php include_once 'includes/header.php'; ?>

    <main class="main-content">
      <div class="page-header">
        <h1><i class="fas fa-user-graduate"></i> LEARNERS</h1>
      </div>

      <!-- Search + Filter -->
      <div class="search-filter">
        <div class="filter-container">
          <button class="filter-btn" id="filterToggle">
            <i class="fas fa-filter"></i> Filter
          </button>
          <div class="filter-panel" id="filterPanel">
            <h3>Filter Options</h3>
            <div class="filter-group">
              <strong>Sort by Last Name:</strong>
              <label><input type="radio" name="lastname" value="az" /> A–Z</label>
              <label><input type="radio" name="lastname" value="za" /> Z–A</label>
            </div>
            <div class="filter-group">
              <strong>Sex:</strong>
              <label><input type="checkbox" name="sex" value="male" /> Male</label>
              <label><input type="checkbox" name="sex" value="female" /> Female</label>
            </div>
            <div class="filter-actions">
              <button class="btn-clear" id="clearFilters"><i class="fas fa-times"></i> Clear</button>
              <button class="btn-apply" id="applyFilters"><i class="fas fa-check"></i> Apply</button>
            </div>
          </div>
        </div>

        <div class="search-wrapper">
          <i class="fas fa-search"></i>
          <input type="text" class="search-bar" placeholder="Search here..." />
        </div>

        <button class="register-button" id="openRegisterModal">
          <i class="fas fa-user-plus"></i> Register Learner
        </button>
      </div>

      <!-- 🧾 Learner Table -->
      <div class="table-container">
        <table class="styled-table">
          <thead>
            <tr>
              <th>Learner</th>
              <th>LRN</th>
              <th>Sex</th>
              <th>Grade & Section</th>
              <th>Adviser</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="learnerTable">
            <?php
            $sql = "SELECT 
                      learner.learnerID,
                      learner.fname, learner.mname, learner.lname, learner.LRN, learner.sex, 
                      section.sectionID, section.sectionName,
                      user.firstName AS adviserFirst, user.lastName AS adviserLast
                    FROM learner
                    LEFT JOIN section ON learner.sectionID = section.sectionID
                    LEFT JOIN teachers ON section.teacherID = teachers.teacherID
                    LEFT JOIN user ON teachers.userID = user.user_ID
                    ORDER BY learner.lname ASC";

            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo "
                <tr 
                  data-id='{$row['learnerID']}'
                  data-fname='{$row['fname']}'
                  data-mname='{$row['mname']}'
                  data-lname='{$row['lname']}'
                  data-lrn='{$row['LRN']}'
                  data-sex='{$row['sex']}'
                  data-section='{$row['sectionID']}'
                >
                  <td>" . htmlspecialchars($row['fname']) . " " . htmlspecialchars($row['lname']) . "</td>
                  <td>" . htmlspecialchars($row['LRN']) . "</td>
                  <td>" . htmlspecialchars($row['sex']) . "</td>
                  <td>" . htmlspecialchars($row['sectionName']) . "</td>
                  <td>" . htmlspecialchars($row['adviserFirst']) . " " . htmlspecialchars($row['adviserLast']) . "</td>
                  <td class='action-buttons'>
                    <button class='edit-btn' onclick='openEditModal(this)'><i class='fas fa-edit'></i></button>
                    <button class='delete-btn' onclick='openDeleteModal(this)'><i class='fas fa-trash'></i></button>
                  </td>
                </tr>";
              }
            } else {
              echo "<tr><td colspan='6' style='text-align:center;'>No learners found</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>

  <!-- 🟢 Add Learner Modal (Fixed Layout like Teacher Modal) -->
  <div id="registerModal" class="add-modal">
    <div class="add-modal-content">
      <span class="close" onclick="closeModal()">&times;</span>
      <h2>Register Learner</h2>
      <form id="registerLearnerForm" method="POST" action="register_learner.php">
        <label for="fname">First Name:</label>
        <input type="text" id="fname" name="fname" required>

        <label for="mname">Middle Name:</label>
        <input type="text" id="mname" name="mname">

        <label for="lname">Last Name:</label>
        <input type="text" id="lname" name="lname" required>

        <label for="lrn">LRN:</label>
        <input type="text" id="lrn" name="lrn" required>

        <label for="sex">Sex:</label>
        <select id="sex" name="sex" required>
          <option value="">Select</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
        </select>

        <label for="sectionID">Section:</label>
        <select id="sectionID" name="sectionID" required>
          <?php
          $sectionQuery = "SELECT sectionID, sectionName FROM section";
          $sectionResult = $conn->query($sectionQuery);
          while ($sec = $sectionResult->fetch_assoc()) {
            echo "<option value='{$sec['sectionID']}'>{$sec['sectionName']}</option>";
          }
          ?>
        </select>

        <button type="submit" class="submit-btn">
          <i class="fas fa-save"></i> Save Learner
        </button>
      </form>
    </div>
  </div>


  <!-- ✏️ Edit Learner Modal -->
  <div id="editModal" class="edit-modal">
    <div class="edit-modal-content">
      <span class="close" onclick="closeEditModal()">&times;</span>
      <h2>Edit Learner</h2>
      <form id="editForm">
        <input type="hidden" id="editLearnerID" name="learnerID">

        <label>First Name:</label>
        <input type="text" id="editFname" name="fname" required>

        <label>Middle Name:</label>
        <input type="text" id="editMname" name="mname">

        <label>Last Name:</label>
        <input type="text" id="editLname" name="lname" required>

        <label>LRN:</label>
        <input type="text" id="editLRN" name="lrn" required>

        <label>Sex:</label>
        <select id="editSex" name="sex" required>
          <option value="">Select</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
        </select>

        <label>Section:</label>
        <select id="editSection" name="sectionID" required>
          <?php
          $sectionQuery = "SELECT sectionID, sectionName FROM section";
          $sectionResult = $conn->query($sectionQuery);
          while ($sec = $sectionResult->fetch_assoc()) {
            echo "<option value='{$sec['sectionID']}'>{$sec['sectionName']}</option>";
          }
          ?>
        </select>

        <button type="button" onclick="saveEditedLearner()">Save Changes</button>
      </form>
    </div>
  </div>

  <!-- 🔴 Delete Modal -->
  <div id="deleteLearnerModal" class="delete-modal">
    <div class="delete-modal-content">
      <i class="fas fa-trash modal-icon"></i>
      <h3>Are you sure you want to delete this learner?</h3>
      <div class="modal-actions">
        <button class="btn cancel" type="button" onclick="closeDeleteModal()">Cancel</button>
        <button class="btn confirm" type="button" onclick="confirmDelete()">Delete</button>
      </div>
    </div>
  </div>

  <script src="js/learners.js" defer></script>
</body>

</html>