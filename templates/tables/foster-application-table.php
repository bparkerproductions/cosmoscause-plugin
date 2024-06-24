<?php

namespace Cosmoscause\FosterApplication;

function display_entries()
{ ?>
    <div class="table-responsive">
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
    </div>
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
        $application_date = get_post_meta($entry->ID, '_gf_entry_date', true);
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
            <td style="overflow-x: auto;>
                <?php include plugin_dir_path(__FILE__) . 'parts/contact-info.php'; ?>
            </td>
            <td><?= esc_html($application_date); ?></td>
            <td>
                <div class=" actions-container">
                <?php include plugin_dir_path(__FILE__) . 'parts/approve-deny-buttons.php'; ?>
                </div>
            </td>
        </tr>
<?php endforeach;
}
