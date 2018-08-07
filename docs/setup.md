# Torque Theme Setup

> Skip 1,2 or 3 if respective package already installed

1.  Install Homebrew (if `brew -v` does not return a version).

    Open a new terminal window and run:

    ```sh
    $ /usr/bin/ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"
    ```

2.  Install Yarn with Homebrew (if `yarn -v` does not return a version)

    ```sh
    $ brew install yarn
    ```

3.  Install NVM (if `nvm version` does not return a version)

    ```sh
    $ curl -o- https://raw.githubusercontent.com/creationix/nvm/v0.33.11/install.sh | bash
    ```

4.  Clone repo if you haven't already, and `cd` in your terminal to the project root

    ```sh
    $ cd path/to/Torque-Theme
    ```

5.  Install and use required Node.js version with NVM (specified in nvmrc)

    ```sh
    $ nvm use
    ```

6.  Request secrets from project manager and store them in the project root

7.  Install docker

    - Mac: https://store.docker.com/editions/community/docker-ce-desktop-mac
    - Windows: https://store.docker.com/editions/community/docker-ce-desktop-windows

8.  Start docker daemon (run the application you downloaded in the last step)

9.  Run setup script

    ```sh
    $ bash setup.sh
    ```

    This command will:

    - Configure Yarn to allow workspaces ([see here for more detail on our use of workspaces](./developing.md))
    - Install dependencies for all workspaces and create project yarn.lock
    - Download the docker images if you don't already have them cached.
    - Start 3 docker containers ([docs here for more info on our use of docker](./docker.md)):
      1.  The MySQL database, using the secrets to define the db users.
      2.  PhpMyAdmin - access at http://localhost:8080
      3.  A PHP server running a Wordpress installation - access at http://localhost:8000
    - Build all the workspaces in wp-content
    - Run Webpack in development and watch mode for the 'torque-theme' workspace. This will watch the files and compile and update them as necessary in wp-content inside the docker container. Simply refresh the browser to see the changes reflected.

10. Copy mu-plugins directory in the root into wp-content (for the moment we dont want to be changing anything here, so it should be sufficient to just copy it once and not worry about any watch servers)

11. Complete Wordpress install (only if this is the first time you've started the docker containers):

    - Visit http://localhost:8000
    - Complete install process. The database will be connected automatically via docker-compose, so you'll only need to choose a language and set up a user.

12. Done! The site is now active on http://localhost:8000. Note, you may need to run webpack for each workspace (using `yarn start <workspace-name>`) once more to make sure your themes and plugins are properly compiled to wp-content.

### Head over to the [Developing](./developing.md) docs to learn how to add new plugins and change theme files
