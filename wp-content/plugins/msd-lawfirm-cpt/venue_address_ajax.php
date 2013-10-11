<?php
require_once('../../../wp-load.php');
global $wpdb;
$venue = $_POST['venue'];
$venue_post_id = $wpdb->get_col("SELECT post_id
    FROM $wpdb->postmeta WHERE meta_key = '_location_venue' AND meta_value = '$venue' LIMIT 1" );
    if(is_numeric($venue_post_id[0])){
        $address = $wpdb->get_col("SELECT meta_value
            FROM $wpdb->postmeta WHERE meta_key = '_location_address' AND post_id = $venue_post_id[0] LIMIT 1" );
        $address = array_values($address);
        $address = unserialize($address[0]);
        print(json_encode($address[0]));
    } else {
        print '{"street":"","street2":"","city":"","state":"","zip":"","access_url":""}';
    }
