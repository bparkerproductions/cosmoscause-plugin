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
          autoWidth: false,
          columnDefs: [
            { targets: 0, width: "100px" },
            { targets: 1, width: "150px" },
            { targets: 2, width: "150px" },
            { targets: 3, width: "100px" },
            { targets: 4, width: "150px" },
            { targets: 5, width: "150px" },
          ],
          initComplete: function () {
            const url = new URL(window.location.href);
            const searchParams = new URLSearchParams(url.search);
            const searchValue = searchParams.get("search");
            if (searchValue) {
              this.api().search(searchValue).draw();
            }
          },
          order: [[3, "desc"]],
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
          autoWidth: false,
          columnDefs: [
            { targets: 0, width: "100px" },
            { targets: 1, width: "150px" },
            { targets: 2, width: "150px" },
            { targets: 3, width: "100px" },
            { targets: 4, width: "150px" },
          ],
          order: [3, "desc"],
        });
      }

      // Initialize the surrender application datatable
      const surrenderApplicationTable = document.getElementById(
        "surrender-application-table"
      );
      if (surrenderApplicationTable) {
        new DataTable(surrenderApplicationTable, {
          paging: false,
          searching: true,
          ordering: true,
          autoWidth: false,
          columnDefs: [
            { targets: 0, width: "100px" },
            { targets: 1, width: "150px" },
            { targets: 2, width: "150px" },
            { targets: 3, width: "100px" },
          ],
          order: [3, "desc"],
        });
      }
    }
  });
})();
