<?php
/*
 * Plugin Name:       Customizable Simple Click2Chat Button
 * Description:       Add a WhatsApp animated button that matches your brand. Customizable colors, position, visibility and pre-filled message
 * Version:           1.2
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Viola Niccolai
 * Author URI:        https://www.unsitofattobene.it
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       customizable-simple-click2chat-button
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue scripts and styles
 */
function wab_plugin_style_scripts() {
	wp_enqueue_style( 'wab-style', plugins_url( 'style.css', __FILE__ ), array(), '1.2' );
	wp_add_inline_style( 'wab-style', wab_generate_custom_css() );
}
add_action( 'wp_enqueue_scripts', 'wab_plugin_style_scripts' );

/**
 * Generate custom CSS based on settings
 */
function wab_generate_custom_css() {
	$primary_color = get_option('wab_primary_color', '#46c254');
	$outline_color = get_option('wab_outline_color', '#ffffff');
	$ring_color = get_option('wab_ring_color', '#ffffff');
	$position_vertical = get_option('wab_position_vertical', 'bottom');
	$position_horizontal = get_option('wab_position_horizontal', 'right');
	$offset_vertical = get_option('wab_offset_vertical', '20');
	$offset_horizontal = get_option('wab_offset_horizontal', '15');
	$icon_size = get_option('wab_icon_size', '45');
	$shadow_color = get_option('wab_shadow_color', '');

	// Visibility settings
	$show_desktop = get_option('wab_show_desktop', '1');
	$show_tablet = get_option('wab_show_tablet', '1');
	$show_mobile = get_option('wab_show_mobile', '1');

	$css = "
	.wab-button {
		{$position_vertical}: {$offset_vertical}px !important;
		{$position_horizontal}: {$offset_horizontal}px !important;
		width: {$icon_size}px !important;
		height: {$icon_size}px !important;
	}

	.wab-button .wab-svg {
		width: 100%;
		height: 100%;
		display: block;
	}

	.wab-button .wab-fill-primary {
		fill: {$primary_color};
	}

	.wab-button .wab-fill-outline {
		fill: {$outline_color};
	}

	.wab-button .wab-fill-ring {
		fill: {$ring_color};
	}
	";

	if (!empty($shadow_color)) {
		$css .= "
		.wab-button {
			filter: drop-shadow(2px 2px 4px {$shadow_color}) !important;
		}
		";
	}
	
	// Add responsive visibility
	if (!$show_desktop) {
		$css .= "
		@media (min-width: 1025px) {
			.wab-button {
				display: none !important;
			}
		}
		";
	}
	
	if (!$show_tablet) {
		$css .= "
		@media (min-width: 768px) and (max-width: 1024px) {
			.wab-button {
				display: none !important;
			}
		}
		";
	}
	
	if (!$show_mobile) {
		$css .= "
		@media (max-width: 767px) {
			.wab-button {
				display: none !important;
			}
		}
		";
	}
	
	return $css;
}

/**
 * Add WhatsApp button in footer
 */
