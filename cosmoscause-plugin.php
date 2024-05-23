<?php
/*
Plugin Name: Cosmos Cause Plugin
Description: A custom WordPress plugin for Cosmos Cause that provides application database functionality and helpers
Version: 1.0
Author: Brandon Parker
Author URI: https://bparkerproductions.com
*/

if (!defined('ABSPATH')) {
    exit;
}

/**
 * On plugin activation
 */
function my_custom_plugin_activate()
{
    // update_option('my_custom_plugin_activated', true);
}
register_activation_hook(__FILE__, 'my_custom_plugin_activate');

/**
 * On plugin deactivation
 */
function my_custom_plugin_deactivate()
{
    // delete_option('my_custom_plugin_activated');
}
register_deactivation_hook(__FILE__, 'my_custom_plugin_deactivate');

/**
 * On plugin initialization
 */
function my_custom_plugin_init()
{
}
add_action('init', 'my_custom_plugin_init');

/**
 * Styles and scripts
 */
function cosmoscause_add_scripts()
{
    wp_enqueue_style('cosmoscause-plugin-style', plugins_url('css/style.css', __FILE__));
    wp_enqueue_script('cosmoscause-icons', 'https://kit.fontawesome.com/9512b63247.js', array(), _S_VERSION, true);

    // Table
    wp_enqueue_style('datatables-css', 'https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css');
    wp_enqueue_script('bootstrap5-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js', array(), null, true);
    wp_enqueue_script('datatables-js', 'https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js', array(), null, true);
    wp_enqueue_script('datatables-bs5-js', 'https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js', array('datatables-js'), null, true);

    // REST API scripts
    wp_enqueue_script('cosmoscause-approval-script', plugins_url('js/approval.js', __FILE__), array(), null, true);
    wp_localize_script('cosmoscause-approval-script', 'ajax_object', array(
        'nonce' => wp_create_nonce('wp_rest'),
        'base_url' => get_site_url()
    ));

    wp_enqueue_script('cosmoscause-plugin-js', plugins_url('js/script.js', __FILE__), array('datatables-js', 'datatables-bs5-js'), '1.0', true);
}
add_action('admin_enqueue_scripts', 'cosmoscause_add_scripts');

// Approval endpoints and functions
include plugin_dir_path(__FILE__) . 'approval.php';

/**
 * Include approve/deny button and form entries functionality
 */
include_once plugin_dir_path(__FILE__) . 'entries.php';

/**
 * Create the database page functionality under the "Forms" section
 */
include_once plugin_dir_path(__FILE__) . 'entries-database.php';
