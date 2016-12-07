<div class="sm-posts sm-posts-single-post">
	<?php
		// Prepare marker to show only one post
		$first = true;
		// Posts are found
		if ( $posts->have_posts() ) {
			while ( $posts->have_posts() ) :
				$posts->the_post();
				global $post;

				// Show oly first post
				if ( $first ) {
					$first = false;
					?>
					<div id="sm-post-<?php the_ID(); ?>" class="sm-post">
						<h1 class="sm-post-title"><?php the_title(); ?></h1>
						<div class="sm-post-meta"><?php _e( 'Posted', 'shortcodes' ); ?>: <?php the_time( get_option( 'date_format' ) ); ?> | <a href="<?php comments_link(); ?>" class="sm-post-comments-link"><?php comments_number( __( '0 comments', 'shortcodes' ), __( '1 comment', 'shortcodes' ), __( '%n comments', 'shortcodes' ) ); ?></a></div>
						<div class="sm-post-content">
							<?php the_content(); ?>
						</div>
					</div>
					<?php
				}
			endwhile;
		}
		// Posts not found
		else {
			echo '<h4>' . __( 'Posts not found', 'shortcodes' ) . '</h4>';
		}
	?>
</div>