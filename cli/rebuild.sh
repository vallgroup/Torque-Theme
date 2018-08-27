#!/usr/bin/env bash

set -x

# save any uploads outside of wp-content
mkdir uploads
cp -r wp-content/uploads/* uploads

# delete wp-content
rm -R wp-content

# run setup script again, rebuilding wp-content from scratch
chmod +x ./cli/setup.sh
./cli/setup.sh
