// Main script for initializing plugin features
(function () {
  document.addEventListener("DOMContentLoaded", function () {
    // Initialize datatable
    var table = document.getElementById("entries-table");
    if (table) {
      new DataTable(table, {
        paging: false,
        searching: true,
        ordering: true,
      });
    }
  });
})();
