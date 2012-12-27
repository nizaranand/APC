<?php
/**
 * boot.php
 *
 * Copyright (c) 2012 "kento" Karim Rahimpur www.itthinx.com
 *
 * This code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt.
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This header and all notices must be kept intact.
 *
 * @author Karim Rahimpur
 * @package wunderslider-gallery
 * @since wunderslider-gallery 1.0.0
 */

$options = get_option( WSG_OPTIONS, null );

//
// conditionally boot up parts
//
if ( !is_admin() ) {
	require_once( WSG_CORE_LIB . '/class-wunderslider-gallery.php' );
	require_once( WSG_CORE_LIB . '/class-wunderslider-nggallery.php' );
}
if ( is_admin() ) {
	require_once( WSG_ADMIN_LIB . '/class-wsg-admin-options.php' );
}

/**
 * Activation handler.
 * Registers plugin options.
 */
function wsg_activate() {
	$options = get_option( WSG_OPTIONS, null );
	if ( $options === null ) {
		add_option( WSG_OPTIONS, array(), null, 'no' );
	}
}

/**
 * Deactivation handler.
 */
function wsg_deactivate() {
}

/**
 * Uninstall handler.
 * Removes plugin options.
 */
function wsg_uninstall() {
	delete_option( WSG_OPTIONS );
}

//
// Register plugin activation handlers.
//
register_activation_hook( WSG_PLUGIN_FILE, 'wsg_activate' );
register_deactivation_hook( WSG_PLUGIN_FILE, 'wsg_deactivate' );
register_uninstall_hook( WSG_PLUGIN_FILE, 'wsg_uninstall' );


/**
 * Loads the plugin's translations.
 */
function wsg_init() {
	load_plugin_textdomain( WSG_PLUGIN_DOMAIN, null, 'wunderslider-gallery/languages' );
}

add_action( 'init', 'wsg_init' );
