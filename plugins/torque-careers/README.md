# Torque Plugin Boilerplate

## GET STARTED

1.  Copy entire torque-plugin directory into plugins.

    - Include package.json, webpack.config.js, and other config files
    - Exclude node_modules if for some reason it exists

2.  Find and replace the following in the entire directory:

    1.  Torque_Careers (eg Torque_Floor_Plans) **Note: aim to always prefix with Torque**
    2.  Torque Careers (eg Torque Floor Plans)
    3.  torque-careers (eg torque-floor-plans)
    4.  careers/v1/ (eg floor-plans/v1/)
    5.  torque_careers (eg torque_floor_plan)

3.  Rename directory: torque-plugin => torque-careers

4.  Rename all files in this directory: {torque-plugin}-etc-class.php => {torque-careers}-etc-class.php

5.  Add '<torque_child_theme_slug>' to cli/lib/workspaces.sh

6.  Open new terminal, and in **project** root, run:

    ```sh
    $ yarn
    ```

    to install/link dependencies.

7.  In **project** root, run:

    ```sh
    $ yarn start torque-careers
    ```

    to compile files to wp-content and start webpack
