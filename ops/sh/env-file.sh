#!/bin/bash

# Function to copy the environment file based on the selected option
copy_env_file() {
    local option="$1"
    local src_dir="./ops"
    local dest_dir="./src"

    case "$option" in
        "1")
            env_file="dclm-dev.env"
            ;;
        "2")
            env_file="dclm-prod.env"
            ;;
        *)
            echo -e "No option selected. Copying default envfile"
            env_file="bams-dev.env"
            ;;
    esac

    if [ -f "$src_dir/$env_file" ]; then
        cp "$src_dir/$env_file" "$dest_dir/.env"
        echo -e "Environment file $env_file copied to .env\n"
    else
        echo -e "Environment file $env_file not found in $src_dir.\n"
        exit 1
    fi
}

# Check if an argument is provided
if [ $# -eq 0 ]; then
    # Display menu if no argument is provided
    read -p $'Select an environment:\n1. dclm-dev\n2. dclm-prod\nEnter your choice or do nothing to copy default envfile: ' choice
else
    choice="$1"
fi

# Call the copy_env_file function with the provided or selected option
copy_env_file "$choice"
