let deleteTargetID = null;

// 🟢 Add Schedule Modal
document.getElementById("openRegisterModal").addEventListener("click", () => {
  document.getElementById("registerModal").style.display = "flex";
});
function closeModal() {
  document.getElementById("registerModal").style.display = "none";
}

// ✏️ Edit Schedule Modal
function openEditModal(button) {
  const row = button.closest("tr");
  const cells = row.querySelectorAll("td");
  document.getElementById("editScheduleID").value = row.dataset.id;
  document.getElementById("editSubject").value = cells[0].textContent;
  // section dropdown match text
  const sectionSelect = document.getElementById("editSection");
  [...sectionSelect.options].forEach(opt => {
    opt.selected = cells[1].textContent.includes(opt.text);
  });
  document.getElementById("editRoom").value = cells[2].textContent;
  const teacherSelect = document.getElementById("editTeacher");
  [...teacherSelect.options].forEach(opt => {
    opt.selected = cells[3].textContent.trim() === opt.text.trim();
  });
  document.getElementById("editDay").value = cells[4].textContent.trim();
  const time = cells[5].textContent.split(" - ");
  document.getElementById("editStartTime").value = time[0];
  document.getElementById("editEndTime").value = time[1];
  document.getElementById("editSY").value = cells[6].textContent.trim();
  document.getElementById("editScheduleModal").style.display = "flex";
}
function closeEditModal() {
  document.getElementById("editScheduleModal").style.display = "none";
}

// ✏️ Save Edited Schedule
function saveEditedSchedule() {
  const form = document.getElementById("editScheduleForm");
  const data = new URLSearchParams(new FormData(form));
  data.append("action", "edit");

  fetch("schedule.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: data.toString(),
  })
    .then(res => res.text())
    .then(data => {
      if (data.trim() === "success") {
        alert("Schedule updated successfully!");
        location.reload();
      } else {
        alert("Error updating schedule!");
      }
    });
}

// 🗑️ Delete Schedule Modal
function openDeleteModal(button) {
  deleteTargetID = button.closest("tr").dataset.id;
  document.getElementById("deleteScheduleModal").style.display = "flex";
}
function closeDeleteModal() {
  document.getElementById("deleteScheduleModal").style.display = "none";
}
function confirmDelete() {
  fetch("schedule.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "action=delete&scheduleID=" + deleteTargetID,
  })
    .then(res => res.text())
    .then(data => {
      if (data.trim() === "success") {
        alert("Schedule deleted successfully!");
        location.reload();
      } else {
        alert("Error deleting schedule!");
      }
    });
}
