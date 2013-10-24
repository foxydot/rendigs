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
    if(stripos($_SERVER[REQUEST_URI],'practice-areas')){
        add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_sidebar_content_sidebar' );
        add_action('genesis_after_loop','msd_child_get_attys_in_pa');
    } 
}
function msd_child_get_attys_in_pa(){
    global $post,$msd_lawfirm,$contact_info;
    $attys = $msd_lawfirm->display_class->get_atty_by_practice($post->post_name);
    if(count($attys)>0){
        print '<h3>Contact one of our '.$post->post_title.' attorneys</h3>';
    }
    foreach($attys AS $atty){
        print $msd_lawfirm->display_class->atty_display($atty);
    }
}

function msd_child_excerpt( $post_id, $excerpt_length = 30, $trailing_character = '&nbsp;<i class="icon-circle-arrow-right"></i>' ) {
$the_post = get_post( $post_id );
$the_excerpt = strip_tags( strip_shortcodes( $the_post->post_excerpt ) );
 
if ( empty( $the_excerpt ) )
$the_excerpt = strip_tags( strip_shortcodes( $the_post->post_content ) );
 
$words = explode( ' ', $the_excerpt, $excerpt_length + 1 );
 
if( count( $words ) > $excerpt_length )
$words = array_slice( $words, 0, $excerpt_length );
 
$the_excerpt = implode( ' ', $words ) . '<a href="'.get_post_permalink($post_id).'">'.$trailing_character.'</a>';
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