<?php
if ( ! class_exists('Kopa_Widget') ) {
    return;
}
add_action( 'widgets_init', array('Luxento_Toolkit_Instagram', 'register_widget'));
class Luxento_Toolkit_Instagram extends Kopa_Widget {

	public $kpb_group = 'social';
	
	public static function register_widget(){
		register_widget('Luxento_Toolkit_Instagram');
	}

	public function __construct() {

		$this->widget_cssclass    = ' luxento-widget-6-img';
		$this->widget_description = esc_html__( 'Display images from instagram.', 'luxento-toolkit' );
		$this->widget_id          = 'luxento-widget-instagram';
		$this->widget_name        = esc_html__( '__Instagram', 'luxento-toolkit' );		
		$this->settings           = array(
            'title'  => array(
                'type'  => 'text',
                'std'   => esc_html__('Instagram', 'luxento-toolkit'),
                'label' => esc_html__( 'Title', 'luxento-toolkit')
            ),
            'accessId'    => array(
				'type'  => 'text',
				'std'   => '',
				'label' =>  esc_html__( 'Access id', 'luxento-toolkit'),
				'rows'  => 8
            ),
            'access_token'  => array(
				'type'  => 'text',
				'std'   => '',
				'label' => esc_html__( 'Access token :', 'luxento-toolkit'),
				'desc'  => esc_html__( 'Please read document for more detail.', 'luxento-toolkit'),
            ),
            'limit'  => array(
				'type'  => 'number',
				'std'   => 6,
				'label' => esc_html__( 'Number of photos :', 'luxento-toolkit')
            ),

        );

		parent::__construct();
	}

	public function widget( $args, $instance ) {		
		extract( $args );
		
		$instance = wp_parse_args((array) $instance, $this->get_default_instance());
		
		extract( $instance );
		
		echo wp_kses_post( $before_widget );
		
		if( $title ){
			echo wp_kses( $before_title . $title . $after_title, luxento_lite_get_allowed_tags() ); 
		}
		?>

		<div class="luxento-instagram-args luxento-insta-02" data-id="<?php echo esc_attr( $accessId ); ?>" data-token="<?php echo esc_attr( $access_token ); ?>" data-limit="<?php echo (int)esc_attr( $limit ); ?>"></div>
		
		<?php	
		echo wp_kses_post( $after_widget );			
	}

}