<?php
/*
 * Custom User options for HopefulTheme
 */
// Need feature expansion

/** Register everything **/

function hopeful_options_page() {
	// Create the settings page
	add_submenu_page( 'themes.php', 'HopefulTheme Customization', 'Hopeful Settings', 'edit_theme_options', 'hopefultheme-settings',  'hopeful_settings_page');
	return;
}
add_action('admin_menu', 'hopeful_options_page');

function hopeful_options() {
	// Create all the settings
	$default_hopeful_settings = array(
		'logo_url'			=> '',
		'favicon_url'		=> '',
		'color_stylesheet'	=> ''
	);
	add_option('hopeful-header-settings', $default_hopeful_settings);
	return;
}
add_action('admin_init', 'hopeful_options'); // If there are ever a whole lot of settings, we may not want to load them in every admin page.

// Register scripts and styles for using the Wordpress Uploader:
function wp_uploader_ldscripts() {
	wp_enqueue_script('jquery');
	wp_enqueue_script('thickbox');
	wp_enqueue_script('media-upload');
}
function wp_uploader_ldstyles() {
	wp_enqueue_style('thickbox');
}
if (isset($_GET['page']) && $_GET['page'] == 'hopefultheme-settings') { // If we're on the theme's option page, enque the scripts
	add_action('admin_enqueue_scripts', 'wp_uploader_ldscripts');
	add_action('admin_print_styles', 'wp_uploader_ldstyles');
}

/** Display the options page **/

