<?php
add_action( 'widgets_init', array('Luxento_Toolkit_Widget_Adver', 'register_widget'));

class Luxento_Toolkit_Widget_Adver extends Kopa_Widget {

    public $kpb_group = 'other';

    public static function register_widget(){
        register_widget('Luxento_Toolkit_Widget_Adver');
    }
    function __construct() {
        $this->widget_cssclass    = 'luxento-widget-adver';
        $this->widget_id          = 'luxento-widget-adver';
        $this->widget_name        = esc_html__('__Image', 'luxento-toolkit-plus');
        $this->widget_description = esc_html__('Show image ads.', 'luxento-toolkit-plus');
        $this->settings 		  = array(
        	'title'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'Title:', 'luxento-toolkit-plus' )
            ),
            'image'  => array(
                'type'  => 'upload',
                'std'   => '',
                'mines' => 'image',
                'label' => esc_html__( 'Upload your image:', 'luxento-toolkit-plus' )
            ),
            'url'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'URL:', 'luxento-toolkit-plus' )
            ),
            'target'  => array(
                'type'  => 'select',
                'std'   => '_blank',
                'options' => array(
					'_blank' => esc_html__('Open in a new tab', 'luxento-toolkit-plus' ),
					'_self'  => esc_html__('Open in current tab', 'luxento-toolkit-plus' ),
                ),
                'label' => esc_html__( 'URL:', 'luxento-toolkit-plus' )
            ),
        );
        parent::__construct();
    }

    public function widget($args, $instance) {
        $title      = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
        $instance   = wp_parse_args((array) $instance, $this->get_default_instance());
        extract($args);
        extract( $instance );
        echo wp_kses_post( $before_widget );
        if ( ! empty($title) ){
            echo wp_kses_post( $before_title.$title.$after_title );
        }
        if( $image ) : 
        ?>
        	<div class="widget-content">
				<a href="<?php echo esc_url( $url ); ?>" target="<?php echo esc_attr( $target ); ?>"><img src="<?php echo esc_url( $image ); ?>" alt=""></a>
			</div>
        <?php
        endif; 
        echo wp_kses_post( $after_widget );
    }
}