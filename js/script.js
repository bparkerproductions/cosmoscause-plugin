// Main script for initializing plugin features
(function () {
  document.addEventListener("DOMContentLoaded", function () {
    console.log("called from script");
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
