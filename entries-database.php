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

    cosmoscause_sync_pet_applications(1);
    cosmoscause_sync_foster_applications(2);
}

/**
 * Sync pet application (GF ID of 1)
 */
function cosmoscause_sync_pet_applications($form_id)
{
    $paging = array('offset' => 0, 'page_size' => 200);

    $entries = GFAPI::get_entries($form_id, array(), array(), $paging);

    foreach ($entries as $entry) {
        $entry_id = $entry['id'];

        // Check if a CPT already exists for this entry
        $existing_post_id = get_posts(array(
            'post_type' => 'application_entry',
            'meta_key' => '_gf_entry_id',
            'meta_value' => $entry_id,
            'fields' => 'ids'
        ));

        $application_url = admin_url("admin.php?page=gf_entries&view=entry&id={$form_id}&lid={$entry_id}");

        $meta_array = array(
            '_gf_entry_id' => $entry_id,
            '_applicant_approval_status' => 'Pending',
            '_pet_name' => rgar($entry, 4),
            '_applicant_names' => list_items(rgar($entry, 48)),
            '_applicant_phone_number' => rgar($entry, 7),
            '_applicant_email' => rgar($entry, 8),
            '_application_date' => rgar($entry, 47),
            '_application_url' => $application_url
        );

        // Create a new CPT entry
        if (empty($existing_post_id)) {
            wp_insert_post(array(
                'post_type' => 'application_entry',
                'post_title' => 'Pet application entry ' . $entry_id . ':',
                'post_status' => 'publish',
                'meta_input' => $meta_array
            ));
        }
    }
}

function cosmoscause_sync_foster_applications($form_id)
{
    $paging = array('offset' => 0, 'page_size' => 200);

    $entries = GFAPI::get_entries($form_id, array(), array(), $paging);

    foreach ($entries as $entry) {
        $entry_id = $entry['id'];

        // Check if a CPT already exists for this entry
        $existing_post_id = get_posts(array(
            'post_type' => 'foster_entry',
            'meta_key' => '_gf_entry_id',
            'meta_value' => $entry_id,
            'fields' => 'ids'
        ));

        $application_url = admin_url("admin.php?page=gf_entries&view=entry&id={$form_id}&lid={$entry_id}");
        $meta_array = array(
            '_gf_entry_id' => $entry_id,
            '_applicant_approval_status' => 'Pending',
            '_applicant_names' => rgar($entry, 8),
            '_applicant_phone_number' => rgar($entry, 49),
            '_applicant_email' => rgar($entry, 11),
            '_application_signature_date' => rgar($entry, 44),
            '_application_url' => $application_url
        );

        // Create a new CPT entry
        if (empty($existing_post_id)) {
            wp_insert_post(array(
                'post_type' => 'foster_entry',
                'post_title' => 'Foster Entry ' . $entry_id . ':',
                'post_status' => 'publish',
                'meta_input' => $meta_array,
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
