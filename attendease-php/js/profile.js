document.addEventListener("DOMContentLoaded", function () {
  const editBtn = document.getElementById("openEditModal");
  const modal = document.getElementById("editModal");
  const closeBtn = document.getElementById("closeEditModal");
  const cancelBtn = document.getElementById("cancelEdit");

  // Open modal
  editBtn.addEventListener("click", function () {
    modal.style.display = "flex";
  });

  // Close modal
  closeBtn.addEventListener("click", function () {
    modal.style.display = "none";
  });
  cancelBtn.addEventListener("click", function () {
    modal.style.display = "none";
  });

  // Close when clicking outside
  window.addEventListener("click", function (event) {
    if (event.target === modal) {
      modal.style.display = "none";
    }
  });

  // Form validation
  document.getElementById("editForm").addEventListener("submit", function (e) {
    e.preventDefault();
    const newPass = document.getElementById("newPassword").value;
    const confirmPass = document.getElementById("confirmPassword").value;

    if (newPass !== confirmPass) {
      alert("Passwords do not match!");
      return;
    }

    alert("✅ Password updated successfully!");
    modal.style.display = "none";
  });
});
