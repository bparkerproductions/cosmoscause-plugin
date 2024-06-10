<div class="contract-generation <?= $applicant_approval_status !== 'Approved' ? 'd-none' : ''; ?>">
    <hr>
    <div class="mt-2">
        <button role="button" class="btn btn-sm btn-info text-white contract-generation__button">
            <span class="me-2"><i class="fa-light fa-file-signature"></i></span>Get Contract Link
        </button>

        <div class="d-none contract-generation__link-container mt-2">
            <div>
                <a data-address="<?= $applicant_address; ?>" data-phone-number="<?= $phone_number; ?>" data-email="<?= $email; ?>" data-applicant-name="<?= $applicant_names; ?>" data-pet-name="<?= $pet_name ?>" target="_blank" class="contract-generation__link" href="#" title="Open Contract Link">
                    <i class="fa-regular fa-arrow-up-right-from-square me-2 fa-sm text-dark"></i>Get Contract Link</i>
                </a>

                <a class="contract-generation__email d-block mt-2 cursor-pointer" data-recipient-email="<?= $email; ?>" title="Send contract link to <?= $email; ?>">
                    <span class="me-2"><i class="fa-solid fa-envelope fa-lg text-primary"></i></span>Send Contract Link
                </a>

            </div>
            <p class="fs-sm contract-generation__message d-none mt-2"></p>
        </div>
    </div>
</div>