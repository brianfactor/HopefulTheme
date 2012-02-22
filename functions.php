<?php
/*
 * Theme functions show up here
 * This file is called with every pageload.
 */

/* Includes */
include(TEMPLATEPATH . '/admin/themesettings.php');

global 	$theme_settings;
$theme_settings = get_option('hopeful-header-settings'); // Array with all the theme settings

/* Theme support for Thumbnails */
add_theme_support('post-thumbnails');
 
/* Add a ton of widget areas */

if ( function_exists('register_sidebar') ) {
	register_sidebar( array(
		'name' 			=> 'Primary Sidebar',
		'id' 			=> 'sidebar-1',
		'description'	=> 'This sidebar appears on the left side of most pages.',
		'before_widget' => '<div id="%1$s" class="widget %2$s left half">',
		'after_widget' 	=> '</div>',
		'before_title' 	=> '<h3 class="widgettitle">',
		'after_title' 	=> '</h3>' 
	));
	register_sidebar( array(
		'name' 			=> 'Front Page Featured',
		'id' 			=> 'home-main',
		'description'	=> 'These widgets appear on the homepage in the left featured area - if the homepage is set to display a static page.',
		'before_widget' => '<div id="%1$s" class="widget %2$s left half">',
		'after_widget' 	=> '</div>',
		'before_title' 	=> '<h3 class="widgettitle">',
		'after_title' 	=> '</h3>'
	));
	register_sidebar( array(
		'name' 			=> 'Front Page Addons',
		'id' 			=> 'home-addons',
		'description'	=> 'These widgets appear on the homepage just below the featured area. They\'re in columns of three.',
		'before_widget' => '<div id="%1$s" class="widget %2$s left half">',
		'after_widget' 	=> '</div>',
		'before_title' 	=> '<h3 class="widgettitle">',
		'after_title' 	=> '</h3>'
	));	
	register_sidebar( array(
		'name' 			=> 'Centered Footer',
		'id' 			=> 'footer-center',
		'description'	=> 'This is the first widget area in the footer on every page. It will display the widgets four columns at a time.',
		'before_widget' => '<div id="%1$s" class="widget %2$s left half">',
		'after_widget' 	=> '</div>',
		'before_title' 	=> '<h3 class="widgettitle">',
		'after_title' 	=> '</h3>'		
	));
	register_sidebar( array(
		'name' 			=> 'Left Footer',
		'id' 			=> 'footer-left',
		'description'	=> 'This is the bottom footer on the left side of every page.',
		'before_widget' => '<div id="%1$s" class="widget %2$s left half">',
		'after_widget' 	=> '</div>',
		'before_title' 	=> '<h3 class="widgettitle">',
		'after_title' 	=> '</h3>'		
	));
	register_sidebar( array(
		'name' 			=> 'Right Footer',
		'id' 			=> 'footer-right',
		'description'	=> 'This is the footer to the right side on every page.',
		'before_widget' => '<div id="%1$s" class="widget %2$s left half">',
		'after_widget' 	=> '</div>',
		'before_title' 	=> '<h3 class="widgettitle">',
		'after_title' 	=> '</h3>'		
	));
}

/* Register Navigation menu(s) */

register_nav_menu( 'primary', 'Primary Header Navigation' );

/* Functions used in a whole lot of pages */

// Page Title - borrowed from twentyeleven.
function twentyeleven_print_title() {
	global $page, $paged;
	wp_title( '|', true, 'right' );
	// Add the blog name.
	bloginfo( 'name' );
	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";
	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( 'Page %s', max($paged, $page) );
}

function favicon_url() {
	global $theme_settings; // Array with all the theme settings
	echo $theme_settings['favicon_url'];
}

function site_logo() {
	global $theme_settings;
	$logo_url = $theme_settings['logo_url'];
	
	if ( empty($logo_url) ) {
		echo '<h1>' . get_bloginfo('name') . '</h1>';
	}
	else { 	// Also need to check that file exists...
		$logo_size = getimagesize($logo_url); // This guy is REALLY slow if the file doesn't exist... eeh.
		echo '<img src="' . $logo_url 
		. '" width="' . $logo_size[0] 
		. '" height="' . $logo_size[1] 
		. '" alt="' . get_bloginfo('name') . '" />';
	}
}
