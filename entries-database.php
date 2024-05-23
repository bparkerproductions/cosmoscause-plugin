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

// Function to display the content of the new admin page
function database_page_content()
{
    include plugin_dir_path(__FILE__) . 'templates/database-page.php';
}
