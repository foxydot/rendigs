<?php
//interrupt main loop and get only upcoming events
/** Replace the standard loop with our custom loop */
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'genesis_custom_loop' );
add_filter('genesis_custom_loop_args','targeted_events_do_custom_loop');
add_filter('genesis_custom_loop_args','targeted_past_events_do_custom_loop');

remove_all_actions('genesis_post_content');

add_filter( 'genesis_noposts_text', 'msd_noevents_text');
 
function targeted_events_do_custom_loop() {
    global $paged; // current paginated page
    global $wp_query;
    $args = array(
        'meta_query' => array(
            array(
                'key' => '_date_event_datestamp',
                'value' => time()-86400,
                'compare' => '>'
            ),
            array(
                'key' => '_date_event_datestamp',
                'value' => mktime(0, 0, 0, date("m")+6, date("d"), date("Y")),
                'compare' => '<'
            )
         ),
         'order_by' => 'meta_value',
         'meta_key' => '_date_event_datestamp',
    );
    $test_query = new WP_Query(wp_parse_args($wp_query->query_vars, $args));
    if ( !$test_query->have_posts() ) {
        add_filter('genesis_custom_loop_args','targeted_past_events_do_custom_loop');
    }
    return wp_parse_args($wp_query->query_vars, $args);
}
function targeted_past_events_do_custom_loop() {
    global $paged; // current paginated page
    global $wp_query;
    $args = array(
        'meta_query' => array(
            array(
                'key' => '_date_event_datestamp',
                'value' => time()-86400,
                'compare' => '<'
            ),
         ),
         'order_by' => 'meta_value',
         'order' => 'ASC',
         'meta_key' => '_date_event_datestamp',
    );
    return wp_parse_args($wp_query->query_vars, $args);
}
function msd_noevents_text($text){
    return 'There are no upcoming events scheduled at this time.';
}
genesis();
