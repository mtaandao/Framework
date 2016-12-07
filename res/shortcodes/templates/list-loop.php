<ul class="sm-posts sm-posts-list-loop">
<?php
// Posts are found
if ( $posts->have_posts() ) {
	while ( $posts->have_posts() ) {
		$posts->the_post();
		global $post;
?>
<li id="sm-post-<?php the_ID(); ?>" class="sm-post"><a href="<?php the_prettylink(); ?>"><?php the_title(); ?></a></li>
<?php
	}
}
// Posts not found
else {
?>
<li><?php _e( 'Posts not found', 'shortcodes' ) ?></li>
<?php
}
?>
</ul>
