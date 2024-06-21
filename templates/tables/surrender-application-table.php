<?php

namespace Cosmoscause\SurrenderApplication;

function display_entries()
{ ?>
    <table id="surrender-application-table" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th><?php esc_html_e('Entry', 'cosmoscause-plugin'); ?></th>
                <th><?php esc_html_e('Applicant(s)', 'cosmoscause-plugin'); ?></th>
                <th><?php esc_html_e('Contact', 'cosmoscause-plugin'); ?></th>
                <th><?php esc_html_e('Date', 'cosmoscause-plugin'); ?></th>
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
        'post_type' => 'surrender_entry',
        'posts_per_page' => -1
    ));
    foreach ($database_entries as $entry) :
        $entry_id = get_post_meta($entry->ID, '_gf_entry_id', true);
        $applicant_names = get_post_meta($entry->ID, '_applicant_name', true);
        $pet_name = get_post_meta($entry->ID, '_pet_name', true);
        $pet_breed = get_post_meta($entry->ID, '_pet_breed', true);
        $email = get_post_meta($entry->ID, '_applicant_email', true);
        $application_date = get_post_meta($entry->ID, '_gf_entry_date', true);
        $application_url = get_post_meta($entry->ID, '_application_url', true);
        $reference_name = get_post_meta($entry->ID, '_reference_name', true);
        $reference_phone = get_post_meta($entry->ID, '_reference_phone', true);
    ?>
        <tr>
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
                    <i class="fa-light fa-dog fa-lg text-dark me-2"></i><span class="fst-italic">Surrendered: </span>
                    <span class="text-primary"><?= esc_html($pet_name) ?> (<?= esc_html($pet_breed); ?>)</span>
                </p>
            </td>
            <td>
                <?php include plugin_dir_path(__FILE__) . 'parts/contact-info.php'; ?>
            </td>
            <td><?= esc_html($application_date); ?></td>
        </tr>
<?php endforeach;
}
