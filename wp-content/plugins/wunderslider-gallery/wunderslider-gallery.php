<?php
/**
 * wunderslider-gallery.php
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
 *
 * Plugin Name: WunderSlider Gallery
 * Plugin URI: http://www.itthinx.com/wunderslider
 * Description: Turns default WordPress and NextGEN galleries into WunderSliders. This plugin requires <a href="http://www.wunderslider.com/">WunderSlider</a> which is free for personal use and available for download <a href="http://www.itthinx.com/wunderslider/">here</a>.
 * Version: 1.3.2
 * Author: itthinx
 * Author URI: http://www.itthinx.com
 * Donate-Link: http://www.itthinx.com
 * License: GPLv3
 */
define( 'WSG_PLUGIN_VERSION', '1.3.2' );
define( 'WSG_PLUGIN_DOMAIN', 'wunderslider-gallery' );
define( 'WSG_PLUGIN_FILE', __FILE__ );
define( 'WSG_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WSG_PLUGIN_DIR', WP_PLUGIN_DIR . '/wunderslider-gallery' );
define( 'WSG_CORE_LIB', WSG_PLUGIN_DIR . '/lib/core' );
define( 'WSG_ADMIN_LIB', WSG_PLUGIN_DIR . '/lib/admin' );
define( 'WSG_UTY_LIB', WSG_PLUGIN_DIR . '/lib/uty' );
define( 'WSG_OPTIONS', 'wsg_options' );
require_once( WSG_CORE_LIB . '/boot.php' );
