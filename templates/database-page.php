<?php
// Ensure this file is included in WordPress
if (!defined('ABSPATH')) {
    exit;
}

// Check for user capabilities
if (!current_user_can('manage_options')) {
    return;
}

?>
<div class="wrap">
    <div class="alert bg-info text-white mb-2">
        <div class="row">
            <div class="col-lg-2">
                <img id="site-logo" class="w-100" src="<?= get_field('site_main_logo', 'option')['url'] ?>" />
            </div>
            <div class="col d-flex flex-column align-items-start justify-content-center">
                <h1 class="text-white"><?php esc_html_e('Cosmos Cause Database', 'cosmoscause'); ?></h1>
                <p><?php esc_html_e('Manage form submissions, applicants, and more.'); ?></p>
            </div>
        </div>
    </div>

    <section>
        <?php display_pet_application_entries(); ?>
    </section>
</div>

<?php
function display_pet_application_entries()
{
    if (!class_exists('GFAPI')) : ?>
        <p><?= esc_html__('Gravity Forms API is not available.', 'cosmoscause-plugin') ?></p>
    <?php endif; ?>

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
        'post_type' => 'database_entry',
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
