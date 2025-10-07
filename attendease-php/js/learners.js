// learners.js
let selectedLearnerID = null;

// 🟢 Open Add Modal
document.getElementById("openRegisterModal").onclick = () => {
  document.getElementById("registerModal").style.display = "block";
};
function closeModal() {
  document.getElementById("registerModal").style.display = "none";
}

// ✏️ Open Edit Modal
function openEditModal(btn) {
  const row = btn.closest("tr");
  selectedLearnerID = row.dataset.id;

  document.getElementById("editLearnerID").value = row.dataset.id;
  document.getElementById("editFname").value = row.dataset.fname;
  document.getElementById("editMname").value = row.dataset.mname;
  document.getElementById("editLname").value = row.dataset.lname;
  document.getElementById("editLRN").value = row.dataset.lrn;
  document.getElementById("editSex").value = row.dataset.sex;
  document.getElementById("editSection").value = row.dataset.section;

  document.getElementById("editModal").style.display = "block";
}
function closeEditModal() {
  document.getElementById("editModal").style.display = "none";
}

// 💾 Save Edited Learner
function saveEditedLearner() {
  const form = document.getElementById("editLearnerForm");
  const data = new FormData(form);
  data.append("action", "edit");

  fetch("learners.php", {
    method: "POST",
    body: data,
  })
    .then((res) => res.text())
    .then((response) => {
      if (response.trim() === "success") {
        alert("Learner updated successfully!");
        location.reload();
      } else {
        alert("Error updating learner!");
      }
    });
}

// 🗑️ Open Delete Modal
function openDeleteModal(btn) {
  const row = btn.closest("tr");
  selectedLearnerID = row.dataset.id;
  document.getElementById("deleteLearnerModal").style.display = "block";
}
function closeDeleteModal() {
  document.getElementById("deleteLearnerModal").style.display = "none";
}

// 🗑️ Confirm Delete
function confirmDelete() {
  const data = new FormData();
  data.append("action", "delete");
  data.append("learnerID", selectedLearnerID);

  fetch("learners.php", {
    method: "POST",
    body: data,
  })
    .then((res) => res.text())
    .then((response) => {
      if (response.trim() === "success") {
        alert("Learner deleted successfully!");
        location.reload();
      } else {
        alert("Error deleting learner!");
      }
    });
}
