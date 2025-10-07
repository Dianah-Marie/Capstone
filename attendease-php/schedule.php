<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'db/connect.php';

// =========================
// 🗑️ DELETE SCHEDULE
// =========================
if (isset($_POST['action']) && $_POST['action'] === 'delete') {
    $scheduleID = intval($_POST['scheduleID']);
    $stmt = $conn->prepare("DELETE FROM schedule WHERE scheduleID = ?");
    $stmt->bind_param("i", $scheduleID);
    echo $stmt->execute() ? "success" : "error";
    exit;
}

// =========================
// ✏️ EDIT SCHEDULE
// =========================
if (isset($_POST['action']) && $_POST['action'] === 'edit') {
    $scheduleID = intval($_POST['scheduleID']);
    $subject = $_POST['subject'];
    $sectionID = intval($_POST['sectionID']);
    $room = $_POST['roomAssignment'];
    $teacherID = intval($_POST['teacherID']);
    $day = $_POST['day'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];
    $schoolYear = $_POST['schoolYear'];

    $stmt = $conn->prepare("UPDATE schedule SET subject=?, sectionID=?, roomAssignment=?, teacherID=?, day=?, startTime=?, endTime=?, schoolYear=? WHERE scheduleID=?");
    $stmt->bind_param("sisissssi", $subject, $sectionID, $room, $teacherID, $day, $startTime, $endTime, $schoolYear, $scheduleID);

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
    <title>Schedule | AttendEase</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container">
        <?php include_once 'includes/sidebar.php'; ?>
        <?php include_once 'includes/header.php'; ?>

        <main class="main-content">
            <div class="page-header">
                <h1><i class="fas fa-calendar-alt"></i> SCHEDULE</h1>
            </div>

            <!-- 🔍 Filter + Search + Add -->
            <div class="search-filter">
                <div class="filter-container">
                    <button class="filter-btn" id="filterToggle">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>

                <div class="search-wrapper">
                    <i class="fas fa-search"></i>
                    <input type="text" class="search-bar" placeholder="Search here..." />
                </div>

                <button class="register-button" id="openRegisterModal">
                    <i class="fas fa-plus"></i> Add Schedule
                </button>
            </div>

            <!-- 📋 Schedule Table -->
            <div class="table-container">
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Grade & Section</th>
                            <th>Room</th>
                            <th>Teacher</th>
                            <th>Day</th>
                            <th>Time</th>
                            <th>School Year</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="scheduleTable">
                        <?php
                        $sql = "SELECT 
                schedule.scheduleID,
                schedule.subject,
                schedule.roomAssignment AS room,
                schedule.day,
                schedule.startTime,
                schedule.endTime,
                schedule.schoolYear,
                section.gradeLevel,
                section.sectionName,
                user.firstName AS teacherFirst,
                user.lastName AS teacherLast
              FROM schedule
              LEFT JOIN section ON schedule.sectionID = section.sectionID
              LEFT JOIN teachers ON schedule.teacherID = teachers.teacherID
              LEFT JOIN user ON teachers.userID = user.user_ID
              ORDER BY schedule.day ASC, schedule.startTime ASC";

                        $result = $conn->query($sql);

                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $start = substr($row['startTime'], 0, 5); // HH:MM only
                                $end = substr($row['endTime'], 0, 5);

                                echo "
          <tr data-id='{$row['scheduleID']}'>
            <td>" . htmlspecialchars($row['subject']) . "</td>
            <td>Grade " . htmlspecialchars($row['gradeLevel']) . " - " . htmlspecialchars($row['sectionName']) . "</td>
            <td>" . htmlspecialchars($row['room']) . "</td>
            <td>" . htmlspecialchars($row['teacherFirst']) . " " . htmlspecialchars($row['teacherLast']) . "</td>
            <td>" . htmlspecialchars($row['day']) . "</td>
            <td>{$start} - {$end}</td>
            <td>" . htmlspecialchars($row['schoolYear']) . "</td>
            <td class='action-buttons'>
              <button class='edit-btn' onclick='openEditModal(this)'><i class='fas fa-edit'></i></button>
              <button class='delete-btn' onclick='openDeleteModal(this)'><i class='fas fa-trash'></i></button>
            </td>
          </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8' style='text-align:center;'>No schedules found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- 🟢 Add Schedule Modal -->
    <div id="registerModal" class="add-modal">
        <div class="add-modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Add Schedule</h2>
            <form id="registerScheduleForm" method="POST" action="register_schedule.php">
                <label>Subject:</label>
                <input type="text" name="subject" required>

                <label>Grade & Section:</label>
                <select name="sectionID" required>
                    <option value="">Select</option>
                    <?php
                    $sections = $conn->query("SELECT sectionID, CONCAT('Grade ', gradeLevel, ' - ', sectionName) AS sectionFull FROM section");
                    while ($sec = $sections->fetch_assoc()) {
                        echo "<option value='{$sec['sectionID']}'>{$sec['sectionFull']}</option>";
                    }
                    ?>
                </select>

                <label>Room:</label>
                <input type="text" name="roomAssignment" required>

                <label>Teacher:</label>
                <select name="teacherID" required>
                    <option value=''>Select</option>
                    <?php
                    $teachers = $conn->query("SELECT t.teacherID, CONCAT(u.firstName,' ',u.lastName) AS fullname 
                          FROM teachers t
                          LEFT JOIN user u ON t.userID = u.user_ID");
                    while ($t = $teachers->fetch_assoc()) {
                        echo "<option value='{$t['teacherID']}'>{$t['fullname']}</option>";
                    }
                    ?>
                </select>

                <label>Day:</label>
                <select name="day" required>
                    <option>Monday</option>
                    <option>Tuesday</option>
                    <option>Wednesday</option>
                    <option>Thursday</option>
                    <option>Friday</option>
                </select>

                <label>Start Time:</label>
                <input type="time" name="startTime" required>

                <label>End Time:</label>
                <input type="time" name="endTime" required>

                <label>School Year:</label>
                <input type="text" name="schoolYear" placeholder="2025-2026" required>

                <button type="submit" class="submit-btn">Save Schedule</button>
            </form>
        </div>
    </div>

    <!-- ✏️ Edit Schedule Modal -->
    <div id="editScheduleModal" class="edit-modal">
        <div class="edit-modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Edit Schedule</h2>
            <form id="editScheduleForm">
                <input type="hidden" id="editScheduleID" name="scheduleID">

                <label>Subject:</label>
                <input type="text" id="editSubject" name="subject" required>

                <label>Grade & Section:</label>
                <select id="editSection" name="sectionID" required>
                    <?php
                    $sections = $conn->query("SELECT sectionID, CONCAT('Grade ', gradeLevel, ' - ', sectionName) AS sectionFull FROM section");
                    while ($sec = $sections->fetch_assoc()) {
                        echo "<option value='{$sec['sectionID']}'>{$sec['sectionFull']}</option>";
                    }
                    ?>
                </select>

                <label>Room:</label>
                <input type="text" id="editRoom" name="roomAssignment" required>

                <label>Teacher:</label>
                <select id="editTeacher" name="teacherID" required>
                    <?php
                    $teachers = $conn->query("SELECT t.teacherID, CONCAT(u.firstName,' ',u.lastName) AS fullname 
                          FROM teachers t
                          LEFT JOIN user u ON t.userID = u.user_ID");
                    while ($t = $teachers->fetch_assoc()) {
                        echo "<option value='{$t['teacherID']}'>{$t['fullname']}</option>";
                    }
                    ?>
                </select>

                <label>Day:</label>
                <select id="editDay" name="day" required>
                    <option>Monday</option>
                    <option>Tuesday</option>
                    <option>Wednesday</option>
                    <option>Thursday</option>
                    <option>Friday</option>
                </select>

                <label>Start Time:</label>
                <input type="time" id="editStartTime" name="startTime" required>

                <label>End Time:</label>
                <input type="time" id="editEndTime" name="endTime" required>

                <label>School Year:</label>
                <input type="text" id="editSY" name="schoolYear" required>

                <button type="button" onclick="saveEditedSchedule()">Save Changes</button>
            </form>
        </div>
    </div>

    <!-- 🔴 Delete Modal -->
    <div id="deleteScheduleModal" class="delete-modal">
        <div class="delete-modal-content">
            <i class="fas fa-trash modal-icon"></i>
            <h3>Are you sure you want to delete this schedule?</h3>
            <div class="modal-actions">
                <button class="btn cancel" onclick="closeDeleteModal()">Cancel</button>
                <button class="btn confirm" onclick="confirmDelete()">Delete</button>
            </div>
        </div>
    </div>

    <script src="js/schedule.js" defer></script>
</body>

</html>