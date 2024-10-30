<?php
add_filter('luxento_toolkit_get_elements', 'luxento_toolkit_register_toggle');

function luxento_toolkit_register_toggle($groups){
	$groups['accordion & toggle'][] = array(
		'name' => esc_html__( 'Toggle', 'luxento-toolkit' ),
		'code' => '[toggles]<br/>[toggle title="Toggle title 1"]Toggle content 1[/toggle]<br/>[toggle title="Toggle title 2"]Toggle content 2[/toggle]<br/>[toggle title="Toggle title 3"]Toggle content 3[/toggle]<br/>[/toggles]',
		);
	return $groups;
}

add_shortcode('toggles', 'luxento_toolkit_toggles');
add_shortcode('toggle', '__return_false' );

function luxento_toolkit_toggles( $atts, $content = null){
	extract( shortcode_atts( array('style' => 1 ), $atts ) );

	$matches = luxento_extract_shortcodes( $content, true, array( 'toggle' ) );
	$toggles_id = 'toggles-' . mt_rand( 10, 100000 );
	for ( $i = 0; $i < count( $matches ); $i++ ) {
		$toggleid[$i] = 'toggle-' . mt_rand( 10, 100000 ) . '-' . strtolower( str_replace( array( "!", "@", "#", "$", "%", "^", "&", "*", ")", "(", "+", "=", "[", "]", "/", "\\", ";", "{", "}", "|", '"', ":", "<", ">", "?", "~", "`", " " ), "", $matches[$i]['atts']['title'] ) );
	}
	ob_start();
	?>
	<div class="luxento-toggle">
		<?php
		for ( $i = 0; $i < count( $matches ); $i++ ) {
			$active = '';
			if ( $i == 0 ) {
				$active = 'open';
			}
			?>
			<h6 class="<?php echo esc_attr( $active ? $active : '' ); ?>"> <span><?php echo esc_html__( 'X', 'luxento-toolkit' ); ?></span> <?php echo (isset( $matches[$i]['atts']['title'] ) ? $matches[$i]['atts']['title'] : ''); ?></h6>
			<div class="luxento-toggle-content">
				<p class="entry-detail luxento-custom-entry-detail">
					<?php echo do_shortcode( trim( (isset( $matches[$i]['content'] ) ? $matches[$i]['content'] : '' ) ) ); ?>
				</p>
			</div>
			<?php
		}
		?>
	</div>
	<?php
	$string = ob_get_contents();
	ob_end_clean();
	
	return apply_filters( 'luxento_toolkit_toggles', $string, $atts, $content );
}