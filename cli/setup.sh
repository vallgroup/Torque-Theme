#!/usr/bin/env bash

source ./cli/lib/colors.sh

build() {
  echo -e "${BLUE}Building $1...${NC}"
  yarn workspace $1 build
}

remove() {
  if [ -d "$1" ]
  then
    rm -R $1
  elif [ -f "$1" ]
  then
    rm $1
  fi
}

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
build torque-theme
#plugins
build torque-floor-plans
build torque-availability
build torque-gallery-layouts
build torque-map
build torque-building-facts
build torque-staff
build torque-button

# copy across mu-plugins
echo -e "${BLUE}Copying mu-plugins...${NC}"
mkdir wp-content/mu-plugins
cp -r mu-plugins/* wp-content/mu-plugins

# copy across uploads
chmod +x ./cli/uploads.sh
./cli/uploads.sh from_repo

# remove unwanted default plugins and themes
echo -e "${BLUE}Removing wp default plugins and themes...${NC}"
remove wp-content/themes/twentyfifteen
remove wp-content/themes/twentysixteen
remove wp-content/themes/twentyseventeen
remove wp-content/plugins/akismet
remove wp-content/plugins/hello.php
