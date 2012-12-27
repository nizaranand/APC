<?php
/**
 * admin-options-set.php
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

if ( !defined( 'WS_MAX_ZONES' ) ) {
	define( 'WS_MAX_ZONES', 16 );
}
if ( !defined( 'WS_DEFAULT_ZONES' ) ) {
	define( 'WS_DEFAULT_ZONES', 8 );
}

require_once( WSG_UTY_LIB . '/class-wsg-utility.php' );

// default settings
$atts = array(

	'applyDefaults'   => false,
	'silent'          => false,
	'hideLogo'        => false,
	'applyByDefault'  => true,

	'randomize'       => false,
	'skin'            => 'default',
	'useCaption'      => true,
	'useSelectors'    => true,
	'useNav'          => true,
	'useFlick'        => true,
	'useThrobber'     => true,
	'effect'          => 'random',
	'animateInterval' => 500,
	'render'          => 'fixed',
	'mouseOverPause'  => false,
	'width'           => 800,
	'height'          => 500,
	'overlayOpacity'  => 0.2,
	'overlay'         => 'stripes',
	'hzones'          => WS_DEFAULT_ZONES,
	'vzones'          => null,
	'period'          => 4000,
	'duration'        => 1000,
	'fps'             => 16,
	'morph'           => true
);

$options = get_option( WSG_OPTIONS, null );
$nextgen = array();
if ( isset( $options['defaults'] ) ) {
	if ( empty( $_POST['submit'] ) || !wp_verify_nonce( $_POST[WSG_NONCE], 'admin' ) || $_POST['action'] !== 'reset' ) {
		$atts = array_merge( $atts, $options['defaults'] );
		$nextgen = isset( $options['nextgen'] ) ? $options['nextgen'] : array();
	}
}

if ( !empty( $_POST['submit'] ) && wp_verify_nonce( $_POST[WSG_NONCE], 'admin' ) ) {
	if ( $_POST['action'] === 'set' ) {
		$atts = array(
			'applyDefaults'   => isset( $_POST['applyDefaults'] ),
			'silent'          => !isset( $_POST['silent'] ),
			'hideLogo'        => !isset( $_POST['hideLogo'] ),
			'applyByDefault'  => isset( $_POST['applyByDefault'] ),

			'randomize'       => isset( $_POST['randomize'] ),
			'skin'            => isset( $_POST['skin'] ) ? WSG_Utility::skin( $_POST['skin'] ) : $atts['skin'],
			'useCaption'      => isset( $_POST['useCaption'] ),
			'useSelectors'    => isset( $_POST['useSelectors'] ),
			'useNav'          => isset( $_POST['useNav'] ),
			'useThrobber'     => isset( $_POST['useThrobber'] ),
			'useFlick'        => isset( $_POST['useFlick'] ),
			'effect'          => isset( $_POST['effect'] ) ? WSG_Utility::effect( $_POST['effect'] ) : $atts['effect'],
			'animateInterval' => isset( $_POST['animateInterval'] ) ? WSG_Utility::integer( $_POST['animateInterval'], 0, 5000 ) : $atts['animateInterval'],
			'render'          => isset( $_POST['render'] ) ? WSG_Utility::check_render( $_POST['render'] ) : 'fullscreen',
			'mouseOverPause'  => isset( $_POST['mouseOverPause'] ),
			'width'           => isset( $_POST['width'] ) ? WSG_Utility::integer( $_POST['width'], 1, 1280 ) : $atts['width'],
			'height'          => isset( $_POST['height'] ) ? WSG_Utility::integer( $_POST['height'], 1, 1280 ) : $atts['height'],
			'overlayOpacity'  => isset( $_POST['overlayOpacity'] ) ? round( WSG_Utility::float( $_POST['overlayOpacity'], 0, 1 ), 2 ) : $atts['overlayOpacity'],
			'overlay'         => isset( $_POST['overlay'] ) &&  array_key_exists( $_POST['overlay'], WSG_Utility::$overlays ) ? $_POST['overlay'] : '',
			'hzones'          => !empty( $_POST['hzones'] ) ? WSG_Utility::integer_or_random( $_POST['hzones'], 1, WS_MAX_ZONES ) : $atts['hzones'],
			'vzones'          => !empty( $_POST['vzones'] ) ? WSG_Utility::integer_or_random( $_POST['vzones'], 1, WS_MAX_ZONES ) : $atts['vzones'],
			'period'          => isset( $_POST['period'] ) ? WSG_Utility::integer( $_POST['period'], 1 ) : $atts['period'],
			'duration'        => isset( $_POST['duration'] ) ? WSG_Utility::integer( $_POST['duration'], 1 ) : $atts['duration'],
			'fps'             => isset( $_POST['fps'] ) ? WSG_Utility::integer( $_POST['fps'], 1, 24 ) : $atts['fps'],
			'morph'           => true,
		);

		$nextgen['handle']    = isset( $_POST['nextgen'] );
		$nextgen['nggallery'] = isset( $_POST['nggallery'] );
	}
}

if ( $atts['duration'] > $atts['period'] ) {
	$atts['duration'] = $atts['period'];
}

// set mode and display according to $fullscreen
switch( $atts['render'] ) {
	case 'fullscreen' :
		$atts['mode']    = 'proportional';
		$atts['display'] = 'fill';
		break;
	case 'proportional' :
		$atts['mode']    = 'proportional';
		$atts['display'] = 'proportional';
		break;
	case 'fixed' :
		$atts['mode']    = 'proportional';
		$atts['display'] = 'fixed';
		break;
}

$atts['clickable'] = !$atts['useFlick'];

if ( !empty( $_POST['submit'] ) && wp_verify_nonce( $_POST[WSG_NONCE], 'admin' ) ) {
	$options['defaults']  = $atts;
	$options['nextgen']   = $nextgen;
	update_option( WSG_OPTIONS, $options );
}

extract( $atts );
