<?php

/**
 * The entries file will modify the gravity forms "Entries" section with custom functions and features.
 */

if (!defined('ABSPATH')) {
    exit;
}

// Add custom buttons under each Gravity Forms entry in the admin area
add_filter('gform_entry_detail_meta_boxes', 'add_approve_deny_buttons', 10, 3);

function add_approve_deny_buttons($meta_boxes, $entry, $form)
{
    $meta_boxes['approve_deny_buttons'] = array(
        'title'    => 'Actions',
        'callback' => 'render_approve_deny_buttons',
        'context'  => 'normal',
    );

    return $meta_boxes;
}

function render_approve_deny_buttons($args)
{
    $entry = get_posts(array(
        'post_type' => 'database_entry',
        'posts_per_page' => 1,
        'meta_query'     => array(
            array(
                'key'     => '_gf_entry_id',
                'value'   => intval($_GET['lid']),
                'compare' => '='
            )
        )
    ))[0];

    $applicant_approval_status = get_post_meta($entry->ID, '_applicant_approval_status', true);

    include plugin_dir_path(__FILE__) . 'templates/approve-deny-buttons.php';
}
