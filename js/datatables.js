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
        const table = new DataTable(petApplicationTable, {
          paging: false,
          searching: true,
          ordering: true,
          order: [[0, "desc"]],
          initComplete: function (settings, json) {
            setInitialSearch();
          },
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
          order: [0, "desc"],
        });
      }
    }

    function setInitialSearch() {
      const url = new URL(window.location.href);
      const searchParams = new URLSearchParams(url.search);
      const searchValue = searchParams.get("search");
      if (searchValue) {
        this.api().search(searchValue).draw();
      }
    }
  });
})();
