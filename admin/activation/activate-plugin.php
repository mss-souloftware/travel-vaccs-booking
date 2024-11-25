<?php
/**
 * 
 * @package Travel Vaccs Booking
 * @subpackage M. Sufyan Shaikh
 * 
*/

function createAllTables(){
    global $wpdb;
    $cvb_registered = "cvb_registered"; 
    if(get_option($cvb_registered) != null){
        return;
    } else { 
        try {  
            $table_plugin = $wpdb->prefix . "custom_vaccination_plugin"; 
            $charset_collate = $wpdb->get_charset_collate();
           
            $createTablePlugin = "CREATE TABLE $table_plugin  (
                id int(11) NOT NULL AUTO_INCREMENT,
                task varchar(150) NOT NULL,
                selectedDate date NOT NULL,
                selectedTime time NOT NULL,
                userAddress varchar(150) NOT NULL,
                email varchar(150) NOT NULL,
                phone int(11) NOT NULL,
                googleLocation varchar(150) NOT NULL,
                nonce varchar(50) NOT NULL,
                paymentStatus varchar(50) NOT NULL DEFAULT 0,
                currentDate timestamp NOT NULL DEFAULT current_timestamp(),
                price float(10,2) NOT NULL,
                PRIMARY KEY  (id)
            ) $charset_collate;";
         
            require_once ABSPATH . "wp-admin/includes/upgrade.php"; 
            dbDelta( $createTablePlugin );
           
        } catch (\Throwable $erro) {
            error_log($erro->getMessage());
            return $erro;
        } 
        add_option($cvb_registered, true);   
    } 
}

function removeAllTables(){
    $optionsToDelette = [ 
        "cvb_registered"
    ];

    global $wpdb; 

    $table_plugin = $wpdb->prefix . "custom_vaccination_plugin";

    try {
        $removal_pluginDatabase = "DROP TABLE IF EXISTS {$table_plugin}";
        $remResult2 = $wpdb->query( $removal_pluginDatabase );

        foreach ($optionsToDelette as $options_value) {
            if (get_option($options_value)) {
                delete_option($options_value);
            } 
        }

        return $remResult2;
    } catch (\Throwable $erro) {
        error_log($erro->getMessage());
        return $erro;
    }
}
