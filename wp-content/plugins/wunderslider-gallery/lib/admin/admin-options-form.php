<?php
/**
 * admin-options-form.php
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
?>

<?php
	echo 
		'<h3>' . __( 'Default Settings', WSG_PLUGIN_DOMAIN ) . '</h3>' .
		'<div class="intro">' .
		'<p>' . __( 'The <em>WunderSlider Gallery</em> plugin turns galleries that are embedded with the standard WordPress <code>[gallery]</code> or NextGEN shortcodes into responsive WunderSlider slideshows.', WSG_PLUGIN_DOMAIN ) . '</p>' .
		'<p>' .
			__( 'If you want to maintain the standard way of how a specific gallery is rendered, add the <code>wunderslider</code> attribute and set it to <code>false</code> : <code>[gallery wunderslider="false"]</code>.', WSG_PLUGIN_DOMAIN ) .
			' ' .
			__( 'If you only want to apply WunderSlider Gallery to a few galleries, you can disable the <em>Apply by default</em> option.', WSG_PLUGIN_DOMAIN ) .
		'</p>' .
		'<p>' . __( '<a href="http://www.wunderslider.com/">WunderSlider</a> uses a set of default options when no specific settings are used. Here you can determine what settings should be used by default instead.', WSG_PLUGIN_DOMAIN ) . '</p>' .
		'<p>' . __( 'You can override these settings by passing WunderSlider shortcode attributes to the <code>[gallery]</code> shortcode.', WSG_PLUGIN_DOMAIN ) . '</p>' .
		'<p>' . __( 'For more information and examples please refer to the following resources:', WSG_PLUGIN_DOMAIN ) . '</p>' .
		'<ul>' .
			'<li>' . __( '<a href="http://www.wunderslider.com/">WunderSlider Demo</a>', WSG_PLUGIN_DOMAIN ) . '</li>' .
			'<li>' . __( '<a href="http://wunderslider.com/wordpress/">WunderSlider WordPress Demo</a>', WSG_PLUGIN_DOMAIN ) . '</li>' .
			'<li>' . __( '<a href="http://www.itthinx.com/wunderslider/">WunderSlider Page</a>', WSG_PLUGIN_DOMAIN ) . '</li>' .
		'</ul>' .
		'</div>';
	
	if ( !defined( 'WS_PLUGIN_URL' ) ) {
		echo
			'<div class="error">' .
			'<p>' .
			__( 'The WunderSlider plugin has not been found. You need to install or activate it.', WSG_PLUGIN_DOMAIN ) .
			'</p>' .
			'<p>' .
			__( 'Please visit <a href="http://www.wunderslider.com/">WunderSlider</a> to obtain a copy, then install and activate the WunderSlider WordPress plugin.', WSG_PLUGIN_DOMAIN ) .
			'</p>' .
			'</div>';
	}
?>

<div class="settings">

<form name="settings" method="post" action="">
<div>

<div class="buttons">
<?php /* nonce and action are rendered at the end */ ?>
<input class="apply button" type="submit" name="submit" value="<?php echo __( 'Apply', WSG_PLUGIN_DOMAIN ); ?>" />
</div>

<br/>

<div class="enable-defaults">
<fieldset>
<legend><?php _e( 'Enable defaults', WSG_PLUGIN_DOMAIN ); ?></legend>
<div class="field first">
<p>
<input id="applyDefaults" type="checkbox" name="applyDefaults" <?php echo ( $applyDefaults ? 'checked="checked"' : '' ); ?> />
<label for="applyDefaults"><?php _e( 'Enable these settings by default?', WSG_PLUGIN_DOMAIN ); ?></label>
</p>
<p class="description"><?php _e( 'IMPORTANT : The followig options are only applied when this option is enabled.', WSG_PLUGIN_DOMAIN ); ?></p>
</div>
</fieldset>
</div>

