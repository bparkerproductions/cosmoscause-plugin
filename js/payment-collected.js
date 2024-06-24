// Main script for calling WP REST API to update the status about payment information.
(function () {
  document.addEventListener("DOMContentLoaded", function () {
    const $checkboxes = document.querySelectorAll(".payment-collected__status");

    $checkboxes.forEach(function (checkbox) {
      checkbox.addEventListener("change", function () {
        const entryId = this.getAttribute("data-entry-id");
        const parent = this.closest(".payment-collected");

        fetch(
          ajax_object.base_url +
            "/wp-json/cosmoscause-plugin/v1/payment-status/" +
            entryId,
          {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              "X-WP-Nonce": ajax_object.nonce,
            },
            body: JSON.stringify({
              checked: this.checked,
            }),
          }
        )
          .then((response) => response.json())
          .then((data) => {
            const notifier = parent.querySelector(
              ".payment-collected__notifier"
            );

            if (data.checked) {
              notifier.classList.remove("bg-dark-subtle");
              notifier.classList.add("bg-success");
            } else {
              notifier.classList.add("bg-dark-subtle");
              notifier.classList.remove("bg-success");
            }
            notifier.innerText = data.checkedMessage;
          })
          .catch((error) => {
            console.error("Error:", error);
          });
      });
    });
  });
})();