function hopeful_settings_page() { global $hopeful_header_settings;
	// Get all variables
	$hopeful_settings = get_option('hopeful-header-settings');
	
	// When the current page is reloaded, we test if the hidden field was submitted with it. 
	// If so, update the options with what was submitted.
	if ( isset( $_POST['hopeful-settings-submit'] ) && ($_POST['hopeful-settings-submit'] == "Y") ) {
		// Print message that records if there's an invalid input.
		echo '<div id="message" class="updated"><p><strong>';

		$hopeful_settings['color_stylesheet'] = $_POST['hopeful-color-stylesheet'];	// Shouldn't need sanitizing - selector
		$hopeful_settings['logo_url'] = _hopeful_logo_sanitize( $_POST['hopeful-logo-url'] );
		$hopeful_settings['favicon_url'] = _hopeful_logo_sanitize( $_POST['hopeful-favicon-url'] );

		update_option('hopeful-header-settings', $hopeful_settings);
		
		// Print pretty message
		echo 'Settings saved.';
		echo '</strong></p></div>';
	}
?>
	<style type="text/css">
		form h3 {
			border-bottom: 1px solid #999;
			margin-top: 2em;
		}
	</style>

	<script type="text/javascript">
		// Special thanks to Matt at Webmaster Source for help with the image uploader
		// http://www.webmaster-source.com/2010/01/08/using-the-wordpress-uploader-in-your-plugin-or-theme/
		jQuery(document).ready(function() {
			var img_uploaded;
			
			jQuery('#upload_logo_button').click(function() {
				formfield = jQuery('#upload_logo').attr('name');
				tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
				return false;
			});
			
			window.send_to_editor = function(html) { // Overwrite default function
				imgurl = jQuery('img',html).attr('src');
				jQuery('#upload_logo').val(imgurl);
				tb_remove();
			}
		});
		// Now the question is how to do it if you have have more than one field...
	</script>

	<div class="wrap">
		<!-- title and info -->
		<h2>HopefulTheme :: Settings</h2>
		<p>Welcome! Here you can customize the look of your HopefulTheme. To customize further, <a href="/wp-admin/nav-menus.php">add widgets</a>, <a href="/wp-admin/widgets.php">customize the menus</a>, or <a href="/wp-admin/edit.php?post_type=wpss_slides&page=wpss-options">tweak the slider</a>.</p>

		<form method="post" action=""> <?php // This page is the option processor ?>
			<input type="hidden" name="hopeful-settings-submit" value="Y" />
			
			<h3>Logos</h3>
			
			<p>If you would like to use your own images, <a href="/wp-admin/media-new.php">upload them</a> and then copy and paste the link into the right box:</p>
				<?php $hopeful_logo_url = $hopeful_settings['logo_url'];
				$hopeful_favicon_url = $hopeful_settings['favicon_url']; ?>
				
				<h4>Site Header Logo</h4>
					
					<p>This logo goes in the top left corner and replaces your site title. Optimum size: 200x75 px. Other sizes will create inconsistent results. <br />
					Leave this blank to just use the Site Title (which can be changed in <a href="/wp-admin/options-general.php">General Settings</a>). Make sure to click save after your upload.</p>
					<input id="upload_logo" type="text" placeholder="http://" name="hopeful-logo-url" size="50" value="<?php echo $hopeful_logo_url; ?>" />
					<input id="upload_logo_button" class="button" type="button" value="Upload/Change Logo" />
					
				<h4>Favicon (small logo)</h4>
				
					<p>A favicon should be 16x16 px. It will be your website's icon in the browser. This should be a .ico image for best browser compadibility.</p>
					<input id="upload_favicon" type="text" placeholder="http://" name="hopeful-favicon-url" size="50" value="<?php echo $hopeful_favicon_url; ?>" />
					<input id="upload_favicon_button" class="button" type="button" value="Upload/Change Image" />
					<p>Not sure what this is? Need help making a favicon? Contact <a href="http://authormedia.com/contact/">Author Media</a>.</p>
			
				<p>Facebook openGraph image - maybe?</p>
			
			<h3>Styles &amp; Colors</h3>
			
				<p>Select a pre-defined color theme from the list below:</p>
				<select name="hopeful-color-stylesheet">
					<?php $current_color = $hopeful_settings['color_stylesheet'];
					
					$color_stylesheet_dir = get_template_directory() . '/colors/';
					$color_list = scandir( $color_stylesheet_dir ); 		// Array with all the files in the colors directory
					$count = 0;
					foreach ($color_list as $color) :
						$extension = end( explode('.', $color) );
						if ( $extension != 'css' ) {
							continue;
						}
						echo '<option value="' . $color . '"';
						if ( $color == $current_color ) {
							echo ' selected';
						}
						echo '>' . $color . '</option>';
					endforeach;
					echo '<option value=""';
					if($color == '' ) echo ' selected';
					echo '>(none)</option>'; ?>
				</select>
				
				<h4>Custom colors</h4>
				
					<p>Background color: <input type="text" name="bg-color" value="#000000" /></p>
					<p>Main background color: <input type="text" name="main-bg-color" value="#ffffff" /></p>
					<p>Main text color: <input type="text" name="main-txt-color" value="#000000" /></p>
					<p>Secondary background color: <input type="text" name="second-bg-color" value="#DDD" /></p>
					<p>Secondary text color: <input type="text" name="secondary-txt-color" value="#BBB" /></p>
					<p>Random background colors (seperate by comas): <input type="text" name="random-colors" size="50" /></p>
				
				<h4>Custom background.</h4>
				
					<p>Choose an image to be the background. Leave blank to use the color from above.</p>
						<input type="text" placeholder="http://" size="50" />
					
					<p>background settings:<br />
						<input type="checkbox" name="bg-repeat" value="true" /> Repeat image<br />
						<input type="radio" name="bg-position" value="left top" /> Position at top left<br />
						<input type="radio" name="bg-position" value="right top" /> Position at top right<br />
						<input type="radio" name="bg-position" value="left bottom"/> Position at bottom left<br />
						<input type="radio" name="bg-position" value="right bottom" /> Position at bottom right
					</p>
				
			<h3>Layout</h3>
				
				<p><input type="checkbox" /> Display featured widget on homepage?</p>
				
				<p><input type="checkbox" /> Display center footer widget?</p>
				
			<h3>Advanced: Custom CSS</h3>
			
				<p>If you are not satisfied by the settings above, you can use CSS. If you find you need more than a few lines, I recommend making a <a href="http://codex.wordpress.org/Child_Themes">child theme</a>.</p>
				<textarea rows="10" cols="100" name="custom-css"></textarea>
				
			<p class="submit">
                <input type="submit" class="button-primary" value="Save Settings" />
            </p>
            
		</form>
		
	</div>
<?php }

/** Functions for sanitizing the input from the settings page **/

function _hopeful_logo_sanitize( $logo_url ) {
	if ( empty($logo_url) ) {
		return '';
	}

	$valid_imgs = array ( 'png', 'jpg', 'jpeg', 'ico', 'bmp', 'gif', 'svg' );
	$extension = end( explode('.', $logo_url) );
	if ( !in_array($extension, $valid_imgs) ) {	// If this does not have a valid image extension
		echo 'Invalid Logo input; wrong filetype. It needs to have one of these file extensions:';
		foreach ( $valid_imgs as $ext )
			echo ' ' . $ext;
		echo '. Or just leave blank to use text.<br />';
	}
	$sanitized_url = esc_url_raw($logo_url);
	if ( $sanitized_url ) {
		return $sanitized_url;
	}
	else {
		echo 'Invalid Logo input. Perhaps it\'s a bad protocol.<br />';
		return $default_hopeful_settings['logo_url'];
	}
}

?>
