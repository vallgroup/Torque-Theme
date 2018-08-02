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

4.  cd in your terminal to the root of this project

    ```sh
    $ cd path/to/torque-theme
    ```

5.  Install and use required Node.js version with NVM (specified in package.json engine.node)

    ```sh
    $ nvm use
    ```

6.  Install docker

    - Mac: https://store.docker.com/editions/community/docker-ce-desktop-mac
    - Windows: https://store.docker.com/editions/community/docker-ce-desktop-windows

7.  Run setup script

    ```sh
    $ bash setup.sh
    ```
