<?php
add_action( 'widgets_init', array( 'Luxento_Toolkit_Widget_1Big_1Small', 'register_widget' ) );

class Luxento_Toolkit_Widget_1Big_1Small extends Kopa_Widget {

    public $kpb_group = 'post';

    public static function register_widget() {
        register_widget( 'Luxento_Toolkit_Widget_1Big_1Small' );
    }
    function __construct() {
        $this->widget_cssclass    = 'luxento-widget-1-big-1-small';
        $this->widget_id          = 'luxento-widget-1big-1small';
        $this->widget_name        = esc_html__( '__Posts List 3 Columns', 'luxento-toolkit-plus' );
        $this->widget_description = esc_html__( 'Show post list 3 columns, last column only show title.', 'luxento-toolkit-plus' );
        $this->settings = luxento_lite_get_post_widget_args();
        $this->settings['excerpt_length'] = array(
            'type'  => 'number',
            'std'   => 20,
            'label' => esc_html__( 'Excerpt length:', 'luxento-toolkit-plus' ),
            'desc'  => ''
        );
        $this->settings['style'] = array(
            'type'  => 'select',
            'std'   => 'style1',
            'options' => array(
                'style1' => esc_html__('Style Front page', 'luxento-toolkit-plus'),
                'style2' => esc_html__('Style Blog page', 'luxento-toolkit-plus')
            )
        );

        parent::__construct();
    }

