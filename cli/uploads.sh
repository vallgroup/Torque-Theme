#!/usr/bin/env bash

source ./cli/lib/colors.sh

UPLOADS_DIR_REPO=uploads

WP_CONTENT=wp-content
UPLOADS_DIR_WP_CONTENT=${WP_CONTENT}/uploads


remove() {
  echo -e "${BLUE}Removing uploads from wp-content...${NC}"
  if [ -d "$UPLOADS_DIR_WP_CONTENT" ]
  then
    rm -R $UPLOADS_DIR_WP_CONTENT
  fi
}

# copy across new uploads if they exist and uploads dir is not empty
from_repo() {
  if [ -d "$UPLOADS_DIR_REPO" ] && [ ! -z "$(ls -A $UPLOADS_DIR_REPO)" ]
  then
    echo -e "${BLUE}Copying uploads from repo to wp-content...${NC}"
    cp -r $UPLOADS_DIR_REPO $WP_CONTENT
  else
    echo -e "${YELLOW}Warning: Could not copy uploads to wp-content since uploads dir was empty or did not exist${NC}"
  fi
}

# save any uploads outside of wp-content
from_wp_content() {
  if [ -d "$UPLOADS_DIR_WP_CONTENT" ] && [ ! -z "$(ls -A $UPLOADS_DIR_WP_CONTENT)" ]
  then
    echo -e "${BLUE}Copying uploads from wp-content to repo...${NC}"
    cp -r $UPLOADS_DIR_WP_CONTENT .
  else
    echo -e "${YELLOW}Warning: Could not copy uploads to repo since wp-content uploads dir was empty or did not exist${NC}"
  fi
}


case $1 in
  remove)             remove           ;;
  from_repo)          from_repo        ;;
  from_wp_content)    from_wp_content  ;;
  *)                  from_wp_content  ;;
esac
