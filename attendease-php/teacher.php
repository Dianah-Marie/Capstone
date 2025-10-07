<?php
$pageTitle = "Teacher Management | AttendEase";

// ✅ Step 1: Start session before any HTML
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'attendease';

$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $fullName = trim($_POST['fullName']);
  $parts = explode(" ", $fullName);

  $first_name = $parts[0]; // always first word
  $last_name = count($parts) > 1 ? array_pop($parts) : ''; // last word
  $middle_name = count($parts) > 2 ? implode(" ", array_slice($parts, 1, -1)) : '';

  $username = trim($_POST['username']);
  $email = trim($_POST['email']);
  $role = trim($_POST['accountType']);

  $password = trim($_POST['password']);
  $confirm_password = trim($_POST['confirm_password']);

  // Validate input
  if (empty($fullName) || empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
    $error = "All fields are required!";
  } elseif ($password !== $confirm_password) {
    $error = "Passwords do not match!";
  } else {
    // Check if username already exists
    $check = $conn->prepare("SELECT user_id FROM user WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
      $error = "Username already exists!";
    } else {
      // Hash the password
      $hashed_password = password_hash($password, PASSWORD_BCRYPT);
      $stmt = $conn->prepare(
        "INSERT INTO user (firstName, middleName, lastName, username, email, password, accountType) 
        VALUES (?, ?, ?, ?, ?, ?, ?)"
      );
      $stmt->bind_param("sssssss", $first_name, $middle_name, $last_name, $username, $email, $hashed_password, $role);

      if ($stmt->execute()) {
        $success = "Account created successfully!";
      } else {
        $error = "Error: " . $stmt->error;
      }
    }
  }
}
// delete teacher
if (isset($_GET['user_ID']) && !empty($_GET['user_ID'])) {
  $userID = intval($_GET['user_ID']);

  $stmt = $conn->prepare("DELETE FROM user WHERE user_ID = ?");
  $stmt->bind_param("i", $userID);
  if ($stmt->execute()) {
    echo "<script>alert('Teacher deleted successfully'); window.location='teacher.php';</script>";
    exit;
  } else {
    echo "Error deleting teacher: " . $conn->error;
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <link rel="icon" href="img/icon.png" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo $pageTitle; ?></title>


</head>

<body>
  <!-- Sidebar Include -->
  <?php include 'includes/sidebar.php'; ?>

  <!-- Header Include -->
  <?php include 'includes/header.php'; ?>


  <!-- Main Content -->
  <main class="main-content">
    <div class="page-header">
      <h1>TEACHER MANAGEMENT</h1>
    </div>

    <!-- Filter + Search (inline) -->
    <div class="search-filter">
      <!-- Filter Container -->
      <div class="filter-container">
        <button class="filter-btn" id="filterToggle">
          <i class="fas fa-filter"></i> Filter
        </button>

        <!-- Filter Panel -->
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
            <label><input type="checkbox" name="sex" value="female" />
              Female</label>
          </div>

          <div class="filter-group">
            <strong>Grade Level:</strong>
            <label><input type="checkbox" value="7" /> Grade 7</label>
            <label><input type="checkbox" value="8" /> Grade 8</label>
            <label><input type="checkbox" value="9" /> Grade 9</label>
            <label><input type="checkbox" value="10" /> Grade 10</label>
          </div>

          <div class="filter-actions">
            <button class="btn-clear" id="clearFilters">
              <i class="fas fa-times"></i> Clear
            </button>
            <button class="btn-apply" id="applyFilters">
              <i class="fas fa-check"></i> Apply
            </button>
          </div>
        </div>
      </div>

      <!-- Search Wrapper -->
      <div class="search-wrapper">
        <i class="fas fa-search"></i>
        <input type="text" class="search-bar" placeholder="Search here..." />
      </div>

      <div class="updown">
        <span class="material-symbols-outlined">swap_vert</span>
      </div>

      <button class="register-button" onclick="openModal()">
        <i class="fas fa-user-plus"></i> Register Teacher
      </button>
    </div>




    <div class="table-container">
      <table class="styled-table">
        <thead>
          <tr>
            <th>Username</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Account Type</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sqlt = "SELECT * FROM user WHERE accountType = 'Teacher' ORDER BY user_id DESC";
          $result = $conn->query($sqlt);

          if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($row['username']) . "</td>";
              echo "<td>" . htmlspecialchars($row['firstName']) . "</td>";
              echo "<td>" . htmlspecialchars($row['email']) . "</td>";
              echo "<td>" . htmlspecialchars($row['accountType']) . "</td>";
              echo "<td class='action-buttons'>
                      <button class='edit-btn' onclick='teacherEditModal(this)' data-id='" . $row['user_ID'] . "'>
                        <i class='fas fa-edit'></i>
                      </button>
                      <button class='delete-btn' onclick='teacherDeleteModal(" . $row['user_ID'] . ")'>
                        <i class='fas fa-trash'></i>
                      </button>
                    </td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='5'>No teachers found</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </main>

  <!-- Add Teacher Modal -->
  <div id="addTeacherModal" class="add-modal">
    <div class="add-modal-content">
      <span class="close" onclick="closeModal()">&times;</span>
      <h2>Add New Teacher</h2>
      <form id="addForm" method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="fullName">Full Name:</label>
        <input type="text" id="fullName" name="fullName" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="accountType">Account Type:</label>
        <select id="accountType" name="accountType">
          <option value="Teacher">Teacher</option>
          <option value="Admin">Admin</option>
        </select>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <button type="submit" class="submit-btn">
          <i class="fas fa-plus"></i> Add Teacher
        </button>
      </form>
    </div>
  </div>

  <!-- Edit Modal -->
  <div id="editModal" class="edit-modal">
    <div class="edit-modal-content">
      <span class="close" onclick="closeEditModal()">&times;</span>
      <h2>Edit Teacher</h2>
      <form id="editForm">
        <input type="hidden" id="editUserID">
        <label>Username</label>
        <input type="text" id="editUsername">
        <label>Full Name</label>
        <input type="text" id="editFullName">
        <label>Email</label>
        <input type="email" id="editEmail">
        <label>Account Type</label>
        <select id="editAccountType">
          <option value="Teacher">Teacher</option>
          <option value="Admin">Admin</option>
        </select>
        <button type="button" onclick="saveEdit()">Save Changes</button>
      </form>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div id="deleteModal" class="delete-modal">
    <div class="delete-modal-content">
      <i class="fas fa-trash modal-icon"></i>
      <h3>Are you sure you want to delete this Teacher?</h3>
      <div class="modal-actions">
        <button class="btn cancel" onclick="closeDeleteModal()">Cancel</button>
        <button class="btn confirm" onclick="confirmDelete()">Delete</button>
      </div>
    </div>
  </div>


  <script src="js/teacher.js" defer></script>



</body>

</html>