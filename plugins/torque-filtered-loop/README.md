# Torque Plugin Boilerplate

## GET STARTED

1.  Copy entire torque-plugin directory into plugins.

    - Include package.json, webpack.config.js, and other config files
    - Exclude node_modules if for some reason it exists

2.  Find and replace the following in the entire directory:

    1.  Torque_Filtered_Loop (eg Torque_Floor_Plans) **Note: aim to always prefix with Torque**
    2.  Torque Filtered Loop (eg Torque Floor Plans)
    3.  torque-filtered-loop (eg torque-floor-plans)
    4.  filtered-loop/v1/ (eg floor-plans/v1/)
    5.  torque_filtered_loop (eg torque_floor_plan)

3.  Rename directory: torque-plugin => torque-filtered-loop

4.  Rename all files in this directory: {torque-plugin}-etc-class.php => {torque-filtered-loop}-etc-class.php

5.  Add '<torque_child_theme_slug>' to cli/lib/workspaces.sh

6.  Open new terminal, and in **project** root, run:

    ```sh
    $ yarn
    ```

    to install/link dependencies.

7.  In **project** root, run:

    ```sh
    $ yarn start torque-filtered-loop
    ```

    to compile files to wp-content and start webpack
