<?php 
$contact_info = new WPAlchemy_MetaBox(array
		(
			'id' => '_contact_info',
			'title' => 'Contact Info',
			'types' => array('attorney'), // added only for pages and to custom post type "events"
			'context' => 'normal', // same as above, defaults to "normal"
			'priority' => 'high', // same as above, defaults to "high"
			'template' => WP_PLUGIN_DIR.'/'.plugin_dir_path('msd-lawfirm-cpt/msd-lawfirm-cpt.php').'lib/template/contact-info.php',
			'autosave' => TRUE,
			'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
			'prefix' => '_attorney_' // defaults to NULL
		));

$summary = new WPAlchemy_MetaBox(array
		(
			'id' => '_additional_information',
			'title' => 'Additional Information',
			'types' => array('attorney'),
			'context' => 'normal',
			'priority' => 'high',
			'template' => WP_PLUGIN_DIR.'/'.plugin_dir_path('msd-lawfirm-cpt/msd-lawfirm-cpt.php').'lib/template/additional_information.php',
			'autosave' => TRUE,
			'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
			'prefix' => '_attorney_' // defaults to NULL
		));