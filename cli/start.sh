#!/usr/bin/env bash

# $ bash start.sh <workspace-name>

# checks the docker containers are running,
# otherwise starts them up
docker-compose up -d && \

# runs 'start' script for workspace <workspace-nanme>
# as defined in the package.json for that workspace
yarn workspace $1 start
