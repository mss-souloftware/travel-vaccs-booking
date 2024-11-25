<?php
/**
 * 
 * Plugin Name: Travel Vaccs Booking
 * plugin URI: https://souloftware.com/
 * version:1.0.0
 * Text Domail: lic. M. Sufyan Shaikh 
 * Description: Custom plugin for vaccination booking.
 * Author: Souloftware
 * Author URI: https://souloftware.com/contact
*/
 
// first need do somethings beffore call all the functions like create databases and tables like this time
 
require_once plugin_dir_path(__FILE__) . './admin/activation/activate-plugin.php'; 
  // ACTIIVATION PLUGIN FUNCTION -CREATE TABLES -
  register_activation_hook( __FILE__, 'createAllTables' );
  
  register_uninstall_hook( __FILE__, 'removeAllTables' );

 

// Include functions.php, use require_once to stop the script if functions.php is not found
require_once plugin_dir_path(__FILE__) . 'utils/functions.php';

 
 