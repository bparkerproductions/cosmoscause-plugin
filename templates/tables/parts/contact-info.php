<div class="pb-2 border-bottom mb-2">
    <?php if (isset($email) && $email) : ?>
        <div class="mb-2">
            <span class="mb-1 fa-lg text-dark d-block"><i class="fa-sharp fa-light fa-envelope"></i></span>
            <a class="me-2 text-decoration-none" href="mailto:<?= esc_html($email) ?>" title="Applicant Email">
                <?= esc_html($email); ?>
            </a>
        </div>
    <?php endif; ?>

    <?php if (isset($phone_number) && $phone_number) : ?>

        <div>
            <span class="mb-1 fa-lg text-dark d-block"><i class="fa-duotone fa-phone"></i></span>
            <a class="text-decoration-none" href="tel:<?= esc_html($phone_number) ?>" title="Applicant Phone Number">
                <?= esc_html($phone_number) ?>
            </a>
        </div>

    <?php endif; ?>
</div>

<?php if (isset($reference_name)) : ?>
    <div class="my-1">
        <?php if ($reference_name) : ?>
            <a class="text-decoration-none" href="tel:<?= esc_html($reference_phone) ?>" title="Reference Phone Number">
                <span class=" me-2"><i class="fa-duotone fa-phone"></i></span><?= $reference_name ?>
                <span class="fst-italic fs-sm">(Reference)</span>
            </a>
        <?php else : ?>
            <p class="text-black-50 fst-italic mb-1">No reference provided</p>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php if (isset($vet_phone)) : ?>
    <div class="my-1">
        <?php if ($vet_phone) : ?>
            <a class="text-decoration-none" href="tel:<?= esc_html($vet_phone) ?>" title="Veterinarian Phone Number">
                <span class="me-2"><i class="fa-duotone fa-phone"></i></span><?= $vet_name; ?> <span class="fst-italic fs-sm">(Veterinarian)</span>
            </a>
        <?php else : ?>
            <p class="text-black-50 fst-italic mb-1">No veterinarian provided</p>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php if (isset($landlord_phone)) : ?>
    <div class="my-1">
        <?php if ($landlord_phone) : ?>
            <a class="text-decoration-none" href="tel:<?= esc_html($landlord_phone) ?>" title="Landlord Phone Number">
                <span class="me-2"><i class="fa-duotone fa-phone"></i></span><?= $landlord_name; ?> <span class="fst-italic fs-sm">(Landlord)</span>
            </a>
        <?php else : ?>
            <p class="text-black-50 fst-italic mb-1">No landlord provided</p>
        <?php endif; ?>
    </div>
<?php endif; ?>