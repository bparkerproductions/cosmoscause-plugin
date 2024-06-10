// Main script for calling WP REST API approve/deny endpoints from plugin approve/deny buttons.
(function () {
  document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".contract-generation__button").forEach((btn) => {
      btn.addEventListener("click", function () {
        const parent = this.closest(".contract-generation");
        const linkField = parent.querySelector(".contract-generation__link");
        const linkFieldContainer = parent.querySelector(
          ".contract-generation__link-container"
        );

        if (linkFieldContainer.classList.contains("d-none"))
          linkFieldContainer.classList.remove("d-none");
        else linkFieldContainer.classList.add("d-none");

        const generatedLink = generateLink(linkField);

        // Activate the listener for sending the applicant the generated link
        const emailButton = parent.querySelector(".contract-generation__email");
        emailButton.addEventListener("click", function () {
          const recipientEmail = emailButton.getAttribute(
            "data-recipient-email"
          );

          if (recipientEmail && generatedLink) {
            sendContractLink(recipientEmail, generatedLink, parent);
          }
        });
      });
    });

    function generateLink(linkField) {
      const baseUrl = ajax_object.base_url + "/pet-application-contract/?";

      const queryParams = {
        email: linkField.getAttribute("data-email") || "",
        phone: linkField.getAttribute("data-phone-number") || "",
        applicant_name: linkField.getAttribute("data-applicant-name") || "",
        dog_name: linkField.getAttribute("data-pet-name") || "",
        address: linkField.getAttribute("data-address") || "",
      };

      const url = new URL(baseUrl);
      const params = new URLSearchParams(queryParams);

      url.search = params.toString();

      linkField.href = url.toString();

      return url.toString();
    }

    function sendContractLink(email, url, parent) {
      fetch(
        ajax_object.base_url +
          "/wp-json/cosmoscause-plugin/v1/send-contract-link/",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-WP-Nonce": ajax_object.nonce,
          },
          body: JSON.stringify({
            url,
            email,
          }),
        }
      )
        .then((response) => response.json())
        .then((data) => {
          const messegeEl = parent.querySelector(
            ".contract-generation__message"
          );
          messegeEl.classList.remove("d-none");
          messegeEl.innerText = data.message;

          if (data.status === "success") {
            messegeEl.classList.add("text-success");
          }
          if (data.status === "error") {
            messegeEl.classList.add("text-error");
          }
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    }
  });
})();
