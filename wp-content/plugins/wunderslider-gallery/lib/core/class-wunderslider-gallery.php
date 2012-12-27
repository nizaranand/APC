<?php
/**
 * class-wunderslider-gallery.php
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
class WunderSlider_Gallery {
	
	/**
	 * How many sliders have been created during a request.
	 * @var int
	 */
	private static $count = 0;

	/**
	 * Setup - adds the post_gallery filter.
	 */
	public static function init() {
		add_filter( 'the_posts', array( __CLASS__, 'the_posts' ) );
		add_filter( 'post_gallery', array( __CLASS__, 'post_gallery' ), 10, 2 );
	}

	/**
	 * Load scripts when shortcode is present.
	 * @param array $posts
	 * @return array
	 */
	public static function the_posts( $posts ) {
		if ( defined( 'WS_PLUGIN_URL' ) ) {
			if ( !wp_script_is( 'wunderslider' ) ) {
				$options = get_option( WSG_OPTIONS, null );
				$applyByDefault = !isset( $options['defaults'] ) || !isset( $options['defaults']['applyByDefault'] ) || $options['defaults']['applyByDefault'];
				$add_script = false;
				foreach( $posts as $post ) {
					if ( $applyByDefault ) {
						if ( preg_match_all( '/\[gallery.*\]/', $post->post_content, $matches ) ) {
							// applied by default if at least one uses it
							foreach ( $matches[0] as $match ) {
								if ( strpos( $match, 'wunderslider="false"' ) === false && strpos( $match, "wunderslider='false'" ) === false) {
									$add_script = true;
									break;
								}
							}
						}
					} else if ( preg_match_all( '/\[gallery.*\]/', $post->post_content, $matches ) ) {
						foreach ( $matches[0] as $match ) {
							if ( strpos( $match, 'wunderslider="true"' ) !== false || strpos( $match, "wunderslider='true'" ) !== false) {
								$add_script = true;
								break;
							}
						}
					}
					$add_script = apply_filters( 'wsg_add_script', $post );
					if ( $add_script ) {
						break;
					}
				}
				if ( $add_script ) {
					wp_enqueue_script( 'wunderslider', trailingslashit( WS_PLUGIN_URL ) . 'js/wunderslider-min.js', array( 'jquery' ), WSG_PLUGIN_VERSION );
				}
			}
		}
		return $posts;
	}

	/**
	 * Gallery replacement shortcode handler.
	 * 
	 * This handler is invoked from gallery_shortcode() defined in media.php.
	 *
	 * @param array $attr attributes
	 * @return string
	 */
	public static function post_gallery( $empty = '', $attr = array() ) {
		global $post;

		// stop it right here if we don't have a WunderSlider
		if ( !defined( 'WS_PLUGIN_URL' ) ) {
			return '<div>' . __( 'The <a href="http://www.wunderslider.com/">WunderSlider</a> plugin is missing.', WSG_PLUGIN_DOMAIN ) . '</div>';
		}

		$options = get_option( WSG_OPTIONS, null );
		$use_ws = !isset( $options['defaults'] ) || !isset( $options['defaults']['applyByDefault'] ) || $options['defaults']['applyByDefault'];
		// apply ws?
		if ( isset( $attr['wunderslider'] ) ) {
			include_once( WSG_UTY_LIB . '/class-wsg-utility.php' );
			$use_ws = WSG_Utility::boolean( $attr['wunderslider'] );
		}
		
		if ( !$use_ws ) {
			return;
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

		$output = '';
		
		//
		// Gallery stuff to get the attachments
		//

		// Quote: "We're trusting author input, so let's at least make sure it looks like a valid orderby statement"
		if ( isset( $attr['orderby'] ) ) {
			$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
			if ( !$attr['orderby'] ) {
				unset( $attr['orderby'] );
			}
		}

		extract(
			shortcode_atts(
				array(
					'order'      => 'ASC',
					'orderby'    => 'menu_order ID',
					'id'         => $post->ID,
					'size'       => 'full', // possible default sizes: thumbnail, medium, large, full
					'include'    => '',
					'exclude'    => ''
				),
				$attr
			)
		);

		$id = intval( $id );
		if ( 'RAND' == $order ) {
			$orderby = 'none';
		}

		if ( !empty( $include ) ) {
			$include = preg_replace( '/[^0-9,]+/', '', $include );
			$_attachments = get_posts(
				array(
					'include' => $include,
					'post_status' => 'inherit',
					'post_type' => 'attachment',
					'post_mime_type' => 'image',
					'order' => $order,
					'orderby' => $orderby
				)
			);
			$attachments = array();
			foreach ( $_attachments as $key => $val ) {
				$attachments[$val->ID] = $_attachments[$key];
			}
		} else if ( !empty( $exclude ) ) {
			$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
			$attachments = get_children(
				array(
					'post_parent' => $id,
					'exclude' => $exclude,
					'post_status' => 'inherit',
					'post_type' => 'attachment',
					'post_mime_type' => 'image',
					'order' => $order,
					'orderby' => $orderby
				)
			);
		} else {
			$attachments = get_children(
				array(
					'post_parent' => $id,
					'post_status' => 'inherit',
					'post_type' => 'attachment',
					'post_mime_type' => 'image',
					'order' => $order,
					'orderby' => $orderby
				)
			);
		}

		if ( empty( $attachments ) ) {
			return '';
		}

		if ( is_feed() ) {
			$output = "\n";
			foreach ( $attachments as $att_id => $attachment ) {
				$output .= wp_get_attachment_link( $att_id, $size, true ) . "\n";
			}
			return $output;
		}

		//
		// Build the WunderSlider XML :
		//

		// opening wunderslider root element
		$xml = '<wunderslider ';
		$atts = isset( $options['defaults'] ) && isset( $options['defaults']['applyDefaults'] ) && $options['defaults']['applyDefaults'] ? $options['defaults'] : array();
		// remove hyperoptions
		unset( $atts['applyDefaults'] );
		unset( $atts['render'] );
		if ( !empty( $attr ) ) {
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
		foreach( $attachments as $id => $attachment ) {
			if ( wp_attachment_is_image( $id ) ) {
			$url = wp_get_attachment_url( $id );
			$img_url = null;
			if ( $intermediate = image_get_intermediate_size( $id, $size ) ) {
				$img_url = isset( $intermediate['url'] ) ? $intermediate['url'] : null;
				if ( empty( $img_url ) && !empty( $intermediate['file'] ) ) {
					$original_file_url = wp_get_attachment_url( $id );
					if ( !empty( $original_file_url ) ) {
						$img_url = path_join( dirname( $original_file_url ), $intermediate['file'] );
					}
				}
			}
			if ( !empty( $img_url ) ) {
				$url = $img_url;
			}
			$title = $attachment->post_title;
			$description = $attachment->post_content;
			$xml .= sprintf( '<image url="%s" title="%s" description="%s" />', esc_attr( $url ), esc_attr( $title ), esc_attr( $description ) );
			}
		}

		// closing root
		$xml .= '</wunderslider>';

		// parse the WunderSlider XML and build the output
		require_once( WP_PLUGIN_DIR . '/wunderslider/wunderslider.php' );
		require_once( WP_PLUGIN_DIR . '/wunderslider/lib/core/class-wunderslider-xml-parser.php' );

		$p = new WunderSlider_XML_Parser( $xml );
		$p->jquery = false;
		$p->basepath = trailingslashit( WS_PLUGIN_URL );
		$p->container_id = "wunderslider-gallery-" . self::$count++;

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
		// @todo noscript render option : invoke gallery_shortcode(...) with post_gallery filters disabled

		return $output;
	}
}
add_action( 'init', array( 'WunderSlider_Gallery', 'init' ) );
