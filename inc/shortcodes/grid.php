<?php

add_filter( 'sunday_news_toolkit_get_elements', 'sunday_news_toolkit_register_grid_elements' );

function sunday_news_toolkit_register_grid_elements( $groups ) {
    $groups['grids'][] = array(
        'name' => esc_html__( 'Grid 100%', 'sunday-news-lite-toolkit' ),
        'code' => '[sunday_news_toolkit_grid_row]<br/>[sunday_news_toolkit_grid_col col=12]TEXT[/sunday_news_toolkit_grid_col]<br/>[/sunday_news_toolkit_grid_row]<br/>'
        );
    $groups['grids'][] = array(
        'name' => esc_html__( 'Grid 50% x2', 'sunday-news-lite-toolkit' ),
        'code' => '[sunday_news_toolkit_grid_row]<br/>[sunday_news_toolkit_grid_col col=6]TEXT[/sunday_news_toolkit_grid_col]<br/>[sunday_news_toolkit_grid_col col=6]TEXT[/sunday_news_toolkit_grid_col]<br/>[/sunday_news_toolkit_grid_row]<br/>'
        );
    $groups['grids'][] = array(
        'name' => esc_html__( 'Grid 33% x3', 'sunday-news-lite-toolkit' ),
        'code' => '[sunday_news_toolkit_grid_row]<br/>[sunday_news_toolkit_grid_col col=4]TEXT[/sunday_news_toolkit_grid_col]<br/>[sunday_news_toolkit_grid_col col=4]TEXT[/sunday_news_toolkit_grid_col]<br/>[sunday_news_toolkit_grid_col col=4]TEXT[/sunday_news_toolkit_grid_col]<br/>[/sunday_news_toolkit_grid_row]<br/>'
        );
    $groups['grids'][] = array(
        'name' => esc_html__( 'Grid 33% - 66%', 'sunday-news-lite-toolkit' ),
        'code' => '[sunday_news_toolkit_grid_row]<br/>[sunday_news_toolkit_grid_col col=4]TEXT[/sunday_news_toolkit_grid_col]<br/>[sunday_news_toolkit_grid_col col=8]TEXT[/sunday_news_toolkit_grid_col]<br/>[/sunday_news_toolkit_grid_row]<br/>'
        );
    $groups['grids'][] = array(
        'name' => esc_html__( 'Grid 25% - 50% - 25%', 'sunday-news-lite-toolkit' ),
        'code' => '[sunday_news_toolkit_grid_row]<br/>[sunday_news_toolkit_grid_col col=3]TEXT[/sunday_news_toolkit_grid_col]<br/>[sunday_news_toolkit_grid_col col=6]TEXT[/sunday_news_toolkit_grid_col]<br/>[sunday_news_toolkit_grid_col col=3]TEXT[/sunday_news_toolkit_grid_col]<br/>[/sunday_news_toolkit_grid_row]<br/>'
        );
    $groups['grids'][] = array(
        'name' => esc_html__( 'Grid 25% x4', 'sunday-news-lite-toolkit' ),
        'code' => '[sunday_news_toolkit_grid_row]<br/>[sunday_news_toolkit_grid_col col=3]TEXT[/sunday_news_toolkit_grid_col]<br/>[sunday_news_toolkit_grid_col col=3]TEXT[/sunday_news_toolkit_grid_col]<br/>[sunday_news_toolkit_grid_col col=3]TEXT[/sunday_news_toolkit_grid_col]<br/>[sunday_news_toolkit_grid_col col=3]TEXT[/sunday_news_toolkit_grid_col]<br/>[/sunday_news_toolkit_grid_row]<br/>'
        );
    $groups['grids'][] = array(
        'name' => esc_html__( 'Grid 25% - 75%', 'sunday-news-lite-toolkit' ),
        'code' => '[sunday_news_toolkit_grid_row]<br/>[sunday_news_toolkit_grid_col col=3]TEXT[/sunday_news_toolkit_grid_col]<br/>[sunday_news_toolkit_grid_col col=9]TEXT[/sunday_news_toolkit_grid_col]<br/>[/sunday_news_toolkit_grid_row]<br/>'
        );
    $groups['grids'][] = array(
        'name' => esc_html__( 'Grid 16.6% - 66.6% - 16.6%', 'sunday-news-lite-toolkit' ),
        'code' => '[sunday_news_toolkit_grid_row]<br/>[sunday_news_toolkit_grid_col col=2]TEXT[/sunday_news_toolkit_grid_col]<br/>[sunday_news_toolkit_grid_col col=8]TEXT[/sunday_news_toolkit_grid_col]<br/>[sunday_news_toolkit_grid_col col=2]TEXT[/sunday_news_toolkit_grid_col]<br/>[/sunday_news_toolkit_grid_row]<br/>'
        );
    $groups['grids'][] = array(
        'name' => esc_html__( 'Grid 16.6% - 16.6% - 16.6% - 50%', 'sunday-news-lite-toolkit' ),
        'code' => '[sunday_news_toolkit_grid_row]<br/>[sunday_news_toolkit_grid_col col=2]TEXT[/sunday_news_toolkit_grid_col]<br/>[sunday_news_toolkit_grid_col col=2]TEXT[/sunday_news_toolkit_grid_col]<br/>[sunday_news_toolkit_grid_col col=2]TEXT[/sunday_news_toolkit_grid_col]<br/>[sunday_news_toolkit_grid_col col=6]TEXT[/sunday_news_toolkit_grid_col]<br/>[/sunday_news_toolkit_grid_row]<br/>'
        );
    $groups['grids'][] = array(
        'name' => esc_html__( 'Grid 16.6% x6', 'sunday-news-lite-toolkit' ),
        'code' => '[sunday_news_toolkit_grid_row]<br/>[sunday_news_toolkit_grid_col col=2]TEXT[/sunday_news_toolkit_grid_col]<br/>[sunday_news_toolkit_grid_col col=2]TEXT[/sunday_news_toolkit_grid_col]<br/>[sunday_news_toolkit_grid_col col=2]TEXT[/sunday_news_toolkit_grid_col]<br/>[sunday_news_toolkit_grid_col col=2]TEXT[/sunday_news_toolkit_grid_col]<br/>[sunday_news_toolkit_grid_col col=2]TEXT[/sunday_news_toolkit_grid_col]<br/>[sunday_news_toolkit_grid_col col=2]TEXT[/sunday_news_toolkit_grid_col]<br/>[/sunday_news_toolkit_grid_row]<br/>'
        );
    $groups['grids'][] = array(
        'name' => esc_html__( 'Grid 66% - 33%', 'sunday-news-lite-toolkit' ),
        'code' => '[sunday_news_toolkit_grid_row]<br/>[sunday_news_toolkit_grid_col col=8]TEXT[/sunday_news_toolkit_grid_col]<br/>[sunday_news_toolkit_grid_col col=4]TEXT[/sunday_news_toolkit_grid_col]<br/>[/sunday_news_toolkit_grid_row]<br/>'
        );
    $groups['grids'][] = array(
        'name' => esc_html__( 'Grid 83.3% - 16.6%', 'sunday-news-lite-toolkit' ),
        'code' => '[sunday_news_toolkit_grid_row]<br/>[sunday_news_toolkit_grid_col col=10]TEXT[/sunday_news_toolkit_grid_col]<br/>[sunday_news_toolkit_grid_col col=2]TEXT[/sunday_news_toolkit_grid_col]<br/>[/sunday_news_toolkit_grid_row]<br/>'
        );
    return $groups;
}

add_shortcode( 'sunday_news_toolkit_grid_row', 'sunday_news_toolkit_shortcode_grid_row' );
add_shortcode( 'sunday_news_toolkit_grid_col', '__return_false' );

function sunday_news_toolkit_shortcode_grid_row( $atts, $content = null ) {
    extract( shortcode_atts( array(), $atts ) );

    $cols = sunday_news_lite_extract_shortcodes( $content, true, array( 'sunday_news_toolkit_grid_col' ) );

    $output = '<div class="row">';

    if ($cols) {
        foreach ($cols as $col) {
            $output .= sprintf( '<div class="col-lg-%s">%s</div>', (int)$col['atts']['col'], do_shortcode( $col['content'] ) );
        }
    }

    $output.= '</div>';

    return apply_filters( 'sunday_news_toolkit_shortcode_grid_row', $output, $atts, $content );
}
