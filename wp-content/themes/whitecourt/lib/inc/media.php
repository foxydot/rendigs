<?php

/** Add Viewport meta tag for mobile browsers */
add_action( 'genesis_meta', 'add_viewport_meta_tag' );
function add_viewport_meta_tag() {
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
}

/** Add new image sizes */
add_image_size( 'post-image', 540, 150, TRUE );
add_image_size( 'headshot', 340, 600, FALSE );
add_image_size( 'mini-headshot', 120, 120, TRUE );

/* Manipulate the featured image */
add_action( 'genesis_before_post', 'msd_post_image', 8 );
function msd_post_image() {
	global $post;
   	//setup thumbnail image args to be used with genesis_get_image();
	$size = 'post-image'; // Change this to whatever add_image_size you want
	$default_attr = array(
			'class' => "alignright attachment-$size $size",
			'alt'   => $post->post_title,
			'title' => $post->post_title,
	);

	// This is the most important part!  Checks to see if the post has a Post Thumbnail assigned to it. You can delete the if conditional if you want and assume that there will always be a thumbnail
	if ( has_post_thumbnail() && is_page() ) {
		printf( '<a title="%s" href="%s">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), genesis_get_image( array( 'size' => $size, 'attr' => $default_attr ) ) );
	}

}