// Main script for initializing plugin features

(function () {
  document.addEventListener("DOMContentLoaded", function () {
    initializeDataTables();

    // Initialize pet application and foster application datatables
    function initializeDataTables() {
      const petApplicationTable = document.getElementById(
        "pet-application-table"
      );
      if (petApplicationTable) {
        new DataTable(petApplicationTable, {
          paging: false,
          searching: true,
          ordering: true,
        });
      }

      // Initialize foster application datatable
      const fosterApplicationTable = document.getElementById(
        "foster-application-table"
      );
      if (fosterApplicationTable) {
        new DataTable(fosterApplicationTable, {
          paging: false,
          searching: true,
          ordering: true,
        });
      }
    }
  });
})();
