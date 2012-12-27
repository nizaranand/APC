<?php
/**
 * Self-hosted Video Module
 */

function agility_videojs_scripts_and_styles(){

	global $agilitySettings;
	$dir = get_template_directory_uri().'/';

	if( $agilitySettings->op( 'self-hosted-video' ) ){
		//Stylesheets
		//wp_enqueue_style( 'videojs', $dir.'modules/video/jplayer/skins/blue.monday/jplayer.blue.monday.css' );
		wp_enqueue_style( 'videojs', $dir.'modules/video/jplayer/skins/agility/jplayer.agility.css' );

		//Javascript
		wp_enqueue_script( 'jplayer' , $dir.'modules/video/jplayer/jquery.jplayer.min.js' , array( 'jquery' ), false, false ); // false );
	}
}
add_action( 'wp_enqueue_scripts', 'agility_videojs_scripts_and_styles' );


//TODO rename to agility_featured_video
function agility_featured_videojs( $delay = false , $width = 640 , $height = 264 ){
	global $post;

	$sources = array(
		'ogg'	=>	get_post_meta( $post->ID , 'featured_video_ogg' , true ),
		'webm'	=>	get_post_meta( $post->ID , 'featured_video_webm' , true ),
		'mp4'	=>	get_post_meta( $post->ID , 'featured_video_mp4' , true ), //
		'img'	=>	wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ),
	);

	$_width 	= get_post_meta( $post->ID , 'featured_video_width' , true );
	$_height = get_post_meta( $post->ID , 'featured_video_height' , true );

	if( $_width != '' ) $width = $_width;
	if( $_height != '' ) $height = $_height;

	agility_video_jplayer( 'featured-video-'.$post->ID, $sources , $width, $height, $delay );

}

