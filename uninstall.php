<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * Removes all plugin options from the database.
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'wab_telephone' );
delete_option( 'wab_message' );
delete_option( 'wab_primary_color' );
delete_option( 'wab_outline_color' );
delete_option( 'wab_ring_color' );
delete_option( 'wab_position_vertical' );
delete_option( 'wab_position_horizontal' );
delete_option( 'wab_offset_vertical' );
delete_option( 'wab_offset_horizontal' );
delete_option( 'wab_icon_size' );
delete_option( 'wab_show_desktop' );
delete_option( 'wab_show_tablet' );
delete_option( 'wab_show_mobile' );
delete_option( 'wab_shadow_color' );
