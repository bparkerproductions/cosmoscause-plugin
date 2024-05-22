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
    <div class="alert bg-info text-white mb-5">
        <h1 class="text-white"><?php esc_html_e('Cosmos Cause Database', 'cosmoscause'); ?></h1>
        <p><?php esc_html_e('Manage form submissions, applicants, and more.'); ?></p>
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
    <?php endif;

    foreach ($entries as $entry) :
        // 4 = Pet Name
        // 48 = Applicant name(s)
        $pet_name = rgar($entry, 4);
        $applicant_names = rgar($entry, 48); ?>
        <p><?= esc_html($pet_name) ?></p>

        <p><?= list_items($applicant_names); ?></p>
<?php endforeach;
}

function list_items($items)
{
    if (empty($items)) {
        return '';
    }

    if (is_serialized($items)) {
        $items = maybe_unserialize($items);
    }

    return esc_html(implode(', ', $items,));
}
