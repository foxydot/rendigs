<?php
add_theme_support( 'genesis-footer-widgets', 4 );
add_action('after_setup_theme','msd_child_add_homepage_sidebars');
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
 * Add extra menu locations
 */
register_nav_menus( array(
'footer_library_link' => 'Library Link',
'footer_menu' => 'Footer Menu'
) );

/**
 * Replace footer
 */
remove_action('genesis_footer','genesis_do_footer');
add_action('genesis_footer','msdsocial_do_footer');
function msdsocial_do_footer(){
	global $msd_social;
	if($msd_social){
		$copyright = '&copy;Copyright '.date('Y').' '.$msd_social->get_bizname().' &middot; All Rights Reserved';
	} else {
		$copyright = '&copy;Copyright '.date('Y').' '.get_bloginfo('name').' &middot; All Rights Reserved ';
	}
	if(has_nav_menu('footer_menu')){$copyright .= wp_nav_menu( array( 'theme_location' => 'footer_menu','container_class' => 'ftr-menu ftr-links','echo' => FALSE ) );}
	print '<div id="copyright" class="copyright gototop">'.$copyright.'</div><div id="social" class="social creds">';
	if($msd_social){print $msd_social->get_address().$msd_social->get_digits();}
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