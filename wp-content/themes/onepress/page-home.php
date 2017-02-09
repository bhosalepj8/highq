 <?php
/**
 * Template Name: Home Page
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package OnePress


 */

get_header();
 ?>

	
        <section class="clearfix hero-image">
          <div class="container">
                <figure>
                  <img src="<?php echo get_template_directory_uri(); ?>/assets/images/hero-image.jpg" alt=""/>
				</figure>
          </div>
        </section><!-- mid section ends here -->

	<br/>

<?php get_footer(); ?>