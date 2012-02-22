<?php
/**
 * The template for displaying all pages. Borrowed from twentyeleven.
 *
 * This is the template that displays all static pages by default.
 *
 * @package HopefulTheme
 */
 
get_header(); ?>

<div class="container-bubble">
	<div id="primary">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

	<?php get_sidebar();?>
<div style="clear:both;"></div>
</div>
<?php get_footer(); ?>