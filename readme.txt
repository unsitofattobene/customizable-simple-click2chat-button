=== Customizable Simple Click2Chat Button ===
Contributors: violaniccolai
Website link: https://www.unsitofattobene.it
Tags: chat, button, floating button, contact, click to chat
Requires at least: 5.2
Tested up to: 6.9
Requires PHP: 7.2
Stable tag: 1.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Add a WhatsApp animated button that matches your brand. Customizable colors, position, visibility and pre-filled message.

== Description ==

"Customizable Simple Click2Chat Button" adds a floating chat icon to your website, allowing visitors to contact you with a single click.

**Features:**

* Fully customizable colors (bubble, handset, and ring — independently)
* Configurable pre-filled message
* Adjustable position (top/bottom, left/right) with pixel offset
* Customizable icon size
* Per-device visibility (desktop, tablet, mobile)
* Live preview in the admin panel
* Zero JavaScript on the frontend — pure HTML and CSS
* Inline SVG for optimal performance
* Translation-ready with Italian translation included

== Installation ==

1. Upload the plugin folder to `/wp-content/plugins/`
2. Activate the plugin from the WordPress "Plugins" menu
3. Go to "Click2Chat" in the admin menu
4. Enter your phone number with international prefix (e.g. 39333123456)
5. Customize colors, position, and visibility

== Frequently Asked Questions ==

= How do I enter the phone number? =

Enter the full number with the international prefix, without spaces, dashes, or the + sign. For example: 39333123456.

= Can I customize the message that appears in the chat? =

Yes, in the "Pre-filled message" field you can write the text that will be automatically inserted into the visitor's chat.

= Does the plugin slow down my site? =

No. The plugin loads no JavaScript on the frontend, makes no additional HTTP requests, and uses an inline SVG. The performance impact is virtually zero.

== Screenshots ==

1. Admin panel with live preview
2. Chat button on the site

== Upgrade Notice ==

= 1.2 =
Removed deprecated function flagged by Plugin Check.

= 1.1 =
New admin features, cache busting, and preview improvements.

= 1.0 =
Initial release.

== Changelog ==

= 1.2 =
* Removed deprecated load_plugin_textdomain() call (translations are now loaded automatically by WordPress)

= 1.1 =
* Added "Customize" action link in the plugins list for quick access to settings
* Automatic page cache purge on settings save (supports WP Rocket, LiteSpeed, WP Super Cache, W3 Total Cache, WP Fastest Cache, Autoptimize, SG Optimizer)
* Cache warning notice below the save button
* Fixed shadow not showing in admin preview on page load
* Changed default shadow color to #787878 (gray)
* Added dark background toggle in admin preview
* Added notice about phone number requirement
* Added Italian translations for all new strings

= 1.0 =
* Initial release
