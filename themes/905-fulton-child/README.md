# Torque Child Theme Boilerplate

## GET STARTED

1.  Copy entire torque-child-theme directory into themes.

    - Include package.json, webpack.config.js, and other config files
    - Exclude node_modules if for some reason it exists

2.  Find and replace the following in the entire directory:

    1.  905 Fulton (eg 905 Fulton)
    2.  905-fulton-child (eg 905-fulton-child) **Note:** best practise is to include -child at the end
    3.  Fulton (eg Fulton)
    4.  (eg https://github.com/vallgroup/Torque-Theme)
    5.  Fulton (eg Fulton)

3.  Rename directory: torque-child-theme => 905-fulton-child

4.  Rename all files in this directory: {torque-child_theme}-etc-class.php => {905-fulton-child}-etc-class.php

5.  Register workspace in package.json in **project** root

6.  Open new terminal, and in **project** root, run:

    ```sh
    $ yarn
    ```

    to install/link dependencies.

7.  In **project** root, run:

    ```sh
    $ yarn start 905-fulton-child
    ```

    to compile files to wp-content and start webpack
