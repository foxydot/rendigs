<?php
add_shortcode('button','msd_child_button_function');
function msd_child_button_function($atts, $content = null){	
	extract( shortcode_atts( array(
      'url' => null,
	  'target' => '_self'
      ), $atts ) );
	$ret = '<div class="button-wrapper">
<a class="readmore button" href="'.$url.'" target="'.$target.'">'.remove_wpautop($content).'</a>
</div>';
	return $ret;
}
add_shortcode('hero','msd_child_landing_page_hero');
function msd_child_landing_page_hero($atts, $content = null){
	$ret = '<div class="hero">'.remove_wpautop($content).'</div>';
	return $ret;
}
add_shortcode('callout','msd_child_landing_page_callout');
function msd_child_landing_page_callout($atts, $content = null){
	$ret = '<div class="callout">'.remove_wpautop($content).'</div>';
	return $ret;
}
function column_shortcode($atts, $content = null){
	extract( shortcode_atts( array(
	'cols' => '3',
	'position' => '',
	), $atts ) );
	switch($cols){
		case 5:
			$classes[] = 'one-fifth';
			break;
		case 4:
			$classes[] = 'one-fouth';
			break;
		case 3:
			$classes[] = 'one-third';
			break;
		case 2:
			$classes[] = 'one-half';
			break;
	}
	switch($position){
		case 'first':
		case '1':
			$classes[] = 'first';
		case 'last':
			$classes[] = 'last';
	}
	return '<div class="'.implode(' ',$classes).'">'.$content.'</div>';
}

add_shortcode('columns','column_shortcode');

function msdlab_clean_email($atts, $content = null){
    extract( shortcode_atts( array(
        'email' => false,
        'subject' => false,
        'cc' => false,
        'bcc' => false,
        'body' => false,
    ), $atts ) );
    $qs = '';
    if($subject || $cc || $bcc || $body){
        $qs = '?';
        $qs .= $subject?'subject="'.$subject.'"':'';
        $qs .= $cc?'cc="'.$cc.'"':'';
        $qs .= $bcc?'bcc="'.$bcc.'"':'';
        $qs .= $body?'body="'.$body.'"':'';
    }
    $address = $email?$email:$content;
    return '<a href="mailto:'.antispambot($address).$qs.'">'.antispambot($content).'</a>';
}
add_shortcode('clean_email','msdlab_clean_email');
