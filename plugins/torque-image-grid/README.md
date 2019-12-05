# Torque Image Grid

## GET STARTED

1.  Copy entire torque-plugin directory into plugins.

    - Include package.json, webpack.config.js, and other config files
    - Exclude node_modules if for some reason it exists

2.  Find and replace the following in the entire directory:

    1.  Torque_Image_Grid (eg Torque_Floor_Plans) **Note: aim to always prefix with Torque**
    2.  Torque Image Grid (eg Torque Floor Plans)
    3.  torque-image-grid (eg torque-floor-plans)
    4.  image-grid/v1/ (eg floor-plans/v1/)
    5.  torque_image_grid (eg torque_floor_plan)

3.  Rename directory: torque-plugin => torque-image-grid

4.  Rename all files in this directory: {torque-plugin}-etc-class.php => {torque-image-grid}-etc-class.php

5.  Add 'torque-image-grid' to cli/lib/workspaces.sh

6.  Open new terminal, and in **project** root, run:

    ```sh
    $ yarn
    ```

    to install/link dependencies.

7.  In **project** root, run:

    ```sh
    $ yarn start torque-image-grid
    ```

    to compile files to wp-content and start webpack

8.  Delete the README up to here and fill in the rest.

## Filters

<!-- prettier-ignore-start -->

*Filter* | *Function* | *Value Type*
--- | --- | ---
`example_filter_slug` | Filter does loads of really cool stuff | Array[string]

<!-- prettier-ignore-end -->

# Changelog

## [1.0.0] <date>

### Added

### Changed

### Removed
