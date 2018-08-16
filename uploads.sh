#!/usr/bin/env bash

# save any uploads outside of wp-content
mkdir uploads
cp -r wp-content/uploads/* uploads
