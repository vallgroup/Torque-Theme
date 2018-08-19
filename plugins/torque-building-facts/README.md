# Torque Plugin Boilerplate

## GET STARTED

1.  Copy entire torque-plugin directory into plugins.

    - Include package.json, webpack.config.js, and other config files
    - Exclude node_modules if for some reason it exists

2.  Find and replace the following in the entire directory:

    1.  Torque_Building_Facts (eg Torque_Floor_Plans) **Note: aim to always prefix with Torque**
    2.  Torque Building Facts (eg Torque Floor Plans)
    3.  torque-building-facts (eg torque-floor-plans)
    4.  torque-building-facts/v1/ (eg floor-plans/v1/)
    5.  torque_building_facts (eg torque_floor_plan)

3.  Rename directory: torque-plugin => torque-building-facts

4.  Rename all files in this directory: {torque-plugin}-etc-class.php => {torque-building-facts}-etc-class.php

5.  Register workspace in package.json in **project** root and add it to the setup.sh initial build script.

6.  Open new terminal, and in **project** root, run:

    ```sh
    $ yarn
    ```

    to install/link dependencies.

7.  In **project** root, run:

    ```sh
    $ yarn start torque-building-facts
    ```

    to compile files to wp-content and start webpack
