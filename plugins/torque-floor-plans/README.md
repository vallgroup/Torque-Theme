# Torque Plugin Boilerplate

## GET STARTED

1.  Copy entire torque-plugin directory into plugins. Include package.json and webpack.config.js.

2.  Find and replace the following in the entire directory:

    1.  Torque_Floor_Plans (eg Torque_Floor_Plans) **Note: aim to always prefix with Torque**
    2.  Torque Floor Plans (eg Torque Floor Plans)
    3.  torque-floor-plans (eg torque-floor-plans)
    4.  floor-plans/v1/ (eg floor-plans/v1/)
    5.  floor_plan (eg floor_plan)

3.  Rename directory: torque-plugin => torque-floor-plans

4.  Rename all files in this directory: {torque-plugin}-etc-class.php => {torque-floor-plans}

5.  Register workspace in package.json in **project** root

6.  Open new terminal, and in **project** root, run:

    ```sh
    $ yarn
    ```

    to install/link dependencies.

7.  In **project** root, run:

    ```sh
    $ yarn start torque-floor-plans
    ```

    to compile files to wp-content and start webpack
