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
                vccsType varchar(150) NOT NULL,
                persons varchar(150) NOT NULL,
                selectedTime time NOT NULL,
                ClinicLoc varchar(150) NOT NULL,
                schedule varchar(150) NOT NULL,
                fname varchar(150) NOT NULL,
                lname varchar(150) NOT NULL,
                email varchar(150) NOT NULL,
                phone int(11) NOT NULL,
                sAddress varchar(150) NOT NULL,
                address2 varchar(150) NOT NULL,
                city varchar(150) NOT NULL,
                country varchar(150) NOT NULL,
                postal varchar(150) NOT NULL,
                comment varchar(150) NOT NULL,
                submissionStatus varchar(150) NOT NULL,
                currentDate timestamp NOT NULL DEFAULT current_timestamp(),
                nonce varchar(50) NOT NULL,
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
