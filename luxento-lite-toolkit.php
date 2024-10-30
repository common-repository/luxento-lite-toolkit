<?php
/*
Plugin Name: Luxento Lite Toolkit
Description: A specific plugin use in Luxento Lite Theme, included some custom widgets, shortcodes
Version: 1.0.0
Author: Kopa Theme
Author URI: http://kopatheme.com
License: GNU General Public License v3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Luxento Lite Toolkit plugin, Copyright 2014 Kopatheme.com
Luxento Lite Toolkit is distributed under the terms of the GNU GPL

Requires at least: 4.4
Tested up to: 4.4.2
Text Domain: luxento-toolkit
Domain Path: /languages/
*/

define( 'LUXENTO_TOOLKIT_DIR', plugin_dir_url(__FILE__) );
define( 'LUXENTO_TOOLKIT_PATH', plugin_dir_path(__FILE__) );

add_action( 'plugins_loaded', array( 'Luxento_Toolkit', 'plugins_loaded' ) );	
add_action( 'after_setup_theme', array( 'Luxento_Toolkit', 'after_setup_theme' ), 25 );

class Luxento_Toolkit {
	
	function __construct() {
		add_filter( 'widget_text', 'do_shortcode' );
		add_filter( 'excerpt_more', '__return_null' );
		add_filter( 'user_contactmethods', array( $this, 'modify_user_profile' ) );
		add_action( 'admin_init', array( $this, 'metabox_post_featured' ) );
		add_action( 'admin_init', array( $this, 'register_page_options' ) );
		add_action( 'luxento_single_social_share', array( $this, 'social_share' ) );

		add_image_size( 'luxento-1tall-4short-ss', 300, 300, true );
		add_image_size( 'luxento-1big-2small-mm', 620, 620, true );
		add_image_size( 'luxento-1big-1small-sm', 300, 620, true );
		
		// WIDGETS.
        require LUXENTO_TOOLKIT_PATH . 'inc/widgets/introduction.php';		
        require LUXENTO_TOOLKIT_PATH . 'inc/widgets/contact-us.php';		
        require LUXENTO_TOOLKIT_PATH . 'inc/widgets/contact-form.php';		
        require LUXENTO_TOOLKIT_PATH . 'inc/widgets/instagram.php';		
        require LUXENTO_TOOLKIT_PATH . 'inc/widgets/last-tweets.php';		
        require LUXENTO_TOOLKIT_PATH . 'inc/widgets/most-comment.php';		
        require LUXENTO_TOOLKIT_PATH . 'inc/widgets/follow-us.php';
        require LUXENTO_TOOLKIT_PATH . 'inc/widgets/google-map.php';

        require LUXENTO_TOOLKIT_PATH . 'inc/widgets/1big-1small.php';
        require LUXENTO_TOOLKIT_PATH . 'inc/widgets/1has-thumb.php';
        require LUXENTO_TOOLKIT_PATH . 'inc/widgets/adver.php';
        require LUXENTO_TOOLKIT_PATH . 'inc/widgets/allhas-thumb.php';
        require LUXENTO_TOOLKIT_PATH . 'inc/widgets/list-categories.php';
        require LUXENTO_TOOLKIT_PATH . 'inc/widgets/flickr.php';

        // SHORTCODES.
		require_once( LUXENTO_TOOLKIT_PATH . 'inc/shortcode-util.php' );
		$luxento_toolkit_dirs = 'inc/shortcodes/';

		$path = LUXENTO_TOOLKIT_PATH . $luxento_toolkit_dirs . '*.php';
		$files = glob( $path );

		if ( $files ) {
		    foreach ( $files as $file ) {
		        require_once $file;
		    }
		}		
	}

	public static function plugins_loaded() {
		load_plugin_textdomain( 'luxento-toolkit', false, LUXENTO_TOOLKIT_PATH . '/languages/' );
	}

	public static function after_setup_theme() {
		if ( class_exists( 'Kopa_Framework' ) && defined( 'LUXENTO_LITE_PREFIX' ) ) {
			new Luxento_Toolkit();
		}
	}

	public static function modify_user_profile( $profile_fields ) {
	    $socials = luxento_lite_get_profile_socials();
	    if ( $socials ) {
	        foreach ( $socials as $key => $social ) {
	            $profile_fields[$key] = $social['title'];
	        }
	    }
	    return $profile_fields;
	}

