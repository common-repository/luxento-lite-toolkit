<?php
add_filter('luxento_toolkit_get_elements', 'luxento_toolkit_register_caption');

function luxento_toolkit_register_caption($groups){
	$groups['caption'][] = array(
		'name' => esc_html__( 'Captions', 'luxento-toolkit' ),
		'code' => '[luxento_toolkit_captions]Content[/luxento_toolkit_captions]'
		);

	return $groups;
}

add_shortcode( 'luxento_toolkit_captions', 'luxento_toolkit_shortcode_caption' );

function luxento_toolkit_shortcode_caption( $atts, $content ) {
	$string = '';
	$string .= '<div class="luxento-wrap-title"><h5>'.$content.'</h5></div>';
	
	return apply_filters( 'luxento_toolkit_shortcode_captions', $string, $atts, $content );
}
