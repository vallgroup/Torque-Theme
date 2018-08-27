#!/usr/bin/env bash

UPLOADS_DIR_REPO=uploads

WP_CONTENT=wp-content
UPLOADS_DIR_WP_CONTENT=${WP_CONTENT}/uploads


remove() {
  if [ -d "$UPLOADS_DIR_WP_CONTENT" ]
  then
    rm -R $UPLOADS_DIR_WP_CONTENT
  fi
}

# copy across new uploads if they exist and uploads dir is not empty
from_repo() {
  if [ -d "$UPLOADS_DIR_REPO" ] && [ ! -z "$(ls -A $UPLOADS_DIR_REPO)" ]
  then
    cp -r $UPLOADS_DIR_REPO $WP_CONTENT
  fi
}

# save any uploads outside of wp-content
from_wp_content() {
  if [ -d "$UPLOADS_DIR_WP_CONTENT" ] && [ ! -z "$(ls -A $UPLOADS_DIR_WP_CONTENT)" ]
  then
    cp -r $UPLOADS_DIR_WP_CONTENT .
  fi
}


case $1 in
  remove)             remove           ;;
  from_repo)          from_repo        ;;
  from_wp_content)    from_wp_content  ;;
  *)                  from_wp_content  ;;
esac
