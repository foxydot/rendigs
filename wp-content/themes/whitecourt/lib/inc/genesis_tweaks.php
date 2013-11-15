<?php
add_theme_support( 'genesis-footer-widgets', 4 );
//add_action('after_setup_theme','msd_child_add_homepage_sidebars');
function msd_child_add_homepage_sidebars(){
	genesis_register_sidebar(array(
	'name' => 'Homepage Hero',
	'description' => 'Homepage hero space',
	'id' => 'homepage-top'
			));
	genesis_register_sidebar(array(
	'name' => 'Homepage Widget Area One',
	'description' => 'Homepage central widget areas',
	'id' => 'homepage-one'
			));
	genesis_register_sidebar(array(
    'name' => 'Homepage Widget Area Two',
    'description' => 'Homepage central widget areas',
    'id' => 'homepage-two'
    		));
	genesis_register_sidebar(array(
    'name' => 'Homepage Widget Area Three',
    'description' => 'Homepage central widget areas',
    'id' => 'homepage-three'
    		));
	genesis_register_sidebar(array(
    'name' => 'Homepage Widget Area Four',
    'description' => 'Homepage central widget areas',
    'id' => 'homepage-four'
    		));
    
}

add_action('template_redirect','msd_child_check_special_templates');
function msd_child_check_special_templates(){
    global $post;
    $post_data = get_post(get_topmost_parent($post->ID));
    $section = $post_data->post_name;
    if(
        stripos($_SERVER[REQUEST_URI],'about') ||
        stripos($_SERVER[REQUEST_URI],'industry') ||
        stripos($_SERVER[REQUEST_URI],'contact-us') ||
        stripos($_SERVER[REQUEST_URI],'social-media')
    ){
        add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_sidebar_content_sidebar' );
    } elseif($section == 'auth'){
        add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );
    } elseif(is_search()){
        add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
    };
    if(stripos($_SERVER[REQUEST_URI],'practice-areas')){
        add_action('genesis_after_loop','msd_child_get_attys_in_pa');
    } elseif(is_home()){
        add_action('genesis_before_loop','msd_genesis_add_title_to_news_page');
    } elseif(get_post_type() == 'targeted_event'){
        add_action('genesis_before_loop','msd_genesis_add_title_to_loop_page');
    }
}
function msd_child_get_attys_in_pa(){
    global $post,$msd_lawfirm,$contact_info;
    $attys = $msd_lawfirm->display_class->get_atty_by_practice($post->post_name);
    if(count($attys)>0){
        print '<h3>Contact one of our '.$post->post_title.' attorneys</h3>';
    }
    foreach($attys AS $atty){
        print $msd_lawfirm->display_class->atty_display($atty,array('dobio' => TRUE,'the_pa' => $post->post_name));
    }
}
function msd_genesis_add_title_to_loop_page(){
    global $wp_query;
    if(isset($wp_query->query['event_category'])){
        $title = "Events";
    }
    print '<h1 class="entry-title">'.$title.'</h1>';
}
function msd_genesis_add_title_to_news_page(){
    print '<h1 class="entry-title">News</h1>';
}
function new_excerpt_more($more) {
       global $post;
    return ' <a class="moretag" href="'. get_permalink($post->ID) . '">Read More&nbsp;<i class="icon-circle-arrow-right"></i></a>';
}
add_filter('excerpt_more', 'new_excerpt_more');
add_filter( 'get_the_content_more_link', 'new_excerpt_more' );
function child_theme_setup() {
    // override parent theme's 'more' text for excerpts
    remove_filter( 'excerpt_more', 'twentyeleven_auto_excerpt_more' ); 
    remove_filter( 'get_the_excerpt', 'twentyeleven_custom_excerpt_more' );
}
add_action( 'after_setup_theme', 'child_theme_setup' );

add_filter('relevanssi_excerpt_content', 'excerpt_function', 10, 3);
function excerpt_function($content, $post, $query) {
        //add whatever you want to $content here
        $content = $content.' <a href="'.get_post_permalink($post_id).'">&nbsp;<i class="icon-circle-arrow-right"></i></a>';
    return $content;
}