function wab_footer_whatsapp() {
	$telephone = get_option('wab_telephone');

	if (empty($telephone)) {
		return;
	}

	$message = get_option('wab_message', '');
	$wa_url = 'https://wa.me/' . esc_attr($telephone);
	if (!empty($message)) {
		$wa_url .= '?text=' . rawurlencode($message);
	}
	
	$svg = '<svg class="wab-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 324 324">
		<path class="wab-fill-primary" d="M 162.18 0 C 73.43 0 1.59 70.79 0.35 159.53 C 0 184.38 5.26 207.97 14.94 229.11 C 20.62 241.53 21.48 255.62 17.41 268.66 L 2.53 316.3 L 56.88 304.1 C 69.03 301.37 81.72 302.85 92.98 308.18 C 114.56 318.41 138.76 324.01 164.31 323.68 C 253.13 322.54 324.02 250.67 324.02 161.85 C 324.02 72.46 251.56 0 162.18 0 Z"/>
		<path class="wab-fill-ring" fill-rule="evenodd" d="M 25,162 C 25,86.4 86.4,25 162,25 C 237.6,25 299,86.4 299,162 C 299,237.6 237.6,299 162,299 C 86.4,299 25,237.6 25,162 Z M 38,162 C 38,93.6 93.6,38 162,38 C 230.4,38 286,93.6 286,162 C 286,230.4 230.4,286 162,286 C 93.6,286 38,230.4 38,162 Z"/>
		<path class="wab-fill-outline" transform="translate(162,162) scale(0.85) translate(-162,-162)" d="M 235.81 240.79 C 240 234.07 242.85 226.9 244.24 219.25 C 244.67 216.89 243.91 214.47 242.22 212.78 L 223.11 193.68 C 219.82 190.38 215.21 188.76 210.58 189.26 C 207.09 189.63 203.84 191.2 201.36 193.68 L 195.49 199.54 C 192.89 202.15 189.02 202.99 185.55 201.75 C 170.14 196.25 148.84 175.16 148.84 175.16 C 148.84 175.16 127.75 153.86 122.25 138.45 C 121.01 134.98 121.86 131.11 124.46 128.51 L 130.32 122.64 C 132.8 120.16 134.36 116.91 134.74 113.42 C 135.24 108.79 133.62 104.18 130.32 100.89 L 111.22 81.78 C 109.53 80.09 107.11 79.33 104.75 79.76 C 97.1 81.15 89.93 84 83.21 88.19 C 80.73 89.74 79.08 92.32 78.65 95.21 C 76.57 109.04 74.98 152.39 123.3 200.7 C 171.61 249.01 214.96 247.43 228.79 245.35 C 231.68 244.91 234.26 243.27 235.81 240.79 Z"/>
	</svg>';

	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG is hardcoded, not user input
	echo '<a href="' . esc_url($wa_url) . '" class="wab-button hi-there" aria-label="WhatsApp" target="_blank" rel="noopener noreferrer">' . $svg . '</a>';
}
add_action('wp_footer', 'wab_footer_whatsapp');

/**
 * Register settings
 */
function wab_register_mysettings() {
	register_setting( 'wab-settings-group', 'wab_telephone', array(
		'sanitize_callback' => function( $val ) {
			return preg_replace( '/[^0-9]/', '', $val );
		}
	));
	register_setting( 'wab-settings-group', 'wab_message', array(
		'sanitize_callback' => 'sanitize_textarea_field'
	));
	register_setting( 'wab-settings-group', 'wab_primary_color', array(
		'sanitize_callback' => 'sanitize_hex_color'
	));
	register_setting( 'wab-settings-group', 'wab_outline_color', array(
		'sanitize_callback' => 'sanitize_hex_color'
	));
	register_setting( 'wab-settings-group', 'wab_ring_color', array(
		'sanitize_callback' => 'sanitize_hex_color'
	));
	register_setting( 'wab-settings-group', 'wab_shadow_color', array(
		'sanitize_callback' => function( $val ) {
			return empty( $val ) ? '' : sanitize_hex_color( $val );
		}
	));
	register_setting( 'wab-settings-group', 'wab_position_vertical', array(
		'sanitize_callback' => function( $val ) {
			return in_array( $val, array( 'top', 'bottom' ), true ) ? $val : 'bottom';
		}
	));
	register_setting( 'wab-settings-group', 'wab_position_horizontal', array(
		'sanitize_callback' => function( $val ) {
			return in_array( $val, array( 'left', 'right' ), true ) ? $val : 'right';
		}
	));
	register_setting( 'wab-settings-group', 'wab_offset_vertical', array(
		'sanitize_callback' => 'absint'
	));
	register_setting( 'wab-settings-group', 'wab_offset_horizontal', array(
		'sanitize_callback' => 'absint'
	));
	register_setting( 'wab-settings-group', 'wab_icon_size', array(
		'sanitize_callback' => function( $val ) {
			$val = absint( $val );
			return max( 30, min( 150, $val ) );
		}
	));
	register_setting( 'wab-settings-group', 'wab_show_desktop', array(
		'sanitize_callback' => 'absint'
	));
	register_setting( 'wab-settings-group', 'wab_show_tablet', array(
		'sanitize_callback' => 'absint'
	));
	register_setting( 'wab-settings-group', 'wab_show_mobile', array(
		'sanitize_callback' => 'absint'
	));
}
add_action( 'admin_init', 'wab_register_mysettings' );

