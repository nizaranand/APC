<?php
/**
 * Special settings for Posts and Pages edit screens
 *
 */

class PostSettingsMetaBox extends CustomMetaBox{

	public function __construct( $id, $title, $page, $context = 'side', $priority = 'default' ){
			
		parent::__construct( $id, $title, $page, $context, $priority );		
		
		
		$this->addField( new SelectMetaField( 'feature_type', __( 'Feature Type', 'agility' ), '', array() ,
				agility_feature_types() ));

		$this->addField( new TextMetaField( 'featured_video', __( 'Featured Video URL (Embedded)', 'agility' ) , '' , array( 
					'description' => '<a target="_blank" href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F">What sites can '.
									'I embed from?</a>  (Use Vimeo or YouTube for responsive support)',
				) ) );

		$this->addField( new SelectMetaField( 'custom_sidebar', __( 'Custom Sidebar', 'agility' ), '', array( 'default' => 'sidebar-1' ) ,
				'agility_sidebar_ops' ) );

		global $agilitySettings;
		$this->addField( new CheckboxMetaField( 'crop_feature', __( 'Crop Featured Image', 'agility' ), '', 
			array( 'description' => '', 
				'default' => $agilitySettings->op( 'crop-feature' ) ? 'on' : 'off' ) ) );

		$this->addField( new CheckboxMetaField( 'custom_thumbnail', __( 'Use Custom Thumbnail', 'agility' ), '', 
			array( 'description' => 'Use the custom cropped thumbnail instead of the standard Agility cropping for this featured image.',
				 'default' => $agilitySettings->op( 'custom-thumbnail' ) ? 'on' : 'off' ) ) );

		$this->addField( new CheckboxMetaField( 'disable_formatting', __( 'Disable Automatic Formatting', 'agility' ), '', 
			array( 'description' => 'Disable the autop and texturize filters for this post.',
				 'default' => 'off' ) ) );
	}

}


class PageSettingsMetaBox extends CustomMetaBox{

	public function __construct( $id, $title, $page, $context = 'side', $priority = 'default' ){
			
		parent::__construct( $id, $title, $page, $context, $priority );		
		
		
		$this->addField( new TextMetaField( 'post_subtitle', __( 'Subtitle', 'agility' ) , '' , array( 
					'description' => __( 'The subtitle is optional and will appear below the main title.', 'agility' ),
				) ) );

		$this->addField( new SelectMetaField( 'custom_sidebar', __( 'Custom Sidebar', 'agility' ), '', array( 'default' => 'sidebar-1' ) ,
				'agility_sidebar_ops' ) );

		$this->addField( new SelectMetaField( 'blog_query_id', __( 'Custom Blog', 'agility' ), '', array( 'default' => 0 , 
				'description' => __( 'Applicable for templates that display a blog' , 'agility' ) ) ,
				'agility_blog_ops' ) );

		$this->addField( new CheckboxMetaField( 'disable_formatting', __( 'Disable Automatic Formatting', 'agility' ), '', 
			array( 'description' => 'Disable the autop and texturize filters for this Page.',
				 'default' => 'off' ) ) );

	}

}

//$GLOBALS['cpt_post_settings_metabox_post'] = new PostSettingsMetaBox( 'post_settings', 'Post Settings', 'post', 'side' );
