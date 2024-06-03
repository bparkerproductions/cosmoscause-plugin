// Main script for calling WP REST API to save note content for each form database entry.
(function () {
  document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".note-save-button").forEach(function (button) {
      button.addEventListener("click", function (e) {
        e.preventDefault();
        this.classList.add("btn__loader-active");

        const entryId = this.getAttribute("data-entry-id");
        const noteContent = tinyMCE.get("custom_editor" + entryId).getContent();

        fetch(
          ajax_object.base_url +
            "/wp-json/cosmoscause-plugin/v1/save-notes/" +
            entryId,
          {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              "X-WP-Nonce": ajax_object.nonce,
            },
            body: JSON.stringify({
              noteContent,
            }),
          }
        )
          .then((response) => response.json())
          .then((data) => {
            const saveMsg = document.querySelector(".notes__save-message");

            // Display success message after a second of "loading"
            setTimeout(
              function () {
                this.classList.remove("btn__loader-active");
                saveMsg.classList.remove("d-none");
              }.bind(this),
              350
            );

            // Clear success message after a couple of seconds
            setTimeout(function () {
              saveMsg.classList.add("d-none");
            }, 1500);
          })
          .catch((error) => {
            console.error("Error:", error);
          });
      });
    });

    // When the notes open, we then want to initialize all tinyMCE instances
    // Instead of loading them all at once.
    document.querySelectorAll(".open-notes-btn").forEach((btn) => {
      btn.addEventListener("click", function () {
        entryId = this.getAttribute("data-entry-id");
        const textarea = document.querySelector(
          "textarea#custom_editor" + entryId
        );
        const noteContent = textarea.getAttribute("data-stored-content");

        // Initialize tinyMCE
        tinyMCE.init({
          selector: "#custom_editor" + entryId,
          menubar: false,
          toolbar:
            "bold italic underline strikethrough | formatselect | bullist numlist | undo redo",
          plugins: "lists",
          height: 300,
          setup: function (editor) {
            editor.on("init", function () {
              if (noteContent) {
                editor.setContent(noteContent);
              }
            });
          },
        });
      });
    });
  });
})();
