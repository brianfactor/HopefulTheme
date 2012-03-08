<?php
/*
 * Custom User options for HopefulTheme
 */
// Need feature expansion

/** Register everything **/

function hopeful_options_page() {
	// Create the settings page
	add_submenu_page( 'themes.php', 'HopefulTheme Customization', 'Hopeful Settings', 'edit_theme_options', 'hopefultheme-settings',  'hopeful_settings_page');
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
	if (isset($_GET['page']) && $_GET['page'] == 'hopefultheme-settings') { // If we're on the theme's option page, enqueue the scripts
		add_action('admin_enqueue_scripts', 'wp_uploader_ldscripts');
		add_action('admin_print_styles', 'wp_uploader_ldstyles');
	}

/** Display the options page **/

function hopeful_settings_page() { global $hopeful_header_settings;
	// Get all variables
	$old_hopeful_settings = get_option('hopeful-header-settings');
	
	// When the current page is reloaded, we test if the hidden field was submitted with it. 
	// If $array1so, update the options with what was submitted.
	if ( isset( $_POST['hopeful-settings-submit'] ) && ($_POST['hopeful-settings-submit'] == "Y") ) {
		// Print message that records if there's an invalid input.
		echo '<div id="message" class="updated"><p><strong>';

		// Logos
		$hopeful_settings['logo_url'] = _img_url_sanitizer( $_POST['hopeful-logo-url'] );
		$hopeful_settings['favicon_url'] = _img_url_sanitizer( $_POST['hopeful-favicon-url'] );
		// Colors & BG
		$hopeful_settings['color_stylesheet'] = $_POST['hopeful-color-stylesheet'];	// Shouldn't need sanitizing - selector
		$hopeful_settings['bg_color'] = $_POST['bg-color'];
		$hopeful_settings['main_bg_color'] = $_POST['main-bg-color'];
		$hopeful_settings['main_txt_color'] = $_POST['main-txt-color'];
		$hopeful_settings['second_bg_color'] = $_POST['second-bg-color'];
		$hopeful_settings['secondary_txt_color'] = $_POST['secondary-txt-color'];
		$hopeful_settings['random_colors'] = $_POST['random-colors'];
		$hopeful_settings['bg_image'] = $_POST['bg-image'];
		if( isset($_POST['bg-position']) )
			$hopeful_settings['bg_position'] = $_POST['bg-position'];
		else 
			$hopeful_settings['bg_position'] = "bottom center";
		if( isset($_POST['bg-repeat']) )
			$hopeful_settings['bg_repeat'] = $_POST['bg-repeat'];
		else
			$hopeful_settings['bg_repeat'] = "";
		// Advanced Code
		$hopeful_settings['custom_css'] = $_POST['custom-css'];
		$hopeful_settings['custom_js'] = $_POST['custom-js'];
		
		$hopeful_settings = array_merge($old_hopeful_settings,$hopeful_settings);	// To preserve old array values. In case of value conflict, second array overrides.
		update_option('hopeful-header-settings', $hopeful_settings);
		
		// Print pretty message
		echo 'Settings saved.';
		echo '</strong></p></div>';
	}
	else {
		$hopeful_settings = $old_hopeful_settings;
	} 
?>
	<style type="text/css">
		form h3 {
			border-bottom: 1px solid #999;
			margin-top: 2em;
		}
	</style>

	<script type="text/javascript">
		// Special thanks to Matt at Webmaster Source for help with the image uploader script
		// http://www.webmaster-source.com/2010/01/08/using-the-wordpress-uploader-in-your-plugin-or-theme/
		jQuery(document).ready(function() {
			var img_field;
			
			jQuery('#upload_logo_button').click(function() {
				formfield = jQuery('#upload_logo').attr('name');
				tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
				window.img_field = '#upload_logo';
				return false;
			});
			
			jQuery('#upload_favicon_button').click(function() {
				formfield = jQuery('#upload_favicon').attr('name');
				tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
				window.img_field = '#upload_favicon';
				return false;
			});
			
			jQuery('#upload_bg_image_button').click(function() {
				formfield = jQuery('#upload_bg_image').attr('name');
				tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
				window.img_field = '#upload_bg_image';
				return false;
			});
			
			window.send_to_editor = function(html) { // Overwrite default function
				imgurl = jQuery('img',html).attr('src');
				jQuery(window.img_field).val(imgurl);		// References global set by last click function.
				tb_remove();
			}
			
		});
		// Now the question is how to do it if we have a dynamic number of fields.
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
					Leave this blank to just use the Site Title (which can be changed in <a href="<?php admin_url("options-general.php"); ?>" >General Settings</a>). Make sure to click save after your upload.</p>
					<input id="upload_logo" type="text" placeholder="http://" name="hopeful-logo-url" size="50" value="<?php echo $hopeful_logo_url; ?>" />
					<input id="upload_logo_button" class="button" type="button" value="Upload/Change Logo" />
					
				<h4>Favicon (small logo)</h4>
				
					<p>A favicon should be 16x16 px. It will be your website's icon in the browser. This should be a .ico image for best browser compadibility.</p>
					<input id="upload_favicon" type="text" placeholder="http://" name="hopeful-favicon-url" size="50" value="<?php echo $hopeful_favicon_url; ?>" />
					<input id="upload_favicon_button" class="button" type="button" value="Upload/Change Image" />
					<p>Not sure what this is? Need help making a favicon? Contact <a href="http://authormedia.com/contact/">Author Media</a>.</p>
			
				<p>Facebook openGraph image - maybe?</p>
				
				<p class="submit">
                	<input type="submit" class="button-primary" value="Save Settings" />
            	</p>
            	
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
				
				<p>You can add your own color stylesheets to the HopefulTheme/colors/ directory. Make sure to not erase them when you update the theme!</p>
				
				<h4>Custom colors</h4>
				
					<p>Background color: <input type="text" name="bg-color" 
						value="<?php if( isset($hopeful_settings['bg_color']) ) echo $hopeful_settings['bg_color']; else echo '000000'; ?>" /></p>
					<p>Main background color: <input type="text" name="main-bg-color" 
						value="<?php if( isset($hopeful_settings['main_bg_color']) ) echo $hopeful_settings['main_bg_color']; else echo 'ffffff'; ?>" /></p>
					<p>Main text color: <input type="text" name="main-txt-color" 
						value="000000" /></p>
					<p>Secondary background color: <input type="text" name="second-bg-color" 
						value="DDD" /></p>
					<p>Secondary text color: <input type="text" name="secondary-txt-color" 
						value="BBB" /></p>
					<p>Random background colors (seperate by comas): <input type="text" name="random-colors" size="50"
						value="000" /></p>
				
				<h4>Custom background</h4>
				
					<p>Choose an image to be the background. Leave blank to use the color from above.</p>
						<input id="upload_bg_image" type="text" name="bg-image" placeholder="http://" size="50" />
						<input id="upload_bg_image_button" class="button" type="button" value="Upload/Change Background" />
						
					<p>Background settings:<br />
						<input type="checkbox" name="bg-repeat" value="repeat" 
							<?php if($hopeful_settings['bg_repeat'] == "repeat") echo 'checked'; ?> /> Repeat image<br />
						<br />
						<input type="radio" name="bg-position" value="bottom center"
							<?php // Default option
							if( !isset($hopeful_settings['bg-position']) || $hopeful_settings['bg_position'] == 'bottom center' ) echo 'checked'; ?>
						<input type="radio" name="bg-position" value="left top" 
							<?php if($hopeful_settings['bg_position'] == "left top") echo 'checked'; ?> /> Position at top left<br />
						<input type="radio" name="bg-position" value="right top"
							<?php if($hopeful_settings['bg_position'] == "right top") echo 'checked'; ?> /> Position at top right<br />
						<input type="radio" name="bg-position" value="left bottom" 
							<?php if($hopeful_settings['bg_position'] == "left bottom") echo 'checked'; ?> /> Position at bottom left<br />
						<input type="radio" name="bg-position" value="right bottom" 
							<?php if($hopeful_settings['bg_position'] == "right bottom") echo 'checked'; ?> /> Position at bottom right
					</p>
				
			<h3>Layout</h3>
				
				<p>/// Some options for which widget areas to display ///</p>
				<p><a href="<?php echo admin_url("options-reading.php");_?>">Change homepage between static and blog</a>.</p>
				
			<h3>Advanced: Custom Code</h3>
				
				<h4>Custom CSS</h4>
				<p>If you are not satisfied by what you can change with the settings above, you can use CSS. If you find you need more than a few lines, I recommend adding a stylesheet to colors/ or making a <a href="http://codex.wordpress.org/Child_Themes">child theme</a>.</p>
				<textarea rows="10" cols="100" name="custom-css"><?php echo $hopeful_settings['custom_css']; ?></textarea>
				
				<h4>Custom Javascript</h4>
				<p>Here's where custom Js code (like <a href="http://www.google.com/analytics/">Google Analytics</a>) can be inserted into the header.</p>
				<textarea rows="10" cols="100" name="custom-js"><?php echo $hopeful_settings['custom_js']; ?></textarea>
				
			<p class="submit">
                <input type="submit" class="button-primary" value="Save Settings" />
            </p>
            
		</form>
		
	</div>
<?php }

/** Functions for sanitizing the input from the settings page **/

if ( !function_exists('_img_url_sanitizer') ) {
function _img_url_sanitizer( $logo_url ) {
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
}

if ( !function_exists('_sanitize_color') ) {
function _sanitize_color($input) {
	$output=$input;
	return $output;
} 
}
?>
