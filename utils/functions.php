<?php
/**
 * 
 * @package Travel Vaccs Booking
 * @subpackage M. Sufyan Shaikh
 * 
*/

//Frontend Templates
require_once plugin_dir_path(__DIR__) . '/frontend/form/form.php';

//Backend Templates
require_once plugin_dir_path(__DIR__) . '/admin/templates/tickets-list.php';

// Actions
require_once plugin_dir_path(__DIR__) . '/utils/formsubmission/form.php';

// Backend Scripts
function clt_admin_style() {
  wp_enqueue_style( 'backendStyle', plugins_url( '../src/css/bck-style.css', __FILE__ ), array(), false );
  wp_enqueue_script( 'backendScript', plugins_url( '../src//js/bck-script.js', __FILE__ ), array(), '1.0.0', true ); 
  wp_localize_script( 'backendScript', 'ajax_variables', array(
    'ajax_url'    => admin_url( 'admin-ajax.php' ),
    'nonce'  => wp_create_nonce( 'my-ajax-nonce' ),
  ));
}
add_action('admin_enqueue_scripts', 'clt_admin_style');

// Frontend Scripts
function vaccination_frontend_script() { 
    wp_enqueue_script( 'frontenScript', plugins_url( '../src/js/script.js', __FILE__ ), ['jquery'], null, true ); 
    
    
    wp_enqueue_style( 'frontendBootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css', array(), false );
    wp_enqueue_style( 'frontendFontAwesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css', array(), false );
    wp_enqueue_style( 'frontendStyle', plugins_url( '../src/css/style.css', __FILE__ ), array(), false );
   
    wp_localize_script( 'frontenScript', 'ajax_variables', array(
      'ajax_url'       => admin_url( 'admin-ajax.php' ),
      'nonce'          => wp_create_nonce( 'my-ajax-nonce' )
    ));
  }
  add_action( 'wp_enqueue_scripts', 'vaccination_frontend_script' ); 


add_shortcode( 'vaccination-form', 'vaccination_frontend' );

// Hook to 'admin_menu' action to create menus.
add_action('admin_menu', 'custom_plugin_menu');

// Ticket Form submission
add_action('wp_ajax_submit_vaccination_form', 'submit_vaccination_form');
add_action('wp_ajax_nopriv_submit_vaccination_form', 'submit_vaccination_form');


// Add an AJAX handler for deleting a single ticket
add_action('wp_ajax_delete_single_vaccination', 'delete_single_vaccination');
function delete_single_vaccination() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_vaccination_plugin';

    // Get the ticket ID from the AJAX request
    $ticket_id = isset($_POST['ticket_id']) ? intval($_POST['ticket_id']) : 0;

    if ($ticket_id) {
        // Delete the ticket
        $deleted = $wpdb->delete($table_name, ['id' => $ticket_id]);

        if ($deleted) {
            wp_send_json_success(['message' => 'Ticket deleted successfully.']);
        } else {
            wp_send_json_error(['message' => 'Failed to delete ticket.']);
        }
    } else {
        wp_send_json_error(['message' => 'Invalid ticket ID.']);
    }

    wp_die();
}

// Register AJAX action for updating ticket status
add_action('wp_ajax_update_vaccination_status', 'update_vaccination_status');
function update_vaccination_status() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'custom_vaccination_plugin';

    $ticket_id = isset($_POST['ticket_id']) ? intval($_POST['ticket_id']) : 0;
    $status = isset($_POST['status']) ? intval($_POST['status']) : null;

    if ($ticket_id && $status !== null) {
        $updated = $wpdb->update(
            $table_name,
            ['paymentStatus' => $status],
            ['id' => $ticket_id],
            ['%d'],
            ['%d']
        );

        if ($updated !== false) {
            wp_send_json_success(['message' => 'Status updated successfully.']);
        } else {
            wp_send_json_error(['message' => 'Failed to update status.']);
        }
    } else {
        wp_send_json_error(['message' => 'Invalid data provided.']);
    }

    wp_die();
}


function custom_plugin_menu() {
    add_menu_page(
        'Vaccs Booking',         
        'Vaccs Booking',         
        'manage_options',        
        'cts-vaccs',       
        'custom_plugin_page',     
        'dashicons-admin-generic',
        6                         
    );

    // Add submenu pages
    add_submenu_page(
        'cts-vaccs',        
        'Settings Page',         
        'Settings',              
        'manage_options',        
        'cts-vaccs-payment',
        'custom_plugin_settings'  
    );
}