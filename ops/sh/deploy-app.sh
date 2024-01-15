#!/bin/bash

# Enter app dir
echo -e "\nEntering app directory..."
cd "$APP_DIR"

# Pull repo changes
echo -e "\nDownloading latest repo changes..."
make new

# Drop running container
echo -e "\nDropping running container..."
make down

# Start new container
echo -e "\nLaunching latest app version..."
make up
