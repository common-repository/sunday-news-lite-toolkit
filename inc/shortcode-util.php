<?php

add_action( 'admin_init', 'sunday_news_toolkit_admin_init' );
add_action( 'admin_enqueue_scripts', 'sunday_news_toolkit_admin_enqueue_scripts' );
add_action( 'admin_footer', 'sunday_news_toolkit_print_elements', 15 );

function sunday_news_toolkit_admin_init() {
	if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
		add_filter( 'mce_external_plugins', 'sunday_news_toolkit_load_editor_plugin' );
		add_filter( 'mce_buttons', 'sunday_news_toolkit_add_editor_button' );
	}
}

function sunday_news_toolkit_load_editor_plugin( $plugin_array ) {
	$plugin_array['sunday_news_toolkit_button'] = SUNDAY_NEWS_TOOLKIT_DIR . 'assets/js/tinymce.js';
	return $plugin_array;
}

function sunday_news_toolkit_add_editor_button( $buttons ) {
	$buttons[] = 'sunday_news_toolkit_button';
	return $buttons;
}

function sunday_news_toolkit_admin_enqueue_scripts( $hook ) {
	if ( in_array( $hook, array( 'widgets.php', 'post.php', 'post-new.php', 'edit.php' ), true ) ) {
		
		wp_enqueue_style( 'sunday-news-toolkit-featherlight', SUNDAY_NEWS_TOOLKIT_DIR . 'assets/css/featherlight.css', array(), null );
		wp_enqueue_style( 'sunday-news-toolkit-admin-style', SUNDAY_NEWS_TOOLKIT_DIR . 'assets/css/admin.style.css', array(), null );

		wp_enqueue_script( 'sunday-news-toolkit-featherlight', SUNDAY_NEWS_TOOLKIT_DIR . 'assets/js/featherlight.js', array( 'jquery' ), null, true );
		wp_enqueue_script( 'sunday-news-toolkit-admin-script', SUNDAY_NEWS_TOOLKIT_DIR . 'assets/js/admin.script.js', array( 'jquery' ), null, true );

		$localize_data = array(
			'translate' => array(
				'sunday_news_toolkit_elements' => esc_html__( 'Sunday News Elements', 'sunday-news-lite-toolkit' ),
			),
			'resource' => array(
				'icon' => SUNDAY_NEWS_TOOLKIT_DIR . 'assets/images/icon.png',
			),
		);

		wp_localize_script( 'sunday-news-toolkit-admin-script', 'sunday_news_toolkit_variables', $localize_data );
	}
}

function sunday_news_toolkit_print_elements() {
	$screen = get_current_screen();

	if ('post' === $screen->base ) {
		$groups = array();
		$groups = apply_filters('sunday_news_toolkit_get_elements', $groups);

		if ( $groups ) {
			$allowed_tags = sunday_news_lite_get_allowed_tags();
			?>	
			<div id="sunday-news-toolkit-elements">
				<?php
				$is_first = true;		
				foreach ( $groups as $group_slug => $group ) : 
					
					$title_caret     = '+';
					$title_classes[] = 'sunday-news-toolkit-title';					
					$grid_style      = 'display:none;';

					if ( $is_first ) {
						$is_first      = false;
						$title_caret   = '-';
						$grid_style    = '';
						$title_classes[] = 'sunday-news-toolkit-other';					
					}
					?>

					<h3 class="<?php echo esc_attr( implode( $title_classes, ' ' ) ); ?>">
						<?php echo esc_attr( sunday_news_lite_beautify( $group_slug ) ); ?>
						<small>(<?php echo esc_attr( count( $group ) );?>)</small>
						<span class="sunday-news-toolkit-caret">+</span>
					</h3>

					<div style="<?php echo esc_attr( $grid_style ); ?>">
						<div class="sunday-news-toolkit-row">
							<?php 
							$loop_index = 0;
							foreach ( $group as $element_slug => $element ) :
								if ( $loop_index && 0 === $loop_index  % 2) {
									echo '</div>';
									echo '<div class="sunday-news-toolkit-row">';
								}								
								?>

								<div class="sunday-news-toolkit-col">								
									<span class="sunday-news-toolkit-caption" onclick="sunday_news_toolkit_element.insert(jQuery(this));"><?php echo esc_attr( $element['name'] ); ?></span>
									<div class="sunday-news-toolkit-code">
										<?php echo wp_kses( $element['code'], $allowed_tags ); ?>
									</div>
								</div>
							<?php 
							$loop_index++;
							endforeach;
							?>
						</div>
					</div>
		     	<?php 		     	
		     	endforeach; 
		     	?>
			</div>
		<?php
		}
	}
}