<?php
if ( ! defined( 'PB_IMPORTBUDDY' ) || ( true !== PB_IMPORTBUDDY ) ) {
	die( '<html></html>' );
}
Auth::require_authentication(); // Die if not logged in.

$page_title = 'Database Replace';
require_once( '_header.php' );
?>

<div class="wrap">
<?php
if ( ! file_exists( ABSPATH . 'wp-config.php' ) ) {
	$parentConfigMessage = '';
	$parentConfig =  dirname( ABSPATH ) . '/wp-config.php';
	echo $parentConfig;
	if ( @file_exists( $parentConfig ) ) {
		$parentConfigMessage = '<b>However</b>, a wp-config.php file was found in the parent directory as `' . $parentConfig . '`. <a href="#"><b>Click here</b></a> if you would like to run this tool using this wp-config.php file in the parent directory.';
	}
	pb_backupbuddy::alert( 'Error: This tool requires an existing WordPress installation to perform database replacements on. No WordPress wp-config.php configuration file was found in the same directory as importbuddy.php. ' . $parentConfigMessage . ' Note: When importing/restoring the ImportBuddy tool will automatically migrate the site/home URL and server directory paths for you.', true );
} else {
	require_once( '_dbreplace.php' );
}
?>
</div>

<?php
require_once( '_footer.php' );