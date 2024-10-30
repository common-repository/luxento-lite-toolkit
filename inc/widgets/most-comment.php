<?php
if ( ! class_exists('Kopa_Widget') ) {
	return;
}

add_action( 'widgets_init', array('Luxento_Toolkit_Comments', 'register_widget'));

class Luxento_Toolkit_Comments extends Kopa_Widget {

	public $kpb_group = 'comment';
	public $lines     = array();

	public static function register_widget(){
		register_widget('Luxento_Toolkit_Comments');
	}

	public function __construct() {
		$this->widget_cssclass    = ' widget_recent_comments';
		$this->widget_description = esc_html__( 'Display newest comments', 'luxento-toolkit' );
		$this->widget_id          = 'luxento-widget-comments';
		$this->widget_name        = esc_html__( '__Comments', 'luxento-toolkit' );

		$this->settings           = array(      
			'title'  => array(
				'type'  => 'text',
				'std'   => 'Latest Comments',
				'label' => esc_html__( 'Title:', 'luxento-toolkit')
			),            
			'count'  => array(
				'type'  => 'number',
				'std'   => 3,
				'label' => esc_html__( 'Number of comments:', 'luxento-toolkit' )
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
		
		if( $title ){
			echo wp_kses( $before_title.$title.$after_title, luxento_lite_get_allowed_tags() ); 
		}

		$comments = get_comments(array(
			'status' => 'approve',
			'number' => $count,
			'order'  => 'DESC',
			'post_type' => array('post', 'page')));
		
		if( $comments ): 
			$class = ('style1' == $style ) ? 'comment-style-1': 'comment-style-2';
			?>
			<ul class="<?php echo esc_attr( $class ); ?>">
				<?php 
				foreach($comments as $comment) : 
					$post_id  = isset($comment->comment_post_ID) ? $comment->comment_post_ID: 0;
				$category = luxento_lite_get_first_category_by_id( $post_id, 'luxento-categories luxento-categories-custom-01' );
				?>
				<li>
					<?php echo wp_kses_post( $category );  ?>
					<a class="luxento_style_01" href="<?php echo get_permalink( $post_id ); ?>"><?php echo get_the_title( $post_id ); ?></a>
				</li>
			<?php endforeach;  ?>
			</ul>
			<?php 
		endif;

		echo wp_kses_post( $after_widget ); 
		
		$content = ob_get_clean();

		echo wp_kses_post( $content );
	}
}