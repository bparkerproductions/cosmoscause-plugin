<div class="pb-2 border-bottom mb-2">
    <a class="me-2 text-decoration-none" href="mailto:<?= esc_html($email) ?>" title="Applicant Email">
        <span class="me-2"><i class="fa-sharp fa-light fa-envelope"></i></span>Email
    </a>
    <a class="text-decoration-none" href="tel:<?= esc_html($phone_number) ?>" title="Applicant Phone Number">
        <span class="me-2"><i class="fa-duotone fa-phone"></i></span>Phone
    </a>
</div>
<div class="my-1">
    <?php if ($reference_name) : ?>
        <a class="text-decoration-none" href="tel:<?= esc_html($reference_phone) ?>" title="Reference Phone Number">
            <span class=" me-2"><i class="fa-duotone fa-phone"></i></span><?= $reference_name ?>
            <span class="fst-italic fs-sm">(Reference)</span>
        </a>
    <?php else : ?>
        <p class="text-black-50 fst-italic">No reference provided</p>
    <?php endif; ?>
</div>