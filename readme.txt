=== Debug Bar for Sophi ===
Contributors:      10up, sophidev
Tags:              Sophi, Debug Bar
Requires at least: 5.6
Tested up to:      6.0
Stable tag:        0.2.0
Requires PHP:      7.4
License:           GPLv2 or later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html

Extends the Debug Bar plugin for the Sophi.io Site Automation service.

== Description ==

Extends the Debug Bar plugin for the [Sophi.io](https://www.sophi.io/) Site Automation service.  After installing and activating, click the `Debug` button in the admin toolbar.  Within the Debug Bar Panel, click the `Sophi` panel.

Note that the Debug Bar for Sophi plugin does not show the Sophi JavaScript Tracking activity in the Debug Bar as that's something that can be viewed with a browser console's `Network` tab.  Otherwise you should be able to view the Sophi Authentication request/response, Sophi API request/response, and CMS publish/update events in the Debug Bar to help triage your Sophi integration.

== Requirements ==

* PHP 7.4+
* WordPress 5.6+
* [Sophi](https://wordpress.org/plugins/sophi/) 1.1.0+
* [Debug Bar](https://wordpress.org/plugins/debug-bar/) 1.0+ (note that this is already included on [WordPress VIP](https://wpvip.com/))

== Installation ==

1. Install the [Sophi](https://wordpress.org/plugins/sophi) plugin.
1. Install the [Debug Bar](https://wordpress.org/plugins/debug-bar/) plugin.  Note that this is already included on [WordPress VIP](https://wpvip.com/).
1. Install the Debug Bar for Sophi plugin via the plugin installer, either by searching for it or uploading a ZIP file.
1. Activate all three plugins.

== Changelog ==

= 0.2.0 - 2022-05-17 =
* **Added:** Support for [WordPress VIP](https://wpvip.com/) to force enable the Debug Bar plugin on their platform (props [@cadic](https://github.com/cadic), [@jeffpaul](https://github.com/jeffpaul)).
* **Added:** New setting to "Disable WordPress caching of Sophi content" to force request/response with Sophi API (props [@cadic](https://github.com/cadic), [@jeffpaul](https://github.com/jeffpaul)).
* **Added:** New Tools > "Sophi Logs" page to output raw Sophi logs (props [@cadic](https://github.com/cadic), [@jeffpaul](https://github.com/jeffpaul)).
* **Added:** Documentation updates (props [@jeffpaul](https://github.com/jeffpaul)).
* **Fixed:** Deploy to WordPress.org GitHub Action (props [@cadic](https://github.com/cadic), [@jeffpaul](https://github.com/jeffpaul)).
* **Fixed:** Catch `JSON.parse` exception if the plugin outputs empty JSON request or response (props [@cadic](https://github.com/cadic)).

= 0.1.0 - 2022-05-10 =
* Initial release of the Debug Bar for Sophi.io plugin. 🎉
