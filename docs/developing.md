# Developing

If you've completed the steps in [setup](./setup.md), then starting the dev server is as easy as running

```sh
$ yarn start
```

Any changes to src files in plugins/ or themes/ should now be visible after visiting http://localhost:8000 or refreshing the page if you're already there.

Otherwise, for more info on the project structure...

### Why Yarn Workspaces and Webpack?

> [See](https://yarnpkg.com/lang/en/docs/workspaces/)

The main benefit to us of using these workspaces is that we can define a separate package.json for each plugin and theme (ie package) that we add. This allows us to run a separate webpack instance in each, and so define a src directory, a build directory, loaders, and plugins on a per package basis, and independently build distributions of each package as and when we have a new version to ship.

We have some default config files (eg .babelrc) in the project root which the separate webpack configs can use, but if they need something more specific (eg config for react), then they can define their own in their respective package root directory.

### Compilation to wp-content

Our docker container takes its' wp-content from the wp-content directory in our project root, but we dont want to update that directly since it could be overwritten by docker and we would lose it for good ([see](./docker.md)).

We combat this by storing our package src files in separate directories which mimic the wp-content structure. With webpack, we then either directly copy, or in the case of scss and js transform and compile, our files into the wp-content directory used by docker.

Exactly which directory in wp-content the files are compiled to can be set in the webpack config of each package, but we should try to keep the same structure in our plugins and themes directories as we see inside wp-content.

#### Behind the scenes

1.  Dev changes example.php in src directory in registered workspace

> Dev is done here, the rest is automatic

2.  Webpack (when configured correctly) is watching for file changes, and will directly copy example.php from the src to its' respective location inside of wp-content.

3.  Since wp-content is linked to the wordpress installation inside of the docker container via a bind mount, the site is updated too.

**Note:** This would be the same process for js or scss files, except they would also be transformed/compiled/minified by webpack during the copy process.

### Usage

#### Creating a new package using yarn workspaces and webpack

> See themes/torque/ for a good example of a configured workspace

1.  Create a new directory in plugins/ or themes/ for the package.

2.  Create a src/ directory which will hold the package code.

3.  Add a package.json to the package root and add a `{ name: ... }` property to define the workspace name along with any other config and dependencies.

4.  Add a webpack.config.js to the package root and configure as you wish (most importantly the src and build directories to make sure the src is compiled and copied to wp-content)

5.  Run `$ yarn` in the **project** root to install the new dependencies and link them to the other packages.

6.  Update the `start` command in the **project** root's package.json to also start webpack for this new workspace.

7.  Run

    ```sh
    $ yarn start
    ```

    and you should see your changes to wp-content on localhost.
