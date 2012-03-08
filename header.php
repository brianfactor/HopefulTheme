<?php
/**
 * The Header for our theme. Borrowed from twentyeleven... well, a lot of it is.
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package HopefulTheme
 */

 // Theme settings
 global $theme_settings; // Retrieved in functions.php
 
?>
<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	
	<title><?php twentyeleven_print_title(); // In functions.php ?></title>
	
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<!-- favicon --><link rel="shortcut icon" href="<?php favicon_url(); ?>"/>

	
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->
	<?php // For threaded comments when you hit "reply"?
	if ( is_singular() && get_option( 'thread_comments' ) )	wp_enqueue_script( 'comment-reply' ); ?>

	<!-- Custom code from the theme admin --> 
	<script type="text/javascript">
// Use this usually for analytics code and the like
<?php echo $theme_settings['custom_js']; ?>
	</script>
	<style type="text/css">
/* Use this one for custom styles */
<?php echo $theme_settings['custom_css']; ?>
	</style>
	
	<!-- begin wp head -->
	<?php wp_head();?>
</head>

<body <?php body_class(); ?>>

<div id="page" class="hfeed">
	<header id="branding" role="banner">

		<hgroup style="display:none;">
			<h1 id="site-title"><span><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span></h1>
			<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
		</hgroup>
		
		<nav id="access" role="navigation">
			
			<div class="title-menu-container logo-container">
				<ul class="menu">
				<li class="menu-item menu-item-home <?php if(is_front_page()) echo 'current-menu-item current_page_item'; ?>">
					<a href="<?php bloginfo('wpurl'); ?>">
						<?php site_logo(); ?>
					</a>
				</li></ul>
			</div>
			
			<div class="menu-container">
				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			</div>
			
			<?php if (is_search()) {
				echo '<header class="current-search">';
				get_search_form();
				echo '</header>'; 
			} else {
				get_search_form();
			}?>
		</nav><!-- #access -->
	</header><!-- #branding -->

	<div id="main">