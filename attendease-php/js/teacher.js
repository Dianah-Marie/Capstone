// ==========================
//   Add Teacher Modal Logic
// ==========================
function openModal() {
  document.getElementById("addTeacherModal").style.display = "flex";
}
function closeModal() {
  document.getElementById("addTeacherModal").style.display = "none";
}

// Optional: close modal when clicking outside
window.addEventListener("click", function (e) {
  const modal = document.getElementById("addTeacherModal");
  if (e.target === modal) {
    modal.style.display = "none";
  }
});

// ==========================
//   🎓 Edit Teacher Modal
// ==========================

// 🔹 Open and populate the Edit Modal
function teacherEditModal(button) {
  const userID = button.getAttribute("data-id");
  const row = button.closest("tr");

  // Extract data from the table row
  const username = row.cells[0].textContent.trim();
  const fullName = row.cells[1].textContent.trim();
  const email = row.cells[2].textContent.trim();
  const accountType = row.cells[3].textContent.trim();

  // Fill modal fields
  document.getElementById("editUserID").value = userID;
  document.getElementById("editUsername").value = username;
  document.getElementById("editFullName").value = fullName;
  document.getElementById("editEmail").value = email;
  document.getElementById("editAccountType").value = accountType;

  // Show the modal
  document.getElementById("editModal").style.display = "flex";
}

// 🔹 Close modal function
function closeEditModal() {
  document.getElementById("editModal").style.display = "none";
}

// 🔹 Optional: Close modal when clicking outside
window.addEventListener("click", function (e) {
  const modal = document.getElementById("editModal");
  if (e.target === modal) {
    modal.style.display = "none";
  }
});

// 🔹 Save edits (AJAX request to update.php)
function saveEdit() {
  const userID = document.getElementById("editUserID").value;
  const username = document.getElementById("editUsername").value.trim();
  const fullName = document.getElementById("editFullName").value.trim();
  const email = document.getElementById("editEmail").value.trim();
  const accountType = document.getElementById("editAccountType").value;

  if (!username || !fullName || !email) {
    alert("Please fill in all fields before saving.");
    return;
  }

  // Prepare data to send
  const formData = new FormData();
  formData.append("user_ID", userID);
  formData.append("username", username);
  formData.append("fullName", fullName);
  formData.append("email", email);
  formData.append("accountType", accountType);

  // ✅ Send AJAX request to update
  fetch("update_teacher.php", {
    method: "POST",
    body: formData,
  })
    .then(response => response.text())
    .then(data => {
      alert(data); // Show success message from PHP
      location.reload(); // Reload page to reflect changes
    })
    .catch(error => console.error("Error:", error));
}


// ==========================
//   🎓 Delete Teacher Modal
// ==========================

let deleteUserId = null;

// 🗑️ Show modal and store ID
function teacherDeleteModal(userId) {
  deleteUserId = userId;
  document.getElementById("deleteModal").style.display = "flex";
}

// ❌ Close modal
function closeDeleteModal() {
  document.getElementById("deleteModal").style.display = "none";
  deleteUserId = null;
}

// ✅ Confirm deletion → redirect to PHP
function confirmDelete() {
  if (deleteUserId) {
    window.location.href = "teacher.php?user_ID=" + deleteUserId;
  }
}