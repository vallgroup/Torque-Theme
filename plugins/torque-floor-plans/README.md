# Torque Floor Plans

Registers a Floor Plans CPT allowing you to assign a floor, description, and downloadable PDF.
A Floor Plans React app can then be included via a shortcode in the Wordpress site allowing the user to browse floors and the floor plans assigned to each floor.

## Filters

<!-- prettier-ignore-start -->

*Filter* | *Function* | *Value Type*
--- | --- | ---
`torque_floor_plans_cpt_metaboxes` | Filter Floor Plans CPT metaboxes | array
`torque_floor_plans_data_source` | Change the floor plans data source | 'entrata' or false (default - uses WP CPT)
`torque_floor_plans_entrata_property_id` | (Entrata Specific) set the entrata property id | int

<!-- prettier-ignore-end -->

# Changelog

## [2.1.0]

### Added

- Metaboxes filter hook

## [2.0.0]

### Added

- Entrata API as data source

## [1.0.0]

### Added

- React app, includable via Shortcode
- Floor Plans CPT w/ metaboxes
- Custom API for passing floor plans to front end.
