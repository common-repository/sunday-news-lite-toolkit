<?php

add_action( 'widgets_init', array( 'Sunday_News_Toolkit_Plus_Widget_Three_Cols', 'register_widget' ) );

class Sunday_News_Toolkit_Plus_Widget_Three_Cols extends Kopa_Widget {

    public $kpb_group = 'post';

    public static function register_widget() {
        register_widget( 'Sunday_News_Toolkit_Plus_Widget_Three_Cols' );
    }
    function __construct() {
        $this->widget_cssclass    = 'sunday-widget-2-article-left-and-2-article-right';
        $this->widget_id          = 'stkp-widget-3cols';
        $this->widget_name        = esc_html__( '__Posts List 3 Cols', 'sunday-news-lite-toolkit' );
        $this->widget_description = esc_html__( 'Show posts list 3 cols.', 'sunday-news-lite-toolkit' );
        $this->settings           = sunday_news_lite_get_post_widget_args();
        $this->settings['get_related_by'] = array(
            'type'  => 'select',
            'std'   => 15,
            'label' => esc_html__( 'Get related by:', 'sunday-news-lite-toolkit' ),
            'options' => array(
                'post_tag' => esc_html__( 'Tags', 'sunday-news-lite-toolkit' ),
                'category' => esc_html__( 'Category', 'sunday-news-lite-toolkit' ),
            ),
            'desc'  => '',
        );
        $this->settings['number_related'] = array(
            'type'  => 'number',
            'std'   => 2,
            'label' => esc_html__( 'Number related post:', 'sunday-news-lite-toolkit' ),
            'desc'  => '',
        );
        $this->settings['main_excerpt_length'] = array(
            'type'  => 'number',
            'std'   => 20,
            'label' => esc_html__( 'Main excerpt length:', 'sunday-news-lite-toolkit' ),
            'desc'  => '',
        );
        $this->settings['sub_excerpt_length'] = array(
            'type'  => 'number',
            'std'   => 15,
            'label' => esc_html__( 'Sub excerpt length:', 'sunday-news-lite-toolkit' ),
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
                    <?php if ( $index == 1 ) : ?>
                        <div class="sunday-left">
                            <article class="entry-item">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <div class="entry-thumb">
                                        <div>
                                            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'sunday-news-283-215' ); ?></a>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="entry-content">
                                    <ul class="meta-data">
                                        <?php echo sunday_news_lite_get_first_category_by_id( get_the_id(), 'category' ); ?>
                                        <li><span class="date"><?php echo get_the_date(); ?></span></li>
                                    </ul>   
                                    <h5 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                                    <?php
                                        $GLOBALS['sunday_news_lite_excerpt_length'] = (int) $main_excerpt_length;
                                        add_filter( 'excerpt_length', 'sunday_news_lite_set_excerpt_length' );
                                            echo '<p class="entry-detail">'.get_the_excerpt().'</p>'; 
                                        remove_filter( 'excerpt_length', 'sunday_news_lite_set_excerpt_length' );
                                    ?>
                                    <a href="<?php the_permalink(); ?>" class="entry-read-more"><span>+</span><?php esc_html_e( 'Read more', 'sunday-news-lite-toolkit' ); ?></a>
                                    <?php echo sunday_news_lite_get_related_post( get_the_id(), $number_related, $get_related_by ); ?>
                                </div>
                            </article>
                        </div>
                    <?php elseif ( $index == 2 ) : ?>
                        <div class="sunday-middle">
                            <article class="entry-item">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <div class="entry-thumb">
                                        <div>
                                            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'sunday-news-283-215' ); ?></a>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="entry-content">
                                    <ul class="meta-data">
                                        <?php echo sunday_news_lite_get_first_category_by_id( get_the_id(), 'category' ); ?>
                                        <li><span class="date"><?php echo get_the_date(); ?></span></li>
                                    </ul>   
                                    <h5 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                                    <?php
                                        $GLOBALS['sunday_news_lite_excerpt_length'] = (int) $main_excerpt_length;
                                        add_filter( 'excerpt_length', 'sunday_news_lite_set_excerpt_length' );
                                            echo '<p class="entry-detail">'.get_the_excerpt().'</p>'; 
                                        remove_filter( 'excerpt_length', 'sunday_news_lite_set_excerpt_length' );
                                    ?>
                                    <a href="<?php the_permalink(); ?>" class="entry-read-more"><span>+</span><?php esc_html_e( 'Read more', 'sunday-news-lite-toolkit' ); ?></a>
                                    <?php echo sunday_news_lite_get_related_post( get_the_id(), $number_related, $get_related_by ); ?>
                                </div>
                            </article>
                        </div>
                    <?php else: ?>
                        <?php 
                            $first_item_class = '';
                            if ( $index == 3 ) {
                                echo '<div class="sunday-right">';
                                $first_item_class = 'sunday-first-child';
                            }
                        ?>
                            <article class="entry-item <?php echo esc_attr( $first_item_class ); ?>">
                                <div class="entry-content">
                                    <ul class="meta-data">
                                        <?php echo sunday_news_lite_get_first_category_by_id( get_the_id(), 'category' ); ?>
                                        <li><span class="date"><?php echo get_the_date(); ?></span></li>
                                    </ul>   
                                    <h5 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                                    <?php
                                        $GLOBALS['sunday_news_lite_excerpt_length'] = (int) $sub_excerpt_length;
                                        add_filter( 'excerpt_length', 'sunday_news_lite_set_excerpt_length' );
                                            echo '<p class="entry-detail">'.get_the_excerpt().'</p>'; 
                                        remove_filter( 'excerpt_length', 'sunday_news_lite_set_excerpt_length' );
                                    ?>
                                    <a href="<?php the_permalink(); ?>" class="entry-read-more"><span>+</span><?php esc_html_e( 'Read more', 'sunday-news-lite-toolkit' ); ?></a>                                             
                                </div>
                            </article>
                        <?php if ( $index == $result_set->post_count ) {
                                echo '</div>';
                            }
                        ?> 
                    <?php endif; ?>
                    <?php $index++; ?>     
                <?php endwhile; ?>
            <?php endif; ?>
        <?php
        echo wp_kses_post( $after_widget );
        wp_reset_postdata();
    }
}