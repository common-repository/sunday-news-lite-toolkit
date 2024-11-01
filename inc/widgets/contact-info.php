<?php

add_filter( 'kpb_get_widgets_list', array( 'Sunday_News_Toolkit_Widget_Contact_Info', 'register_block' ) );

class Sunday_News_Toolkit_Widget_Contact_Info extends Kopa_Widget {

    public $kpb_group = 'contact';

    public static function register_block( $blocks ) {
        $blocks['Sunday_News_Toolkit_Widget_Contact_Info'] = new Sunday_News_Toolkit_Widget_Contact_Info();
        return $blocks;
    }
    function __construct() {
        $this->widget_cssclass    = 'sunday-widget-left-cog-info-location';
        $this->widget_id          = 'stkp-widget-contact-info';
        $this->widget_name        = esc_html__( '__Contact Info', 'sunday-news-lite-toolkit' );
        $this->widget_description = esc_html__( 'Show contact info.', 'sunday-news-lite-toolkit' );
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
            'desc' => array(
                'type'  => 'textarea',
                'std'   => '',
                'label' => esc_html__( 'Description:', 'sunday-news-lite-toolkit' ),
            ),
            'address' => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'Address:', 'sunday-news-lite-toolkit' ),
            ),
            'email' => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'Email:', 'sunday-news-lite-toolkit' ),
            ),
            'phone' => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'Phone:', 'sunday-news-lite-toolkit' ),
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
            <?php if ( $image ) : ?>
                <div class="sunday-left entry-thumb">
                    <div>
                        <img src="<?php echo esc_url( $image ); ?>" alt="">
                    </div>
                </div>
            <?php endif; ?>
            <div class="sunday-right">
                <?php 
                    if ( $desc ) {
                        echo '<p>'.wp_kses_post( $desc ).'</p>';
                    }

                    if ( $address ) {
                        echo '<i class="fa fa-building-o"></i>'.wp_kses_post( $address ).'';
                    }

                    if ( $phone ) {
                        echo '<a href="callto:'.wp_kses_post( $phone ).'"><i class="fa fa-phone"></i>'.wp_kses_post( $phone ).'</a>';
                    }

                    if ( $email ) {
                        echo '<a href="mailto:'.wp_kses_post( $email ).'"><i class="fa fa-envelope-o"></i>'.wp_kses_post( $email ).'</a>';
                    }
                ?>
            </div>
        <?php
        echo wp_kses_post( $after_widget );
    }
}