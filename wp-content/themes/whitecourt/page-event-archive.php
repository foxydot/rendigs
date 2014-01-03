<?php
//interrupt main loop and get only upcoming events
/** Replace the standard loop with our custom loop */
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'genesis_custom_loop' );
//add_filter('genesis_custom_loop_args','targeted_events_do_custom_loop');
add_filter('genesis_custom_loop_args','targeted_past_events_do_custom_loop');

remove_all_actions('genesis_post_content');

add_filter( 'genesis_noposts_text', 'msd_noevents_text');

function targeted_past_events_do_custom_loop() {
    $today = current_time( 'timestamp' ) - 86400;
    $args = array(
        'post_type' => 'targeted_event',
        'meta_query' => array(
            array(
                'key' => '_date_event_datestamp',
                'value' => $today,
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
    return 'There are no upcoming events scheduled at this time. View <a href="event-archive">Archived Events</a>';
}
add_action('genesis_before_post_title','msdlab_event_header');
function msdlab_event_header(){
    global $post,$date_info;
    $date_info->the_meta($post->ID);
    print date("D, d M Y",$date_info->get_the_value('event_datestamp'));
}
genesis();
