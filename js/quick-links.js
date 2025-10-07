// Animate counter
function animateCount(elementId, target, duration = 1500) {
  const el = document.getElementById(elementId);
  let start = 0;
  const increment = target / (duration / 30);

  const timer = setInterval(() => {
    start += increment;
    if (start >= target) {
      start = target;
      clearInterval(timer);
    }
    el.textContent = Math.floor(start).toLocaleString();
  }, 30);
}

// Generate mini chart
function generateChart(elementId, data, color) {
  const el = document.getElementById(elementId);
  el.innerHTML = "";
  data.forEach((value, idx) => {
    const span = document.createElement("span");
    span.style.height = value + "px";
    span.style.background = color;
    if (idx % 3 === 0) span.classList.add("active");
    el.appendChild(span);
  });
}

// Set percentage dynamically
function setStatus(elementId, count, total) {
  const el = document.getElementById(elementId);
  let percent = total > 0 ? Math.round((count / total) * 100) : 0;
  el.textContent = percent + "%";
  if (percent >= 50) {
    el.className = "status up";
  } else {
    el.className = "status down";
  }
}

// Dashboard data
const dashboardData = {
  learners: { count: 1200, chart: [10,20,30,25,35,20,30,15,25,18], color: "#7e57c2" },
  ontime:   { count: 950,  chart: [25,15,30,20,35,10,28,18,22,30], color: "#29b6f6" },
  absent:   { count: 120,  chart: [20,30,15,25,35,10,28,18,22,30], color: "#ec407a" },
  tardy:    { count: 80,   chart: [15,25,10,30,18,22,12,28,20,35], color: "#66bb6a" }
};

// Run setup
window.addEventListener("DOMContentLoaded", () => {
  const total = dashboardData.learners.count;

  Object.entries(dashboardData).forEach(([key, data]) => {
    animateCount(`count-${key}`, data.count);
    generateChart(`chart-${key}`, data.chart, data.color);

    if (key !== "learners") {
      setStatus(`status-${key}`, data.count, total);
    } else {
      document.getElementById("status-learners").textContent = total + " total";
    }
  });
});
