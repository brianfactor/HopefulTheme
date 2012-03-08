<?php header('Content-type: text/css'); ?>
/*
 * This stylesheet changes the styling based on that settings from admin
 */

<?php
// Get all the options from GET variables (file arguments) - all should be color codes without # of course.
global $theme_settings;
?>

body {
	background-color: <?php echo $theme_settings['bg_color']; ?>;
}
