<?php
function display_pet_application_entries()
{ ?>
    <table id="entries-table" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th><?php esc_html_e('Entry', 'cosmoscause-plugin'); ?></th>
                <th><?php esc_html_e('Applied for', 'cosmoscause-plugin'); ?></th>
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
        'post_type' => 'application_entry',
        'posts_per_page' => -1
    ));
    foreach ($database_entries as $entry) :

        $entry_id = get_post_meta($entry->ID, '_gf_entry_id', true);
        $applicant_approval_status = get_post_meta($entry->ID, '_applicant_approval_status', true);
        $pet_name = get_post_meta($entry->ID, '_pet_name', true);
        $applicant_names = get_post_meta($entry->ID, '_applicant_names', true);
        $phone_number = get_post_meta($entry->ID, '_applicant_phone_number', true);
        $email = get_post_meta($entry->ID, '_applicant_email', true);
        $application_date = get_post_meta($entry->ID, '_application_date', true);
        $application_url = get_post_meta($entry->ID, '_application_url', true); ?>
        <tr>
            <td>
                <a class="text-decoration-none" href="<?= esc_url($application_url) ?>" target="_blank">
                    <i class="fa-regular fa-arrow-up-right-from-square"></i> <?= $entry_id ?>
                </a>
            </td>
            <td><?= esc_html($pet_name) ?></td>
            <td><?= esc_html($applicant_names); ?></td>
            <td>
                <a class="me-2 text-decoration-none" href="mailto:<?= esc_html($email) ?>">
                    <span class="me-2"><i class="fa-sharp fa-light fa-envelope"></i></span>Email
                </a>
                <a class="text-decoration-none" href="tel:<?= esc_html($phone_number) ?>">
                    <span class="me-2"><i class="fa-duotone fa-phone"></i></span>Phone
                </a>
            </td>
            <td><?= esc_html($application_date); ?></td>
            <td>
                <?php include plugin_dir_path(__FILE__) . 'approve-deny-buttons.php'; ?>
            </td>
        </tr>
<?php endforeach;
}