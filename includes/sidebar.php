<!-- Sidebar -->
<nav class="sidebar">
  <div class="menu-toggle" id="menu-toggle">
    <i class="fas fa-bars"></i>
  </div>

  <div class="logo">
    <img src="images/AElogo.png" alt="AttendEase Logo" class="logo-img" />
  </div>


  <ul class="sidebar-menu">
    <li class="menu-label">MAIN</li>
    <li>
      <a href="index.php" title="Dashboard">
        <i class="fas fa-home"></i> <span>Dashboard</span>
      </a>
    </li>

    <li class="menu-label">OVERVIEW</li>
    <li>
      <a href="classlist.php" title="Classlist">
        <i class="fas fa-list"></i>
        <span>Classlist</span>
      </a>
    </li>
    <li>
      <a href="schedule.php" title="Schedule">
        <i class="fas fa-calendar-alt"></i> <span>Schedule</span>
      </a>
    </li>
    <li>
      <a href="attendance.php" title="Attendance">
        <i class="fas fa-calendar-check"></i> <span>Attendance</span>
      </a>
    </li>

    <li class="menu-label">REPORTS</li>
    <li>
      <a href="sf2.php" title="School Form 2 (SF2) Report">
        <i class="fas fa-file-alt"></i> <span>SF2 Report</span>
      </a>
    </li>
    <li>
      <a href="trend.php" title="Trend Analysis">
        <i class="fas fa-chart-line"></i> <span>Trend Analysis</span>
      </a>
    </li>

    <li class="menu-separator"></li>
    <li>
      <a href="logout.php" id="logoutLink" title="Logout">
        <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
      </a>
    </li>
  </ul>
</nav>

<div id="logoutModal" class="modal">
  <div class="modal-content">
    <!-- Icon on top -->
    <div class="modal-icon">
      <i class="fas fa-sign-out-alt"></i>
    </div>

    <h2>Confirm Logout</h2>
    <p>Are you sure you want to log out?</p>

    <div class="modal-actions">
      <button id="cancelLogout" class="btn cancel">Cancel</button>
      <a href="logout.php" class="btn confirm">Logout</a>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const logoutLink = document.getElementById("logoutLink");
    const logoutModal = document.getElementById("logoutModal");
    const cancelBtn = document.getElementById("cancelLogout");

    // Show modal when logout link is clicked
    logoutLink.addEventListener("click", (e) => {
      e.preventDefault();
      logoutModal.style.display = "flex";
    });

    // Hide modal on cancel
    cancelBtn.addEventListener("click", () => {
      logoutModal.style.display = "none";
    });

    // Hide modal if user clicks outside the modal content
    window.addEventListener("click", (e) => {
      if (e.target === logoutModal) {
        logoutModal.style.display = "none";
      }
    });
  });
</script>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    // Existing logout modal script stays the same

    // Handle active sidebar link
    const links = document.querySelectorAll(".sidebar-menu a");
    const currentPath = window.location.pathname.split("/").pop();

    links.forEach(link => {
      if (link.getAttribute("href") === currentPath) {
        link.classList.add("active");
      }

      link.addEventListener("click", () => {
        links.forEach(l => l.classList.remove("active"));
        link.classList.add("active");
      });
    });
  });
</script>