	public static function register_page_options() {
		$args = array(
	        'id'          => 'luxento-toolkit-metabox-advance-options',
	        'title'       => esc_html__( 'Advance options', 'luxento-toolkit' ),
	        'desc'        => '',
	        'pages'       => array( 'page', 'post' ),
	        'context'     => 'normal',
	        'priority'    => 'low',
	        'fields'      => array(      
	            array(
					'title'   => esc_html__('Is hide breaking news', 'luxento-toolkit'),						
					'type'    => 'checkbox',
					'default' => 0,
					'id'      => 'luxento_is_hide_breaking_news',
	            ),
	            array(
					'title'   => esc_html__('Is hide breadcrumb', 'luxento-toolkit'),						
					'type'    => 'checkbox',
					'default' => 0,
					'id'      => 'luxento_is_hide_breadcrumb',
	            ),
	            array(
	                'title'   => esc_html__('Is hide page title', 'luxento-toolkit'),                       
	                'type'    => 'checkbox',
	                'default' => 0,
	                'id'      => 'luxento_is_hide_page_title',
	            ),	          
	        )
	    );

	    kopa_register_metabox( $args );
	}

	public static function metabox_post_featured() {
	    $post_type = array( 'post' );
	    $luxento_modules_fields = array(
	        array(
	            'title' => esc_html__( 'Gallery:', 'luxento-toolkit' ),
	            'type'  => 'gallery',
	            'id'    => 'luxento_gallery',
	            'desc'  => esc_html__( 'This option only apply for post-format "Gallery".', 'luxento-toolkit' )
	        ),
	        array(
	            'title' => esc_html__( 'Custom:', 'luxento-toolkit' ),
	            'type'     => 'textarea',
	            'id'       => 'luxento_custom',
	            'validate' => false,
	            'desc'     => esc_html__( 'Enter custom content as shortcode or custom HTML, ...', 'luxento-toolkit' )
	        )
	    );
	    $luxento_modules_fields = apply_filters( 'luxento_toolkit_metabox_set_fields_post_featured', $luxento_modules_fields );
	    $args = array(
	        'id'       => 'luxento-toolkit-post-options-metabox',
	        'title'    => esc_html__( 'Featured content', 'luxento-toolkit' ),
	        'desc'     => '',
	        'pages'    => $post_type,
	        'context'  => 'normal',
	        'priority' => 'high',
	        'fields'   => $luxento_modules_fields
	    );

	    kopa_register_metabox( $args );

	    $featured_image = array(
	        'id'       => 'luxento-toolkit-image-options-metabox',
	        'title'    => esc_html__( 'Featured Image', 'luxento-toolkit' ),
	        'desc'     => '',
	        'pages'    => $post_type,
	        'context'  => 'normal',
	        'priority' => 'high',
	        'fields'   => array(
	            array(
	                'type'  => 'checkbox',
	                'id'    => 'single_full_image',
	                'default' => 1,
	                'label' => esc_html__( 'Use full image?', 'luxento-toolkit' ),
	                'desc'  => esc_html__( 'Uncheck to use custom size images for single post. Only availavle on standard post format', 'luxento-toolkit' )
	            )
	        )
	    );

	    kopa_register_metabox( $featured_image );
	}

	public static function social_share( $post_id ) {
		$post_url       = get_permalink( $post_id );
		$post_title     = get_the_title( $post_id );
		$featured_image = get_theme_mod( 'header_logo' );

		if ( has_post_thumbnail( $post_id ) ) {
				$image          = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
				$featured_image = $image[0];
			}
		?>
		<li class="luxento-meta-data-right">
			<a href="<?php echo esc_url( sprintf( '//www.facebook.com/share.php?u=%s', urlencode( $post_url) ) ); ?>" title="<?php esc_attr_e( 'Share by facebook', 'luxento-toolkit' ); ?>" target="_blank"  rel="nofollow"><i class="fa fa-facebook"></i></a>
			<a href="<?php echo esc_url( sprintf( '//twitter.com/home?status=%s+%s', $post_title, $post_url ) ); ?>" title="<?php esc_attr_e( 'Share by twitter', 'luxento-toolkit' ); ?>" target="_blank"  rel="nofollow"><i class="fa fa-twitter"></i></a>
			<a href="<?php echo esc_url( sprintf( '//plus.google.com/share?url=%s', $post_url ) ); ?>" title="<?php esc_attr_e( 'Share by google plus', 'luxento-toolkit' ); ?>" target="_blank"  rel="nofollow"><i class="fa fa-google-plus"></i></a>
			<a href="<?php echo esc_url( sprintf( '//pinterest.com/pin/create/button/?url=%s&media=%s', $post_url, $featured_image ) ); ?>" title="<?php esc_attr_e( 'Pin it', 'luxento-toolkit' ); ?>" target="_blank"  rel="nofollow"><i class="fa fa-pinterest"></i></a>
		</li>
		<?php
	}
}	