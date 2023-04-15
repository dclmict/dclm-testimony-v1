include ./src/.env

repo:
	echo "\033[31mEnter app code folder name:\033[0m ";
	read -r code; \
	cd ~/dev/web/dclm/$$code; \
	git init && git add . && git commit -m "DCLM Testimony"; \
	echo "\033[31mEnter Github repo name :\033[0m ";
	read -r repo; \
	gh repo create dclmict/$$repo --public --source=. --remote=origin; \
	git push --set-upstream origin main

git:
	@if git status --porcelain | grep -q '^??'; then \
		echo "\033[31mUntracked files found::\033[0m \033[32mPlease enter commit message:\033[0m"; \
		read -r msg1; \
		git add -A; \
		git commit -m "$$msg1"; \
		read -p "Do you want to push your commit to GitHub? (yes|no): " choice; \
		case "$$choice" in \
			yes|Y|y) \
				echo "\033[32mPushing commit to GitHub...\033[0m"; \
				git push; \
				;; \
			no|N|n) \
				echo "\033[32m Nothing to be done. Thank you...\033[0m"; \
				exit 0; \
				;; \
			*) \
				echo "\033[32m No choice. Exiting script...\033[0m"; \
				exit 1; \
				;; \
		esac \
	else \
		echo "\033[31mThere are no new files::\033[0m \033[32mPlease enter commit message:\033[0m"; \
		read -r msg2; \
		git commit -am "$$msg2"; \
		read -p "Do you want to push your commit to GitHub? (yes|no): " choice; \
		case "$$choice" in \
			yes|Y|y) \
				echo "\033[32mPushing commit to GitHub...\033[0m"; \
				git push; \
				;; \
			no|N|n) \
				echo "\033[32m Nothing to be done. Thank you...\033[0m"; \
				exit 0; \
				;; \
			*) \
				echo "\033[32m No choice. Exiting script...\033[0m"; \
				exit 1; \
				;; \
		esac \
	fi

build:
	@if docker images | grep -q $(DIN):$(DIV); then \
		echo "Removing \033[31m$(DIN):$(DIV)\033[0m image"; \
		echo y | docker image prune --filter="dangling=true"; \
		docker image rm $(DIN):$(DIV); \
		echo "Building \033[31m$(DIN):$(DIV)\033[0m image"; \
		docker build -t $(DIN):$(DIV) .; \
		docker images | grep $(DIN):$(DIV); \
	else \
		echo "Building \033[31m$(DIN):$(DIV)\033[0m image"; \
		docker build -t $(DIN):$(DIV) .; \
		docker images | grep $(DIN):$(DIV); \
	fi

push:
	cat ops/docker/pin | docker login -u opeoniye --password-stdin
	docker push $(DIN):$(DIV)

up:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env up -d

dev:
	cp ./ops/.env.dev ./src/.env
	cp ./docker-dev.yml ./src/docker-compose.yml
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env up -d

prod:
	@if ls /var/docker | grep -q $(DIN):$(DIV); then \
		echo "\033[31mDirectory exists, starting container...\033[0m"; \
		touch ops/.env.prod; \
		echo "\033[32mPaste .env content and save with :wq\033[0m"; \
		vim ops/.env.prod; \
		cp ./ops/.env.prod ./src/.env; \
		cp ./docker-prod.yml ./src/docker-compose.yml; \
		docker pull $(DIN):$(DIV); \
		docker compose -f ./src/docker-compose.yml --env-file ./src/.env up -d; \
	else \
		"\033[31mDirectory not found, setting up project...\033[0m"; \
		mkdir -p /var/docker/dclm-events; \
		cd /var/docker/dclm-events; \
		git clone https://github.com/dclmict/dclm-events.git .; \
		sudo chown -R ubuntu:ubuntu .; \
		touch ops/.env.prod; \
		echo "\033[32mPaste .env content and save with :wq\033[0m"; \
		vim ops/.env.prod; \
		cp ./ops/.env.prod ./src/.env; \
		cp ./docker-prod.yml ./src/docker-compose.yml; \
		docker pull $(DIN):$(DIV); \
		docker compose -f ./src/docker-compose.yml --env-file ./src/.env up -d; \
	fi

down:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env down

start:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env start

stop:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env stop

restart:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env.dev restart

destroy:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env down --volumes

shell:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec testimony-app bash

composer:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec testimony-app composer install

key:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec testimony-app php artisan key:generate

migrate:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec testimony-app php artisan migrate

fresh:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec testimony-app php artisan migrate:fresh

seed:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec testimony-app php artisan db:seed

storage:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec testimony-app php artisan storage:link

db:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec testimony-app php artisan tinker

info:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec testimony-app php artisan --version

log:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env logs -f testimony-app