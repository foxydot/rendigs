<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage msdbase
 * @since msdbase 3.1
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'msdbase' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
</head>

<body <?php body_class(); ?>>
	<div id="body-wrapper" class="body-wrapper">
		<div id="header" class="header">
			<div id="header-nav" class="header-nav">
				<?php wp_nav_menu( array(  'container_class' => 'hdrNav', 'theme_location' => 'header', 'fallback_cb' => 'false' ) ); ?>
			</div>
			<<?php print is_front_page()?'h1':'h2'; ?> class="logo">
				<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
			</<?php print is_front_page()?'h1':'h2'; ?>>
			
			<h2 class="description">
				<?php bloginfo( 'description' ); ?>
			</h2>
			<?php get_search_form(); ?>
		</div>
		<div id="nav-wrapper" class="nav-wrapper">
			<!-- This adds the page menu controlled from the wp admin section -->
				<?php /* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu.  The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.  */ ?>
				<?php wp_nav_menu( array( 'container_class' => 'mainNav', 'theme_location' => 'primary' ) ); ?>
			<div id="social-media" class="social-media">
				<?php if(get_option('msdbase_facebook_link')!=""){ ?>
				<a href="<?php echo get_option('msdbase_facebook_link'); ?>" class="fb" title="Join Us on Facebook!"></a>
				<?php }?>
				<?php if(get_option('msdbase_linkedin_link')!=""){ ?>
				<a href="<?php echo get_option('msdbase_linkedin_link'); ?>" class="in" title="Link In!"></a>
				<?php }?>
				<?php if(get_option('msdbase_twitter_user')!=""){ ?>
				<a href="http://www.twitter.com/<?php echo get_option('msdbase_twitter_user'); ?>" class="tw" title="Follow Us on Twitter!"></a>
				<?php }?>
				<a href="<?php bloginfo('rss2_url'); ?>" title="RSS" class="rss"></a>
			</div>	
		<div class="clear"></div>
		</div>
		
		<div id="content-wrapper" class="content-wrapper">