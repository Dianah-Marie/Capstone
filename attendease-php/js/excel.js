document.addEventListener("DOMContentLoaded", function () {
  const reportBtn = document.getElementById("generateReport");
  const modal = document.getElementById("reportModal");
  const cancelBtn = document.getElementById("cancelReport");
  const confirmBtn = document.getElementById("confirmReport");
  

  // Open modal
  reportBtn.addEventListener("click", () => {
    modal.style.display = "flex";
  });

  // Cancel modal
  cancelBtn.addEventListener("click", () => {
    modal.style.display = "none";
  });

  // Confirm generate
  confirmBtn.addEventListener("click", () => {
    modal.style.display = "none";

    // ✅ Get table
    const table = document.querySelector(".styled-table");
    if (!table) {
      alert("No table data found!");
      return;
    }

    // ✅ Convert table to a worksheet
    const wb = XLSX.utils.book_new();
    const ws = XLSX.utils.table_to_sheet(table);

    // ✅ Append worksheet to workbook
    XLSX.utils.book_append_sheet(wb, ws, "Class List");

    // ✅ Export to Excel
    XLSX.writeFile(wb, "Class_List_Report.xlsx");

  });

  // Optional: close modal when clicking outside
  window.addEventListener("click", (e) => {
    if (e.target === modal) modal.style.display = "none";
  });
});
