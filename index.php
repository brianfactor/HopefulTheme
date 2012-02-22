<?php
/**
 * The main template file. Borrowed from Twentyeleven.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package HopeTheme
 */

global $post, $wp_query;
get_header(); ?>

	<div class="container-bubble">
		<div id="primary">
			<div id="content" role="main">
			
			<header><h1 class="archive-title">
				<?php if (is_search()) {
					echo 'Search: "' . get_search_query(false) . '"';
				}
				else if (is_category()) {
					echo 'Category: "' . get_cat_name($wp_query->get('cat')) . '"';
				} 
				else if (is_tag()) {
					echo 'Tag: "' . $wp_query->get('tag') . '"';
				}
				else if (is_date()) {
					echo 'Date: "';
					if ($wp_query->get('monthnum') != 0) echo $wp_query->get('monthnum') . '/';
					if ($wp_query->get('day') != 0) echo $wp_query->get('day'). '/';
					echo $wp_query->get('year') . '"';
				}
				else {
					wp_title();
				} ?>
			</h1></header>
				
			<?php if ( have_posts() ) : ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', get_post_format() ); ?>

				<?php endwhile; ?>

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentyeleven' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Whoopse. Couln\'t find that page. Try searching for what you need:', 'twentyeleven' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>

			</div><!-- #content -->
		</div><!-- #primary -->

	<?php get_sidebar(); ?>
	<div style="clear:both"></div>
</div>

<?php get_footer(); ?>
