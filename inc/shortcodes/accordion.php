<?php

add_filter( 'sunday_news_toolkit_get_elements', 'sunday_news_toolkit_register_accordion' );

function sunday_news_toolkit_register_accordion( $groups ) {
	$groups['accordion & toggle'][] = array(
		'name' => esc_html__( 'Accordion 1', 'sunday-news-lite-toolkit' ),
		'code' => '[sunday_news_toolkit_accordions style="1"]<br/>[sunday_news_toolkit_accordion title="Accordion title 1"]Accordion content 1[/sunday_news_toolkit_accordion]<br/>[sunday_news_toolkit_accordion title="Accordion title 2"]Accordion content 2[/sunday_news_toolkit_accordion]<br/>[sunday_news_toolkit_accordion title="Accordion title 3"]Accordion content 3[/sunday_news_toolkit_accordion]<br/>[/sunday_news_toolkit_accordions]',
		);
	$groups['accordion & toggle'][] = array(
		'name' => esc_html__( 'Accordion 2', 'sunday-news-lite-toolkit' ),
		'code' => '[sunday_news_toolkit_accordions style="2"]<br/>[sunday_news_toolkit_accordion title="Accordion title 1"]Accordion content 1[/sunday_news_toolkit_accordion]<br/>[sunday_news_toolkit_accordion title="Accordion title 2"]Accordion content 2[/sunday_news_toolkit_accordion]<br/>[sunday_news_toolkit_accordion title="Accordion title 3"]Accordion content 3[/sunday_news_toolkit_accordion]<br/>[/sunday_news_toolkit_accordions]',
		);
	return $groups;
}

add_shortcode( 'sunday_news_toolkit_accordions', 'sunday_news_toolkit_sunday_news_toolkit_accordions' );
add_shortcode( 'sunday_news_toolkit_accordion', '__return_false' );

function sunday_news_toolkit_sunday_news_toolkit_accordions( $atts, $content = null ) {
	extract( shortcode_atts( array(
        'style'  => '1',
        ), $atts) );
	$matches = sunday_news_lite_extract_shortcodes( $content, true, array( 'sunday_news_toolkit_accordion' ) );

	ob_start();
	if ( $style == '2' ){
		echo '<div class="sunday-accordion sunday-accordion-custom-style">';
	} else {
		echo '<div class="sunday-accordion">';
	}
	?>
		<?php
		for ( $i = 0; $i < count( $matches ); $i++ ) {
			$active = '';
			if ( $i == 0 ) {
				$active = 'open';
			}
			?>
			<h6 class="<?php echo esc_attr( $active ? $active : '' ); ?>">
				<?php echo ( isset( $matches[$i]['atts']['title'] ) ? $matches[$i]['atts']['title'] : '' ); ?>
			</h6>
			<div>
				<p>
					<?php echo do_shortcode( trim( (isset( $matches[$i]['content'] ) ? $matches[$i]['content'] : '' ) ) ); ?>
				</p>
			</div>
			<?php
		}
		?>
	</div>
	<?php
	$string = ob_get_contents();
	ob_end_clean();
	
	return apply_filters( 'sunday_news_toolkit_sunday_news_toolkit_accordions', $string, $atts, $content );
}