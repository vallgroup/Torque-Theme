# Torque Map

Allows users to create their own custom maps, complete with styling, custom pointers and points of interest filters (POIs), and include them in their wordpress site with a shortcode.

## Filters

Filters available for the theme to control some of the map's layout and functionality:

<!-- prettier-ignore-start -->

*Filter* | *Function* | *Value Type*
--- | --- | ---
`torque_map_api_key` | Set the API key to use for google maps | string
`torque_map_pois_allowed` | Define how many Points Of Interest are allowed per map. Defaults to 0. | int
`torque_map_display_pois_list` | Whether the map should display a list of POIs below the map when a POI is searched for. Defaults to false. | bool
`torque_map_tinymce_plugin_button` | Passing `true` will allow users to enter a shortcode in the backend of wordpress to create a map on the fly - without the need to create the map post first. Defaults to false. | bool
`torque_map_pois_location` | Set the location for the POI buttons. Defaults to `top`. You can pass `bottom` to display them at the below the map. | string

<!-- prettier-ignore-end -->

# Changelog

## [1.1.0]

### Added

- Ability to add custom styling to maps with snazzymaps output

## [1.0.2] 9/12/2018

### Changed

- fix the markers point anchors so they dont move relative to the map on zoom.
- make sure the marker icons dont change before we have the new results from the nearby search

## [1.0.1] 9/12/2018

### Changed

- fix bug in controller class - was failing when trying to get a map by id that had no pois assigned
- fix the map icon point anchor - it was moving position relative to the map when the map was zoomed

## [1.0.0]

### Added

- Shortcode with TinyMCE
- Map CPT
- API for getting map CPT
- React App with Google Maps
