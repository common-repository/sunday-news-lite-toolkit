<?php

add_filter( 'sunday_news_toolkit_get_elements', 'sunday_news_toolkit_register_blockquote' );

function sunday_news_toolkit_register_blockquote( $groups ) {
    $groups['blockquotes'][] = array(
        'name' => esc_html__( 'Blockquote 1', 'sunday-news-lite-toolkit' ),
        'code' => '[sunday_news_toolkit_blockquote style="1" author="- Author -"]Blockquote Content[/sunday_news_toolkit_blockquote]'
        );
    $groups['blockquotes'][] = array(
        'name' => esc_html__( 'Blockquote 2', 'sunday-news-lite-toolkit' ),
        'code' => '[sunday_news_toolkit_blockquote style="2" author="- Author -"]Blockquote Content[/sunday_news_toolkit_blockquote]'
        );
    $groups['blockquotes'][] = array(
        'name' => esc_html__( 'Blockquote 3', 'sunday-news-lite-toolkit' ),
        'code' => '[sunday_news_toolkit_blockquote style="3" author="- Author -"]Blockquote Content[/sunday_news_toolkit_blockquote]'
        );

    return $groups;
}

add_shortcode( 'sunday_news_toolkit_blockquote', 'sunday_news_toolkit_shortcode_blockquote' );

function sunday_news_toolkit_shortcode_blockquote( $atts, $content = null ) {
    
    extract( shortcode_atts( array( 'style' => 1 ), $atts ) );
    $author  = isset( $atts['author'] ) ? $atts['author'] : '';
    switch((int)$atts['style']){
        case 1:
            $classes[] = 'sunday-semibold';
            break;
        case 2:
            $classes[] = 'sunday-semibold sunday-borderx2-left';
            break;
        case 3:
            $classes[] = 'sunday-semibold sunday-borderx2';
            break;
        default:
            $classes[] = 'sunday-semibold';
            break;
    } 
    ob_start();
    ?>
    <p class="<?php echo esc_attr( implode(' ', $classes) ); ?>">
        <?php echo wp_kses( $content, sunday_news_lite_get_allowed_tags() ); ?>
        <?php if( '' != $author ): ?>
            <span class="sunday-bold"><?php echo esc_attr( $author ); ?></span>
        <?php endif; ?>
    </p>

    <?php
    $string = ob_get_contents();
    ob_end_clean();

    return apply_filters( 'sunday_news_toolkit_shortcode_blockquote', $string, $atts, $content );
}
