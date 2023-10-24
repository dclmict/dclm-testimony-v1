# https://makefiletutorial.com/

SHELL := /bin/bash

# copy .env file based on env (auto)
SRC := $(shell os=$$(hostname); \
	if [ "$$os" = "dclm" ]; then \
		cp ./ops/dclm-prod.env ./src/.env; \
	elif [ "$$os" = "dclmict" ]; then \
		cp ./ops/dclm-dev.env ./src/.env; \
	else \
		cp ./ops/bams-dev.env ./src/.env; \
	fi)

# load .env file
include ./src/.env

# copy .env file based on env (prompt)
env: 
	@os=$$(hostname); \
	if [ "$$os" = "dclm" ]; then \
		cp ./ops/dclm-prod.env ./src/.env; \
	elif [ "$$os" = "dclmict" ]; then \
		cp ./ops/dclm-dev.env ./src/.env; \
	else \
		if [[ "$$os" != "dclm" && "$$os" != "dclmict" ]]; then \
			chmod +x ./ops/env-file.sh; \
			./ops/env-file.sh; \
		else \
			cp ./ops/bams-dev.env ./src/.env; \
		fi \
	fi

repo:
	@if [ -d .git ]; then \
		make repo-name; \
	else \
		make repo-init; \
		make repo-name; \
	fi

repo-init:
	@read -p "Do you want to initialise this folder as a git repo? (yes|no): " choice; \
	case "$$choice" in \
		yes|Y|y) \
			echo -e "\033[31m Please enter initial commit message: \033[0m\n"; \
			read -r commitMsg; \
			git init && git add . && git commit -m "$$commitMsg"; \
			;; \
		no|N|n) \
			echo -e "\033[32m Nothing to be done. Thank you...\033[0m\n"; \
			exit 0; \
			;; \
		*) \
			echo -e "\033[32m No choice. Exiting script...\033[0m\n"; \
			exit 1; \
			;; \
	esac

repo-name:
	@read -p "Do you want to create a github repo? (yes|no): " choice; \
	case "$$choice" in \
		yes|Y|y) \
			echo -e "\033[31m Please enter github repo name: \033[0m\n"; \
			read -r repoName; \
			gh repo create dclmict/$$repoName --public --source=. --remote=origin; \
			;; \
		no|N|n) \
			echo -e "\033[32m Nothing to be done. Thank you...\033[0m\n"; \
			exit 0; \
			;; \
		*) \
			echo -e "\033[32m No choice. Exiting script...\033[0m\n"; \
			exit 1; \
			;; \
	esac

git:
	@if git status --porcelain | grep -q "^??"; then \
		make commit-1; \
		make git-push; \
	elif git status --porcelain | grep -qE '[^ADMR]'; then \
		make commit-2; \
		make git-push; \
	elif [ -z "$$(git status --porcelain)" ]; then \
		make git-push; \
	else \
		echo -e "\033[31m Unknown status. Aborting...\033[0m\n"; \
		exit 0; \
	fi

commit-1:
	@echo -e "\033[31mUntracked files found::\033[0m \033[32mPlease enter commit message:\033[0m"; \
	read -r msg1; \
	git add -A; \
	git commit -m "$$msg1"; \

commit-2:
	@echo -e "\033[31mModified files found...\033[0m \033[32mPlease enter commit message:\033[0m"; \
	read -r msg2; \
	git commit -am "$$msg2"

gh-sl:
	@gh secret list

gh-ss: gh-sd
	@read -p "Do you want to set repo secrets? (yes|no): " choice; \
	case "$$choice" in \
		yes|Y|y) \
			echo -e "\033[32m Setting repo secrets...\033[0m\n"; \
			chmod +x ./ops/gh-variable-set.sh; \
			./ops/gh-variable-set.sh; \
			gh secret set -f $(ENV); \
			;; \
		no|N|n) \
			echo -e "\033[32m Nothing to be done. Thank you...\033[0m\n"; \
			exit 0; \
			;; \
		*) \
			echo -e "\033[32m No choice. Exiting script...\033[0m\n"; \
			exit 1; \
			;; \
	esac