<div class="applyByDefault">
<fieldset>
<legend><?php _e( 'Default behaviour', WSG_PLUGIN_DOMAIN ); ?></legend>
<div class="field first">
<input id="applyByDefault" type="checkbox" name="applyByDefault" <?php echo ( $applyByDefault ? 'checked="checked"' : '' ); ?> />
<label for="applyByDefault"><?php _e( 'Apply by default.', WSG_PLUGIN_DOMAIN ); ?></label>
<p class="description"><?php _e( 'If this option is enabled, WunderSlider will be applied to all [gallery] shortcodes unless the <code>wunderslider="false"</code> attribute is added.', WSG_PLUGIN_DOMAIN ); ?></p>
<p class="description"><?php _e( 'If this option is disabled, WunderSlider will be applied only to those [gallery] shortcodes that explicitly add the <code>wunderslider="true"</code> attribute.', WSG_PLUGIN_DOMAIN ); ?></p>
</div>
</fieldset>
</div>

<?php if ( class_exists( 'nggdb') ) : ?>
<div class="nextgen">
<fieldset>
<legend><?php _e( 'NextGEN Gallery', WSG_PLUGIN_DOMAIN ); ?></legend>
<p><?php _e( 'You can use the [wunderslider_nggallery] shortcode to render galleries.', WSG_PLUGIN_DOMAIN ); ?></p>
<p><?php _e( 'To embed a NextGEN gallery you must specify the gallery id, for example: <code>[wunderslider_nggallery id=&quot;123&quot;]</code>', WSG_PLUGIN_DOMAIN ); ?></p>
<div class="field first">
<input id="nextgen" type="checkbox" name="nextgen" <?php echo ( isset( $nextgen['handle'] ) && $nextgen['handle'] ? 'checked="checked"' : '' ); ?> />
<label for="nextgen"><?php _e( 'Handle NextGEN Gallery shortcodes?', WSG_PLUGIN_DOMAIN ); ?></label>
<p class="description"><?php _e( 'If this option is enabled, WunderSlider will handle the NextGEN Gallery shortcodes and apply the following settings:', WSG_PLUGIN_DOMAIN ); ?></p>
</div>
<ul>
<li>
<div class="field">
<input id="nggallery" type="checkbox" name="nggallery" <?php echo ( ( isset( $nextgen['nggallery'] ) && $nextgen['nggallery'] ) ? 'checked="checked"' : '' ); ?> />
<label for="nggallery"><?php _e( 'Apply by default to [nggallery].', WSG_PLUGIN_DOMAIN ); ?></label>
<p class="description"><?php _e( 'If this option is enabled, WunderSlider will be applied to all [nggallery] shortcodes unless the <code>wunderslider="false"</code> attribute is added.', WSG_PLUGIN_DOMAIN ); ?></p>
<p class="description"><?php _e( 'If this option is disabled, WunderSlider will be applied only to those [nggallery] shortcodes that explicitly add the <code>wunderslider="true"</code> attribute.', WSG_PLUGIN_DOMAIN ); ?></p>
</div>
</li>
</ul>
</fieldset>
</div>
<?php else : ?>
<div class="nextgen">
<p><strong><?php _e( 'NextGEN Gallery', WSG_PLUGIN_DOMAIN ); ?></strong></p>
<p><?php _e( 'You do not have <a href="http://wordpress.org/extend/plugins/nextgen-gallery/">NextGEN Gallery</a> installed or activated. Settings related to NextGEN Gallery will be shown when the plugin is activated.', WSG_PLUGIN_DOMAIN ); ?></p>
</div>
<?php endif; ?>

<div class="randomize">
<fieldset>
<legend><?php _e( 'Randomize', WSG_PLUGIN_DOMAIN ); ?></legend>
<div class="field first">
<input id="randomize" type="checkbox" name="randomize" <?php echo ( $randomize ? 'checked="checked"' : '' ); ?> />
<label for="randomize"><?php _e( 'Randomize the order of appearance.', WSG_PLUGIN_DOMAIN ); ?></label>
</div>
</fieldset>
</div>

<div class="appearance">
<fieldset>
<legend><?php _e( 'Appearance', WSG_PLUGIN_DOMAIN ); ?></legend>
<div class="field first">
<label for="skin"><?php _e( 'Skin', WSG_PLUGIN_DOMAIN ); ?></label>
<select id="skin" name="skin">
<?php
	foreach( WSG_Utility::$skins as $key => $value ) {
		if ( $skin == $key ) {
			$selected = ' selected="selected" ';
		} else {
			$selected = '';
		}
		echo '<option ' . $selected . ' value="' . $key . '">' . __( $value, WSG_PLUGIN_DOMAIN ) . '</option>';
	}
