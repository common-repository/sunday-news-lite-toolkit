<?php

add_action( 'widgets_init', array( 'Sunday_News_Toolkit_Widget_Ads', 'register_widget' ) );

class Sunday_News_Toolkit_Widget_Ads extends Kopa_Widget {

    public $kpb_group = 'post';

    public static function register_widget() {
        register_widget( 'Sunday_News_Toolkit_Widget_Ads' );
    }
    function __construct() {
        $this->widget_cssclass    = 'sunday-widget-thumb';
        $this->widget_id          = 'stk-widget-ads';
        $this->widget_name        = esc_html__( '__Ads', 'sunday-news-lite-toolkit' );
        $this->widget_description = esc_html__( 'Show ads image.', 'sunday-news-lite-toolkit' );
        $this->settings           = array(
            'title'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'Title:', 'sunday-news-lite-toolkit' ),
            ),
            'image' => array(
                'type'    => 'upload',
                'std'     => '',
                'label'   => esc_html__( 'Image:', 'sunday-news-lite-toolkit' ),
                'mines'    => 'image',
            ),
            'url' => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'URL:', 'sunday-news-lite-toolkit' ),
            ),
            'target' => array(
                'type'  => 'select',
                'std'   => '_blank',
                'label' => esc_html__( 'Target:', 'sunday-news-lite-toolkit' ),
                'options' => array(
                    '_blank' => esc_html__( 'Open in a new tab.', 'sunday-news-lite-toolkit' ),
                    '_self'  => esc_html__( 'Open in current tab.', 'sunday-news-lite-toolkit' ),
                ),
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
        ?>
        <?php if ( $image && $url ) : ?>
            <div class="entry-thumb">
                <div>
                    <a href="<?php echo esc_url( $url ); ?>" target="<?php echo esc_attr( $target ); ?>">
                        <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>" title="<?php echo esc_attr( $title ); ?>">
                    </a>
                </div>
            </div>
        <?php endif; ?>
        <?php
        echo wp_kses_post( $after_widget );
    }
}