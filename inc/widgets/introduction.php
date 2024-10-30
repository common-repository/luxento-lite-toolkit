<?php
if ( ! class_exists('Kopa_Widget') ) {
    return;
}

add_action( 'widgets_init', array( 'Luxento_Toolkit_Introduction', 'register_widget' ) );

class Luxento_Toolkit_Introduction extends Kopa_Widget {

	public $kpb_group = 'contact';

	public static function register_widget(){
		register_widget('Luxento_Toolkit_Introduction');
	}

	public function __construct() {
		
		$this->widget_cssclass    = ' luxento-widget-01 luxento-style-1';
		$this->widget_description = esc_html__('Display introduction in footer', 'luxento-toolkit');
		$this->widget_id          = 'luxento-widget-intro';
		$this->widget_name        = esc_html__( '__Introduction', 'luxento-toolkit' );
		
		$this->settings = array(
			'image' => array(
				'type'  => 'upload',
				'label' => esc_html__('Upload your image', 'luxento-toolkit'),
				'std'   => ''
			),
			'detail' => array(
				'type'  => 'textarea',
				'label' => esc_html__('Detail', 'luxento-toolkit'),
				'std'   => ''
			)
		);
		parent::__construct();
	}

	public function widget( $args, $instance ) {

		ob_start();
		
		extract( $args );
		
		$instance = wp_parse_args((array) $instance, $this->get_default_instance());
		
		extract( $instance );
		
		echo wp_kses_post( $before_widget ); 

		?>
		
		<?php if( $image  || $detail ): ?>
			<img src="<?php echo esc_url( $image ); ?>" alt="">
			<p><?php echo wp_kses( $detail, luxento_lite_get_allowed_tags() ); ?></p>
		<?php endif; ?>

		<?php
		
		echo wp_kses_post( $after_widget );
		
		$content = ob_get_clean();
		
		echo wp_kses_post( $content );  

	}
}