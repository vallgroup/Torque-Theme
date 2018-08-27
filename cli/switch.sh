#!/usr/bin/env bash

set -e

GREEN='\033[0;32m'
RED='\033[0;31m'
BLUE='\033[1;34m'
PURPLE='\033[0;35m'
NC='\033[0m'

chmod +x ./cli/uploads.sh

# check we have branch set

branch=$1

if [ -z "$branch" ]
then
  branches=$(git branch)

  echo -e "${BLUE}Available branches${NC}"
  echo -e "${branches}"
  echo -e "${PURPLE}Enter a branch to switch to: ${NC}"
  read branch
fi

# make sure user knows uncomitted uploads will be lost

echo -e "${RED}\nWarning: Uploads not committed to the repo will be lost."
echo -e "${PURPLE}Proceed? [y\N] ${NC}"

read proceed

if [ "$proceed" != "y" ]
then
  echo -e "${BLUE}Run [yarn uploads] to copy over latest uploads from wp-content. These can then be committed to the repo${NC}"
  exit
fi

# make the switch

# stop containers from previous environment
docker-compose stop

# remove uploads from gitignore wp-content directory
./cli/uploads.sh remove

# switch to new env
git checkout $branch

# copy across new uploads
./cli/uploads.sh from_repo


echo -e "${GREEN}Success: New environment ready${NC}"
