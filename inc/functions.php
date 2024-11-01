<?php

add_action( 'sunday_news_single_social_share', 'sunday_news_toolkit_social_share' );
function sunday_news_toolkit_social_share( ) {
	$is_show_share_about_author = get_theme_mod( 'single_share' );
    if ( ! $is_show_share_about_author )
        return;
	global $post;
	$user_id    = $post->post_author;
	$twitter    = get_the_author_meta( 'twitter', $user_id );
	$name       = get_the_author_meta( 'display_name', $user_id );
	$post_url   = get_permalink( get_the_id() );
	$post_title = get_the_title( get_the_id() );
	?>
	<ul class="sunday-social-tool clearfix">
		
		<li class="sunday-fixheight6 sunday-mail-button">
			<?php 
				$subject = esc_html__( 'I wanted you to see this site', 'sunday-news-lite-toolkit' ); 
				$body = esc_html__( 'Check out this site', 'sunday-news-lite-toolkit' ); 
			?>
			<a href="mailto:?subject=<?php echo urlencode( $subject); ?>&amp;body=<?php echo urlencode( $body ); the_permalink(); ?>"
	   title="<?php esc_html_e( 'Share by Email', 'sunday-news-lite-toolkit' ); ?>"><span class="fa fa-envelope-o"></span><?php esc_html_e( 'Email', 'sunday-news-lite-toolkit' ); ?></a>
		</li>

		<li class="sunday-fixheight6 sunday-print-button">
			<a><span class="fa fa-print"></span><?php esc_html_e( 'Print', 'sunday-news-lite-toolkit' ); ?></a>
		</li>

		<li class="sunday-fixheight6 sunday-haschild">
			<a class="sunday-icon-plus" href="#"><span >+</span><?php esc_html_e( 'Share', 'sunday-news-lite-toolkit' ); ?></a>				
			<div class="sunday-content-lv1">
				<ul>
					<li><a href="<?php echo esc_url( sprintf( '//twitter.com/home?status=%s+%s', $post_title, $post_url ) ); ?>"><i class="fa fa-twitter"></i><?php esc_html_e( 'Twitter', 'sunday-news-lite-toolkit' ); ?></a></li>
					<li><a href="<?php echo esc_url( sprintf( '//www.facebook.com/share.php?u=%s', urlencode( $post_url ) ) ); ?>"><i class="fa fa-facebook"></i><?php esc_html_e( 'Facebook', 'sunday-news-lite-toolkit' ); ?></a></li>
					<li><a href="<?php echo esc_url(sprintf('//plus.google.com/share?url=%s', $post_url)); ?>"><i class="fa fa-google"><span class="fa fa-plus"></span></i><?php esc_html_e( 'Google +', 'sunday-news-lite-toolkit' ); ?></a></li>
					<li><a href="http://pinterest.com/pin/create/button/?url=<?php echo $post_url;?>&description=<?php echo urlencode( $post_title );?>"><i class="fa fa-pinterest"></i><?php esc_html_e( 'Pinterest', 'sunday-news-lite-toolkit' ); ?></a></li>
				</ul>
			</div>
		</li>

		<li class="sunday-fixheight6">							
			<a href="#link-to-comment"><span class="fa fa-comment-o"></span><?php esc_html_e( 'Comment', 'sunday-news-lite-toolkit' ); ?></a>
		</li>
		<?php if ( $twitter ) : ?>
			<li class="sunday-fixheight6"><a href="<?php echo esc_url( $twitter ); ?>"><span class="fa fa-twitter"></span><?php esc_html_e( 'Follow us @', 'sunday-news-lite-toolkit' );  echo esc_html( $name ); ?></a></li>
		<?php endif; ?>
	</ul>
	<?php
}