<?php

add_filter( 'sunday_news_toolkit_get_elements', 'sunday_news_toolkit_register_dropcaps' );

function sunday_news_toolkit_register_dropcaps( $groups ) {
	$groups['dropcaps'][] = array(
		'name' => esc_html__( 'Dropcaps 1', 'sunday-news-lite-toolkit' ),
		'code' => '[sunday_news_toolkit_dropcaps style="1" drop_text="D"]ropcap style 1[/sunday_news_toolkit_dropcaps]'
		);
	$groups['dropcaps'][] = array(
		'name' => esc_html__( 'Dropcaps 2', 'sunday-news-lite-toolkit' ),
		'code' => '[sunday_news_toolkit_dropcaps style="2" drop_text="D"]ropcaps style 2[/sunday_news_toolkit_dropcaps]'
		);

	return $groups;
}

add_shortcode( 'sunday_news_toolkit_dropcaps', 'sunday_news_toolkit_shortcode_dropcap' );

function sunday_news_toolkit_shortcode_dropcap( $atts, $content ) {
	
	extract( shortcode_atts( array('style' => 1), $atts ) );
	$drop_text = isset( $atts['drop_text'] ) ? $atts['drop_text'] : '';

    switch( (int) $atts['style'] ) {
        case 1:
            $classes[] = 'sunday-dropcap';
            break;
        case 2:
            $classes[] = 'sunday-dropcap-has-background';
            break;
        default:
            $classes[] = 'sunday-dropcap';
            break;
    } 
    ob_start();
    ?>
	<p class="<?php echo esc_attr( implode(' ', $classes) ); ?>"><span><?php echo wp_kses( $drop_text, sunday_news_lite_get_allowed_tags() ); ?></span><?php echo wp_kses( $content, sunday_news_lite_get_allowed_tags() ); ?></p>
	<?php
	$string = ob_get_contents();
    ob_end_clean();

	return apply_filters( 'sunday_news_toolkit_shortcode_dropcap', $string, $atts, $content );
}
