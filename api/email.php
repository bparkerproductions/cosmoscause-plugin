<?php

/**
 * Functions related to sending mail to applicants
 */

if (!defined('ABSPATH')) {
    exit;
}

// Register REST API endpoints
add_action('rest_api_init', function () {
    register_rest_route('cosmoscause-plugin/v1', '/send-contract-link', array(
        'methods' => 'POST',
        'callback' => 'cosmoscause_send_contract_link',
        'permission_callback' => function () {
            return current_user_can('manage_options');
        }
    ));
});

function cosmoscause_send_contract_link(WP_REST_Request $request)
{
    $generated_link = $request->get_param('url');
    $recipient_email = $request->get_param('email');

    // Email subject and message
    $subject = 'Your Have a New Request to Sign a Pet Application Contract';
    $message = 'Hello,

    You have a new request to sign a pet application contract. Please click the following link to proceed:
     ' . $generated_link;

    // Send the email
    $sent = wp_mail($recipient_email, $subject, $message);

    if ($sent) {
        $successMessage = 'Contract Link was successfully sent to ' . $recipient_email;
        return new WP_REST_Response(array('status' => 'success', 'message' => $successMessage), 200);
    } else {
        $failureMessage = 'Contract Link could not be sent to ' . $recipient_email;
        return new WP_REST_Response(array('status' => 'error', 'message' => $failureMessage), 500);
    }
}
