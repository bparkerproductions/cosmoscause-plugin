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
    <?php endif;

    // Get pet application form
    $form_id = 1;


    // Get entries for the current form
    $search_criteria = array();
    $sorting = array();
    $paging = array('offset' => 0, 'page_size' => 100);
    $entries = GFAPI::get_entries($form_id, $search_criteria, $sorting, $paging);

    if (is_wp_error($entries)) : ?>
        <p><?= esc_html__('Error fetching entries: ', 'cosmoscause-plugin') . $entries->get_error_message() ?></p>
    <?php endif;

    if (empty($entries)) : ?>
        <p><?= esc_html__('No entries found.', 'cosmoscause-plugin') ?></p>
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
            <?php generate_table_rows($entries, $form_id); ?>
        </tbody>
    </table>
    <?php }

function generate_table_rows($entries, $form_id)
{
    foreach ($entries as $entry) : $entry_id = $entry['id']; ?>
        <tr data-id="<?= $entry_id; ?>">
            <?php
            // 4 = Pet Name
            // 48 = Applicant name(s)
            // 47 = Date of application
            // 7 = Phone number
            // 8 = Email
            $pet_name = rgar($entry, 4);
            $applicant_names = rgar($entry, 48);
            $todays_date = rgar($entry, 47);
            $phone_number = rgar($entry, 7);
            $email = rgar($entry, 8);
            $entry_url = admin_url("admin.php?page=gf_entries&view=entry&id={$form_id}&lid={$entry_id}"); ?>
            <td>
                <a class="text-decoration-none" href="<?= esc_url($entry_url) ?>" target="_blank">
                    <i class="fa-regular fa-arrow-up-right-from-square"></i> <?= $entry_id ?>
                </a>
            </td>
            <td><?= esc_html($pet_name) ?></td>
            <td><?= list_items($applicant_names); ?></td>
            <td>
                <a class="me-2 text-decoration-none" href="mailto:<?= esc_html($email) ?>">
                    <span class="me-2"><i class="fa-sharp fa-light fa-envelope"></i></span>Email
                </a>
                <a class="text-decoration-none" href="tel:<?= esc_html($phone_number) ?>">
                    <span class="me-2"><i class="fa-duotone fa-phone"></i></span>Phone
                </a>
            </td>
            <td><?= esc_html($todays_date); ?></td>
            <td>
                <div class="d-flex flex-column align-items-start">
                    <span class="badge bg-info mb-2">Undecided</span>
                    <div>
                        <button class="btn btn-sm btn-success text-white approve-button" data-entry-id="<?= esc_attr($entry_id); ?>">
                            <span class="me-2"><i class="fa-regular fa-check"></i></span>Approve
                        </button>
                        <button class="btn btn-sm btn-danger text-white deny-button" data-entry-id="<?= esc_attr($entry_id); ?>">
                            <span class=" me-2"><i class="fa-regular fa-xmark"></i></span>Deny
                        </button>
                    </div>
                </div>
            </td>
        </tr>
<?php endforeach;
}
