<?php 
if (!class_exists('MSDLawfirmAttorneyCPT')) {
	class MSDLawfirmAttorneyCPT {
		//Properties
		var $cpt = 'attorney';
		//Methods
	    /**
	    * PHP 4 Compatible Constructor
	    */
		public function MSDLawfirmAttorneyCPT(){$this->__construct();}
	
		/**
		 * PHP 5 Constructor
		 */
		function __construct(){
			global $current_screen;
        	//"Constants" setup
        	$this->plugin_url = plugin_dir_url('msd-lawfirm-cpt/msd-lawfirm-cpt.php');
        	$this->plugin_path = plugin_dir_path('msd-lawfirm-cpt/msd-lawfirm-cpt.php');
			//Actions
			add_action( 'init', array(&$this,'register_tax_practice_areas') );
			add_action( 'init', array(&$this,'register_cpt_attorney') );
			add_action('admin_head', array(&$this,'plugin_header'));
			add_action('admin_print_scripts', array(&$this,'add_admin_scripts') );
			add_action('admin_print_styles', array(&$this,'add_admin_styles') );
			add_action('admin_footer',array(&$this,'info_footer_hook') );
			// important: note the priority of 99, the js needs to be placed after tinymce loads
			add_action('admin_print_footer_scripts',array(&$this,'print_footer_scripts'),99);
			
			//Filters
			add_filter( 'pre_get_posts', array(&$this,'custom_query') );
			add_filter( 'enter_title_here', array(&$this,'change_default_title') );
		}
		
		public function register_tax_practice_areas() {
		
		    $labels = array( 
		        'name' => _x( 'Practice areas', 'practice-areas' ),
		        'singular_name' => _x( 'Practice area', 'practice-areas' ),
		        'search_items' => _x( 'Search practice areas', 'practice-areas' ),
		        'popular_items' => _x( 'Popular practice areas', 'practice-areas' ),
		        'all_items' => _x( 'All practice areas', 'practice-areas' ),
		        'parent_item' => _x( 'Parent practice area', 'practice-areas' ),
		        'parent_item_colon' => _x( 'Parent practice area:', 'practice-areas' ),
		        'edit_item' => _x( 'Edit practice area', 'practice-areas' ),
		        'update_item' => _x( 'Update practice area', 'practice-areas' ),
		        'add_new_item' => _x( 'Add new practice area', 'practice-areas' ),
		        'new_item_name' => _x( 'New practice area name', 'practice-areas' ),
		        'separate_items_with_commas' => _x( 'Separate practice areas with commas', 'practice-areas' ),
		        'add_or_remove_items' => _x( 'Add or remove practice areas', 'practice-areas' ),
		        'choose_from_most_used' => _x( 'Choose from the most used practice areas', 'practice-areas' ),
		        'menu_name' => _x( 'Practice areas', 'practice-areas' ),
		    );
		
		    $args = array( 
		        'labels' => $labels,
		        'public' => true,
		        'show_in_nav_menus' => true,
		        'show_ui' => true,
		        'show_tagcloud' => false,
		        'hierarchical' => true, //we want a "category" style taxonomy, but may have to restrict selection via a dropdown or something.
		
		        'rewrite' => array('slug'=>'practice-area','with_front'=>false),
			    'query_var' => true
		    );
		
		    register_taxonomy( 'practice_area', array($this->cpt), $args );
		}
		
		function register_cpt_attorney() {
		
		    $labels = array( 
		        'name' => _x( 'Attorneys', 'attorney' ),
		        'singular_name' => _x( 'Attorney', 'attorney' ),
		        'add_new' => _x( 'Add New', 'attorney' ),
		        'add_new_item' => _x( 'Add New Attorney', 'attorney' ),
		        'edit_item' => _x( 'Edit Attorney', 'attorney' ),
		        'new_item' => _x( 'New Attorney', 'attorney' ),
		        'view_item' => _x( 'View Attorney', 'attorney' ),
		        'search_items' => _x( 'Search Attorney', 'attorney' ),
		        'not_found' => _x( 'No attorney found', 'attorney' ),
		        'not_found_in_trash' => _x( 'No attorney found in Trash', 'attorney' ),
		        'parent_item_colon' => _x( 'Parent Attorney:', 'attorney' ),
		        'menu_name' => _x( 'Attorney', 'attorney' ),
		    );
		
		    $args = array( 
		        'labels' => $labels,
		        'hierarchical' => false,
		        'description' => 'Attorney',
		        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'custom-fields' ),
		        'taxonomies' => array( 'practice_area' ),
		        'public' => true,
		        'show_ui' => true,
		        'show_in_menu' => true,
		        'menu_position' => 20,
		        
		        'show_in_nav_menus' => true,
		        'publicly_queryable' => true,
		        'exclude_from_search' => true,
		        'has_archive' => true,
		        'query_var' => true,
		        'can_export' => true,
		        'rewrite' => array('slug'=>'attorney','with_front'=>false),
		        'capability_type' => 'post'
		    );
		
		    register_post_type( $this->cpt, $args );
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
				wp_register_script('my-upload', plugin_dir_url(dirname(__FILE__)).'/js/msd-upload-file.js', array('jquery','media-upload','thickbox'),FALSE,TRUE);
				wp_enqueue_script('my-upload');
			}
		}
		
		function add_admin_styles() {
			global $current_screen;
			if($current_screen->post_type == $this->cpt){
				wp_enqueue_style('thickbox');
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
				return __('Attorney Name','attorney');
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
		

		function custom_query( $query ) {
			if(!is_admin()){
				$is_attorney = ($query->query_vars['practice_area'])?TRUE:FALSE;
				if($query->is_main_query() && $query->is_search){
					$searchterm = $query->query_vars['s'];
					// we have to remove the "s" parameter from the query, because it will prevent the posts from being found
					$query->query_vars['s'] = "";
					
					if ($searchterm != "") {
						$query->set('meta_value',$searchterm);
						$query->set('meta_compare','LIKE');
					};
					$query->set( 'post_type', array('post','page',$this->cpt) );
					ts_data($query);
				}
				elseif( $query->is_main_query() && $query->is_archive && $is_attorney ) {
					$query->set( 'orderby', 'date');
					$query->set( 'order', 'ASC');
					$query->set( 'posts_per_page', 100 );
					$query->set( 'post_type', $this->cpt );
				}
			}
		}			
  } //End Class
} //End if class exists statement