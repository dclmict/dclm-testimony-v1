# Start app engine
run-app:
	@\
  os=$$(hostname); \
	branch=$$(git rev-parse --abbrev-ref HEAD); \
  if [[ "$$os" = "dclm" && "$$branch" = "release/prod" ]]; then \
		echo -e "Starting container in $(GREEN)$$(hostname)$(RESET) environment..."; \
    make -s compose-dclm-prod; \
		docker pull $(DL_DK_IMAGE); \
		docker compose -f $(COMPOSE_FILE) up -d; \
  elif [[ "$$os" = "dclmict" && "$$branch" = "release/dev" ]]; then \
		echo -e "Starting container in $(GREEN)$$(hostname)$(RESET) environment..."; \
    make -s compose-dclm-dev; \
		docker pull $(DL_DK_IMAGE); \
		docker compose -f $(COMPOSE_FILE) up -d; \
  elif [[ "$$os" != "dclm" && "$$os" != "dclmict" && "$$branch" = "bams" ]]; then \
		echo -e "Starting container in $(GREEN)$$(hostname)$(RESET) environment..."; \
		make -s compose-bams; \
		docker compose -f $(COMPOSE_FILE) up -d; \
	else \
		echo -e "Switch to $(RED_BOLD)bams$(RESET) branch to run"; \
  fi

new:
	@git restore .
	@git pull

down:
	@docker compose -f $(COMPOSE_FILE) down

start:
	@docker compose -f $(COMPOSE_FILE) start

restart:
	@docker compose -f $(COMPOSE_FILE) restart

stop:
	@docker compose -f $(COMPOSE_FILE) stop

ps:
	@docker compose -f $(COMPOSE_FILE) ps

stat:
	@docker compose -f $(COMPOSE_FILE) top

log:
	@docker compose -f $(COMPOSE_FILE) logs -f $(DL_APP_NAME)

sh:
	@docker compose -f $(COMPOSE_FILE) exec -it $(DL_APP_NAME) bash

compose-bams:
	@echo "Generating docker-compose.yml..."
	@echo "services:" > ./src/docker-compose.yml
	@echo "  $(DL_APP_NAME):" >> ./src/docker-compose.yml
	@echo "    container_name: \$${DL_APP_NAME}" >> ./src/docker-compose.yml
	@echo "    image: \$${DL_DK_IMAGE}" >> ./src/docker-compose.yml
	@echo "    env_file: .env" >> ./src/docker-compose.yml
	@echo "    ports:" >> ./src/docker-compose.yml
	@echo "      - $(COMPOSE_PORT)" >> ./src/docker-compose.yml
	@echo "    networks:" >> ./src/docker-compose.yml
	@echo "      - $(COMPOSE_NETWORK)" >> ./src/docker-compose.yml
	@echo "    working_dir: /var/www" >> ./src/docker-compose.yml
	@echo "    restart: unless-stopped" >> ./src/docker-compose.yml
	@echo "    labels:" >> ./src/docker-compose.yml
	@echo "      logging: '"promtail"'" >> ./src/docker-compose.yml
	@echo "      logging_jobname: '"containerlogs"'" >> ./src/docker-compose.yml
	@echo "    storage_opt:" >> ./src/docker-compose.yml
	@echo "      size: 20G" >> ./src/docker-compose.yml
	@echo "    volumes:" >> ./src/docker-compose.yml
	@echo "      - .:/var/www" >> ./src/docker-compose.yml
	@echo "      - $(DL_NGX_CERT):/var/ssl/cert.pem" >> ./src/docker-compose.yml
	@echo "      - $(DL_NGX_KEY):/var/ssl/key.pem" >> ./src/docker-compose.yml
	@echo "networks:" >> ./src/docker-compose.yml
	@echo "  $(COMPOSE_NETWORK):" >> ./src/docker-compose.yml
	@echo "    name: $(COMPOSE_NETWORK)" >> ./src/docker-compose.yml
	@echo "    external: true" >> ./src/docker-compose.yml
	@echo "Docker-compose file generated successfully."

compose-dclm-dev:
	@echo "Generating docker-compose.yml..."
	@echo "services:" > ./src/docker-compose.yml
	@echo "  $(DL_APP_NAME):" >> ./src/docker-compose.yml
	@echo "    container_name: \$${DL_APP_NAME}" >> ./src/docker-compose.yml
	@echo "    image: \$${DL_DK_IMAGE}" >> ./src/docker-compose.yml
	@echo "    env_file: .env" >> ./src/docker-compose.yml
	@echo "    ports:" >> ./src/docker-compose.yml
	@echo "      - $(COMPOSE_PORT)" >> ./src/docker-compose.yml
	@echo "    networks:" >> ./src/docker-compose.yml
	@echo "      - $(COMPOSE_NETWORK)" >> ./src/docker-compose.yml
	@echo "    storage_opt:" >> ./src/docker-compose.yml
	@echo "      size: 20G" >> ./src/docker-compose.yml
	@echo "    volumes:" >> ./src/docker-compose.yml
	@echo "      - $(DL_NGX_CERT):/var/ssl/cert.pem" >> ./src/docker-compose.yml
	@echo "      - $(DL_NGX_KEY):/var/ssl/key.pem" >> ./src/docker-compose.yml
	@echo "    restart: always" >> ./src/docker-compose.yml
	@echo "    working_dir: /var/www" >> ./src/docker-compose.yml
	@echo "networks:" >> ./src/docker-compose.yml
	@echo "  $(COMPOSE_NETWORK):" >> ./src/docker-compose.yml
	@echo "    name: $(COMPOSE_NETWORK)" >> ./src/docker-compose.yml
	@echo "    external: true" >> ./src/docker-compose.yml
	@echo "Docker-compose file generated successfully."

compose-dclm-prod:
	@echo "Generating docker-compose.yml..."
	@echo "services:" > ./src/docker-compose.yml
	@echo "  $(DL_APP_NAME):" >> ./src/docker-compose.yml
	@echo "    container_name: \$${DL_APP_NAME}" >> ./src/docker-compose.yml
	@echo "    image: \$${DL_DK_IMAGE}" >> ./src/docker-compose.yml
	@echo "    env_file: .env" >> ./src/docker-compose.yml
	@echo "    ports:" >> ./src/docker-compose.yml
	@echo "      - $(COMPOSE_PORT)" >> ./src/docker-compose.yml
	@echo "    networks:" >> ./src/docker-compose.yml
	@echo "      - $(COMPOSE_NETWORK)" >> ./src/docker-compose.yml
	@echo "    storage_opt:" >> ./src/docker-compose.yml
	@echo "      size: 20G" >> ./src/docker-compose.yml
	@echo "    volumes:" >> ./src/docker-compose.yml
	@echo "      - $(DL_NGX_CERT):/var/ssl/cert.pem" >> ./src/docker-compose.yml
	@echo "      - $(DL_NGX_KEY):/var/ssl/key.pem" >> ./src/docker-compose.yml
	@echo "    restart: always" >> ./src/docker-compose.yml
	@echo "    working_dir: /var/www" >> ./src/docker-compose.yml
	@echo "networks:" >> ./src/docker-compose.yml
	@echo "  $(COMPOSE_NETWORK):" >> ./src/docker-compose.yml
	@echo "    name: $(COMPOSE_NETWORK)" >> ./src/docker-compose.yml
	@echo "    external: true" >> ./src/docker-compose.yml
	@echo "Docker-compose file generated successfully."