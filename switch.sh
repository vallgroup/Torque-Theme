#!/usr/bin/env bash

# stop containers from previous environment
docker-compose stop

# remove uploads from gitignore wp-content directory
rm -R wp-content/uploads

# switch to new env
git checkout $1

# copy across new uploads
mkdir wp-content/uploads
cp -r uploads/* wp-content/uploads
