<div id="note-container<?= $entry->ID ?>" class="my-2 collapse">
    <div class="bg-info rounded p-3">
        <h5 class="pb-2 border-bottom text-light">
            <i class="fa-light fa-notes me-2 fa-2x"></i>Notes for <?= $applicant_names; ?>
        </h5>

        <div class="my-2">
            <?php
            $note_content = get_post_meta($entry->ID, '_entry_notes', true); ?>
            <textarea id="custom_editor<?= $entry->ID ?>" data-stored-content="<?= $note_content ?>"></textarea>
            <div class="mt-2">
                <button class="btn btn-light note-save-button position-relative" data-entry-id="<?= $entry->ID ?>" role="button">
                    <i class="fa-solid fa-floppy-disk text-dark me-2"></i>Save Notes
                    <span class="btn__loader"><i class="fa-regular fa-loader fa-spin"></i></span>
                </button>
                <p data-entry-id="<?= $entry->ID; ?>" class="notes__save-message mt-2 text-white mb-0 d-none">Notes saved.</p>
            </div>
        </div>

        <div class="mt-4">
            <button class="btn btn-sm btn-light" data-bs-toggle="collapse" href="#note-container<?= $entry->ID; ?>" role="button"><i class="fa-solid fa-circle-xmark me-2 text-dark"></i>Close</button>
        </div>
    </div>
</div>