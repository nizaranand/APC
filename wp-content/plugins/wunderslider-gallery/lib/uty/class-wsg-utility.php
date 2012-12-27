<?php
/**
 * class-wsg-utility.php
 *
 * Copyright (c) "kento" Karim Rahimpur www.itthinx.com
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
 * Defines available rendering resources and utility functions.
 */
class WSG_Utility {
	
	/**
	 * Available skins.
	 * @var array
	 */
	public static $skins = array(
		'default'     => 'Default',
		'box'         => 'Box',
		'dotsy'       => 'Dotsy',
		'dotsy-dark'  => 'Dotsy Dark',
		'dotsy-light' => 'Dotsy Light',
		'glass'       => 'Glass',
		'glass-light' => 'Glass Light',
		'zenspace'    => 'Zen Space'
	);

	/**
	 * Available effects.
	 * @var array
	 */
	public static $effects = array(

		'random' => 'Random',

		'none' => 'No effect',

		'fadeIn' => 'Fade in',
		'checkers' => 'Checkers',
		'slideDown' => 'Slide down',
		'slideUp' => 'Slide up',
		'slideLeft' => 'Slide left',
		'slideRight' => 'Slide right',
		'slideLeftDown' => 'Slide left down',
		'slideRightDown' => 'Slide right down',
		'slideLeftUp' => 'Slide left up',
		'slideRightUp' => 'Slide right up',

		'joinUp' => 'Join up',
		'joinDown' => 'Join down',
		'joinLeft' => 'Join left',
		'joinRight' => 'Join right',
		'joinLeftDown' => 'Join left down',
		'joinRightDown' => 'Join right down',
		'joinLeftUp' => 'Join left up',
		'joinRightUp' => 'Join right up',

		'hBlinds' => 'Horizontal blinds',
		'vBlinds' => 'Vertical blinds',

		'hStripes' => 'Horizontal stripes',
		'vStripes' => 'Vertical stripes',
		'stripes'=> 'Flying blocks',     // flying blocks

		'hJoinStripes' => 'Horizontal composition', // h-compose
		'vJoinStripes' => 'Vertical composition', // v-compose
		'joinStripes' => 'Unplode',  // unplode

		'hCurtain' => 'Horizontal curtain',
		'vCurtain' => 'Vertical curtain',
		'curtain' => 'Magic curtain',      // magic curtain

		'runRightDown' => 'Run right down', // left to right, top down
		'runLeftDown' => 'Run left down',
		'runRightUp' => 'Run right up',
		'runLeftUp' => 'Run left up',

		'runDownRight' => 'Run down right', // top down, left to right
		'runDownLeft' => 'Run down left',
		'runUpRight' => 'Run up right',
		'runUpLeft' => 'Run up left',

		'scanDown' => 'Scan down',     // top down, left to right, right to left
		'scanUp' => 'Scan up',
		'scanLeft' => 'Scan left',
		'scanRight' => 'Scan right',

		'snakeIn' => 'Snake in',
		'snakeOut' => 'Snake out'
	);

	/**
	 * Available overlays.
	 * @var array
	 */
	public static $overlays = array(
		'chain' => 'Chain',
		'chain-white' => 'Chain (white)',
		'gilgamesh' => 'GilgaMesh',
		'gilgamesh-white' => 'GilgaMesh (white)',
		'mesh' => 'Mesh',
		'mesh-white' => 'Mesh (white)',
		'polka' => 'Polka',
		'polka-white' => 'Polka (white)',
		'stripes' => 'Stripes',
		'stripes-white' => 'Stripes (white)',
		'thickmesh' => 'Thick mesh',
		'thickmesh-white' => 'Thick mesh (white)'
	);

	/**
	 * Check and return boolean value.
	 * @param mixed $value
	 * @return boolean
	 */
	public static function boolean( $value ) {
		$value = (string) $value;
		$value = strtolower( $value );
		switch( $value ) {
			case 'true' :
			case 'on' :
			case 'yes' :
				$value = true;
				break;
			default :
				$value = false;
		}
		return $value;
	}

	/**
	 * Check and return integer.
	 * @param mixed $value
	 * @param int $min
	 * @param int $max
	 * @return int
	 */
	public static function integer( $value, $min = null, $max = null ) {
		$value = intval( $value );
		if ( $min !== null ) {
			if ( $value < $min ) {
				$value = $min;
			}
		}
		if ( $max !== null ) {
			if ( $value > $max ) {
				$value = $max;
			}
		}
		return $value;
	}

	/**
	 * Check and return integer or the string 'random'.
	 * @param mixed $value
	 * @param int $min
	 * @param int $max
	 * @return int
	 */
	public static function integer_or_random( $value, $min = null, $max = null ) {
		if ( $value === 'random' ) {
			return 'random';
		} else {
			return self::integer( $value, $min, $max );
		}
	}

	/**
	 * Check and return float.
	 * @param mixed $value
	 * @param float $min
	 * @param float $max
	 * @return float
	 */
	public static function float( $value, $min = null, $max = null) {
		$value = floatval( $value );
		if ( $min !== null ) {
			if ( $value < $min ) {
				$value = $min;
			}
		}
		if ( $max !== null ) {
			if ( $value > $max ) {
				$value = $max;
			}
		}
		return $value;
	}

	/**
	 * Check and return skin key.
	 * @param string $value
	 * @return string skin key
	 */
	public static function skin( $value ) {
		if ( array_key_exists( $value, self::$skins ) ) {
			return $value;
		} else {
			return 'default';
		}
	}

	/**
	 * Check and return effect key.
	 * @param string $value
	 * @return string effect key
	 */
	public static function effect( $value ) {
		if ( array_key_exists( $value, self::$effects ) ) {
			return $value;
		} else {
			return 'random';
		}
	}

	/**
	 * Check and return rendering mode key.
	 * @param string $value
	 * @return string rendering key
	 */
	public static function check_render( $render ) {
		$result = 'fullscreen';
		switch ( $render ) {
			case 'fullscreen' :
				$result = 'fullscreen';
				break;
			case 'fixed' :
				$result = 'fixed';
				break;
			case 'proportional' :
				$result = 'proportional';
				break;
		}
		return $result;
	}

}