gh-sd:
	@read -p "Do you want to delete repo secret? (yes|no): " choice; \
	case "$$choice" in \
		yes|Y|y) \
			echo -e "\033[32m Deleting repo secrets...\033[0m\n"; \
			chmod +x ./ops/gh-secret-delete.sh; \
			./ops/gh-secret-delete.sh $(ENV); \
			;; \
		no|N|n) \
			echo -e "\033[32m Nothing to be done. Thank you...\033[0m\n"; \
			exit 0; \
			;; \
		*) \
			echo -e "\033[32m No choice. Exiting script...\033[0m\n"; \
			exit 1; \
			;; \
	esac

git-push: env gh-ss
	@read -p "Do you want to push your commit to GitHub? (yes|no): " choice; \
	case "$$choice" in \
		yes|Y|y) \
			echo -e "\033[32m Pushing commit to GitHub...\033[0m\n"; \
			git push; \
			;; \
		no|N|n) \
			echo -e "\033[32m Nothing to be done. Thank you...\033[0m\n"; \
			exit 0; \
			;; \
		*) \
			echo -e "\033[32m No choice. Exiting script...\033[0m\n"; \
			exit 1; \
			;; \
	esac

image:
	@if docker images | grep -q $(DIN); then \
		echo -e "\033[31mRemoving all dangling images\033[0m"; \
		echo y | docker image prune --filter="dangling=true"; \
		echo -e "Building \033[31m$(DIN):$(DIV)\033[0m image"; \
		docker build -t $(DIN):$(DIV) -f $(DOCKERFILE) .; \
		docker images | grep $(DIN); \
	else \
		echo -e "\033[32mBuilding $(DIN):$(DIV) image\033[0m"; \
		docker build -t $(DIN):$(DIV) -f $(DOCKERFILE) .; \
		docker images | grep $(DIN); \
	fi

image-push:
	@echo ${DLP} | docker login -u opeoniye --password-stdin
	@docker push $(DIN):$(DIV)

dcgen:
	@echo "Generating docker-compose.yml..."
	@echo "services:" > ./src/docker-compose.yml
	@echo "  $(CN):" >> ./src/docker-compose.yml
	@echo "    container_name: \$${CN}" >> ./src/docker-compose.yml
	@echo "    image: \$${DIN}:\$${DIV}" >> ./src/docker-compose.yml
	@echo "    env_file: .env" >> ./src/docker-compose.yml
	@echo "    ports:" >> ./src/docker-compose.yml
	@echo "      - $(COMPOSE_PORT)" >> ./src/docker-compose.yml
	@echo "    networks:" >> ./src/docker-compose.yml
	@echo "      - $(COMPOSE_NETWORK)" >> ./src/docker-compose.yml
	@echo "    volumes:" >> ./src/docker-compose.yml
	@echo "      - $(CERT):/var/ssl/cert.pem" >> ./src/docker-compose.yml
	@echo "      - $(CERT_KEY):/var/ssl/key.pem" >> ./src/docker-compose.yml
	@echo "    restart: always" >> ./src/docker-compose.yml
	@echo "    working_dir: /var/www" >> ./src/docker-compose.yml
	@echo "networks:" >> ./src/docker-compose.yml
	@echo "  $(COMPOSE_NETWORK):" >> ./src/docker-compose.yml
	@echo "    name: $(COMPOSE_NETWORK)" >> ./src/docker-compose.yml
	@echo "    external: true" >> ./src/docker-compose.yml
	@echo "Docker-compose file generated successfully."

up:
	@make dcgen
	@echo -e "\033[31mStarting container in $(APP_ENV) environment...\033[0m"
	@docker pull $(DIN):$(DIV)
	@docker compose -f $(DCF) --env-file $(ENV) up -d

down:
	@docker compose -f $(DCF) --env-file $(ENV) down

start:
	@docker compose -f $(DCF) --env-file $(ENV) start

restart:
	@docker compose -f $(DCF) --env-file $(ENV) restart

stop:
	@docker compose -f $(DCF) --env-file $(ENV) stop

new:
	@git restore .
	@git pull

sh:
	@docker compose -f $(DCF) --env-file $(ENV) exec -it $(CN) bash

ps:
	@docker compose -f $(DCF) ps

stats:
	@docker compose -f $(DCF) top

log:
	@docker compose -f $(DCF) --env-file $(ENV) logs -f $(CN)

run:
	@echo -e "\033[31mEnter command to run inside container: \033[0m"; \
	read -r cmd; \
	docker compose -f $(DCF) exec $(CN) bash -c "$$cmd"

play:
	@docker run -it --rm --name bams -v "$$(pwd)":/myapp -w /myapp ubuntu:20.04