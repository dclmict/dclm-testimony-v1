#!/bin/bash

# enter directory
cd "$DEST_APP_ENV_DIR"

# another way
ngxx="vhost.conf"
ngx=$(cat "$ngxx")
# echo -e "Content of ngx:"
# echo "$VHOST"

eval "VHOST=\"$ngx\""
# eval "VHOST=\"$VHOST_CONFIG\""

# Create a temporary file with the provided configuration
echo -e "\n\nCreating temporary file..."
temp_file="$(mktemp)"
echo "$VHOST" > "$temp_file"
# echo -e "Content of temporal file:"
# cat "$temp_file"

# Extract the block identifier (the first line of the provided config)
echo -e "\nExtracting the vhost block identifier..."
block_identifier=$(head -n 1 "$temp_file")
echo -e "Content of block identifier:\n$block_identifier"

# Check if the vhost configuration exists
echo -e "\nChecking if vhost config exists..."
if grep -qF "$block_identifier" "$NGINX_CONF_DIR/$NGINX_CONF_FILE"; then
  echo -e "Vhost config already exists."

  # Get the existing vhost block that matches the block identifier
  echo -e "\nExtracting existing vhost config..."
  end_pattern="^}"
  existing_block="$(sed -n "/$block_identifier/,/$end_pattern/p" "$NGINX_CONF_DIR/$NGINX_CONF_FILE")"
  echo -e "Content of existing vhost:\n$existing_block"

  # Compare the existing block with the provided configuration
  echo -e "\nComparing existing vhost config with provided vhost config..."
  if diff -q <(echo "$VHOST") <(echo "$existing_block"); then
    echo "Configuration matches. No action needed."
  else
    # Delete the existing vhost configuration and append the provided config
    echo -e "\nDeleting existing vhost config..."
    sed -i "/$block_identifier/,/$end_pattern/d" "$NGINX_CONF_DIR/$NGINX_CONF_FILE"

    echo -e "\nUpdating vhost config..."
    echo -e "\n$VHOST" | sudo tee -a "$NGINX_CONF_DIR/$NGINX_CONF_FILE"
    # echo "$VHOST" | tr "\r" "\n" >> "$NGINX_CONF_DIR/$NGINX_CONF_FILE"
    # echo -e "$VHOST\r" >> "$NGINX_CONF_DIR/$NGINX_CONF_FILE"
    echo "Nginx vhost configuration updated."

    # Test Nginx configuration for syntax errors
    sudo nginx -t

    # Reload Nginx if the configuration is valid
    if [ $? -eq 0 ]; then
      sudo nginx -s reload
      sudo systemctl status nginx
    else
      echo "Nginx configuration is invalid. Not reloading Nginx."
    fi 
  fi
else
  echo "Nginx vhost configuration not found."
  echo "Creating Nginx vhost entry for $APP_URL..."
  echo -e "\n$VHOST" | sudo tee -a "$NGINX_CONF_DIR/$NGINX_CONF_FILE"

  # Test Nginx configuration for syntax errors
  sudo nginx -t

  # Reload Nginx if the configuration is valid
  if [ $? -eq 0 ]; then
    sudo nginx -s reload
    sudo systemctl status nginx
  else
    echo "Nginx configuration is invalid. Not reloading Nginx."
  fi  
fi

# Remove temporary files
echo -e "\nRemove temporary files..."
rm -f "$temp_file"
rm -f "$ngxx"
