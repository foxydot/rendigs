<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.  The actual display of comments is
 * handled by a callback to msdbase_comment which is
 * located in the functions.php file.
 *
 * @package WordPress
 * @subpackage msdbase
 * @since msdbase 3.1
 */
?>

			
<?php if ( post_password_required() ) : ?>
				<p><?php _e( 'This post is password protected. Enter the password to view any comments.', 'msdbase' ); ?></p>
			
<?php
		/* Stop the rest of comments.php from being processed,
		 * but don't kill the script entirely -- we still have
		 * to fully load the template.
		 */
		return;
	endif;
?>

<?php
	// You can start editing here -- including this comment!
?>

<?php if ( have_comments() ) : ?>
			<h3><?php
			printf( _n( 'One Response to %2$s', '%1$s Responses to %2$s', get_comments_number(), 'msdbase' ),
			number_format_i18n( get_comments_number() ), '<em>' . get_the_title() . '</em>' );
			?></h3>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			
				<?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'msdbase' ) ); ?>
			<?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'msdbase' ) ); ?>
			
<?php endif; // check for comment navigation ?>

			<ol>
				<?php
					/* Loop through and list the comments. Tell wp_list_comments()
					 * to use msdbase_comment() to format the comments.
					 * If you want to overload this in a child theme then you can
					 * define msdbase_comment() and that will be used instead.
					 * See msdbase_comment() in msdbase/functions.php for more.
					 */
					wp_list_comments( array( 'callback' => 'msdbase_comment' ) );
				?>
			</ol>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			
				<?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'msdbase' ) ); ?>
			<?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'msdbase' ) ); ?>
			
<?php endif; // check for comment navigation ?>

<?php else : // or, if we don't have comments:

	/* If there are no comments and comments are closed,
	 * let's leave a little note, shall we?
	 */
	if ( ! comments_open() ) :
?>
	<?php //on second thought, no note! ?>
<?php endif; // end ! comments_open() ?>

<?php endif; // end have_comments() ?>

<?php comment_form(); ?>


