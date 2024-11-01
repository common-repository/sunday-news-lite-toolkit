<?php

add_filter( 'sunday_news_toolkit_get_elements', 'sunday_news_toolkit_register_buttons' );

function sunday_news_toolkit_register_buttons( $groups ) {
    $groups['buttons'][] = array(
        'name' => esc_html__( 'Button style 1', 'sunday-news-lite-toolkit' ),
        'code' => '[sunday_news_toolkit_button style="1" url="#" target="_self|_blank"]Content[/sunday_news_toolkit_button]'
        );
    $groups['buttons'][] = array(
        'name' => esc_html__( 'Button style 2', 'sunday-news-lite-toolkit' ),
        'code' => '[sunday_news_toolkit_button style="2" url="#" target="_self|_blank"]Content[/sunday_news_toolkit_button]'
        );
    $groups['buttons'][] = array(
        'name' => esc_html__( 'Button style 3', 'sunday-news-lite-toolkit' ),
        'code' => '[sunday_news_toolkit_button style="3" url="#" target="_self|_blank"]Content[/sunday_news_toolkit_button]'
        );
    $groups['buttons'][] = array(
        'name' => esc_html__( 'Button style 4', 'sunday-news-lite-toolkit' ),
        'code' => '[sunday_news_toolkit_button style="4" url="#" target="_self|_blank"]Content[/sunday_news_toolkit_button]'
        );
    $groups['buttons'][] = array(
        'name' => esc_html__( 'Medium button style 1', 'sunday-news-lite-toolkit' ),
        'code' => '[sunday_news_toolkit_button style="u-1" url="#" target="_self|_blank"]Content[/sunday_news_toolkit_button]'
        );
    $groups['buttons'][] = array(
        'name' => esc_html__( 'Medium button style 2', 'sunday-news-lite-toolkit' ),
        'code' => '[sunday_news_toolkit_button style="u-2" url="#" target="_self|_blank"]Content[/sunday_news_toolkit_button]'
        );
    $groups['buttons'][] = array(
        'name' => esc_html__( 'Medium button style 3', 'sunday-news-lite-toolkit' ),
        'code' => '[sunday_news_toolkit_button style="u-3" url="#" target="_self|_blank"]Content[/sunday_news_toolkit_button]'
        );

    return $groups;
}

add_shortcode( 'sunday_news_toolkit_button', 'sunday_news_toolkit_shortcode_button' );

function sunday_news_toolkit_shortcode_button( $atts, $content = null ) {
    extract( shortcode_atts( array(
        'style'  => '1',
        'title'  => '',
        'url'    => '',
        'target' => ''
        ), $atts ) );

    $url    = ( $url ) ? $url : '#';
    $target = ( $target ) ? $target : '_blank';

    $classes = apply_filters( 'sunday_news_toolkit_button_classes', array() );

    switch( $style ){
        case '1':
            $classes[] = 'sunday-button';
            break;
        case '2':
            $classes[] = 'sunday-button sunday-bt-ct-height1';
            break;
        case '3':
            $classes[] = 'sunday-button sunday-bt-ct-height2';
            break;
        case '4':
            $classes[] = 'sunday-button sunday-bt-ct-height3';
            break;
        case 'u-1':
            $classes[] = 'sunday-button sunday-bt-ct-background';
            break;
        case 'u-2':
            $classes[] = 'sunday-button-has-borderx2 sunday-borderx2';
            break;
        case 'u-3':
            $classes[] = 'sunday-button-has-borderx2 sunday-borderx2 sunday-bt-ct-color';
            break;
        default:
            $classes[] = 'sunday-button';
            break;
    }
    ob_start(); ?>
    <a class="<?php echo esc_attr( implode(' ', $classes) ); ?>" href="<?php echo esc_url( $url ); ?>" target="<?php echo esc_attr( $target ); ?>"><?php echo wp_kses( $content, sunday_news_lite_get_allowed_tags() ); ?></a>
    <?php
    $string = ob_get_contents();
    ob_end_clean();
    
    return apply_filters( 'sunday_news_toolkit_buttons', $string, $atts, $content );
}