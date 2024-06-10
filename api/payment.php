<?php

/**
 * Reuse logic to store, retrieve, and update the approval status of GF entries.
 */

if (!defined('ABSPATH')) {
    exit;
}

// Register REST API endpoints
add_action('rest_api_init', function () {
    register_rest_route('cosmoscause-plugin/v1', '/payment-status/(?P<entry_id>\d+)', array(
        'methods' => 'POST',
        'callback' => 'cosmoscause_update_payment_status',
        'permission_callback' => function () {
            return current_user_can('manage_options');
        }
    ));
});

function cosmoscause_update_payment_status(WP_REST_Request $request)
{
    $is_checked = $request->get_param('checked');
    $entry_id = intval($request->get_param('entry_id'));
    $checked_value = $is_checked ? 'collected' : 'not collected';

    update_post_meta($entry_id, '_payment_status', $checked_value);

    $message = 'The payment status has been set to ' . $checked_value;
    return new WP_REST_Response(array('message' => $message, 'checkedMessage' => $checked_value, 'checked' => $is_checked, 'entry_id' => $entry_id), 200);
}
