<br><?php
$tests = array();


$directories = array(
	ABSPATH . '',
	ABSPATH . 'wp-includes/',
	ABSPATH . 'wp-admin/',
	ABSPATH . 'wp-content/themes/',
	ABSPATH . 'wp-content/plugins/',
	ABSPATH . 'wp-content/',
	ABSPATH . 'wp-content/uploads/',
	ABSPATH . 'wp-includes/',
	pb_backupbuddy::$options['backup_directory'],
	pb_backupbuddy::$options['log_directory'],
	pb_backupbuddy::$options['temp_directory'],
);


foreach( $directories as $directory ) {
	
	$mode_octal_four = '<i>' . __( 'Unknown', 'it-l10n-backupbuddy' ) . '</i>';
	$owner = '<i>' . __( 'Unknown', 'it-l10n-backupbuddy' ) . '</i>';
	
	$stats = pluginbuddy_stat::stat( $directory );
	if ( false !== $stats ) {
		$mode_octal_four = $stats['mode_octal_four'];
		$owner = $stats['uid'] . ':' . $stats['gid'];
	}
	$this_test = array(
					'title'			=>		'/' . str_replace( ABSPATH, '', $directory ),
					'suggestion'	=>		'<= 755',
					'value'			=>		$mode_octal_four,
					'owner'			=>		$owner,
				);
	if ( false === $stats || $mode_octal_four > 755 ) {
		$this_test['status'] = __('WARNING', 'it-l10n-backupbuddy' );
	} else {
		$this_test['status'] = __('OK', 'it-l10n-backupbuddy' );
	}
	array_push( $tests, $this_test );
	
} // end foreach.


?>

<table class="widefat">
	<thead>
		<tr class="thead">
			<?php 
				echo '<th>', __('Relative Path','it-l10n-backupbuddy' ),'</th>',
					'<th>', __('Suggestion', 'it-l10n-backupbuddy' ), '</th>',
					'<th>', __('Value', 'it-l10n-backupbuddy' ), '</th>',
					'<th>', __('Owner (UID:GID)', 'it-l10n-backupbuddy' ), '</th>',
					// '<th>', __('Result', 'it-l10n-backupbuddy' ), '</th>',
					 '<th style="width: 60px;">', __('Status', 'it-l10n-backupbuddy' ), '</th>';
			?>
		</tr>
	</thead>
	<tfoot>
		<tr class="thead">
			<?php 
				echo '<th>', __('Relative Path','it-l10n-backupbuddy' ),'</th>',
					'<th>', __('Suggestion', 'it-l10n-backupbuddy' ), '</th>',
					'<th>', __('Value', 'it-l10n-backupbuddy' ), '</th>',
					'<th>', __('Owner (UID:GID)', 'it-l10n-backupbuddy' ), '</th>',
					// '<th>', __('Result', 'it-l10n-backupbuddy' ), '</th>',
					'<th style="width: 60px;">', __('Status', 'it-l10n-backupbuddy' ), '</th>';
			?>
		</tr>
	</tfoot>
	<tbody>
		<?php
		foreach( $tests as $this_test ) {
			echo '<tr class="entry-row alternate">';
			echo '	<td>' . $this_test['title'] . '</td>';
			echo '	<td>' . $this_test['suggestion'] . '</td>';
			echo '	<td>' . $this_test['value'] . '</td>';
			echo '	<td>' . $this_test['owner'] . '</td>';
			//echo '	<td>' . $this_test['status'] . '</td>';
			echo '	<td>';
			if ( $this_test['status'] == __('OK', 'it-l10n-backupbuddy' ) ) {
				//echo '<div style="background-color: #22EE5B; border: 1px solid #E2E2E2;">&nbsp;&nbsp;&nbsp;</div>';
				echo '<span class="pb_label pb_label-success">Pass</span>';
			} elseif ( $this_test['status'] == __('FAIL', 'it-l10n-backupbuddy' ) ) {
				//echo '<div style="background-color: #CF3333; border: 1px solid #E2E2E2;">&nbsp;&nbsp;&nbsp;</div>';
				echo '<span class="pb_label pb_label-important">Fail</span>';
			} elseif ( $this_test['status'] == __('WARNING', 'it-l10n-backupbuddy' ) ) {
				//echo '<div style="background-color: #FEFF7F; border: 1px solid #E2E2E2;">&nbsp;&nbsp;&nbsp;</div>';
				echo '<span class="pb_label pb_label-warning">Warning</span>';
			} else {
				echo 'unknown';
			}
			echo '	</td>';
			echo '</tr>';
		}
		?>
	</tbody>
</table>

<br><br>