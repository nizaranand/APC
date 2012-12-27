<?php
/**
 * class-wunderslider-nggallery.php
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
 * @since wunderslider-gallery 1.3.0
 */
class WunderSlider_NGGallery {

	/**
	 * How many sliders have been created during a request.
	 * @var int
	 */
	private static $count = 0;

	/**
	 * Returns true if we are supposed to handle NextGEN's shortcodes (when no $tag is specified).
	 * Returns true if a given $tag should be handled.
	 *  
	 * @param $tag shortcode tag, defaults to null -> check
	 * 
	 * @return boolean true if NextGEN shortcodes or a specific shortcode should be handled
	 */
	private static function handle_shortcodes( $tag = null ) {
		$options = get_option( WSG_OPTIONS, null );
		$handle =
			isset( $options['nextgen'] ) &&
			isset( $options['nextgen']['handle'] ) &&
			$options['nextgen']['handle'];
		if ( $tag !== null ) {
			$handle =
				$handle &&
				isset( $options['nextgen'][$tag] ) &&
				$options['nextgen'][$tag];
		}
		return $handle;
	}

	/**
	 * Setup - adds the post_gallery filter.
	 */
	public static function init() {
		if ( class_exists( 'nggdb' ) ) {
			add_filter( 'the_posts', array( __CLASS__, 'the_posts' ) );
			add_shortcode( 'wunderslider_nggallery', array( __CLASS__, 'render_wunderslider_nggallery' ) );
		}
	}

	/**
	 * Override NextGEN's shortcodes.
	 */
	public static function plugins_loaded() {
		if ( class_exists( 'nggdb' ) ) {
			$options = get_option( WSG_OPTIONS, null );
			if ( self::handle_shortcodes() ) {
				remove_shortcode( 'nggallery' );
				add_shortcode( 'nggallery', array( __CLASS__ , 'nggallery') );
			}
		}
	}

	/**
	 * Load scripts when shortcode is present.
	 * 
	 * @todo add_filter on wsg_add_script instead
	 * 
	 * @param array $posts
	 * @return array
	 */
	public static function the_posts( $posts ) {
		if ( defined( 'WS_PLUGIN_URL' ) ) {
			if ( !wp_script_is( 'wunderslider' ) ) {
				if ( self::handle_shortcodes() ) {
					foreach( $posts as $post ) {
						$add_script = strpos( $post->post_content, '[wunderslider_nggallery' ) !== false;
						if ( !$add_script && strpos( $post->post_content, '[nggallery' ) !== false ) {
							if ( self::handle_shortcodes( 'nggallery' ) ) {
								if ( preg_match_all( '/\[nggallery.*\]/', $post->post_content, $matches ) ) {
									// applied by default if at least one uses it
									foreach ( $matches[0] as $match ) {
										if ( strpos( $match, 'wunderslider="false"' ) === false && strpos( $match, "wunderslider='false'" ) === false) {
											$add_script = true;
											break;
										}
									}
								}
							} else if ( preg_match_all( '/\[nggallery.*\]/', $post->post_content, $matches ) ) {
								foreach ( $matches[0] as $match ) {
									if ( strpos( $match, 'wunderslider="true"' ) !== false || strpos( $match, "wunderslider='true'" ) !== false) {
										$add_script = true;
										break;
									}
								}
							}
						}
						if ( $add_script ) {
							wp_enqueue_script( 'wunderslider', trailingslashit( WS_PLUGIN_URL ) . 'js/wunderslider-min.js', array( 'jquery' ), WSG_PLUGIN_VERSION );
							break;
						}
					}
				}
			}
		}
		return $posts;
	}