    public function widget( $args, $instance ) {
        $title      = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
        $instance   = wp_parse_args( (array) $instance, $this->get_default_instance() );
        extract( $args );
        extract( $instance );
        $query      = luxento_lite_get_post_widget_query( $instance );
        $result_set = new WP_Query( $query );
        $entry_content_class     = 'entry-content';
        $first_item_space_bottom = 'luxento-space-bttom-2';
        if ( 'style2' == $style ) {
            $before_widget = str_replace('luxento-widget-1-big-1-small', 'luxento-widget-1-big-1-small luxento-widget-custom-1-big-1-small luxento-style-1', $before_widget);
            $entry_content_class = 'entry-content luxento-custom-entry-content';
            $first_item_space_bottom = '';
        }
        echo wp_kses_post( $before_widget );
        if ( ! empty($title) ){
            echo wp_kses_post( $before_title.$title.$after_title );
        }
        $index     = 1;
        $current   = 1; 
        $real_post = count($result_set->posts);
        if( $real_post > 2 ){
            $class_col_left = 'col-lg-6 col-md-6 col-sm-8 col-xs-6 luxento-left';
            $class_col_middle = 'col-lg-3 col-md-3 col-sm-4 col-xs-6 luxento-middle';
        }else{
            $class_col_left = 'col-lg-9 col-md-9 col-sm-12 luxento-left';
            $class_col_middle = 'col-lg-3 col-md-3 col-sm-12 luxento-middle';
        }
        ?>
        <?php if( $result_set->have_posts() ): ?>
            <div class="widget-content luxento-clearfix">
                <div class="row">
                    <?php while( $result_set->have_posts() ) : $result_set->the_post(); ?>
                        <?php if( $index == 1 ) : ?>
                            <div class="<?php echo esc_attr( $class_col_left ); ?>">
                                <article class="entry-item luxento-first-item">
                                    <div class="entry-thumb">
                                        <?php 
                                            if(has_post_thumbnail()){
                                                the_post_thumbnail('luxento-1big-2small-mm');
                                            }else{
                                                echo '<img src="http://placehold.it/620x620" alt="">';
                                            }
                                        ?>
                                    </div>
                                    <div class="<?php echo esc_attr($entry_content_class); ?>">
                                        <?php echo luxento_lite_get_first_category_by_id(get_the_ID(), 'luxento-categories'); ?>
                                        <div class="<?php echo esc_attr($first_item_space_bottom); ?>">
                                            <h2 class ="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                            <ul class="luxento-meta-data">
                                                <li class="luxento-day-post">
                                                    <i class="fa fa-clock-o"></i>
                                                    <span class="luxento-has-bot-line"><?php echo get_the_date(); ?></span>
                                                </li>
                                                <li class="luxento-author-post">
                                                    <?php esc_html_e('by ', 'luxento-toolkit-plus'); the_author_posts_link(); ?>
                                                </li>                                           
                                            </ul>
                                            <?php 
                                                $GLOBALS['luxento_lite_excerpt_length'] = (int) $excerpt_length;
                                                add_filter('excerpt_length', 'luxento_lite_set_excerpt_length');
                                                    echo '<p class="entry-detail">'.get_the_excerpt().'</p>'; 
                                                remove_filter('excerpt_length', 'luxento_lite_set_excerpt_length');
                                            ?>
                                        </div>              
                                    </div>
                                </article>
                            </div>
                            <?php 
                                if( $current == $real_post && $current > 1 ) {
                                    echo '</div>';
                                }
                            ?>
                        <?php elseif( $index == 2 ) : ?>
                            <div class="<?php echo esc_attr( $class_col_middle ); ?>">
                                <article class="entry-item luxento-first-item">
                                    <div class="entry-thumb">
                                        <?php 
                                            if(has_post_thumbnail()){
                                                the_post_thumbnail('luxento-1big-1small-sm');
                                            }else{
                                                echo '<img src="http://placehold.it/300x620" alt="">';
                                            }
                                        ?>
                                    </div>
                                    <div class="entry-content luxento-custom-entry-content">
                                        <?php echo luxento_lite_get_first_category_by_id(get_the_ID(), 'luxento-categories'); ?>
                                        <div class="luxento-space-bttom-1">
                                        <h4 class ="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                        <ul class="luxento-meta-data">
                                            <li class="luxento-day-post">
                                                <i class="fa fa-clock-o"></i>
                                                <span class="luxento-has-bot-line"><?php echo get_the_date(); ?></span>
                                            </li>
                                            <li class="luxento-author-post">
                                                <?php esc_html_e('by ', 'luxento-toolkit-plus'); the_author_posts_link(); ?>
                                            </li>                                           
                                        </ul>
                                        </div>                                                  
                                    </div>
                                </article>
                            </div>
                            <?php 
                                if( $current == $real_post && $current > 2) {
                                    echo '</div>';
                                }
                            ?>
                        <?php else: ?>
                            <?php
                                if( $index == 3 ){
                                    echo '<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 luxento-right">';
                                    $class = 'luxento-first-item';
                                }else{
                                    $class = '';
                                }
                            ?>
                                <article class="entry-item <?php echo esc_attr( $class ); ?> luxento-item-no-thumb">
                                    <div class="entry-content">
                                        <?php echo luxento_lite_get_first_category_by_id(get_the_ID(), 'luxento-categories'); ?>
                                        <h5 class ="entry-title luxento-custom-entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                                        <ul class="luxento-meta-data luxento-custom-meta-data">
                                            <li class="luxento-day-post">
                                                <i class="fa fa-clock-o"></i>
                                                <span class="luxento-has-bot-line"><?php echo get_the_date(); ?></span>
                                            </li>
                                            <li class="luxento-author-post">
                                                <?php esc_html_e('by ', 'luxento-toolkit-plus'); the_author_posts_link(); ?>
                                            </li>                                           
                                        </ul>                                                       
                                    </div>
                                </article>
                            <?php
                                if( $current == $real_post && $index !== 7 ){
                                    echo '</div>';
                                }

                                if( $index == 7 ){

                                    if( $current == $real_post ){
                                        echo '</div>';
                                    }else{
                                        echo '</div></div><div class="row">';
                                    }
                                    $index = 0;
                                }
                            ?>
                        <?php endif; ?>
                    <?php $index++; $current++; endwhile; ?>
                </div>
            </div>
        <?php endif; ?>
        <?php
        echo wp_kses_post( $after_widget );
        wp_reset_postdata();
    }
}