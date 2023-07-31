# https://makefiletutorial.com/

SHELL := /bin/bash

# copy .env file based on environment
SRC := $(shell os=$$(uname -s); \
	if [ "$$os" = "Linux" ]; then \
		cp ./ops/.env.prod ./src/.env; \
		cp ./docker-prod.yml ./src/docker-compose.yml; \
	elif [ "$$os" = "Darwin" ]; then \
		cp ./ops/.env.dev ./src/.env; \
		cp ./docker-dev.yml ./src/docker-compose.yml; \
	else \
		exit 0; \
	fi)

# load .env file
include ./src/.env

repo:
	@if [ -d .git ]; then \
		echo -e "\033[31mPlease enter github repo name: \033[0m "; \
		read -r repo; \
		gh repo create dclmict/$$repo --private --source=. --remote=origin; \
		read -p "Do you want to push your code to GitHub? (yes|no): " choice; \
		case "$$choice" in \
			yes|Y|y) \
				echo -e "\033[31m Enter commit message\033[0m"; \
				read -r cm; \
				git add . && git commit -m "$$cm"; \
				git push --set-upstream origin main; \
				;; \
			no|N|n) \
				echo -e "\033[32m Nothing to be done. Thank you...:\033[0m"; \
				exit 0; \
				;; \
			*) \
				echo -e "\033[32m No choice. Exiting script...:\033[0m"; \
				exit 1; \
				;; \
		esac \
	else \
		echo -e "\033[31mPlease enter github repo name: \033[0m "; \
		git init && git add . && git commit -m "DCLM DAM"; \
		read -r repo; \
		gh repo create dclmict/$$repo --private --source=. --remote=origin; \
		read -p "Do you want to push your code to GitHub? (yes|no): " choice; \
		case "$$choice" in \
			yes|Y|y) \
				echo -e "\033[31m Enter commit message\033[0m"; \
				read -r cm; \
				git add . && git commit -m "$$cm"; \
				git push --set-upstream origin main; \
				;; \
			no|N|n) \
				echo -e "\033[32m Nothing to be done. Thank you...:\033[0m"; \
				exit 0; \
				;; \
			*) \
				echo -e "\033[32m No choice. Exiting script...:\033[0m"; \
				exit 1; \
				;; \
		esac \
	fi

git:
	@if git status --porcelain | grep -q '^??'; then \
		echo -e "\033[31mUntracked files found::\033[0m \033[32mPlease enter commit message:\033[0m"; \
		read -r msg1; \
		git add -A; \
		git commit -m "$$msg1"; \
		read -p "Do you want to push your commit to GitHub? (yes|no): " choice; \
		case "$$choice" in \
			yes|Y|y) \
				echo -e "\033[32mPushing commit to GitHub...:\033[0m"; \
				git push; \
				;; \
			no|N|n) \
				echo -e "\033[32m Nothing to be done. Thank you...:\033[0m"; \
				exit 0; \
				;; \
			*) \
				echo -e "\033[32m No choice. Exiting script...:\033[0m"; \
				exit 1; \
				;; \
		esac \
	else \
		echo -e "\033[31mThere are no new files::\033[0m \033[32mPlease enter commit message:\033[0m"; \
		read -r msg2; \
		git commit -am "$$msg2"; \
		read -p "Do you want to push your commit to GitHub? (yes|no): " choice; \
		case "$$choice" in \
			yes|Y|y) \
				echo -e "\033[32mPushing commit to GitHub...:\033[0m"; \
				git push; \
				;; \
			no|N|n) \
				echo -e "\033[32m Nothing to be done. Thank you...:\033[0m"; \
				exit 0; \
				;; \
			*) \
				echo -e "\033[32m No choice. Exiting script...:\033[0m"; \
				exit 1; \
				;; \
		esac \
	fi

build:
	@if docker images | grep -q $(DIN); then \
		echo -e "\033[31mRemoving all dangling images\033[0m image"; \
		echo y | docker image prune --filter="dangling=true"; \
		echo "Building \033[31m$(DIN):$(DIV)\033[0m image"; \
		docker build -t $(DIN):$(DIV) .; \
		docker images | grep $(DIN); \
	else \
		echo -e "Building \033[31m$(DIN):$(DIV)\033[0m image"; \
		docker build -t $(DIN):$(DIV) .; \
		docker images | grep $(DIN); \
	fi

push:
	echo ${DLP} | docker login -u opeoniye --password-stdin
	docker push $(DIN):$(DIV)

up:
	@echo -e "\033[31mStarting container in prod environment...\033[0m"; \
	if [ "$$(uname -s)" = "Linux" ]; then \
		if [ -f ops/.env.prod ]; then \
			cp ./ops/.env.prod ./src/.env; \
			docker pull $(DIN):$(DIV); \
			docker compose -f ./src/docker-compose.yml --env-file ./src/.env up -d; \
		else \
			echo -e "ops/.env.prod not found."; \
			exit 1; \
		fi; \
	elif [ "$$(uname -s)" = "Darwin" ]; then \
		echo -e "\033[31mStarting container in dev environment...\033[0m"; \
		docker compose -f ./src/docker-compose.yml --env-file ./src/.env up -d; \
	else \
		echo -e "Unsupported operating system."; \
		exit 1; \
	fi

down:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env down

start:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env start

stop:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env stop

restart:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env restart

destroy:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env down --volumes

shell:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec $(CN) bash

composer:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec $(CN) composer install

key:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec $(CN) php artisan key:generate

migrate:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec $(CN) php artisan migrate

fresh:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec $(CN) php artisan migrate:fresh

seed:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec $(CN) php artisan db:seed

storage:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec $(CN) php artisan storage:link

db:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec $(CN) php artisan tinker

info:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec $(CN) php artisan --version

ps:
	docker compose -f ./src/docker-compose.yml ps

stats:
	docker compose -f ./src/docker-compose.yml top

log:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env logs -f $(CN)

run:
	@echo -e "\033[31mEnter command to run inside container: \033[0m"; \
	read -r cmd; \
	docker compose -f ./src/docker-compose.yml exec $(CN) bash -c "$$cmd"

new:
	git restore .
	git pull