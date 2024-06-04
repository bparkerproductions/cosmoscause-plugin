<?php

/**
 * This part links to the GF entry and has UI buttons that toggle the checklist and notes component. 
 */
?>

<div class="d-flex flex-column">
    <a class="text-decoration-none" href="<?= esc_url($application_url) ?>" target="_blank">
        <i class="fa-regular fa-arrow-up-right-from-square"></i> <?= $entry_id ?>
    </a>

    <!-- Toggle UI Buttons -->
    <!-- <button class="btn btn-sm btn-info text-white my-1 d-flex justify-content-start align-items-center" data-bs-toggle="collapse" href="#checklist-container<?= $entry->ID; ?>" role="button">
        <i class="fa-regular fa-list-check me-2"></i>Checklist
    </button> -->

    <button class="btn btn-sm btn-info text-white my-1 d-flex justify-content-start align-items-center open-notes-btn" data-bs-toggle="collapse" href="#note-container<?= $entry->ID; ?>" data-entry-id="<?= $entry->ID; ?>" role="button">
        <i class="fa-light fa-notes me-2"></i>Notes
    </button>
</div>