/**
 * Purge page cache on settings save so inline CSS is refreshed
 */
function wab_purge_cache( $option ) {
	if ( strpos( $option, 'wab_' ) !== 0 ) {
		return;
	}

	// WP Rocket
	if ( function_exists( 'rocket_clean_domain' ) ) {
		rocket_clean_domain();
	}

	// LiteSpeed Cache
	if ( has_action( 'litespeed_purge_all' ) ) {
		do_action( 'litespeed_purge_all' );
	}

	// WP Super Cache
	if ( function_exists( 'wp_cache_clear_cache' ) ) {
		wp_cache_clear_cache();
	}

	// W3 Total Cache
	if ( function_exists( 'w3tc_flush_all' ) ) {
		w3tc_flush_all();
	}

	// WP Fastest Cache
	if ( function_exists( 'wpfc_clear_all_cache' ) ) {
		wpfc_clear_all_cache();
	}

	// Autoptimize
	if ( class_exists( 'autoptimizeCache' ) ) {
		autoptimizeCache::clearall();
	}

	// SG Optimizer
	if ( function_exists( 'sg_cachepress_purge_cache' ) ) {
		sg_cachepress_purge_cache();
	}

	// Generic hook used by some cache plugins
	if ( has_action( 'cachify_flush_cache' ) ) {
		do_action( 'cachify_flush_cache' );
	}
}
add_action( 'updated_option', 'wab_purge_cache' );
add_action( 'added_option', 'wab_purge_cache' );

/**
 * Create plugin options page
 */
function wab_create_menu() {
	add_menu_page(
		__( 'WhatsApp Settings', 'customizable-simple-click2chat-button' ),
		'WhatsApp',
		'manage_options',
		'wab-settings',
		'wab_settings_page',
		'dashicons-whatsapp'
	);
}
add_action('admin_menu', 'wab_create_menu');

/**
 * Add "Customize" link in the plugins list
 */
