=== WunderSlider Gallery ===
Contributors: itthinx
Donate link: http://www.itthinx.com/wunderslider
Tags: banner rotator, effects, flick, flicking, fullscreen, gallery, image, images, image slider, itthinx, javscript, jquery, media, nextgen, nextgen gallery, photo, photo album, photo albums, photos, picture pictures, plugin, responsive, resizeable, slider, slideshow, swipe, swiping, swish, touch, touch enabled, wipe, wordpress, wunderslider, wunderslider gallery
Requires at least: 3.3
Tested up to: 3.4.1
Stable tag: 1.3.2
License: GPLv3

WunderSlider Gallery turns default WordPress and NextGEN galleries into responsive fullscreen and embedded WunderSlider slideshows.

== Description ==

This plugin provides an automated way to convert any standard WordPress gallery that is embedded on a page using the [gallery] shortcode into a *WunderSlider*.

WunderSlider Gallery also supports [NextGEN Gallery](http://wordpress.org/extend/plugins/nextgen-gallery/) to embed any gallery as a *WunderSlider* using the [wunderslider_nggallery] shortcode or by enabling it as the default renderer for the [nggallery] shortcode. 

The plugin requires the *WunderSlider* which is available freely for personal use and can be downloaded on the [WunderSlider](http://www.itthinx.com/wunderslider/) page.

A license is required to be purchased for commercial use, see the WunderSlider page for more details.

__Feedback__ is welcome.
If you want to leave feedback or want to provide constructive criticism, please do so at the support pages indicated below.

Please try to solve problems there before you rate this plugin or say it doesn't work.

Limited* free support is provided on the [WunderSlider](http://www.itthinx.com/wunderslider/) page __only__. Please be specific when stating any issues you might experience. * Limited means: thank you for your feedback and please be patient as you should get an answer as soon as possible.

[Follow WunderSlider on Twitter](http://twitter.com/wunderslider) for updates on the WunderSlider and its plugins.

[Follow itthinx on Twitter](http://twitter.com/itthinx) for updates on this and other plugins.

__Usage / Notes on settings__

After you have followed the instructions on installing *WunderSlider* and the *WunderSlider Gallery* plugin, go to __Appearance > WunderSlider Gallery__ and have a look at the default settings.

 `[gallery]` shortcode attributes :

- The `size` attribute uses `full` by default. Set it to another size if you don't need the full image size.

  Default sizes are `thumbnail`, `medium`, `large` and `full`.

- WunderSlider attributes that use a dash in the attribute name must be used with an underscore instead when passed to the `[gallery]` shortcode. If used, `container-class`, `container-style`, `container-height` and `container-width` must be passed as `container_class`, `container_style`, `container_height` and `container_width` to the `[gallery]` shortcode.
  This is especially important when the `display="proportional"` setting is used, as you will have to provide the container width and height explicitly.
  
  Example:
  
  `[gallery display="proportional" container_width="80%" height="360px"]` 

- If you do *not* want the WunderSlider applied to a specific gallery, you must add the `wunderslider="false"` attribute, for example:
 
  `[gallery wunderslider="false"]`
  
__Usage with [NextGEN Gallery](http://wordpress.org/extend/plugins/nextgen-gallery/)__

Any NextGEN gallery can be rendered as a *WunderSlider* using the `[wunderslider_nggallery]` shortcode or by enabling defaults for NextGEN Gallery shortcodes in the __Appearance > WunderSlider Gallery__ settings. 

Example: 

  `[wunderslider_nggallery id="123"]` will render a WunderSlider for the NextGEN gallery with id 123.

The [nggallery] shortcode can be rendered as a WunderSlider by either enabling it by default or by specifying:

`[nggallery id="123" wunderslider="true"]`

For this to take effect, the option to handle NextGEN Gallery shortcodes must be enabled on the settings page __Appearance > WunderSlider Gallery__.

As with the `[gallery]` shortcode, any WunderSlider attributes can be passed to `[wunderslider_nggallery]` or `[nggallery]` - those that use a dash in the attribute name must be used with an underscore instead: `container-class`, `container-style`, `container-height` and `container-width` must be passed as `container_class`, `container_style`, `container_height` and `container_width`.

Examples:

- `[wunderslider_nggallery id="1" container_width="80%" container_height="300px" display="proportional"]`
- `[nggallery id="1" wunderslider="true" container_width="80%" container_height="300px" display="proportional"]`


== Installation ==

1. Obtain a free personal or licensed commercial copy of the [WunderSlider](http://www.itthinx.com/wunderslider/) and unzip it. You will find the *WunderSlider* plugin in the `wordpress` folder.
2. Upload and activate the *WunderSlider* plugin. You can use the *Add new* option found in the *Plugins* menu in WordPress.   
3. Upload and activate the *WunderSlider Gallery* plugin from the *Plugins* menu in WordPress.
4. Create a page or post, upload some images there and insert the gallery. View that page, you will have WunderSlider render it.
5. Read the WunderSlider manual.
6. No really, READ IT.
7. Go to __Appearance > WunderSlider Gallery__ and adjust the default settings.

== Frequently Asked Questions ==

= What is the purpose of this plugin? =

This plugin provides an automated way to convert any standard WordPress gallery that is embedded on a page using the [gallery] shortcode into a WunderSlider.

This plugin requires the [WunderSlider](http://www.itthinx.com/wunderslider/) - either a free personal or a licensed commercial copy.

Installing this plugin without the [WunderSlider](http://www.itthinx.com/wunderslider/) is a bit pointless, so get yourself a copy and follow the installation instructions.

= Where can I see a demo? =

- [WunderSlider Demo](http://www.wunderslider.com/)
- [WunderSlider WordPress Demo](http://wunderslider.com/wordpress/)

= What's the difference between the free personal version and the licensed commercial version? =

In features, there is *no* difference at all.

The main difference is that you are not allowed to use the free version for commercial purposes.

Please refer to [WunderSlider](http://www.itthinx.com/wunderslider/) for details on that.

By default, the free personal version will place a small icon on pages where it is used and send usage data, if you don't want that, you can turn these off on the Appearance > WunderSlider Gallery settings page in the admin section. 

== Screenshots ==

See the [WunderSlider Demo](http://www.wunderslider.com/) and the [WunderSlider WordPress Demo](http://wunderslider.com/wordpress/). 

== Changelog ==

= 1.3.2 =
* awareness release - no changes to this plugin but WS Javascript bug fixes require update

= 1.3.1 =
* improved WordPress shortcode handling
* fixed NextGEN shortcode handling logic
* fixed fatal error when id is missing in [nggallery] shortcode

= 1.3.0 =
* added support for NextGEN Gallery
* fixed underscore attribute rewrite
* fixed remnant debugging trace
* separated ids for containers derived from [gallery] shortcodes

= 1.2.1 =
* Added a hints section with recommendation for alternatives when Javascript is disabled.

= 1.2.0 =
* Added German translation.
* Enabled translations.

= 1.1.1 =
* Improved script loading on multiple instances.

= 1.1.0 =
* Added the option to apply WunderSlider by default to `[gallery]` shortcodes or not.

= 1.0.0 =
* Initial release

== Upgrade Notice ==

= 1.3.2 =
* Bug fixes - Please also update the WunderSlider base plugin - Personal license: download from http://www.itthinx.com/wunderslider/ - Commercial License: download from http://www.itthinx.com/downloads/

= 1.3.1 =
* Important improvements and bug fixes, please update.

= 1.3.0 =
* This release adds support for NextGEN Gallery and fixes bugs.

= 1.2.1 =
* Added a hints section with recommendation for alternatives when Javascript is disabled.

= 1.2.0 =
* Update to enable translations. German translation added.

= 1.1.1 =
* Update: Improved script loading on multiple instances.

= 1.1.0 =
* If you want to apply WunderSlider to only a few galleries: this update adds the option to apply WunderSlider by default to `[gallery]` shortcodes or not.

= 1.0.0 =
* Initial release
