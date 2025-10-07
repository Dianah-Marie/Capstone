<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <link rel="icon" href="images/icon.png" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Trend Analysis | AttendEase</title>

  <!-- 🎨 Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bebas+Neue&display=swap" />

  <!-- Main CSS -->
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/notification.css" />
  <link rel="stylesheet" href="css/table.css" />
  <link rel="stylesheet" href="css/confirmation.css">

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
        <h1><i class="fas fa-chart-line"></i> TREND ANALYSIS</h1>
      </div>


      <!-- Filter Bar -->
      <div class="filter-bar">
        <label for="mode">View By:</label>
        <select id="mode">
          <option value="monthly">Monthly</option>
          <option value="yearly">Yearly</option>
        </select>

        <label for="subject">Subject:</label>
        <select id="subject">
          <option value="">All Subjects</option>
          <option value="math">Math</option>
          <option value="science">Science</option>
          <option value="english">English</option>
        </select>

        <button class="filter-btn">
          <i class="fas fa-filter"></i> Apply
        </button>
      </div>

      <!-- Trend Graph -->
      <div class="trend-graph">
        <p>[ Trend Graph / Data Visualization Placeholder ]</p>
      </div>
    </main>
  </div>

  <!-- JS File -->
  <script src="js/script.js" defer></script>
</body>

</html>