# Torque Child Theme Boilerplate

## GET STARTED

1. Follow instructions in developing docs to set up a client branch.

2. Copy entire torque-child-theme directory into themes.

   - Include package.json, webpack.config.js, and other config files
   - Exclude node_modules if for some reason it exists

3. Find and replace the following in the entire directory: **Note:** do not use numbers or special characters

   1. <torque_child_theme_name> (eg 905 Fulton)
   2. <torque_child_theme_slug> (eg 905-fulton-child) **Note:** best practise is to include -child at the end
   3. The_Cannery (eg Fulton)
   4. <torque_child_theme_uri> (eg https://github.com/vallgroup/Torque-Theme)
   5. <torque_child_theme_client_name> (eg Fulton)

4. Rename all files in this directory: {torque-child_theme}-etc-class.php => {<torque_child_theme_slug>}-etc-class.php

5. Add '<torque_child_theme_slug>' to cli/lib/workspaces.sh

6. Open new terminal, and in **project** root, run:

   ```sh
   $ yarn
   ```

   to install/link dependencies.

7. Return to 'developing' docs in parent theme to finish setting up the new client branch.

8. Delete the README up to here and fill in the rest.

# Changelog

## [1.0.0]

### Added

### Changed

### Removed
