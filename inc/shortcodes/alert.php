<?php
add_filter('luxento_toolkit_get_elements', 'luxento_toolkit_register_alert');

function luxento_toolkit_register_alert($groups){
    $groups['alerts'][] = array(
        'name' => esc_html__( 'Alert success', 'luxento-toolkit' ),
        'code' => '[alert title="Title" style="1" ]Content alert success[/alert]',
    );

    $groups['alerts'][] = array(
        'name' => esc_html__( 'Alert info', 'luxento-toolkit' ),
        'code' => '[alert title="Title" style="2" ]Content alert info[/alert]',
    );

    $groups['alerts'][] = array(
        'name' => esc_html__( 'Alert warning', 'luxento-toolkit' ),
        'code' => '[alert title="Title" style="3" ]Content alert warning[/alert]',
    );

    $groups['alerts'][] = array(
        'name' => esc_html__( 'Alert danger', 'luxento-toolkit' ),
        'code' => '[alert title="Title" style="4" ]Content alert danger[/alert]',
    );

    return $groups;
}

add_shortcode('alert', 'luxento_toolkit_shortcode_alert');

function luxento_toolkit_shortcode_alert($atts, $content = null) {
    extract( shortcode_atts( array( 'style' => 1, 'title' => '' ), $atts ) );
    
    $classes = apply_filters('luxento_toolkit_alert_classes',array('luxento-alert'));
    switch((int)$atts['style']){
        case 1:
            $classes[] = 'luxento-alert-custom-1';
            break;
        case 2:
            $classes[] = 'luxento-alert-custom-2';
            break;
        case 3:
            $classes[] = 'luxento-alert-custom-3';
            break;
        default:
            $classes[] = 'luxento-alert-custom-4';
            break;
    }
    
    ob_start();
    ?>
    <span class="<?php echo esc_attr(implode(' ', $classes)); ?>">
        <?php if( $title ): ?>
        <span class="luxento-alert-title"><?php echo esc_attr($title ); ?></span>
        <?php endif; ?> <?php echo wp_kses( $content, luxento_lite_get_allowed_tags() ); ?> <span class="luxento-alert-control">x</span></span>
    <?php
    $string = ob_get_contents();
    ob_end_clean();
    
    return apply_filters( 'luxento_toolkit_alerts', $string, $atts, $content );
}