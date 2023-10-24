#!/bin/bash

# Check app dir
echo -e "\nChecking if app directory exists.."
if [ ! -d "$APP_DIR" ]; then
  echo "Directory not found, creating..."
  mkdir -p "$APP_DIR"
else
  echo "Directory already exists."
fi

# Enter into app dir
echo -e "\nEntering app directory.."
cd "$APP_DIR"

# Clone app repo
echo -e "\nCloning latest repo changes.."
if [ ! -d .git ]; then
  echo "App repo not found. Cloning..."
  git clone "$REPO" . \
  && git switch "$GIT_BRANCH"
else
  echo "App repo exists..."
  git fetch --all \
  && git switch "$GIT_BRANCH"
fi
