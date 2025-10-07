<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <link rel="icon" href="images/icon.png" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>School Form 2 (SF2) | AttendEase</title>

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
      <div class="page-header">
        <h1><i class="fas fa-file-alt"></i> SCHOOL FORM 2</h1>
      </div>

      <div class="section-display">
        <label>Section:</label>
        <span class="section-value">Grade 7 - Hera</span>

        <!-- Export Button now beside Section -->
        <button class="export-btn" id="generateReport">
          <i class="fas fa-file-export"></i> Export Report
        </button>
      </div>

      <!-- SF2 Graph/Chart -->
      <div class="sf2-graph">
        <p>[ SF2 Graph / Data Visualization Placeholder ]</p>
      </div>
    </main>
  </div>

  <!-- Export Report Modal -->
  <div id="reportModal" class="modal">
    <div class="modal-content">
      <div class="modal-icon">
        <i class="fas fa-file-export"></i>
      </div>
      <h2>Export Report</h2>
      <p>Are you sure you want to Export School Form 2 Report?</p>
      <div class="modal-actions">
        <button id="cancelReport" class="btn cancel">
          <i class="fas fa-times"></i> Cancel
        </button>
        <button id="confirmReport" class="btn confirm">
          <i class="fas fa-file-export"></i> Export
        </button>
      </div>
    </div>
  </div>

  <!-- JS File -->
  <script src="js/script.js" defer></script>
  <script src="js/excel.js" defer></script>
</body>

</html>