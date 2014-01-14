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
            $i = 0;
            foreach($posts AS $post){
                $posts[$i]->lastname = get_post_meta($post->ID,'_attorney__attorney_last_name',TRUE);
                $i++;
            }
            usort($posts,array(&$this,'sort_by_lastname'));
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
        
        function atty_display($atty,$attr = array()){
            global $post,$msd_lawfirm,$contact_info,$primary_practice_area;
            //ts_data($atty);
            extract($attr);
            $headshot = get_the_post_thumbnail($atty->ID,'mini-headshot');
            $terms = wp_get_post_terms($atty->ID,'practice_area');
            $primary_practice_area->the_meta($atty->ID);
            $ppa = $primary_practice_area->get_the_value('primary_practice_area');
            $practice_areas = array();
            if(count($terms)>0){
                $i = 0;
                foreach($terms AS $term){
                    $more_practice_areas = ''; //On the attorney pages, please remove all round circles with blue arrows under the attorney practice areas.
                    //$more_practice_areas = $i==2?' <a href="'.get_post_permalink($atty->ID).'"><i class="icon-circle-arrow-right"></i></a>':'';
                    if($term->slug == $the_pa){
                        if($test = get_page_by_path('/practice-areas/'.$term->slug)){
                            $first = '<li><a href="/practice-areas/'.$term->slug.'">'.$term->name.'</a>'.$more_practice_areas.'</li>';
                        } else {
                            $first = '<li>'.$term->name.$more_practice_areas.'</li>';
                        }
                    } elseif($term->slug == $ppa){
                        if($test = get_page_by_path('/practice-areas/'.$term->slug)){
                            $second = '<li><a href="/practice-areas/'.$term->slug.'">'.$term->name.'</a>'.$more_practice_areas.'</li>';
                        } else {
                            $second = '<li>'.$term->name.$more_practice_areas.'</li>';
                        }
                    } else {
                        if($test = get_page_by_path('/practice-areas/'.$term->slug)){
                            $practice_areas[$i] .= '<li><a href="/practice-areas/'.$term->slug.'">'.$term->name.'</a>'.$more_practice_areas.'</li>';
                        } else {
                            $practice_areas[$i] .= '<li>'.$term->name.$more_practice_areas.'</li>';
                        }
                    }
                    $i++;
                }
                if($first && $second){
                    array_unshift($practice_areas,$first,$second);
                } elseif($first) {
                    array_unshift($practice_areas,$first);
                } elseif($second) {
                    array_unshift($practice_areas,$second);
                }
                if(count($practice_areas)>3){
                    $practice_areas = array_slice($practice_areas, 0, 3);
                }
                $practice_areas = implode(' ', $practice_areas);
            }
            $mini_bio = msd_child_excerpt($atty->ID);
            $atty_contact_info = '';
            $contact_info->the_meta($atty->ID);
            $contact_info->the_field('_attorney_phone');
            if($contact_info->get_the_value() != ''){ 
                $atty_contact_info .= '<li class="phone"><i class="icon-phone icon-large"></i> '.msd_str_fmt($contact_info->get_the_value(),'phone').'</li>';
            } 
            
            $contact_info->the_field('_attorney_mobile');
            if($contact_info->get_the_value() != ''){
                $atty_contact_info .= '<li class="mobile"><i class="icon-mobile-phone icon-large"></i> '.msd_str_fmt($contact_info->get_the_value(),'phone').'</li>';
            }
            
            $contact_info->the_field('_attorney_linked_in');
            if($contact_info->get_the_value() != ''){
                $atty_contact_info .= '<li class="linkedin"><a href="'.$contact_info->get_the_value().'"><i class="icon-linkedin-sign icon-large"></i> Connect</a></li>';
            }
            
            $contact_info->the_field('_attorney_bio_sheet');
            if($contact_info->get_the_value() != ''){
                $atty_contact_info .= '<li class="vcard"><a href="'.$contact_info->get_the_value().'"><i class="icon-download-alt icon-large"></i> Download Bio</a></li>';
            }
            
            $contact_info->the_field('_attorney_email');
            if($contact_info->get_the_value() != ''){
                $atty_contact_info .= '<li class="email"><i class="icon-envelope-alt icon-large"></i> '.msd_str_fmt($contact_info->get_the_value(),'email').'</li>';
            }
            $attystr = '
            <div class="atty '.$atty->post_name.'">
                <div class="headshot">
                    '.$headshot.'
                </div>
                <div class="info">
                    <h4><a href="'.get_post_permalink($atty->ID).'" title="'.$atty->post_title.'">'.$atty->post_title.'</a></h4>
                    <strong>Practice Areas</strong>
                    <ul class="practice-areas">
                    '.$practice_areas.'
                    </ul>';
                    if($dobio){
                        $attystr .= '
                        <div class="bio">'.$mini_bio.'</div>';
                        }
            $attystr .= '
                    <ul class="attorney-contact-info">
                    '.$atty_contact_info.'
                    </ul>
                </div>
            </div>';
            return $attystr;
    }   
        
        function sort_by_lastname( $a, $b ) {
            return $a->lastname == $b->lastname ? 0 : ( $a->lastname < $b->lastname ) ? -1 : 1;
        } 
        
        function get_all_practice_areas(){
            return get_terms('practice_area');
        }
  } //End Class
} //End if class exists statement