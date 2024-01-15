#!/bin/bash

# Check if the env file argument is provided
if [ $# -ne 1 ]; then
    echo "Usage: $0 <env_file>"
    exit 1
fi

# Initialize the ARGS array
ARGS=()

# Read the env file and add variable names to ARGS array
env_file="$1"
while IFS= read -r line; do
    # Check if the line is not empty and does not start with '#'
    if [ -n "$line" ] && [[ ! "$line" =~ ^\# ]]; then
        # Extract the variable name (part before the '=' sign)
        var_name=$(echo "$line" | cut -d'=' -f1)
        ARGS+=("$var_name")
    fi
done < "$env_file"

# Loop through each argument and run the gh secret delete command
# for ARC in "${ARGS[@]}"; do
#     gh secret delete "$ARC"
# done

# Run the gh secret delete command in parallel
parallel -j+0 gh secret delete ::: "${ARGS[@]}"
