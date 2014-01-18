<?php

/** Add Viewport meta tag for mobile browsers */
add_action( 'genesis_meta', 'add_viewport_meta_tag' );
function add_viewport_meta_tag() {
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
}

/** Add new image sizes */
add_image_size( 'post-image', 540, 300, FALSE );
add_image_size( 'headshot', 373, 600, FALSE );
add_image_size( 'mini-headshot', 120, 160, TRUE );

/**
 * Add new image sizes to the media panel
 */
if(!function_exists('msd_insert_custom_image_sizes')){
function msd_insert_custom_image_sizes( $sizes ) {
    global $_wp_additional_image_sizes;
    if ( empty($_wp_additional_image_sizes) )
        return $sizes;

    foreach ( $_wp_additional_image_sizes as $id => $data ) {
        if ( !isset($sizes[$id]) )
            $sizes[$id] = ucfirst( str_replace( '-', ' ', $id ) );
    }

    return $sizes;
}
}
add_filter( 'image_size_names_choose', 'msd_insert_custom_image_sizes' );


/* Manipulate the featured image */
add_action('genesis_before_content','msd_add_post_images');
function msd_add_post_images(){
    if(is_archive() || is_home()){
        //add_action( 'genesis_before_post', 'msd_post_image', 8 );
    } elseif(is_single()){
        if(get_post_type() == 'post' || get_post_type() == 'targeted_event'){
            add_action( 'genesis_post_content', 'msd_post_image', 1);
        }
    }
}
function msd_post_image() {
	global $post;
   	//setup thumbnail image args to be used with genesis_get_image();
   	if(is_archive() || is_home()){
   	    $size = 'mini-headshot'; // Change this to whatever add_image_size you want
   	} elseif(is_single()){
        $size = 'post-image'; // Change this to whatever add_image_size you want
   	}
	$default_attr = array(
			'class' => "alignleft attachment-$size $size",
			'alt'   => $post->post_title,
			'title' => $post->post_title,
	);

	// This is the most important part!  Checks to see if the post has a Post Thumbnail assigned to it. You can delete the if conditional if you want and assume that there will always be a thumbnail
	if ( has_post_thumbnail() && !is_page() ) {
		printf( '%s', genesis_get_image( array( 'size' => $size, 'attr' => $default_attr ) ) );
	}

}