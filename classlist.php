<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <link rel="icon" href="images/icon.png" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Class List | AttendEase</title>

  <!-- 🎨 Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bebas+Neue&display=swap" />

  <!-- Main CSS -->
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/notification.css" />
  <link rel="stylesheet" href="css/table.css" />
  <link rel="stylesheet" href="css/confirmation.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</head>

<body>
  <div class="container">
    <?php
    include_once 'includes/sidebar.php';
    include_once 'includes/header.php';
    ?>
    <!-- Main Content -->
    <main class="main-content">
      <div class="page-header">
        <h1><i class="fas fa-list"></i> CLASS LIST</h1>
      </div>

      <!-- Attendance Toggle Buttons -->
      <div class="attendance-toggle">
        <button class="toggle-btn active">Advisory Attendance</button>
        <button class="toggle-btn">Subject Taught Attendance</button>
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
              <label><input type="checkbox" name="sex" value="female" /> Female</label>
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

        <!-- ✅ Unified Search Wrapper -->
        <div class="search-wrapper">
          <i class="fas fa-search"></i>
          <input type="text" class="search-bar" placeholder="Search here..." />
        </div>

        <!-- Sort Button -->
        <div class="updown">
          <span class="material-symbols-outlined">swap_vert</span>
        </div>
      </div>

      <!-- Class List Table -->
      <div class="table-container">
        <table class="styled-table">
          <thead>
            <tr>
              <th>Learner</th>
              <th>LRN</th>
              <th>Sex</th>
              <th>Grade Level & Section</th>
              <th>Adviser</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Juan Dela Cruz</td>
              <td>1234567890</td>
              <td>Male</td>
              <td>Grade 7 - Section A</td>
              <td>Mr. Santos</td>
            </tr>
            <tr>
              <td>Maria Clara</td>
              <td>0987654321</td>
              <td>Female</td>
              <td>Grade 7 - Section A</td>
              <td>Ms. Santos</td>
            </tr>
          </tbody>
        </table>
      </div>
    </main>
  </div>

  <!-- JS File -->
  <script src="js/script.js" defer></script>
</body>

</html>