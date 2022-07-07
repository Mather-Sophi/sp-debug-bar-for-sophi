# Changelog

All notable changes to this project will be documented in this file, per [the Keep a Changelog standard](http://keepachangelog.com/), and will adhere to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased] - TBD

## [0.3.0] - 2022-07-07
### Added
- Link to Sophi.io Settings in plugin actions (props [@cadic](https://github.com/cadic), [@jeffpaul](https://github.com/jeffpaul) via [#32](https://github.com/globeandmail/debug-bar-for-sophi/pull/32)).
- Documentation updates (props [@jeffpaul](https://github.com/jeffpaul), [@YMufleh](https://github.com/YMufleh) via [#30](https://github.com/globeandmail/debug-bar-for-sophi/pull/30)).
- [Mend Bolt](https://github.com/apps/mend-bolt-for-github) and [Renovate](https://togithub.com/renovatebot/renovate) bots (props [@mend-bolt-for-github](https://github.com/apps/mend-bolt-for-github), [@renovate](https://github.com/apps/renovate) via [#35](https://github.com/globeandmail/debug-bar-for-sophi/pull/35), [#36](https://github.com/globeandmail/debug-bar-for-sophi/pull/36)).

### Changed
- Settings page updates (props [@cadic](https://github.com/cadic), [@jeffpaul](https://github.com/jeffpaul) via [#33](https://github.com/globeandmail/debug-bar-for-sophi/pull/33)).

### Removed
- `react-dom` and `prop-types` dependencies as not needed (props [@cadic](https://github.com/cadic) via [#31](https://github.com/globeandmail/debug-bar-for-sophi/pull/31)).

### Fixed
- PHP Notice on empty request body (props [@cadic](https://github.com/cadic), [@jeffpaul](https://github.com/jeffpaul) via [#27](https://github.com/globeandmail/debug-bar-for-sophi/pull/27)).
- Debug records horizontal overflow (props [@cadic](https://github.com/cadic), [@jeffpaul](https://github.com/jeffpaul) via [#29](https://github.com/globeandmail/debug-bar-for-sophi/pull/29)).
- Missing text domain for "Sophi.io Logs" page title (props [@cadic](https://github.com/cadic), [@jeffpaul](https://github.com/jeffpaul) via [#33](https://github.com/globeandmail/debug-bar-for-sophi/pull/33)).
- Linting workflow (props [@cadic](https://github.com/cadic) via [#34](https://github.com/globeandmail/debug-bar-for-sophi/pull/34)).

### Security
- Pinned `10up-toolkit`, `husky`, `node-wp-i18n`, and `react-json-view` dependencies (props [@renovate](https://github.com/apps/renovate) via [#45](https://github.com/globeandmail/debug-bar-for-sophi/pull/45)).
- Update `10up-toolkit` from 3.0.0 to 4.1.2 (props [@cadic](https://github.com/cadic), [@renovate](https://github.com/apps/renovate) via [#31](https://github.com/globeandmail/debug-bar-for-sophi/pull/31), [#46](https://github.com/globeandmail/debug-bar-for-sophi/pull/46)).
- Update `husky` from 7.0.4 to 8.0.1 (props [@cadic](https://github.com/cadic) via [#31](https://github.com/globeandmail/debug-bar-for-sophi/pull/31)).
- Update `actions/checkout` action from v2 to v3 (props [@renovate](https://github.com/apps/renovate) via [#48](https://github.com/globeandmail/debug-bar-for-sophi/pull/48)).
- Update `actions/dependency-review-action` action from v1 to v2 (props [@renovate](https://github.com/apps/renovate) via [#49](https://github.com/globeandmail/debug-bar-for-sophi/pull/49)).
- Update `tj-actions/changed-files` action from v18.7 to v23.1 (props [@renovate](https://github.com/apps/renovate) via [#50](https://github.com/globeandmail/debug-bar-for-sophi/pull/50), [#51](https://github.com/globeandmail/debug-bar-for-sophi/pull/51)).

## [0.2.0] - 2022-05-17
### Added
- Support for [WordPress VIP](https://wpvip.com/) to force enable the Debug Bar plugin on their platform (props [@cadic](https://github.com/cadic), [@jeffpaul](https://github.com/jeffpaul) via [#11](https://github.com/globeandmail/debug-bar-for-sophi/pull/11)).
- New setting to "Disable WordPress caching of Sophi content" to force request/response with Sophi API (props [@cadic](https://github.com/cadic), [@jeffpaul](https://github.com/jeffpaul) via [#16](https://github.com/globeandmail/debug-bar-for-sophi/pull/16)).
- New Tools > "Sophi Logs" page to output raw Sophi logs (props [@cadic](https://github.com/cadic), [@jeffpaul](https://github.com/jeffpaul) via [#17](https://github.com/globeandmail/debug-bar-for-sophi/pull/17)).
- Documentation updates (props [@jeffpaul](https://github.com/jeffpaul) via [#8](https://github.com/globeandmail/debug-bar-for-sophi/pull/8), [#23](https://github.com/globeandmail/debug-bar-for-sophi/pull/23)).

### Fixed
- Deploy to WordPress.org GitHub Action (props [@cadic](https://github.com/cadic), [@jeffpaul](https://github.com/jeffpaul) via [#10](https://github.com/globeandmail/debug-bar-for-sophi/pull/10)).
- Catch `JSON.parse` exception if the plugin outputs empty JSON request or response (props [@cadic](https://github.com/cadic) via [#12](https://github.com/globeandmail/debug-bar-for-sophi/pull/12)).

## [0.1.0] - 2022-05-10
- Initial release of the Debug Bar for Sophi.io plugin. 🎉

[Unreleased]: https://github.com/globeandmail/debug-bar-for-sophi/compare/trunk...develop
[0.3.0]: https://github.com/globeandmail/debug-bar-for-sophi/compare/0.2.0...0.3.0
[0.2.0]: https://github.com/globeandmail/debug-bar-for-sophi/compare/0.1.0...0.2.0
[0.1.0]: https://github.com/globeandmail/debug-bar-for-sophi/tree/0.1.0
