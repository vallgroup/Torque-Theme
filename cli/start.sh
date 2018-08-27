#!/usr/bin/env bash

# $ bash start.sh <workspace-name>

GREEN='\033[0;32m'
PURPLE='\033[0;35m'
NC='\033[0m'

# checks the docker containers are running,
# otherwise starts them up
docker-compose up -d

# runs 'start' script for workspace <workspace-nanme>
# as defined in the package.json for that workspace
workspace=$1

# if user did not pass a workspace argument then we want to as for it as input
if [ -z "$workspace" ]
then
  # no workspace passed
  echo -e "${PURPLE}Enter workspace name:${NC}"
  read workspace
fi

echo -e "${GREEN}Starting workspace ${workspace}...${NC}"

yarn workspace $workspace start
