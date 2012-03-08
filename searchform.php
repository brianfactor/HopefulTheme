<?php
/**
 * The template for displaying search forms as borrowed from Twenty Eleven
 *
 * @package HopeTheme
 */
?>
	<form method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label for="s" class="assistive-text"><?php _e('Search'); ?></label>
		<input type="text" class="field, s" name="s" placeholder="<?php esc_attr_e('Search'); ?>" value="<?php esc_attr_e( get_search_query(false) ); ?>" />
		<input type="submit" class="submit searchsubmit" name="submit" value="<?php esc_attr_e('Search'); ?>" />
	</form>
