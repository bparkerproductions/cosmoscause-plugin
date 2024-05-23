// Main script for calling WP REST API approve/deny endpoints from plugin approve/deny buttons.
(function () {
  document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".approve-button").forEach(function (button) {
      button.addEventListener("click", function () {
        var entryId = this.getAttribute("data-entry-id");
        fetch(
          ajax_object.base_url +
            "/wp-json/cosmoscause-plugin/v1/approve-entry/" +
            entryId,
          {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              "X-WP-Nonce": ajax_object.nonce,
            },
          }
        )
          .then((response) => response.json())
          .then((data) => {
            if (data.status === "Approved") {
              alert("Entry Approved");
              //   location.reload();
            } else {
              alert("Failed to approve entry");
            }
          });
      });
    });

    document.querySelectorAll(".deny-button").forEach(function (button) {
      button.addEventListener("click", function () {
        var entryId = this.getAttribute("data-entry-id");
        fetch(
          ajax_object.base_url +
            "/wp-json/cosmoscause-plugin/v1/deny-entry/" +
            entryId,
          {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              "X-WP-Nonce": ajax_object.nonce,
            },
          }
        )
          .then((response) => response.json())
          .then((data) => {
            if (data.status === "Denied") {
              alert("Entry Denied");
              //   location.reload();
            } else {
              alert("Failed to deny entry");
            }
          });
      });
    });
  });
})();
