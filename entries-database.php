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

    // TODO refactor to rely on something besides the form_id
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

        // Create a new CPT entry
        if (empty($existing_post_id)) {
            $existing_post_id = wp_insert_post(array(
                'post_type' => 'application_entry',
                'post_title' => 'Pet application entry ' . $entry_id . ':',
                'post_status' => 'publish',
                'meta_input' => array('_gf_entry_id' => $entry_id,)
            ));
        }

        $street_address = rgar($entry, '6.1');
        $address_line_2 = rgar($entry, '6.2');
        $city = rgar($entry, '6.3');
        $state = rgar($entry, '6.4');
        $zip_code = rgar($entry, '6.5');
        $country = rgar($entry, '6.6');

        // Combine the address components
        $address = trim("$street_address $address_line_2 $city, $state $zip_code $country");
        $application_url = admin_url("admin.php?page=gf_entries&view=entry&id={$form_id}&lid={$entry_id}");

        /**
         * Post meta values:
         * Entry [notes, date] Pet name, Vet List,
         * Landlord [Phone, Email], 
         * Reference [Name, Phone]
         * Applicant [Names, Phone, Approval Status, Email, Address]
         * Application URL, Contract Started,
         */
        add_meta_to_existing_cpt($existing_post_id, '_entry_notes', "");
        add_meta_to_existing_cpt($existing_post_id, '_gf_entry_date', $entry['date_created']);
        add_meta_to_existing_cpt($existing_post_id, '_pet_name', rgar($entry, 4));
        add_meta_to_existing_cpt($existing_post_id, '_veterinarian_list', rgar($entry, 26));

        add_meta_to_existing_cpt($existing_post_id, '_landlord_phone', rgar($entry, 13));
        add_meta_to_existing_cpt($existing_post_id, '_landlord_email', rgar($entry, 14));

        add_meta_to_existing_cpt($existing_post_id, '_reference_name', rgar($entry, 49));
        add_meta_to_existing_cpt($existing_post_id, '_reference_phone', rgar($entry, 50));

        add_meta_to_existing_cpt($existing_post_id, '_applicant_names', list_items(rgar($entry, 48)));
        add_meta_to_existing_cpt($existing_post_id, '_applicant_phone_number', rgar($entry, 7));
        add_meta_to_existing_cpt($existing_post_id, '_applicant_approval_status', "Pending");
        add_meta_to_existing_cpt($existing_post_id, '_applicant_email', rgar($entry, 8));
        add_meta_to_existing_cpt($existing_post_id, '_applicant_address', $address);

        add_meta_to_existing_cpt($existing_post_id, '_application_url', $application_url);
        add_meta_to_existing_cpt($existing_post_id, '_contract_started', "not started");
    }
}

/**
 * Sync pet application (GF ID of 2)
 */
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

        // Create a new CPT entry
        if (empty($existing_post_id)) {
            $existing_post_id = wp_insert_post(array(
                'post_type' => 'foster_entry',
                'post_title' => 'Foster Entry ' . $entry_id . ':',
                'post_status' => 'publish',
                'meta_input' => array('_gf_entry_id' => $entry_id,),
            ));
        }

        $application_url = admin_url("admin.php?page=gf_entries&view=entry&id={$form_id}&lid={$entry_id}");

        /**
         * Post meta values:
         * Entry [notes, date] 
         * Reference [Name, Phone]
         * Veterinarian [Name, Phone]
         * Applicant [Names, Phone, Approval Status, Email]
         * Application URL
         */

        add_meta_to_existing_cpt($existing_post_id, '_entry_notes', "");
        add_meta_to_existing_cpt($existing_post_id, '_gf_entry_date', $entry['date_created']);

        add_meta_to_existing_cpt($existing_post_id, '_reference_name', rgar($entry, 37));
        add_meta_to_existing_cpt($existing_post_id, '_reference_phone', rgar($entry, 50));

        add_meta_to_existing_cpt($existing_post_id, '_veterinarian_name', rgar($entry, 42));
        add_meta_to_existing_cpt($existing_post_id, '_veterinarian_phone', rgar($entry, 36));

        add_meta_to_existing_cpt($existing_post_id, '_applicant_names', rgar($entry, 8));
        add_meta_to_existing_cpt($existing_post_id, '_applicant_phone_number', rgar($entry, 49));
        add_meta_to_existing_cpt($existing_post_id, '_applicant_approval_status', "Pending");
        add_meta_to_existing_cpt($existing_post_id, '_applicant_email', rgar($entry, 11));

        add_meta_to_existing_cpt($existing_post_id, '_application_url', $application_url);
    }
}

// Adds a post meta to a post type if it doesn't exist already
function add_meta_to_existing_cpt($the_post, $meta_key, $meta_value)
{
    $post_id = is_array($the_post) ? $the_post[0] : $the_post;

    if (!metadata_exists('post', $post_id, $meta_key)) {
        // Add the meta key with the specified value
        add_post_meta($post_id, $meta_key, $meta_value, true);
    }
}

// Adds a post meta to a post type if it doesn't exist already
function delete_meta_for_existing_cpt($the_post, $meta_key)
{
    $post_id = is_array($the_post) ? $the_post[0] : $the_post;

    if (metadata_exists('post', $post_id, $meta_key)) {
        // Add the meta key with the specified value
        delete_post_meta($post_id, $meta_key);
    }
}

add_action('wp_loaded', 'cosmoscause_sync_gf_entries_to_cpt');


// Function to display the content of the new admin page in a datatable
function database_page_content()
{
    include plugin_dir_path(__FILE__) . 'templates/database-page.php';
}
