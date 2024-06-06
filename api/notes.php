<?php

/**
 * Reuse logic to store, retrieve, and update the approval status of GF entries.
 */

if (!defined('ABSPATH')) {
    exit;
}

// Register REST API endpoints
add_action('rest_api_init', function () {
    register_rest_route('cosmoscause-plugin/v1', '/save-notes/(?P<entry_id>\d+)', array(
        'methods' => 'POST',
        'callback' => 'cosmoscause_save_notes',
        'permission_callback' => function () {
            return current_user_can('manage_options');
        }
    ));
});

function cosmoscause_save_notes(WP_REST_Request $request)
{
    $request_body = file_get_contents('php://input');
    $data = json_decode($request_body, true);

    if (isset($data['noteContent'])) {
        $note_content = wp_kses_post($data['noteContent']);
        $entry_id = intval($request->get_param('entry_id'));
        update_post_meta($entry_id, '_entry_notes', $note_content);
    }


    return new WP_REST_Response(array('content' => $note_content, 'updated_post_id' => $entry_id), 200);
}
