#!/usr/bin/env bash

chmod +x ./cli/uploads.sh

# save any uploads outside of wp-content
./cli/uploads.sh from_wp_content

# delete wp-content
rm -R wp-content

# run setup script again, rebuilding wp-content from scratch
chmod +x ./cli/setup.sh
./cli/setup.sh
