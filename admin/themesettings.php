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
add_action('admin_init', 'hopeful_options');

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
	<div class="wrap">
		<!-- title and info -->
		<h2>hopefulTheme :: Settings</h2>
		<p>Welcome! Here you can customize the look of the Gib Theme. To customize further, <a href="/wp-admin/nav-menus.php">add widgets</a>, <a href="/wp-admin/widgets.php">customize menus</a>, or <a href="/wp-admin/edit.php?post_type=wpss_slides&page=wpss-options">tweak the slider</a>.</p>

		<form method="post" action=""> <?php // This page is the option processor ?>
			<input type="hidden" name="hopeful-settings-submit" value="Y" />
			
			<h3>Colors</h3>
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
						$count++;
					endforeach; 
					if ($count == 0) echo '<option value="">(none available)</option>'; ?>
				</select>
			
			<h3>Logos</h3>
			<p>If you would like to use your own images, <a href="/wp-admin/media-new.php">upload them</a> and then copy and paste the link into the right box:</p>
				<?php $hopeful_logo_url = $hopeful_settings['logo_url'];
				$hopeful_favicon_url = $hopeful_settings['favicon_url']; ?>
				
				<h4>Site Header Logo</h4>
					
					<p>This logo goes in the top left corner and replaces your site title. Optimum size: 200x75 px. Other sizes will create inconsistent results. <br />
					Leave this blank to just use the Site Title (which can be changed in <a href="/wp-admin/options-general.php">General Settings</a>).</p>
					<input type="text" placeholder="http://" name="hopeful-logo-url" size="50" value="<?php echo $hopeful_logo_url; ?>" />
					
				<h4>Favicon (small logo)</h4>
				
					<p>A favicon should be 16x16 px. It will be your website's icon in the browser. This should be a .ico image for best browser compadibility.</p>
					<input type="text" placeholder="http://" name="hopeful-favicon-url" size="50" value="<?php echo $hopeful_favicon_url; ?>" />
					<p>What's this? Need help making a favicon? Contact <a href="http://authormedia.com/contact/">Author Media</a>.</p>
			
			<h3>Layout</h3>
			
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
