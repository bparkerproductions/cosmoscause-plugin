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
    wp_enqueue_script('cosmoscause-plugin-js', plugins_url('js/script.js', __FILE__), array(), '1.0', true);
}
add_action('admin_enqueue_scripts', 'cosmoscause_add_scripts');


/**
 * Include approve/deny button and form entries functionality
 */
include_once plugin_dir_path(__FILE__) . 'entries.php';
