<?php global $post_id; ?>
<?php $post_class = skilled_class( 'post-item' ); ?>
<div class="one half col-md-4 single-result" <?php echo post_class( $post_class ) ?>>

	<div class="one whole">
		<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <!--<hr class="wh-separator"/>-->
		<div class="thumbnail">
			<?php skilled_get_thumbnail( 'wh-featured-image' ); ?>
		</div>
	</div>
	<div class="item one whole">
		<?php get_template_part( 'templates/entry-meta' ); ?>
		<div class="entry-summary"><?php echo strip_shortcodes( get_the_excerpt() ); ?></div>
		<a class="wh-button read-more" href="<?php the_permalink(); ?>"><?php _e( 'read more', 'skilled' ); ?></a>
	</div>
</div>
