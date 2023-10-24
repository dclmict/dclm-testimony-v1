#!/bin/bash

# Source the .env file to load environment variables
source ./src/.env

# Extract the VHOST_CONFIG variable
VHOST_CONFIG=${VHOST_CONFIG}

# Save the VHOST_CONFIG to env.txt
file=./env.txt
echo "$VHOST_CONFIG" > "$file"

# set environment variable using 'gh' CLI
# gh variable set NGX -b "$(cat $file)"
gh variable set NGX < "$file"

rm -f "$file"