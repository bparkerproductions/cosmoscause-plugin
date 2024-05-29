// Main script for calling WP REST API approve/deny endpoints from plugin approve/deny buttons.
(function () {
  document.addEventListener("DOMContentLoaded", function () {
    console.log("test");
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
              const entryStatus = document.querySelector(
                `.entry-status[data-for-post="${postId}"]`
              );
              const approvedBtn = document.querySelector(
                `.approve-button[data-post-id="${postId}"]`
              );
              const deniedBtn = document.querySelector(
                `.deny-button[data-post-id="${postId}"]`
              );

              // Update button state and status text
              entryStatus.textContent = "Approved";
              entryStatus.style.backgroundColor = "#65c9bb";
              approvedBtn.classList.add("d-none");
              deniedBtn.classList.remove("d-none");
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
              const entryStatus = document.querySelector(
                `.entry-status[data-for-post="${postId}"]`
              );
              const approvedBtn = document.querySelector(
                `.approve-button[data-post-id="${postId}"]`
              );
              const deniedBtn = document.querySelector(
                `.deny-button[data-post-id="${postId}"]`
              );

              // Update button state and status text
              approvedBtn.classList.remove("d-none");
              deniedBtn.classList.add("d-none");
              entryStatus.textContent = "Denied";
              entryStatus.style.backgroundColor = "#ff4e4e";

              flashMessage("This form entry has been denied.", postId);
            }
          });
      });
    });

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
