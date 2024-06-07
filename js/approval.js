// Main script for calling WP REST API approve/deny endpoints from plugin approve/deny buttons.
(function () {
  document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".approve-button").forEach(function (button) {
      button.addEventListener("click", function (e) {
        e.preventDefault();
        const postId = this.getAttribute("data-post-id");

        fetch(
          ajax_object.base_url +
            "/wp-json/cosmoscause-plugin/v1/approve-entry/" +
            postId,
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
              const parent = this.closest(".actions-container");

              const contractGeneration = parent.querySelector(
                ".contract-generation"
              );
              // Update button state and status text

              if (contractGeneration)
                contractGeneration.classList.remove("d-none");

              entryStatus(postId).textContent = "Approved";
              entryStatus(postId).style.backgroundColor = "#65c9bb";
              approvedBtn(postId).classList.add("d-none");
              deniedBtn(postId).classList.remove("d-none");
              flashMessage("This form entry has been approved!", postId);
            }
          });
      });
    });

    document.querySelectorAll(".deny-button").forEach(function (button) {
      button.addEventListener("click", function (e) {
        e.preventDefault();
        const postId = this.getAttribute("data-post-id");
        fetch(
          ajax_object.base_url +
            "/wp-json/cosmoscause-plugin/v1/deny-entry/" +
            postId,
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
              const parent = this.closest(".actions-container");
              const contractGeneration = parent.querySelector(
                ".contract-generation"
              );

              // Update button state and status text
              if (contractGeneration)
                contractGeneration.classList.add("d-none");
              approvedBtn(postId).classList.remove("d-none");
              deniedBtn(postId).classList.add("d-none");
              entryStatus(postId).textContent = "Denied";
              entryStatus(postId).style.backgroundColor = "#ff4e4e";

              flashMessage("This form entry has been denied.", postId);
            }
          });
      });
    });

    // Hide/show functionality for the deny/approve change status buttons
    document
      .querySelectorAll(".approve-buttons__change-status")
      .forEach(function (button) {
        button.addEventListener("click", function () {
          const parent = this.closest(".approve-buttons");
          const buttonContainer = parent.querySelector(
            ".approve-buttons__buttons"
          );

          // Toggle buttons
          if (buttonContainer.classList.contains("d-none")) {
            buttonContainer.classList.remove("d-none");
            buttonContainer.classList.add("d-flex");
          } else {
            buttonContainer.classList.add("d-none");
            buttonContainer.classList.remove("d-flex");
          }
        });
      });

    // Selector functions
    function entryStatus(id) {
      return document.querySelector(`.entry-status[data-for-post="${id}"]`);
    }

    function approvedBtn(id) {
      return document.querySelector(`.approve-button[data-post-id="${id}"]`);
    }

    function deniedBtn(id) {
      return document.querySelector(`.deny-button[data-post-id="${id}"]`);
    }

    // Helper functions
    function flashMessage(message, postId) {
      const messageEl = document.querySelector(
        `.button-alert-message[data-for-post="${postId}"]`
      );
      messageEl.textContent = message;
      messageEl.classList.remove("d-none");

      setTimeout(function () {
        messageEl.classList.add("d-none");
      }, 1500);
    }
  });
})();
