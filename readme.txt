=== Debug Bar for Sophi ===
Contributors:      10up, sophidev, cadic, jeffpaul
Tags:              Sophi, Debug Bar
Requires at least: 5.6
Tested up to:      6.0
Stable tag:        0.3.0
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
* [Debug Bar](https://wordpress.org/plugins/debug-bar/) 1.0+
  * The Debug Bar for Sophi plugin has been tested up to Debug Bar version 1.1.3, compatibility with later versions is not guaranteed
  * This plugin is already included on [WordPress VIP](https://wpvip.com/)

== Installation ==

1. Install the [Sophi](https://wordpress.org/plugins/sophi) plugin.
1. Install the [Debug Bar](https://wordpress.org/plugins/debug-bar/) plugin.  Note that this is already included on [WordPress VIP](https://wpvip.com/).
1. Install the Debug Bar for Sophi plugin via the plugin installer, either by searching for it or uploading a ZIP file.
1. Activate all three plugins.

== Changelog ==

= 0.3.0 - 2022-07-07 =
* **Added:** Link to Sophi.io Settings in plugin actions (props [@cadic](https://github.com/cadic), [@jeffpaul](https://github.com/jeffpaul) via [#32](https://github.com/globeandmail/debug-bar-for-sophi/pull/32)).
* **Added:** Documentation updates (props [@jeffpaul](https://github.com/jeffpaul), [@YMufleh](https://github.com/YMufleh) via [#30](https://github.com/globeandmail/debug-bar-for-sophi/pull/30)).
* **Added:** [Mend Bolt](https://github.com/apps/mend-bolt-for-github) and [Renovate](https://togithub.com/renovatebot/renovate) bots (props [@mend-bolt-for-github](https://github.com/apps/mend-bolt-for-github), [@renovate](https://github.com/apps/renovate) via [#35](https://github.com/globeandmail/debug-bar-for-sophi/pull/35), [#36](https://github.com/globeandmail/debug-bar-for-sophi/pull/36)).
* **Changed:** Settings page updates (props [@cadic](https://github.com/cadic), [@jeffpaul](https://github.com/jeffpaul) via [#33](https://github.com/globeandmail/debug-bar-for-sophi/pull/33)).
* **Removed:** `react-dom` and `prop-types` dependencies as not needed (props [@cadic](https://github.com/cadic) via [#31](https://github.com/globeandmail/debug-bar-for-sophi/pull/31)).
* **Fixed:** PHP Notice on empty request body (props [@cadic](https://github.com/cadic), [@jeffpaul](https://github.com/jeffpaul) via [#27](https://github.com/globeandmail/debug-bar-for-sophi/pull/27)).
* **Fixed:** Debug records horizontal overflow (props [@cadic](https://github.com/cadic), [@jeffpaul](https://github.com/jeffpaul) via [#29](https://github.com/globeandmail/debug-bar-for-sophi/pull/29)).
* **Fixed:** Missing text domain for "Sophi.io Logs" page title (props [@cadic](https://github.com/cadic), [@jeffpaul](https://github.com/jeffpaul) via [#33](https://github.com/globeandmail/debug-bar-for-sophi/pull/33)).
* **Fixed:** Linting workflow (props [@cadic](https://github.com/cadic) via [#34](https://github.com/globeandmail/debug-bar-for-sophi/pull/34)).
* **Security:** Pinned `10up-toolkit`, `husky`, `node-wp-i18n`, and `react-json-view` dependencies (props [@renovate](https://github.com/apps/renovate) via [#45](https://github.com/globeandmail/debug-bar-for-sophi/pull/45)).
* **Security:** Update `10up-toolkit` from 3.0.0 to 4.1.2 (props [@cadic](https://github.com/cadic), [@renovate](https://github.com/apps/renovate) via [#31](https://github.com/globeandmail/debug-bar-for-sophi/pull/31), [#46](https://github.com/globeandmail/debug-bar-for-sophi/pull/46)).
* **Security:** Update `husky` from 7.0.4 to 8.0.1 (props [@cadic](https://github.com/cadic) via [#31](https://github.com/globeandmail/debug-bar-for-sophi/pull/31)).
* **Security:** Update `actions/checkout` action from v2 to v3 (props [@renovate](https://github.com/apps/renovate) via [#48](https://github.com/globeandmail/debug-bar-for-sophi/pull/48)).
* **Security:** Update `actions/dependency-review-action` action from v1 to v2 (props [@renovate](https://github.com/apps/renovate) via [#49](https://github.com/globeandmail/debug-bar-for-sophi/pull/49)).
* **Security:** Update `tj-actions/changed-files` action from v18.7 to v23.1 (props [@renovate](https://github.com/apps/renovate) via [#50](https://github.com/globeandmail/debug-bar-for-sophi/pull/50), [#51](https://github.com/globeandmail/debug-bar-for-sophi/pull/51)).

= 0.2.0 - 2022-05-17 =
* **Added:** Support for [WordPress VIP](https://wpvip.com/) to force enable the Debug Bar plugin on their platform (props [@cadic](https://github.com/cadic), [@jeffpaul](https://github.com/jeffpaul)).
* **Added:** New setting to "Disable WordPress caching of Sophi content" to force request/response with Sophi API (props [@cadic](https://github.com/cadic), [@jeffpaul](https://github.com/jeffpaul)).
* **Added:** New Tools > "Sophi Logs" page to output raw Sophi logs (props [@cadic](https://github.com/cadic), [@jeffpaul](https://github.com/jeffpaul)).
* **Added:** Documentation updates (props [@jeffpaul](https://github.com/jeffpaul)).
* **Fixed:** Deploy to WordPress.org GitHub Action (props [@cadic](https://github.com/cadic), [@jeffpaul](https://github.com/jeffpaul)).
* **Fixed:** Catch `JSON.parse` exception if the plugin outputs empty JSON request or response (props [@cadic](https://github.com/cadic)).

= 0.1.0 - 2022-05-10 =
* Initial release of the Debug Bar for Sophi.io plugin. 🎉