	/**
	 * Shortcode renderer for [wunderslider_nggallery].
	 * 
	 * $attr must provide the gallery's id and will pass any other parameters on to the root element of the WunderSlider XML specification.
	 *
	 * @param array $attr attributes
	 * @param string $content not used
	 */
	public static function render_wunderslider_nggallery( $attr, $content = null ) {

		// complain if the WunderSlider plugin is missing
		if ( !defined( 'WS_PLUGIN_URL' ) ) {
			return '<div class="error">' . __( 'The <a href="http://www.wunderslider.com/">WunderSlider</a> plugin is missing.', WSG_PLUGIN_DOMAIN ) . '</div>';
		}

		// rename underscored attributes
		if ( isset( $attr['container_class'] ) ) {
			$attr['container-class'] = $attr['container_class'];
			unset( $attr['container_class'] );
		}
		if ( isset( $attr['container_width'] ) ) {
			$attr['container-width'] = $attr['container_width'];
			unset( $attr['container_width'] );
		}
		if ( isset( $attr['container_height'] ) ) {
			$attr['container-height'] = $attr['container_height'];
			unset( $attr['container_height'] );
		}
		if ( isset( $attr['container_style'] ) ) {
			$attr['container-style'] = $attr['container_style'];
			unset( $attr['container_style'] );
		}

		extract( shortcode_atts( array( 'id' => null ), $attr ) );
		$id = intval( $id );
		if ( isset( $attr['id'] ) ) {
			unset( $attr['id'] ); // do not pass it on to the WunderSlider XML spec
		}
		if ( $id === null ) {
			return '<div class="error">' . __( 'The gallery <em>id</em> is missing.', WSG_PLUGIN_DOMAIN ) . '</div>';
		}

		$output = '';

		$ngg_options = nggGallery::get_option('ngg_options');
		$ngg_options['galSort'] = ($ngg_options['galSort']) ? $ngg_options['galSort'] : 'pid';
		$ngg_options['galSortDir'] = ($ngg_options['galSortDir'] == 'DESC') ? 'DESC' : 'ASC';

		if ( $picturelist = nggdb::get_gallery( $id, $ngg_options['galSort'], $ngg_options['galSortDir'] ) ) {

			$options = get_option( WSG_OPTIONS, null );

			//
			// Build the WunderSlider XML :
			//

			// opening wunderslider root element
			$xml = '<wunderslider ';
			$atts = isset( $options['defaults'] ) && isset( $options['defaults']['applyDefaults'] ) && $options['defaults']['applyDefaults'] ? $options['defaults'] : array();
			// remove hyperoptions
			unset( $atts['applyDefaults'] );
			unset( $atts['render'] );
			if ( !empty( $attr ) && is_array( $attr ) ) {
				$atts = array_merge( $atts, $attr );
			}
			if ( !empty( $atts ) ) {
				foreach( $atts as $key => $value ) {
					// avoid invalid 1s and 0s
					if ( $value === false ) {
						$value = 'false';
					} else if ( $value === true ) {
						$value = 'true';
					}
					$xml .= $key . '="' . esc_attr( $value ) . '" ';
				}
			}
			$xml .= '>';

			// image elements
			foreach( $picturelist as $nggImage ) {
				$url         = $nggImage->imageURL;
				$title       = $nggImage->title;
				$description = $nggImage->description;
				$xml .= sprintf( '<image url="%s" title="%s" description="%s" />', esc_attr( $url ), esc_attr( $title ), esc_attr( $description ) );
			}

			// closing root
			$xml .= '</wunderslider>';

			// parse the WunderSlider XML and build the output
			require_once( WP_PLUGIN_DIR . '/wunderslider/wunderslider.php' );
			require_once( WP_PLUGIN_DIR . '/wunderslider/lib/core/class-wunderslider-xml-parser.php' );

			$p = new WunderSlider_XML_Parser( $xml );
			$p->jquery = false;
			$p->basepath = trailingslashit( WS_PLUGIN_URL );
			$p->container_id = "wunderslider-nggallery-" . self::$count++;

			if ( $p->error === null ) {
				global $wsg_links_content;
				if ( !isset( $wsg_links_content ) || ( strpos( $wsg_links_content, $p->links ) === false ) ) {
					$output .= $p->links;
					$wsg_links_content = $p->links;
				}
				$output .= $p->container;
				$output .= $p->javascript;
			} else {
				$output .= $p->error;
			}
			// @todo noscript render option

		} else {
			$output .= '<div class="error">' . __( 'Gallery not found', WSG_PLUGIN_DOMAIN ) . '</div>';
		}
		return $output;
	}
	
	/**
	 * Shortcode override for [nggallery].
	 *
	 * $attr must provide the gallery's id and will pass any other parameters on to the root element of the WunderSlider XML specification.
	 *
	 * @param array $attr attributes
	 * @param string $content not used
	 */
	public static function nggallery( $attr, $content = null ) {
		$options = get_option( WSG_OPTIONS, null );
		$handle  = self::handle_shortcodes();
		$use_ws  = self::handle_shortcodes( 'nggallery' );
		// apply ws?
		if ( isset( $attr['wunderslider'] ) ) {
			include_once( WSG_UTY_LIB . '/class-wsg-utility.php' );
			$use_ws = WSG_Utility::boolean( $attr['wunderslider'] );
		}
		if ( $handle && $use_ws ) {
			return self::render_wunderslider_nggallery( $attr, $content );
		} else {
			// can't do this as it's not implemented (ore behaves) as a singleton
			// $ngs = new NextGEN_shortcodes();
			// return $ngs->show_gallery( $attr );
			global $wpdb;
			extract(
				shortcode_atts(
					array(
						'id'        => 0,
						'template'  => '',
						'images'    => false
					),
					$attr
				)
			);
			if( !is_numeric( $id ) ) {
				$id = $wpdb->get_var( $wpdb->prepare( "SELECT gid FROM $wpdb->nggallery WHERE name = '%s' ", $id ) );
			}
			return nggShowGallery( $id, $template, $images );
		}
	}
}
add_action( 'init', array( 'WunderSlider_NGGallery', 'init' ) );
add_action( 'plugins_loaded', array( 'WunderSlider_NGGallery', 'plugins_loaded' ), 333 );
