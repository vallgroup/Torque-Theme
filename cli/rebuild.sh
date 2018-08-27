#!/usr/bin/env bash

source ./cli/lib/colors.sh
chmod +x ./cli/uploads.sh

# save any uploads outside of wp-content
./cli/uploads.sh from_wp_content

# delete wp-content
echo -e "${BLUE}Removing wp-content for rebuild...${NC}"
rm -R wp-content

# run setup script again, rebuilding wp-content from scratch
echo -e "${BLUE}Re-running setup...${NC}"
chmod +x ./cli/setup.sh
./cli/setup.sh
