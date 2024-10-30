<?php
add_action( 'widgets_init', array('Luxento_Toolkit_Widget_List_Categories', 'register_widget'));

class Luxento_Toolkit_Widget_List_Categories extends Kopa_Widget {

    public $kpb_group = 'post';

    public static function register_widget(){
        register_widget('Luxento_Toolkit_Widget_List_Categories');
    }
    function __construct() {
        $this->widget_cssclass    = 'luxento-widget-list-categoris luxento-style-1';
        $this->widget_id          = 'luxento-widget-list-categories';
        $this->widget_name        = esc_html__('__List Categories', 'luxento-toolkit-plus');
        $this->widget_description = esc_html__('Show list categories.', 'luxento-toolkit-plus');
        $this->settings 		  = array(
        	'title'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'Title:', 'luxento-toolkit-plus' )
            ),
            'show_post_count'  => array(
                'type'  => 'checkbox',
                'std'   => 1,
                'label' => esc_html__( 'Show post counts', 'luxento-toolkit-plus' )
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
            $args = array(
                'orderby'   => 'name',
                'order'     => 'ASC',
                'hide_empty'    => '0',
            );
            $categories = get_categories($args);
            echo '<ul>';
                foreach( $categories as $category ) { 
                    $cat_ID    = $category->term_id;
                    $cat_name  = $category->name;
                    $cat_count = $category->count;
                    echo '<li><span class="luxento-road-line"></span><a href="'.esc_url(get_category_link( $cat_ID )).'">'.esc_html( $cat_name ).'</a><span>('.esc_html( $cat_count ).')</span></li>';
                }
            echo '</ul>';
        echo wp_kses_post( $after_widget );
    }
}