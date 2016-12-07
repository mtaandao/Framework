<div class="sm-posts sm-posts-teaser-loop">
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