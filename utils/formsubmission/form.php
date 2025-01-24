<?php
/**
 * 
 * @package Travel Vaccs Booking
 * @subpackage M. Sufyan Shaikh
 * 
 */

function submit_vaccination_form()
{
    check_ajax_referer('my-ajax-nonce', 'nonce');

    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_vaccination_plugin';

    // Sanitize and prepare form data
    $data = [
        'vccsType' => sanitize_text_field($_POST['vccsType']),
        'adults' => sanitize_text_field($_POST['adults']),
        'locationId' => intval($_POST['locationId']),
        'schedule' => sanitize_text_field($_POST['schedule']),
        'fname' => sanitize_text_field($_POST['fname']),
        'lname' => sanitize_text_field($_POST['lname']),
        'email' => sanitize_email($_POST['email']),
        'phone' => intval($_POST['phone']),
        'sAddress' => sanitize_text_field($_POST['sAddress']),
        'address2' => sanitize_text_field($_POST['address2']),
        'city' => sanitize_text_field($_POST['city']),
        'country' => sanitize_text_field($_POST['country']),
        'postal' => sanitize_text_field($_POST['postal']),
        'comment' => sanitize_textarea_field($_POST['comment']),
        'paymentStatus' => sanitize_text_field($_POST['submissionStatus']),
        'nonce' => sanitize_text_field($_POST['nonce']),
    ];

    // Insert data into the database
    $inserted = $wpdb->insert($table_name, $data);

    if ($inserted) {
        wp_send_json_success(['message' => 'Request submitted successfully!']);
    } else {
        wp_send_json_error(['message' => 'Failed to submit request.']);
    }

    wp_die();
}
