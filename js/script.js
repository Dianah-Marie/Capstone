document.addEventListener('DOMContentLoaded', function () {
  // 📅 Generate Calendar
  function generateCalendar() {
    const now = new Date();
    const calendar = document.getElementById("calendar");
    const month = now.toLocaleString('default', { month: 'long' });
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
      html += `<div class="calendar-day ${isToday ? 'today' : ''}">${day}</div>`;
    }

    html += `</div>`;
    calendar.innerHTML = html;
  }

  generateCalendar();

  // 👋 Auto-hide Welcome Message
  const welcome = document.getElementById('welcome-msg');
  if (welcome) {
    setTimeout(() => {
      welcome.style.opacity = '0';
      welcome.style.transform = 'translateY(-10px)';
      setTimeout(() => {
        welcome.style.display = 'none';
      }, 500);
    }, 3000);
  }

  // 📂 Sidebar Toggle
  const menuToggle = document.getElementById('menu-toggle');
  const sidebar = document.querySelector('.sidebar');
  const mainContent = document.querySelector('.main-content');

  menuToggle.addEventListener('click', () => {
    sidebar.classList.toggle('closed');
    mainContent.style.marginLeft = sidebar.classList.contains('closed') ? '60px' : '220px';
  });

  // 🔒 Logout Modal Logic (moved outside of sidebar toggle)
  const logoutLink = document.querySelector('a[title="Logout"]');
  const modal = document.getElementById('logoutModal');
  const cancelBtn = document.getElementById('cancelLogout');

  if (logoutLink && modal && cancelBtn) {
    logoutLink.addEventListener('click', function (e) {
      e.preventDefault();
      modal.style.display = 'flex';
    });

    cancelBtn.addEventListener('click', function () {
      modal.style.display = 'none';
    });

    window.addEventListener('click', function (e) {
      if (e.target === modal) {
        modal.style.display = 'none';
      }
    });
  }
});
