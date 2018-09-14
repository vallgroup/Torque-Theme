# Torque US States

Adds a US State CPT which allows one 'State' post at a time to be assigned to each of the US States.

We also expose a filter which enables the theme to add a metabox to any post type, allowing the post to be assigned to a state.

A React app can then be included with a shortcode which will allow the user to filter posts by selecting a state from a map.

## Filters

<!-- prettier-ignore-start -->

*Filter* | *Function* | *Value Type*
--- | --- | ---
`torque_us_states_post_types_state_assigner` | Allows the theme to pass an array of post_type names for which a state selector metabox will appear | Array[string]

<!-- prettier-ignore-end -->

# Changelog

## [1.0.0] 09/14/2018

### Added

- React App for filtering posts
- Shortcode with TinyMCE form for selecting post type for the app
- Filter for deciding which post types to show a state selector metabox on
- US State CPT
