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