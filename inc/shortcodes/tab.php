<?php
add_filter('luxento_toolkit_get_elements', 'luxento_toolkit_register_tab_1');

function luxento_toolkit_register_tab_1($groups){
	$groups['tabs'][] = array(
		'name' => esc_html__( 'Tab 1', 'luxento-toolkit' ),
		'code' => '[tabs style="1"]<br/>[tab title="Tab title 1" ]Tab Content 1[/tab]<br/>[tab title="Tab title 2"]Tab Content 2[/tab]<br/>[tab title="Tab title 3"]Tab Content 3[/tab]<br/>[/tabs]'
		);
	$groups['tabs'][] = array(
		'name' => esc_html__( 'Tab 2', 'luxento-toolkit' ),
		'code' => '[tabs style="2"]<br/>[tab title="Tab title 1" ]Tab Content 1[/tab]<br/>[tab title="Tab title 2"]Tab Content 2[/tab]<br/>[tab title="Tab title 3"]Tab Content 3[/tab]<br/>[/tabs]'
		);
	return $groups;
}

add_shortcode( 'tabs', 'luxento_toolkit_shortcode_tab' );
add_shortcode( 'tab', '__return_false' );

function luxento_toolkit_shortcode_tab( $atts, $content ) {
	$rand = rand();
	extract( shortcode_atts( array('style' => '1'), $atts ) );
	$style_id = isset($atts['style']) ? (int)$atts['style'] : 0 ; 
	$old_atts = $atts;
	unset($old_atts['style']);
	$classes = ( 1 == (int)$style ) ? 'luxento-megatab' : 'luxento-megatab-1';
	ob_start();
	$matches = luxento_extract_shortcodes( $content, true, array( 'tab' ) );
	?>
	<div class="widget luxento-widget-has-tab-in-single luxento-widget-has-tab-in-single-1">
		<div class="widget-content">
			<ul class="nav nav-tabs <?php echo esc_attr( $classes ); ?>">
				<?php
				for ( $i = 0; $i < count( $matches ); $i++ ) { ?>
					<li class="<?php echo esc_attr( $i == 0 ? 'active luxento-first-item' : ''  ); ?>" role="presentation">
						<a href="#tab<?php echo esc_attr( 'tab1-' . $i . '-' . $rand ); ?>" role="tab" data-toggle="tab" aria-controls="tab<?php echo esc_attr( 'tab1-' . $i . '-' . $rand ); ?>">
							<?php 
							$title = '';
							if(isset( $matches[$i]['atts']['title'] )){
								$title = $matches[$i]['atts']['title'];
							}else{
								if(!empty($old_atts)){
									$title = $old_atts['tab'.($i+1)];
								}
							}
							?>
							<?php echo wp_kses_post($title ); ?>
						</a>
					</li>
				<?php } ?>
			</ul>
			<div class="tab-content">
				<?php
				for ( $i = 0; $i < count( $matches ); $i++ ) { ?>
					<div class="tab-pane <?php echo esc_attr( $i == 0 ? 'active' : ''  ); ?>" id="tab<?php echo esc_attr( 'tab1-' . $i . '-' . $rand ); ?>" role="tabpanel">
						<p class="entry-detail luxento-custom-entry-detail luxento-has-dropcap"><?php echo do_shortcode( trim( (isset( $matches[$i]['content'] ) ? $matches[$i]['content'] : '' ) ) ); ?></p>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php
	$string = ob_get_contents();
	ob_end_clean();
	
	return apply_filters( 'luxento_toolkit_shortcode_tab', $string, $atts, $content );
}