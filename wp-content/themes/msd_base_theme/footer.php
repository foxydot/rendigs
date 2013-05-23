<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage msdbase
 * @since msdbase 3.1
 */
?>
<div class="clear"></div>
		</div>

		<div id="footer" class="footer">
<?php
	/* A sidebar in the footer? Yep. You can can customize
	 * your footer with four columns of widgets.
	 */
	get_sidebar( 'footer' );
?>
				<?php wp_nav_menu( array(  'container_class' => 'ftrNav', 'theme_location' => 'footer', 'fallback_cb' => 'false' ) ); ?>

				<?php msdbase_copyright(TRUE); ?>

				<?php do_action( 'msdbase_credits' ); ?>
				<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'msdbase' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'msdbase' ); ?>" rel="generator"><?php printf( __( 'Proudly powered by %s.', 'msdbase' ), 'WordPress' ); ?></a>
				</a>

<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>