<!-- Top Header -->
<header class="top-header">
  <p class="schoolName">BOTONG-CABANBANAN NATIONAL HIGH SCHOOL</p>
  <div class="user-info">
    <!-- 🔔 Notification Bell with Badge -->
    <div class="notification-wrapper">
      <button class="btn-notification" id="notificationBtn">
        <i class="fas fa-bell"></i>
        <span class="badge" id="notificationBadge">3</span>
      </button>

      <!-- 📋 Attendance Notifications Panel -->
      <div class="notification-panel" id="notificationPanel">
        <div class="notif-header">
          <h3>Notifications</h3>
          <button class="mark-read" id="markAllRead">Mark all as read</button>
        </div>

        <!-- Tabs -->
        <div class="notif-tabs">
          <button class="tab active" data-tab="all">
            All <span>3</span>
          </button>
          <button class="tab" data-tab="absent">
            Absences <span>1</span>
          </button>
          <button class="tab" data-tab="tardy">
            Tardiness <span>2</span>
          </button>
        </div>

        <!-- Notification List -->
        <div class="notif-list" id="notifList">
          <div class="notif-item unread" data-status="absent">
            <div class="avatar initials">JD</div>
            <div class="notif-content">
              <p>
                <strong>Juan Dela Cruz</strong>
                has a new <span class="highlight">absence</span> record.
              </p>
              <small>Updated Oct 02, 2025 • Attendance Report</small>
            </div>
          </div>

          <div class="notif-item unread" data-status="tardy">
            <div class="avatar initials">MC</div>
            <div class="notif-content">
              <p>
                <strong>Maria Clara</strong>
                has a new <span class="highlight">tardiness</span> record.
              </p>
              <small>Updated Oct 01, 2025 • Attendance Report</small>
            </div>
          </div>

          <div class="notif-item unread" data-status="tardy">
            <div class="avatar initials">RS</div>
            <div class="notif-content">
              <p>
                <strong>Rizal Santos</strong>
                has a new <span class="highlight">tardiness</span> record.
              </p>
              <small>Updated Sep 30, 2025 • Attendance Report</small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- User Info -->
    <a href="profile.php" class="profile-link"
      style="display: flex; align-items: center; gap: 10px; text-decoration: none; color: inherit;">
      <div class="name-role">
        <span class="username">Teacher01</span>
        <span class="role">Adviser</span>
      </div>
      <img src="https://via.placeholder.com/30" class="avatar" alt="Profile" />
    </a>
  </div>
  <script src="js/script.js" defer></script>
</header>

<script>
  // JS to toggle notification panel
  const notifBtn = document.getElementById('notificationBtn');
  const notifPanel = document.getElementById('notificationPanel');
  notifBtn.addEventListener('click', () => notifPanel.classList.toggle('active'));

  // "Mark all as read" just clears badge & marks items visually
  document.getElementById('markAllRead').addEventListener('click', () => {
    document.querySelectorAll('.notif-item').forEach(item => item.classList.remove('unread'));
    document.getElementById('notificationBadge').textContent = "0";
  });
</script>