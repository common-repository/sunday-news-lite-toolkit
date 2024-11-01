<?php

add_action( 'widgets_init', array( 'Sunday_News_Toolkit_Plus_Widget_Tow_Cols_Postformat', 'register_widget' ) );

class Sunday_News_Toolkit_Plus_Widget_Tow_Cols_Postformat extends Kopa_Widget {

    public $kpb_group = 'post';

    public static function register_widget() {
        register_widget( 'Sunday_News_Toolkit_Plus_Widget_Tow_Cols_Postformat' );
    }
    function __construct() {
        $this->widget_cssclass    = 'sunday-widget-2-row-2-col-4-article';
        $this->widget_id          = 'stkp-widget-2cols-postformat';
        $this->widget_name        = esc_html__( '__Posts List 2 Cols - Postformat', 'sunday-news-lite-toolkit' );
        $this->widget_description = esc_html__( 'Show posts list 2 cols with icon. Query post by postformat.', 'sunday-news-lite-toolkit' );
        $this->settings           = sunday_news_lite_get_post_widget_args();
        $this->settings['main_excerpt_length'] = array(
            'type'  => 'number',
            'std'   => 20,
            'label' => esc_html__( 'Main excerpt length:', 'sunday-news-lite-toolkit' ),
            'desc'  => '',
        );
        $this->settings['postformat'] = array(
            'type'  => 'multiselect',
            'std'     => '',
            'label'   => esc_html__( 'Post format:', 'sunday-news-lite-toolkit' ),
            'options' => array(
                'post-format-quote'   => esc_html__( 'Quote', 'sunday-news-lite-toolkit' ),
                'post-format-image'   => esc_html__( 'Image', 'sunday-news-lite-toolkit' ),
                'post-format-gallery' => esc_html__( 'Gallery', 'sunday-news-lite-toolkit' ),
                'post-format-audio'   => esc_html__( 'Audio', 'sunday-news-lite-toolkit' ),
                'post-format-video'   => esc_html__( 'Video', 'sunday-news-lite-toolkit' ),
                'post-format-link'    => esc_html__( 'Link', 'sunday-news-lite-toolkit' ),
            ),
            'size'    => '5',
        );
        
        parent::__construct();
    }

    public function widget( $args, $instance ) {
        $title      = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        $instance   = wp_parse_args( (array) $instance, $this->get_default_instance() );
        extract( $args );
        extract( $instance );
        $query      = sunday_news_lite_get_post_format_widget_query( $instance, $postformat );
        $result_set = new WP_Query( $query );
        echo wp_kses_post( $before_widget );
        if ( ! empty( $title ) ) {
            echo wp_kses_post( $before_title.$title.$after_title );
        }
        ?>
            <?php if ( $result_set->have_posts() ) : ?>
                <div class="row">
                <?php while ( $result_set->have_posts() ) : $result_set->the_post(); ?>  
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <article class="entry-item">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="entry-thumb sunday-thumb-has-icon">
                                    <div>
                                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'sunday-news-189-133' ); ?></a>
                                    </div>
                                    <a href="<?php echo the_permalink(); ?>"><?php echo sunday_news_lite_get_icon_postformat_by_id( get_the_id() ); ?></a>
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
                            </div>
                        </article>
                    </div>
                <?php endwhile; ?>
                </div>
            <?php endif; ?>
        <?php
        echo wp_kses_post( $after_widget );
        wp_reset_postdata();
    }
}