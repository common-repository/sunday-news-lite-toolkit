<?php

add_action( 'widgets_init', array( 'Sunday_News_Toolkit_Widget_Tabs', 'register_widget' ) );

class Sunday_News_Toolkit_Widget_Tabs extends Kopa_Widget {

    public $kpb_group = 'post';

    public static function register_widget(){
        register_widget( 'Sunday_News_Toolkit_Widget_Tabs' );
    }
    function __construct() {
        $all_cats = get_categories();
        $categories = array( '' => esc_html__( '-- none --', 'sunday-news-lite-toolkit' ) );
        foreach ( $all_cats as $cat ) {
            $categories[ $cat->slug ] = $cat->name;
        }

        $all_tags = get_tags();
        $tags = array( '' => esc_html__( '-- none --', 'sunday-news-lite-toolkit' ) );
        foreach( $all_tags as $tag ) {
            $tags[ $tag->slug ] = $tag->name;
        }
        $this->widget_cssclass    = 'sunday-widget-has-affection-vertical-tabs';
        $this->widget_id          = 'stk-widget-tabs';
        $this->widget_name        = esc_html__( '__Posts List Tabs', 'sunday-news-lite-toolkit' );
        $this->widget_description = esc_html__( 'Show posts list tabs.', 'sunday-news-lite-toolkit' );
        $this->settings           = array(
            'title'  => array(
                'type'  => 'text',
                'std'   => '',
                'label' => esc_html__( 'Title:', 'sunday-news-lite-toolkit' ),
            ),
            'categories' => array(
                'type'    => 'multiselect',
                'std'     => '',
                'label'   => esc_html__( 'Categories:', 'sunday-news-lite-toolkit' ),
                'options' => $categories,
                'size'    => '5',
            ),
            'order' => array(
                'type'  => 'select',
                'std'   => 'DESC',
                'label' => esc_html__( 'Order:', 'sunday-news-lite-toolkit' ),
                'options' => array(
                    'ASC'  => esc_html__( 'ASC', 'sunday-news-lite-toolkit' ),
                    'DESC' => esc_html__( 'DESC', 'sunday-news-lite-toolkit' ),
                ),
            ),
            'orderby' => array(
                'type'  => 'select',
                'std'   => 'date',
                'label' => esc_html__( 'Orderby:', 'sunday-news-lite-toolkit' ),
                'options' => array(
                    'date'          => esc_html__( 'Date', 'sunday-news-lite-toolkit' ),
                    'rand'          => esc_html__( 'Random', 'sunday-news-lite-toolkit' ),
                    'comment_count' => esc_html__( 'Number of comments', 'sunday-news-lite-toolkit' ),
                ),
            ),
            'number' => array(
                'type'    => 'number',
                'std'     => '5',
                'label'   => esc_html__( 'Number of posts:', 'sunday-news-lite-toolkit' ),
                'min'     => '1',
            ),
            'main_excerpt_length' => array(
                'type'    => 'number',
                'std'     => '20',
                'label'   => esc_html__( 'Number of posts:', 'sunday-news-lite-toolkit' ),
            )
        );

        parent::__construct();
    }

    public function widget( $args, $instance ) {
        $title      = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        $instance   = wp_parse_args( (array) $instance, $this->get_default_instance() );
        extract( $args );
        extract( $instance );
        echo wp_kses_post( $before_widget );
        if ( ! empty( $title ) ){
            echo wp_kses_post( $before_title.$title.$after_title );
        }
        $first        = true;
        $tabs_nav     = '';
        $tabs_content = '';
        if ( $instance['categories'] ) {        
            if ( $instance['categories'][0] == '' )
                unset( $instance['categories'][0] );
        }
        if ( $instance['categories'] ) {  
            foreach ( $instance['categories']  as $cat_slug ) {
                if ( $first ) {
                    $class = 'active';
                } else {
                    $class = '';
                }

                $cat_obj   = get_category_by_slug( $cat_slug );
                $cat_name  = $cat_obj->name;
                $cat_link  = get_category_link( $cat_obj->term_id );
                $term_meta = get_option( "taxonomy_$cat_obj->term_id" );
                $icon      = ( isset( $term_meta['icon'] ) ) ? $term_meta['icon'] : 'fa fa-newspaper-o';
                $tabs_nav .= '<li class="'.esc_attr( $class ).'"><a href=".'.esc_attr( $cat_slug ).'" data-toggle="tab" title="'.esc_attr( $cat_name ).'"><i class="'.esc_attr( $icon ).'"></i></a></li>';

                $query = array(
                    'post_type'           => 'post',
                    'posts_per_page'      => $instance['number'],
                    'order'               => isset( $instance['order'] ) && $instance['order'] == 'ASC' ? 'ASC' : 'DESC',
                    'orderby'             => $instance['orderby'],
                    'ignore_sticky_posts' => true,
                    'category_name'       => $cat_slug
                );
                $result_set = new WP_Query( $query );
                if ( $result_set->have_posts() ) :
                    $tabs_content .= '<div class="tab-pane '.esc_attr( $class ).' sunday-tab-item1 '.esc_attr( $cat_slug ).'">';
                    $tabs_content .= '<div class="sunday-tab-title"><a href="'.esc_url( $cat_link ).'">'.esc_html( $cat_name ).'</a></div>';
                    while ( $result_set->have_posts() ) : $result_set->the_post();
                        $GLOBALS['sunday_news_lite_excerpt_length'] = (int) $main_excerpt_length;
                        add_filter( 'excerpt_length', 'sunday_news_lite_set_excerpt_length' );
                        $excerpt_length = '<p class="entry-detail">'.get_the_excerpt().'</p>'; 
                        remove_filter( 'excerpt_length', 'sunday_news_lite_set_excerpt_length' );                   
                        $tabs_content .=   '<article class="entry-item xxx">
                                                <div class="entry-content">
                                                    <h6 class="entry-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h6>
                                                    <ul class="meta-data">
                                                        '.sunday_news_lite_get_first_category_by_id(get_the_id(), 'category').'
                                                        <li><span class="date">'.get_the_date().'</span></li>
                                                    </ul>                                                   
                                                    '.$excerpt_length.'                            
                                                </div>
                                            </article>';
                        $first = false;
                    endwhile; 
                    $tabs_content .= '</div>';
                endif;
                wp_reset_postdata();
            }
        }
        ?>
        <?php if ( $tabs_nav ) : ?>
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-3 sunday-tab-list-icon">
                    <ul class="nav nav-tabs sunday-custom-nav-tab">
                        <?php echo sprintf( '%s', $tabs_nav ); ?>
                    </ul>
                </div>
                <div class="col-md-9 col-sm-9 col-xs-9 sunday-tab-list-content">
                    <div class="tab-content">
                        <?php echo sprintf( '%s', $tabs_content ); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php
        echo wp_kses_post( $after_widget );
    }
}