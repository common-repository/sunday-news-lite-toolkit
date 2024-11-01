<?php

add_action( 'widgets_init', array( 'Sunday_News_Toolkit_Widget_Tow_Cols_Black_BG', 'register_widget' ) );

class Sunday_News_Toolkit_Widget_Tow_Cols_Black_BG extends Kopa_Widget {

    public $kpb_group = 'post';

    public static function register_widget() {
        register_widget( 'Sunday_News_Toolkit_Widget_Tow_Cols_Black_BG' );
    }
    function __construct() {
        $this->widget_cssclass    = 'sunday-widget-has-background-black-no-crog';
        $this->widget_id          = 'stk-widget-2cols-black-bg';
        $this->widget_name        = esc_html__( '__Posts List 2 Cols - Black Bg', 'sunday-news-lite-toolkit' );
        $this->widget_description = esc_html__( 'Show posts list 2 cols, black background.', 'sunday-news-lite-toolkit' );
        $this->settings           = sunday_news_lite_get_post_widget_args();
        $this->settings['main_excerpt_length'] = array(
            'type'  => 'number',
            'std'   => 20,
            'label' => esc_html__( 'Main excerpt length:', 'sunday-news-lite-toolkit' ),
            'desc'  => '',
        );
        $this->settings['text_link'] = array(
            'type'  => 'text',
            'std'   => '',
            'label' => esc_html__( 'View more text:', 'sunday-news-lite-toolkit' ),
            'desc'  => '',
        );
        $this->settings['url_link'] = array(
            'type'  => 'text',
            'std'   => '',
            'label' => esc_html__( 'View more URL:', 'sunday-news-lite-toolkit' ),
            'desc'  => '',
        );
        
        parent::__construct();
    }

    public function widget( $args, $instance ) {
        $title      = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        $instance   = wp_parse_args( (array) $instance, $this->get_default_instance() );
        extract( $args );
        extract( $instance );
        $query      = sunday_news_lite_get_post_widget_query( $instance );
        $result_set = new WP_Query( $query );
        echo wp_kses_post( $before_widget );
        if ( ! empty( $title ) ) {
            echo wp_kses_post( $before_title.$title.$after_title );
        }
        $index = 1;
        ?>
            <?php if ( $result_set->have_posts() ) : ?>
                <?php while ( $result_set->have_posts() ) : $result_set->the_post(); ?>
                    <?php 
                        if ( $index % 2 == 0 ) {
                            echo '<article class="entry-item sunday-right">';
                        } else {
                            echo '<article class="entry-item sunday-left">';
                        }
                    ?>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="entry-thumb">
                                <div>
                                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'sunday-news-353-430' ); ?></a>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="entry-content">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </div>
                    </article>
                    <?php $index++; ?>     
                <?php endwhile; ?>
            <?php endif; ?>
            <div class="clearfix"></div>
            <?php if ( $text_link && $url_link ) : ?>
                <p class="sunday-viewsmore">                                        
                    <a href="<?php echo esc_url( $url_link ); ?>"><?php echo esc_html( $text_link); ?></a>
                </p>
            <?php endif; ?>
        <?php
        echo wp_kses_post( $after_widget );
        wp_reset_postdata();
    }
}