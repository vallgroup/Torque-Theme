#!/usr/bin/env bash

# $ bash start.sh <workspace-name>

source ./cli/lib/colors.sh
source ./cli/lib/workspaces.sh

# checks the docker containers are running,
# otherwise starts them up
docker-compose up -d --remove-orphans

# runs 'start' script for workspace <workspace-nanme>
# as defined in the package.json for that workspace
workspace=$1

# if user did not pass a workspace argument then we want to as for it as input
if [ -z "$workspace" ]
then
  echo -e "${BLUE}Registered workspaces:${NC}"
  printf '  %s\n' "${workspaces[@]}"

  echo -e "${PURPLE}Enter workspace name:${NC}"
  read workspace
fi

echo -e "${GREEN}Starting workspace ${workspace}...${NC}"

yarn workspace $workspace start
