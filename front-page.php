<?php
/*
Template Name: Front Page
*/

/*
 * Front Page template
 * This displays on the homepage when the user chooses for it to be a static page.
 * 
 * @package HopefulTheme
 */

// All the <head> and navigation stuff
get_header(); ?>

	<div class="container-bubble">

		<?php // Secondary, left hand widget area ?>
		<div id="secondary">
			<div class="widget-area">
				<?php if( !dynamic_sidebar('home-main') ) { // output the widget area if available 
					// Otherwise, output a placeholder image:
					echo '<img width="256" height="256" src="' . get_bloginfo('template_directory') . '/images/placeholder-pic.png" alt="Placeholder Image" />';
				} ?>
			</div><!-- .widget-area -->
		</div><!-- #secondary -->
	
		<?php // Primary area where the page is displayed ?>
		<div id="primary">
			<div id="content" role="main">
	
				<?php while ( have_posts() ) : the_post(); ?>
					<article class="home-featured">
						<h2 class="entry-title"><?php the_title(); ?></h2>		
						<div class="entry-content"><?php the_content(); ?></div>
						<?php edit_post_link('Edit', '<span class="edit-link">', '</span>'); ?>
					</article>
				<?php endwhile; // end of the loop. ?>
	
			</div><!-- #content -->
		</div><!-- #primary -->
		
		<div style="clear:both;"></div>
		
	</div>

	<?php // Addon "features" for blurbs ?>
	<div id="features">
		<div class="widget-area">
			<?php if ( !dynamic_sidebar('home-addons') ) { // Output the widgets if there are any
				// If not, output three Lorem Ipsum blocks
				echo '<div class="widget">';
					echo '<h3 class="widgettitle">Lot of widgets</h3>';
					echo '<p>Put some cool stuff here about you website.</p>';
				echo '</div><div class="widget">';
					echo '<h3 class="widgettitle">Featured stuff</h3>';
					echo '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>';
				echo '</div><div class="widget">';
					echo '<h3 class="widgettitle">Lorem Ipsum</h3>';
					echo '<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>';
				echo '</div>';
			} ?>
		</div>
	</div>


<?php get_footer(); ?>