?>
</select>
</div>

<div class="field">
<label for="overlay"><?php _e( 'Overlay', WSG_PLUGIN_DOMAIN ); ?></label>
<select id="overlay" name="overlay">
<option value="" <?php echo ( empty( $overlay ) ? ' selected="selected" ' : '' ); ?>>None</option>
<?php
	foreach( WSG_Utility::$overlays as $key => $value ) {
		$selected = $overlay == $key ? ' selected="selected" ' : '';
		echo '<option ' . $selected . ' value="' . $key . '">' . __( $value, WSG_PLUGIN_DOMAIN ) . '</option>';
	}
?>
</select>
</div>

<div class="field">
<label for="overlayOpacity"><?php _e( 'Overlay opacity', WSG_PLUGIN_DOMAIN ); ?></label>
<input id="overlayOpacity" type="text" name="overlayOpacity" value="<?php echo $overlayOpacity; ?>" />
</div>

<div class="field">

<p><strong><?php _e( 'Display mode', WSG_PLUGIN_DOMAIN ); ?></strong></p>

<input id="fullscreen" type="radio" name="render" value='fullscreen' <?php echo ( $render == 'fullscreen' ? 'checked="checked"' : '' ); ?> />
<label for="fullscreen"><?php _e( 'Fullscreen', WSG_PLUGIN_DOMAIN ); ?></label>

<input id="proportional" type="radio" name="render" value='proportional' <?php echo ( $render == 'proportional' ? 'checked="checked"' : '' ); ?> />
<label for="proportional"><?php _e( 'Proportional', WSG_PLUGIN_DOMAIN ); ?></label>

<input id="fixed" type="radio" name="render" value='fixed' <?php echo ( $render == 'fixed' ? 'checked="checked"' : '' ); ?> />
<label for="fixed"><?php _e( 'Fixed', WSG_PLUGIN_DOMAIN ); ?></label>

<p><em><?php _e( 'Proportional display mode', WSG_PLUGIN_DOMAIN ); ?></em></p>
<p class="description"><?php _e( 'If you choose <strong>proportional</strong> you must provide the container width and height explicitly along with the <code>[gallery]</code> shortcode.', WSG_PLUGIN_DOMAIN ); ?></p>
<p class="description"><?php _e( 'Example: <code>[gallery container_width="80%" height="360px"]</code> .', WSG_PLUGIN_DOMAIN ); ?></p>
</div>

</fieldset>
</div>

<?php if ( $render === 'fixed' ) :?>
<div class="dimensions">
<fieldset>

<legend><?php _e( 'Dimensions', WSG_PLUGIN_DOMAIN ); ?></legend>

<div class="field first">
<label for="width"><?php _e( 'Width', WSG_PLUGIN_DOMAIN ); ?></label>
<input id="width" type="text" name="width" value="<?php echo $width; ?>" />
</div>

<div class="field">
<label for="height"><?php _e( 'Height', WSG_PLUGIN_DOMAIN ); ?></label>
<input id="height" type="text" name="height" value="<?php echo $height; ?>" />
</div>

</fieldset>
</div>
<?php endif; ?>

<div class="controls">
<fieldset>

<legend><?php _e( 'Controls', WSG_PLUGIN_DOMAIN ); ?></legend>

<div class="field first">
<input id="useCaption" type="checkbox" name="useCaption" <?php echo ( $useCaption ? 'checked="checked"' : '' ); ?> />
<label for="useCaption"><?php _e( 'Show caption', WSG_PLUGIN_DOMAIN ); ?></label>
</div>

<div class="field">
<input id="useSelectors" type="checkbox" name="useSelectors" <?php echo ( $useSelectors ? 'checked="checked"' : '' ); ?> />
<label for="useSelectors"><?php _e( 'Show slide selector buttons', WSG_PLUGIN_DOMAIN ); ?></label>
</div>

<div class="field">
<input id="useNav" type="checkbox" name="useNav" <?php echo ( $useNav ? 'checked="checked"' : '' ); ?> />
<label for="useNav"><?php  _e( 'Show next/previous buttons', WSG_PLUGIN_DOMAIN ); ?></label>
</div>

