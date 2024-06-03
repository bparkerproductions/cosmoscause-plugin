<div class="d-flex flex-column align-items-start approve-buttons">
    <span class="entry-status badge mb-2 <?= strtolower($applicant_approval_status); ?>" data-for-post="<?= $entry->ID; ?>">
        <?= esc_html($applicant_approval_status) ?>
    </span>

    <p class="mt-2 mb-0 pb-1 fw-bold cursor-pointer approve-buttons__change-status">Change Status</p>
    <div class="approve-buttons__buttons flex-column d-none">
        <button class="btn btn-sm btn-success text-white approve-button <?= $applicant_approval_status == 'Approved' ? 'd-none' : ''; ?>" data-post-id="<?= $entry->ID; ?>" title="Approve this entry.">
            <span class=" me-2"><i class="fa-regular fa-check"></i></span>Approve
        </button>
        <button class="btn btn-sm btn-danger text-white deny-button <?= $applicant_approval_status == 'Denied' ? 'd-none' : ''; ?>" data-post-id="<?= $entry->ID; ?>" title="Deny this entry.">
            <span class=" me-2"><i class="fa-regular fa-xmark"></i></span>Deny
        </button>
    </div>
    <p class="button-alert-message d-none mb-0 mt-2 text-info" data-for-post="<?= $entry->ID; ?>">Alert Message</p>
</div>