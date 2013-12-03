<?php 
if (!class_exists('MSDNewsletterCPT')) {
    class MSDNewsletterCPT {
        //Properties
        var $cpt = 'newsletter';
        //Methods
        /**
        * PHP 4 Compatible Constructor
        */
        public function MSDNewsletterCPT(){$this->__construct();}
    
        /**
         * PHP 5 Constructor
         */
        function __construct(){
            global $current_screen;
            //"Constants" setup
            $this->plugin_url = plugin_dir_url('msd-lawfirm-cpt/msd-lawfirm-cpt.php');
            $this->plugin_path = plugin_dir_path('msd-lawfirm-cpt/msd-lawfirm-cpt.php');
            //Actions
            add_action( 'init', array(&$this,'register_cpt_newsletter') );
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
        }
        
        function register_cpt_newsletter() {
        
            $labels = array( 
                'name' => _x( 'Newsletters', 'newsletter' ),
                'singular_name' => _x( 'Newsletter', 'newsletter' ),
                'add_new' => _x( 'Add New', 'newsletter' ),
                'add_new_item' => _x( 'Add New Newsletter', 'newsletter' ),
                'edit_item' => _x( 'Edit Newsletter', 'newsletter' ),
                'new_item' => _x( 'New Newsletter', 'newsletter' ),
                'view_item' => _x( 'View Newsletter', 'newsletter' ),
                'search_items' => _x( 'Search Newsletter', 'newsletter' ),
                'not_found' => _x( 'No newsletter found', 'newsletter' ),
                'not_found_in_trash' => _x( 'No newsletter found in Trash', 'newsletter' ),
                'parent_item_colon' => _x( 'Parent Newsletter:', 'newsletter' ),
                'menu_name' => _x( 'Newsletter', 'newsletter' ),
            );
        
            $args = array( 
                'labels' => $labels,
                'hierarchical' => false,
                'description' => 'Newsletter',
                'supports' => array( 'title', 'editor' ),
                'taxonomies' => array( ),
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
                'rewrite' => array('slug'=>'resources/newsletter','with_front'=>false),
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
            'content' => '<h3>The Newsletter Title</h3>
                          <p>Add a title for a newsletter</p>
                          <h3>The PDF</h3>
                          <p>Be sure to add the PDF to be attached to the Newsletter.</p>'
          );
          
          // Add the help tab.
          $current_screen->add_help_tab( $args );
        
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
                return __('Newsletter Title','newsletter');
            } else {
                return $title;
            }
        }
        
        function info_footer_hook()
        {
            global $current_screen;
            if($current_screen->post_type == $this->cpt){
                ?><script type="text/javascript">
                
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
            } 
        }

        function custom_query( $query ) {
            if(!is_admin()){
                $is_newsletter = ($query->query_vars['newsletter_type'])?TRUE:FALSE;
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
  } //End Class
} //End if class exists statement