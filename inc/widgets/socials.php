<?php

add_action( 'widgets_init', array( 'Sunday_News_Toolkit_Widget_Socials', 'register_widget' ) );

class Sunday_News_Toolkit_Widget_Socials extends Kopa_Widget {

    public $kpb_group = 'post';

    public static function register_widget() {
        register_widget( 'Sunday_News_Toolkit_Widget_Socials' );
    }
    function __construct() {
        $this->widget_cssclass    = 'sunday-widget-icon-in-background-blue';
        $this->widget_id          = 'stk-widget-socials';
        $this->widget_name        = esc_html__( '__Socials', 'sunday-news-lite-toolkit' );
        $this->widget_description = esc_html__( 'Show socials.', 'sunday-news-lite-toolkit' );
        $this->settings           = array(
            'title'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'Title:', 'sunday-news-lite-toolkit' ),
            ),
        );

        parent::__construct();
    }

    public function widget( $args, $instance ) {
        $title      = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        $instance   = wp_parse_args( (array) $instance, $this->get_default_instance() );
        extract( $args );
        extract( $instance );
        echo wp_kses_post( $before_widget );
        if ( ! empty( $title ) ) {
            echo wp_kses_post( $before_title.$title.$after_title );
        }
        $socials = sunday_news_lite_get_socials();
        if ( $socials ) : ?>
            <div class="sunday-icon-socia">
                <ul class="clearfix">
                    <?php 
                        foreach ( $socials as $value ) {
                            $key_value = get_theme_mod( 'social_share_'.$value['id'] );
                            if ( $key_value != 'HIDE' && $value['id'] == 'rss') {
                                if ( $key_value == '' ){
                                    $key_value = get_bloginfo( 'rss2_url' );
                                }
                                echo sprintf( '<li><a href="%s" rel="nofollow" target="_blank"><i class="%s"></i></a></li>', esc_url( $key_value ), esc_attr( $value['icon'] ) );
                            }
                            if ( ! empty( $key_value ) && $value['id'] != 'rss' ) {
                                 echo sprintf( '<li><a href="%s" rel="nofollow" target="_blank"><i class="%s"></i></a></li>', esc_url( $key_value ), esc_attr( $value['icon'] ) );
                            }
                        }
                    ?>
                </ul>
            </div>
        <?php endif;
        echo wp_kses_post( $after_widget );
    }
}