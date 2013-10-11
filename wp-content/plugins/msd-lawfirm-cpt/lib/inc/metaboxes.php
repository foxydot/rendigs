<?php 
global $contact_info,$additional_info;
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

$additional_info = new WPAlchemy_MetaBox(array
		(
			'id' => '_additional_information',
			'title' => 'Additional Information',
			'types' => array('attorney'),
			'context' => 'normal',
			'priority' => 'high',
			'template' => WP_PLUGIN_DIR.'/'.plugin_dir_path('msd-lawfirm-cpt/msd-lawfirm-cpt.php').'lib/template/additional-information.php',
			'autosave' => TRUE,
			'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
			'prefix' => '_attorney_' // defaults to NULL
		));
        
global $date_info,$location_info,$event_info;

$date_info = new WPAlchemy_MetaBox(array
        (
            'id' => '_date_information',
            'title' => 'Event Date and Location',
            'types' => array('targeted_event'),
            'context' => 'normal',
            'priority' => 'high',
            'template' => WP_PLUGIN_DIR.'/'.plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php').'lib/template/date-information.php',
            'autosave' => TRUE,
            'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
            'prefix' => '_date_' // defaults to NULL
        ));
/*$location_info = new WPAlchemy_MetaBox(array
        (
            'id' => '_location_information',
            'title' => 'Venue Information',
            'types' => array('targeted_event'),
            'context' => 'normal',
            'priority' => 'high',
            'template' => WP_PLUGIN_DIR.'/'.plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php').'lib/template/location-information.php',
            'autosave' => TRUE,
            'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
            'prefix' => '_location_' // defaults to NULL
        ));
$event_info = new WPAlchemy_MetaBox(array
        (
            'id' => '_event_information',
            'title' => 'Event Information',
            'types' => array('targeted_event'),
            'context' => 'normal',
            'priority' => 'high',
            'template' => WP_PLUGIN_DIR.'/'.plugin_dir_path('msd-custom-cpt/msd-custom-cpt.php').'lib/template/event-information.php',
            'autosave' => TRUE,
            'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
            'prefix' => '_event_' // defaults to NULL
        ));*/