<div class="field">
<input id="useFlick" type="checkbox" name="useFlick" <?php echo ( $useFlick ? 'checked="checked"' : '' ); ?> />
<label for="useFlick" title="<?php _e( 'If flicking is enabled, images are not linked - captions can still be linked', WSG_PLUGIN_DOMAIN ); ?>"><?php _e( 'Enable flicking', WSG_PLUGIN_DOMAIN ); ?></label>
</div>

<div class="field">
<input id="mouseOverPause" type="checkbox" name="mouseOverPause" <?php echo ( $mouseOverPause ? 'checked="checked"' : '' ); ?> />
<label for="mouseOverPause"><?php _e( 'Cursor over slideshow pauses', WSG_PLUGIN_DOMAIN ); ?></label>
</div>

</fieldset>
</div>

<div class="transitions">
<fieldset>

<legend><?php _e( 'Transitions', WSG_PLUGIN_DOMAIN ); ?></legend>

<div class="field first">
<label for="effect"><?php _e( 'Effect', WSG_PLUGIN_DOMAIN ); ?></label>
<select id="effect" name="effect">
<?php
	foreach( WSG_Utility::$effects as $key => $value ) {
		if ( $effect == $key ) {
			$selected = ' selected="selected" ';
		} else {
			$selected = '';
		}
		echo '<option ' . $selected . ' value="' . $key . '">' . __( $value, WSG_PLUGIN_DOMAIN ) . '</option>';
	}
?>
</select>
</div>

<div class="field">
<label class="hzones" for="hzones" title="<?php _e( 'Number of horizontal zones', WSG_PLUGIN_DOMAIN ); ?>"><?php _e( 'Horizontal blocks', WSG_PLUGIN_DOMAIN ); ?></label>
<select id="hzones" class="hzones" name="hzones" title="<?php _e( 'Number of horizontal zones', WSG_PLUGIN_DOMAIN ); ?>">
<option value="random" <?php echo ( $hzones == 'random' ? ' selected="selected" ' : '' ); ?>><?php _e( 'Random', WSG_PLUGIN_DOMAIN ); ?></option>
<?php
	for ( $i = 1; $i <= WS_MAX_ZONES; $i++ ) {
		$selected = $hzones == $i ? ' selected="selected" ' : '';
		echo '<option ' . $selected . ' value="' . $i . '">' . $i . '</option>';
	}
?>
</select>
</div>

<div class="field">
<label class="vzones" for="hzones" title="<?php _e( 'Number of vertical zones, &quot;Auto&quot; adjusts for square blocks.', WSG_PLUGIN_DOMAIN ); ?>"><?php _e( 'Vertical blocks', WSG_PLUGIN_DOMAIN ); ?></label>
<select id="vzones" class="vzones" name="vzones" title="<?php _e('Number of vertical zones, &quot;Auto&quot; adjusts for square blocks.', WSG_PLUGIN_DOMAIN ); ?>">
<option value="" <?php echo ( empty( $vzones ) ? ' selected="selected" ' : '' ); ?>><?php _e( 'Auto', WSG_PLUGIN_DOMAIN ); ?></option>
<option value="random" <?php echo ( $vzones == 'random' ? ' selected="selected" ' : '' ); ?>><?php _e( 'Random', WSG_PLUGIN_DOMAIN ); ?></option>
<?php
	for ( $i = 1; $i <= WS_MAX_ZONES; $i++ ) {
		$selected = $vzones == $i ? ' selected="selected" ' : '';
		echo '<option ' . $selected . ' value="' . $i . '">' . $i . '</option>';
	}
?>
</select>
</div>

<div class="field period">
<label for="period" title="<?php _e( 'How long to switch to the next image in ms.', WSG_PLUGIN_DOMAIN ); ?>"><?php _e( 'Period', WSG_PLUGIN_DOMAIN ); ?></label>
<input id="period" type="text" name="period" title="<?php _e( 'How long to switch to the next image in ms.', WSG_PLUGIN_DOMAIN ); ?>" value="<?php echo $period; ?>" />
</div>

<div class="field duration">
<label for="duration" title="<?php _e( 'Duration of the transition effect in ms.', WSG_PLUGIN_DOMAIN ); ?>"><?php _e( 'Duration', WSG_PLUGIN_DOMAIN ); ?></label>
<input id="duration" type="text" name="duration" title="<?php _e( 'Duration of the transition effect in ms.', WSG_PLUGIN_DOMAIN ); ?>" value="<?php echo $duration; ?>" />
</div>

