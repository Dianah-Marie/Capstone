<?php
// ✅ Step 1: Start session before any HTML
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Step 2: Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <link rel="icon" href="img/icon.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Teacher Dashboard | AttendEase</title>
</head>

<body>
    <div class="container">
        <?php
        // ✅ Step 3: Include these AFTER session + redirect
        include_once 'includes/header.php';
        include_once 'includes/sidebar.php';
        ?>

        <!-- Main Content -->
        <main class="main-content">
            <div id="welcome-msg" class="welcome">Welcome Teacher</div>
            <h1>DASHBOARD</h1>

            <div class="quick-links">
                <!-- Learners -->
                <div class="info-card purple">
                    <div class="card-header">
                        <div class="icon"><i class="fas fa-user-graduate"></i></div>
                        <span id="status-learners" class="status"></span>
                    </div>
                    <p class="label">Learners</p>
                    <p id="count-learners" class="count">0</p>
                    <div id="chart-learners" class="chart"></div>
                </div>

                <!-- On Time -->
                <div class="info-card blue">
                    <div class="card-header">
                        <div class="icon"><i class="fas fa-user-check"></i></div>
                        <span id="status-ontime" class="status"></span>
                    </div>
                    <p class="label">On Time</p>
                    <p id="count-ontime" class="count">0</p>
                    <div id="chart-ontime" class="chart"></div>
                </div>

                <!-- Absent -->
                <div class="info-card pink">
                    <div class="card-header">
                        <div class="icon"><i class="fas fa-user-times"></i></div>
                        <span id="status-absent" class="status"></span>
                    </div>
                    <p class="label">Absent</p>
                    <p id="count-absent" class="count">0</p>
                    <div id="chart-absent" class="chart"></div>
                </div>

                <!-- Tardy -->
                <div class="info-card green">
                    <div class="card-header">
                        <div class="icon"><i class="fas fa-user-clock"></i></div>
                        <span id="status-tardy" class="status"></span>
                    </div>
                    <p class="label">Tardy</p>
                    <p id="count-tardy" class="count">0</p>
                    <div id="chart-tardy" class="chart"></div>
                </div>
            </div>

            <div class="cards">
                <div class="card">
                    <h2>Trend Analysis</h2>
                    <div class="trend-chart">
                        <canvas id="tardyTrendChart"></canvas>
                    </div>
                </div>
                <div class="calendar-container">
                    <h2>Calendar</h2>
                    <div id="calendar"></div>
                </div>
            </div>

            <div class="activity">
                <h2>Recent Activity</h2>
                <div class="placeholder activity-content"></div>
            </div>
        </main>
    </div>

    <!-- JS -->
    <script src="js/script.js" defer></script>
    <script src="js/quick-links.js" defer></script>
</body>

</html>