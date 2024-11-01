<?php

add_filter( 'sunday_news_toolkit_get_elements', 'sunday_news_toolkit_register_related' );

function sunday_news_toolkit_register_related( $groups ) {
    $groups['related'][] = array(
        'name' => esc_html__( 'Related', 'sunday-news-lite-toolkit' ),
        'code' => '[sunday_news_toolkit_related get_by="post_tag|category" post_id="" limit=""]'
        );

    return $groups;
}

add_shortcode( 'sunday_news_toolkit_related', 'sunday_news_toolkit_related' );

function sunday_news_toolkit_related( $atts, $content = null ) {
    extract( shortcode_atts( array(
		'get_by'  => 'category',
		'limit'   => 2,
		'post_id' => '',
        ), $atts ) );

    $post_id = ( $post_id ) ? $post_id : get_the_id();

    ob_start(); 
    sunday_news_lite_get_related_post( $post_id, $limit, $get_by );
    $string = ob_get_contents();
    ob_end_clean();
    
    return apply_filters( 'sunday_news_toolkit_related', $string, $atts, $content );
}