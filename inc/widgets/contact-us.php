<?php
if ( ! class_exists('Kopa_Widget') ) {
    return;
}
add_action( 'widgets_init', array('Luxento_Toolkit_Contact_Us', 'register_widget'));

class Luxento_Toolkit_Contact_Us extends Kopa_Widget {

	public $kpb_group = 'contact';

	public static function register_widget(){
		register_widget('Luxento_Toolkit_Contact_Us');
	}

	public function __construct() {
		$this->widget_cssclass    = ' luxento-widget-contact luxento-style-1';
		$this->widget_description = esc_html__('Display contact us in footer', 'luxento-toolkit');
		$this->widget_id          = 'luxento-widget-contact';
		$this->widget_name        = esc_html__( '__Contact Us', 'luxento-toolkit' );
		$this->settings           = array(
			'title'       => array(
				'type'    => 'text',
				'label'   => esc_html__('Title', 'luxento-toolkit'),
				'std'     => ''
				),
			'office_name' => array(
				'type'    => 'text',
				'label'   => esc_html__('Office name', 'luxento-toolkit'),
				'std'     => ''
				),
			'office_link' => array(
				'type'    => 'text',
				'label'   => esc_html__('Office link', 'luxento-toolkit'),
				'std'     => ''
				),
			'office_add'  => array(
				'type'    => 'text',
				'label'   => esc_html__('Office address', 'luxento-toolkit'),
				'std'     => ''
				),
			'office_phone'=> array(
				'type'    => 'text',
				'label'   => esc_html__('Office phone', 'luxento-toolkit'),
				'std'     => ''
				),
			'office_email'=> array(
				'type'    => 'text',
				'label'   => esc_html__('Office email', 'luxento-toolkit'),
				'std'     => ''
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
		if( $title ){
			echo wp_kses( $before_title.$title.$after_title, luxento_lite_get_allowed_tags() ); 
		}
		if( $office_name || $office_link || $office_add || $office_phone || $office_email ):
		?>
		<div class="widget-content luxento-custom-border">
			<?php if(  $office_name || $office_link ): ?>
			<p class="luxento-name-ct"><a href="<?php echo esc_url( $office_link ); ?>"><?php echo esc_attr( $office_name ); ?></a></p>
			<?php endif; ?>
			<?php if( $office_add ): ?>
			<p class="luxento-address"><?php echo esc_attr( $office_add ); ?></p>
			<?php endif; ?>
			<?php if( $office_phone ): ?>
			<p class="luxento-call"><a href="callto:<?php echo esc_attr( $office_phone ); ?>"><i class="fa fa-phone"></i><?php echo esc_attr( $office_phone ); ?></a></p>
			<?php endif; ?>
			<?php if( $office_email ): ?>
			<p class="luxento-mail"><a href="mailto:<?php echo esc_url( $office_email ); ?>"><i class="fa fa-envelope"></i><?php echo esc_attr( $office_email ); ?></a></p>
			<?php endif; ?>
		</div>
		<?php
		endif;
		echo wp_kses_post( $after_widget );
		$content = ob_get_clean();
		echo wp_kses_post( $content );  
	}
}




