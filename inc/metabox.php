<?php

function sunday_news_register_page_post_options() {

	$args = array(
        'id'          => 'sunday-news-metabox-advance-options',
        'title'       => esc_html__( 'Advance options', 'sunday-news-lite-toolkit' ),
        'desc'        => '',
        'pages'       => array( 'page', 'post' ),
        'context'     => 'normal',
        'priority'    => 'low',
        'fields'      => array(      
            array(
				'title'   => esc_html__( 'Is hide breaking news', 'sunday-news-lite-toolkit' ),						
				'type'    => 'checkbox',
				'default' => 0,
				'id'      => 'sunday_news_is_hide_breaking_news',
            ),
            array(
				'title'   => esc_html__( 'Is hide breadcrumb', 'sunday-news-lite-toolkit' ),						
				'type'    => 'checkbox',
				'default' => 0,
				'id'      => 'sunday_news_is_hide_breadcrumb',
            ),
            array(
                'title'   => esc_html__( 'Is hide title', 'sunday-news-lite-toolkit' ),                     
                'type'    => 'checkbox',
                'default' => 0,
                'id'      => 'sunday_news_is_hide_title',
            ),
        )
    );

    kopa_register_metabox( $args );

    $args = array(
        'id'          => 'sunday-news-metabox-advance-post-options',
        'title'       => esc_html__( 'Advance options', 'sunday-news-lite-toolkit' ),
        'desc'        => '',
        'pages'       => array( 'post' ),
        'context'     => 'normal',
        'priority'    => 'low',
        'fields'      => array(  
            array(
                'title'   => esc_html__( 'Title below thumbnail', 'sunday-news-lite-toolkit' ),                      
                'type'    => 'text',
                'default' => '',
                'id'      => 'sunday_news_thumbnail_title',
            ),
            array(
                'title'   => esc_html__( 'Descriptipn below thumbnail', 'sunday-news-lite-toolkit' ),                     
                'type'    => 'textarea',
                'default' => '',
                'id'      => 'sunday_news_thumbnail_info',
            ),  
        )
    );

    kopa_register_metabox( $args );

}
