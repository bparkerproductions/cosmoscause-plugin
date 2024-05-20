<?php

// Ensure this file is included in WordPress
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
    $entry_id = rgar($args['entry'], 'id');
    $form_id = $args['form']['id'];

    include plugin_dir_path(__FILE__) . 'templates/approve-deny-buttons.php';
}
