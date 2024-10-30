<?php
add_filter( 'kpb_get_widgets_list', array('Luxento_Toolkit_Widget_Contact_Form', 'register_block') );
add_action( 'wp_ajax_luxento_send_mail', array('Luxento_Toolkit_Widget_Contact_Form', 'send_mail') );
add_action( 'wp_ajax_nopriv_luxento_send_mail', array('Luxento_Toolkit_Widget_Contact_Form', 'send_mail') );


class Luxento_Toolkit_Widget_Contact_Form extends Kopa_Widget {

    public $kpb_group = 'contact';

    public static function register_block($blocks){
        $blocks['Luxento_Toolkit_Widget_Contact_Form'] = new Luxento_Toolkit_Widget_Contact_Form();
        return $blocks;
    }

	public function __construct() {
		$this->widget_cssclass    = 'luxento-widget-form-contact';
		$this->widget_description = esc_html__( 'Display your contact form and your contact information.', 'luxento-toolkit' );
		$this->widget_id          = 'luxento-toolkit-google-map';
		$this->widget_name        = esc_html__( '__Contact Form', 'luxento-toolkit' );
		$this->settings 		  = array(
			'title'  => array(         
				'type'  => 'text',
				'std'   => '',
				'label' => esc_html__( 'Title', 'luxento-toolkit' )
			),            
            'additionnal_info'  => array(
                'type'  => 'textarea',
                'std'   => '',
                'label' => esc_html__( 'Additionnal info', 'luxento-toolkit' )
            ),
			'address'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'Address', 'luxento-toolkit' )
            ),
            'email'  => array(
                'type'  => 'text',
                'std'   => 'yourmail@yourdomain.com',
                'label' => esc_html__( 'Email', 'luxento-toolkit' )
            ),
            'phone'  => array(
                'type'  => 'text',
                'std'   => '+(01) 2345 6789',
                'label' => esc_html__( 'Phone', 'luxento-toolkit' )
            ),
            'fax'  => array(
                'type'  => 'text',
                'std'   => '+(01) 2345 6789',
                'label' => esc_html__( 'Fax', 'luxento-toolkit' )
            )
		);	

		parent::__construct();
	}

	public function widget( $args, $instance ) {
		extract( $args );
		
        $instance = wp_parse_args((array) $instance, $this->get_default_instance());
		
        extract( $instance );

		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);

		echo wp_kses_post( $before_widget );

		if($title)
			echo wp_kses_post( $before_title . $title .$after_title );	      
        
        ?>
        <div class="row">
            
            <div class="col-lg-6 col-sm-6 col-xs-12">

                <form id="luxento_contact_form" class="luxento-form-contact luxento-custom-form-contact" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" novalidate="novalidate">
                    <input type="text" id="contact_name" name="contact_name" placeholder="<?php esc_html_e( 'Name' ); ?>">
                    <input type="text" id="contact_email" name="contact_email" placeholder="<?php esc_html_e( 'Email' ); ?>">
                    <textarea name="contact_message" id="contact_message" placeholder="<?php esc_html_e( 'Message' ); ?>"></textarea>    
                    <button id="contact_send" name="contact_send" class="luxento-button" type="submit"><i class="fa fa-paper-plane-o"></i><?php esc_html_e( 'Send' ); ?></button>
                    <?php wp_nonce_field( 'luxento_send_mail', 'contact_security', true, true ); ?>
                    <input type="hidden" name="action" value="luxento_send_mail">

                    <p id="contact_response"></p>
                </form>
                
            </div>

            <div class="col-lg-6 col-sm-6 col-xs-12">
                
                <div class="luxent-contact-address">

                    <?php if( $additionnal_info ): ?>
                        <div class="luxento-wrap luxento-first-item">                        
                            <h5><?php esc_html_e( 'Additionnal info:', 'luxento-toolkit'); ?></h5>
                            <p class="luxento-custom-entry-detail"><?php echo wp_kses( $additionnal_info, luxento_lite_get_allowed_tags() ); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if( $address ): ?>
                        <div class="luxento-wrap">                                            
                            <h5><?php esc_html_e( 'Address:', 'luxento-toolkit'); ?></h5>
                            <p class="luxento-custom-entry-detail"><?php echo wp_kses( $address, luxento_lite_get_allowed_tags() ); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if( $email || $phone || $fax ): ?>
                        <div class="luxento-wrap">                    

                            <h5><?php esc_html_e( 'Quick Contact:', 'luxento-toolkit'); ?></h5>
                            
                            <?php if($email): ?>
                                <p class="luxento-custom-entry-detail">
                                    <?php esc_html_e( 'Email:', 'luxento-toolkit'); ?>
                                    <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_attr($email); ?></a>
                                </p>
                            <?php endif; ?>

                            <?php if($phone): ?>
                                <p class="luxento-custom-entry-detail">
                                    <?php esc_html_e( 'Phone:', 'luxento-toolkit'); ?>
                                    <a href="callto:<?php echo esc_attr($phone); ?>"><?php echo esc_attr($phone); ?></a>
                                </p>
                            <?php endif; ?>
                                
                            <?php if($fax): ?>
                                <p class="luxento-custom-entry-detail">
                                    <?php esc_html_e( 'Fax:', 'luxento-toolkit'); ?>
                                    <?php echo esc_attr($fax); ?>
                                </p>
                            <?php endif; ?>

                        </div>
                    <?php endif; ?>

                </div>

            </div>

        </div>

        <?php

		echo wp_kses_post( $after_widget );
	}

    public static function send_mail(){
        check_ajax_referer( 'luxento_send_mail', 'contact_security' );

        foreach ($_POST as $key => $value) {
            if (ini_get('magic_quotes_gpc')) {
                $_POST[$key] = stripslashes($_POST[$key]);
            }
            $_POST[$key] = htmlspecialchars(strip_tags($_POST[$key]));
        }

        $name          = $_POST["contact_name"];
        $email         = $_POST["contact_email"];
        $message       = $_POST["contact_message"];
        
        $mail_template = apply_filters( 'luxento_get_mail_template', wp_kses( __( '<p>Aloha!</p><p>You have a new message from  [contact_name] ([contact_email])</p><div>[contact_message]</div><p>Thanks!</p>', 'luxento-toolkit' ), luxento_lite_get_allowed_tags() ) );
        
        $body          = str_replace('[contact_name]', $name, $mail_template);
        $body          = str_replace('[contact_email]', $email, $body);
        $body          = str_replace('[contact_message]', $message, $body);        
        
        $to            = get_bloginfo('admin_email');
        $subject       = esc_html__("Contact Form:", 'luxento-toolkit') . " $name";
        $headers       = 'MIME-Version: 1.0' . "\r\n";
        $headers       .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";        
        $headers       .= sprintf('From: %1$s', $email) . "\r\n";
        $headers       .= sprintf('Cc: %1$s', $email) . "\r\n";
        $result        = do_shortcode( esc_html__( 'Oops! errors occured. Please try again..', 'luxento-toolkit' ) );
        
        if (wp_mail($to, $subject, $body, $headers)) {
            $result = do_shortcode( esc_html__('Success! Your email address has been sent', 'luxento-toolkit' ) );
        }

        echo wp_kses_post( $result );

        exit();
    }


}
