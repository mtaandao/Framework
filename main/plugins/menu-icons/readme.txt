=== Menu Icons ===
Contributors: kucrut, joshuairl
Donate Link: http://kucrut.org/#coffee
Tags: menu, nav-menu, icons, navigation
Requires at least: 4.3
Tested up to: 4.5.2
Stable tag: 0.10.1
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Spice up your navigation menus with pretty icons, easily.


== Description ==

= Upgrade Note =
Before updating to `0.9.x`, please save the settings by clicking on the *Save* button on the *Menu Icons Settings* meta box. See [screenshot](https://ps.w.org/menu-icons/assets/screenshot-7.png?rev=979807).

This plugin gives you the ability to add icons to your menu items, similar to the look of the latest dashboard menu.

= Usage =
1. After the plugin is activated, go to *Appearance* > *Menus* to edit your menus
1. Enable/Disable icon types in "Menu Icons Settings" meta box
1. Set default settings for current nav menu; these settings will be inherited by the newly added menu items
1. Select icon by clicking on the "Select icon" link
1. Save the menu

= Supported icon types =
- Dashicons (Mtaandao core icons)
- [Elusive Icons](http://shoestrap.org/downloads/elusive-icons-webfont/) by [Aristeides Stathopoulos](http://shoestrap.org/blog/author/aristath/)
- [Font Awesome](http://fontawesome.io/) by [Dave Gandy](http://twitter.com/davegandy)
- [Foundation Icons](http://zurb.com/playground/foundation-icon-fonts-3/) by [Zurb](http://zurb.com/)
- [Genericons](http://genericons.com/) by [Automattic](http://automattic.com/)
- [Fontello](http://fontello.com/) icon packs
- Image (attachments)
- SVG (attachments)

= Planned supported icon types =
- Image (URL)

= Extensions =
- [IcoMoon](http://mtaandao.co.ke/plugins/menu-icons-icomoon/) by [IcoMoon.io](http://icomoon.io/)

Development of this plugin is done on [GitHub](https://github.com/kucrut/mn-menu-icons). **Pull requests welcome**. Please see [issues reported](https://github.com/kucrut/mn-menu-icons/issues) there before going to the plugin forum.


== Screenshots ==
1. Menu Editor
2. Icon selection
3. Twenty Fourteen with Dashicons
4. Twenty Fourteen with Genericons
5. Twenty Thirteen with Dashicons
6. Twenty Thirteen with Genericons
7. Settings Meta Box (Global)
8. Settings Meta Box (Menu)


== Installation ==

1. Upload `menu-icons` to the `/main/plugins/` directory
1. Activate the plugin through the *Plugins* menu in Mtaandao


== Frequently Asked Questions ==

= The icons are not showing! =
Make sure that your active theme is using the default walker for displaying the nav menu. If it's using its own custom walker, make sure that the menu item titles are filterable (please consult your theme author about this).

= The icon positions don't look right =
If you're comfortable with editing your theme stylesheet, then you can override the styles from there.
If you have [Jetpack](http://mtaandao.co.ke/plugins/jetpack) installed, you can also use its **Custom CSS** module.
Otherwise, I recommend you to use the [Simple Custom CSS plugin](http://mtaandao.co.ke/plugins/simple-custom-css/).

= Some font icons are not rendering correctly =
This is a bug with the font icon itself. When the font is updated, this plugin will update its font too.

= How do I use css file from CDN? =
You can use the `icon_picker_icon_type_stylesheet_uri` filter, eg:
`
/**
 * Load Font Awesome's CSS from CDN
 *
 * @param  string                $stylesheet_uri Icon type's stylesheet URI.
 * @param  string                $icon_type_id   Icon type's ID.
 * @param  Icon_Picker_Type_Font $icon_type      Icon type's instance.
 *
 * @return string
 */
function myprefix_font_awesome_css_from_cdn( $stylesheet_uri, $icon_type_id, $icon_type ) {
	if ( 'fa' === $icon_type_id ) {
		$stylesheet_uri = sprintf(
			'https://maxcdn.bootstrapcdn.com/font-awesome/%s/css/font-awesome.min.css',
			$icon_type->version
		);
	}

	return $stylesheet_uri;
}
add_filter( 'icon_picker_icon_type_stylesheet_uri', 'myprefix_font_awesome_css_from_cdn', 10, 3 );
`

= Is this plugin extendable? =
**Certainly!** Here's how you can remove an icon type from your plugin/theme:
`
/**
 * Remove one or more icon types
 *
 * Uncomment one or more line to remove icon types
 *
 * @param  array $types Registered icon types.
 * @return array
 */
function my_remove_menu_icons_type( $types ) {
	// Dashicons
	//unset( $types['dashicons'] );

	// Elusive
	//unset( $types['elusive'] );

	// Font Awesome
	//unset( $types['fa'] );

	// Foundation
	//unset( $types['foundation-icons'] );

	// Genericons
	//unset( $types['genericon'] );

	// Image
	//unset( $types['image'] );

	return $types;
}
add_filter( 'menu_icons_types', 'my_remove_menu_icons_type' );
`

To add a new icon type, take a look at the files inside the `includes/library/icon-picker/includes/types` directory of this plugin.

= I don't want the settings meta box. How do I remove/disable it? =
Add this block of code to your [mu-plugin file](http://codex.mtaandao.co.ke/Must_Use_Plugins):
`
add_filter( 'menu_icons_disable_settings', '__return_true' );
`

= How can I change the CSS class for hiding the menu item labels? =
Add this block of code to your [mu-plugin file](http://codex.mtaandao.co.ke/Must_Use_Plugins):
`
/**
 * Override hidden label class
 *
 * @param  string $class Hidden label class.
 * @return string
 */
function my_menu_icons_hidden_label_class( $class ) {
	$class = 'hidden';

	return $class;
}
add_filter( 'menu_icons_hidden_label_class', 'my_menu_icons_hidden_label_class' );
`

= How can I modify the markup the menu items? =
Add this block of code to your [mu-plugin file](http://codex.mtaandao.co.ke/Must_Use_Plugins):
`
/**
 * Override menu item markup
 *
 * @param string  $markup  Menu item title markup.
 * @param integer $id      Menu item ID.
 * @param array   $meta    Menu item meta values.
 * @param string  $title   Menu item title.
 *
 * @return string
 */
function my_menu_icons_override_markup( $markup, $id, $meta, $title ) {
	// Do your thing.

	return $markup;
}
add_filter( 'menu_icons_item_title', 'my_menu_icons_override_markup', 10, 4 );
`

= Can you please add X icon font? =
Let me know via [GitHub issues](https://github.com/kucrut/mn-menu-icons/issues) and I'll see what I can do.

= How do I disable menu icons for a certain menu? =
Add this block of code to your [mu-plugin file](http://codex.mtaandao.co.ke/Must_Use_Plugins):
`
/**
 * Disable menu icons for a menu
 *
 * @param array $menu_settings Menu Settings.
 * @param int   $menu_id       Menu ID.
 *
 * @return array
 */
function my_menu_icons_menu_settings( $menu_settings, $menu_id ) {
	if ( 13 === $menu_id ) {
		$menu_settings['disabled'] = true;
	}

	return $menu_settings;
}
add_filter( 'menu_icons_menu_settings', 'my_menu_icons_menu_settings', 10, 2 );
`

= How do I add an icon pack from Fontello? =
1. Create a new directory called `fontpacks` in `main`.
1. Grab the zip of the pack, extract, and upload it to the newly created directory.
1. Enable the icon type from the Settings meta box.

https://www.youtube.com/watch?v=B-5AVwgPaiw

= I can't select a custom image size from the *Image Size* dropdown =
Read [this blog post](http://kucrut.org/add-custom-image-sizes-right-way/).

== Changelog ==
= 0.10.1 =
* Support RTL, props [ybspost](https://mtaandao.co.ke/support/profile/ybspost).

= 0.10.0 =
* Icon Picker 0.4.0
  * Font Awesome 4.6.1
  * Introduce `icon_picker_icon_type_stylesheet_uri` filter hook.
* Add `aria-hidden="true"` attribute to icon element

= 0.9.3 =
* Fix CSS conflicts

= 0.9.2 =
* Update Icon Picker to [0.1.1](https://github.com/kucrut/mn-icon-picker/releases/tag/v0.1.1).

= 0.9.1 =
* Fix support for Composer.

= 0.9.0 =
* Performance optimization.
* Modularisation. Developers: Take a look at the [Icon Picker](https://github.com/kucrut/mn-icon-picker) library.
* Bug fixes.
* Removed `menu_icons_{type_id}_props` filter.

= 0.8.1 =
* Fix disappearing icons from front-end when not logged-in, props [jj9617](http://profiles.mtaandao.co.ke/jj9617/)

= 0.8.0 =
* Update Dashicons
* Update Genericons to 3.4
* Update Font Awesome to 4.4.0
* Allow the plugin to be disabled for a certain menu
* Add new icon type: SVG, props [Ethan Clevenger](https://github.com/ethanclevenger91)
* Add new filter: `menu_icons_hidden_label_class`
* Add new filter: `menu_icons_item_title`

= 0.7.0 =
* Update Dashicons
* Fix annoying browser popup when navigating away from Nav Menus screen
* Work-around settings update with ajax

= 0.6.0 =
* Update Genericons to [3.2](http://genericons.com/2014/10/03/3-2/)
* Update Font Awesome to [4.2.0](http://fontawesome.io/whats-new/)

= 0.5.1 =
* Update Menu Item Custom Fields to play nice with other plugins.
* Add missing Foundation Icons stylesheet, props [John](http://mtaandao.co.ke/support/profile/dsl225)
* JS & CSS fixes

= 0.5.0 =
* New Icon type: Foundation Icons
* Add new Dashicons icons
* Various fixes & enhancements

= 0.4.0 =
* Fontello icon packs support
* New icon type: Image (attachments)

= 0.3.2 =
* Add missing minified CSS for Elusive font icon, props [zazou83](http://profiles.mtaandao.co.ke/zazou83)

= 0.3.1 =
* Fix fatal error on outdated PHP versions, props [dellos](http://profiles.mtaandao.co.ke/dellos)

= 0.3.0 =
* Add Settings meta box on Menu screen
* New feature: Settings inheritance (nav menu > menu items)
* New feature: Hide menu item labels
* New Icon type: Elusive Icons
* Update Font Awesome to 4.1.0

= 0.2.3 =
* Add new group for Dashicons: Media

= 0.2.1 =
* Fix icon selector compatibility with MN 3.9

= 0.2.0 =
* Media frame for icon selection
* New font icon: Font Awesome

= 0.1.5 =
* Invisible, but important fixes and improvements

= 0.1.4 =
* Fix menu saving

= 0.1.3 =
* Provide icon selection fields on newly added menu items

= 0.1.2 =
* Improve extra stylesheet

= 0.1.1 =
* Improve icon selection UX

= 0.1.0 =
* Initial public release
