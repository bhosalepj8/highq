<?php
/**
 * @package WordPress
 * @subpackage Wheels
 */
$is_boxed = skilled_get_option( 'single-post-is-boxed', false );
if ( $is_boxed ) {
	get_header( 'boxed' );
} else {
	get_header();
}
?>
<?php get_template_part( 'templates/title' ); ?>
<div class="<?php echo skilled_class( 'main-wrapper' ) ?>">
	<div class="<?php echo skilled_class( 'container' ); ?>">
		<?php if ( skilled_get_option( 'single-post-sidebar-left', false ) ): ?>
			<div class="<?php echo skilled_class( 'sidebar' ) ?>">
				<?php get_sidebar(); ?>
			</div>
			<div class="<?php echo skilled_class( 'content' ) ?>">
				<?php get_template_part( 'templates/content-single' ); ?>
			</div>
		<?php else: ?>
			<div class="<?php echo skilled_class( 'content' ) ?>">
				<?php get_template_part( 'templates/content-single' ); ?>
			</div>
			<div class="<?php echo skilled_class( 'sidebar' ) ?>">
				<?php get_sidebar(); ?>
			</div>
		<?php endif; ?>
	</div>
</div>
<?php
if ( $is_boxed ) {
	get_footer( 'boxed' );
} else {
	get_footer();
}
?>
