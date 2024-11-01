<?php
require_once SUNDAY_NEWS_TOOLKIT_PATH . 'inc/mailchimp-api/inc/mailchimp.php';

add_action( 'widgets_init', array('Sunday_News_Toolki_Plus_Widget_Subscribe', 'register_widget'));
class Sunday_News_Toolki_Plus_Widget_Subscribe extends Kopa_Widget {

	public $kpb_group = 'contact';

	public static function register_widget(){
		register_widget('Sunday_News_Toolki_Plus_Widget_Subscribe');
	}

	public function __construct() {
		$this->widget_cssclass    = 'sunday-widget-mail sunday-borderx2';
		$this->widget_description = esc_html__( 'Displays subscribe form.', 'sunday-news-lite-toolkit' );
		$this->widget_id          = 'stk-widget-subscrible';
		$this->widget_name        = esc_html__( '__Subscrible', 'sunday-news-lite-toolkit' );
		
		$this->settings           = array(			
			'title'  => array(
				'type'  => 'text',
				'std'   => '',
				'label' => esc_html__( 'Title:', 'sunday-news-lite-toolkit'),
			),
			'desc'  => array(
				'type'  => 'textarea',
				'std'   => '',
				'label' => esc_html__( 'Description:', 'sunday-news-lite-toolkit'),
			),
            'placeholder'  => array(
                'type'  => 'text',
                'std'   => esc_html__('Enter your email', 'sunday-news-lite-toolkit'),
                'label' => esc_html__( 'Placeholder text:', 'sunday-news-lite-toolkit' ),
            ),
            'list_id'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'List ID:', 'sunday-news-lite-toolkit' ),
                'desc' => wp_kses_post('Get your List Id by go to <a href="//us8.admin.mailchimp.com/lists/" target="_blank">link</a>. Then choose List name and default.', '')
            ),
            'api_key'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'Your API Key:', 'sunday-news-lite-toolkit' ),
                'desc' => wp_kses_post('Get an API Key by going to <a href="//us8.admin.mailchimp.com/account/api/" target="_blank">link</a>.', 'sunday-news-lite-toolkit')
            ),
		);

		parent::__construct();
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$instance = wp_parse_args( (array) $instance, $this->get_default_instance() );
		extract( $instance );
		$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base );

        #Encrypt data
		$list_id_e = sunday_news_toolkit_encrypt_decrypt( 'encrypt', $list_id );
		$api_key_e = sunday_news_toolkit_encrypt_decrypt( 'encrypt', $api_key );
		$nonce     = sunday_news_toolkit_encrypt_decrypt( 'encrypt', wp_create_nonce( 'sunday_news_toolkit_mailchimp' ) );

		echo wp_kses_post( $before_widget );
		?>
			<div class="sunday-custom-container">
				<?php if ( $title ) : ?>
					<div class="widget-title1">
						<?php echo '<h5>'.wp_kses_post( $title ).'</h5>'; ?>
						<div><i class="fa fa-envelope"></i></div>
					</div>
				<?php endif; ?>
				<div class="widget-content">
					<?php if( $desc ){
	                		echo '<p>'.wp_kses_post( $desc ).'</p>';
	                	}
	                ?>
					<form class="mailchimp-form" action="#" method="post" data-nonce="<?php echo esc_attr( $nonce ); ?>" data-list-id="<?php echo esc_attr( $list_id_e ); ?>" data-api-key="<?php echo esc_attr( $api_key_e ); ?>">
						<input type="text" placeholder="<?php echo esc_attr($placeholder); ?>" class="sunday-mail-add" name="email">
						<button class="sunday-button" type="submit"><?php esc_html_e( 'SUBSCRIBE', 'sunday-news-lite-toolkit' ); ?></button>
						<span class="sunday-del-text">X</span>
					</form>
				</div>
			</div>
		<?php
		echo  wp_kses_post( $after_widget );
	}
}
