<?php
add_action('wp_enqueue_scripts','msd_child_get_bootstrap',0);
function msd_child_get_bootstrap(){
    wp_enqueue_style('bootstrap-style','//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.no-icons.min.css');
    wp_enqueue_script('bootstrap-jquery','//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js',array('jquery'));
}
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_sidebar_content' );
add_action('genesis_after_loop','msd_child_atty_tabs');
function msd_child_atty_tabs(){
    global $post,$msd_lawfirm,$contact_info;
    
    print '<ul class="nav nav-tabs" id="myTab">
    <li class="active"><a href="#alpha" data-toggle="tab">Alphabetical</a></li>
    <li><a href="#practice-area" data-toggle="tab">By Practice Area</a></li>
    </ul>
     
    <div class="tab-content">
    <div class="tab-pane active" id="alpha">';
    $attys = $msd_lawfirm->display_class->get_all_attorneys();
    foreach($attys AS $atty){
        print $msd_lawfirm->display_class->atty_display($atty);
    }
    
    print '</div>
    <div class="tab-pane" id="practice-area">';
    $practice_areas = get_terms('practice_area');
    foreach($practice_areas AS $pa){
        $attys = $msd_lawfirm->display_class->get_atty_by_practice($pa->slug);
        if(count($attys)>0){
            print '<h3>'.$pa->name.'</h3>';
        }
        foreach($attys AS $atty){
            print $msd_lawfirm->display_class->atty_display($atty);
        }
    }
    print '</div>
    </div>';
print $tabs;
}
genesis();