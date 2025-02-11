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
function clt_admin_style()
{
    wp_enqueue_style('backendStyle', plugins_url('../src/css/bck-style.css', __FILE__), array(), false);
    wp_enqueue_script('backendScript', plugins_url('../src//js/bck-script.js', __FILE__), array(), '1.0.0', true);
    wp_localize_script('backendScript', 'ajax_variables', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('my-ajax-nonce'),
    ));
}
add_action('admin_enqueue_scripts', 'clt_admin_style');

// Frontend Scripts
function vaccination_frontend_script()
{
    wp_enqueue_script('frontenScript', plugins_url('../src/js/script.js', __FILE__), ['jquery'], null, true);


    wp_enqueue_style('frontendBootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css', array(), false);
    wp_enqueue_style('frontendFontAwesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css', array(), false);
    wp_enqueue_style('frontendStyle', plugins_url('../src/css/style.css', __FILE__), array(), false);

    wp_localize_script('frontenScript', 'ajax_variables', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('my-ajax-nonce')
    ));
}
add_action('wp_enqueue_scripts', 'vaccination_frontend_script');


add_shortcode('vaccination-form', 'vaccination_frontend');

// Hook to 'admin_menu' action to create menus.
add_action('admin_menu', 'custom_plugin_menu');

// Ticket Form submission
add_action('wp_ajax_submit_vaccination_form', 'submit_vaccination_form');
add_action('wp_ajax_nopriv_submit_vaccination_form', 'submit_vaccination_form');


function update_ticket_status()
{
    // Verify nonce for security
    if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'my-ajax-nonce')) {
        wp_send_json_error('Invalid nonce');
        wp_die();
    }

    // Get and sanitize inputs
    $ticket_id = isset($_POST['ticket_id']) ? intval($_POST['ticket_id']) : 0;
    $status = isset($_POST['status']) ? sanitize_text_field($_POST['status']) : '';

    if (!$ticket_id || $status === '') {
        wp_send_json_error('Invalid ticket ID or status.');
        wp_die();
    }

    // Perform the status update (replace 'your_table_name' with the actual table name)
    global $wpdb;
    $updated = $wpdb->update(
        "{$wpdb->prefix}custom_vaccination_plugin", // Your table
        array('paymentStatus' => $status),      // Data to update
        array('id' => $ticket_id),       // Where clause
        array('%s'),                     // Data format
        array('%d')                      // Where clause format
    );

    if ($updated !== false) {
        wp_send_json_success('Status updated successfully.');
    } else {
        wp_send_json_error('Failed to update status.');
    }

    wp_die(); // Always end AJAX functions with wp_die()
}
add_action('wp_ajax_update_ticket_status', 'update_ticket_status');


function delete_ticket()
{
    // Verify nonce
    if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'my-ajax-nonce')) {
        wp_send_json_error('Invalid nonce');
        wp_die();
    }

    // Get and sanitize ticket ID
    $ticket_id = isset($_POST['ticket_id']) ? intval($_POST['ticket_id']) : 0;

    if (!$ticket_id) {
        wp_send_json_error('Invalid ticket ID.');
        wp_die();
    }

    global $wpdb;
    $deleted = $wpdb->delete(
        "{$wpdb->prefix}custom_vaccination_plugin", // Your table
        array('id' => $ticket_id),        // Where clause
        array('%d')                       // Where clause format
    );

    if ($deleted) {
        wp_send_json_success('Ticket deleted successfully.');
    } else {
        wp_send_json_error('Failed to delete ticket.');
    }

    wp_die(); // End AJAX function
}
add_action('wp_ajax_delete_ticket', 'delete_ticket');


add_action('init', 'cts_vaccs_register_locations');
function cts_vaccs_register_locations()
{
    $labels = [
        'name' => 'Locations',
        'singular_name' => 'Location',
        'menu_name' => 'Locations',
        'name_admin_bar' => 'Location',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Location',
        'edit_item' => 'Edit Location',
        'view_item' => 'View Location',
        'all_items' => 'All Locations',
        'search_items' => 'Search Locations',
        'not_found' => 'No locations found.',
        'not_found_in_trash' => 'No locations found in Trash.',
    ];

    $args = [
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => false,
        'query_var' => true,
        'rewrite' => ['slug' => 'locations'],
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
    ];

    register_post_type('locations', $args);
}

add_action('init', 'cts_vaccs_register_clinics');
function cts_vaccs_register_clinics()
{
    $labels = [
        'name' => 'Clinics',
        'singular_name' => 'Clinic',
        'menu_name' => 'Clinics',
        'name_admin_bar' => 'Clinic',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Clinic',
        'edit_item' => 'Edit Clinic',
        'view_item' => 'View Clinic',
        'all_items' => 'All Clinics',
        'search_items' => 'Search Clinics',
        'not_found' => 'No clinics found.',
        'not_found_in_trash' => 'No clinics found in Trash.',
    ];

    $args = [
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => false, // Hides from the main admin menu
        'query_var' => true,
        'rewrite' => ['slug' => 'clinics'],
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
    ];

    register_post_type('clinics', $args);
}

