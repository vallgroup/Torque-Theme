#!/usr/bin/env bash

# allow yarn workspaces
yarn config set workspaces-experimental true

# install dependencies
yarn

# stop any previously running docker containers
docker-compose stop

# download and build docker images
docker-compose up -d

# build workspaces into wp-content
yarn workspace torque-theme build
yarn workspace torque-floor-plans build
yarn workspace torque-availability build
yarn workspace torque-gallery-layouts build
yarn workspace torque-map build

# copy across mu-plugins
mkdir wp-content/mu-plugins
cp -r mu-plugins/* wp-content/mu-plugins

# copy across uploads
mkdir wp-content/uploads
cp -r uploads/* wp-content/uploads

# remove unwanted default plugins and themes
rm -R wp-content/themes/twentyfifteen
rm -R wp-content/themes/twentysixteen
rm -R wp-content/themes/twentyseventeen
rm -R wp-content/plugins/akismet
rm wp-content/plugins/hello.php

# start watch server
yarn start torque-theme
