<?php
add_filter( 'kpb_get_widgets_list', array('Luxento_Toolkit_Widget_Google_Map', 'register_block') );
add_filter( 'luxento_get_map_class_name', array('Luxento_Toolkit_Widget_Google_Map', 'set_map_class_name') );

class Luxento_Toolkit_Widget_Google_Map extends Kopa_Widget {

    public $kpb_group = 'contact';

    public static function register_block($blocks){
        $blocks['Luxento_Toolkit_Widget_Google_Map'] = new Luxento_Toolkit_Widget_Google_Map();
        return $blocks;
    }

    public static function set_map_class_name($class_names){
        array_push( $class_names, 'Luxento_Toolkit_Widget_Google_Map' );
        return $class_names;
    }

	public function __construct() {
		$this->widget_cssclass    = 'luxento-widget-map luxento-custom-widget-map';
		$this->widget_description = esc_html__( 'Display your google map by Latitude & Longtitude', 'luxento-toolkit' );
		$this->widget_id          = 'luxento-toolkit-google-map';
		$this->widget_name        = esc_html__( '__Google Map', 'luxento-toolkit' );
		$this->settings 		  = array(
			'title'  => array(         
				'type'  => 'text',
				'std'   => '',
				'label' => esc_html__( 'Title', 'luxento-toolkit' )
			),            
            'latitude'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__('Latitude', 'luxento-toolkit')
            ),
			'longtitude'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__('Longtitude', 'luxento-toolkit')
            ),
            'location'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__('Location', 'luxento-toolkit')
            ),
            'height'  => array(
                'type'  => 'text',
                'std'   => '450px',
                'label' => esc_html__('Height', 'luxento-toolkit')
            )
		);	

		parent::__construct();
	}

	public function widget( $args, $instance ) {
		ob_start();

		extract( $args );
		
        $instance = wp_parse_args((array) $instance, $this->get_default_instance());
		
        extract( $instance );

		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);

		echo wp_kses_post( $before_widget );

		if($title)
			echo wp_kses_post( $before_title . $title .$after_title );	
        
        if (!empty($latitude) && !empty($longtitude)):   
            $style = ($height) ? "height: {$height};" : '';
            $map_id = 'luxento-map-' . wp_generate_password(4, false, false);
            ?>            
            <div id="<?php echo esc_attr($map_id);?>" 
                style="<?php echo esc_attr($style); ?>"
                class="luxento-map"                    
                data-latitude="<?php echo esc_attr($latitude); ?>" 
                data-longtitude="<?php echo esc_attr($longtitude); ?>"
                data-location="<?php echo esc_attr($location); ?>"></div>            
            <?php             
        endif;            
      
		echo wp_kses_post( $after_widget );

		$content = ob_get_clean();

		echo $content ;		
	}

}