function agility_video_jplayer( $id, $sources , $width = 640 , $height = 264 , $delay = false ){

	global $post;

	$source_defaults = array(
		'ogg'	=>	'',
		'mp4'	=>	'',
		'webm'	=>	'',
		'img'	=>	'',
	);

	extract( wp_parse_args( $sources , $source_defaults ) );

	//$dir = get_template_directory_uri().'/';

	?>

	<?php if( !$ogg && !$mp4 && !$webm ):?>

				<div class="hint">Please define at least one video source file (ogg, mp4, webm).</div>

	<?php else: ?>

				<script type="text/javascript">
				/*
				    jQuery(document).ready(function($){
				      $("#jquery_jplayer_1").jPlayer({
				        ready: function () {
				          $(this).jPlayer("setMedia", {
				            m4v: "http://www.jplayer.org/video/m4v/Big_Buck_Bunny_Trailer_480x270_h264aac.m4v",
				            ogv: "http://www.jplayer.org/video/ogv/Big_Buck_Bunny_Trailer_480x270.ogv",
				            poster: "http://www.jplayer.org/video/poster/Big_Buck_Bunny_Trailer_480x270.png"
				          });
				        },
				        size: {
				        	width: "<?php echo $width; ?>px",
				        	height: "<?php echo $height; ?>px"
				        },
				        swfPath: "/js",
				        supplied: "m4v, ogv",
				        preload: "none"
				      });

				      var target = $('#jquery_jplayer_1 video')[0]; // Get DOM element from jQuery collection
						$('.jp-full-screen-toggle').click(function() {
						    if ( screenfull ) {
						        screenfull.request( target );
						    }
						});
				    });
*/
				  </script>

				<!-- featured-video -->
				<div id="<?php echo $id; ?>" class="featured-video featured-video-jplayer">

					<div id="jp_container_<?php echo $post->ID; ?>" class="jp-video" 
						data-player-id="<?php echo $post->ID; ?>"
						data-player-width="<?php echo $width; ?>" 
						data-player-height="<?php echo $height; ?>" 
						data-player-m4v="<?php echo $mp4; ?>"
						data-player-ogv="<?php echo $ogg; ?>"
						data-player-webmv="<?php echo $webm; ?>"
						data-player-poster="<?php echo $img; ?>"
						>
						
						<div class="jp-type-single">
						  <div id="jquery_jplayer_<?php echo $post->ID; ?>" class="jp-jplayer"></div>
						  <div class="jp-gui">
							<div class="jp-interface">
							  <div class="jp-progress">
								<div class="jp-seek-bar">
								  <div class="jp-play-bar"></div>
								</div>
							  </div>
							  
							  <div class="jp-controls-holder">
								<ul class="jp-controls">
								  <li><a href="#" class="jp-play" tabindex="1"><i class="icon-play"></i><span>Play</span></a></li>
								  <li><a href="#" class="jp-pause" tabindex="1"><i class="icon-pause"></i><span>Pause</span></a></li>
								  <li><a href="#" class="jp-mute" tabindex="1" title="mute"><i class="icon-volume-off"></i><span>Mute</span></a></li>
								  <li><a href="#" class="jp-unmute" tabindex="1" title="unmute"><i class="icon-volume-up"></i><span>Unmute</span></a></li>
								</ul>
								<div class="jp-volume-bar">
								  <div class="jp-volume-bar-value"></div>
								</div>
								
								<ul class="jp-toggles">
								  <!--<li><a href="#" class="jp-full-screen-toggle" tabindex="1" title="full screen"><i class="icon-resize-full"></i><span>Full Screen</span></a></a></li>-->
								  <li><a href="#" class="jp-full-screen" tabindex="1" title="full screen"><i class="icon-resize-full"></i><span>Full Screen</span></a></a></li>
								  <li><a href="#" class="jp-restore-screen" tabindex="1" title="restore screen"><i class="icon-resize-small"></i><span>Restore Screen</span></a></a></li>
								</ul>

								<div class="jp-time-holder">
									<div class="jp-current-time"></div> / 
							  		<div class="jp-duration"></div>
							  	</div>
							  </div>
							</div>
						  </div>
						  <div class="jp-no-solution">
						  	<div class="jp-no-solution-inner">
								<span>Update Required</span>
								To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
							</div>
						  </div>
						</div>
					  </div>
					
					<?php /*
					<!-- Begin VideoJS - Self Hosted Video -->
					<!-- Using the Video for Everybody Embed Code http://camendesign.com/code/video_for_everybody -->
					<video class="video-js vjs-default-skin" width="<?php echo $width; ?>" height="<?php echo $height; ?>" controls preload="none" 
							poster="<?php echo $img; ?>" data-setup="{}" >

					<?php if( $mp4 ): ?>
						<source src="<?php echo $mp4; ?>" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"' />
					<?php endif; ?>

					<?php if( $webm ): ?>
						<source src="<?php echo $webm; ?>" type='video/webm; codecs="vp8, vorbis"' />
					<?php endif; ?>

					<?php if( $ogg ): ?>
						<source src="<?php echo $ogg; ?>" type='video/ogg; codecs="theora, vorbis"' />
					<?php endif; ?>

					<?php if( $mp4 ): ?>
						<!-- Flash Fallback. -->
						<object class="vjs-flash-fallback" width="<?php echo $width; ?>" height="<?php echo $height; ?>" type="application/x-shockwave-flash"
							data="http://vjs.zencdn.net/3.2/video-js.swf">
							<param name="movie" value="http://vjs.zencdn.net/3.2/video-js.swf" />
							<param name="allowfullscreen" value="true" />
							<param name="flashvars" value='config={"playlist":["<?php echo $mp4; ?>", {"url": "<?php echo $mp4; ?>","autoPlay":false,"autoBuffering":true}]}' />
							<!-- Image Fallback. Typically the same as the poster image. -->
							<img src="<?php echo $img; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" alt="Poster Image"
								title="No video playback capabilities." />
						</object>
					<?php endif; ?>

					</video>
					<!-- End VideoJS -->		
					*/
					?>			
					
				</div>
				<!-- end .featured-video -->

	<?php endif;
}


//Create Meta Box
if(!class_exists('AgilityCustomPostType')) require_once( get_template_directory().'/modules/custom_post_types/AgilityCustomPostType.class.php');

class SHVideoSettingsMetaBox extends CustomMetaBox{

	public function __construct( $id, $title, $page, $context = 'side', $priority = 'default' ){
			
		parent::__construct( $id, $title, $page, $context, $priority );		

		$this->addField( new TextMetaField( 'featured_video_mp4', __( 'MP4 Video URL', 'agility' ) , '' , array( 
					'description' => __( 'MP4 is required for Safari/iOS HTML5 Video and Flash Fallback', 'agility' ),
				) ) );
		
		$this->addField( new TextMetaField( 'featured_video_ogg', __( 'OGG Video URL', 'agility' ) , '' , array( 
					'description' => __( 'OGG (.ogv) is used for Firefox/Opera/Chrome HTML5 Video', 'agility' ),
				) ) );

		$this->addField( new TextMetaField( 'featured_video_webm', __( 'WebM Video URL', 'agility' ) , '' , array( 
					'description' => '<a href="http://camendesign.com/code/video_for_everybody#webm">WebM</a> '.__( 'is optional.', 'agility' ),
				) ) );

		$this->addField( new TextMetaField( 'featured_video_width', __( 'Video Width', 'agility' ) , '' , array( 
					'description' => 'Width in pixels (will determine aspect ratio when scaling)'
				) ) );

		$this->addField( new TextMetaField( 'featured_video_height', __( 'Video Height', 'agility' ) , '' , array( 
					'description' => 'Height in pixels (will determine aspect ratio when scaling)'
				) ) );

	}

}