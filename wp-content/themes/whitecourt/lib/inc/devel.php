<?php
//add_filter('pre_get_posts','what_is_the_query',100);
function what_is_the_query($query){
    ts_data($query);
    return $query;
}
//add_action('wp_footer','get_hooks');
function get_hooks(){
    
global $wp_filter; ts_var( $wp_filter['get_the_excerpt'] );
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