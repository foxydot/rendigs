<?php 
if (!class_exists('MSDEventCPT')) {
    class MSDEventCPT {
        //Properties
        var $cpt = 'targeted_event';
        //Methods
        /**
        * PHP 4 Compatible Constructor
        */
        public function MSDEventCPT(){$this->__construct();}
    
        /**
         * PHP 5 Constructor
         */
        function __construct(){
            global $current_screen;
            //"Constants" setup
            $this->plugin_url = plugin_dir_url('msd-lawfirm-cpt/msd-lawfirm-cpt.php');
            $this->plugin_path = plugin_dir_path('msd-lawfirm-cpt/msd-lawfirm-cpt.php');
            //Actions
            add_action( 'init', array(&$this,'register_taxonomy_event_category') );
            add_action( 'init', array(&$this,'register_taxonomy_event_type') );
            add_action( 'init', array(&$this,'register_cpt_event') );
            add_action('admin_head', array(&$this,'plugin_header'));
            add_action('admin_enqueue_scripts', array(&$this,'add_admin_scripts') );
            add_action('admin_enqueue_scripts', array(&$this,'add_admin_styles') );
            add_action('admin_footer',array(&$this,'info_footer_hook') );
            // important: note the priority of 99, the js needs to be placed after tinymce loads
            add_action('admin_print_footer_scripts',array(&$this,'print_footer_scripts'),99);
            //add_action('template_redirect', array(&$this,'my_theme_redirect'));
            add_action('admin_head', array(&$this,'codex_custom_help_tab'));
            
            //Filters
           // add_filter( 'pre_get_posts', array(&$this,'custom_query') );
            add_filter( 'enter_title_here', array(&$this,'change_default_title') );
            
            add_image_size('sponsor',275,120,FALSE);
            // hook add_query_vars function into query_vars
            add_filter('query_vars', array(&$this,'add_query_vars'));
            // hook add_rewrite_rules function into rewrite_rules_array
            add_filter('rewrite_rules_array', array(&$this,'add_rewrite_rules'));
        }
        
        function register_taxonomy_event_category(){
            
            $labels = array( 
                'name' => _x( 'Event categories', 'event-category' ),
                'singular_name' => _x( 'Event category', 'event-category' ),
                'search_items' => _x( 'Search event categories', 'event-category' ),
                'popular_items' => _x( 'Popular event categories', 'event-category' ),
                'all_items' => _x( 'All event categories', 'event-category' ),
                'parent_item' => _x( 'Parent event category', 'event-category' ),
                'parent_item_colon' => _x( 'Parent event category:', 'event-category' ),
                'edit_item' => _x( 'Edit event category', 'event-category' ),
                'update_item' => _x( 'Update event category', 'event-category' ),
                'add_new_item' => _x( 'Add new event category', 'event-category' ),
                'new_item_name' => _x( 'New event category name', 'event-category' ),
                'separate_items_with_commas' => _x( 'Separate event categories with commas', 'event-category' ),
                'add_or_remove_items' => _x( 'Add or remove event categories', 'event-category' ),
                'choose_from_most_used' => _x( 'Choose from the most used event categories', 'event-category' ),
                'menu_name' => _x( 'Event categories', 'event-category' ),
            );
        
            $args = array( 
                'labels' => $labels,
                'public' => true,
                'show_in_nav_menus' => true,
                'show_ui' => true,
                'show_tagcloud' => false,
                'hierarchical' => true, //we want a "category" style taxonomy, but may have to restrict selection via a dropdown or something.
        
                'rewrite' => array('slug'=>'event-category','with_front'=>false),
                'query_var' => true
            );
        
            register_taxonomy( 'event_category', array($this->cpt), $args );
        }

        function register_taxonomy_event_type(){
            
            $labels = array( 
                'name' => _x( 'Event types', 'event-types' ),
                'singular_name' => _x( 'Event type', 'event-types' ),
                'search_items' => _x( 'Search event types', 'event-types' ),
                'popular_items' => _x( 'Popular event types', 'event-types' ),
                'all_items' => _x( 'All event types', 'event-types' ),
                'parent_item' => _x( 'Parent event type', 'event-types' ),
                'parent_item_colon' => _x( 'Parent event type:', 'event-types' ),
                'edit_item' => _x( 'Edit event type', 'event-types' ),
                'update_item' => _x( 'Update event type', 'event-types' ),
                'add_new_item' => _x( 'Add new event type', 'event-types' ),
                'new_item_name' => _x( 'New event type name', 'event-types' ),
                'separate_items_with_commas' => _x( 'Separate event types with commas', 'event-types' ),
                'add_or_remove_items' => _x( 'Add or remove event types', 'event-types' ),
                'choose_from_most_used' => _x( 'Choose from the most used event types', 'event-types' ),
                'menu_name' => _x( 'Event types', 'event-types' ),
            );
        
            $args = array( 
                'labels' => $labels,
                'public' => true,
                'show_in_nav_menus' => true,
                'show_ui' => true,
                'show_tagcloud' => false,
                'hierarchical' => true, //we want a "category" style taxonomy, but may have to restrict selection via a dropdown or something.
        
                'rewrite' => array('slug'=>'event-type','with_front'=>false),
                'query_var' => true
            );
        
            register_taxonomy( 'event_type', array($this->cpt), $args );
        }
        
        function register_cpt_event() {
        
            $labels = array( 
                'name' => _x( 'Events', 'event' ),
                'singular_name' => _x( 'Event', 'event' ),
                'add_new' => _x( 'Add New', 'event' ),
                'add_new_item' => _x( 'Add New Event', 'event' ),
                'edit_item' => _x( 'Edit Event', 'event' ),
                'new_item' => _x( 'New Event', 'event' ),
                'view_item' => _x( 'View Event', 'event' ),
                'search_items' => _x( 'Search Event', 'event' ),
                'not_found' => _x( 'No event found', 'event' ),
                'not_found_in_trash' => _x( 'No event found in Trash', 'event' ),
                'parent_item_colon' => _x( 'Parent Event:', 'event' ),
                'menu_name' => _x( 'Event', 'event' ),
            );
        
            $args = array( 
                'labels' => $labels,
                'hierarchical' => false,
                'description' => 'Event',
                'supports' => array( 'title', 'editor', 'thumbnail' ),
                'taxonomies' => array('event_type', 'event_category' ),
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'menu_position' => 20,
                
                'show_in_nav_menus' => true,
                'publicly_queryable' => true,
                'exclude_from_search' => false,
                'has_archive' => true,
                'query_var' => true,
                'can_export' => true,
                'rewrite' => array('slug'=>'event','with_front'=>false),
                'capability_type' => 'post'
            );
        
            register_post_type( $this->cpt, $args );
        }

        function codex_custom_help_tab() {
            global $current_screen;
            if($current_screen->post_type != $this->cpt)
            return;
        
          // Setup help tab args.
          $args = array(
            'id'      => 'title', //unique id for the tab
            'title'   => 'Title', //unique visible title for the tab
            'content' => '<h3>The Event Title</h3>
                          <p>The title of each event is generated when you add or edit an Event Location or an Event Date. This ensures that titles stay consistent and SEO compliant.</p>
                          <h3>The Permalink</h3>
                          <p>The permalink is created by the title, but it doesn\'t change automatically if you change the title. To change the permalink when editing an event, click the [Edit] button next to the permalink. 
                          Remove the text that becomes editable and click [OK]. The permalink will repopulate with the new Location and date!</p>
                          <p>Please note the difference between Event <strong>Location</strong> and event <strong>Venue</strong>. The former is a flexible variable for general description; the later is a specific venue with a mappable address, such as a convention center.</p>',  //actual help text
          );
          
          // Add the help tab.
          $current_screen->add_help_tab( $args );
          
          // Setup help tab args.
          $args = array(
            'id'      => 'event_date', //unique id for the tab
            'title'   => 'Event Location and Date', //unique visible title for the tab
            'content' => '<h3>The Event Location</h3>
                          <p>The Event Location is the custom name of the general area that the event is being held in. 
                          This value can be anything you like and will be displayed as part of the event title.</p>
                          <h3>The Event Date</h3>
                          <p>The Event Date is the date of the event. This value is restrained to dates (chooseable via a datepicker module) will be displayed as part of the event title. This value is also used to sort events for the calendars, upcoming events, etc.</p>',  //actual help text
          );
          
          // Add the help tab.
          //$current_screen->add_help_tab( $args );
        
          // Setup help tab args.
          $args = array(
            'id'      => 'event_location', //unique id for the tab
            'title'   => 'Venue Information', //unique visible title for the tab
            'content' => '<h3>The Event Venue</h3>
                          <p>The Event Venue is the name of the actual venue that the event is being held in. This
                          value is reusable and will populate the address if it is a reused venue. (Note: Please click outside the select box after selecting a venue to populate the address.)</p>
                          <h3>Venue Address</h3>
                          <p>The Venue Address is displayed on the single event display and is used to generate the Google map address.</p>
                          <h3>Virtual Event Access URL</h3>
                          <p>The Access URL is technically part of the Venue Address. If a URL is specified, this will be displayed INSTEAD of the physical address, and no map link wil be available
                          This is useful for virtual events.</p>',  //actual help text
          );
          
          // Add the help tab.
          //$current_screen->add_help_tab( $args );
        
        
          // Setup help tab args.
          $args = array(
            'id'      => 'event_information', //unique id for the tab
            'title'   => 'Event Information', //unique visible title for the tab
            'content' => '<h3>Company Lineup</h3>
                          <p>The Company Lineup can be added as a simple lsit, separated by commas. The single event display will list these companies in the sidebar.</p>
                          <h3>Event Sponsors</h3>
                          <p>The Event Sponsors area allows the addition of multiple sponsors and logos. To add a sponor logo, click on the [+] button, and select or uplaod the logo. 
                          Use the size "sponsor" to insert the logo. You can add a sponsor name for SEO (alt text) and a URL to link the logo to the sponsor site.</p>
                          <p>These logos will display in the sidebar on the individual event display.</p>',  //actual help text
          );
          
          // Add the help tab.
         // $current_screen->add_help_tab( $args );
        
        
          // Setup help tab args.
          $args = array(
            'id'      => 'publish', //unique id for the tab
            'title'   => 'Publish', //unique visible title for the tab
            'content' => '<h3>Status</h3>
                          <p>The publish status determines where this event will display. 
                            <ul>
                                <li><strong>Published</strong> events will display in all areas of the site.</li>
                                <li><strong>Pending Review</strong> events will appear only on the full year calendars and will <i>not</i> be linked to an individual event display.</li>
                                <li><strong>Draft</strong> events will not be displayed to non-administrative users.</li>
                            </ul>
                          </p>',  //actual help text
          );
          
          // Add the help tab.
          //$current_screen->add_help_tab( $args );
        
          // Setup help tab args.
          $args = array(
            'id'      => 'event_categories', //unique id for the tab
            'title'   => 'Event Categories', //unique visible title for the tab
            'content' => '<h3>Event Categories</h3>
                          <p>Please select a category for each event. This category is displayed in several places and is used for sorting on the full year calendars.</p>',  //actual help text
          );
          
          // Add the help tab.
          $current_screen->add_help_tab( $args );
        
        
          // Setup help tab args.
          $args = array(
            'id'      => 'event_types', //unique id for the tab
            'title'   => 'Event Types', //unique visible title for the tab
            'content' => '<h3>Event Types</h3>
                          <p>Please select a type for each event. This type is used to determine branding in several places on the site.</p>',  //actual help text
          );
          
          // Add the help tab.
          $current_screen->add_help_tab( $args );
        
        }
        
        function add_query_vars($aVars) {
            $aVars[] = "event_archive";
            return $aVars;
        }
 
        function add_rewrite_rules($aRules) {
            $aNewRules['event-category/legal-events/event-archive/?$'] = 'index.php?pagename=event-archive&event_archive=true';
            $aRules = $aNewRules + $aRules;
            return $aRules;
        }
        
        function plugin_header() {
            global $post_type;
            ?>
            <?php
        }
         
        function add_admin_scripts() {
            global $current_screen;
            if($current_screen->post_type == $this->cpt){
                wp_enqueue_script('media-upload');
                wp_enqueue_script('thickbox');
                wp_enqueue_script('jquery-ui-core');
                wp_enqueue_script('jquery-ui-datepicker');
                wp_enqueue_script('jquery-ui-button');
                wp_enqueue_script('jquery-ui-autocomplete');
                wp_enqueue_script('jquery-ui-tooltip');
                wp_enqueue_script('jquery-timepicker',plugin_dir_url(dirname(__FILE__)).'/js/jquery.timepicker.min.js',array('jquery'));
                wp_enqueue_script('my-upload');
            }
        }
        
        function add_admin_styles() {
            global $current_screen;
            if($current_screen->post_type == $this->cpt){
                wp_enqueue_style('thickbox');
                wp_enqueue_style('jquery-ui-style','http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.min.css');
                wp_enqueue_style('custom_meta_css',plugin_dir_url(dirname(__FILE__)).'/css/meta.css');
            }
        }   
            
        function print_footer_scripts()
        {
            global $current_screen;
            if($current_screen->post_type == $this->cpt){
                print '<script type="text/javascript">/* <![CDATA[ */
                    jQuery(function($)
                    {
                        var i=1;
                        $(\'.customEditor textarea\').each(function(e)
                        {
                            var id = $(this).attr(\'id\');
             
                            if (!id)
                            {
                                id = \'customEditor-\' + i++;
                                $(this).attr(\'id\',id);
                            }
             
                            tinyMCE.execCommand(\'mceAddControl\', false, id);
             
                        });
                    });
                /* ]]> */</script>';
            }
        }
        function change_default_title( $title ){
            global $current_screen;
            if  ( $current_screen->post_type == $this->cpt ) {
                return __('Event Title','event');
            } else {
                return $title;
            }
        }
        
        function info_footer_hook()
        {
            global $current_screen;
            if($current_screen->post_type == $this->cpt){
                ?><script type="text/javascript">
                        jQuery('#postdivrich').before(jQuery('#_contact_info_metabox'));
                    </script><?php
            }
        }
        
        function my_theme_redirect() {
            global $wp;
        
            //A Specific Custom Post Type
            if ($wp->query_vars["post_type"] == $this->cpt) {
                $templatefilename = 'single-'.$this->cpt.'.php';
                if (file_exists(STYLESHEETPATH . '/' . $templatefilename)) {
                    $return_template = STYLESHEETPATH . '/' . $templatefilename;
                } else {
                    $return_template = plugin_dir_path(dirname(__FILE__)). 'template/' . $templatefilename;
                }
                do_theme_redirect($return_template);
        
            //A Custom Taxonomy Page
            } elseif ($wp->query_vars["taxonomy"] == 'event_category') {
                $templatefilename = 'taxonomy-event_category.php';
                if (file_exists(STYLESHEETPATH . '/' . $templatefilename)) {
                    $return_template = STYLESHEETPATH . '/' . $templatefilename;
                } else {
                    $return_template = plugin_dir_path(dirname(__FILE__)). 'template/' . $templatefilename;
                }
                do_theme_redirect($return_template);
            } elseif ($wp->query_vars["taxonomy"] == 'event_type') {
                $templatefilename = 'taxonomy-event_type.php';
                if (file_exists(STYLESHEETPATH . '/' . $templatefilename)) {
                    $return_template = STYLESHEETPATH . '/' . $templatefilename;
                } else {
                    $return_template = plugin_dir_path(dirname(__FILE__)). 'template/' . $templatefilename;
                }
                do_theme_redirect($return_template);
            } 
        }

        function custom_query( $query ) {
            if(!is_admin()){
                $is_event = ($query->query_vars['event_type'])?TRUE:FALSE;
                if($query->is_main_query() && $query->is_search){
                    
                    $post_types = $query->query_vars['post_type'];
                    if(count($post_types)==0){
                        $post_types[] = 'post';
                        $post_types[] = 'page';
                    }
                    $post_types[] = $this->cpt;
                    $query->set( 'post_type', $post_types );
                }
                elseif( $query->is_main_query() && $query->is_archive ) {
                    $query->set( 'post_type', array('post','page',$this->cpt) );
                }
            }
        }   
        
        function msd_event_date(){
            global $post,$date_info;
            $date_info->the_meta($post->ID);
            $date = $date_info->get_the_value('event_datestamp');
            if($date){
                print '<div class="post-info odd"><span title="'.date("F d,Y",$date).'" class="date event time">'.date("F d,Y",$date).'</span></div>';
            }
        }        
  } //End Class
} //End if class exists statement