<div class="field fps">
<label for="fps" title="<?php _e( 'Frames per second, animation framerate.', WSG_PLUGIN_DOMAIN ); ?>"><?php _e( 'FPS', WSG_PLUGIN_DOMAIN ); ?></label>
<input id="fps" type="text" name="fps" title="<?php _e( 'Frames per second, animation framerate.', WSG_PLUGIN_DOMAIN ); ?>" value="<?php echo $fps; ?>" />
</div>

<div class="field animateInterval">
<label for="animateInterval" title="<?php _e( 'Length of block animations in ms.', WSG_PLUGIN_DOMAIN ); ?>"><?php _e( 'Animate', WSG_PLUGIN_DOMAIN ); ?></label>
<input id="animateInterval" type="text" name="animateInterval" title="<?php _e( 'Length of the animation in ms.', WSG_PLUGIN_DOMAIN ); ?>" value="<?php echo $animateInterval; ?>" />
</div>

</fieldset>
</div>

<div class="spread-the-word">
<fieldset>
<legend><?php _e( 'Spread the word and usage data', WSG_PLUGIN_DOMAIN ); ?></legend>
<div class="field first">
<p>
<input id="hideLogo" type="checkbox" name="hideLogo" <?php echo ( !$hideLogo ? 'checked="checked"' : '' ); ?> />
<label for="hideLogo"><?php _e( 'Show the WunderSlider logo?', WSG_PLUGIN_DOMAIN ); ?></label>
</p>
<p class="description"><?php _e( 'If this option is enabled, the small WunderSlider logo will be shown on those pages where it is used on. This helps to spread the word about WunderSlider, to continue its development and add new improvements.', WSG_PLUGIN_DOMAIN ); ?></p>
</div>
<div class="field">
<p>
<input id="silent" type="checkbox" name="silent" <?php echo ( !$silent ? 'checked="checked"' : '' ); ?> />
<label for="silent"><?php _e( 'Allow WunderSlider to send usage data?', WSG_PLUGIN_DOMAIN ); ?></label>
</p>
<p class="description"><?php _e( 'If this option is enabled, WunderSlider will send usage data which consists of indicating the URL of the site it is used on. This allows to better assess the amount of sites it is used on.', WSG_PLUGIN_DOMAIN ); ?></p>
</div>
</fieldset>
</div>

<div class="buttons">
<?php wp_nonce_field( 'admin', WSG_NONCE, true, true ); ?>
<input type="hidden" name="action" value="set" />
<input class="apply button" type="submit" name="submit" value="<?php echo __( 'Apply', WSG_PLUGIN_DOMAIN ); ?>" />
</div>

</div>
</form>
</div>

<div class="separator"></div>

<?php
	echo 
		'<h3>' . __( 'Reset', WSG_PLUGIN_DOMAIN ) . '</h3>' .
		'<p>' . __( 'The options will be set to their default values.', WSG_PLUGIN_DOMAIN ) . '</p>';
?>

<div class="settings-reset">
<form name="reset" method="post" action="">
<div class="buttons">
<?php wp_nonce_field( 'admin', WSG_NONCE, true, true ); ?>
<input type="hidden" name="action" value="reset" />
<input class="reset button" type="submit" name="submit" value="<?php echo __( 'Reset', WSG_PLUGIN_DOMAIN ); ?>" />
</div>
</form>

<br/>

<div class="separator"></div>

<?php
	echo '<h3>' . __( 'Hints', WSG_PLUGIN_DOMAIN ). '</h3>';
	echo '<h4>' . __( 'Showing an alternative when Javascript is disabled', WSG_PLUGIN_DOMAIN ) . '</h4>';
	echo '<p>' . __( 'Assuming that WunderSlider is enabled by default, the following will render the standard WordPress gallery when Javascript is disabled.', WSG_PLUGIN_DOMAIN ) . '</p>';
	echo '<code>';
	echo htmlentities('[gallery]');
	echo '<br/>';
	echo htmlentities('<noscript>[gallery wunderslider="false"]</noscript>');
	echo '</code>';
?>
</div>
