<?php
if ( ! class_exists('Kopa_Widget'))  {

	return;

}

add_action( 'widgets_init', array('Luxento_Toolkit_Last_Tweet', 'register_widget'));

class Luxento_Toolkit_Last_Tweet extends Kopa_Widget {

	public $kpb_group = 'social';

	public static function register_widget(){

		register_widget('Luxento_Toolkit_Last_Tweet');

	}

	public function __construct() {

		$this->widget_cssclass    = ' luxento-widget-social luxento-style-1';

		$this->widget_description = esc_html__('Display information of last tweets', 'luxento-toolkit');

		$this->widget_id          = 'luxento-widget-latest-tweet';

		$this->widget_name        = esc_html__( '__Twitter', 'luxento-toolkit' );

		$this->settings       = array();

		$this->settings = array(

			'title' => array(

				'type'  => 'text',

				'label' => esc_html__('Title', 'luxento-toolkit'),

				'std'   => ''

				),

			'twitter_id' => array(

				'type'  => 'text',

				'label' => esc_html__('Twitter ID', 'luxento-toolkit'),

				'std'   => ''

				),

			'api_key' => array(

				'type'  => 'text',

				'label' => esc_html__('Twitter API Key', 'luxento-toolkit'),

				'std'   => ''

				),

			'api_secret' => array(  

				'type'  => 'text',

				'label' => esc_html__('Twitter API Secret', 'luxento-toolkit'),

				'std'   => ''

				),

			'access_token' => array(

				'type'  => 'text',

				'label' => esc_html__('Twitter Access Token', 'luxento-toolkit'),

				'std'   => ''

				),

			'access_token_secret' => array(

				'type'  => 'text',

				'label' => esc_html__('Twitter Access Token Secret', 'luxento-toolkit'),

				'std'   => ''

				),

			'limit' => array(

				'type'  => 'number',

				'label' => esc_html__('Number of tweet', 'luxento-toolkit'),

				'std'   => 5

				)

			);

		parent::__construct();

	}

	function update( $new_instance, $old_instance ) {
		if( isset( $new_instance['twitter_id'] ) ){
			$key = 'luxento_toolkit_' . $new_instance['twitter_id'];
			delete_transient( $key );
		}

		return parent::update( $new_instance, $old_instance );
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

		if($twitter_id && $api_key && $api_secret && $access_token && $access_token_secret && $limit):
			$cache = get_transient( 'luxento_toolkit_' . $twitter_id );
			if( empty($cache) ):
				ob_start();
				require_once dirname(__FILE__).'/twitterapi/TwitterAPIExchange.php';
				$settings = array(
							'oauth_access_token'        => $access_token,
							'oauth_access_token_secret' => $access_token_secret,
							'consumer_key'              => $api_key,
							'consumer_secret'           => $api_secret
			      );
				$url           = "https://api.twitter.com/1.1/statuses/user_timeline.json";
		    	$requestMethod = "GET";
				$getfield      = "?screen_name={$twitter_id}&count={$limit}";
		  		$twitter       = new TwitterAPIExchange($settings);
		   		$data          = json_decode($twitter->setGetfield($getfield)
		                      ->buildOauth($url, $requestMethod)
		                      ->performRequest(), TRUE);
		   		if( $data ): ?>
				<ul>
					<?php  
					foreach ($data as $items): 
					preg_match('!https?://[\S]+!', $items['text'], $matches);
					$url = '';
						if (isset($matches) && !empty($matches)){ 
							$url = $matches[0]; 
						}
						$pattern = '~https://[^\s]*~i';
						$title = preg_replace($pattern, '', $items['text']); ?>
						<li class="luxento-first-item">
							<a class="luxento-account-social" href="<?php echo esc_url('https://twitter.com/intent/user?user_id='); ?><?php echo esc_attr($items['user']['id']); ?>"><i class="fa fa-twitter"></i><?php echo esc_attr($items['user']['name']); ?></a>
							<p>
								<?php echo esc_attr( $title ); ?> 
								<?php if (!empty($url)) : ?>
						        	<a href="<?php echo esc_url( $url ); ?>"><?php echo esc_attr( $url ); ?></a>
						        <?php endif; ?> 
							</p>
						</li>
					<?php 
					endforeach; ?>
				</ul>
				<?php
					$cache = ob_get_clean();
		      		set_transient( 'luxento_toolkit_'.$twitter_id, $cache, 60 * 60 );
				endif;
			endif;
			echo wp_kses( $cache, luxento_lite_get_allowed_tags() );
		endif;

		echo wp_kses_post( $after_widget );
	}
}