function custom_plugin_menu()
{
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
        'Manage Clinics',
        'Clinics',
        'manage_options',
        'edit.php?post_type=clinics',
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

add_action('admin_menu', 'custom_plugin_menu');



// Add Meta Box to Locations Post Type
add_action('add_meta_boxes', 'add_days_time_range_meta_box');
function add_days_time_range_meta_box()
{
    add_meta_box(
        'days_time_range_meta_box',  // ID
        'Time Slots Settings',       // Title
        'render_days_time_range_meta_box', // Callback
        'clinics',                 // Post type
        'normal',                    // Context
        'default'                    // Priority
    );
}

// Render the Meta Box to Select Days and Time Range
function render_days_time_range_meta_box($post)
{
    // Retrieve the existing values
    $days = get_post_meta($post->ID, 'days', true);
    $start_time = get_post_meta($post->ID, 'start_time', true);
    $end_time = get_post_meta($post->ID, 'end_time', true);
    $slot_duration = get_post_meta($post->ID, 'slot_duration', true);

    // Default values
    if (!$days)
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
    if (!$slot_duration)
        $slot_duration = 30; // Default to 30 minutes

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
function save_days_time_range_meta_box($post_id)
{
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
function generate_time_slots($post_id)
{
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
function display_time_slots($post)
{
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


add_action('wp_ajax_fetch_slots', 'fetch_slots');
add_action('wp_ajax_nopriv_fetch_slots', 'fetch_slots');

function fetch_slots()
{
    check_ajax_referer('my-ajax-nonce', 'nonce');

    $location_id = intval($_POST['location_id']);
    $post = get_post($location_id);

    if (!$post || $post->post_type !== 'clinics') {
        wp_send_json_error(['message' => 'Invalid location ID.']);
    }

    // Fetch custom fields
    $start_time = get_post_meta($post->ID, 'start_time', true);
    $end_time = get_post_meta($post->ID, 'end_time', true);
    $slot_duration = get_post_meta($post->ID, 'slot_duration', true);
    $days = get_post_meta($post->ID, 'days', true); // Serialized array of selected days

    // Unserialize the 'days' field to get an array of days
    $days_array = maybe_unserialize($days);

    // Convert custom fields to required format
    $start = DateTime::createFromFormat('H:i', $start_time);
    $end = DateTime::createFromFormat('H:i', $end_time);

    if (!$start || !$end || !$slot_duration) {
        wp_send_json_error(['message' => 'Incomplete slot data for this location.']);
    }

    // Calculate available slots only for selected days
    $slots_data = [];
    $today = new DateTime(); // Start from today's date

    // Get current day index and days of the week
    $days_of_week = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
    $today_day_index = $today->format('w'); // Get current day as a number (0 = Sunday, 6 = Saturday)

    // Generate the available days array, starting from the current day
    $available_days = [];
    foreach ($days_array as $day) {
        if (in_array($day, $days_of_week)) {
            $day_index = array_search($day, $days_of_week);
            $day_difference = ($day_index - $today_day_index + 7) % 7; // Calculate days until the next occurrence of this day

            // Add the day to available days if it's within the next 7 days
            $available_days[] = [
                'day' => $day,
                'date' => (clone $today)->modify("+$day_difference days")->format('Y-m-d')
            ];
        }
    }

    // Sort available days in chronological order (starting from today)
    usort($available_days, function ($a, $b) {
        return strtotime($a['date']) - strtotime($b['date']);
    });

    // Limit the output to the next 7 days (optimization)
    $end_date = (clone $today)->modify('+7 days');
    foreach ($available_days as $day_info) {
        $current_time = clone $start;
        $slots = [];
        $current_day_date = new DateTime($day_info['date']);

        // Calculate slots only for selected day and within the range
        while ($current_time < $end) {
            $slots[] = $current_time->format('H:i');
            $current_time->modify("+{$slot_duration} minutes");
        }

        // Only add the slots for the days within the next 7 days
        if ($current_day_date <= $end_date) {
            $slots_data[] = [
                'day' => $day_info['day'],
                'date' => $day_info['date'],
                'slots' => $slots
            ];
        }
    }

    wp_send_json_success(['slots' => $slots_data]);
}


function locations_search_shortcode()
{
    // Get all "locations" posts
    $args = array(
        'post_type' => 'locations',
        'posts_per_page' => -1, // Load all locations
        'post_status' => 'publish',
    );

    $query = new WP_Query($args);
    $locations = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $locations[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'link' => get_permalink(),
            );
        }
        wp_reset_postdata();
    }

    ob_start(); ?>

<input type="text" id="location-search" placeholder="Start typing to find destination" autocomplete="off">
<ul id="search-results"></ul>

<style>
#location-search {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

#search-results {
    list-style: none;
    padding: 0;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background: #fff;
    max-width: 100%;
    position: absolute;
    z-index: 1000;
    display: none;
    /* Initially hidden */
}

#search-results li {
    padding: 8px;
    cursor: pointer;
}

#search-results li:hover {
    background: #f0f0f0;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const searchField = document.getElementById("location-search");
    const resultsList = document.getElementById("search-results");

    // Load all locations from PHP
    const locations = <?php echo json_encode($locations); ?>;

    searchField.addEventListener("input", function() {
        let query = this.value.trim().toLowerCase();
        resultsList.innerHTML = "";

        if (query.length < 2) {
            resultsList.style.display = "none";
            return;
        }

        let matches = locations.filter(location => location.title.toLowerCase().includes(query));

        if (matches.length > 0) {
            resultsList.style.display = "block";
            matches.forEach(location => {
                let listItem = document.createElement("li");
                listItem.textContent = location.title;
                listItem.onclick = () => window.location.href = location.link;
                resultsList.appendChild(listItem);
            });
        } else {
            resultsList.style.display = "none";
        }
    });

    // Hide results on click outside
    document.addEventListener("click", function(e) {
        if (!searchField.contains(e.target) && !resultsList.contains(e.target)) {
            resultsList.style.display = "none";
        }
    });
});
</script>

