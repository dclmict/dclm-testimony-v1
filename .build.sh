#!/bin/bash

# https://gist.github.com/JeffreyMFarley/324f154e0f766897ddf923dd99133562#file-builder-sh
# Check that networking is up.
[ "$NETWORKING" = "no" ] && exit 0

APP_IMAGE=ddc-web

# -----------------------------------------------------------------------------

# $1 is the tag - defaults to "dev"
# $2 is the ES Index - defaults to "dev"
build-app() {
    ISO_DATE=$(date "+%Y-%m-%d")
    docker build \
        --build-arg gitBranch=${1-dev} \
        -t $APP_IMAGE:$ISO_DATE \
        ./images/app
    docker tag $APP_IMAGE:$ISO_DATE $APP_IMAGE:${1-dev}
}

# -----------------------------------------------------------------------------
# Check if using UCP

if [ -n "$DOCKER_HOST" ]; then
    echo -e "\nThis script is only for local docker use"
    exit 2
fi

# -----------------------------------------------------------------------------

case $1 in
    make-app)
        clean
        build-app $2 $3
        ;;
    *)
        echo "Usage: $0 {command}"
        echo "  make-app        - create a development version of the app"
        echo -e "\n  Each command has a dedicated Markdown file with much more information"
        exit 2
        ;;
esac