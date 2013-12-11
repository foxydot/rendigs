<?php
/*
 * Add styles and scripts
*/
add_action('wp_enqueue_scripts', 'msd_add_styles');

function msd_add_styles() {
	global $is_IE,$post;
	if(!is_admin()){
		wp_enqueue_style('font-awesome','//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css');
		wp_enqueue_style('msd-style',get_stylesheet_directory_uri().'/lib/css/style.css');
		if(is_front_page()){
			wp_enqueue_style('msd-homepage-style',get_stylesheet_directory_uri().'/lib/css/homepage.css',array('msd-style'));
            $queue = array('msd-style','msd-homepage-style');
		} elseif(is_single() && $post->post_type == 'attorney') {
			wp_enqueue_style('msd-attorney-style',get_stylesheet_directory_uri().'/lib/css/attorney.css',array('msd-style'));
            $queue = array('msd-style','msd-attorney-style');
		} else {
            $queue = array('msd-style');
		}
        if($is_IE){
            wp_enqueue_style('ie-style',get_stylesheet_directory_uri().'/lib/css/ie.css',$queue);
        }
	}
}
add_action('wp_enqueue_scripts', 'msd_add_scripts');

function msd_add_scripts() {
	global $is_IE,$post;
	if(!is_admin()){
		wp_enqueue_script('msd-jquery',get_stylesheet_directory_uri().'/lib/js/theme-jquery.js',array('jquery'));
		wp_enqueue_script('equalHeights',get_stylesheet_directory_uri().'/lib/js/jquery.equal-height-columns.js',array('jquery'));
		if($is_IE){
            wp_enqueue_script('modernizr',get_stylesheet_directory_uri().'/lib/js/modernizr.custom.js');
			wp_enqueue_script('columnizr',get_stylesheet_directory_uri().'/lib/js/jquery.columnizer.js',array('jquery'));
			wp_enqueue_script('ie-fixes',get_stylesheet_directory_uri().'/lib/js/ie-jquery.js',array('jquery'));
		}
		if(is_front_page()){
			wp_enqueue_script('msd-homepage-jquery',get_stylesheet_directory_uri().'/lib/js/homepage-jquery.js',array('jquery'));
		} elseif(is_single() && $post->post_type == 'attorney') {
			wp_enqueue_script('msd-attorney-jquery',get_stylesheet_directory_uri().'/lib/js/attorney-jquery.js',array('jquery'));
		}
	}
}

// cleanup tinymce for SEO
function fb_change_mce_buttons( $initArray ) {
	//@see http://wiki.moxiecode.com/index.php/TinyMCE:Control_reference
	$initArray['theme_advanced_blockformats'] = 'p,address,pre,code,h3,h4,h5,h6';
	$initArray['theme_advanced_disable'] = 'forecolor';

	return $initArray;
}
//add_filter('tiny_mce_before_init', 'fb_change_mce_buttons');

function enable_more_buttons($buttons) {
  $buttons[] = 'hr';
  $buttons[] = 'sub';
  $buttons[] = 'sup';
  $buttons[] = 'fontselect';
  $buttons[] = 'fontsizeselect';
  $buttons[] = 'cleanup';
 
  return $buttons;
}
add_filter('mce_buttons_3', 'enable_more_buttons');
	
// add classes for various browsers
add_filter('body_class','browser_body_class');
function browser_body_class($classes) {
    global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
 
    if($is_lynx) $classes[] = 'lynx';
    elseif($is_gecko) $classes[] = 'gecko';
    elseif($is_opera) $classes[] = 'opera';
    elseif($is_NS4) $classes[] = 'ns4';
    elseif($is_safari) $classes[] = 'safari';
    elseif($is_chrome) $classes[] = 'chrome';
    elseif($is_IE) $classes[] = 'ie';
    else $classes[] = 'unknown';
 
    if($is_iphone) $classes[] = 'iphone';
    return $classes;
}

add_filter('body_class','pagename_body_class');
function pagename_body_class($classes) {
	global $post;
	if(is_page()){
		$classes[] = $post->post_name;
	}
	return $classes;
}

add_filter('body_class','section_body_class');
function section_body_class($classes) {
	global $post;
	$post_data = get_post(get_topmost_parent($post->ID));
	$classes[] = 'section-'.$post_data->post_name;
	return $classes;
}
add_filter('body_class','category_body_class');
function category_body_class($classes) {
    global $post;
	$post_categories = wp_get_post_categories( $post->ID );
	foreach($post_categories as $c){
		$cat = get_category( $c );
		$classes[] = 'category-'.$cat->slug;
	}
    return $classes;
}

// add classes for subdomain
if(is_multisite()){
	add_filter('body_class','subdomain_body_class');
	function subdomain_body_class($classes) {
		global $subdomain;
		$site = get_current_site()->domain;
		$url = get_bloginfo('url');
		$sub = preg_replace('@http://@i','',$url);
		$sub = preg_replace('@'.$site.'@i','',$sub);
		$sub = preg_replace('@\.@i','',$sub);
		$classes[] = 'site-'.$sub;
		$subdomain = $sub;
		return $classes;
	}
}

if(!function_exists('msd_str_fmt')){
	function msd_str_fmt($str,$format = FALSE){
		switch($format){
			case 'email':
				$ret = '<a href="mailto:'.antispambot($str).'?CC='.antispambot('info@rendigs.com').'" class="email">'.antispambot($str).'</a>';
				break;
			case 'phone':
				$str = preg_replace("/[^0-9]/", "", $str);
				if(strlen($str) == 7)
					$ret = preg_replace("/([0-9]{3})([0-9]{4})/", "$1 $2", $str);
				elseif(strlen($str) == 10)
					$ret = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "$1 $2 $3", $str);
				else
					$ret = $str;
				break;
			default:
				$ret = $str;
				break;
		}
		return $ret;
	}
}

add_action('template_redirect','set_section');
function set_section(){
	global $post, $section;
	$post_data = get_post(get_topmost_parent($post->ID));
	$section = $post_data->post_name;
}

function get_topmost_parent($post_id){
    $this_post = get_post($post_id);
	$parent_id = $this_post->post_parent;
	if($parent_id == 0){
		$parent_id = $post_id;
	}else{
		$parent_id = get_topmost_parent($parent_id);
	}
	return $parent_id;
}
add_filter( 'the_content', 'msd_remove_msword_formatting' );
function msd_remove_msword_formatting($content){
	global $allowedposttags;
	$allowedposttags['span']['style'] = false;
	$content = wp_kses($content,$allowedposttags);
	return $content;
}
add_action('init','msd_allow_all_embeds');
function msd_allow_all_embeds(){
	global $allowedposttags;
	$allowedposttags["iframe"] = array(
			"src" => array(),
			"height" => array(),
			"width" => array()
	);
	$allowedposttags["object"] = array(
			"height" => array(),
			"width" => array()
	);

	$allowedposttags["param"] = array(
			"name" => array(),
			"value" => array()
	);

	$allowedposttags["embed"] = array(
			"src" => array(),
			"type" => array(),
			"allowfullscreen" => array(),
			"allowscriptaccess" => array(),
			"height" => array(),
			"width" => array()
	);
}
//shortcodes in widgets
add_filter('widget_text', 'do_shortcode');

function remove_wpautop( $content ) { 
    $content = do_shortcode( shortcode_unautop( $content ) ); 
    $content = preg_replace( '#^<\/p>|^<br \/>|<p>$#', '', $content );
    return $content;
}