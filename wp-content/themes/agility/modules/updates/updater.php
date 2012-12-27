<?php

/**
 * Provides a notification everytime the theme is updated
 * Original code courtesy of João Araújo of Unisphere Design - http://themeforest.net/user/unisphere
 */

define( 'AGILITY_UPDATE_DELAY' , 172800 );
define( 'AGILITY_NOTIFIER_URL' , 'http://sevensparklabs.com/updates/agility/notifier.xml' );

//TEST
//define( 'AGILITY_UPDATE_DELAY' , 20 );
//define( 'AGILITY_NOTIFIER_URL' , 'http://mavair.local/~chris/updates/test/agility/notifier.xml' );

function agility_update_notifier_menu() {  

	if( !function_exists( 'simplexml_load_string' ) ) return;
	if( !function_exists( 'wp_get_theme' ) ) return;

	global $wp_admin_bar, $wpdb;

	if ( !is_super_admin() || !is_admin_bar_showing() ) 
		return;
	

	$xml = agility_get_latest_theme_version( AGILITY_UPDATE_DELAY ); // This tells the function to cache the remote call for 172800 seconds (48 hours)
	//$theme_data = get_theme_data(TEMPLATEPATH . '/style.css'); // Get theme data from style.css (current version is what we want)

	/*if(version_compare($theme_data['Version'], $xml->latest) == -1) {
		if( !$wp_admin_bar ) return;
		$wp_admin_bar->add_menu( array( 'id' => 'agility_update_notifier', 'title' => '<span> Agility Theme <span id="ab-updates">New Updates</span></span>', 'href' => get_admin_url() . 'admin.php?page=agility-settings&updates=1' ) );
	}*/

	$theme = wp_get_theme( 'agility' );
	//echo $theme->Name. '...'.$theme->Version . '|'.$xml->latest;

	if( version_compare( $theme->Version, $xml->latest ) == -1 ){
		if( !$wp_admin_bar ) return;
		$wp_admin_bar->add_menu( array( 'id' => 'agility_update_notifier', 'title' => '<span> Agility Theme <span id="ab-updates">New Updates</span></span>', 'href' => get_admin_url() . 'admin.php?page=agility-settings&updates=1' ) );
	}

}  

if( is_admin() ) add_action('admin_menu', 'agility_update_notifier_menu');

function agility_update_notifier() { 
	$xml = agility_get_latest_theme_version( AGILITY_UPDATE_DELAY ); // This tells the function to cache the remote call for 172800 seconds (48 hours)
	//$theme_data = get_theme_data(TEMPLATEPATH . '/style.css'); // Get theme data from style.css (current version is what we want)
	$theme = wp_get_theme( 'agility' );
	?>

	<style>
		.update-nag {display: none;}
		#instructions {max-width: 800px;}
		h3.title {margin: 30px 0 0 0; padding: 30px 0 0 0; border-top: 1px solid #ddd;}
	</style>

	<div class="wrap">
	
		<div id="icon-tools" class="icon32"></div>
		<h2><?php echo $theme->Name; ?> Theme Updates</h2>
	    <div id="message" class="updated below-h2"><p><strong>There is a new version of the <?php echo $theme->Name; ?> theme available.</strong> You have version <?php echo $theme->Version; ?> installed. Update to version <?php echo $xml->latest; ?>.</p></div>
        
        <img style="float: left; margin: 0 20px 20px 0; border: 1px solid #ddd;" src="<?php echo get_bloginfo( 'template_url' ) . '/screenshot.png'; ?>" />
        
        <div id="instructions" style="max-width: 800px;">
            <h3>Update Download and Instructions</h3>
            <p><strong>Please note:</strong> make a <strong>backup</strong> of the Theme inside your WordPress installation folder <strong>/wp-content/themes/<?php echo strtolower($theme->Name); ?>/</strong></p>
            <p>To update the Theme, login to <a href="http://www.themeforest.net/">ThemeForest</a>, head over to your <strong>downloads</strong> section and re-download the theme like you did when you bought it.</p>
            <p>Extract the zip's contents, look for the extracted theme folder, and after you have all the new files upload them using FTP to the <strong>/wp-content/themes/<?php echo strtolower($theme->Name); ?>/</strong> folder overwriting the old ones (this is why it's important to backup any changes you've made to the theme files).</p>
        </div>
        
            <div class="clear"></div>
	    
	    <h3 class="title">Changelog</h3>
	    <?php echo $xml->changelog; ?>

	</div>
    
<?php } 

// This function retrieves a remote xml file on my server to see if there's a new update 
// For performance reasons this function caches the xml content in the database for XX seconds ($interval variable)
function agility_get_latest_theme_version($interval) {
	// remote xml file location
	//$notifier_file_url = 'http://sevensparklabs.com/updates/agility/notifier.xml';
	$notifier_file_url = AGILITY_NOTIFIER_URL; 
	
	$db_cache_field = 'agility-notifier-cache';
	$db_cache_field_last_updated = 'agility-notifier-last-updated';
	$last = get_option( $db_cache_field_last_updated );
	$now = time();
	// check the cache
	if ( !$last || (( $now - $last ) > $interval) ) {
		// cache doesn't exist, or is old, so refresh it
		if( function_exists('curl_init') ) { // if cURL is available, use it...
			$ch = curl_init($notifier_file_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			$cache = curl_exec($ch);
			curl_close($ch);
		} else {
			$cache = file_get_contents($notifier_file_url); // ...if not, use the common file_get_contents()
		}
		
		if ($cache) {			
			// we got good results
			update_option( $db_cache_field, $cache );
			update_option( $db_cache_field_last_updated, time() );			
		}
		// read from the cache file
		$notifier_data = get_option( $db_cache_field );
	}
	else {
		// cache file is fresh enough, so read from it
		$notifier_data = get_option( $db_cache_field );
	}
	
	$xml = simplexml_load_string($notifier_data); 
	
	return $xml;
}