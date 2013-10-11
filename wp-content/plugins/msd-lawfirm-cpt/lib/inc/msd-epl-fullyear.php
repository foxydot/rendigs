<?php
if (!class_exists('MSDEventFullYear')) {
    class MSDEventFullYear{
        //Methods
        /**
        * PHP 4 Compatible Constructor
        */
        function MSDEventFullYear(){$this->__construct();}
        
        /**
        * PHP 5 Constructor
        */        
        function __construct(){
           // add_action('template_redirect',array(&$this,'fix_404'));
            add_action('wp_enqueue_scripts',array(&$this,'get_calendar'));
            // hook add_query_vars function into query_vars
            add_filter('query_vars', array(&$this,'add_query_vars'));
            // hook add_rewrite_rules function into rewrite_rules_array
            add_filter('rewrite_rules_array', array(&$this,'add_rewrite_rules'));
        }
        
        function add_query_vars($aVars) {
            $aVars[] = "tgt_year";
            $aVars[] = "tgt_brand";
            return $aVars;
        }
 
        function add_rewrite_rules($aRules) {
            $aNewRules['calendar/([^/]+)/?$'] = 'index.php?pagename=calendar&tgt_year=$matches[1]';
            $aNewRules['calendar/([^/]+)/([^/]+)/?$'] = 'index.php?pagename=calendar&tgt_brand=$matches[2]&tgt_year=$matches[1]';
            $aRules = $aNewRules + $aRules;
            return $aRules;
        }
        
        function fix_404(){
            global $wp,$wp_query;
            if($wp->query_vars["pagename"] == 'calendar'){
                ts_data($wp_query);
                if( is_404() ){
                    $brand = $wp_query->query['tgt_brand'];
                    $year = $wp_query->query['tgt_year'];
                    $valid_year = FALSE;
                    if(preg_match('/[\d{4}]/i',$year)){
                        $valid_year = TRUE;
                    }
                    $valid_brand = TRUE;
                    if($brand != ''){
                        $valid_brand = FALSE;
                        if(in_array($brand,array('dice','rigzone'))){$valid_brand = TRUE;}
                    }
                    if( $valid_brand && $valid_year ){
                        status_header( '200' );
                        $wp_query->is_404 = null;
                    }
                }
            }
        }
        
        function get_calendar(){
            global $wp,$wp_query;
            if($wp->query_vars["pagename"] == 'calendar'){
                remove_action('genesis_entry_header','genesis_do_post_title');
                remove_action('genesis_post_title','genesis_do_post_title');
                remove_action('genesis_entry_content','genesis_do_post_content');
                remove_action( 'genesis_post_content', 'genesis_do_post_content' );
                add_action( 'genesis_post_content', array(&$this,'display_full_calendar') );
                
                wp_enqueue_style('msd-calendar-screen',plugin_dir_url(dirname(__FILE__)).'css/calendar-screen.css',NULL,1,'all');
                wp_enqueue_style('msd-calendar-print',plugin_dir_url(dirname(__FILE__)).'css/calendar-print.css',NULL,1,'print');
            }
        }

        function display_full_calendar(){
            global $wp,$wp_query,$date_info;
            if(isset($wp_query->query_vars['tgt_brand'])) {
                $brand = urldecode($wp_query->query_vars['tgt_brand']);
            }
            if(isset($wp_query->query_vars['tgt_year']) && !empty($wp_query->query_vars['tgt_year'])) {
                $year = urldecode($wp_query->query_vars['tgt_year']);
            } else {
                $year = date("Y");
            }
            switch($brand){
                case 'dice':
                    $event_type = array('all-professions','dice-physical','dice-virtual');
                    break;
                case 'rigzone':
                    $event_type = array('rigzone-physical');
                    break;
                default:
                    break;
            }
            $designations = array(
                'oil-gas-energy' => 'O/G',
                'diversity' => 'AP/Div',
                'technology' => 'Tech/Eng',
            );
            $args = array(
                'post_type' => 'targeted_event',
                'posts_per_page' => -1,
                'post_status' => array( 'publish', 'pending' ),
            );
            if(!empty($event_type)){
                $args['tax_query'][] = array(
                    'taxonomy' => 'event_type',
                    'field' => 'slug',
                    'terms' => $event_type
                );
            }
            $unprocessed_events = get_posts($args);
            $i=0;
            foreach($unprocessed_events AS $ue){
                $date_info->the_meta($ue->ID);
                $mydate = $date_info->get_the_value('event_datestamp');
                $events[date("Y",$mydate)][date("n",$mydate)][$mydate] = $ue;
                $events[date("Y",$mydate)][date("n",$mydate)][$mydate]->event_location = $date_info->get_the_value('event_location');
                $events[date("Y",$mydate)][date("n",$mydate)][$mydate]->event_date = $date_info->get_the_value('event_date');
                $events[date("Y",$mydate)][date("n",$mydate)][$mydate]->event_category = get_the_terms($ue->ID,'event_category');
                $events[date("Y",$mydate)][date("n",$mydate)][$mydate]->event_type = get_the_terms($ue->ID,'event_type');
                $i++;
            }
           $yearevents = $events[$year];
           for($m=1;$m<=12;$m++){
               $content = '';
               ksort($yearevents[$m]);
               foreach($yearevents[$m] AS $key => $event){
                   foreach($event->event_category AS $category){
                       $des = $designations[$category->slug];
                       $des_class = $category->slug;
                   }
                   foreach($event->event_type AS $type){
                       $des_class .= ' '.$type->slug;
                   }
                   $content .= '<div class="single event '.$des_class.'">';
                        if($event->post_status == "publish"){
                            $content .= '<a class="registration-link" href="'.get_post_permalink($event->ID).'">';
                        } else {
                            $content .= '<span class="registration-link">';
                        }
                            $content .= '<span class="date">'.date("j",$key).'</span><span class="city">'.$event->event_location.'</span><span class="category">'.$des.'</span>';
                        if($event->post_status == "publish"){
                            $content .= '</a>';
                        } else {
                            $content .= '</span>';
                        }
                   $content .= '</div>';
               }
               $calendar .= $this->month_wrapper($content,$m,$year);
           }
           $calendar = $this->year_wrapper($calendar,$year,$brand);
           print $calendar;
        }

        function month_wrapper($content,$m,$y){
            $ret = '<div class="month-cell '.strtolower(date("F",mktime(1,1,1,$m,1,$y))).'">
                <div class="month-hdr">'.date("F",mktime(1,1,1,$m,1,$y)).'</div>
                <div class="month-content">'.$content.'</div>
            </div>';
            return $ret;
        }
        
        function year_wrapper($content,$y,$brand){
            global $msd_epl_calendar;
            $brandassets = array(
                'dice' => array(
                    'logo' => '/wp-content/uploads/2013/07/logo-dice.png',
                    'phone' => '877.386.3323',
                    'website' => 'www.dicecareerfairs.com'
                ),
                'rigzone' => array(
                    'logo' => plugin_dir_url(dirname(__FILE__)).'img/rigzone-logo.png',
                    'phone' => '515.313.2284',
                    'website' => 'www.rigzone.com'
                ),
            );
            $ret .= '<div class="year-cell '.$brand.'">
            <div class="year-hdr">'.$y.' '.ucwords($brand).' Career Fair Schedule</div>
            <div class="year-content">'.$content.'</div>
            </div>';
            if(!empty($brand)){
                if($brand=='dice'){
                    $ret .= '<div class="legend"><span class="tech-engineering">Technology, Engineering & Security Clearance</span> | <span class="diversity">All Professions/Diversity</span> | <span class="virtual">Virtual</span></div>';
                }
                $ret .= '<div class="calendar-ftr"><div class="logo"><img src="'.$brandassets[$brand]['logo'].'"></div><div class="info">Subject to Change • Call to Confirm Dates<div class="brand-info">'.$brandassets[$brand]['phone'].' • '.$brandassets[$brand]['website'].'</div></div></div>';
            }
            return $ret;
        }
    }
}