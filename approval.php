<?php

/**
 * Reuse logic to store, retrieve, and update the approval status of GF entries.
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register REST API endpoints
 */
add_action('rest_api_init', function () {
    register_rest_route('cosmoscause-plugin/v1', '/approve-entry/(?P<entry_id>\d+)', array(
        'methods' => 'POST',
        'callback' => 'cosmoscause_plugin_approve_entry',
        'permission_callback' => function () {
            return current_user_can('manage_options');
        }
    ));

    register_rest_route('cosmoscause-plugin/v1', '/deny-entry/(?P<entry_id>\d+)', array(
        'methods' => 'POST',
        'callback' => 'cosmoscause_plugin_deny_entry',
        'permission_callback' => function () {
            return current_user_can('manage_options');
        }
    ));
});

function cosmoscause_plugin_approve_entry(WP_REST_Request $request)
{
    error_log("Approving entry ID: $entry_id");
    $entry_id = intval($request['entry_id']);
    update_post_meta($entry_id, '_approval_status', 'Approved');
    return new WP_REST_Response(array('status' => 'Approved'), 200);
}

function cosmoscause_plugin_deny_entry(WP_REST_Request $request)
{
    $entry_id = intval($request['entry_id']);
    update_post_meta($entry_id, '_approval_status', 'Denied');
    return new WP_REST_Response(array('status' => 'Denied'), 200);
}
