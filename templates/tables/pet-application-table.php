<?php

namespace Cosmoscause\PetApplication;

function display_entries()
{ ?>
    <div class="table-responsive">
        <table id="pet-application-table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th><?php esc_html_e('Entry', 'cosmoscause-plugin'); ?></th>
                    <th><?php esc_html_e('Applicant(s)', 'cosmoscause-plugin'); ?></th>
                    <th><?php esc_html_e('Contact', 'cosmoscause-plugin'); ?></th>
                    <th><?php esc_html_e('Date', 'cosmoscause-plugin'); ?></th>
                    <th><?php esc_html_e('Status', 'cosmoscause-plugin'); ?></th>
                    <th><?php esc_html_e('Payment', 'cosmoscause-plugin'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php generate_table_rows(); ?>
            </tbody>
        </table>
    </div>
    <?php }

function generate_table_rows()
{
    $database_entries = get_posts(array(
        'post_type' => 'application_entry',
        'posts_per_page' => -1
    ));
    foreach ($database_entries as $entry) :

        $entry_id = get_post_meta($entry->ID, '_gf_entry_id', true);
        $applicant_approval_status = get_post_meta($entry->ID, '_applicant_approval_status', true);
        $pet_name = get_post_meta($entry->ID, '_pet_name', true);
        $applicant_names = get_post_meta($entry->ID, '_applicant_names', true);
        $applicant_address = get_post_meta($entry->ID, '_applicant_address', true);
        $phone_number = get_post_meta($entry->ID, '_applicant_phone_number', true);
        $email = get_post_meta($entry->ID, '_applicant_email', true);
        $application_date = get_post_meta($entry->ID, '_gf_entry_date', true);
        $reference_name = get_post_meta($entry->ID, '_reference_name', true);
        $reference_phone = get_post_meta($entry->ID, '_reference_phone', true);
        $veterinatian_list = unserialize(get_post_meta($entry->ID, '_veterinarian_list', true));
        $application_url = get_post_meta($entry->ID, '_application_url', true);
        $payment_status = get_post_meta($entry->ID, '_payment_status', true);
        $landlord_name = get_post_meta($entry->ID, '_landlord_name', true);
        $landlord_phone = get_post_meta($entry->ID, '_landlord_phone', true);
    ?>
        <tr class="position-relative">
            <td>
                <?php include plugin_dir_path(__FILE__) . 'parts/entry-ui-buttons.php'; ?>
                <div class="table__component-container">
                    <?php include plugin_dir_path(__FILE__) . 'components/notes-section.php'; ?>
                </div>
            </td>
            <td>
                <p>
                    <i class="fa-light fa-user-pen fa-lg text-dark me-2"></i><?= esc_html($applicant_names); ?>
                </p>
                <p>
                    <i class="fa-light fa-dog fa-lg text-dark me-2"></i><span class="fst-italic">Applied for: </span>
                    <span class="text-primary"><?= esc_html($pet_name) ?></span>
                </p>
            </td>
            <td style="overflow-x: auto;">
                <?php include plugin_dir_path(__FILE__) . 'parts/contact-info.php'; ?>

                <div class=" my-1">
                    <?php if ($veterinatian_list !== false) :
                        foreach ($veterinatian_list as $vet) :
                            $veterinatian_name = $vet['Name'];
                            $veterinatian_phone = $vet['Phone Number']; ?>
                            <a class="me-2 text-decoration-none" href="tel:<?= esc_html($veterinatian_phone) ?>" title="Veterinarian Phone Number">
                                <span class="me-2"><i class="fa-duotone fa-phone"></i></span><?= $veterinatian_name ?> <span class="fst-italic fs-sm">(Veterinarian)</span>
                            </a>
                        <?php endforeach;
                    else : ?>
                        <p class="text-black-50 fst-italic">No veterinarian provided</p>
                    <?php endif; ?>
                </div>
            </td>
            <td>
                <span class="fst-italic fs-sm"><?= esc_html($application_date); ?></span>
            </td>
            <td>
                <div class="actions-container">
                    <?php
                    include plugin_dir_path(__FILE__) . 'parts/approve-deny-buttons.php';
                    include plugin_dir_path(__FILE__) . 'parts/contract-generation.php';
                    ?>
                </div>
            </td>
            <td>
                <div class="payment-collected">
                    <?php
                    $payment_notifier_class = $payment_status === 'collected' ? 'bg-success' : 'bg-dark-subtle';
                    $payment_checked = $payment_status === 'collected' ? 'checked' : '';
                    ?>
                    <span class="mb-2 badge d-block <?= $payment_notifier_class; ?> payment-collected__notifier"><?= esc_html($payment_status); ?></span>
                    <input class="form-check-input payment-collected__status" type="checkbox" value="" id="paymentCheck" data-entry-id="<?= $entry->ID; ?>" <?= $payment_checked; ?>>
                    <label class="form-check-label" for="flexCheckDefault">
                        Payment Collected
                    </label>
                </div>
            </td>
        </tr>

<?php endforeach;
}
