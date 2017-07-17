=== DMG Post Archives Widget ===
Contributors: dancoded
Tags: archives widget, menu, css, list archives, monthly
Donate link: http://dancoded.com/wordpress-plugins
Requires at least: 3.1
Tested up to: 4.6
Stable tag: 1.0
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl.html

Displays monthly archives as a list or dropdown jump-menu with advanced options to add CSS classes, modify the title & add custom HTML/ Text.

== Description ==

Display monthly archives as a list of links or a dropdown jump-menu (automatically navigate to page when selected).

Includes advanced options to display post counts, add CSS styles and modify the title.

Replaces the built in Archives Widget (WP_Widget_Archives).

A hook is available to filter the title: `dmg_archives_widget_title`.

For example, to change the title on a single page or post, you could add this to your functions.php file:


`function myTitleFilter( $title )
{
	if( is_singular() )
	{
		return "<strong>$title</strong>";
	}
	else
	{
		return $title;		
	}
}
add_filter( 'dmg_archives_widget_title' , 'myTitleFilter');`

More information about this plugin can be found at <http://dancoded.com/wordpress-plugins/archives-widget/>.

== Installation ==
1. Upload the plugin files to the `/wp-content/plugins/dmg-archives-widget` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' page in the WordPress admin area
1. Drag onto any active sidebar on the 'Appearance > Widgets' page

== Changelog ==
= 1.0 =
* Initial version