function wab_action_links( $links ) {
	$settings_link = '<a href="' . esc_url( admin_url( 'admin.php?page=wab-settings' ) ) . '">' . esc_html__( 'Customize', 'customizable-simple-click2chat-button' ) . '</a>';
	$links[] = $settings_link;
	return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wab_action_links' );

function wab_settings_page() {
	// Set default values
	$telephone = get_option('wab_telephone', '');
	$message = get_option('wab_message', '');
	$primary_color = get_option('wab_primary_color', '#46c254');
	$outline_color = get_option('wab_outline_color', '#ffffff');
	$ring_color = get_option('wab_ring_color', '#ffffff');
	$position_vertical = get_option('wab_position_vertical', 'bottom');
	$position_horizontal = get_option('wab_position_horizontal', 'right');
	$offset_vertical = get_option('wab_offset_vertical', '20');
	$offset_horizontal = get_option('wab_offset_horizontal', '15');
	$icon_size = get_option('wab_icon_size', '45');
	$shadow_color = get_option('wab_shadow_color', '');
	$show_desktop = get_option('wab_show_desktop', '1');
	$show_tablet = get_option('wab_show_tablet', '1');
	$show_mobile = get_option('wab_show_mobile', '1');
?>
<div class="wrap">
	<h1><?php esc_html_e( 'WhatsApp Button Settings', 'customizable-simple-click2chat-button' ); ?></h1>

	<div style="display: flex; gap: 30px; align-items: flex-start;">
		<div style="flex: 1; min-width: 0;">
			<form method="post" action="options.php">
				<?php settings_fields( 'wab-settings-group' ); ?>
				<?php do_settings_sections( 'wab-settings-group' ); ?>

				<h2><?php esc_html_e( 'Basic Configuration', 'customizable-simple-click2chat-button' ); ?></h2>
				<p class="description" style="font-style: italic; margin-bottom: 15px;">
					<?php esc_html_e( 'The button will not be displayed on the site until a phone number is entered.', 'customizable-simple-click2chat-button' ); ?>
				</p>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Phone number', 'customizable-simple-click2chat-button' ); ?></th>
						<td>
							<input type="text" name="wab_telephone" value="<?php echo esc_attr($telephone); ?>" class="regular-text" placeholder="39333123456" />
							<p class="description"><?php esc_html_e( 'Enter the full number with international prefix (e.g. 39333123456)', 'customizable-simple-click2chat-button' ); ?></p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Pre-filled message', 'customizable-simple-click2chat-button' ); ?></th>
						<td>
							<textarea name="wab_message" class="large-text" rows="3" placeholder="<?php esc_attr_e( 'Hi, I would like more information...', 'customizable-simple-click2chat-button' ); ?>"><?php echo esc_textarea($message); ?></textarea>
							<p class="description"><?php esc_html_e( 'This message will be pre-filled in the customer\'s WhatsApp chat (leave empty for no message)', 'customizable-simple-click2chat-button' ); ?></p>
						</td>
					</tr>
				</table>

				<h2><?php esc_html_e( 'Icon Colors', 'customizable-simple-click2chat-button' ); ?></h2>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Bubble color', 'customizable-simple-click2chat-button' ); ?></th>
						<td>
							<input type="color" id="wab_primary_color_picker" value="<?php echo esc_attr($primary_color); ?>" />
							<input type="text" name="wab_primary_color" id="wab_primary_color_text" value="<?php echo esc_attr($primary_color); ?>" class="regular-text" pattern="^#[0-9A-Fa-f]{6}$" style="margin-left: 10px;" />
							<p class="description"><?php esc_html_e( 'Background bubble color (default: #46c254)', 'customizable-simple-click2chat-button' ); ?></p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Handset color', 'customizable-simple-click2chat-button' ); ?></th>
						<td>
							<input type="color" id="wab_outline_color_picker" value="<?php echo esc_attr($outline_color); ?>" />
							<input type="text" name="wab_outline_color" id="wab_outline_color_text" value="<?php echo esc_attr($outline_color); ?>" class="regular-text" pattern="^#[0-9A-Fa-f]{6}$" style="margin-left: 10px;" />
							<p class="description"><?php esc_html_e( 'Phone handset color (default: #ffffff)', 'customizable-simple-click2chat-button' ); ?></p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Ring color', 'customizable-simple-click2chat-button' ); ?></th>
						<td>
							<input type="color" id="wab_ring_color_picker" value="<?php echo esc_attr($ring_color); ?>" />
							<input type="text" name="wab_ring_color" id="wab_ring_color_text" value="<?php echo esc_attr($ring_color); ?>" class="regular-text" pattern="^#[0-9A-Fa-f]{6}$" style="margin-left: 10px;" />
							<p class="description"><?php esc_html_e( 'Circular ring color (default: #ffffff)', 'customizable-simple-click2chat-button' ); ?></p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Shadow color', 'customizable-simple-click2chat-button' ); ?></th>
						<td>
							<input type="color" id="wab_shadow_color_picker" value="<?php echo esc_attr($shadow_color ?: '#787878'); ?>" />
							<input type="text" name="wab_shadow_color" id="wab_shadow_color_text" value="<?php echo esc_attr($shadow_color); ?>" class="regular-text" pattern="^#[0-9A-Fa-f]{6}$" style="margin-left: 10px;" />
							<label style="margin-left: 10px;">
								<input type="checkbox" id="wab_shadow_enabled" <?php checked(!empty($shadow_color)); ?> />
								<?php esc_html_e( 'Enable shadow', 'customizable-simple-click2chat-button' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Optional drop shadow behind the bubble (leave empty to disable)', 'customizable-simple-click2chat-button' ); ?></p>
						</td>
					</tr>
				</table>

				<h2><?php esc_html_e( 'Position & Size', 'customizable-simple-click2chat-button' ); ?></h2>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Vertical position', 'customizable-simple-click2chat-button' ); ?></th>
						<td>
							<select name="wab_position_vertical">
								<option value="bottom" <?php selected($position_vertical, 'bottom'); ?>><?php esc_html_e( 'Bottom', 'customizable-simple-click2chat-button' ); ?></option>
								<option value="top" <?php selected($position_vertical, 'top'); ?>><?php esc_html_e( 'Top', 'customizable-simple-click2chat-button' ); ?></option>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Vertical offset (px)', 'customizable-simple-click2chat-button' ); ?></th>
						<td>
							<input type="number" name="wab_offset_vertical" value="<?php echo esc_attr($offset_vertical); ?>" min="0" max="500" />
							<p class="description"><?php esc_html_e( 'Distance from the top or bottom edge in pixels', 'customizable-simple-click2chat-button' ); ?></p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Horizontal position', 'customizable-simple-click2chat-button' ); ?></th>
						<td>
							<select name="wab_position_horizontal">
								<option value="right" <?php selected($position_horizontal, 'right'); ?>><?php esc_html_e( 'Right', 'customizable-simple-click2chat-button' ); ?></option>
								<option value="left" <?php selected($position_horizontal, 'left'); ?>><?php esc_html_e( 'Left', 'customizable-simple-click2chat-button' ); ?></option>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Horizontal offset (px)', 'customizable-simple-click2chat-button' ); ?></th>
						<td>
							<input type="number" name="wab_offset_horizontal" value="<?php echo esc_attr($offset_horizontal); ?>" min="0" max="500" />
							<p class="description"><?php esc_html_e( 'Distance from the left or right edge in pixels', 'customizable-simple-click2chat-button' ); ?></p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Icon size (px)', 'customizable-simple-click2chat-button' ); ?></th>
						<td>
							<input type="number" name="wab_icon_size" id="wab_icon_size" value="<?php echo esc_attr($icon_size); ?>" min="30" max="150" />
							<p class="description"><?php esc_html_e( 'Icon size in pixels (recommended: 45px)', 'customizable-simple-click2chat-button' ); ?></p>
						</td>
					</tr>
				</table>

				<h2><?php esc_html_e( 'Device Visibility', 'customizable-simple-click2chat-button' ); ?></h2>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Show on', 'customizable-simple-click2chat-button' ); ?></th>
						<td>
							<label>
								<input type="checkbox" name="wab_show_desktop" value="1" <?php checked($show_desktop, '1'); ?> />
								<?php esc_html_e( 'Desktop (above 1024px)', 'customizable-simple-click2chat-button' ); ?>
							</label><br>
							<label>
								<input type="checkbox" name="wab_show_tablet" value="1" <?php checked($show_tablet, '1'); ?> />
								<?php esc_html_e( 'Tablet (768px - 1024px)', 'customizable-simple-click2chat-button' ); ?>
							</label><br>
							<label>
								<input type="checkbox" name="wab_show_mobile" value="1" <?php checked($show_mobile, '1'); ?> />
								<?php esc_html_e( 'Mobile (up to 767px)', 'customizable-simple-click2chat-button' ); ?>
							</label>
							<p class="description"><?php esc_html_e( 'Select on which devices to show the WhatsApp button', 'customizable-simple-click2chat-button' ); ?></p>
						</td>
					</tr>
				</table>

				<p class="submit">
					<input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes', 'customizable-simple-click2chat-button' ); ?>" />
				</p>
				<p class="description" style="color: #826200;">
					&#9888; <?php esc_html_e( 'If changes are not visible on the site after saving, please clear your browser and/or caching plugin cache.', 'customizable-simple-click2chat-button' ); ?>
				</p>
			</form>
		</div>

		<div style="width: 250px; flex-shrink: 0; position: sticky; top: 50px;">
			<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 5px;">
				<h3 style="margin: 0;"><?php esc_html_e( 'Preview', 'customizable-simple-click2chat-button' ); ?></h3>
				<label style="font-size: 12px; cursor: pointer;">
					<input type="checkbox" id="wab_preview_dark" /> <?php esc_html_e( 'Dark background', 'customizable-simple-click2chat-button' ); ?>
				</label>
			</div>
			<div id="wab-preview-box" style="position: relative; height: 250px; border: 2px dashed #ccc; background: #f5f5f5; border-radius: 8px; overflow: hidden; transition: background 0.3s;">
				<svg id="wab-preview-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 324 324" style="position: absolute; <?php echo esc_attr($position_vertical); ?>: <?php echo esc_attr($offset_vertical); ?>px; <?php echo esc_attr($position_horizontal); ?>: <?php echo esc_attr($offset_horizontal); ?>px; width: <?php echo esc_attr($icon_size); ?>px; height: <?php echo esc_attr($icon_size); ?>px; display: block;">
					<path id="wab-preview-bubble" fill="<?php echo esc_attr($primary_color); ?>" d="M 162.18 0 C 73.43 0 1.59 70.79 0.35 159.53 C 0 184.38 5.26 207.97 14.94 229.11 C 20.62 241.53 21.48 255.62 17.41 268.66 L 2.53 316.3 L 56.88 304.1 C 69.03 301.37 81.72 302.85 92.98 308.18 C 114.56 318.41 138.76 324.01 164.31 323.68 C 253.13 322.54 324.02 250.67 324.02 161.85 C 324.02 72.46 251.56 0 162.18 0 Z"/>
					<path id="wab-preview-ring" fill="<?php echo esc_attr($ring_color); ?>" fill-rule="evenodd" d="M 25,162 C 25,86.4 86.4,25 162,25 C 237.6,25 299,86.4 299,162 C 299,237.6 237.6,299 162,299 C 86.4,299 25,237.6 25,162 Z M 38,162 C 38,93.6 93.6,38 162,38 C 230.4,38 286,93.6 286,162 C 286,230.4 230.4,286 162,286 C 93.6,286 38,230.4 38,162 Z"/>
					<path id="wab-preview-phone" fill="<?php echo esc_attr($outline_color); ?>" transform="translate(162,162) scale(0.85) translate(-162,-162)" d="M 235.81 240.79 C 240 234.07 242.85 226.9 244.24 219.25 C 244.67 216.89 243.91 214.47 242.22 212.78 L 223.11 193.68 C 219.82 190.38 215.21 188.76 210.58 189.26 C 207.09 189.63 203.84 191.2 201.36 193.68 L 195.49 199.54 C 192.89 202.15 189.02 202.99 185.55 201.75 C 170.14 196.25 148.84 175.16 148.84 175.16 C 148.84 175.16 127.75 153.86 122.25 138.45 C 121.01 134.98 121.86 131.11 124.46 128.51 L 130.32 122.64 C 132.8 120.16 134.36 116.91 134.74 113.42 C 135.24 108.79 133.62 104.18 130.32 100.89 L 111.22 81.78 C 109.53 80.09 107.11 79.33 104.75 79.76 C 97.1 81.15 89.93 84 83.21 88.19 C 80.73 89.74 79.08 92.32 78.65 95.21 C 76.57 109.04 74.98 152.39 123.3 200.7 C 171.61 249.01 214.96 247.43 228.79 245.35 C 231.68 244.91 234.26 243.27 235.81 240.79 Z"/>
				</svg>
			</div>
		</div>
	</div>
</div>

<script>
(function() {
	var primaryPicker = document.getElementById('wab_primary_color_picker');
	var primaryText = document.getElementById('wab_primary_color_text');
	var outlinePicker = document.getElementById('wab_outline_color_picker');
	var outlineText = document.getElementById('wab_outline_color_text');
	var ringPicker = document.getElementById('wab_ring_color_picker');
	var ringText = document.getElementById('wab_ring_color_text');
	var iconSize = document.getElementById('wab_icon_size');
	var posV = document.querySelector('select[name="wab_position_vertical"]');
	var posH = document.querySelector('select[name="wab_position_horizontal"]');
	var offV = document.querySelector('input[name="wab_offset_vertical"]');
	var offH = document.querySelector('input[name="wab_offset_horizontal"]');
	var shadowPicker = document.getElementById('wab_shadow_color_picker');
	var shadowText = document.getElementById('wab_shadow_color_text');
	var shadowEnabled = document.getElementById('wab_shadow_enabled');
	var previewSvg = document.getElementById('wab-preview-svg');
	var previewBubble = document.getElementById('wab-preview-bubble');
	var previewRing = document.getElementById('wab-preview-ring');
	var previewPhone = document.getElementById('wab-preview-phone');

	function updatePreview() {
		previewBubble.setAttribute('fill', primaryText.value);
		previewRing.setAttribute('fill', ringText.value);
		previewPhone.setAttribute('fill', outlineText.value);
		var size = iconSize.value + 'px';
		previewSvg.style.width = size;
		previewSvg.style.height = size;

		previewSvg.style.top = '';
		previewSvg.style.bottom = '';
		previewSvg.style.left = '';
		previewSvg.style.right = '';
		previewSvg.style[posV.value] = Math.min(parseInt(offV.value) || 0, 80) + 'px';
		previewSvg.style[posH.value] = Math.min(parseInt(offH.value) || 0, 80) + 'px';

		if (shadowEnabled.checked && shadowText.value) {
			previewSvg.style.filter = 'drop-shadow(2px 2px 4px ' + shadowText.value + ')';
		} else {
			previewSvg.style.filter = 'none';
		}
	}

	function syncColor(picker, text) {
		picker.addEventListener('input', function() {
			text.value = this.value;
			updatePreview();
		});
		text.addEventListener('input', function() {
			if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
				picker.value = this.value;
				updatePreview();
			}
		});
	}

	syncColor(primaryPicker, primaryText);
	syncColor(outlinePicker, outlineText);
	syncColor(ringPicker, ringText);

	shadowPicker.addEventListener('input', function() {
		shadowText.value = this.value;
		if (!shadowEnabled.checked) shadowEnabled.checked = true;
		updatePreview();
	});
	shadowText.addEventListener('input', function() {
		if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
			shadowPicker.value = this.value;
			updatePreview();
		}
	});
	shadowEnabled.addEventListener('change', function() {
		if (!this.checked) shadowText.value = '';
		else if (!shadowText.value) shadowText.value = shadowPicker.value;
		updatePreview();
	});

	iconSize.addEventListener('input', updatePreview);
	posV.addEventListener('change', updatePreview);
	posH.addEventListener('change', updatePreview);
	offV.addEventListener('input', updatePreview);
	offH.addEventListener('input', updatePreview);

	var previewDark = document.getElementById('wab_preview_dark');
	var previewBox = document.getElementById('wab-preview-box');
	previewDark.addEventListener('change', function() {
		previewBox.style.background = this.checked ? '#333333' : '#f5f5f5';
		previewBox.style.borderColor = this.checked ? '#555555' : '#ccc';
	});

	// Sync preview on page load
	updatePreview();
})();
</script>
<?php 
}