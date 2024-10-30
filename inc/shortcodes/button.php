<?php
add_filter('luxento_toolkit_get_elements', 'luxento_toolkit_register_buttons');

function luxento_toolkit_register_buttons($groups){
    $groups['buttons'][] = array(
        'name' => esc_html__( 'Big button style 1', 'luxento-toolkit' ),
        'code' => '[button type="big-1"]Content[/button]'
        );
    $groups['buttons'][] = array(
        'name' => esc_html__( 'Big button style 2', 'luxento-toolkit' ),
        'code' => '[button type="big-2"]Content[/button]'
        );
    $groups['buttons'][] = array(
        'name' => esc_html__( 'Big button style 3', 'luxento-toolkit' ),
        'code' => '[button type="big-3"]Content[/button]'
        );
    $groups['buttons'][] = array(
        'name' => esc_html__( 'Big button style 4', 'luxento-toolkit' ),
        'code' => '[button type="big-4"]Content[/button]'
        );
    $groups['buttons'][] = array(
        'name' => esc_html__( 'Medium button style 1', 'luxento-toolkit' ),
        'code' => '[button type="medium-1"]Content[/button]'
        );
    $groups['buttons'][] = array(
        'name' => esc_html__( 'Medium button style 2', 'luxento-toolkit' ),
        'code' => '[button type="medium-2"]Content[/button]'
        );
    $groups['buttons'][] = array(
        'name' => esc_html__( 'Medium button style 3', 'luxento-toolkit' ),
        'code' => '[button type="medium-3"]Content[/button]'
        );
    $groups['buttons'][] = array(
        'name' => esc_html__( 'Medium button style 4', 'luxento-toolkit' ),
        'code' => '[button type="medium-4"]Content[/button]'
        );
    $groups['buttons'][] = array(
        'name' => esc_html__( 'Small button style 1', 'luxento-toolkit' ),
        'code' => '[button type="small-1"]Content[/button]'
        );
    $groups['buttons'][] = array(
        'name' => esc_html__( 'Small button style 2', 'luxento-toolkit' ),
        'code' => '[button type="small-2"]Content[/button]'
        );
    $groups['buttons'][] = array(
        'name' => esc_html__( 'Small button style 3', 'luxento-toolkit' ),
        'code' => '[button type="small-3"]Content[/button]'
        );
    $groups['buttons'][] = array(
        'name' => esc_html__( 'Small button style 4', 'luxento-toolkit' ),
        'code' => '[button type="small-4"]Content[/button]'
        );

    return $groups;
}

add_shortcode('button', 'luxento_toolkit_shortcode_button');

function luxento_toolkit_shortcode_button($atts, $content = null){
    extract(shortcode_atts(array(
        'type'  => 'big-1',
        'title' => ''
        ), $atts));

    $classes = apply_filters('luxento_toolkit_button_classes',array());

    switch( $type ){
        case 'big-1':
            $classes[] = 'b1';
            break;
        case 'big-2':
            $classes[] = 'b2';
            break;
        case 'big-3':
            $classes[] = 'b3';
            break;
        case 'big-4':
            $classes[] = 'b4';
            break;
        case 'medium-1':
            $classes[] = 'm1';
            break;
        case 'medium-2':
            $classes[] = 'm2';
            break;
        case 'medium-3':
            $classes[] = 'm3';
            break;
        case 'medium-4':
            $classes[] = 'm4';
            break;
        case 'small-1':
            $classes[] = 's1';
            break;
        case 'small-2':
            $classes[] = 's2';
            break;
        case 'small-3':
            $classes[] = 's3';
            break;
        case 'small-4':
            $classes[] = 's4';
            break;
        default:
            $classes[] = 'b1';
            break;
    }
    ob_start(); ?>
    <button class="luxento-button-<?php echo esc_attr(implode(' ', $classes)); ?>"><?php echo wp_kses( $content, luxento_lite_get_allowed_tags() ); ?></button>
    <?php
    $string = ob_get_contents();
    ob_end_clean();
    
    return apply_filters( 'luxento_toolkit_buttons', $string, $atts, $content );
}