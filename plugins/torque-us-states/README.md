# Torque US States

Adds a US State CPT which allows one 'State' post at a time to be assigned to each of the US States.

We also expose a filter which enables the theme to add a metabox to any post type, allowing the post to be assigned to a state.
Via a filter, the user can also choose a custom metabox to get the value of the loop button link from.

A React app can then be included with a shortcode which will allow the user to filter posts by selecting a state from a map.

## Filters

<!-- prettier-ignore-start -->

*Filter* | *Function* | *Value Type*
--- | --- | ---
`torque_us_states_post_types_state_assigner` | Allows the theme to pass an array of post_type names for which a state selector metabox will appear | Array[string]
`torque_us_states_loop_link_source_meta_key` | Allows the theme to pass an array of metabox key/name pairs so the user can select a custom source for the loop post button link | Array

<!-- prettier-ignore-end -->

# Changelog

## [1.0.2] 10/30/2018

### Changed

- Page scrolls to loop when a valid state is clicked

## [1.0.1] 10/02/2018

### Changed

- Added an extra wrapper div to the top section to allow for backgrounds

## [1.0.0] 09/14/2018

### Added

- React App for filtering posts
- Shortcode with TinyMCE form for selecting post type for the app
- Filter for deciding which post types to show a state selector metabox on
- US State CPT
