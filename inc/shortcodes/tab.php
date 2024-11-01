<?php

add_filter( 'sunday_news_toolkit_get_elements', 'sunday_news_toolkit_register_tab' );

function sunday_news_toolkit_register_tab( $groups ) {
	$groups['tabs'][] = array(
		'name' => esc_html__( 'Tab 1', 'sunday_news-toolkit' ),
		'code' => '[sunday_news_toolkit_tabs style="1" cat_slugs="cat_slug,cat_slug" posts_per_page="2" excerpt="20"]'
		);
	$groups['tabs'][] = array(
		'name' => esc_html__( 'Tab 2', 'sunday_news-toolkit' ),
		'code' => '[sunday_news_toolkit_tabs style="2" cat_slugs="cat_slug,cat_slug" posts_per_page="2" excerpt="20"]'
		);
	$groups['tabs'][] = array(
		'name' => esc_html__( 'Tab 3', 'sunday_news-toolkit' ),
		'code' => '[sunday_news_toolkit_tabs style="3" cat_slugs="cat_slug,cat_slug" posts_per_page="2" excerpt="20"]'
		);

	return $groups;
}

add_shortcode( 'sunday_news_toolkit_tabs', 'sunday_news_toolkit_shortcode_tab' );

function sunday_news_toolkit_shortcode_tab( $atts, $content ) {
	extract( shortcode_atts( array('style' => '1'), $atts ) );

    ob_start();

	$style_id       = isset( $atts['style'] ) ? (int) $atts['style'] : 1 ; 
	$excerpt        = isset( $atts['excerpt'] ) ? (int) $atts['excerpt'] : 20 ; 
	$posts_per_page = isset( $atts['posts_per_page'] ) ? (int) $atts['posts_per_page'] : 2 ; 
	$cat_slugs      = explode( ',',  $atts['cat_slugs'] );
	
	$first        = true;
    $tabs_nav     = '';
    $tabs_content = '';

    if ( $cat_slugs ) {  
        foreach ( $cat_slugs  as $cat_slug ) {
            if ( $first ) {
                $class = 'active';
            } else {
                $class = '';
            }

            $rand = wp_generate_password( 8, false );
            $cat_obj   = get_category_by_slug( $cat_slug );
            if ( isset( $cat_obj->name ) ) {
                $cat_name  = $cat_obj->name;
                $cat_link  = get_category_link( $cat_obj->term_id );
                $term_meta = get_option( "taxonomy_$cat_obj->term_id" );
                $icon      = ( isset( $term_meta['icon'] ) ) ? $term_meta['icon'] : 'fa fa-newspaper-o';
                if ( $style == 1 ) {
	                $tabs_nav .= '<li class="'.esc_attr( $class ).'"><a href=".'.esc_attr( $rand.$cat_slug ).'" data-toggle="tab" title="'.esc_attr( $cat_name ).'"><i class="'.esc_attr( $icon ).'"></i></a></li>';
	            }
                if ( $style == 2 || $style == 3 ) {
                	$tabs_nav .= '<li class="'.esc_attr( $class ).'"><a href=".'.esc_attr( $rand.$cat_slug ).'" data-toggle="tab" title="'.esc_attr( $cat_name ).'">'.esc_attr( $cat_name ).'</a></li>';
                }

                $query = array(
                    'post_type'           => 'post',
                    'posts_per_page'      => $posts_per_page,
                    'ignore_sticky_posts' => true,
                    'category_name'       => $cat_slug
                );
                $result_set = new WP_Query( $query );
                if ( $result_set->have_posts() ) :
                    $tabs_content .= '<div class="tab-pane '.esc_attr( $class ).' sunday-tab-item1 '.esc_attr( $rand.$cat_slug ).'">';
                    $tabs_content .= '<div class="sunday-tab-title"><a href="'.esc_url( $cat_link ).'">'.esc_html( $cat_name ).'</a></div>';
                    while ( $result_set->have_posts() ) : $result_set->the_post();
                        $GLOBALS['sunday_news_lite_excerpt_length'] = (int) $excerpt;
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
    }
    ?>

    <?php 
    	if ( $style == 1 ) : 
    	if ( $tabs_nav ) : 
    ?>
		<div class="widget sunday-widget-has-affection-vertical-tabs">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-3 sunday-tab-list-icon">
                    <ul class="nav nav-tabs sunday-custom-nav-tab">
                        <?php echo $tabs_nav; ?>
                    </ul>
                </div>
                <div class="col-md-9 col-sm-9 col-xs-9 sunday-tab-list-content">
                    <div class="tab-content">
                        <?php echo $tabs_content; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php 
    	endif; 
    	endif; 
    ?>
    <?php 
    	if ( $style == 2 ) : 
    	if ( $tabs_nav ) : 
    ?>
		<div class="widget sunday-widget-tabs">
            <div class="widget-content clearfix">
                    <ul class="nav nav-tabs sunday-header-tab">
                        <?php echo $tabs_nav; ?>
                    </ul>
                
                    <div class="tab-content">
                        <?php echo $tabs_content; ?>
                    </div>
            </div>
        </div>
    <?php 
    	endif; 
    	endif; 
    ?>
    <?php 
    	if ( $style == 3 ) : 
    	if ( $tabs_nav ) : 
    ?>
		<div class="widget sunday-widget-tabs sunday-tab-hoz">
            <div class="widget-content clearfix">
                    <ul class="nav nav-tabs sunday-header-tab">
                        <?php echo $tabs_nav; ?>
                    </ul>
                
                    <div class="tab-content">
                        <?php echo $tabs_content; ?>
                    </div>
            </div>
        </div>
    <?php 
    	endif; 
    	endif; 
    ?>
    <?php 
    $string = ob_get_contents();
    ob_end_clean();
    
    return apply_filters( 'sunday_news_toolkit_shortcode_tab', $string, $atts, $content );
}
