<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <link rel="icon" href="images/icon.png" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Attendance| AttendEase</title>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
  <!-- 🎨 Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bebas+Neue&display=swap" />

  <!-- Main CSS -->
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/notification.css" />
  <link rel="stylesheet" href="css/table.css" />
  <link rel="stylesheet" href="css/confirmation.css" />

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
        <h1><i class="fas fa-calendar-check"></i> ATTENDANCE</h1>
      </div>



      <!-- Attendance Toggle Buttons -->
      <div class="attendance-toggle">
        <button class="toggle-btn active">Advisory Attendance</button>
        <button class="toggle-btn">Subject Taught Attendance</button>
      </div>

      <!-- Filter + Search (inline) -->
      <div class="search-filter">

        <!-- 🔽 Group filter button + panel -->
        <div class="filter-container">
          <button class="filter-btn" id="filterToggle">
            <i class="fas fa-filter"></i> Filter
          </button>

          <!-- ⬇️ Filter Panel goes right under the Filter button -->
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

            <!-- Status Filter -->
            <div class="filter-group">
              <strong>Status:</strong>
              <label><input type="checkbox" value="present" /> Present</label>
              <label><input type="checkbox" value="absent" /> Absent</label>
              <label><input type="checkbox" value="tardy" /> Tardy</label>
            </div>

            <!-- Subject Filter -->
            <div class="filter-group">
              <strong>Subject:</strong>
              <label><input type="checkbox" value="Math" /> Math</label>
              <label><input type="checkbox" value="Science" /> Filipino</label>
              <label><input type="checkbox" value="English" /> English</label>
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
        <!-- 🔼 End filter-container -->

        <!-- search bar -->
        <div class="search-wrapper">
          <i class="fas fa-search"></i>
          <input type="text" class="search-bar" placeholder="Search here..." />
        </div>

        <!-- up/down -->
        <div class="updown">
          <span class="material-symbols-outlined">swap_vert</span>
        </div>

        <!-- report button -->
        <button class="report-btn" id="generateReport">
          <i class="fas fa-file-export"></i> Generate Report
        </button>

        <!-- daily summary -->
        <a href="summary.php" class="summary-btn">
          <i class="fas fa-calendar-day"></i> Daily Summary
        </a>
      </div>


      <!-- Attendance Table -->
      <div class="table-container">
        <table class="styled-table">
          <thead>
            <tr>
              <th><input type="checkbox" /></th>
              <th>Learner Name</th>
              <th>LRN</th>
              <th>Section</th>
              <th>Subject</th>
              <th>Date</th>
              <th>Time In</th>
              <th>Time Out</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><input type="checkbox" /></td>
              <td>Juan Dela Cruz</td>
              <td>00034355</td>
              <td>Grade 7- Hera</td>
              <td>Math</td>
              <td>2025-09-28</td>
              <td>08:00 AM</td>
              <td>09:00 AM</td>
              <td>Present</td>
              <td class="action-buttons">
                <button class="edit-btn" onclick="openEditModal(this)">
                  <i class="fas fa-edit"></i>
                </button>
                <button class="delete-btn" onclick="openDeleteModal(this)">
                  <i class="fas fa-trash"></i>
                </button>
              </td>
            </tr>
            <tr>
              <td><input type="checkbox" /></td>
              <td>Maria Clara</td>
              <td>090090989</td>
              <td>Grade 7- Hera</td>
              <td>Science</td>
              <td>2025-09-28</td>
              <td>09:15 AM</td>
              <td>10:15 AM</td>
              <td>Late</td>
              <td class="action-buttons">
                <button class="edit-btn" onclick="openEditModal(this)">
                  <i class="fas fa-edit"></i>
                </button>
                <button class="delete-btn" onclick="openDeleteModal(this)">
                  <i class="fas fa-trash"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
        <!-- 🟢 Edit Attendance Modal -->
        <div id="editModal" class="edit-modal">
          <div class="edit-modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Edit Attendance</h2>

            <form id="editForm">
              <label>Learner Name</label>
              <input type="text" id="editName" readonly>

              <label>LRN</label>
              <input type="text" id="editLRN" readonly>

              <label>Section</label>
              <input type="text" id="editSection" readonly>

              <label>Subject</label>
              <input type="text" id="editSubject" readonly>

              <label>Date</label>
              <input type="date" id="editDate">

              <label>Time In</label>
              <input type="time" id="editTimeIn">

              <label>Time Out</label>
              <input type="time" id="editTimeOut">

              <label>Status</label>
              <input type="text" id="editStatus" readonly>

              <button type="button" onclick="saveEdit()"><i class="fas fa-save"></i> Save Changes</button>
            </form>
          </div>
        </div>

      </div>
    </main>
  </div>

  <!-- Generate Report Modal -->
  <div id="reportModal" class="modal">
    <div class="modal-content">
      <div class="modal-icon">
        <i class="fas fa-file-alt"></i>
      </div>
      <h2>Generate Report</h2>
      <p>Are you sure you want to generate the Class List Report?</p>
      <div class="modal-actions">
        <button id="cancelReport" class="btn cancel">
          <i class="fas fa-times"></i> Cancel
        </button>
        <button id="confirmReport" class="btn confirm">
          <i class="fas fa-file-export"></i> Generate
        </button>
      </div>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div id="deleteModal" class="delete-modal">
    <div class="delete-modal-content">
      <i class="fas fa-trash modal-icon"></i>
      <h3>Are you sure you want to delete this record?</h3>
      <div class="modal-actions">
        <button class="btn cancel" onclick="closeDeleteModal()">Cancel</button>
        <button class="btn confirm" onclick="confirmDelete()">Delete</button>
      </div>
    </div>
  </div>



  <!-- JS File -->
  <script src="js/script.js" defer></script>
  <script src="js/excel.js" defer></script>
</body>

</html>