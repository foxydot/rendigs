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
			'phone' => 'phone',
			'mobile' => 'mobile-phone',
			'linkedin' => 'linkedin-sign',
			'vcard' => 'download-alt',
			'email' => 'envelope-alt',
	);
	?>
	<ul class="attorney-contact-info">
		<?php $contact_info->the_field('_attorney_phone'); ?>
		<?php if($contact_info->get_the_value() != ''){ ?>
			<li class="phone"><i class="icon-phone icon-large"></i> <?php print msd_str_fmt($contact_info->get_the_value(),'phone'); ?></li>
		<?php } ?>
		
		<?php $contact_info->the_field('_attorney_mobile'); ?>
		<?php if($contact_info->get_the_value() != ''){ ?>
			<li class="mobile"><i class="icon-mobile-phone icon-large"></i> <?php print msd_str_fmt($contact_info->get_the_value(),'phone'); ?></li>
		<?php } ?>
		
		<?php $contact_info->the_field('_attorney_linked_in'); ?>
		<?php if($contact_info->get_the_value() != ''){ ?>
			<li class="linkedin"><a href="<?php print $contact_info->get_the_value(); ?>"><i class="icon-linkedin-sign icon-large"></i> Connect</a></li>
		<?php } ?>
		
		<?php $contact_info->the_field('_attorney_vcard'); ?>
		<?php if($contact_info->get_the_value() != ''){ ?>
			<li class="vcard"><i class="icon-download-alt icon-large"></i> <?php print $contact_info->get_the_value(); ?></li>
		<?php } ?>
		
		<?php $contact_info->the_field('_attorney_email'); ?>
		<?php if($contact_info->get_the_value() != ''){ ?>
			<li class="email"><i class="icon-envelope-alt icon-large"></i> <?php print msd_str_fmt($contact_info->get_the_value(),'email'); ?></li>
		<?php } ?>
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
	<h3 class="toggle">More Info<span>Expand</span></h3>
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