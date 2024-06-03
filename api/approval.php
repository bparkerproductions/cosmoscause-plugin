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
    register_rest_route('cosmoscause-plugin/v1', '/approve-entry/(?P<post_id>\d+)', array(
        'methods' => 'POST',
        'callback' => 'cosmoscause_approve_entry',
        'permission_callback' => function () {
            return current_user_can('manage_options');
        }
    ));

    register_rest_route('cosmoscause-plugin/v1', '/deny-entry/(?P<post_id>\d+)', array(
        'methods' => 'POST',
        'callback' => 'cosmoscause_deny_entry',
        'permission_callback' => function () {
            return current_user_can('manage_options');
        }
    ));
});

function cosmoscause_approve_entry(WP_REST_Request $request)
{
    $newStatus = 'Approved';
    $post_id = intval($request->get_param('post_id'));
    update_post_meta($post_id, '_applicant_approval_status', $newStatus);
    return new WP_REST_Response(array('status' => $newStatus, 'updated_post_id' => $post_id), 200);
}

function cosmoscause_deny_entry(WP_REST_Request $request)
{
    $newStatus = 'Denied';
    $post_id = intval($request->get_param('post_id'));
    update_post_meta($post_id, '_applicant_approval_status', $newStatus);
    return new WP_REST_Response(array('status' => $newStatus), 200);
}
