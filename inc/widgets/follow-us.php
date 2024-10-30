<?php
if ( ! class_exists('Kopa_Widget') ) {
	return;
}

add_action( 'widgets_init', array('Luxento_Toolkit_Follow_Us', 'register_widget'));

class Luxento_Toolkit_Follow_Us extends Kopa_Widget {

	public $kpb_group = 'contact';

	public static function register_widget(){
		register_widget('Luxento_Toolkit_Follow_Us');
	}

	public function __construct() {
		$this->widget_cssclass    = ' luxento-widget-follow luxento-style-1';
		$this->widget_description = esc_html__('Display follow us in footer', 'luxento-toolkit');
		$this->widget_id          = 'luxento-widget-follow';
		$this->widget_name        = esc_html__( '__Follow Us', 'luxento-toolkit' );
		$this->settings       = array(
			'title' => array(
				'type'  => 'text',
				'label' => esc_html__('Title', 'luxento-toolkit'),
				'std'   => ''
				),
			'style' => array(
				'type'  => 'select',
				'std'   => 'style1',
				'options' => array(
					'style1' => esc_html__('Style 1', 'luxento-toolkit'),
					'style2' => esc_html__('Style 2', 'luxento-toolkit'),
					)
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
		if( $title ):
			echo wp_kses( $before_title.$title.$after_title, luxento_lite_get_allowed_tags() ); 
		endif; 
		$luxento_socials      = luxento_lite_get_socials();
		$luxento_socials_data = array();
		if ( $luxento_socials ) {
			foreach ( $luxento_socials as $v ) {
				$luxento_curr_value = get_theme_mod( 'social_share_' . esc_attr( $v['id'] ),'' );
				if ( 'rss' === $v['id'] ) {
					if ( 'HIDE' !== $luxento_curr_value ) {
						$luxento_socials_data[] = $v;
					}
				} else {
					if ( ! empty( $luxento_curr_value ) ) {
						$luxento_socials_data[] = $v;
					}
				}
			}
		}
		if ( $luxento_socials_data ) : 
			$class = ('style1' == $style ) ? 'follow-style-1': 'follow-style-2';   ?>
			<ul class="luxento-list-social luxento-custom-border luxento-clearfix <?php echo esc_attr( $class ); ?>">
				<?php
				foreach ( $luxento_socials_data as $v ) {
					$curr_value = get_theme_mod( 'social_share_' . esc_attr( $v['id'] ),'' );
					if ( 'rss' === $v['id'] ) {
						if ( empty( $curr_value ) ) {
							$curr_value = get_bloginfo( 'rss2_url' );
						}
					}
					?>
					<li><a href="<?php echo esc_url( $curr_value ); ?>" data-toggle="tooltip" rel="nofollow" title="<?php echo esc_html( $v['title'] ); ?>" target="_blank"><i class="<?php echo esc_attr( $v['icon'] ); ?>"></i></a></li>
					<?php
				}
				?>
			</ul>
		<?php 
		endif; 
		echo wp_kses_post( $after_widget );
		$content = ob_get_clean();
		echo wp_kses_post( $content );  
	}
}




