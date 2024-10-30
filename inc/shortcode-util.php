<?php

add_action( 'admin_init', 'luxento_toolkit_admin_init' );
add_action( 'admin_enqueue_scripts', 'luxento_toolkit_admin_enqueue_scripts' );
add_action( 'admin_footer', 'luxento_toolkit_print_elements', 15 );

function luxento_toolkit_admin_init(){
	if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
		add_filter( 'mce_external_plugins', 'luxento_toolkit_load_editor_plugin' );
		add_filter( 'mce_buttons', 'luxento_toolkit_add_editor_button' );
	}
}

function luxento_toolkit_load_editor_plugin($plugin_array){
	$plugin_array['luxento_toolkit_button'] = LUXENTO_TOOLKIT_DIR . 'assets/js/tinymce.js';
	return $plugin_array;
}

function luxento_toolkit_add_editor_button($buttons){
	$buttons[] = 'luxento_toolkit_button';
	return $buttons;
}

function luxento_toolkit_admin_enqueue_scripts($hook){
	if ( in_array( $hook, array( 'widgets.php', 'post.php', 'post-new.php', 'edit.php' ), true ) ){
		
		wp_enqueue_style( 'luxento-toolkit-featherlight', LUXENTO_TOOLKIT_DIR . 'assets/css/featherlight.css', array(), null );
		wp_enqueue_style( 'luxento-toolkit-admin-style', LUXENTO_TOOLKIT_DIR . 'assets/css/admin.style.css', array(), null );

		wp_enqueue_script( 'luxento-toolkit-featherlight', LUXENTO_TOOLKIT_DIR . 'assets/js/featherlight.js', array( 'jquery' ), null, true );
		wp_enqueue_script( 'luxento-toolkit-admin-script', LUXENTO_TOOLKIT_DIR . 'assets/js/admin.script.js', array( 'jquery' ), null, true );

		$localize_data = array(
			'ajax' => array(
				'url' => admin_url( 'admin-ajax.php' ),
				'security' => array(
					'load_elements' => wp_create_nonce( 'luxento-toolkit-load-elements' ),
				),
			),
			'translate' => array(
				'luxento_toolkit_elements' => esc_html__( 'Luxento Elements', 'luxento-toolkit' ),
			),
			'resource' => array(
				'icon' => LUXENTO_TOOLKIT_DIR . 'assets/images/icon.png',
			),
		);

		wp_localize_script( 'luxento-toolkit-admin-script', 'luxento_toolkit_variables', $localize_data );
	}
}

function luxento_toolkit_print_elements(){
	$screen = get_current_screen();
	

	if('post' === $screen->base ){

		$groups = array();
		$groups = apply_filters('luxento_toolkit_get_elements', $groups);

		if($groups){
			$allowed_tags = luxento_lite_get_allowed_tags();
			?>	
			<div id="luxento-toolkit-elements">
				<?php
				$is_first = true;		
				foreach ( $groups as $group_slug => $group ) : 
					
					$title_caret     = '+';
					$title_classes[] = 'luxento-toolkit-title';					
					$grid_style      = 'display:none;';

					if($is_first){
						$is_first      = false;
						$title_caret   = '-';
						$grid_style    = '';
						$title_classes[] = 'luxento-toolkit-other';					
					}
					?>

					<h3 class="<?php echo esc_attr( implode( $title_classes, ' ' ) ); ?>">
						<?php echo esc_attr( luxento_beautify( $group_slug ) ); ?>
						<small>(<?php echo esc_attr( count( $group ) );?>)</small>
						<span class="luxento-toolkit-caret">+</span>
					</h3>

					<div style="<?php echo esc_attr( $grid_style ); ?>">
						<div class="luxento-toolkit-row">
						
							<?php 
							$loop_index = 0;
							foreach ( $group as $element_slug => $element ) :
								if($loop_index && 0 === $loop_index  % 2){
									echo '</div>';
									echo '<div class="luxento-toolkit-row">';
								}								
								?>

								<div class="luxento-toolkit-col">								
								
									<span class="luxento-toolkit-caption" onclick="luxento_toolkit_Element.insert(jQuery(this));"><?php echo esc_attr( $element['name'] ); ?></span>
									<div class="luxento-toolkit-code">
										<?php echo wp_kses( $element['code'], $allowed_tags ); ?>
									</div>

								</div>
							<?php 
							$loop_index++;
							endforeach;
							?>
						</div>
					</div>
		     	<?php 		     	
		     	endforeach; 
		     	?>
			</div>
		<?php
		}
	}
}

function luxento_extract_shortcodes( $content, $enable_multi = false, $shortcodes = array() ) {
    $codes         = array();
    $regex_matches = '';
    $regex_pattern = get_shortcode_regex();

    preg_match_all( '/' . $regex_pattern . '/s', $content, $regex_matches );

    foreach ( $regex_matches[0] as $shortcode ) {
        $regex_matches_new = '';
        preg_match( '/' . $regex_pattern . '/s', $shortcode, $regex_matches_new );

        if ( in_array( $regex_matches_new[2], $shortcodes, true ) ) :
            $codes[] = array(
                'shortcode' => $regex_matches_new[0],
                'type'      => $regex_matches_new[2],
                'content'   => $regex_matches_new[5],
                'atts'      => shortcode_parse_atts( $regex_matches_new[3] ),
            );

            if ( ! $enable_multi ) {
                break;
            }
        endif;
    }

    return $codes;
}

function luxento_beautify( $string ) {
    $string = str_replace( '-', ' ', $string );
    return ucwords( str_replace( '_', ' ', $string ) );
}
