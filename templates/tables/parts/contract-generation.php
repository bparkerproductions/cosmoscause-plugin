<div class="contract-generation <?= $applicant_approval_status !== 'Approved' ? 'd-none' : ''; ?>">
    <hr>
    <div class="mt-2">
        <button role="button" class="btn btn-sm btn-info text-white contract-generation__button">Get Contract Link</button>

        <div class="d-none contract-generation__link-container mt-2">
            <div class="d-flex align-items-center">
                <i class="fa-regular fa-arrow-up-right-from-square me-2 fa-sm text-dark"></i>
                <a data-address="<?= $applicant_address; ?>" data-phone-number="<?= $phone_number; ?>" data-email="<?= $email; ?>" data-applicant-name="<?= $applicant_names; ?>" data-pet-name="<?= $pet_name ?>" target="_blank" class="contract-generation__link" href="#" title="Open Contract Link"> Contract Link</a>

                <span class="contract-generation__email ms-2 cursor-pointer" data-recipient-email="<?= $email; ?>" title="Send contract link to <?= $email; ?>"><i class="fa-solid fa-envelope fa-2x text-info"></i></span>
            </div>
            <p class="fs-sm contract-generation__message d-none mt-2"></p>
        </div>
    </div>
</div>