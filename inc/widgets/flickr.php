<?php
add_action( 'widgets_init', array('Luxento_Toolkit_Widget_Flickr', 'register_widget'));

class Luxento_Toolkit_Widget_Flickr extends Kopa_Widget {

    public $kpb_group = 'social';

    public static function register_widget(){
        register_widget('Luxento_Toolkit_Widget_Flickr');
    }
    function __construct() {
        $this->widget_cssclass    = 'luxento-widget-flickr';
        $this->widget_id          = 'luxento-widget-flickr';
        $this->widget_name        = esc_html__('__Flickr', 'luxento-toolkit-plus');
        $this->widget_description = esc_html__('Show photo Flickr.', 'luxento-toolkit-plus');
        $this->settings 		  = array(
        	'title'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'Title:', 'luxento-toolkit-plus' )
            ),
            'id'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'User ID:', 'luxento-toolkit-plus' )
            ),
            'limit'  => array(
                'type'  => 'number',
                'std'   => '6',
                'label' => esc_html__( 'Limit:', 'luxento-toolkit-plus' )
            ),
        );
        parent::__construct();
    }

    public function widget($args, $instance) {
        $instance = wp_parse_args((array) $instance, $this->get_default_instance());
        
        extract( $args );
        
        extract( $instance );
        
        echo wp_kses_post( $before_widget );
        
        $title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base );
        
        if ( ! empty($title) ){
            echo wp_kses_post( $before_title.$title.$after_title );
        }        
        ?>
        
        <ul class="luxento-flickr-content" data-id="<?php echo esc_attr( $id ); ?>" data-limit="<?php echo esc_attr( $limit ); ?>"></ul>
        
        <?php
        echo wp_kses_post( $after_widget );
    }
}