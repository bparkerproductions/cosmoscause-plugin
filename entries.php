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
    include plugin_dir_path(__FILE__) . 'templates/approve-deny-buttons.php';
}