function msd_child_excerpt( $post_id, $excerpt_length = 30, $trailing_character = '&nbsp;<i class="icon-circle-arrow-right"></i>' ) {
$the_post = get_post( $post_id );
$the_excerpt = strip_tags( strip_shortcodes( $the_post->post_excerpt ) );
 
if ( empty( $the_excerpt ) )
$the_excerpt = strip_tags( strip_shortcodes( $the_post->post_content ) );
 
$words = explode( ' ', $the_excerpt, $excerpt_length + 1 );
 
if( count( $words ) > $excerpt_length )
$words = array_slice( $words, 0, $excerpt_length );
 
$the_excerpt = implode( ' ', $words ) . ' <a href="'.get_post_permalink($post_id).'">'.$trailing_character.'</a>';
return $the_excerpt;
}

add_action('after_setup_theme','msd_child_add_special_sidebars');
function msd_child_add_special_sidebars(){
	genesis_register_sidebar(array(
	'name' => 'Attorney Pages Sidebar',
	'description' => 'Sidebar on attorney profiles',
	'id' => 'attorney-sidebar'
			));    
}
/** Customize search form input box text */
add_filter( 'genesis_search_text', 'custom_search_text' );
function custom_search_text($text) {
	return esc_attr( 'Begin your search here...' );
}

add_filter('genesis_breadcrumb_args', 'custom_breadcrumb_args');
function custom_breadcrumb_args($args) {
	$args['labels']['prefix'] = ''; //marks the spot
	$args['sep'] = ' > ';
	return $args;
}

remove_action('genesis_before_loop', 'genesis_do_breadcrumbs');
add_action('genesis_before_content_sidebar_wrap', 'genesis_do_breadcrumbs');

remove_action( 'genesis_before_post_content', 'genesis_post_info' );
remove_action( 'genesis_after_post_content', 'genesis_post_meta' );

add_action('genesis_before_loop','msd_should_there_be_meta');
function msd_should_there_be_meta(){
    if(get_post_type()=='post'){
        add_action( 'genesis_before_post_content', 'genesis_post_info' );
    }
    if(get_post_type()=='targeted_event'){
        add_action( 'genesis_before_post_title', array('MSDEventCPT','msd_event_date') );
    }
}
add_filter( 'genesis_post_info', 'msd_post_info_filter' );
function msd_post_info_filter($post_info) {
    $post_info = '[post_date] [post_edit]';
    return $post_info;
}

 /**
 * Replace footer
 */
remove_action('genesis_footer','genesis_do_footer');
add_action('genesis_footer','msdsocial_do_footer');
function msdsocial_do_footer(){
	global $msd_social;
	if($msd_social){
		$copyright = '&copy;Copyright '.date('Y').' '.$msd_social->get_bizname().' <br/> All Rights Reserved';
	} else {
		$copyright = '&copy;Copyright '.date('Y').' '.get_bloginfo('name').' <br/> All Rights Reserved ';
	}
	if(has_nav_menu('footer_menu')){$copyright .= wp_nav_menu( array( 'theme_location' => 'footer_menu','container_class' => 'ftr-menu ftr-links','echo' => FALSE ) );}
	print '<div id="copyright" class="copyright gototop">'.$copyright.'</div><div id="social" class="social creds">';
	if($msd_social){print '<strong>'.$msd_social->get_bizname().'</strong><br />'.$msd_social->get_address().'&nbsp;&nbsp;|&nbsp;&nbsp;'.$msd_social->get_digits();}
	print '</div>';
}

/**
 * Reversed out style SCS
 */
add_action('genesis_before', 'msd_new_custom_layout_logic');
function msd_new_custom_layout_logic() {

	$site_layout = genesis_site_layout();
	 
	if ( $site_layout == 'sidebar-content-sidebar' ) {
		// Remove default genesis sidebars
		remove_action( 'genesis_after_content', 'genesis_get_sidebar' );
		remove_action( 'genesis_after_content_sidebar_wrap', 'genesis_get_sidebar_alt');
		// Add layout specific sidebars
		add_action( 'genesis_before_content_sidebar_wrap', 'genesis_get_sidebar' );
		add_action( 'genesis_after_content', 'genesis_get_sidebar_alt');
	}
}