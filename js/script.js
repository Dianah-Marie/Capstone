document.addEventListener("DOMContentLoaded", function () {

  /* ==========================
     📅 Generate Calendar
  ========================== */
  function generateCalendar() {
    const now = new Date();
    const calendar = document.getElementById("calendar");
    if (!calendar) return; // exit if no calendar element

    const month = now.toLocaleString("default", { month: "long" });
    const year = now.getFullYear();
    const today = now.getDate();

    const firstDay = new Date(year, now.getMonth(), 1).getDay();
    const daysInMonth = new Date(year, now.getMonth() + 1, 0).getDate();

    let html = `
      <div class="calendar-header">
        <h3>${month} ${year}</h3>
      </div>
      <div class="calendar-grid">
        <span>Su</span><span>Mo</span><span>Tu</span><span>We</span>
        <span>Th</span><span>Fr</span><span>Sa</span>
    `;

    for (let i = 0; i < firstDay; i++) {
      html += `<div></div>`;
    }

    for (let day = 1; day <= daysInMonth; day++) {
      const isToday = day === today;
      html += `<div class="calendar-day ${isToday ? "today" : ""}">${day}</div>`;
    }

    html += `</div>`;
    calendar.innerHTML = html;
  }
  generateCalendar();

  /* ==========================
     👋 Auto-hide Welcome Message
  ========================== */
  const welcome = document.getElementById("welcome-msg");
  if (welcome) {
    setTimeout(() => {
      welcome.style.opacity = "0";
      welcome.style.transform = "translateY(-10px)";
      setTimeout(() => (welcome.style.display = "none"), 500);
    }, 3000);
  }

  /* ==========================
     📂 Sidebar Toggle
  ========================== */
  const menuToggle = document.getElementById("menu-toggle");
  const sidebar = document.querySelector(".sidebar");
  const mainContent = document.querySelector(".main-content");

  if (menuToggle && sidebar && mainContent) {
    menuToggle.addEventListener("click", () => {
      sidebar.classList.toggle("closed");
      mainContent.style.marginLeft = sidebar.classList.contains("closed")
        ? "60px"
        : "220px";
    });
  }

  /* ==========================
     ✅ Attendance Toggle Buttons
  ========================== */
  const toggleBtns = document.querySelectorAll(".attendance-toggle .toggle-btn");
  if (toggleBtns.length > 0) {
    toggleBtns.forEach((btn) => {
      btn.addEventListener("click", () => {
        toggleBtns.forEach((b) => b.classList.remove("active"));
        btn.classList.add("active");
      });
    });
  }

  /* ==========================
     🔍 Filter Panel Toggle (Safe)
  ========================== */
  const filterToggle = document.getElementById("filterToggle");
  const filterPanel = document.getElementById("filterPanel");

  if (filterToggle && filterPanel) {
    filterToggle.addEventListener("click", () => {
      filterPanel.style.display =
        filterPanel.style.display === "block" ? "none" : "block";
    });
  }

  /* ==========================
     🔔 Notification Panel
  ========================== */
  const btn = document.getElementById("notificationBtn");
  const panel = document.getElementById("notificationPanel");
  const badge = document.getElementById("notificationBadge");
  const tabs = document.querySelectorAll(".tab");

  if (btn && panel) {
    btn.addEventListener("click", (e) => {
      e.stopPropagation(); // prevent closing immediately
      const isOpen = panel.classList.contains("show");

      panel.classList.toggle("show", !isOpen);
      btn.classList.toggle("active", !isOpen);

      // clear badge count when opened
     if (!isOpen && badge) {
  badge.style.display = "none";
}
});

    // Close panel when clicking outside
    document.addEventListener("click", (e) => {
      if (!panel.contains(e.target) && !btn.contains(e.target)) {
        panel.classList.remove("show");
        btn.classList.remove("active");
      }
    });
  }

  // 🔄 Notification Tabs
  if (tabs.length > 0) {
    tabs.forEach((tab) => {
      tab.addEventListener("click", () => {
        tabs.forEach((t) => t.classList.remove("active"));
        tab.classList.add("active");
      });
    });
  }

});


/* ==========================
     📂 EDIT MODAL 
  ========================== */

 let currentRow = null;

// Open modal (already in your code)
function openEditModal(button) {
  currentRow = button.closest("tr");
  const cells = currentRow.querySelectorAll("td");

  document.getElementById("editName").value    = cells[1].innerText;
  document.getElementById("editLRN").value     = cells[2].innerText;
  document.getElementById("editSection").value = cells[3].innerText;
  document.getElementById("editSubject").value = cells[4].innerText;
  document.getElementById("editDate").value    = cells[5].innerText.trim();
  document.getElementById("editTimeIn").value  = convertTime(cells[6].innerText.trim());
  document.getElementById("editTimeOut").value = convertTime(cells[7].innerText.trim());
  document.getElementById("editStatus").value  = cells[8].innerText;

  document.getElementById("editModal").style.display = "flex";
}

// Close modal
function closeModal() {
  document.getElementById("editModal").style.display = "none";
}

// Save changes back to the table
function saveEdit() {
  if (!currentRow) return;

  const cells = currentRow.querySelectorAll("td");

  cells[5].innerText = document.getElementById("editDate").value;
  cells[6].innerText = document.getElementById("editTimeIn").value;
  cells[7].innerText = document.getElementById("editTimeOut").value;

  closeModal();
}

// Convert "08:00 AM" → "08:00"
function convertTime(timeStr) {
  const match = timeStr.match(/(\d{1,2}):(\d{2})\s?(AM|PM)?/i);
  if (!match) return "";

  let hour = parseInt(match[1], 10);
  const minute = match[2];
  const period = match[3] ? match[3].toUpperCase() : "";

  if (period === "PM" && hour < 12) hour += 12;
  if (period === "AM" && hour === 12) hour = 0;

  return `${hour.toString().padStart(2, "0")}:${minute}`;
}



//  delete

let rowToDelete = null; // store the row we want to delete

// Called when clicking the trash button
function openDeleteModal(button) {
  rowToDelete = button.closest("tr"); // store the row
  document.getElementById("deleteModal").style.display = "flex";
}

function closeDeleteModal() {
  document.getElementById("deleteModal").style.display = "none";
}

function confirmDelete() {
  if (rowToDelete) {
    rowToDelete.remove(); // delete the stored row
    rowToDelete = null;   // reset
    alert("Record deleted successfully!");
  }
  closeDeleteModal();
}

