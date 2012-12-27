<?php
/**
 * wsg-admin-options.php
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

/**
 * @var string options form nonce name
 */
define( 'WSG_NONCE', 'wsg-nonce' );

class WSG_Admin_Options {

	/**
	 * Admin options setup.
	 */
	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'admin_menu' ) );
		add_action( 'admin_init', array( __CLASS__, 'admin_init' ) );
		add_filter( 'plugin_action_links_'. plugin_basename( WSG_PLUGIN_FILE ), array( __CLASS__, 'admin_settings_link' ) );
	}

	/**
	 * Admin options admin setup.
	 */
	public static function admin_init() {
		wp_register_style( 'wsg_admin', WSG_PLUGIN_URL . 'css/admin.css', array(), WSG_PLUGIN_VERSION );
	}

	/**
	 * Loads styles for the admin section.
	 */
	public static function admin_print_styles() {
		wp_enqueue_style( 'wsg_admin' );
	}

	/**
	 * Add a menu item to the Appearance menu.
	 */
	public static function admin_menu() {
		$page = add_theme_page(
			__( 'WunderSlider Gallery', WSG_PLUGIN_DOMAIN ),
			__( 'WunderSlider Gallery', WSG_PLUGIN_DOMAIN ),
			'edit_theme_options',
			'wunderslider-gallery',
			array( __CLASS__, 'admin_options' )
		);
		add_action( 'admin_print_styles-' . $page, array( __CLASS__, 'admin_print_styles' ) );
	}

	/**
	 * Options admin screen.
	 */
	public static function admin_options() {
		if ( !current_user_can( 'edit_theme_options' ) ) {
			wp_die( __( 'Access denied.', WSG_PLUGIN_DOMAIN ) );
		}
		echo
			'<h2>' .
			__( 'WunderSlider Gallery', WSG_PLUGIN_DOMAIN ) .
			'</h2>';
		echo '<div class="wsg-options">';
		include( 'admin-options-set.php' );
		include( 'admin-options-form.php' );
		echo '</div>';
	}

	/**
	 * Adds plugin links.
	 *
	 * @param array $links
	 * @param array $links with additional links
	 */
	public static function admin_settings_link( $links ) {
		$links[] = '<a href="' . get_admin_url( null, 'admin.php?page=wunderslider-gallery' ) . '">' . __( 'Settings', WSG_PLUGIN_DOMAIN ) . '</a>';
		$links[] = '<a href="http://www.wunderslider.com/">WunderSlider</a>';
		return $links;
	}

}
add_action( 'init', array( 'WSG_Admin_Options', 'init' ) );
