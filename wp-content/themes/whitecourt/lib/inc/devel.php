<?php
//add_filter('pre_get_posts','what_is_the_query',100);
function what_is_the_query($query){
    ts_data($query);
    return $query;
}
function show_actions(){
    global $wp_filter,$msd_hook; 
    ts_var( $wp_filter[$msd_hook] );
}

//add_action('wp_head','list_all_practice_areas');

function list_all_practice_areas(){
    global $msd_lawfirm;
    $practice_areas = $msd_lawfirm->display_class->get_all_practice_areas();
    foreach($practice_areas AS $pa){
        $mypage = get_page_by_path('/practice-areas/'.$pa->slug);
        $has_page = $mypage?'TRUE':'FALSE';
        $content .= '"'.$pa->name.'","'.$pa->slug.'","'.$has_page.'"'."\n";
    }
    ts_data($content);
}
/*
* A useful troubleshooting function. Displays arrays in an easy to follow format in a textarea.
*/
if ( ! function_exists( 'ts_data' ) ) :
function ts_data($data){
	$ret = '<textarea class="troubleshoot" cols="100" rows="20">';
	$ret .= print_r($data,true);
	$ret .= '</textarea>';
	print $ret;
}
endif;
/*
 * A useful troubleshooting function. Dumps variable info in an easy to follow format in a textarea.
*/
if ( ! function_exists( 'ts_var' ) && function_exists( 'ts_data' ) ) :
function ts_var($var){
	ts_data(var_export( $var , true ));
}
endif;