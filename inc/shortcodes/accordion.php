<?php
add_filter('luxento_toolkit_get_elements', 'luxento_toolkit_register_accordion');

function luxento_toolkit_register_accordion($groups){
	$groups['accordion & toggle'][] = array(
		'name' => esc_html__( 'Accordion', 'luxento-toolkit' ),
		'code' => '[accordions]<br/>[accordion title="Accordion title 1"]Accordion content 1[/accordion]<br/>[accordion title="Accordion title 2"]Accordion content 2[/accordion]<br/>[accordion title="Accordion title 3"]Accordion content 3[/accordion]<br/>[/accordions]',
		);
	return $groups;
}

add_shortcode('accordions', 'luxento_toolkit_accordions');
add_shortcode('accordion', '__return_false' );

function luxento_toolkit_accordions( $atts, $content = null){

	$matches = luxento_extract_shortcodes( $content, true, array( 'accordion' ) );
	$accordions_id = 'accordions-' . mt_rand( 10, 100000 );
	for ( $i = 0; $i < count( $matches ); $i++ ) {
		$accordionid[$i] = 'accordion-' . mt_rand( 10, 100000 ) . '-' . strtolower( str_replace( array( "!", "@", "#", "$", "%", "^", "&", "*", ")", "(", "+", "=", "[", "]", "/", "\\", ";", "{", "}", "|", '"', ":", "<", ">", "?", "~", "`", " " ), "", $matches[$i]['atts']['title'] ) );
	}
	ob_start();
	?>
	<div class="luxento-accordion" data-collapse="accordion">
		<?php
		for ( $i = 0; $i < count( $matches ); $i++ ) {
			$active = '';
			if ( $i == 0 ) {
				$active = 'open';
			}
			?>
			<h6 class="<?php echo esc_attr( $active ? $active : '' ); ?>"><?php echo (isset( $matches[$i]['atts']['title'] ) ? $matches[$i]['atts']['title'] : ''); ?></h6>
			<div class="luxento-acc-content">
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
	
	return apply_filters( 'luxento_toolkit_accordions', $string, $atts, $content );
}