<?php
session_start();
require_once 'db/connect.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <link rel="icon" href="images/icon.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>School Form 2 (SF2) | AttendEase</title>
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

            <!-- Section + Export -->
            <div class="section-display">
                <label for="sectionSelect">Section:</label>
                <select id="sectionSelect" name="sectionSelect" class="section-dropdown">
                    <option value="">Select Section</option>
                    <?php
                    $query = "SELECT sectionID, sectionName FROM section ORDER BY sectionName ASC";
                    $result = $conn->query($query);
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . htmlspecialchars($row['sectionID']) . "'>" . htmlspecialchars($row['sectionName']) . "</option>";
                        }
                    } else {
                        echo "<option disabled>No sections found</option>";
                    }
                    ?>
                </select>

                <!-- Export Button beside dropdown -->
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

    <!-- JS Files -->
    <script src="js/script.js" defer></script>
    <script src="js/excel.js" defer></script>
</body>

</html>