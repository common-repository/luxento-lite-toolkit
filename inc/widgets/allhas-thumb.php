<?php
add_action( 'widgets_init', array('Luxento_Toolkit_Widget_AllHas_Thumb', 'register_widget'));

class Luxento_Toolkit_Widget_AllHas_Thumb extends Kopa_Widget {

    public $kpb_group = 'post';

    public static function register_widget(){
        register_widget('Luxento_Toolkit_Widget_AllHas_Thumb');
    }
    function __construct() {
        $this->widget_cssclass    = 'luxento-widget-list-categoris luxento-widget-custom-list-categoris';
        $this->widget_id          = 'luxento-widget-allhas-thumb';
        $this->widget_name        = esc_html__('__Posts List - All Thumb.', 'luxento-toolkit-plus');
        $this->widget_description = esc_html__('Show posts list, all posts has thumb.', 'luxento-toolkit-plus');
        $this->settings           = luxento_lite_get_post_widget_args();
        parent::__construct();
    }

    public function widget($args, $instance) {
        $title      = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
        $instance   = wp_parse_args((array) $instance, $this->get_default_instance());
        extract($args);
        extract( $instance );
        $query      = luxento_lite_get_post_widget_query($instance);
        $result_set = new WP_Query( $query );
        echo wp_kses_post( $before_widget );
        if ( ! empty($title) ){
            echo wp_kses_post( $before_title.$title.$after_title );
        }
        $first = true;
        ?>
            <?php if( $result_set->have_posts() ): while( $result_set->have_posts() ) : $result_set->the_post(); ?>
                <?php if( $first ) : $first = false; ?>
                    <article class="entry-item luxento-first-item">
                        <div class="entry-thumb">
                            <?php if( has_post_thumbnail() ){
                                    the_post_thumbnail( 'luxento-1tall-4short-ss' );
                                }else{
                                    echo '<img src="http://placehold.it/300x300" alt="">';
                                }
                            ?>
                        </div>
                        <div class="entry-content luxento-custom-entry-content">
                            <?php echo luxento_lite_get_first_category_by_id(get_the_ID(), 'luxento-categories'); ?>
                            <div>
                            <h4 class ="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                             
                            </div>                                                  
                        </div>
                    </article>
                <?php else : ?>
                    <article class="entry-item">
                        <div class="entry-thumb">
                            <?php if( has_post_thumbnail() ){
                                    the_post_thumbnail( 'luxento-1tall-4short-ss' );
                                }else{
                                    echo '<img src="http://placehold.it/300x300" alt="">';
                                }
                            ?>
                        </div>
                        <div class="entry-content luxento-custom-entry-content">
                            <?php echo luxento_lite_get_first_category_by_id(get_the_ID(), 'luxento-categories'); ?>
                            <div>
                            <h4 class ="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                             
                            </div>                                                  
                        </div>
                    </article>
                <?php endif; ?>             
            <?php endwhile; endif; ?>
        <?php
        echo wp_kses_post( $after_widget );
        wp_reset_postdata();
    }
}