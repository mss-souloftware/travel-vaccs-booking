<?php
/**
 * 
 * @package Travel Vaccs Booking
 * @subpackage M. Sufyan Shaikh
 * 
 */

function submit_vaccination_form() {
    check_ajax_referer('my-ajax-nonce', 'nonce');

    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_ticket_plugin';

    // Sanitize and prepare form data
    $data = [
        'task'    => sanitize_text_field($_POST['task']),
        'selectedDate'    => sanitize_text_field($_POST['date']),
        'selectedTime'    => sanitize_text_field($_POST['time']),
        'userAddress' => sanitize_text_field($_POST['address']),
        'email'   => sanitize_email($_POST['email']),
        'phone'   => sanitize_text_field($_POST['phone']),
    ];

    // Insert data into the existing table
    $inserted = $wpdb->insert($table_name, $data);

    if ($inserted) {
        wp_send_json_success(['message' => 'Request submitted successfully!']);
    } else {
        wp_send_json_error(['message' => 'Failed to submit request.']);
    }

    wp_die();
}
