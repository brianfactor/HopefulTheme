<?php
/**
 * The template for displaying the footer. A little bit form twentyeleven
 * 
 * @package 
 */
?>

	</div><!-- #main -->

	<footer id="colophon" role="contentinfo">

			<?php
				if ( function_exists('dynamic_sidebar') ) {
					echo '<div id="footer-center" class="widget-area">';
						if ( !dynamic_sidebar('footer-center') ) { // Try to output the widgetized area
							// Otherwise output all the blog's links
							the_widget('WP_Widget_Links'); 
						};
					echo '</div>';
					
					echo '<div id="footer-left" class="widget-area">';
						if ( !dynamic_sidebar('footer-left')) { // Try to output the widgetized area
							// Otherwise, display just the site name and copyright
							echo '<p>
								&copy; ' . date('Y') . ' <a href="' . get_bloginfo('wpurl') . '">' . get_bloginfo('name') . '</a>.
							</p>';
						}
					echo '</div>';
					
					echo '<div id="footer-right" class="widget-area">';
						if ( !dynamic_sidebar('footer-right') ) { // Try to output
							// Otherwise, output wordpress credit
							echo '<p id="site-generator">
								<a href="' . esc_url('http://wordpress.org/') .'" title="' . esc_attr('Semantic Personal Publishing Platform') . '" rel="generator">
								Proudly powered by WordPress.
								<img src="' . get_bloginfo('template_directory') . '/images/wordpress.png" alt="Wordpress icon" width="16" height="16" style="vertical-align:top;" />
							</a></p>';
						}
					echo '</div>';
				}
					
			?>

	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>