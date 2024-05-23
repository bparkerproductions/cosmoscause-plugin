<?php

if (!defined('ABSPATH')) {
    exit;
}

add_action('admin_menu', 'my_custom_plugin_add_admin_page');

function my_custom_plugin_add_admin_page()
{
    add_menu_page(
        'Cosmos Cause Database',
        'Cosmos Cause Database',
        'manage_options',
        'database',
        'database_page_content',
        'dashicons-database-view',
        20
    );
}

// Display a comma separated list for table data with multiple items
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

/**
 * Before displaying the datatable, make sure each entry has a CPT that
 * post meta can be stored to. This CPT is only really used for storing data.
 */
function cosmoscause_sync_gf_entries_to_cpt()
{
    if (!class_exists('GFAPI')) {
        return;
    }

    $form_id = 1;
    $paging = array('offset' => 0, 'page_size' => 200); // Adjust as needed

    $entries = GFAPI::get_entries($form_id, array(), array(), $paging);

    foreach ($entries as $entry) {
        $entry_id = $entry['id'];

        // Check if a CPT already exists for this entry
        $existing_post_id = get_posts(array(
            'post_type' => 'database_entry',
            'meta_key' => '_gf_entry_id',
            'meta_value' => $entry_id,
            'fields' => 'ids'
        ));

        $pet_name = rgar($entry, 4);
        $applicant_names = list_items(rgar($entry, 48));
        $application_date = rgar($entry, 47);
        $phone_number = rgar($entry, 7);
        $email = rgar($entry, 8);
        $application_url = admin_url("admin.php?page=gf_entries&view=entry&id={$form_id}&lid={$entry_id}");

        if (empty($existing_post_id)) {
            // Create a new CPT entry
            $post_id = wp_insert_post(array(
                'post_type' => 'database_entry',
                'post_title' => 'Entry ' . $entry_id . ': application for ' . $pet_name . ' from ' . $applicant_names . ' on  ' . $application_date,
                'post_status' => 'publish',
                'meta_input' => array(
                    '_gf_entry_id' => $entry_id,
                    '_applicant_approval_status' => 'Pending',
                    '_pet_name' => $pet_name,
                    '_applicant_names' => $applicant_names,
                    '_applicant_phone_number' => $phone_number,
                    '_applicant_email' => $email,
                    '_application_date' => $application_date,
                    '_application_url' => $application_url

                ),
            ));
        }
    }
}

add_action('wp_loaded', 'cosmoscause_sync_gf_entries_to_cpt');


// Function to display the content of the new admin page in a datatable
function database_page_content()
{
    include plugin_dir_path(__FILE__) . 'templates/database-page.php';
}
