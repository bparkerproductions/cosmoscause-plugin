// Main script for calling WP REST API approve/deny endpoints from plugin approve/deny buttons.
(function () {
  document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".contract-generation__button").forEach((btn) => {
      btn.addEventListener("click", function () {
        const parent = this.closest(".contract-generation");
        const linkField = parent.querySelector(".contract-generation__link");
        linkField.classList.remove("d-none");

        generateLink(linkField);
      });
    });

    function generateLink(linkField) {
      const baseUrl = ajax_object.base_url + "/pet-application-contract/?";

      const queryParams = {
        email: linkField.getAttribute("data-email"),
        phone: linkField.getAttribute("data-phone-number"),
        applicant_name: linkField.getAttribute("data-applicant-name"),
        dog_name: linkField.getAttribute("data-pet-name"),
      };

      const url = new URL(baseUrl);
      const params = new URLSearchParams(queryParams);

      url.search = params.toString();

      linkField.href = url.toString();
    }
  });
})();
