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

// Plugin activation hook
function my_custom_plugin_activate()
{
    // update_option('my_custom_plugin_activated', true);
}
register_activation_hook(__FILE__, 'my_custom_plugin_activate');

// Plugin deactivation hook
function my_custom_plugin_deactivate()
{
    // delete_option('my_custom_plugin_activated');
}
register_deactivation_hook(__FILE__, 'my_custom_plugin_deactivate');

// Plugin initialization
function my_custom_plugin_init()
{
}
add_action('init', 'my_custom_plugin_init');

// Enqueue plugin scripts and styles
function my_custom_plugin_enqueue_scripts()
{
    wp_enqueue_style('cosmoscause-plugin-style', plugins_url('css/style.css', __FILE__));
    wp_enqueue_script('cosmoscause-plugin-js', plugins_url('js/script.js', __FILE__), array(), '1.0', true);
}
add_action('wp_enqueue_scripts', 'my_custom_plugin_enqueue_scripts');
