# Debug Bar for Sophi

> Extends the Debug Bar plugin for the Sophi.io Site Automation service.

[![Support Level](https://img.shields.io/badge/support-active-green.svg)](#support-level) [![Release Version](https://img.shields.io/github/release/globeandmail/sophi-debug-bar.svg)](https://github.com/globeandmail/sophi-debug-bar/releases/latest) ![WordPress tested up to version](https://img.shields.io/wordpress/plugin/tested/debug-bar-for-sophi?color=blue&label=WordPress&logo=WordPress) [![GPL-2.0-or-later License](https://img.shields.io/github/license/globeandmail/sophi-debug-bar.svg)](https://github.com/globeandmail/sophi-debug-bar/blob/trunk/LICENSE.md)

[![Linting](https://github.com/10up/sophi-debug-bar/actions/workflows/lint.yml/badge.svg)](https://github.com/10up/sophi-debug-bar/actions/workflows/lint.yml) [![Dependency Review](https://github.com/10up/sophi-debug-bar/actions/workflows/dependency-review.yml/badge.svg)](https://github.com/10up/sophi-debug-bar/actions/workflows/dependency-review.yml)

## Requirements

* PHP 7.4+
* WordPress 5.6+
* [Sophi](https://wordpress.org/plugins/sophi/) 1.1.0+
* [Debug Bar](https://wordpress.org/plugins/debug-bar/) 1.0+
  * The Debug Bar for Sophi plugin has been tested up to Debug Bar version 1.1.3, compatibility with later versions is not guaranteed
  * This plugin is already included on [WordPress VIP](https://wpvip.com/))

## Installation

1. Install the [Sophi](https://wordpress.org/plugins/sophi) plugin.
1. Install the [Debug Bar](https://wordpress.org/plugins/debug-bar/) plugin.  Note that this is already included on [WordPress VIP](https://wpvip.com/).
1. Install the Debug Bar for Sophi plugin via the plugin installer, either by searching for it or uploading a ZIP file.
1. Activate all three plugins.

## Usage

After installing and activating, click the `Debug` button in the admin toolbar.  Within the Debug Bar Panel, click the `Sophi` panel.

Note that the Debug Bar for Sophi plugin does not show the Sophi JavaScript Tracking activity in the Debug Bar as that's something that can be viewed with a browser console's `Network` tab.  Otherwise you should be able to view the Sophi Authentication request/response, Sophi API request/response, and CMS publish/update events in the Debug Bar to help triage your Sophi integration.

## Support Level

**Active:** The Globe and Mail is actively working on this, and we expect to continue work for the foreseeable future including keeping tested up to the most recent version of WordPress.  Bug reports, feature requests, questions, and pull requests are welcome.

## Changelog

A complete listing of all notable changes to Debug Bar for Sophi are documented in [CHANGELOG.md](https://github.com/globeandmail/sophi-debug-bar/blob/develop/CHANGELOG.md).

## Contributing

Please read [CODE_OF_CONDUCT.md](https://github.com/globeandmail/sophi-debug-bar/blob/develop/CODE_OF_CONDUCT.md) for details on our code of conduct, [CONTRIBUTING.md](https://github.com/globeandmail/sophi-debug-bar/blob/develop/CONTRIBUTING.md) for details on the process for submitting pull requests to us, and [CREDITS.md](https://github.com/globeandmail/sophi-debug-bar/blob/develop/CREDITS.md) for a listing of maintainers, contributors, and libraries for Debug Bar for Sophi.

## Like what you see?

<a href="http://10up.com/contact/"><img src="https://10up.com/uploads/2016/10/10up-Github-Banner.png" alt="Work with 10up, we create amazing websites and tools that make content management simple and fun using open source tools and platforms"></a>
