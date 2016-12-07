<div class="sm-posts sm-posts-default-loop">
	<?php
		// Posts are found
		if ( $posts->have_posts() ) {
			while ( $posts->have_posts() ) :
				$posts->the_post();
				global $post;
				?>

				<div id="sm-post-<?php the_ID(); ?>" class="sm-post">
					<?php if ( has_post_thumbnail() ) : ?>
						<a class="sm-post-thumbnail" href="<?php the_prettylink(); ?>"><?php the_post_thumbnail(); ?></a>
					<?php endif; ?>
					<h2 class="sm-post-title"><a href="<?php the_prettylink(); ?>"><?php the_title(); ?></a></h2>
					<div class="sm-post-meta"><?php _e( 'Posted', 'shortcodes' ); ?>: <?php the_time( get_option( 'date_format' ) ); ?></div>
					<div class="sm-post-excerpt">
						<?php the_excerpt(); ?>
					</div>
					<a href="<?php comments_link(); ?>" class="sm-post-comments-link"><?php comments_number( __( '0 comments', 'shortcodes' ), __( '1 comment', 'shortcodes' ), '% comments' ); ?></a>
				</div>

				<?php
			endwhile;
		}
		// Posts not found
		else {
			echo '<h4>' . __( 'Posts not found', 'shortcodes' ) . '</h4>';
		}
	?>
</div>