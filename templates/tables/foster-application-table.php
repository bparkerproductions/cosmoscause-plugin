<?php

namespace Cosmoscause\FosterApplication;

function display_entries()
{ ?>
    <table id="foster-application-table" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th><?php esc_html_e('Entry', 'cosmoscause-plugin'); ?></th>
                <th><?php esc_html_e('Applicant(s)', 'cosmoscause-plugin'); ?></th>
                <th><?php esc_html_e('Contact', 'cosmoscause-plugin'); ?></th>
                <th><?php esc_html_e('Date', 'cosmoscause-plugin'); ?></th>

                <!-- Approved status -->
                <th><?php esc_html_e('Status', 'cosmoscause-plugin'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php generate_table_rows(); ?>
        </tbody>
    </table>
    <?php }

function generate_table_rows()
{
    $database_entries = get_posts(array(
        'post_type' => 'foster_entry',
        'posts_per_page' => -1
    ));
    foreach ($database_entries as $entry) :
        $entry_id = get_post_meta($entry->ID, '_gf_entry_id', true);
        $applicant_approval_status = get_post_meta($entry->ID, '_applicant_approval_status', true);
        $applicant_names = get_post_meta($entry->ID, '_applicant_names', true);
        $phone_number = get_post_meta($entry->ID, '_applicant_phone_number', true);
        $email = get_post_meta($entry->ID, '_applicant_email', true);
        $application_date = get_post_meta($entry->ID, '_application_signature_date', true);
        $application_url = get_post_meta($entry->ID, '_application_url', true);
        $reference_name = get_post_meta($entry->ID, '_reference_name', true);
        $reference_phone = get_post_meta($entry->ID, '_reference_phone', true);
        $vet_name = get_post_meta($entry->ID, '_veterinarian_name', true);
        $vet_phone = get_post_meta($entry->ID, '_veterinarian_phone', true); ?>

        <tr>
            <td>
                <?php include plugin_dir_path(__FILE__) . 'parts/entry-ui-buttons.php'; ?>
                <div class="table__component-container">
                    <?php include plugin_dir_path(__FILE__) . 'components/notes-section.php'; ?>
                </div>
            </td>
            <td><?= esc_html($applicant_names); ?></td>
            <td>
                <?php include plugin_dir_path(__FILE__) . 'parts/contact-info.php'; ?>
                <div>
                    <?php if ($vet_phone) : ?>
                        <a class="text-decoration-none" href="tel:<?= esc_html($vet_phone) ?>" title="Veterinarian Phone Number">
                            <span class="me-2"><i class="fa-duotone fa-phone"></i></span><?= $vet_name; ?> <span class="fst-italic fs-sm">(Veterinarian)</span>
                        </a>
                    <?php else : ?>
                        <p class="text-black-50 fst-italic">No veterinarian provided</p>
                    <?php endif; ?>
                </div>
            </td>
            <td><?= esc_html($application_date); ?></td>
            <td>
                <?php include plugin_dir_path(__FILE__) . 'parts/approve-deny-buttons.php'; ?>
            </td>
        </tr>
<?php endforeach;
}
