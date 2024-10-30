<?php
add_filter('luxento_toolkit_get_elements', 'luxento_toolkit_register_list');

function luxento_toolkit_register_list($groups){
	$groups['list'][] = array(
		'name' => esc_html__( 'List', 'luxento-toolkit' ),
		'code' => '[luxento_toolkit_lists]<br/>[luxento_toolkit_list icon_class="fa fa-star"]Content 1[/luxento_toolkit_list]<br/>[luxento_toolkit_list icon_class="fa fa-star"]Content 2[/luxento_toolkit_list]<br/>[luxento_toolkit_list icon_class="fa fa-star"]Content 3[/luxento_toolkit_list]<br/>[/luxento_toolkit_lists]'
		);
	return $groups;
}

add_shortcode( 'luxento_toolkit_lists', 'luxento_toolkit_shortcode_lists' );
add_shortcode('luxento_toolkit_list', '__return_false');

function luxento_toolkit_shortcode_lists( $atts, $content ) {
	
	extract( shortcode_atts( array(), $atts ) );
	$matches = luxento_extract_shortcodes( $content, true, array( 'luxento_toolkit_list' ) );
	ob_start();
	?>
		<ul class="luxento-custom-list-style">
			<?php 
			for ( $i = 0; $i < count( $matches ); $i++ ) { ?>
				<li class="luxento-list-style-1">
					<?php 
					if(isset($matches[$i]['atts']['icon_class'])): ?>
						<i class="<?php echo esc_attr($matches[$i]['atts']['icon_class']); ?>"></i>
						<?php
					endif;
					echo do_shortcode($matches[$i]['content']); 
					?>
				</li>
				<?php
			}
			?>
        </ul>
	<?php

	$string = ob_get_contents();
	ob_end_clean();

	return apply_filters( 'luxento_toolkit_shortcode_lists', $string, $atts, $content );
}
