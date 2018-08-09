#!/usr/bin/env bash

yarn config set workspaces-experimental true

# install dependencies
yarn

# download and build docker images
docker-compose up -d

# build workspaces into wp-content
yarn workspace torque-theme build
yarn workspace 905-fulton-child build
yarn workspace torque-floor-plans build
yarn workspace torque-availability build
yarn workspace torque-gallery-layouts build

# copy across mu-plugins
mkdir wp-content/mu-plugins
cp -r mu-plugins/* wp-content/mu-plugins

# start watch server
yarn start torque-theme
