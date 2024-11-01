<?php
/*
Plugin Name: WP-Blast
Plugin URI: http://hkvn.info/blog/2008/12/02/wp-blast-plugin-for-wordpress-offical-plugin-page/
Description: A simple plugin to display your blast in your wordpress site as Yahoo! 360.
Author: HKVN
Version: 1.0
Author URI: http://www.hkvn.info
*/

//Display your blast in your index page.
function blastDisplay(){
	$options = get_option('your_blast');
	echo $options['your_blast'];
}

//Create Menu in wp-admin


function blastSubPage()
{
	global $wpdb;
	if (isset($_POST['update_options'])) {
		$options['your_blast'] = trim($_POST['your_blast'],'{}');
		update_option('your_blast', $options);
		// Show a message to say we've done something
		echo '<div class="updated fade"><p>' . __('Options saved') . '</p></div>';
	} else {
		// If we are just displaying the page we first load up the options array
		$options = get_option('your_blast');
	}
?>
	<div class="wrap">
	<h2><?php echo __('WP-Blast Options'); ?></h2>
	<form method="post" action="">
	<fieldset class="options">
<table class="optiontable form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Your Blast is:') ?></th>
				<td><textarea name="your_blast" id="your_blast" rows="4" cols="38"><?php echo $options['your_blast']; ?></textarea></td>
		</table>
	</fieldset>
	<div class="submit">
		<input type="submit" name="update_options" value="<?php _e('Update') ?>" />
	</div>
	<?php if (function_exists('wp_nonce_field')) wp_nonce_field('wp-blast-update-options'); ?>
	</form>    	
	</div>

<?php
}

function blastSubMenu(){
	if (function_exists('current_user_can')) {
		if (!current_user_can('manage_options')) return;
	} else {
		global $user_level;
		get_currentuserinfo();
		if ($user_level < 8) return;
	}
	if (function_exists('add_options_page')) {
		add_options_page(__('Your Blast'), __('Your Blast'), 1, __FILE__, 'blastSubPage');
	}
}

// Install Option menu
add_action('admin_menu', 'blastSubMenu');

function wp_blast_install() {
	// check each of the option values and, if empty, assign a default (doing it this long way
	// lets us add new options in later versions)
	$options = get_option('your_blast');
	if (!isset($options['your_blast'])) $options['your_blast'] = 'This is a simple blast!';
	update_option('your_blast', $options);
}

add_action('activate_'.str_replace('-admin', '', plugin_basename(__FILE__)), 'wp_blast_install');
?>
