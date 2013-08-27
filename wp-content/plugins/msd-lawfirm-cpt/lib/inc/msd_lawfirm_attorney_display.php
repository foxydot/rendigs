<?php 
if (!class_exists('MSDLawfirmAttorneyDisplay')) {
    class MSDLawfirmAttorneyDisplay {
        //Properties
        var $cpt = 'attorney';
        //Methods
        /**
        * PHP 4 Compatible Constructor
        */
        public function MSDLawfirmAttorneyDisplay(){$this->__construct();}
    
        /**
         * PHP 5 Constructor
         */
        function __construct(){
            global $current_screen;
            //"Constants" setup
            $this->plugin_url = plugin_dir_url('msd-lawfirm-cpt/msd-lawfirm-cpt.php');
            $this->plugin_path = plugin_dir_path('msd-lawfirm-cpt/msd-lawfirm-cpt.php');
            //Actions
                        
            //Filters
        }
 
        function get_atty_by_practice($practice_area) {
           $args = array(
            'posts_per_page'   => -1,
            'orderby'          => 'title',
            'order'            => 'ASC',
            'practice_area'    => $practice_area,
            'post_type'        => $this->cpt,
            );
            $posts = get_posts($args);
            return $posts;
        }  
        
        function get_all_attorneys(){
            $args = array(
            'posts_per_page'   => -1,
            'orderby'          => 'title',
            'order'            => 'ASC',
            'post_type'        => $this->cpt,
            );
            $posts = get_posts($args);
            $i = 0;
            foreach($posts AS $post){
                $posts[$i]->lastname = get_post_meta($post->ID,'_attorney__attorney_last_name',TRUE);
                $i++;
            }
            usort($posts,array(&$this,'sort_by_lastname'));
            return $posts;
        }        
        
        function sort_by_lastname( $a, $b ) {
            return $a->lastname == $b->lastname ? 0 : ( $a->lastname < $b->lastname ) ? -1 : 1;
        } 
        
        function get_all_practice_areas(){
            return get_terms('practice_area');
        }
  } //End Class
} //End if class exists statement