<?php
/*
Plugin Name: MMWD Google Analytics
Plugin URI: https://mcgregormedia.co.uk
Description: Adds Google Analytics code to your WordPress site.
Version: 1.0.0
Author: McGregor Media Web Design
Author URI: https://mcgregormedia.co.uk
License: GPL2
Text-domain: mmwd-ga
 
MMWD Site Icons is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 2 of the License, or any later version.
 
MMWD Site Icons is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License along with MMWD Site Icons. If not, see http://www.gnu.org/licenses/gpl.html.
*/



/**
 * Came here directly? Vamoose.
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;




/**
 * Adds the admin options page
 * 
 * @return array	The page data
 *
 * @since 1.0.0
 */

function mmwd_ga_options_add_page() {
	
	add_options_page( 'MMWD Google Analytics Settings', 'Google Analytics', 'manage_options', 'mmwd-ga-options', 'mmwd_ga_options_page' );
	
}
add_action( 'admin_menu', 'mmwd_ga_options_add_page' );






/**
 * Displays the admin options page
 * 
 * @return string 	The page HTML
 *
 * @since 1.0.0
 */

function mmwd_ga_options_page() { ?>

	<div>
		<h2>MMWD Google Analytics Settings</h2>
		<form action="options.php" method="post">
		<?php settings_fields('mmwd_ga_options'); ?>
		<?php do_settings_sections('mmwd_ga'); ?>
		 
		<input name="Submit" class="button-primary" type="submit" value="<?php esc_attr_e( 'Save Changes', 'mmwd-ga' ); ?>">
		</form>
	</div>
 
<?php }






/**
 * Adds the admin settings
 *
 * @since 1.0.0
 */

function mmwd_ga_admin_init(){
	
	register_setting( 'mmwd_ga_options', 'mmwd_ga_options', 'mmwd_ga_options_validate' );
	add_settings_section( 'mmwd_ga_main', 'Google Analytics', 'mmwd_ga_section_text', 'mmwd_ga' );	
	add_settings_field( 'mmwd_ga_id_string', 'Google Analytics', 'mmwd_ga_setting_string', 'mmwd_ga', 'mmwd_ga_main' );
	
}
add_action( 'admin_init', 'mmwd_ga_admin_init' );





/**
 * Adds the section text
 * 
 * @return string	The section text
 *
 * @since 1.0.0
 */

function mmwd_ga_section_text() {
	
	echo '<p>Enter your Google Analytics Tracking ID (UA-XXXXXXXX-X).</p>';
	
}





/**
 * Adds form fields
 * 
 * @return string	The form field HTML
 *
 * @since 1.0.0
 */

function mmwd_ga_setting_string() {
	
	$options = get_option( 'mmwd_ga_options' );
	echo '<input type="text" id="mmwd_ga_id" name="mmwd_ga_options[mmwd_ga_id]" value="' . esc_attr( $options['mmwd_ga_id'] ) . '">';
	
}






/**
 * Sanitizes options
 * 
 * @param array $input		The array of items to be saved
 * 
 * @return array $newinput	The edited items to be saved
 *
 * @since 1.0.0
 */

function mmwd_ga_options_validate( $input ) {
	
	$newinput['mmwd_ga_id'] = sanitize_text_field( $input['mmwd_ga_id'] );
	
	return $newinput;
	
}





/**
 * Adds the code in the footer on the frontend
 * 
 * @return string	The Google Analytics UA code
 *
 * @since 1.0.0
 */

function mmwd_add_ga_code(){
	
	$options = get_option( 'mmwd_ga_options' );
	$mmwd_ga_id = esc_html( $options['mmwd_ga_id'] );
	?>
	<script>
	
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		ga('create', '<?php echo $mmwd_ga_id; ?>', 'auto');
		ga('send', 'pageview');

	</script>
	<?php

}
add_action( 'wp_footer', 'mmwd_add_ga_code');