# Torque Filtered Gallery

Adds a React app (includable via a shortcode) that exposes a front end interface for filtering posts by term.

Currently, the user is able to set a taxonomy, a parent term to limit filter options by, and choose a template for the resulting post loop.

## Filters

<!-- prettier-ignore-start -->

*Filter* | *Function* | *Value Type*
--- | --- | ---
`torque_filtered_gallery_tinymce_plugin_button` | Display the tinyMCE button | bool (true)
`torque_filtered_gallery_loop_template` | Allows the theme to decide which template to use for the post loop | string

<!-- prettier-ignore-end -->

# Changelog

## [2.0.0] 03/26/2019

### Added

- Support for custom filters (acf tabs, dropdown taxonomy, and dropdown date)
- Support for pagination
- API endpoints for getting posts, terms, and filter options
- Template 2

### Changed

- Upgraded plugin to use latest React standards

## [1.1.0]

### Added

- Support for custom post types

### Changed

- Babel to v7

## [1.0.1]

### Changed

- Fixed bug in posts params. posts_per_page -> per_page

## [1.0.0]

### Added

- Add Shortcode with tinyMCE form for setting the tax and parent term.
- Add React app to filter posts and display loop.
- Add caching layer to the React App so posts from one term are only fetched once.
- Add template-0
