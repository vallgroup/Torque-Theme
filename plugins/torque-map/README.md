# Torque Plugin Boilerplate

## GET STARTED

1.  Open new terminal, and in **project** root, run:

    ```sh
    $ yarn
    ```

    to install/link dependencies.

7.  In **project** root, run:

    ```sh
    $ yarn start <torque_plugin_slug>
    ```

    to compile files to wp-content and start webpack


## Filters

Filters available for the theme to control some of the map's layout and functionality:

*Filter* | *Function* | *Value Type*
--- | --- | ---
`torque_map_api_key` | Set the API key to use for google maps | string
`torque_map_pois_allowed` | Define how many Points Of Interest are allowed per map. Defaults to 0. | int
`torque_map_display_pois_list` | Whether the map should display a list of POIs below the map when a POI is searched for. Defaults to false. | bool
`torque_map_tinymce_plugin_button` | Passing `true` will allow users to enter a shortcode in the backend of wordpress to create a map on the fly - without the need to create the map post first. Defaults to false. | bool
`torque_map_pois_location` | Set the location for the POI buttons. Defaults to `top`. You can pass `bottom` to display them at the below the map. | string