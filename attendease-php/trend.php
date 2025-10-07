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
    <title>Trend Analysis | AttendEase</title>
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

                <!-- ✅ Section Dropdown -->
                <label for="sectionID">Section:</label>
                <select id="sectionID">
                    <option value="">All Sections</option>
                    <?php
                    $sectionQuery = "SELECT sectionID, sectionName FROM section ORDER BY sectionName ASC";
                    $sectionResult = $conn->query($sectionQuery);
                    if ($sectionResult && $sectionResult->num_rows > 0) {
                        while ($row = $sectionResult->fetch_assoc()) {
                            echo "<option value='" . htmlspecialchars($row['sectionID']) . "'>" . htmlspecialchars($row['sectionName']) . "</option>";
                        }
                    }
                    ?>
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