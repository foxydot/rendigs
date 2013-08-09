<?php
add_action('genesis_before_sidebar_widget_area','msd_add_attorney_headshot');
function msd_add_attorney_headshot(){
	global $post;
	//setup thumbnail image args to be used with genesis_get_image();
	$size = 'headshot'; // Change this to whatever add_image_size you want
	$default_attr = array(
			'class' => "alignright attachment-$size $size",
			'alt'   => $post->post_title,
			'title' => $post->post_title,
	);

	// This is the most important part!  Checks to see if the post has a Post Thumbnail assigned to it. You can delete the if conditional if you want and assume that there will always be a thumbnail
	if ( has_post_thumbnail() ) {
		printf( '%s', genesis_get_image( array( 'size' => $size, 'attr' => $default_attr ) ) );
	}
}
add_action('genesis_before_post_content','msd_attorney_contact_info');
function msd_attorney_contact_info(){
	global $post,$contact_info;
	$fields = array(
			'phone' => 'Phone',
			'mobile' => 'Mobile',
			'linkedin' => 'LinkedIn',
			'vcard' => 'vCard',
			'email' => 'Email',
	);
	?>
	<ul class="attorney-contact-info">
	<?php
	foreach($fields AS $k=>$v){
	?>
		<?php $contact_info->the_field('_attorney_'.$k); ?>
		<?php if($contact_info->get_the_value() != ''){ ?>
			<li class="">
				<h3><?php print $v; ?></h3>
				<div><?php print $contact_info->get_the_value(); ?></div>
			</li>
		<?php 
		$i++;
		}
	} ?>
	</ul>
	<?php
}
add_action('genesis_after_post_content','msd_attorney_additional_info');
function msd_attorney_additional_info(){
	global $post,$additional_info;
	$fields = array(
			'experience' => 'Experience',
			'admissions' => 'Admissions',
			'affiliations' => 'Professional Affiliations',
			'community' => 'Community Involvement',
			'presentations' => 'Presentations',
			'publications' => 'Publications',
			'education' => 'Education',
	);
	$i = 0; ?>
	<ul class="attorney-additional-info">
	<?php
	foreach($fields AS $k=>$v){
	?>
		<?php $additional_info->the_field('_attorney_'.$k); ?>
		<?php if($additional_info->get_the_value() != ''){ ?>
			<li>
				<h3><?php print $v; ?></h3>
				<div><?php print $additional_info->get_the_value(); ?></div>
			</li>
		<?php 
		$i++;
		}
	} ?>
	</ul>
	<?php
}
genesis();