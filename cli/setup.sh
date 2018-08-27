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
# #themes
yarn workspace torque-theme build
#plugins
yarn workspace torque-floor-plans build
yarn workspace torque-availability build
yarn workspace torque-gallery-layouts build
yarn workspace torque-map build
yarn workspace torque-building-facts build
yarn workspace torque-staff build
yarn workspace torque-button build

# copy across mu-plugins
mkdir wp-content/mu-plugins
cp -r mu-plugins/* wp-content/mu-plugins

# copy across uploads
chmod +x ./cli/uploads.sh
./cli/uploads.sh from_repo

# remove unwanted default plugins and themes
rm -R wp-content/themes/twentyfifteen
rm -R wp-content/themes/twentysixteen
rm -R wp-content/themes/twentyseventeen
rm -R wp-content/plugins/akismet
rm wp-content/plugins/hello.php
