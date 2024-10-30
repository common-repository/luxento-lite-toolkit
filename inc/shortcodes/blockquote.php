<?php
add_filter('luxento_toolkit_get_elements', 'luxento_toolkit_register_blockquote_1');

function luxento_toolkit_register_blockquote_1($groups){
    $groups['blockquotes'][] = array(
        'name' => esc_html__( 'Blockquote 1', 'luxento-toolkit' ),
        'code' => '[luxento_toolkit_blockquote style="1" author="- Author -"]Blockquote Content[/luxento_toolkit_blockquote]'
        );
    $groups['blockquotes'][] = array(
        'name' => esc_html__( 'Blockquote 2', 'luxento-toolkit' ),
        'code' => '[luxento_toolkit_blockquote style="2" author="- Author -"]Blockquote Content[/luxento_toolkit_blockquote]'
        );
    $groups['blockquotes'][] = array(
        'name' => esc_html__( 'Blockquote 3', 'luxento-toolkit' ),
        'code' => '[luxento_toolkit_blockquote style="3" author="- Author -"]Blockquote Content[/luxento_toolkit_blockquote]'
        );
    $groups['blockquotes'][] = array(
        'name' => esc_html__( 'Blockquote 4', 'luxento-toolkit' ),
        'code' => '[luxento_toolkit_blockquote style="4" author="- Author -"]Blockquote Content[/luxento_toolkit_blockquote]'
        );

    return $groups;
}

add_shortcode('luxento_toolkit_blockquote', 'luxento_toolkit_shortcode_blockquote');

function luxento_toolkit_shortcode_blockquote($atts, $content = null) {
    
   extract( shortcode_atts( array('style' => 1), $atts ) );
    $author  = isset( $atts['author'] ) ? $atts['author'] : '';
    $classes = apply_filters('luxento_toolkit_blockquote_classes',array( 'luxento-saying' ));
    switch((int)$atts['style']){
        case 1:
            $classes[] = 'luxento-custom-saying-1';
            break;
        case 2:
            $classes[] = 'luxento-custom-saying-2';
            break;
        case 3:
            $classes[] = 'luxento-custom-saying-3';
            break;
        case 4:
            $classes[] = 'luxento-custom-saying-4';
            break;
        default:
            $classes[] = 'luxento-custom-saying-1';
            break;
    } 
    ob_start();
    ?>
    <div class="<?php echo esc_attr(implode(' ', $classes)); ?>">
        <p><?php echo wp_kses( $content, luxento_lite_get_allowed_tags() ); ?>
            <i class="fa fa-quote-left"></i>
        </p>
        <?php if( '' != $author ): ?>
        <span class="luxento-author-of-saying"><?php echo esc_attr( $author ); ?></span>
        <?php endif; ?>
    </div>
    <?php
    $string = ob_get_contents();
    ob_end_clean();

    return apply_filters( 'luxento_toolkit_shortcode_blockquote', $string, $atts, $content );
}
