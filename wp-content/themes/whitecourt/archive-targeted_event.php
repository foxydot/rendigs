<?php
global $msd_hook;
$msd_hook = 'genesis_post_title';
//add_action('wp_footer','show_actions');

add_action('genesis_before_loop','msdlab_event_archive_page_title');
function msdlab_event_archive_page_title(){
   print '<h1 class="entry-title">Event Archive</h1>'; 
}

//interrupt main loop and get only events for this month
/** Replace the standard loop with our custom loop */
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'genesis_custom_loop' );
add_filter('genesis_custom_loop_args','targeted_events_do_archive_loop');

remove_all_actions('genesis_post_content');
 
function targeted_events_do_archive_loop() {
    global $paged; // current paginated page
    global $wp,$wp_query;
    $wp->query_vars["pagename"] == 'event';
    if(isset($wp_query->query['event_archive_year'])) {$year = $wp_query->query['event_archive_year'];}
    if(isset($wp_query->query['event_archive_month'])) {$month = $wp_query->query['event_archive_month'];}
    $monthstart = mktime(0, 0, 0, $month, 1, $year);
    $monthend = mktime(0, 0, 0, $month, 31, $year);
    $args = array(
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => '_date_event_datestamp',
                'value' => $monthstart,
                'compare' => '>='
            ),
            array(
                'key' => '_date_event_datestamp',
                'value' => $monthend,
                'compare' => '<='
            ),
         ),
         'order_by' => 'meta_value',
         'meta_key' => '_date_event_datestamp',
    );
    return wp_parse_args($wp_query->query_vars, $args);
}
genesis();