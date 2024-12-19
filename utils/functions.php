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


add_action('init', 'cts_vaccs_register_locations');
function cts_vaccs_register_locations() {
    $labels = [
        'name'               => 'Locations',
        'singular_name'      => 'Location',
        'menu_name'          => 'Locations',
        'name_admin_bar'     => 'Location',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Location',
        'edit_item'          => 'Edit Location',
        'view_item'          => 'View Location',
        'all_items'          => 'All Locations',
        'search_items'       => 'Search Locations',
        'not_found'          => 'No locations found.',
        'not_found_in_trash' => 'No locations found in Trash.',
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => false,
        'query_var'          => true,
        'rewrite'            => ['slug' => 'locations'],
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
    ];

    register_post_type('locations', $args);
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
       
    add_submenu_page(
        'cts-vaccs',             
        'Manage Locations',     
        'Locations',            
        'manage_options',    
        'edit.php?post_type=locations',
        null                     
    );

    add_submenu_page(
        'cts-vaccs',            
        'Settings',              
        'Settings',             
        'manage_options',        
        'cts-vaccs-payment',    
        'custom_plugin_settings'
    );
}


// Add Meta Box to Locations Post Type
add_action('add_meta_boxes', 'add_days_time_range_meta_box');
function add_days_time_range_meta_box() {
    add_meta_box(
        'days_time_range_meta_box',  // ID
        'Time Slots Settings',       // Title
        'render_days_time_range_meta_box', // Callback
        'locations',                 // Post type
        'normal',                    // Context
        'default'                    // Priority
    );
}

// Render the Meta Box to Select Days and Time Range
function render_days_time_range_meta_box($post) {
    // Retrieve the existing values
    $days = get_post_meta($post->ID, 'days', true);
    $start_time = get_post_meta($post->ID, 'start_time', true);
    $end_time = get_post_meta($post->ID, 'end_time', true);
    $slot_duration = get_post_meta($post->ID, 'slot_duration', true);
    
    // Default values
    if (!$days) $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
    if (!$slot_duration) $slot_duration = 30; // Default to 30 minutes
    
    wp_nonce_field('save_days_time_range_meta_box', 'days_time_range_nonce');
    ?>
<div>
    <label for="days">Select Days:</label><br>
    <input type="checkbox" name="days[]" value="monday" <?php echo in_array('monday', $days) ? 'checked' : ''; ?> />
    Monday
    <input type="checkbox" name="days[]" value="tuesday" <?php echo in_array('tuesday', $days) ? 'checked' : ''; ?> />
    Tuesday
    <input type="checkbox" name="days[]" value="wednesday"
        <?php echo in_array('wednesday', $days) ? 'checked' : ''; ?> /> Wednesday
    <input type="checkbox" name="days[]" value="thursday" <?php echo in_array('thursday', $days) ? 'checked' : ''; ?> />
    Thursday
    <input type="checkbox" name="days[]" value="friday" <?php echo in_array('friday', $days) ? 'checked' : ''; ?> />
    Friday
    <input type="checkbox" name="days[]" value="saturday"
        <?php echo !in_array('saturday', $days) ? '' : 'checked'; ?> /> Saturday
    <input type="checkbox" name="days[]" value="sunday" <?php echo !in_array('sunday', $days) ? '' : 'checked'; ?> />
    Sunday
</div>


<div>
    <label for="start_time">Start Time:</label>
    <input type="time" id="start_time" name="start_time" value="<?php echo esc_attr($start_time); ?>" required />
</div>

<div>
    <label for="end_time">End Time:</label>
    <input type="time" id="end_time" name="end_time" value="<?php echo esc_attr($end_time); ?>" required />
</div>

<div>
    <label for="slot_duration">Slot Duration (minutes):</label>
    <input type="number" id="slot_duration" name="slot_duration" value="<?php echo esc_attr($slot_duration); ?>" min="1"
        required />
</div>
<?php
}

// Save the Meta Box Data
add_action('save_post', 'save_days_time_range_meta_box');
function save_days_time_range_meta_box($post_id) {
    // Check nonce
    if (!isset($_POST['days_time_range_nonce']) || !wp_verify_nonce($_POST['days_time_range_nonce'], 'save_days_time_range_meta_box')) {
        return;
    }

    // Avoid autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Save the selected days
    if (isset($_POST['days'])) {
        $days = array_map('sanitize_text_field', $_POST['days']);
        update_post_meta($post_id, 'days', $days);
    }

    // Save start and end time
    if (isset($_POST['start_time'])) {
        $start_time = sanitize_text_field($_POST['start_time']);
        update_post_meta($post_id, 'start_time', $start_time);
    }

    if (isset($_POST['end_time'])) {
        $end_time = sanitize_text_field($_POST['end_time']);
        update_post_meta($post_id, 'end_time', $end_time);
    }

    // Save slot duration
    if (isset($_POST['slot_duration'])) {
        $slot_duration = intval($_POST['slot_duration']);
        update_post_meta($post_id, 'slot_duration', $slot_duration);
    }
}


// Function to generate time slots based on the selected days, start time, end time, and slot duration
function generate_time_slots($post_id) {
    $days = get_post_meta($post_id, 'days', true);
    $start_time = get_post_meta($post_id, 'start_time', true);
    $end_time = get_post_meta($post_id, 'end_time', true);
    $slot_duration = get_post_meta($post_id, 'slot_duration', true);

    $time_slots = [];
    
    // Loop over the selected days and generate time slots
    foreach ($days as $day) {
        $start = new DateTime($start_time);
        $end = new DateTime($end_time);
        
        // Generate slots for the day
        while ($start < $end) {
            $time_slots[$day][] = $start->format('H:i');
            $start->modify("+$slot_duration minutes");
        }
    }

    return $time_slots;
}

// Example usage: To get the generated time slots for a location
$location_id = 123; // Replace with your location post ID
$generated_slots = generate_time_slots($location_id);


// Save generated time slots
// function save_days_time_range_meta_box($post_id) {
//     // Check nonce and save process...
    
//     // After saving days, start time, end time, and slot duration, generate time slots
//     $time_slots = generate_time_slots($post_id);
//     update_post_meta($post_id, 'time_slots', $time_slots);
// }


// Display the time slots in the admin (e.g., in the custom meta box or elsewhere)
function display_time_slots($post) {
    $time_slots = get_post_meta($post->ID, 'time_slots', true);
    
    if ($time_slots) {
        echo '<h3>Generated Time Slots</h3>';
        echo '<ul>';
        foreach ($time_slots as $day => $slots) {
            echo '<li>' . ucfirst($day) . ': ' . implode(', ', $slots) . '</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>No time slots generated for this location.</p>';
    }
}