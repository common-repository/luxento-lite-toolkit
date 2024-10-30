<?php
add_filter('luxento_toolkit_get_elements', 'luxento_toolkit_register_dropcaps_1');

function luxento_toolkit_register_dropcaps_1($groups){
	$groups['dropcaps'][] = array(
		'name' => esc_html__( 'Dropcaps 1', 'luxento-toolkit' ),
		'code' => '[dropcaps style="1" drop_text="D"]ropcap style 1[/dropcaps]'
		);
	$groups['dropcaps'][] = array(
		'name' => esc_html__( 'Dropcaps 2', 'luxento-toolkit' ),
		'code' => '[dropcaps style="2" drop_text="D"]ropcaps style 2[/dropcaps]'
		);
	$groups['dropcaps'][] = array(
		'name' => esc_html__( 'Dropcaps 3', 'luxento-toolkit' ),
		'code' => '[dropcaps style="3" drop_text="D"]ropcaps style 3[/dropcaps]'
		);

	return $groups;
}

add_shortcode( 'dropcaps', 'luxento_toolkit_shortcode_dropcap' );

function luxento_toolkit_shortcode_dropcap( $atts, $content ) {
	
	extract( shortcode_atts( array('style' => 1), $atts ) );
	$drop_text = isset($atts['drop_text']) ? $atts['drop_text'] : '';

	$classes = apply_filters('luxento_toolkit_dropcap_classes',array( 'entry-detail', 'luxento-custom-entry-detail' ));
    switch((int)$atts['style']){
        case 1:
            $classes[] = 'luxento-has-dropcap-style-1';
            break;
        case 2:
            $classes[] = 'luxento-has-dropcap-style-2';
            break;
        case 3:
            $classes[] = 'luxento-has-dropcap';
            break;
        default:
            $classes[] = 'luxento-has-dropcap-style-1';
            break;
    } 
    ob_start();
    ?>
	<p class="<?php echo esc_attr(implode(' ', $classes)); ?>"><span><?php echo esc_attr( $drop_text );  ?></span><?php echo wp_kses( $content, luxento_lite_get_allowed_tags() ); ?></p>
	<?php
	$string = ob_get_contents();
    ob_end_clean();

	return apply_filters( 'luxento_toolkit_shortcode_dropcap', $string, $atts, $content );
}
