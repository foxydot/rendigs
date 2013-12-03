<?php
global $msd_hook;
$msd_hook = 'genesis_post_title';
//add_action('wp_footer','show_actions');

add_action('genesis_before_loop','msdlab_newsletter_page_title');
function msdlab_newsletter_page_title(){
   print '<h1 class="entry-title">Newsletters and Legal Alerts</h1>'; 
}

remove_action('genesis_post_title', 'genesis_do_post_title');
add_action('genesis_post_title', 'msdlab_newsletter_do_post_title');
function msdlab_newsletter_do_post_title(){
    global $newsletter_info;
    
    $title = apply_filters( 'genesis_post_title_text', get_the_title() );

    if ( 0 === mb_strlen( $title ) )
        return;

    //* Link it, if necessary
    if ( ! is_singular() && apply_filters( 'genesis_link_post_title', true ) ){
        $newsletter_info->the_meta();
        $title = sprintf( '<a href="%s" title="%s" rel="bookmark">%s</a>', $newsletter_info->get_the_value('_newsletter_pdf'), the_title_attribute( 'echo=0' ), $title );
    }

    //* Wrap in H1 on singular pages
    $wrap = is_singular() ? 'h1' : 'h2';

    //* Also, if HTML5 with semantic headings, wrap in H1
    $wrap = genesis_html5() && genesis_get_seo_option( 'semantic_headings' ) ? 'h1' : $wrap;

    //* Build the output
    $output = genesis_markup( array(
        'html5'   => "<{$wrap} %s>",
        'xhtml'   => sprintf( '<%s class="entry-title">%s</%s>', $wrap, $title, $wrap ),
        'context' => 'entry-title',
        'echo'    => false,
    ) );

    $output .= genesis_html5() ? "{$title}</{$wrap}>" : '';

    echo apply_filters( 'genesis_post_title_output', "$output \n" );
}

remove_filter('excerpt_more', 'new_excerpt_more');
remove_filter( 'get_the_content_more_link', 'new_excerpt_more' );
add_filter('excerpt_more', 'msdlab_newsletter_excerpt_more');
add_filter( 'get_the_content_more_link', 'msdlab_newsletter_excerpt_more' );
function msdlab_newsletter_excerpt_more($more) {
       global $post,$newsletter_info;
       $newsletter_info->the_meta();
    return ' <a class="moretag" href="'. $newsletter_info->get_the_value('_newsletter_pdf') . '">Download PDF&nbsp;<i class="icon-download"></i></a>';
}

genesis();
