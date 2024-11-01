<?php

add_filter( 'kpb_get_widgets_list', array( 'Sunday_News_Toolkit_Widget_Contact_Form', 'register_block' ) );

class Sunday_News_Toolkit_Widget_Contact_Form extends Kopa_Widget {

    public $kpb_group = 'contact';
    
    public static function register_block( $blocks ) {
        $blocks['Sunday_News_Toolkit_Widget_Contact_Form'] = new Sunday_News_Toolkit_Widget_Contact_Form();
        return $blocks;
    }
    
	public function __construct() {
        $this->widget_cssclass    = 'sunday-widget-contactform sunday-widget-has-cog-background-whiteblack';
        $this->widget_description = esc_html__('Show contact form.', 'sunday-news-lite-toolkit');
        $this->widget_id          = 'stkp-widget-contact-form';
        $this->widget_name        = esc_html__( 'Contact Form', 'sunday-news-lite-toolkit' );
        $this->settings           = array(
            'title'  => array(
                'type'  => 'text',
                'std'   => esc_html__( 'Contact', 'sunday-news-lite-toolkit' ),
                'label' => esc_html__( 'Title:', 'sunday-news-lite-toolkit' )
            ),
            'desc'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'Description:', 'sunday-news-lite-toolkit' )
            )
        );
        parent::__construct();
    }

	public function widget( $args, $instance ) {
		extract( $args );
        extract( $instance );
        $title = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);

		echo wp_kses_post( $before_widget );
        if ( ! empty( $title ) ) {
            echo wp_kses_post( $before_title.$title.$after_title );
        }

		?>
            <?php 
                if ( $desc ) {
                    echo '<p>'.wp_kses_post( $desc ).'</p>';
                }
            ?>
            <form action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" class="sunday-contact-form">
                <input name="name" type="text" placeholder="<?php esc_html_e( 'Name(required)', 'sunday-news-lite-toolkit' ); ?>">
                <input name="email" type="text" placeholder="<?php esc_html_e( 'Email(required)', 'sunday-news-lite-toolkit' ); ?>">
                <input name="subject" type="text" placeholder="<?php esc_html_e( 'Website', 'sunday-news-lite-toolkit' ); ?>">
                <textarea name="message" rows="5" placeholder="<?php esc_html_e( 'Your comment(required)', 'sunday-news-lite-toolkit' ); ?>"></textarea>
                <button  class="sunday-button" type="submit"><?php esc_html_e( 'SEND MESSAGE', 'sunday-news-lite-toolkit' ); ?></button>    
                <input type="hidden" name="action" value="sunday_news_send_contact_widget">
                <?php echo wp_nonce_field('sunday_news_send_contact_widget', 'ajax_nonce_sunday_news_send_contact_widget', true, false); ?> 
                <div id="response"></div> 
            </form>
        <?php
		echo wp_kses_post( $after_widget );
	}
}