<?php return ob_get_clean();
}
add_shortcode('locations_search', 'locations_search_shortcode');



function vaccinations_search_shortcode()
{
    // Get all "vaccinations" posts
    $args = array(
        'post_type' => 'vaccinations',
        'posts_per_page' => -1, // Load all vaccinations
        'post_status' => 'publish',
    );

    $query = new WP_Query($args);
    $vaccinations = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $vaccinations[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'link' => get_permalink(),
            );
        }
        wp_reset_postdata();
    }

    ob_start(); ?>

<input type="text" id="vaccination-search" placeholder="Search vaccinations..." autocomplete="off">
<ul id="vaccination-results"></ul>

<style>
#vaccination-search {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

#vaccination-results {
    list-style: none;
    padding: 0;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background: #fff;
    max-width: 100%;
    position: absolute;
    z-index: 1000;
    display: none;
    /* Initially hidden */
}

#vaccination-results li {
    padding: 8px;
    cursor: pointer;
}

#vaccination-results li:hover {
    background: #f0f0f0;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const searchField = document.getElementById("vaccination-search");
    const resultsList = document.getElementById("vaccination-results");

    // Load all vaccinations from PHP
    const vaccinations = <?php echo json_encode($vaccinations); ?>;

    searchField.addEventListener("input", function() {
        let query = this.value.trim().toLowerCase();
        resultsList.innerHTML = "";

        if (query.length < 2) {
            resultsList.style.display = "none";
            return;
        }

        let matches = vaccinations.filter(vaccination => vaccination.title.toLowerCase().includes(
            query));

        if (matches.length > 0) {
            resultsList.style.display = "block";
            matches.forEach(vaccination => {
                let listItem = document.createElement("li");
                listItem.textContent = vaccination.title;
                listItem.onclick = () => window.location.href = vaccination.link;
                resultsList.appendChild(listItem);
            });
        } else {
            resultsList.style.display = "none";
        }
    });

    // Hide results on click outside
    document.addEventListener("click", function(e) {
        if (!searchField.contains(e.target) && !resultsList.contains(e.target)) {
            resultsList.style.display = "none";
        }
    });
});
</script>

<?php return ob_get_clean();
}
add_shortcode('vaccinations_search', 'vaccinations_search_shortcode');



function acf_related_posts_dropdown_shortcode($atts)
{
    ob_start();

    // Get the current post ID
    global $post;
    if (!$post) {
        return '';
    }

    // Get related posts from ACF relationship field (Replace 'related_posts' with your field name)
    $related_posts = get_field('select_location_on_destination', $post->ID);

    if ($related_posts) {
        ?>
<select id="acf-related-posts-dropdown" onchange="if(this.value) window.location.href=this.value;">
    <option value="">Select Destination</option>
    <?php foreach ($related_posts as $related_post): ?>
    <option value="<?php echo get_permalink($related_post->ID); ?>">
        <?php echo esc_html($related_post->post_title); ?>
    </option>
    <?php endforeach; ?>
</select>

<style>
#acf-related-posts-dropdown {
    padding: 8px;
    font-size: 16px;
    border-radius: 5px;
}
</style>
<?php
    }

    return ob_get_clean();
}

// Register shortcode
add_shortcode('locations_from_destination', 'acf_related_posts_dropdown_shortcode');