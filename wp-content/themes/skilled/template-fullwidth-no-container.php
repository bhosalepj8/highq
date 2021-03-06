<?php
/**
 * @package WordPress
 * @subpackage Wheels
 *
 * Template Name: Full Width No Contaner
 */
get_header();
?>
<?php get_template_part( 'templates/title' ); ?>
<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>
