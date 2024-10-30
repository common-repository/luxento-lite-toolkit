<?php
add_filter('luxento_toolkit_get_elements', 'luxento_toolkit_register_grid_elements');

function luxento_toolkit_register_grid_elements($groups){
    $groups['grids'][] = array(
        'name' => esc_html__( 'Grid 100%', 'luxento-toolkit' ),
        'code' => '[luxento_toolkit_grid_row]<br/>[luxento_toolkit_grid_col col=12]TEXT[/luxento_toolkit_grid_col]<br/>[/luxento_toolkit_grid_row]<br/>'
        );
    $groups['grids'][] = array(
        'name' => esc_html__( 'Grid 50% x2', 'luxento-toolkit' ),
        'code' => '[luxento_toolkit_grid_row]<br/>[luxento_toolkit_grid_col col=6]TEXT[/luxento_toolkit_grid_col]<br/>[luxento_toolkit_grid_col col=6]TEXT[/luxento_toolkit_grid_col]<br/>[/luxento_toolkit_grid_row]<br/>'
        );
    $groups['grids'][] = array(
        'name' => esc_html__( 'Grid 33% x3', 'luxento-toolkit' ),
        'code' => '[luxento_toolkit_grid_row]<br/>[luxento_toolkit_grid_col col=4]TEXT[/luxento_toolkit_grid_col]<br/>[luxento_toolkit_grid_col col=4]TEXT[/luxento_toolkit_grid_col]<br/>[luxento_toolkit_grid_col col=4]TEXT[/luxento_toolkit_grid_col]<br/>[/luxento_toolkit_grid_row]<br/>'
        );
    $groups['grids'][] = array(
        'name' => esc_html__( 'Grid 33% - 66%', 'luxento-toolkit' ),
        'code' => '[luxento_toolkit_grid_row]<br/>[luxento_toolkit_grid_col col=4]TEXT[/luxento_toolkit_grid_col]<br/>[luxento_toolkit_grid_col col=8]TEXT[/luxento_toolkit_grid_col]<br/>[/luxento_toolkit_grid_row]<br/>'
        );
    $groups['grids'][] = array(
        'name' => esc_html__( 'Grid 25% - 50% - 25%', 'luxento-toolkit' ),
        'code' => '[luxento_toolkit_grid_row]<br/>[luxento_toolkit_grid_col col=3]TEXT[/luxento_toolkit_grid_col]<br/>[luxento_toolkit_grid_col col=6]TEXT[/luxento_toolkit_grid_col]<br/>[luxento_toolkit_grid_col col=3]TEXT[/luxento_toolkit_grid_col]<br/>[/luxento_toolkit_grid_row]<br/>'
        );
    $groups['grids'][] = array(
        'name' => esc_html__( 'Grid 25% x4', 'luxento-toolkit' ),
        'code' => '[luxento_toolkit_grid_row]<br/>[luxento_toolkit_grid_col col=3]TEXT[/luxento_toolkit_grid_col]<br/>[luxento_toolkit_grid_col col=3]TEXT[/luxento_toolkit_grid_col]<br/>[luxento_toolkit_grid_col col=3]TEXT[/luxento_toolkit_grid_col]<br/>[luxento_toolkit_grid_col col=3]TEXT[/luxento_toolkit_grid_col]<br/>[/luxento_toolkit_grid_row]<br/>'
        );
    $groups['grids'][] = array(
        'name' => esc_html__( 'Grid 25% - 75%', 'luxento-toolkit' ),
        'code' => '[luxento_toolkit_grid_row]<br/>[luxento_toolkit_grid_col col=3]TEXT[/luxento_toolkit_grid_col]<br/>[luxento_toolkit_grid_col col=9]TEXT[/luxento_toolkit_grid_col]<br/>[/luxento_toolkit_grid_row]<br/>'
        );
    $groups['grids'][] = array(
        'name' => esc_html__( 'Grid 16.6% - 66.6% - 16.6%', 'luxento-toolkit' ),
        'code' => '[luxento_toolkit_grid_row]<br/>[luxento_toolkit_grid_col col=2]TEXT[/luxento_toolkit_grid_col]<br/>[luxento_toolkit_grid_col col=8]TEXT[/luxento_toolkit_grid_col]<br/>[luxento_toolkit_grid_col col=2]TEXT[/luxento_toolkit_grid_col]<br/>[/luxento_toolkit_grid_row]<br/>'
        );
    $groups['grids'][] = array(
        'name' => esc_html__( 'Grid 16.6% - 16.6% - 16.6% - 50%', 'luxento-toolkit' ),
        'code' => '[luxento_toolkit_grid_row]<br/>[luxento_toolkit_grid_col col=2]TEXT[/luxento_toolkit_grid_col]<br/>[luxento_toolkit_grid_col col=2]TEXT[/luxento_toolkit_grid_col]<br/>[luxento_toolkit_grid_col col=2]TEXT[/luxento_toolkit_grid_col]<br/>[luxento_toolkit_grid_col col=6]TEXT[/luxento_toolkit_grid_col]<br/>[/luxento_toolkit_grid_row]<br/>'
        );
    $groups['grids'][] = array(
        'name' => esc_html__( 'Grid 16.6% x6', 'luxento-toolkit' ),
        'code' => '[luxento_toolkit_grid_row]<br/>[luxento_toolkit_grid_col col=2]TEXT[/luxento_toolkit_grid_col]<br/>[luxento_toolkit_grid_col col=2]TEXT[/luxento_toolkit_grid_col]<br/>[luxento_toolkit_grid_col col=2]TEXT[/luxento_toolkit_grid_col]<br/>[luxento_toolkit_grid_col col=2]TEXT[/luxento_toolkit_grid_col]<br/>[luxento_toolkit_grid_col col=2]TEXT[/luxento_toolkit_grid_col]<br/>[luxento_toolkit_grid_col col=2]TEXT[/luxento_toolkit_grid_col]<br/>[/luxento_toolkit_grid_row]<br/>'
        );
    $groups['grids'][] = array(
        'name' => esc_html__( 'Grid 66% - 33%', 'luxento-toolkit' ),
        'code' => '[luxento_toolkit_grid_row]<br/>[luxento_toolkit_grid_col col=8]TEXT[/luxento_toolkit_grid_col]<br/>[luxento_toolkit_grid_col col=4]TEXT[/luxento_toolkit_grid_col]<br/>[/luxento_toolkit_grid_row]<br/>'
        );
    $groups['grids'][] = array(
        'name' => esc_html__( 'Grid 83.3% - 16.6%', 'luxento-toolkit' ),
        'code' => '[luxento_toolkit_grid_row]<br/>[luxento_toolkit_grid_col col=10]TEXT[/luxento_toolkit_grid_col]<br/>[luxento_toolkit_grid_col col=2]TEXT[/luxento_toolkit_grid_col]<br/>[/luxento_toolkit_grid_row]<br/>'
        );
    return $groups;
}

add_shortcode( 'luxento_toolkit_grid_row', 'luxento_toolkit_shortcode_grid_row' );
add_shortcode( 'luxento_toolkit_grid_col', '__return_false' );

function luxento_toolkit_shortcode_grid_row( $atts, $content = null ) {
    extract( shortcode_atts( array(), $atts ) );

    $cols = luxento_extract_shortcodes( $content, true, array( 'luxento_toolkit_grid_col' ) );

    $output = '<div class="row">';

    if ($cols) {
        foreach ($cols as $col) {
            $output .= sprintf( '<div class="col-lg-%s">%s</div>', (int)$col['atts']['col'], do_shortcode( $col['content'] ) );
        }
    }

    $output.= '</div>';

    return apply_filters( 'luxento_toolkit_shortcode_grid_row', $output, $atts, $content );
}
