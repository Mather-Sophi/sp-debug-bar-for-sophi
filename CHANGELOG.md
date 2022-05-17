# Changelog

All notable changes to this project will be documented in this file, per [the Keep a Changelog standard](http://keepachangelog.com/), and will adhere to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased] - TBD

## [0.2.0] - 2022-05-17
### Added
- Support for [WordPress VIP](https://wpvip.com/) to force enable the Debug Bar plugin on their platform (props [@cadic](https://github.com/cadic), [@jeffpaul](https://github.com/jeffpaul) via [#11](https://github.com/10up/sophi-debug-bar/pull/11)).
- New setting to "Disable WordPress caching of Sophi content" to force request/response with Sophi API (props [@cadic](https://github.com/cadic), [@jeffpaul](https://github.com/jeffpaul) via [#16](https://github.com/10up/sophi-debug-bar/pull/16)).
- New Tools > "Sophi Logs" page to output raw Sophi logs (props [@cadic](https://github.com/cadic), [@jeffpaul](https://github.com/jeffpaul) via [#17](https://github.com/10up/sophi-debug-bar/pull/17)).
- Documentation updates (props [@jeffpaul](https://github.com/jeffpaul) via [#8](https://github.com/10up/sophi-debug-bar/pull/8), [#23](https://github.com/10up/sophi-debug-bar/pull/23)).

### Fixed
- Deploy to WordPress.org GitHub Action (props [@cadic](https://github.com/cadic), [@jeffpaul](https://github.com/jeffpaul) via [#10](https://github.com/10up/sophi-debug-bar/pull/10)).
- Catch `JSON.parse` exception if the plugin outputs empty JSON request or response (props [@cadic](https://github.com/cadic) via [#12](https://github.com/10up/sophi-debug-bar/pull/12)).

## [0.1.0] - 2022-05-10
- Initial release of the Debug Bar for Sophi.io plugin. 🎉

[Unreleased]: https://github.com/globeandmail/sophi-debug-bar/compare/trunk...develop
[0.2.0]: https://github.com/globeandmail/sophi-debug-bar/compare/0.1.0...0.2.0
[0.1.0]: https://github.com/globeandmail/sophi-debug-bar/tree/0.1.0
