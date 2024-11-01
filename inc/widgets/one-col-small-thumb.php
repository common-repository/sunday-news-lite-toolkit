<?php

add_action( 'widgets_init', array( 'Sunday_News_Toolkit_Widget_One_Col_Small_Thumb', 'register_widget' ) );

class Sunday_News_Toolkit_Widget_One_Col_Small_Thumb extends Kopa_Widget {

    public $kpb_group = 'post';

    public static function register_widget() {
        register_widget( 'Sunday_News_Toolkit_Widget_One_Col_Small_Thumb' );
    }
    function __construct() {
        $this->widget_cssclass    = 'sunday-widget-5-article-thumb-left-info-right';
        $this->widget_id          = 'stk-widget-one-col-small-thumb';
        $this->widget_name        = esc_html__( '__Posts List 1 Col - S Thumb', 'sunday-news-lite-toolkit' );
        $this->widget_description = esc_html__( 'Show posts list 1 col, small thumbnail.', 'sunday-news-lite-toolkit' );
        $this->settings           = sunday_news_lite_get_post_widget_args();
        $this->settings['main_excerpt_length'] = array(
            'type'  => 'number',
            'std'   => 20,
            'label' => esc_html__( 'Main excerpt length:', 'sunday-news-lite-toolkit' ),
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
        $first = true;
        ?>
            <?php if ( $result_set->have_posts() ): ?>
                <?php while( $result_set->have_posts() ) : $result_set->the_post(); ?>
                    <?php 
                        if ( $first ) {
                            echo '<article class="entry-item sunday-first-item clearfix">';
                            $first = false;
                        } else {
                            echo '<article class="entry-item clearfix">';
                        }
                    ?>
                        <ul class="meta-data">
                            <?php echo sunday_news_lite_get_first_category_by_id( get_the_id(), 'category' ); ?>
                            <li><span class="date"><?php echo get_the_date(); ?></span></li>
                        </ul>     
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="entry-thumb">
                                <div>
                                    <?php the_post_thumbnail( 'sunday-news-78-60' ); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="entry-content">
                            <h6 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>    
                            <?php
                                $GLOBALS['sunday_news_lite_excerpt_length'] = (int) $main_excerpt_length;
                                add_filter( 'excerpt_length', 'sunday_news_lite_set_excerpt_length' );
                                    echo '<p class="entry-detail">'.get_the_excerpt().'</p>'; 
                                remove_filter( 'excerpt_length', 'sunday_news_lite_set_excerpt_length' );
                            ?>
                        </div>
                    </article>
                <?php endwhile; ?>
            <?php endif; ?>
        <?php
        echo wp_kses_post( $after_widget );
        wp_reset_postdata();
    }
}